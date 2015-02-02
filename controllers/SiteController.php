<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    private $accessid = "CREATE-HOME";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        //'actions' => ['index'], // Define specific actions
                        'allow' => true, // Has access
                        'matchCallback' => function ($rule, $action) {
                            return \app\models\User::getIsAccessMenu($this->accessid);
                        }
                    ],
                    [
                        'allow' => false, // Do not have access
                        'roles'=>['?'], // Guests '?'
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    protected function validateProject($projectid){
        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();

        $model_project = \app\models\Project::find()->where(['in', 'unitid', $user->accessUnit])
                ->andWhere(['projectid'=>$projectid])
                ->one();

        if ($model_project !== null) {
            return $model_project;
        }

        return null;
    }

    public function actionProjectProcess($projectid){
        $model = $this->validateProject($projectid);
        if ($model == null){
            return null;
        }

        $output = [];
        $output["initiationdate"] = date('d-M-Y', strtotime($model->initiationyear));
        $output["project"] = $model->code . ' - ' . $model->name;
        $output["status"] = $model->status->name;
        $output["projectid"] = $model->projectid;

        $output["proposal"] = "";
        foreach($model->proposal as $proposal){
            $output["proposal"] = ' (Uploaded on: '. date('d-M-Y H:i:s', strtotime($proposal->date)) . ')';
            break;
        }

        $output["costingapproval"] = "";
        foreach($model->costingapprovals as $costingapproval){
            $output["costingapproval"] = ' (Uploaded on: '. date('d-M-Y H:i:s', strtotime($costingapproval->date)). ')';
            break;
        }

        $output["businessassurance"] = "";
        foreach($model->businessassurances as $businessassurance){
            $output["businessassurance"] = ' (Uploaded on: '. date('d-M-Y H:i:s', strtotime($businessassurance->date)). ')';
            break;
        }

        $output["extagreement"] = "";
        foreach($model->extagreements as $extagreement){
            $output["extagreement"] = ' (Number of agreement: '. count($model->extagreements) . ')';
            break;
        }

        $output["intagreement"] = "";
        $i = 0;
        foreach($model->extagreements as $extagreement){
            foreach($extagreement->intagreements as $intagreement){
                $i += count($extagreement->intagreements);
                break;
            }   
        }

        if ($i > 0){
            $output["intagreement"] = ' (Number of agreement: '. $i . ')';
        }

        $output["finalization"] = "";
        $output["finalization_acc"] = "";
        $deliverable = 0;
        $deliverable_pay = 0;
        foreach($model->extagreements as $extagreement){
            foreach($extagreement->extdeliverables as $extdeliverable){
                $deliverable++;
                if (isset($extdeliverable->extagreementpayments) && $extdeliverable->extagreementpayments->date != null && 
                    $extdeliverable->extagreementpayments->date != ""){
                    $deliverable_pay++;
                }
            }
        }

        if ($deliverable == $deliverable_pay && $deliverable > 0){
            $output["finalization_acc"] = "done";
        }else if ($deliverable > 0){
            $output["finalization"] = ' ('.$deliverable_pay. ' of '.$deliverable .' external deliverables have been paid)';
        }

        $output["done"] = "";
        if (count($model->sharingvalueunits) > 0 && count($model->sharingvaluedepartments) > 0 &&
            isset($model->finalizationprojects) && $model->finalizationprojects->filename != null &&
            $model->finalizationprojects->filename != "" && 
            $model->finalizationprojects->remark != null &&
            $model->finalizationprojects->remark != "" &&
            $model->finalizationprojects->intsurveyscore != null &&
            $model->finalizationprojects->intsurveyscore != "" && 
            $model->finalizationprojects->extsurveyscore != null &&
            $model->finalizationprojects->extsurveyscore != ""){
            
            $output["done"] = "done";
        }

        $sql = "select * from ps_projectlog
                where projectid = :1
                order by date desc
            ";
        $output["log"] = "";
        $log = \app\models\ProjectLog::findBySql($sql, [':1'=>$projectid])->one();
        if ($log != null && $log != ""){
            $output["log"] = $log->remark . ', by ' . $log->userin . ' ' . date('d-M-Y', strtotime($log->date));
        }

        echo json_encode($output);
    }

    public function actionProjectAchivement(){
        $output = [];

        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();
        $project_list = \app\models\Project::find()
            ->select(['ps_project.*'])
            ->innerJoin("ps_status", "ps_project.statusid = ps_status.statusid and ps_status.name not like '%cancel%'")
            ->where(['in', 'ps_project.unitid', $user->accessUnit])
            ->all();

        $revenue = 0;
        $cashin = 0;
        $margin = 0;

        foreach($project_list as $project){
            foreach($project->extagreements as $extagreement){
                foreach($extagreement->extdeliverables as $extdeliverable){
                    $revenue += $extdeliverable->rate;

                    if (isset($extdeliverable->extagreementpayments) && $extdeliverable->extagreementpayments->date != null && 
                        $extdeliverable->extagreementpayments->date != ""){
                        $cashin += $extdeliverable->rate;
                    }
                }
            }

            foreach($project->sharingvalueunits as $unit_sharing){
                if (in_array($unit_sharing->unitid, $user->accessUnit)){
                    $margin += $unit_sharing->value - $unit_sharing->cost;
                }
            }
        }

        $output["revenue"] = number_format($revenue);
        $output["cashin"] = number_format($cashin);
        $output["margin"] = number_format($margin);

        echo json_encode($output);
    }

    public function actionProjectDeliverablePayment(){
        $output = [];

        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();
        $project_list = \app\models\Project::find()
            ->select(['ps_project.*'])
            ->innerJoin("ps_status", "ps_project.statusid = ps_status.statusid and ps_status.name not like '%cancel%'")
            ->innerJoin("ps_projectpic", "ps_project.projectid = ps_projectpic.projectid")
            ->where(['in', 'ps_project.unitid', $user->accessUnit])
            ->andWhere('ps_projectpic.userid = :1', [':1' => $user->userid])
            ->orderBy('ps_project.initiationyear')
            ->all();
        
        foreach($project_list as $project){
            $data = new \stdClass();
            $data->project = $project->code .' - '. $project->name;

            $extdeliverables = \app\models\ExtDeliverables::find()
                ->select(['ps_extdeliverables.*'])
                ->leftJoin("ps_extagreement", "ps_extagreement.extagreementid = ps_extdeliverables.extagreementid")
                ->leftJoin("ps_extagreementpayment", "ps_extdeliverables.extdeliverableid = ps_extagreementpayment.extdeliverableid")
            
                ->where('ps_extagreement.projectid  = :1', [':1' => $project->projectid])
                ->andWhere('ps_extdeliverables.duedate is null || ps_extagreementpayment.date is null')
                ->andWhere('date(ps_extdeliverables.duedate) < date(now()) || date(ps_extdeliverables.duedate) between date(now()) and date(DATE_ADD(now(), interval 30 day))')
                ->orderBy('ps_extdeliverables.duedate')
                ->all();

            foreach($extdeliverables as $extdeliverable){
                $arr = new \stdClass();
                if ($extdeliverable->deliverdate == null || $extdeliverable->deliverdate == ""){

                    $arr->deadline = date('d-M-Y', strtotime($extdeliverable->duedate));
                    $date1 = date_create(date('Y-m-d'));
                    $date2 = date_create(date('Y-m-d', strtotime($extdeliverable->duedate)));
                    $diff = date_diff($date2, $date1);
                    $arr->timespan = $diff->format('%R%a days');
                    $arr->descr = $extdeliverable->description;
                    $arr->process = 'Deliver External Agreement';
                    $arr->action = \yii\helpers\Url::toRoute(['ext-agreement-payment/index', 'projectid' => $project->projectid]);

                }else if (!isset($extdeliverable->extagreementpayment) || $extdeliverable->extagreementpayment->date == null || $extdeliverable->extagreementpayment->date == ""){

                    $arr->deadline = date('d-M-Y', strtotime($extdeliverable->duedate));
                    $date1 = date_create(date('Y-m-d'));
                    $date2 = date_create(date('Y-m-d', strtotime($extdeliverable->duedate)));
                    $diff = date_diff($date2, $date1);
                    $arr->timespan = $diff->format('%R%a days');
                    $arr->descr = $extdeliverable->description;
                    $arr->process = 'External Agreement Payment';
                    $arr->action = \yii\helpers\Url::toRoute(['ext-agreement-payment/index', 'projectid' => $project->projectid]);

                }
                $data->deliverable[] = $arr;
            }

            $intdeliverables = \app\models\IntDeliverables::find()
                ->select(['ps_intdeliverables.*'])
                ->leftJoin("ps_intagreement", "ps_intagreement.intagreementid = ps_intdeliverables.intagreementid")
                ->leftJoin("ps_extagreement", "ps_extagreement.extagreementid = ps_intagreement.extagreementid")
                ->leftJoin("ps_intagreementpayment", "ps_intagreementpayment.intdeliverableid = ps_intdeliverables.intdeliverableid")
            
                ->where('ps_extagreement.projectid  = :1', [':1' => $project->projectid])
                ->andWhere('ps_intdeliverables.duedate is null || ps_intagreementpayment.date is null')
                ->andWhere('date(ps_intdeliverables.duedate) < date(now()) || date(ps_intdeliverables.duedate) between date(now()) and date(DATE_ADD(now(), interval 30 day))')
                ->orderBy('ps_intdeliverables.duedate')
                ->all();
            
            foreach($intdeliverables as $intdeliverable){
                $arr = new \stdClass();
                if ($intdeliverable->deliverdate == null || $intdeliverable->deliverdate == ""){

                    $arr->deadline = date('d-M-Y', strtotime($intdeliverable->duedate));
                    $date1 = date_create(date('Y-m-d'));
                    $date2 = date_create(date('Y-m-d', strtotime($intdeliverable->duedate)));
                    $diff = date_diff($date2, $date1);
                    $arr->timespan = $diff->format('%R%a days');
                    $arr->descr = $intdeliverable->description;
                    $arr->process = 'Deliver Internal Agreement';
                    $arr->action = \yii\helpers\Url::toRoute(['int-agreement-payment/index', 'projectid' => $project->projectid]);

                }else if (!isset($intdeliverable->intagreementpayment) || $intdeliverable->intagreementpayment->date == null || $intdeliverable->intagreementpayment->date == ""){

                    $arr->deadline = date('d-M-Y', strtotime($intdeliverable->duedate));
                    $date1 = date_create(date('Y-m-d'));
                    $date2 = date_create(date('Y-m-d', strtotime($intdeliverable->duedate)));
                    $diff = date_diff($date2, $date1);
                    $arr->timespan = $diff->format('%R%a days');
                    $arr->descr = $intdeliverable->description;
                    $arr->process = 'Internal Agreement Payment';
                    $arr->action = \yii\helpers\Url::toRoute(['int-agreement-payment/index', 'projectid' => $project->projectid]);

                }
                $data->deliverable[] = $arr;
            }

            $output[] = $data;
        }

        echo json_encode($output);
    }
}

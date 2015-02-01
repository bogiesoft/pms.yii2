<?php

namespace app\controllers;

use Yii;
use app\models\IntAgreementPayment;
use app\models\Project;
use app\models\IntAgreementPaymentSearch;
use app\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * IntAgreementPaymentController implements the CRUD actions for IntAgreementPayment model.
 */
class IntAgreementPaymentController extends Controller
{
    private $accessid = "MONITOR-IAGREEMENT";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['login', 'error'], // Define specific actions
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
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all IntAgreementPayment models.
     * @return mixed
     */
    public function actionIndex($projectid = 0)
    {
        if($projectid == 0){
            $searchModel = new ProjectSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('project-index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{            
            $this->validateProject($projectid);

            $searchModel = new IntAgreementPaymentSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $projectid);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);   
        }
    }

    /**
     * Displays a single IntAgreementPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $projectid)
    {
        $this->validateProject($projectid);
        $model = $this->findModel($id, $projectid);

        if (Yii::$app->request->post('hasEditable')){
            $out = Json::encode(['output'=>'', 'message'=>'']);
            if (isset($_POST["IntDeliverables"]["intdeliverableid"])){
                $id = $_POST["IntDeliverables"]["intdeliverableid"];
                $model->userup = Yii::$app->user->identity->username;
                $model->dateup = new \yii\db\Expression('NOW()');

                if ($model->load(Yii::$app->request->post())){
                    if ($model->deliverdate == null || $model->deliverdate == ""){
                        $out = Json::encode(['output'=>'', 'message'=>'Deliverable date cannot be blank.']);   
                    }else{
                        $model->deliverdate = date('Y-m-d', strtotime($model->deliverdate));
                        if ($model->save()){
                            $output = date('d-M-Y', strtotime($model->deliverdate));
                            $out = Json::encode(['output'=>$output, 'message'=>'']);
                        }else{
                            $out = Json::encode(['output'=>'', 'message'=>'An error occurred while saving.']);
                        }
                    }
                }
            }

            if (isset($_POST["IntAgreementPayment"])){
                $remark = null;
                $date = null;
                if (isset($_POST["IntAgreementPayment"]["date"])){
                    $date = $_POST["IntAgreementPayment"]["date"];
                    $date = date('Y-m-d', strtotime($date));
                }
                if (isset($_POST["IntAgreementPayment"]["remark"])){
                    $remark = $_POST["IntAgreementPayment"]["remark"];
                }

                $model_payment = IntAgreementPayment::find()->where('intdeliverableid = :1', [':1'=>$id])->one();
                if ($model_payment == null){
                    $model_payment = new IntAgreementPayment();
                    $model_payment->date = $date;
                    $model_payment->remark = $remark;
                    $model_payment->intdeliverableid = $model->intdeliverableid;
                    $model_payment->userin = Yii::$app->user->identity->username;
                    $model_payment->datein = new \yii\db\Expression('NOW()');
                }else{
                    $model_payment->date = $date;
                    $model_payment->remark = $remark;
                    $model_payment->userup = Yii::$app->user->identity->username;
                    $model_payment->dateup = new \yii\db\Expression('NOW()');
                }

                if ($model_payment->save()){
                    $output = date('d-M-Y', strtotime($model_payment->date));
                    $out = Json::encode(['output'=>$output, 'message'=>'']);
                }else{
                    $out = Json::encode(['output'=>'', 'message'=>'An error occurred while saving.']);
                }

            }
            echo $out;
        }else{
            $model_payment = $model->intagreementpayments;
            if ($model_payment == null){
                $model_payment = new IntAgreementPayment();
            }else{
                $model_payment->date = date('d-M-Y', strtotime($model_payment->date));
            }
            return $this->render('view', [
                'model' => $model,
                'model_payment' => $model_payment,
            ]);   
        }
    }

    public function actionCancelDeliver($id, $projectid)
    {
        $model = $this->findModel($id, $projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        $model->deliverdate = null;
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        $model->save();
        return $this->redirect(['view', 'id'=>$id, 'projectid'=>$projectid]);
    }

    public function actionCancelPayment($id, $projectid)
    {
        $model = $this->findPayment($id, $projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        $model->delete();
        return $this->redirect(['view', 'id'=>$model->intdeliverableid, 'projectid'=>$projectid]);
    }

    /**
     * Finds the IntAgreementPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IntAgreementPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $projectid)
    {
        if (($model = \app\models\IntDeliverables::findOne($id)) !== null && 
            $model->intagreement->extagreement->projectid == $projectid) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPayment($id, $projectid)
    {
        if (($model = \app\models\IntAgreementPayment::findOne($id)) !== null &&
            $model->intdeliverable->intagreement->extagreement->projectid == $projectid) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function validateProject($projectid){
        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();

        $model_project = Project::find()->where(['in', 'unitid', $user->accessUnit])
                ->andWhere(['projectid'=>$projectid])
                ->one();

        if ($model_project !== null) {
            return $model_project;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function validateCancelProject($projectid){
        $project = \app\models\Project::findOne($projectid);
        if (strpos(strtolower($project->status->name), 'cancel') !== false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

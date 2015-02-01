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

        if (Yii::$app->request->post('hasEditable')){
            $out = Json::encode(['output'=>'', 'message'=>'']);
            if (isset($_POST["IntDeliverables"]["intdeliverableid"])){
                $id = $_POST["IntDeliverables"]["intdeliverableid"];
                $model = $this->findModel($id, $projectid);
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
            echo $out;
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id, $projectid),
            ]);   
        }
    }

    /**
     * Creates a new IntAgreementPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $projectid)
    {
        $model = new IntAgreementPayment();
        $model->intdeliverableid = $id;
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date('Y-m-d', strtotime($model->date));
            if (!$model->save()){
                $model->date = date('d-M-Y', strtotime($model->date));
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            return $this->redirect(['view', 'id' => $model->intdeliverableid, 'projectid' => $projectid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing IntAgreementPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $projectid, $paymentid)
    {
        $model = $this->findPayment($paymentid, $projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        if ($id != $model->intdeliverableid){
            return $this->redirect(['index', 'id' => $id, 'projectid' => $projectid]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date('Y-m-d', strtotime($model->date));
            if (!$model->save()){
                $model->date = date('d-M-Y', strtotime($model->date));
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            return $this->redirect(['view', 'id' => $model->intdeliverableid, 'projectid' => $projectid]);
        } else {
            $model->date = date('d-M-Y', strtotime($model->date));
            return $this->render('update', [
                'model' => $model,
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

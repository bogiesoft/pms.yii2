<?php

namespace app\controllers;

use Yii;
use app\models\ExtDeliverables;
use app\models\ExtAgreementPayment;
use app\models\Project;
use app\models\ExtAgreementPaymentSearch;
use app\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * ExtAgreementPaymentController implements the CRUD actions for ExtAgreementPayment model.
 */
class ExtAgreementPaymentController extends Controller
{
    private $accessid = "MONITOR-EAGREEMENT";

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
     * Lists all ExtAgreementPayment models.
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
            $searchModel = new ExtAgreementPaymentSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $projectid);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ExtAgreementPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $projectid)
    {
        if (Yii::$app->request->post('hasEditable')){
            $out = Json::encode(['output'=>'', 'message'=>'']);
            if (isset($_POST["ExtDeliverables"]["extdeliverableid"])){
                $id = $_POST["ExtDeliverables"]["extdeliverableid"];
                $model = $this->findModel($id);
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
                'model' => $this->findModel($id),
            ]);   
        }
    }

    /**
     * Creates a new ExtAgreementPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $projectid)
    {
        $model = new ExtAgreementPayment();
        $model->extdeliverableid = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date('Y-m-d', strtotime($model->date));
            if (!$model->save()){
                $model->date = date('d-M-Y', strtotime($model->date));
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            $model_project = new Project();
            $model_project = Project::findOne($projectid);                
            $model_project->setProjectStatus();

            return $this->redirect(['view', 'id' => $model->extdeliverableid, 'projectid' => $projectid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ExtAgreementPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $projectid, $paymentid)
    {
        $model = $this->findPayment($paymentid);
        if ($id != $model->extdeliverableid){
            return $this->redirect(['index', 'id' => $model->extdeliverableid, 'projectid' => $projectid]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date('Y-m-d', strtotime($model->date));
            if (!$model->save()){
                $model->date = date('d-M-Y', strtotime($model->date));
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            $model_project = new Project();
            $model_project = Project::findOne($projectid);                
            $model_project->setProjectStatus();

            return $this->redirect(['view', 'id' => $model->extdeliverableid, 'projectid' => $projectid]);
        } else {
            $model->date = date('d-M-Y', strtotime($model->date));
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the ExtAgreementPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExtAgreementPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExtDeliverables::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPayment($id)
    {
        if (($model = ExtAgreementPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancelDeliver($id, $projectid)
    {
        $model = $this->findModel($id);
        $model->deliverdate = null;
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        $model->save();
        return $this->redirect(['view', 'id'=>$id, 'projectid'=>$projectid]);
    }

    public function actionCancelPayment($id, $projectid)
    {
        $model = $this->findPayment($id);
        $model->delete();
        
        $model_project = new Project();
        $model_project = Project::findOne($projectid);                
        $model_project->setProjectStatus();

        return $this->redirect(['view', 'id'=>$model->extdeliverableid, 'projectid'=>$projectid]);
    }
}

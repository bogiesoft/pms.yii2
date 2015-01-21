<?php

namespace app\controllers;

use Yii;
use app\models\ExtAgreement;
use app\models\Project;
use app\models\ExtAgreementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\data\ActiveDataProvider;

use yii\helpers\ArrayHelper;
use app\models\ExtDeliverables;
use app\models\ProjectSearch;
use yii\filters\AccessControl;

/**
 * ExtAgreementController implements the CRUD actions for ExtAgreement model.
 */
class ExtAgreementController extends Controller
{
    private $accessid = "CREATE-EAGREEMENT";

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
     * Lists all ExtAgreement models.
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
        }
        else {
            $searchModel = new ExtAgreementSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $projectid);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ExtAgreement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExtAgreement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($projectid = 0)
    {
        $model = new ExtAgreement();
        $model->projectid = $projectid;
        $model->setscenario('insert');

        //initial user change & date
        $model->userin = Yii::$app->user->identity->username;
        $model->datein = new \yii\db\Expression('NOW()');
        $model_extdeliverables = null;

        if ($model->load(Yii::$app->request->post())) {

            $flag = true;

            if ($model->file == null && $model->file == ""){
                $flag = false;
            }

            $date = explode(' - ',$model->startdate);
            if (isset($date[0])){
                $model->startdate = date("Y-m-d", strtotime($date[0]));   
            }
            if (isset($date[1])){
                $model->enddate = date("Y-m-d", strtotime($date[1]));   
            }

            if (isset($_POST["ExtDeliverables"])){
                foreach($_POST["ExtDeliverables"] as $extDev){
                    $modelExtDev = new ExtDeliverables();
                    
                    if (isset($extDev["code"]) && $extDev["code"] != ""){
                        $modelExtDev->code = $extDev["code"];   
                    }
                    if (isset($extDev["description"]) && $extDev["description"] != ""){
                        $modelExtDev->description = $extDev["description"];   
                    }
                    if (isset($extDev["rate"]) && $extDev["rate"] != ""){
                        $modelExtDev->rate = $extDev["rate"];   
                    }
                    if (isset($extDev["duedate"]) && $extDev["duedate"] != ""){
                        $modelExtDev->duedate = $extDev["duedate"];   
                    }
                    $model_extdeliverables[] = $modelExtDev;
                }
            }else{
                $extDev = new ExtDeliverables();
                $extDev->validate();
                $model_extdeliverables[] = $extDev;
                $flag = false;
            }

            if (!$flag){
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                return $this->render('create', [
                    'model' => $model,
                    'model_extdeliverables'=> $model_extdeliverables,
                ]);
            }

            $file1 = UploadedFile::getInstance($model, 'file');
            
            date_default_timezone_set('Asia/Jakarta');
            
            $model->filename = str_replace('/', '.', $model->project->code).'_'.date('d.M.Y').'_'.date('His').'_'.'ExtAgreement'. '.' . $file1->extension;
            $model->filename = strtoupper($model->filename);
            $model->file = $file1;            

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollBack();
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                return $this->render('create', [
                    'model' => $model,
                    'model_extdeliverables'=> $model_extdeliverables,
                ]); 
            }

            foreach($model_extdeliverables as $extDev){
                $extDev->extagreementid = $model->extagreementid;
                $extDev->userin = Yii::$app->user->identity->username;
                $extDev->datein = new \yii\db\Expression('NOW()');
                $extDev->duedate = date("Y-m-d", strtotime($extDev->duedate));

                if (!$extDev->save()){
                    $extDev->duedate = date("d.M.Y", strtotime($extDev->duedate));

                    $transaction->rollBack();
                    $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                    return $this->render('create', [
                        'model' => $model,
                        'model_extdeliverables'=> $model_extdeliverables,
                    ]);  
                }

                $extDev->duedate = date("d.M.Y", strtotime($extDev->duedate));
            }

            $model_project = new Project();
            $model_project = Project::findOne($projectid);                
            $model_project->setProjectStatus();

            $model->file->saveAs('uploads/' . $model->filename); 

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->extagreementid, 'projectid' => $projectid]);
    
        }else{
            return $this->render('create', [
                'model' => $model,
                'model_extdeliverables'=> $model_extdeliverables,
            ]);    
        }
        

        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->extagreementid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * Updates an existing ExtAgreement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($projectid, $id)
    {
        $model = $this->findModel($id);
        //$model->setscenario('update'); 

        if ($model->projectid != $projectid){
            return $this->redirect(['index', 'projectid' => $projectid]);
        }

        //initial user change & date
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        $model_extdeliverables = null;

        if ($model->load(Yii::$app->request->post())) {
            
            $flag = true;

            if ($model->file == null && $model->file == "" && $model->filename == ""){
                $flag = false;
            }

            $date = explode(' - ',$model->startdate);
            if (isset($date[0])){
                $model->startdate = date("Y-m-d", strtotime($date[0]));   
            }
            if (isset($date[1])){
                $model->enddate = date("Y-m-d", strtotime($date[1]));   
            }

            if (isset($_POST["ExtDeliverables"])){
                foreach($_POST["ExtDeliverables"] as $extDev){
                    $modelExtDev = new ExtDeliverables();
                    
                    if (isset($extDev["extdeliverableid"]) && $extDev["extdeliverableid"] != ""){
                        $modelExtDev->extdeliverableid = $extDev["extdeliverableid"];   
                    }
                    if (isset($extDev["code"]) && $extDev["code"] != ""){
                        $modelExtDev->code = $extDev["code"];   
                    }
                    if (isset($extDev["description"]) && $extDev["description"] != ""){
                        $modelExtDev->description = $extDev["description"];   
                    }
                    if (isset($extDev["rate"]) && $extDev["rate"] != ""){
                        $modelExtDev->rate = $extDev["rate"];   
                        $modelExtDev->rate = str_replace('.','',$modelExtDev->rate);
                    }
                    if (isset($extDev["duedate"]) && $extDev["duedate"] != ""){
                        $modelExtDev->duedate = $extDev["duedate"];   
                    }
                    $model_extdeliverables[] = $modelExtDev;
                }
            }else{
                $extDev = new ExtDeliverables();
                $extDev->validate();
                $model_extdeliverables[] = $extDev;
                $flag = false;
            }

            if (!$flag){
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                return $this->render('update', [
                    'model' => $model,
                    'model_extdeliverables'=> $model_extdeliverables,
                ]);
            }

            $file1 = UploadedFile::getInstance($model, 'file');            
            date_default_timezone_set('Asia/Jakarta');

            if ($file1 != null)
            {
                $model->filename = str_replace('/', '.', $model->project->code).'_'.date('d.M.Y').'_'.date('His').'_'.'ExtAgreement'. '.' . $file1->extension;
                $model->filename = strtoupper($model->filename);
                $model->file = $file1;    
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollBack();
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                return $this->render('update', [
                    'model' => $model,
                    'model_extdeliverables'=> $model_extdeliverables,
                ]); 
            }

            foreach($model_extdeliverables as $extDev){
                if (isset($extDev->extdeliverableid) && $extDev->extdeliverableid != null && $extDev->extdeliverableid != ""){     
                    
                    $model_dev = ExtDeliverables::findOne($extDev->extdeliverableid);
                    $model_dev->userup = Yii::$app->user->identity->username;
                    $model_dev->dateup = new \yii\db\Expression('NOW()');
                    $model_dev->extagreementid = $model->extagreementid;
                    $model_dev->code = $extDev->code;
                    $model_dev->description = $extDev->description;
                    $model_dev->rate = $extDev->rate;
                    $model_dev->duedate = date("Y-m-d", strtotime($extDev->duedate));

                    if (!$model_dev->save()){
                        $transaction->rollBack();
                        $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                        return $this->render('update', [
                            'model' => $model,
                            'model_extdeliverables'=> $model_extdeliverables,
                        ]);  
                    }

                }else {
                    $extDev->extagreementid = $model->extagreementid;
                    $extDev->userin = Yii::$app->user->identity->username;
                    $extDev->datein = new \yii\db\Expression('NOW()');
                    $extDev->duedate = date("Y-m-d", strtotime($extDev->duedate));

                    if (!$extDev->save()){
                        $extDev->duedate = date("d.M.Y", strtotime($extDev->duedate));

                        $transaction->rollBack();
                        $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                        return $this->render('update', [
                            'model' => $model,
                            'model_extdeliverables'=> $model_extdeliverables,
                        ]);  
                    }

                    $extDev->duedate = date("d.M.Y", strtotime($extDev->duedate));
                }
            }

            $model_project = new Project();
            $model_project = Project::findOne($projectid);                
            $model_project->setProjectStatus();

            if ($model->file != null && $model->file != "")
            {
                $model->file->saveAs('uploads/' . $model->filename); 
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->extagreementid, 'projectid' => $projectid]);

        } else {
            $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));

            $modelExtDev = ExtDeliverables::find()->where('extagreementid = :1', [':1'=>$model->extagreementid])->all();
            foreach($modelExtDev as $extDev){                
                $extDev->duedate = date('d.M.Y', strtotime($extDev->duedate));
                $model_extdeliverables[] = $extDev;
            }

            return $this->render('update', [
                'model' => $model,
                'model_extdeliverables'=> $model_extdeliverables,
            ]);
        }
    }

    /**
     * Deletes an existing ExtAgreement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $model_project = new Project();
        $model_project = Project::findOne($projectid);                

        $model_project->statusid = 5;
        $model_project->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExtAgreement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExtAgreement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExtAgreement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd($index){
        $model = new ExtDeliverables();

        return $this->renderAjax('ext-deliverables/_form', [
                'model'=>$model,
                'index'=>$index,
            ]);
    }
}

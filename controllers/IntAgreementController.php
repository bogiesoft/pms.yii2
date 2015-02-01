<?php

namespace app\controllers;

use Yii;
use app\models\IntAgreement;
use app\models\Project;
use app\models\IntAgreementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use yii\helpers\ArrayHelper;
use app\models\IntDeliverables;

use app\models\ProjectSearch;
use app\models\ExtAgreementSearch;
use yii\filters\AccessControl;

/**
 * IntAgreementController implements the CRUD actions for IntAgreement model.
 */
class IntAgreementController extends Controller
{
    private $accessid = "CREATE-IAGREEMENT";

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
     * Lists all IntAgreement models.
     * @return mixed
     */
    public function actionIndex($extagreementid = 0)
    {
        if($extagreementid == 0){
            //$searchModel = new ProjectSearch();
            $searchModel = new ExtAgreementSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('extagreement-index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else {
            $this->validateProject($extagreementid);
            $searchModel = new IntAgreementSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $extagreementid);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }        
    }

    /**
     * Displays a single IntAgreement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $extagreementid)
    {
        $this->validateProject($extagreementid);
        return $this->render('view', [
            'model' => $this->findModel($id, $extagreementid),
        ]);
    }

    /**
     * Creates a new IntAgreement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($extagreementid = 0)
    {
        $model = new IntAgreement();
        $model->extagreementid = $extagreementid;
        $this->validateProject($extagreementid);
        $this->validateCancelProject($extagreementid);
        $model->setscenario('insert');

        //initial user change & date
        $model->userin = Yii::$app->user->identity->username;
        $model->datein = new \yii\db\Expression('NOW()');
        $model_intdeliverables = null;

        if ($model->load(Yii::$app->request->post())) {

            $flag = true;

            $file1 = UploadedFile::getInstance($model, 'file');
            if ($file1 == null){
                $flag = false;
            }

            $model->signdate = date("Y-m-d", strtotime($model->signdate));
            $date = explode(' - ',$model->startdate);
            if (isset($date[0])){
                $model->startdate = date("Y-m-d", strtotime($date[0]));   
            }
            if (isset($date[1])){
                $model->enddate = date("Y-m-d", strtotime($date[1]));   
            }

            if (isset($_POST["IntDeliverables"])){
                foreach($_POST["IntDeliverables"] as $deliverable){
                    $model_deliverable = new IntDeliverables();
                    
                    if (isset($deliverable["extdeliverableid"]) && $deliverable["extdeliverableid"] != ""){
                        $model_deliverable->extdeliverableid = $deliverable["extdeliverableid"];   
                    }
                    if (isset($deliverable["positionid"]) && $deliverable["positionid"] != ""){
                        $model_deliverable->positionid = $deliverable["positionid"];   
                    }
                    if (isset($deliverable["description"]) && $deliverable["description"] != ""){
                        $model_deliverable->description = $deliverable["description"];   
                    }
                    if (isset($deliverable["frequency"]) && $deliverable["frequency"] != ""){
                        $model_deliverable->frequency = $deliverable["frequency"];   
                    }
                    if (isset($deliverable["rateid"]) && $deliverable["rateid"] != ""){
                        $model_deliverable->rateid = $deliverable["rateid"];   
                    }
                    if (isset($deliverable["duedate"]) && $deliverable["duedate"] != ""){
                        $model_deliverable->duedate = $deliverable["duedate"];   
                    }
                    $model_intdeliverables[] = $model_deliverable;
                }
            }else{
                $deliverable = new IntDeliverables();
                $deliverable->rate = 0;
                $deliverable->validate();
                $model_intdeliverables[] = $deliverable;
                $flag = false;
            }

            if (!$flag){
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                $model->signdate = date("d.M.Y", strtotime($model->signdate));
                return $this->render('create', [
                    'model' => $model,
                    'model_intdeliverables'=> $model_intdeliverables,
                ]);
            }
            
            date_default_timezone_set('Asia/Jakarta');
            
            $model->filename = str_replace('/', '.', $model->extagreement->project->code).'_'.date('d.M.Y').'_'.date('His').'_'.'IntAgreement'. '.' . $file1->extension;
            $model->filename = strtoupper($model->filename);
            $model->file = $file1;

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollBack();
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));
                $model->signdate = date("d.M.Y", strtotime($model->signdate));
                return $this->render('create', [
                    'model' => $model,
                    'model_intdeliverables'=> $model_intdeliverables,
                ]); 
            }

            foreach($model_intdeliverables as $deliverable){
                $deliverable->intagreementid = $model->intagreementid;
                $deliverable->rate = $deliverable->projectrate->rate * $deliverable->frequency;
                $deliverable->userin = Yii::$app->user->identity->username;
                $deliverable->datein = new \yii\db\Expression('NOW()');
                $deliverable->duedate = date("Y-m-d", strtotime($deliverable->duedate));

                if (!$deliverable->save()){
                    $deliverable->duedate = date("d.M.Y", strtotime($deliverable->duedate));

                    $transaction->rollBack();
                    $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));
                    $model->signdate = date("d.M.Y", strtotime($model->signdate));
                               
                    return $this->render('create', [
                        'model' => $model,
                        'model_intdeliverables'=> $model_intdeliverables,
                    ]);  
                }

                $deliverable->duedate = date("d.M.Y", strtotime($deliverable->duedate));
            }

            $model->file->saveAs('uploads/' . $model->filename); 

            $model_project = new Project();
            $model_project = Project::findOne($model->extagreement->project->projectid);                
            $model_project->setProjectStatus();

            $model->file->saveAs('uploads/' . $model->filename); 

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->intagreementid, 'extagreementid'=>$model->intagreementid]);
             
        } else{
            return $this->render('create', [
                'model' => $model,
                'model_intdeliverables' => $model_intdeliverables,
            ]);
        }
    }

    /**
     * Updates an existing IntAgreement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $extagreementid)
    {
        $model = $this->findModel($id, $extagreementid);

        if ($model->extagreementid != $extagreementid){
            return $this->redirect(['index', 'extagreementid' => $extagreementid]);
        }

        $this->validateProject($extagreementid);
        $this->validateCancelProject($extagreementid);

        //initial user change & date
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        $model_intdeliverables = null;

        if ($model->load(Yii::$app->request->post())) {

            $arrDeliverableId = null;
            $flag = true;
            
            $file1 = UploadedFile::getInstance($model, 'file');

            if ($file1 == null && $model->filename == ""){
                $flag = false;
            }
            
            $model->signdate = date("Y-m-d", strtotime($model->signdate));
            $date = explode(' - ',$model->startdate);
            if (isset($date[0])){
                $model->startdate = date("Y-m-d", strtotime($date[0]));   
            }
            if (isset($date[1])){
                $model->enddate = date("Y-m-d", strtotime($date[1]));   
            }

            if (isset($_POST["IntDeliverables"])){
                foreach($_POST["IntDeliverables"] as $deliverable){
                    $model_deliverable = new IntDeliverables();
                    if (isset($deliverable["intdeliverableid"]) && $deliverable["intdeliverableid"] != ""){
                        $model_deliverable->intdeliverableid = $deliverable["intdeliverableid"];   
                    }
                    if (isset($deliverable["extdeliverableid"]) && $deliverable["extdeliverableid"] != ""){
                        $model_deliverable->extdeliverableid = $deliverable["extdeliverableid"];   
                    }
                    if (isset($deliverable["positionid"]) && $deliverable["positionid"] != ""){
                        $model_deliverable->positionid = $deliverable["positionid"];   
                    }
                    if (isset($deliverable["description"]) && $deliverable["description"] != ""){
                        $model_deliverable->description = $deliverable["description"];   
                    }
                    if (isset($deliverable["frequency"]) && $deliverable["frequency"] != ""){
                        $model_deliverable->frequency = $deliverable["frequency"];   
                    }
                    if (isset($deliverable["rateid"]) && $deliverable["rateid"] != ""){
                        $model_deliverable->rateid = $deliverable["rateid"];   
                    }
                    if (isset($deliverable["duedate"]) && $deliverable["duedate"] != ""){
                        $model_deliverable->duedate = $deliverable["duedate"];   
                    }
                    $model_intdeliverables[] = $model_deliverable;
                }
            }else{
                $deliverable = new IntDeliverables();
                $deliverable->rate = 0;
                $deliverable->validate();
                $model_intdeliverables[] = $deliverable;
                $flag = false;
            }

            if (!$flag){
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                $model->signdate = date("d.M.Y", strtotime($model->signdate));
                return $this->render('update', [
                    'model' => $model,
                    'model_intdeliverables'=> $model_intdeliverables,
                ]);
            }

            date_default_timezone_set('Asia/Jakarta');

            if ($file1 != null)
            {
                $model->filename = str_replace('/', '.', $model->extagreement->project->code).'_'.date('d.M.Y').'_'.date('His').'_'.'IntAgreement'. '.' . $file1->extension;
                $model->filename = strtoupper($model->filename);
                $model->file = $file1;
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollBack();
                $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));           
                $model->signdate = date("d.M.Y", strtotime($model->signdate));
                return $this->render('update', [
                    'model' => $model,
                    'model_intdeliverables'=> $model_intdeliverables,
                ]); 
            }

            foreach($model_intdeliverables as $deliverable){
                if (isset($deliverable->intdeliverableid) && $deliverable->intdeliverableid != null && $deliverable->intdeliverableid != "")
                {         
                    $model_deliverable = IntDeliverables::findOne($deliverable->intdeliverableid);
                    $model_deliverable->userup = Yii::$app->user->identity->username;
                    $model_deliverable->dateup = new \yii\db\Expression('NOW()');
                    $model_deliverable->intagreementid = $model->intagreementid;

                    $model_deliverable->extdeliverableid = $deliverable->extdeliverableid;
                    $model_deliverable->positionid = $deliverable->positionid;
                    $model_deliverable->description = $deliverable->description;
                    $model_deliverable->frequency = $deliverable->frequency;
                    $model_deliverable->rateid = $deliverable->rateid;
                    $model_deliverable->rate = $deliverable->projectrate->rate * $deliverable->frequency;
                    $model_deliverable->duedate = date("Y-m-d", strtotime($deliverable->duedate));
                    

                    if (!$model_deliverable->save()){
                        $transaction->rollBack();
                        $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));
                        $model->signdate = date("d.M.Y", strtotime($model->signdate));           
                        return $this->render('update', [
                            'model' => $model,
                            'model_extdeliverables'=> $model_extdeliverables,
                        ]);  
                    }

                }else {
                    $deliverable->intagreementid = $model->intagreementid;
                    $deliverable->rate = $deliverable->projectrate->rate * $deliverable->frequency;
                    $deliverable->userin = Yii::$app->user->identity->username;
                    $deliverable->datein = new \yii\db\Expression('NOW()');
                    $deliverable->duedate = date("Y-m-d", strtotime($deliverable->duedate));

                    if (!$deliverable->save()){
                        $deliverable->duedate = date("d.M.Y", strtotime($deliverable->duedate));

                        $transaction->rollBack();
                        $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));
                        $model->signdate = date("d.M.Y", strtotime($model->signdate));           
                        return $this->render('update', [
                            'model' => $model,
                            'model_intdeliverables'=> $model_intdeliverables,
                        ]);  
                    }

                    $deliverable->duedate = date("d.M.Y", strtotime($deliverable->duedate));
                }
            }

            $model_project = new Project();
            $model_project = Project::findOne($model->extagreement->project->projectid);                
            $model_project->setProjectStatus();

            if ($model->file != null && $model->file != "")
            {
                $model->file->saveAs('uploads/' . $model->filename); 
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->intagreementid, 'extagreementid'=>$model->intagreementid]);

        } else {
            $model->startdate = date('d.M.Y', strtotime($model->startdate)) . ' - ' . date('d.M.Y', strtotime($model->enddate));
            $model->signdate = date("d.M.Y", strtotime($model->signdate));

            $modelDeliverable = IntDeliverables::find()->where('intagreementid = :1', [':1'=>$model->intagreementid])->all();
            foreach($modelDeliverable as $deliverable){                
                $deliverable->duedate = date('d.M.Y', strtotime($deliverable->duedate));
                $model_intdeliverables[] = $deliverable;
            }

            return $this->render('update', [
                'model' => $model,
                'model_intdeliverables' => $model_intdeliverables,
            ]);
        }

        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->intagreementid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * Deletes an existing IntAgreement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $extagreementid)
    {
        $model = $this->findModel($id, $extagreementid);
        $extagreementid = $model->extagreementid;
        $projectid = $model->extagreement->project->projectid;
        $this->validateProject($extagreementid);
        $this->validateCancelProject($extagreementid);

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction(); 
        
        IntDeliverables::deleteAll('intagreementid = :1', [':1'=>$model->intagreementid]);

        $model->delete();

        $model_project = new Project();
        $model_project = Project::findOne($projectid);                
        $model_project->setProjectStatus();

        $transaction->commit();

        return $this->redirect(['index', 'extagreementid'=>$extagreementid]);
    }

    /**
     * Finds the IntAgreement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IntAgreement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $extagreementid)
    {
        if (($model = IntAgreement::findOne($id)) !== null && $model->extagreementid == $extagreementid) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd($index, $extagreementid){
        $model = new IntDeliverables();

        return $this->renderAjax('int-deliverables/_form', [
                'model'=>$model,
                'index'=>$index,
                'extagreementid'=>$extagreementid
            ]);
    }

    public function actionRate($rateid){
        $rate = \app\models\ProjectRate::find()->where(['rateid'=>$rateid])->one();
        if (isset($rate->rate)){
            return $rate->rate;
        }

        return 0;
    }

    protected function validateProject($extagreementid){
        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();
        $model = \app\models\ExtAgreement::findOne($extagreementid);

        $model_project = Project::find()->where(['in', 'unitid', $user->accessUnit])
                ->andWhere(['projectid'=>$model->projectid])
                ->one();

        if ($model_project !== null) {
            return $model_project;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function validateCancelProject($extagreementid){
        $extagreement = \app\models\ExtAgreement::findOne($extagreementid);
        if (strpos(strtolower($extagreement->project->status->name), 'cancel') !== false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

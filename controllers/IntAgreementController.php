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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
                    if (isset($deliverable["code"]) && $deliverable["code"] != ""){
                        $model_deliverable->code = $deliverable["code"];   
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

            return $this->redirect(['view', 'id' => $model->extagreementid]);
             
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //initial user change & date
        $model->userup = 'sun';
        $model->dateup = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            
            $file1 = UploadedFile::getInstance($model, 'file');
            
            date_default_timezone_set('Asia/Jakarta');

            $model->filename = $model->project->code.'_'.date('dMY').'_'.date('His').'_'.'IntAgreement'. '.' . $file1->extension;
            $model->file = $file1;

            $model->startdate = date("Y-m-d", strtotime($model->startdate));
            $model->enddate = date("Y-m-d", strtotime($model->enddate));

            if($flag){
                $model->file->saveAs('uploads/' . $model->filename); 

                $post_intdeliverables = Yii::$app->request->post('IntDeliverables');

                $model_intdeliverables = [];
                
                IntDeliverables::deleteAll('intagreementid = :1',[':1'=> $model->intagreementid]);
                
                foreach($post_intdeliverables as $i => $intdeliverables) {
                    $intdeliverables1 = new IntDeliverables();
                    $intdeliverables1->setAttributes($intdeliverables);                                
                    $intdeliverables1->intagreementid = $model->intagreementid;

                    $model_intdeliverables[] = $intdeliverables1;
                }

                if(ExtDeliverables::validateMultiple($model_intdeliverables)){             

                    try{
                        foreach($model_intdeliverables as $intdeliverables){

                            //initial user change & date
                            $intdeliverables->userin = 'sun';                            
                            $intdeliverables->datein = new \yii\db\Expression('NOW()');
                            
                            $flag = $intdeliverables->save();

                            if(!$flag){
                                $transaction->rollBack();
                                break;
                            }
                        }
                        if($flag){
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->intagreementid]);
                        }
                    }
                    catch (Exception $ex) {
                        $transaction->rollBack();
                    }
                }
                else {
                    $transaction->rollBack();
                }
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'model_intdeliverables' => (empty($model_intdeliverables)) ? [new IntDeliverables()] :$model_intdeliverables,
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the IntAgreement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IntAgreement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IntAgreement::findOne($id)) !== null) {
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
}

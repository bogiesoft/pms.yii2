<?php

namespace app\controllers;

use Yii;
use app\models\Proposal;
use app\models\ProposalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use app\models\Project;
use app\models\ProjectSearch;
use yii\filters\AccessControl;

/**
 * ProposalController implements the CRUD actions for Proposal model.
 */
class ProposalController extends Controller
{
    private $accessid = "CREATE-PROPOSAL";

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
     * Lists all Proposal models.
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
        else{            
            $this->validateProject($projectid);

            $searchModel = new ProposalSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $projectid);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Proposal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($projectid, $id)
    {
        $this->validateProject($projectid);

        return $this->render('view', [
            'model' => $this->findModel($id, $projectid),
        ]);
    }

    /**
     * Creates a new Proposal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($projectid = 0)
    {
        $model = new Proposal();
        $model->setscenario('insert');
        $model->projectid = $projectid;
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        //initial user change & date
        $model->userin = Yii::$app->user->identity->username;
        $model->datein = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            $file1 = UploadedFile::getInstance($model, 'file');
            
            date_default_timezone_set('Asia/Jakarta');

            $model->date = date("Y-m-d", strtotime($model->date));
            
            $model->filename = str_replace('/', '.', $model->project->code).'_'.date('d.M.Y').'_'.date('His').'_'.'Proposal'. '.' . $file1->extension;
            $model->filename = strtoupper($model->filename);
            $model->file = $file1;
                
            if ($model->validate() && $model->save()) {
                $model->file->saveAs('uploads/' . $model->filename); 

                $model_project = new Project();
                $model_project = Project::findOne($projectid);  
                $model_project->setProjectStatus();

                return $this->redirect(['view', 'id' => $model->proposalid, 'projectid'=>$projectid]);
            }
            else {
                $model->date = date("d-M-Y", strtotime($model->date));
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->proposalid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * Updates an existing Proposal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($projectid, $id)
    {
        $model = $this->findModel($id, $projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        //initial user change & date
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('Asia/Jakarta');
            $flag = true;

            $file1 = UploadedFile::getInstance($model, 'file');
            if ($file1 == null && $model->filename == ""){
                $model->addError('file', 'Please upload a file.');
                $flag = false;
            }

            if ($file1 != null){  
                $model->filename = str_replace('/', '.', $model->project->code).'_'.date('d.M.Y').'_'.date('His').'_'.'Proposal'. '.' . $file1->extension;
                $model->filename = strtoupper($model->filename);
                $model->file = $file1;
            }

            $model->date = date("Y-m-d", strtotime($model->date));   
            
            if ($model->validate() && $model->save() && $flag) {                
                if ($file1 != null){
                    $model->file->saveAs('uploads/' . $model->filename); 
                }
                
                $model_project = new Project();
                $model_project = Project::findOne($projectid);                
                $model_project->setProjectStatus();

                return $this->redirect(['view', 'id' => $model->proposalid, 'projectid'=>$projectid]);
            }
            else{
                $model->date = date("d-M-Y", strtotime($model->date));
                return $this->render('update', [
                    'model' => $model,
                ]);    
            }
        } else {
            $model->date = date("d-M-Y", strtotime($model->date));
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->proposalid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * Deletes an existing Proposal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $projectid)
    {
        $model = $this->findModel($id, $projectid);
        $projectid = $model->projectid;

        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        $model->delete();

        $model_project = new Project();
        $model_project = Project::findOne($projectid);                
        $model_project->setProjectStatus();

        return $this->redirect(['index', 'projectid'=>$projectid]);
    }

    /**
     * Finds the Proposal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proposal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $projectid)
    { 
        if (($model = Proposal::findOne($id)) !== null && $model->project->projectid == $projectid) {
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

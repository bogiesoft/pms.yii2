<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ProjectPic;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
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
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();
        $model_projectpic = null;

        //initial user change & date
        $model->userin = 'sun';
        $model->datein = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            $flag = $model->save();

            $post_projectpic = Yii::$app->request->post('ProjectPic');
            //$valid = true;
            
            foreach($post_projectpic as $i => $projectpic) {
                $projectpic1 = new ProjectPic();
                $projectpic1->setAttributes($projectpic);                                
                $projectpic1->projectid = $model->projectid;
                /*
                if(!$projectpic1->validate()){
                    $valid = false;
                }
                */
                $model_projectpic[] = $projectpic1;                
            }
            
            //if(ProjectPic::loadMultiple($model_projectpic, Yii::$app->request->post('ProjectPic')) && ProjectPic::validateMultiple($model_projectpic)){                
            if(ProjectPic::validateMultiple($model_projectpic)){             
            //if($valid){
                
                try{
                    if($flag){
                        foreach($model_projectpic as $ProjectPic){

                            //initial user change & date
                            $ProjectPic->userin = 'sun';                            
                            $ProjectPic->datein = new \yii\db\Expression('NOW()');
                            
                            $flag = $ProjectPic->save();

                            if(!$flag){
                                $transaction->rollBack();
                                break;
                            }
                        }
                        if($flag){
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->projectid]);
                        }
                    }                    
                    /*
                    if($model->save())
                        return $this->redirect(['view', 'id' => $model->projectid]);
                    */
                }
                catch (Exception $ex) {
                    $transaction->rollBack();
                }                
            }
            else{
                $transaction->rollBack();
            }
        }
            
        return $this->render('create', [
            'model' => $model,
            'model_projectpic' => (empty($model_projectpic)) ? [new ProjectPic()] :$model_projectpic,
        ]);
    }

    /**
     * Updates an existing Project model.
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
        /*
        $model_projectpic = null;
        $dataCategory += ArrayHelper::map(User::find()->asArray()->all(), 'userid', 'name');
        */
        $model_projecpic = $model->projectpic;
        
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $flag = $model->save();

            $oldIds = ArrayHelper::map($model_projectpic,'userid','userid');
            $post_projectpic = Yii::$app->request->post('ProjectPic');

            //$valid = true;
            $model_projectpic = [];
            foreach($post_projectpic as $i => $projectpic) {
                $projectpic1 = new ProjectPic();
                $projectpic1->setAttributes($projectpic);                                
                $projectpic1->projectid = $model->projectid;
                /*
                if(!$projectpic1->validate()){
                    $valid = false;
                }
                */
                $model_projectpic[] = $projectpic1;                
            }

            $deleteIds = array_diff($oldIds, array_filter(ArrayHelper::map($model_projectpic,'userid','userid')));

            if(ProjectPic::validateMultiple($model_projectpic)){  
                try{
                    if($flag){

                        if(!empty($deleteIds)){
                            ProjectPic::deleteAll(['projectid'=> $model->projectid, 'userid'=>$deleteIds]);
                        }

                        foreach($model_projectpic as $ProjectPic){
                            //initial user change & date
                            $ProjectPic->userin = 'sun';                            
                            $ProjectPic->datein = new \yii\db\Expression('NOW()');
                            
                            $flag = $ProjectPic->save();

                            if(!$flag){
                                $transaction->rollBack();
                                break;
                            }
                        }
                        if($flag){
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->projectid]);
                        }
                    }                    
                    /*
                    if($model->save())
                        return $this->redirect(['view', 'id' => $model->projectid]);
                    */
                }
                catch (Exception $ex) {
                    $transaction->rollBack();
                }             
            }
            else{
                $transaction.rollBack();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_projectpic' => (empty($model_projectpic)) ? [new ProjectPic()] :$model_projectpic,
            ]);
        }
    }

    /**
     * Deletes an existing Project model.
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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd($index){
        $model = new ProjectPic();

        return $this->renderPartial('project-pic/_form', [
                'model'=>$model,
                'index'=>$index,
            ]);
    }
}

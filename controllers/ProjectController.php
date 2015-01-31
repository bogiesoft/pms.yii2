<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use app\models\ProjectPic;
use yii\filters\AccessControl;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    private $accessid = "CREATE-PDEFINITION";

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
        $projectpics = null;

        //initial user change & date
        $model->userin = Yii::$app->user->identity->username;
        $model->datein = new \yii\db\Expression('NOW()');

        $status = \app\models\Status::find()->where("name like '%potential%'")->one();
        $model->statusid = isset($status->statusid) ? $status->statusid : 0;

        $sql = "select count(projectid) as code from ps_project where year(initiationyear) = year(now())";
        $res = Project::findBySql($sql)->asArray()->one();
        $code = 1;
        if (isset($res["code"]) && isset($res["code"]) != null && isset($res["code"]) != ""){
            $code = $code + $res["code"];
        }

        $model->code = date('Y') . '/' . str_pad($code,(3 - strlen($code) + 1),'0',STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post())) {
            $flag = true;
            $model->initiationyear = date("Y-m-d", strtotime($model->initiationyear));
            
            if (isset($_POST["ProjectPic"])){
                foreach($_POST["ProjectPic"] as $pic){
                    $modelPIC = new ProjectPic();
                    if (isset($pic["userid"]) && $pic["userid"] != ""){
                        $modelPIC->userid = $pic["userid"];
                    }
                    $projectpics[] = $modelPIC;
                }
            }else{
                $pic = new ProjectPic();
                $pic->validate();
                $projectpics[] = $pic;
                $flag = false;
            } 

            if (!$flag){
                return $this->render('update', [
                    'model' => $model,
                    'model_projectpic' => $projectpics,
                ]); 
            }            

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                var_dump($model);
                $model->initiationyear = date("d-M-Y", strtotime($model->initiationyear));
                return $this->render('create', [
                    'model' => $model,
                    'model_projectpic' => $projectpics,
                ]);  
            }

            foreach($projectpics as $pic){
                $pic->projectid = $model->projectid;
                if (!$pic->save()){
                    $model->initiationyear = date("d-M-Y", strtotime($model->initiationyear));
                    return $this->render('create', [
                        'model' => $model,
                        'model_projectpic' => $projectpics,
                    ]); 
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->projectid]);

        }else{
            return $this->render('create', [
                'model' => $model,
                'model_projectpic' => $projectpics,
            ]);   
        }
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
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');
        $projectpics = null;
        
        if ($model->load(Yii::$app->request->post())) {
            $flag = true;
            $model->initiationyear = date("Y-m-d", strtotime($model->initiationyear));
            
            if (isset($_POST["ProjectPic"])){
                foreach($_POST["ProjectPic"] as $pic){
                    $modelPIC = new ProjectPic();
                    if (isset($pic["userid"]) && $pic["userid"] != ""){
                        $modelPIC->userid = $pic["userid"];
                    }
                    $projectpics[] = $modelPIC;
                }
            }else{
                $pic = new ProjectPic();
                $pic->validate();
                $projectpics[] = $pic;
                $flag = false;
            }

            if (!$flag){
                return $this->render('update', [
                    'model' => $model,
                    'model_projectpic' => $projectpics,
                ]); 
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $model->initiationyear = date("d-M-Y", strtotime($model->initiationyear));
                return $this->render('update', [
                    'model' => $model,
                    'model_projectpic' => $projectpics,
                ]);  
            }

            ProjectPic::deleteAll('projectid = :1', [':1'=>$model->projectid]);
            foreach($projectpics as $pic){
                $pic->projectid = $model->projectid;
                if (!$pic->save()){
                    $model->initiationyear = date("d-M-Y", strtotime($model->initiationyear));
                    return $this->render('update', [
                        'model' => $model,
                        'model_projectpic' => $projectpics,
                    ]); 
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->projectid]);

        }else{
            $model->initiationyear = date("d-M-Y", strtotime($model->initiationyear));

            $picModel = ProjectPic::find()->where('projectid = :1', [':1'=>$model->projectid])->all();
            foreach($picModel as $pic){                
                $projectpics[] = $pic;
            }

            return $this->render('update', [
                'model' => $model,
                'model_projectpic' => $projectpics,
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
        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();

        $model = Project::find()->where(['in', 'unitid', $user->accessUnit])
                ->andWhere(['projectid'=>$id])
                ->one();

        if ($model !== null) {
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

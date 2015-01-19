<?php

namespace app\controllers;

use Yii;
use app\models\Group;
use app\models\GroupUser;
use app\models\GroupAccess;
use app\models\GroupAccessData;
use app\models\GroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
{
    private $accessid = "CREATE-GROUP";

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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();
        $users = [];
        $menus = [];
        $units = [];
        $model->active = 1;

        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST["Group"]["UserGroup"])){
                $post = $_POST["Group"]["UserGroup"];  
                foreach($post as $userid => $data){
                    array_push($users, $userid);
                }
            }

            if (isset($_POST["Group"]["GroupAccess"])){
                $post = $_POST["Group"]["GroupAccess"];   
                foreach($post as $menuid => $data){
                    array_push($menus, $menuid);   
                }
            }

            if (isset($_POST["Group"]["GroupUnit"])){
                $post = $_POST["Group"]["GroupUnit"];   
                foreach($post as $unitid => $data){
                    array_push($units, $unitid);
                }
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollback();  
                return $this->render('create', [
                    'model' => $model,
                    'users' => $users,
                    'menus' => $menus,
                    'units' => $units,
                ]);
            }

            foreach($users as $userid){
                $model_user = new GroupUser();
                $model_user->groupid = $model->groupid;
                $model_user->userid = $userid;
                if (!$model_user->save()){
                    $transaction->rollback();  
                    return $this->render('create', [
                        'model' => $model,
                        'users' => $users,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            foreach($menus as $menuid){
                $model_access = new GroupAccess();
                $model_access->groupid = $model->groupid;
                $model_access->menuid = $menuid;
                if (!$model_access->save()){
                    $transaction->rollback();  
                    return $this->render('create', [
                        'model' => $model,
                        'users' => $users,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            foreach($units as $unitid){
                $model_access_data = new GroupAccessData();
                $model_access_data->groupid = $model->groupid;
                $model_access_data->unitid = $unitid;
                if (!$model_access_data->save()){
                    $transaction->rollback();  
                    return $this->render('create', [
                        'model' => $model,
                        'users' => $users,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->groupid]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'users' => $users,
                'menus' => $menus,
                'units' => $units,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users = [];
        $menus = [];
        $units = [];

        if ($model->load(Yii::$app->request->post())) {

            if (isset($_POST["Group"]["UserGroup"])){
                $post = $_POST["Group"]["UserGroup"];  
                foreach($post as $userid => $data){
                    array_push($users, $userid);
                }
            }

            if (isset($_POST["Group"]["GroupAccess"])){
                $post = $_POST["Group"]["GroupAccess"];   
                foreach($post as $menuid => $data){
                    array_push($menus, $menuid);   
                }
            }

            if (isset($_POST["Group"]["GroupUnit"])){
                $post = $_POST["Group"]["GroupUnit"];   
                foreach($post as $unitid => $data){
                    array_push($units, $unitid);
                }
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollback();  
                return $this->render('update', [
                    'model' => $model,
                    'users' => $users,
                    'menus' => $menus,
                    'units' => $units,
                ]);
            }

            GroupUser::deleteAll('groupid = :1',[':1'=>$model->groupid,]);

            foreach($users as $userid){
                $model_user = new GroupUser();
                $model_user->groupid = $model->groupid;
                $model_user->userid = $userid;
                if (!$model_user->save()){
                    $transaction->rollback();  
                    return $this->render('update', [
                        'model' => $model,
                        'users' => $users,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            GroupAccess::deleteAll('groupid = :1',[':1'=>$model->groupid,]);

            foreach($menus as $menuid){
                $model_access = new GroupAccess();
                $model_access->groupid = $model->groupid;
                $model_access->menuid = $menuid;
                if (!$model_access->save()){
                    $transaction->rollback();  
                    return $this->render('update', [
                        'model' => $model,
                        'users' => $users,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            GroupAccessData::deleteAll('groupid = :1',[':1'=>$model->groupid,]);

            foreach($units as $unitid){
                $model_access_data = new GroupAccessData();
                $model_access_data->groupid = $model->groupid;
                $model_access_data->unitid = $unitid;
                if (!$model_access_data->save()){
                    $transaction->rollback();  
                    return $this->render('update', [
                        'model' => $model,
                        'users' => $users,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->groupid]);

        } else {
            $arr = \app\models\GroupUser::find()->where('groupid = :1',[':1'=>$model->groupid,])->asArray()->all();
            foreach($arr as $data){
                array_push($users, $data["userid"]);
            }

            $arr = \app\models\GroupAccess::find()->where('groupid = :1',[':1'=>$model->groupid,])->asArray()->all();
            foreach($arr as $data){
                array_push($menus, $data["menuid"]);
            }

            $arr = \app\models\GroupAccessData::find()->where('groupid = :1',[':1'=>$model->groupid,])->asArray()->all();
            foreach($arr as $data){
                array_push($units, $data["unitid"]);
            }

            return $this->render('update', [
                'model' => $model,
                'users' => $users,
                'menus' => $menus,
                'units' => $units,
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

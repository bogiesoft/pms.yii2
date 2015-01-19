<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\GroupUser;
use app\models\UserAccess;
use app\models\UserAccessData;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    private $accessid = "CREATE-USER";

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $groups = [];
        $menus = [];
        $units = [];
        $acc = true;

        //initial default value active
        $model->active = '1';

        if ($model->load(Yii::$app->request->post())) {
            //check password & confirm password, return error when not same
            if ($model->varPassword != $model->password){
                //reset password
                $model->password = "";
                $model->varPassword = "";

                //set error message
                $model->addError('varPassword', 'Password confirm must be the same as password');
                $model->addError('password', 'Password confirm must be the same as password');

                $acc = false;
            }else{
                //if password is default(no update), get existing password
                if ($model->password == "!@#$%^&*()_+!@#$%"){
                    $model->password = User::findOne($model->userid)->password;
                }
            }

            if (isset($_POST["User"]["UserGroup"])){
                $post = $_POST["User"]["UserGroup"];  
                foreach($post as $groupid => $data){
                    array_push($groups, $groupid);
                }
            }

            if (isset($_POST["User"]["UserAccess"])){
                $post = $_POST["User"]["UserAccess"];   
                foreach($post as $menuid => $data){
                    array_push($menus, $menuid);   
                }
            }

            if (isset($_POST["User"]["UserUnit"])){
                $post = $_POST["User"]["UserUnit"];   
                foreach($post as $unitid => $data){
                    array_push($units, $unitid);
                }
            }

            if (!$acc){
                return $this->render('create', [
                    'model' => $model,
                    'groups' => $groups,
                    'menus' => $menus,
                    'units' => $units,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $acc = false;
            }

            foreach($groups as $groupid){
                $model_group = new GroupUser();
                $model_group->userid = $model->userid;
                $model_group->groupid = $groupid;
                if (!$model_group->save()){
                    $acc = false;
                }
            }

            foreach($menus as $menuid){
                $model_access = new UserAccess();
                $model_access->userid = $model->userid;
                $model_access->menuid = $menuid;
                if (!$model_access->save()){
                    $acc = false;
                }
            }

            foreach($units as $unitid){
                $model_access_data = new UserAccessData();
                $model_access_data->userid = $model->userid;
                $model_access_data->unitid = $unitid;
                if (!$model_access_data->save()){
                    $acc = false;
                }
            }

            if ($acc){
                $transaction->commit();   
                return $this->redirect(['view', 'id' => $model->userid]);    
            }

            $transaction->rollback();  
            return $this->render('create', [
                'model' => $model,
                'groups' => $groups,
                'menus' => $menus,
                'units' => $units,
            ]); 
        
        } else {
            return $this->render('create', [
                'model' => $model,
                'groups' => $groups,
                'menus' => $menus,
                'units' => $units,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //initial password, hide real password
        $model->password = "!@#$%^&*()_+!@#$%";
        $model->varPassword = "!@#$%^&*()_+!@#$%";
        $groups = [];
        $menus = [];
        $units = [];
        $acc = true;

        if ($model->load(Yii::$app->request->post())) {
            //check password & confirm password, return error when not same
            if ($model->varPassword != $model->password){
                //reset password
                $model->password = "";
                $model->varPassword = "";

                //set error message
                $model->addError('varPassword', 'Password confirm must be the same as password');
                $model->addError('password', 'Password confirm must be the same as password');

                $acc = false;
            }else{
                //if password is default(no update), get existing password
                if ($model->password == "!@#$%^&*()_+!@#$%"){
                    $model->password = User::findOne($model->userid)->password;
                }
            }

            if (isset($_POST["User"]["UserGroup"])){
                $post = $_POST["User"]["UserGroup"];  
                foreach($post as $groupid => $data){
                    array_push($groups, $groupid);
                }
            }

            if (isset($_POST["User"]["UserAccess"])){
                $post = $_POST["User"]["UserAccess"];   
                foreach($post as $menuid => $data){
                    array_push($menus, $menuid);   
                }
            }

            if (isset($_POST["User"]["UserUnit"])){
                $post = $_POST["User"]["UserUnit"];   
                foreach($post as $unitid => $data){
                    array_push($units, $unitid);
                }
            }

            if (!$acc){
                return $this->render('update', [
                    'model' => $model,
                    'groups' => $groups,
                    'menus' => $menus,
                    'units' => $units,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollback();  
                return $this->render('update', [
                    'model' => $model,
                    'groups' => $groups,
                    'menus' => $menus,
                    'units' => $units,
                ]);
            }

            GroupUser::deleteAll('userid = :1',[':1'=>$model->userid,]);

            foreach($groups as $groupid){
                $model_group = new GroupUser();
                $model_group->userid = $model->userid;
                $model_group->groupid = $groupid;
                if (!$model_group->save()){
                    $transaction->rollback();  
                    return $this->render('update', [
                        'model' => $model,
                        'groups' => $groups,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            UserAccess::deleteAll('userid = :1',[':1'=>$model->userid,]);

            foreach($menus as $menuid){
                $model_access = new UserAccess();
                $model_access->userid = $model->userid;
                $model_access->menuid = $menuid;
                if (!$model_access->save()){
                    $transaction->rollback();  
                    return $this->render('update', [
                        'model' => $model,
                        'groups' => $groups,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            UserAccessData::deleteAll('userid = :1',[':1'=>$model->userid,]);

            foreach($units as $unitid){
                $model_access_data = new UserAccessData();
                $model_access_data->userid = $model->userid;
                $model_access_data->unitid = $unitid;
                if (!$model_access_data->save()){
                    $transaction->rollback();  
                    return $this->render('update', [
                        'model' => $model,
                        'groups' => $groups,
                        'menus' => $menus,
                        'units' => $units,
                    ]);
                }
            }

            $transaction->commit();   
            return $this->redirect(['view', 'id' => $model->userid]);    

        } else {
            $arr = \app\models\GroupUser::find()->where('userid = :1',[':1'=>$model->userid,])->asArray()->all();
            foreach($arr as $data){
                array_push($groups, $data["groupid"]);
            }

            $arr = \app\models\UserAccess::find()->where('userid = :1',[':1'=>$model->userid,])->asArray()->all();
            foreach($arr as $data){
                array_push($menus, $data["menuid"]);
            }

            $arr = \app\models\UserAccessData::find()->where('userid = :1',[':1'=>$model->userid,])->asArray()->all();
            foreach($arr as $data){
                array_push($units, $data["unitid"]);
            }

            return $this->render('update', [
                'model' => $model,
                'groups' => $groups,
                'menus' => $menus,
                'units' => $units,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

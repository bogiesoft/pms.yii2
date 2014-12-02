<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

        //initial default value active
        $model->active = '1';
        
        //initial user change & date
        $model->userin = 'prayogo';
        $model->datein = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            //check password & confirm password, return error when not same
            if ($model->varPassword != $model->password){
                //reset password
                $model->password = "";
                $model->varPassword = "";

                //set error message
                $model->addError('varPassword', 'Password confirm must be the same as password');
                $model->addError('password', 'Password confirm must be the same as password');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }else{
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->userid]);    
                }   
            }
        } else {
            return $this->render('create', [
                'model' => $model,
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

        //initial user change & date
        $model->userup = 'prayogo';
        $model->dateup = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            //check password & confirm password, return error when not same
            if ($model->varPassword != $model->password){
                //reset password
                $model->password = "";
                $model->varPassword = "";

                //set error message
                $model->addError('varPassword', 'Password confirm must be the same as password');
                $model->addError('password', 'Password confirm must be the same as password');

                return $this->render('update', [
                    'model' => $model,
                ]);
            }else{
                //if password is default(no update), get existing password
                if ($model->password == "!@#$%^&*()_+!@#$%"){
                    $model->password = User::findOne($model->userid)->password;
                }

                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->userid]);    
                }   
            }
        } else {
            return $this->render('update', [
                'model' => $model,
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

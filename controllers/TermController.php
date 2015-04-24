<?php

namespace app\controllers;

use Yii;
use app\models\Term;
use app\models\TermSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TermController implements the CRUD actions for Term model.
 */
class TermController extends Controller
{
    private $accessid = "TERM-TBL";

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
     * Lists all Term models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TermSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Term model.
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
     * Creates a new Term model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Term();

        $model->userin = Yii::$app->user->identity->username;
        $model->datein = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            $model->startdate = date("Y-m-d", strtotime($model->startdate));
            $model->enddate = date("Y-m-d", strtotime($model->enddate));

            if (!$model->save()){
                $model->startdate = date("d-M-Y", strtotime($model->startdate));
                $model->enddate = date("d-M-Y", strtotime($model->enddate));
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            return $this->redirect(['view', 'id' => $model->termid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Term model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            $model->startdate = date("Y-m-d", strtotime($model->startdate));
            $model->enddate = date("Y-m-d", strtotime($model->enddate));

            if (!$model->save()){
                $model->startdate = date("d-M-Y", strtotime($model->startdate));
                $model->enddate = date("d-M-Y", strtotime($model->enddate));
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            return $this->redirect(['view', 'id' => $model->termid]);
        } else {
            $model->startdate = date("d-M-Y", strtotime($model->startdate));
            $model->enddate = date("d-M-Y", strtotime($model->enddate));
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Term model.
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
     * Finds the Term model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Term the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Term::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\ExtAgreement;
use app\models\ExtAgreementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\data\ActiveDataProvider;

/**
 * ExtAgreementController implements the CRUD actions for ExtAgreement model.
 */
class ExtAgreementController extends Controller
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
     * Lists all ExtAgreement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExtAgreementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
    public function actionCreate()
    {
        $model = new ExtAgreement();

        //initial user change & date
        $model->userin = 'sun';
        $model->datein = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {

            $file1 = UploadedFile::getInstance($model, 'file');
            
            date_default_timezone_set('Asia/Jakarta');
            
            $model->filename = $model->project->code.'_'.date('dMY').'_'.date('His').'_'.'ExtAgreement'. '.' . $file1->extension;
            $model->file = $file1;
            
            if ($model->validate()) {

                $model->startdate = date("Y-m-d", strtotime($model->startdate));
                $model->enddate = date("Y-m-d", strtotime($model->enddate));

                if($model->save()){
                    $model->file->saveAs('uploads/' . $model->filename); 
                    return $this->redirect(['view', 'id' => $model->extagreementid]);
                }
            }
            else {
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //initial user change & date
        $model->userup = 'sun';
        $model->dateup = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {
            
            $file1 = UploadedFile::getInstance($model, 'file');
            
            date_default_timezone_set('Asia/Jakarta');

            $model->filename = $model->project->code.'_'.date('dMY').'_'.date('His').'_'.'ExtAgreement'. '.' . $file1->extension;
            $model->file = $file1;            
            if ($model->validate()) {

                $model->startdate = date("Y-m-d", strtotime($model->startdate));
                $model->enddate = date("Y-m-d", strtotime($model->enddate));

                if($model->save()){
                    $model->file->saveAs('uploads/' . $model->filename); 
                    return $this->redirect(['view', 'id' => $model->extagreementid]);
                }
            }
            else{
                return $this->render('update',[
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->extagreementid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        */
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
}

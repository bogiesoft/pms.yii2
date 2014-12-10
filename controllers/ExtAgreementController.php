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

use yii\helpers\ArrayHelper;
use app\models\ExtDeliverables;

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
        $model_extdeliverables = null;

        //initial user change & date
        $model->userin = 'sun';
        $model->datein = new \yii\db\Expression('NOW()');

        if ($model->load(Yii::$app->request->post())) {

            $file1 = UploadedFile::getInstance($model, 'file');
            
            date_default_timezone_set('Asia/Jakarta');
            
            $model->filename = $model->project->code.'_'.date('dMY').'_'.date('His').'_'.'ExtAgreement'. '.' . $file1->extension;
            $model->file = $file1;            

            $model->startdate = date("Y-m-d", strtotime($model->startdate));
            $model->enddate = date("Y-m-d", strtotime($model->enddate));

            $transaction = Yii::$app->db->beginTransaction();
            $flag = $model->save();

            if($flag){
                $model->file->saveAs('uploads/' . $model->filename); 

                $post_extdeliverables = Yii::$app->request->post('ExtDeliverables');
                
                foreach($post_extdeliverables as $i => $extdeliverables) {
                    $extdeliverables1 = new ExtDeliverables();
                    $extdeliverables1->setAttributes($extdeliverables);                                
                    $extdeliverables1->extagreementid = $model->extagreementid;

                    $model_extdeliverables[] = $extdeliverables1;                
                }

                if(ExtDeliverables::validateMultiple($model_extdeliverables)){             

                    try{
                        foreach($model_extdeliverables as $extdeliverables){

                            //initial user change & date
                            $extdeliverables->userin = 'sun';                            
                            $extdeliverables->datein = new \yii\db\Expression('NOW()');
                            
                            $flag = $extdeliverables->save();

                            if(!$flag){
                                $transaction->rollBack();
                                break;
                            }
                        }
                        if($flag){
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->extagreementid]);
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
        }
        
        return $this->render('create', [
            'model' => $model,
            'model_extdeliverables'=> (empty($model_extdeliverables)) ? [new ExtDeliverables()] :$model_extdeliverables,
        ]);

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

        $model_extdeliverables = ExtDeliverables::find()->where('extagreementid = :1',[':1'=>$model->extagreementid,])->all();

        if ($model->load(Yii::$app->request->post())) {
            
            $file1 = UploadedFile::getInstance($model, 'file');            
            date_default_timezone_set('Asia/Jakarta');

            $model->filename = $model->project->code.'_'.date('dMY').'_'.date('His').'_'.'ExtAgreement'. '.' . $file1->extension;
            $model->file = $file1;            

            $model->startdate = date("Y-m-d", strtotime($model->startdate));
            $model->enddate = date("Y-m-d", strtotime($model->enddate));

            $transaction = Yii::$app->db->beginTransaction();
            $flag = $model->save();

            if($flag){
                $model->file->saveAs('uploads/' . $model->filename); 

                $post_extdeliverables = Yii::$app->request->post('ExtDeliverables');
                
                $model_extdeliverables = [];
                
                ExtDeliverables::deleteAll('extagreementid = :1',[':1'=> $model->extagreementid]);

                foreach($post_extdeliverables as $i => $extdeliverables) {
                    $extdeliverables1 = new ExtDeliverables();
                    $extdeliverables1->setAttributes($extdeliverables);                                
                    $extdeliverables1->extagreementid = $model->extagreementid;

                    $model_extdeliverables[] = $extdeliverables1;                
                }

                if(ExtDeliverables::validateMultiple($model_extdeliverables)){             

                    try{
                        if($flag){
                            

                            foreach($model_extdeliverables as $extdeliverables){

                                //initial user change & date
                                $extdeliverables->userin = 'sun';                            
                                $extdeliverables->datein = new \yii\db\Expression('NOW()');
                                
                                $flag = $extdeliverables->save();

                                if(!$flag){
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            if($flag){
                                $transaction->commit();
                                return $this->redirect(['view', 'id' => $model->extagreementid]);
                            }
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
        } 

        return $this->render('update', [
            'model' => $model,
            'model_extdeliverables'=> (empty($model_extdeliverables)) ? [new ExtDeliverables()] :$model_extdeliverables,
        ]);

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

    public function actionAdd($index){
        $model = new ExtDeliverables();

        return $this->renderPartial('ext-deliverables/_form', [
                'model'=>$model,
                'index'=>$index,
            ]);
    }
}

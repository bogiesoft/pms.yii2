<?php

namespace app\controllers;

use Yii;
use app\models\Consultant;
use app\models\ConsultantPhone;
use app\models\ConsultantEmail;
use app\models\ConsultantBank;
use app\models\ConsultantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ConsultantController implements the CRUD actions for Consultant model.
 */
class ConsultantController extends Controller
{
    private $accessid = "CREATE-CONSULTANT";

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
     * Lists all Consultant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsultantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consultant model.
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
     * Creates a new Consultant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consultant();        
        $index = 1;
        $indexEmail = 1;
        $indexBank = 1;
        $phones = null;
        $emails = null;
        $banks = null;

        $flag = true;

        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST["ConsultantPhone"])){
                foreach($_POST["ConsultantPhone"] as $ph){
                    $modelPhone = new ConsultantPhone();
                    if (isset($ph["phonetypeid"]) && $ph["phonetypeid"] != ""){
                        $modelPhone->phonetypeid = $ph["phonetypeid"];
                    }
                    if (isset($ph["phone"]) && $ph["phone"] != ""){
                        $modelPhone->phone = $ph["phone"];   
                    }
                    $phones[] = $modelPhone;
                }
            }else{
                $ph = new ConsultantPhone();
                $ph->validate();
                $phones[] = $ph;
                $flag = false;
            }

            if (isset($_POST["ConsultantEmail"])){
                foreach($_POST["ConsultantEmail"] as $em){
                    $modelEmail = new ConsultantEmail();
                    if (isset($em["email"]) && $em["email"] != ""){
                        $modelEmail->email = $em["email"];
                    }
                    $emails[] = $modelEmail;
                }
            }else{
                $em = new ConsultantEmail();
                $em->validate();
                $emails[] = $em;
                $flag = false;
            }

            if (isset($_POST["ConsultantBank"])){
                foreach($_POST["ConsultantBank"] as $bk){
                    $modelBank = new ConsultantBank();
                    $modelBank->bankid = $bk["bankid"];
                    $modelBank->branch = $bk["branch"];
                    $modelBank->account = $bk["account"];
                    $modelBank->active = $bk["active"];
                    $banks[] = $modelBank;
                }
            }else{
                $bk = new ConsultantBank();
                $bk->validate();
                $banks[] = $bk;
                $flag = false;
            }

            if (!$flag){
                return $this->render('create', [
                    'model' => $model,
                    'index' => $index,
                    'indexEmail' => $indexEmail,
                    'indexBank' => $indexBank,
                    'phones' => $phones,
                    'emails' => $emails,
                    'banks' => $banks,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                return $this->render('create', [
                    'model' => $model,
                    'index' => $index,
                    'indexEmail' => $indexEmail,
                    'indexBank' => $indexBank,
                    'phones' => $phones,
                    'emails' => $emails,
                    'banks' => $banks,
                ]);  
            }

            foreach($phones as $ph){
                $ph->consultantid = $model->consultantid;
                if (!$ph->save()){
                    return $this->render('create', [
                        'model' => $model,
                        'index' => $index,
                        'indexEmail' => $indexEmail,
                        'indexBank' => $indexBank,
                        'phones' => $phones,
                        'emails' => $emails,
                        'banks' => $banks,
                    ]);  
                }
            }

            foreach($emails as $em){
                $em->consultantid = $model->consultantid;
                if (!$em->save()){
                    return $this->render('create', [
                        'model' => $model,
                        'index' => $index,
                        'indexEmail' => $indexEmail,
                        'indexBank' => $indexBank,
                        'phones' => $phones,
                        'emails' => $emails,
                        'banks' => $banks,
                    ]);  
                }
            }

            foreach($banks as $bk){
                $bk->consultantid = $model->consultantid;
                if (!$bk->save()){
                    return $this->render('create', [
                        'model' => $model,
                        'index' => $index,
                        'indexEmail' => $indexEmail,
                        'indexBank' => $indexBank,
                        'phones' => $phones,
                        'emails' => $emails,
                        'banks' => $banks,
                    ]);  
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->consultantid]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'index' => $index,
                'indexEmail' => $indexEmail,
                'indexBank' => $indexBank,
                'phones' => $phones,
                'emails' => $emails,
                'banks' => $banks,
            ]);
        }
    }

    /**
     * Updates an existing Consultant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $index = 1;
        $indexEmail = 1;
        $indexBank = 1;
        $phones = null;
        $emails = null;
        $banks = null;

        $flag = true;

        if ($model->load(Yii::$app->request->post())) {
            $arrPhoneId = null;
            $arrEmailId = null;
            $arrBankId = null;

            if (isset($_POST["ConsultantPhone"])){
                foreach($_POST["ConsultantPhone"] as $ph){
                    $modelPhone = new ConsultantPhone();
                    if (isset($ph["phonetypeid"]) && $ph["phonetypeid"] != ""){
                        $modelPhone->phonetypeid = $ph["phonetypeid"];
                    }
                    if (isset($ph["phone"]) && $ph["phone"] != ""){
                        $modelPhone->phone = $ph["phone"];   
                    }
                    if (isset($ph["consultantphoneid"]) && $ph["consultantphoneid"] != ""){
                        $modelPhone->consultantphoneid = $ph["consultantphoneid"];   
                        $arrPhoneId[] = $modelPhone->consultantphoneid;
                    }

                    $phones[] = $modelPhone;
                }
            }else{
                $ph = new ConsultantPhone();
                $ph->validate();
                $phones[] = $ph;
                $flag = false;
            }

            if (isset($_POST["ConsultantEmail"])){
                foreach($_POST["ConsultantEmail"] as $em){
                    $modelEmail = new ConsultantEmail();
                    if (isset($em["consultantemailid"]) && $em["consultantemailid"] != ""){
                        $modelEmail->consultantemailid = $em["consultantemailid"];
                        $arrEmailId[] = $modelEmail->consultantemailid;
                    }
                    if (isset($em["email"]) && $em["email"] != ""){
                        $modelEmail->email = $em["email"];
                    }
                    $emails[] = $modelEmail;
                }
            }else{
                $em = new ConsultantEmail();
                $em->validate();
                $emails[] = $em;
                $flag = false;
            }

            if (isset($_POST["ConsultantBank"])){
                foreach($_POST["ConsultantBank"] as $bk){
                    $modelBank = new ConsultantBank();
                    if (isset($bk["consultantbankid"]) && $bk["consultantbankid"] != ""){
                        $modelBank->consultantbankid = $bk["consultantbankid"];
                        $arrBankId[] = $modelBank->consultantbankid;
                    }
                    if (isset($bk["bankid"]) && $bk["bankid"] != ""){
                        $modelBank->bankid = $bk["bankid"];
                    }
                    if (isset($bk["branch"]) && $bk["branch"] != ""){
                        $modelBank->branch = $bk["branch"];
                    }
                    if (isset($bk["account"]) && $bk["account"] != ""){
                        $modelBank->account = $bk["account"];
                    }
                    if (isset($bk["active"]) && $bk["active"] != ""){
                        $modelBank->active = $bk["active"];
                    }
                    $banks[] = $modelBank;
                }
            }else{
                $bk = new ConsultantBank();
                $bk->validate();
                $banks[] = $bk;
                $flag = false;
            }

            if (!$flag){
                return $this->render('update', [
                    'model' => $model,
                    'index' => $index,
                    'indexEmail' => $indexEmail,
                    'indexBank' => $indexBank,
                    'phones' => $phones,
                    'emails' => $emails,
                    'banks' => $banks,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                return $this->render('update', [
                    'model' => $model,
                    'index' => $index,
                    'indexEmail' => $indexEmail,
                    'indexBank' => $indexBank,
                    'phones' => $phones,
                    'emails' => $emails,
                    'banks' => $banks,
                ]);  
            }

            $deletePhone = ConsultantPhone::find()->where('consultantid = :1', [':1'=>$model->consultantid])->all();
            foreach($deletePhone as $phone){
                if (!in_array($phone->consultantphoneid, $arrPhoneId)){
                    ConsultantPhone::deleteAll('consultantphoneid = :1', [':1'=>$phone->consultantphoneid]);
                }
            }

            foreach($phones as $ph){
                $ph->consultantid = $model->consultantid;
                
                if (isset($ph->consultantphoneid) && $ph->consultantphoneid != null && $ph->consultantphoneid != ""){     
                    $modelPhone = ConsultantPhone::findOne($ph->consultantphoneid);   
                    $modelPhone->phonetypeid = $ph->phonetypeid;
                    $modelPhone->phone = $ph->phone;

                    if (!$modelPhone->save()){
                        return $this->render('update', [
                            'model' => $model,
                            'index' => $index,
                            'indexEmail' => $indexEmail,
                            'indexBank' => $indexBank,
                            'phones' => $phones,
                            'emails' => $emails,
                            'banks' => $banks,
                        ]); 
                    }
                }else if (!$ph->save()){
                    return $this->render('update', [
                        'model' => $model,
                        'index' => $index,
                        'indexEmail' => $indexEmail,
                        'indexBank' => $indexBank,
                        'phones' => $phones,
                        'emails' => $emails,
                        'banks' => $banks,
                    ]); 
                }
            }

            $deleteEmail = ConsultantEmail::find()->where('consultantid = :1', [':1'=>$model->consultantid])->all();
            foreach($deleteEmail as $email){
                if (!in_array($email->consultantemailid, $arrEmailId)){
                    ConsultantEmail::deleteAll('consultantemailid = :1', [':1'=>$email->consultantemailid]);
                }
            }

            foreach($emails as $em){
                $em->consultantid = $model->consultantid;
                
                if (isset($em->consultantemailid) && $em->consultantemailid != null && $em->consultantemailid != ""){     
                    $modelEmail = ConsultantEmail::findOne($em->consultantemailid);   
                    $modelEmail->email = $em->email;

                    if (!$modelEmail->save()){
                        return $this->render('update', [
                            'model' => $model,
                            'index' => $index,
                            'indexEmail' => $indexEmail,
                            'indexBank' => $indexBank,
                            'phones' => $phones,
                            'emails' => $emails,
                            'banks' => $banks,
                        ]); 
                    }
                }else if (!$em->save()){
                    return $this->render('update', [
                        'model' => $model,
                        'index' => $index,
                        'indexEmail' => $indexEmail,
                        'indexBank' => $indexBank,
                        'phones' => $phones,
                        'emails' => $emails,
                        'banks' => $banks,
                    ]); 
                }
            }

            $deleteBank = ConsultantBank::find()->where('consultantid = :1', [':1'=>$model->consultantid])->all();
            foreach($deleteBank as $bank){
                if (!in_array($bank->consultantbankid, $arrBankId)){
                    ConsultantBank::deleteAll('consultantbankid = :1', [':1'=>$bank->consultantbankid]);
                }
            }

            foreach($banks as $bk){
                $bk->consultantid = $model->consultantid;
                
                if (isset($bk->consultantbankid) && $bk->consultantbankid != null && $bk->consultantbankid != ""){     
                    $modelBank = ConsultantBank::findOne($bk->consultantbankid);   
                    $modelBank->bankid = $bk->bankid;
                    $modelBank->branch = $bk->branch;
                    $modelBank->account = $bk->account;
                    $modelBank->active = $bk->active;

                    if (!$modelBank->save()){
                        return $this->render('update', [
                            'model' => $model,
                            'index' => $index,
                            'indexEmail' => $indexEmail,
                            'indexBank' => $indexBank,
                            'phones' => $phones,
                            'emails' => $emails,
                            'banks' => $banks,
                        ]); 
                    }
                }else if (!$bk->save()){
                    return $this->render('update', [
                        'model' => $model,
                        'index' => $index,
                        'indexEmail' => $indexEmail,
                        'indexBank' => $indexBank,
                        'phones' => $phones,
                        'emails' => $emails,
                        'banks' => $banks,
                    ]); 
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->consultantid]);
        } else {

            $phoneModel = ConsultantPhone::find()->where('consultantid = :1', [':1'=>$model->consultantid])->all();
            foreach($phoneModel as $ph){                
                $phones[] = $ph;
            }

            $emailModel = ConsultantEmail::find()->where('consultantid = :1', [':1'=>$model->consultantid])->all();
            foreach($emailModel as $em){                
                $emails[] = $em;
            }

            $bankModel = ConsultantBank::find()->where('consultantid = :1', [':1'=>$model->consultantid])->all();
            foreach($bankModel as $bk){                
                $banks[] = $bk;
            }

            return $this->render('update', [
                'model' => $model,
                'index' => $index,
                'indexEmail' => $indexEmail,
                'indexBank' => $indexBank,
                'phones' => $phones,
                'emails' => $emails,
                'banks' => $banks,
            ]);
        }
    }

    /**
     * Deletes an existing Consultant model.
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
     * Finds the Consultant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consultant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consultant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRenderPhone($index)
    {
        $model = new ConsultantPhone;
        return $this->renderPartial('phone/_form', array(
            'model' => $model,
            'index' => $index,
        ), false, true);
    }

    public function actionRenderEmail($index)
    {
        $model = new ConsultantEmail;
        return $this->renderPartial('email/_form', array(
            'model' => $model,
            'index' => $index,
        ), false, true);
    }

    public function actionRenderBank($index)
    {
        $model = new ConsultantBank;
        $model->active = 1;
        return $this->renderPartial('bank/_form', array(
            'model' => $model,
            'index' => $index,
        ), false, true);
    }
}

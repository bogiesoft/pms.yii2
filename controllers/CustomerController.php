<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\ContactPerson;
use app\models\ContactPersonPhone;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    private $accessid = "CREATE-CUSTOMER";

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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $contacts = null;
        $index = 1;
        $indexPhone = 1;

        //initial user change & date
        $model->userin = Yii::$app->user->identity->username;
        $model->datein = new \yii\db\Expression('NOW()');

        $flag = true;

        if ($model->load(Yii::$app->request->post())) {
            $model->dayofjoin = date("Y-m-d", strtotime($model->dayofjoin));
            
            if (isset($_POST["ContactPerson"])){
                $contactPerson = $_POST["ContactPerson"];   
            }
            else{
                $contactPerson = [];
                $contact = new ContactPerson(); 
                $contact->validate();
                $phone = new ContactPersonPhone();
                $phone->validate();
                $contact->phones[] = $phone;
                $contacts[] = $contact;
                $flag = false;
            }

            foreach($contactPerson as $contact){
                $contactModel = new ContactPerson();
                if (isset($contact["name"]) && $contact["name"] != ""){
                    $contactModel->name = $contact["name"];   
                }
                if (isset($contact["email"]) && $contact["email"] != ""){
                    $contactModel->email = $contact["email"];   
                }
                if (isset($contact["job"]) && $contact["job"] != ""){
                    $contactModel->job = $contact["job"];   
                }

                $contactModel->validate();

                if (isset($contact["ContactPersonPhone"])){
                    foreach($contact["ContactPersonPhone"] as $phone){
                        $contactPhone = new ContactPersonPhone();
                        if (isset($phone["phonetypeid"]) && $phone["phonetypeid"] != ""){
                            $contactPhone->phonetypeid = $phone["phonetypeid"];
                        }
                        if (isset($phone["phone"]) && $phone["phone"] != ""){
                            $contactPhone->phone = $phone["phone"];
                        }
                        
                        $contactPhone->validate();
                        $contactModel->phones[] = $contactPhone;
                    }    
                }else{
                    $phone = new ContactPersonPhone();
                    $phone->validate();
                    $contactModel->phones[] = $phone;
                    $flag = false;
                }

                $contacts[] = $contactModel;
            }

            if (!$flag){
                $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                return $this->render('create', [
                    'model' => $model,
                    'index' => $index,
                    'indexPhone' => $indexPhone,
                    'contacts' => $contacts,
                ]);   
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $transaction->rollBack();
                $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                return $this->render('create', [
                    'model' => $model,
                    'index' => $index,
                    'indexPhone' => $indexPhone,
                    'contacts' => $contacts,
                ]);    
            }
            foreach($contacts as $contact){
                $contact->customerid = $model->customerid;
                $contact->userin = Yii::$app->user->identity->username;
                $contact->datein = new \yii\db\Expression('NOW()');

                if (!$contact->save()){
                    $transaction->rollBack();
                    $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                    return $this->render('create', [
                        'model' => $model,
                        'index' => $index,
                        'indexPhone' => $indexPhone,
                        'contacts' => $contacts,
                    ]);
                }

                foreach($contact->phones as $phone){
                    $phone->contactpersonid = $contact->contactpersonid;
                    $phone->userin = Yii::$app->user->identity->username;
                    $phone->datein = new \yii\db\Expression('NOW()');

                    if (!$phone->save()){
                        $transaction->rollBack();
                        $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                        return $this->render('create', [
                            'model' => $model,
                            'index' => $index,
                            'indexPhone' => $indexPhone,
                            'contacts' => $contacts,
                        ]);
                    }
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->customerid]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'index' => $index,
                'indexPhone' => $indexPhone,
                'contacts' => $contacts,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contacts = null;
        $index = 1;
        $indexPhone = 1;

        //initial user change & date
        $model->userup = Yii::$app->user->identity->username;
        $model->dateup = new \yii\db\Expression('NOW()');

        $flag = true;

        if ($model->load(Yii::$app->request->post())) {
            $model->dayofjoin = date("Y-m-d", strtotime($model->dayofjoin));
            
            if (isset($_POST["ContactPerson"])){
                $contactPerson = $_POST["ContactPerson"];   
            }
            else{
                $contactPerson = [];
                $contact = new ContactPerson(); 
                $contact->validate();
                $phone = new ContactPersonPhone();
                $phone->validate();
                $contact->phones[] = $phone;
                $contacts[] = $contact;
                $flag = false;
            }

            $arrContactId = [];
            $arrContactPhoneId = [];
            foreach($contactPerson as $contact){
                $contactModel = new ContactPerson();
                if (isset($contact["name"]) && $contact["name"] != ""){
                    $contactModel->name = $contact["name"];   
                }
                if (isset($contact["email"]) && $contact["email"] != ""){
                    $contactModel->email = $contact["email"];   
                }
                if (isset($contact["job"]) && $contact["job"] != ""){
                    $contactModel->job = $contact["job"];   
                }
                if (isset($contact["contactpersonid"]) && $contact["contactpersonid"] != ""){
                    $contactModel->contactpersonid = $contact["contactpersonid"];   
                    $arrContactId[] = $contactModel->contactpersonid;
                }
                
                if (!$contactModel->validate()){
                    $flag = false;
                }

                if (isset($contact["ContactPersonPhone"])){
                    foreach($contact["ContactPersonPhone"] as $phone){
                        $contactPhone = new ContactPersonPhone();
                        if (isset($phone["contactpersonphoneid"]) && $phone["contactpersonphoneid"] != ""){
                            $contactPhone->contactpersonphoneid = $phone["contactpersonphoneid"];
                            $arrContactPhoneId[] = $contactPhone->contactpersonphoneid;
                        }
                        if (isset($phone["phonetypeid"]) && $phone["phonetypeid"] != ""){
                            $contactPhone->phonetypeid = $phone["phonetypeid"];
                        }
                        if (isset($phone["phone"]) && $phone["phone"] != ""){
                            $contactPhone->phone = $phone["phone"];
                        }
                        if (!$contactPhone->validate()){
                            $flag = false;
                        }

                        $contactModel->phones[] = $contactPhone;
                    }    
                }else{
                    $phone = new ContactPersonPhone();
                    $phone->validate();
                    $contactModel->phones[] = $phone;
                    $flag = false;
                }
                
                $contacts[] = $contactModel;
            }
            if (!$flag){
                return $this->render('update', [
                    'model' => $model,
                    'index' => $index,
                    'indexPhone' => $indexPhone,
                    'contacts' => $contacts,
                ]);   
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            if (!$model->save()){
                $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                return $this->render('update', [
                    'model' => $model,
                    'index' => $index,
                    'indexPhone' => $indexPhone,
                    'contacts' => $contacts,
                ]);    
            }

            $deleteContact = ContactPerson::find()->where('customerid = :1', [':1'=>$model->customerid])->all();
            foreach($deleteContact as $contact){
                if (!in_array($contact->contactpersonid, $arrContactId)){
                    ContactPersonPhone::deleteAll('contactpersonid = :1', [':1'=>$contact->contactpersonid]);
                    ContactPerson::deleteAll('contactpersonid = :1', [':1'=>$contact->contactpersonid]);
                }else{
                    foreach($contact->contactpersonphones as $phoneDelete){
                        if (!in_array($phoneDelete->contactpersonphoneid, $arrContactPhoneId)){
                            ContactPersonPhone::deleteAll('contactpersonphoneid = :1', [':1'=>$phoneDelete->contactpersonphoneid]);
                        }
                    }
                }
            }

            foreach($contacts as $contact){
                $contact->customerid = $model->customerid;
                if (isset($contact->contactpersonid) && $contact->contactpersonid != null && $contact->contactpersonid != ""){
                    $modelContact = ContactPerson::findOne($contact->contactpersonid);   
                    $modelContact->name = $contact->name;
                    $modelContact->email = $contact->email;
                    $modelContact->job = $contact->job;
                    $modelContact->customerid = $contact->customerid;

                    if (!$modelContact->save()){
                        $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                        return $this->render('update', [
                            'model' => $model,
                            'index' => $index,
                            'indexPhone' => $indexPhone,
                            'contacts' => $contacts,
                        ]);
                    }

                }else if (!$contact->save()){
                    $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                    return $this->render('update', [
                        'model' => $model,
                        'index' => $index,
                        'indexPhone' => $indexPhone,
                        'contacts' => $contacts,
                    ]);
                }

                foreach($contact->phones as $phone){
                    if ($phone->contactpersonphoneid != null && $phone->contactpersonphoneid != ""){
                        $model_phone = ContactPersonPhone::findOne($phone->contactpersonphoneid);
                        $model_phone->contactpersonid = $contact->contactpersonid;
                        $model_phone->phonetypeid = $phone->phonetypeid;
                        $model_phone->phone = $phone->phone;
                        $model_phone->userup = Yii::$app->user->identity->username;
                        $model_phone->dateup = new \yii\db\Expression('NOW()');
                        
                        if (!$model_phone->save()){
                            $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                            return $this->render('update', [
                                'model' => $model,
                                'index' => $index,
                                'indexPhone' => $indexPhone,
                                'contacts' => $contacts,
                            ]);
                        }   
                    }else{
                        $phone->contactpersonid = $contact->contactpersonid;
                        $phone->userin = Yii::$app->user->identity->username;
                        $phone->datein = new \yii\db\Expression('NOW()');

                        if (!$phone->save()){
                            $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
                            return $this->render('update', [
                                'model' => $model,
                                'index' => $index,
                                'indexPhone' => $indexPhone,
                                'contacts' => $contacts,
                            ]);
                        }   
                    }
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->customerid]);

        } else {

            $contactModel = ContactPerson::find()->where('customerid = :1', [':1'=>$model->customerid])->all();
            foreach($contactModel as $contact){                
                $phoneModel = ContactPersonPhone::find()->where('contactpersonid = :1', [':1'=>$contact->contactpersonid])->all();
                foreach($phoneModel as $phone){
                    $contact->phones[] = $phone;
                }

                $contacts[] = $contact;
            }

            $model->dayofjoin = date("d-M-Y", strtotime($model->dayofjoin));
            return $this->render('update', [
                'model' => $model,
                'index' => $index,
                'indexPhone' => $indexPhone,
                'contacts' => $contacts,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRenderContact($index)
    {
        $model = new ContactPerson;
        return $this->renderAjax('contact/_form', array(
            'model' => $model,
            'index' => $index,
        ));
    }

    public function actionRenderContactPhone($index, $target)
    {
        $model = new ContactPersonPhone;
        return $this->renderAjax('phone/_form', array(
            'model' => $model,
            'index' => $index,
            'target' => $target,
        ));
    }
}

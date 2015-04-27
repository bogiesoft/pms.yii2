<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\IntSurvey;
use app\models\FinalizationProject;
use app\models\ProjectSearch;
use app\models\SharingValueUnit;
use app\models\SharingValueDepartment;
use app\models\SharingValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * SharingValueController implements the CRUD actions for SharingValueDepartment model.
 */
class SharingValueController extends Controller
{
    private $accessid = "SHARING-VALUE";

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
     * Lists all SharingValueDepartment models.
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
     * Displays a single SharingValueDepartment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($projectid)
    {
        $this->validateProject($projectid);
        return $this->render('view', [
            'model' => $this->findModel($projectid),
        ]);
    }

    /**
     * Creates a new SharingValueDepartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($projectid)
    {
        $model = Project::findOne($projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        $model_finalization = new FinalizationProject();
        $intsurveys = null;
        $units = null;
        $departments = null;

        if ($model->load(Yii::$app->request->post())) {
            $flag = true;

            $arrDuplicate = [];

            if (isset($_POST["SharingValueUnit"])){
                foreach($_POST["SharingValueUnit"] as $sharing_unit){

                    $model_unit = new SharingValueUnit();
                    
                    if (isset($sharing_unit["unitid"]) && $sharing_unit["unitid"] != ""){
                        $model_unit->unitid = $sharing_unit["unitid"];   
                    }
                    if (isset($sharing_unit["value"]) && $sharing_unit["value"] != ""){
                        $model_unit->value = $sharing_unit["value"];   
                    }
                    if (isset($sharing_unit["cost"]) && $sharing_unit["cost"] != ""){
                        $model_unit->cost = $sharing_unit["cost"];   
                    }
                    $units[] = $model_unit;
                    if (in_array($model_unit->unitid, $arrDuplicate)){
                        $model_unit->addError('unitid', 'Duplicate unit on sharing value unit');
                        $flag = false;
                    }else{
                        $arrDuplicate[] = $model_unit->unitid;
                    }
                }
            }else{
                $sharing_unit = new SharingValueUnit();
                $sharing_unit->validate();
                $units[] = $sharing_unit;
                $flag = false;
            }

            $arrDuplicate = [];

            if (isset($_POST["SharingValueDepartment"])){
                foreach($_POST["SharingValueDepartment"] as $sharing_department){

                    $model_department = new SharingValueDepartment();
                    
                    if (isset($sharing_department["departmentid"]) && $sharing_department["departmentid"] != ""){
                        $model_department->departmentid = $sharing_department["departmentid"];   
                    }
                    if (isset($sharing_department["value"]) && $sharing_department["value"] != ""){
                        $model_department->value = $sharing_department["value"];   
                    }
                    if (isset($sharing_department["cost"]) && $sharing_department["cost"] != ""){
                        $model_department->cost = $sharing_department["cost"];   
                    }
                    $departments[] = $model_department;

                    if (in_array($model_department->departmentid, $arrDuplicate)){
                        $model_department->addError('departmentid', 'Duplicate department on sharing value deparment');
                        $flag = false;
                    }else{
                        $arrDuplicate[] = $model_department->departmentid;
                    }
                }
            }else{
                $sharing_department = new SharingValueDepartment();
                $sharing_department->validate();
                $departments[] = $sharing_department;
                $flag = false;
            }

            $arrDuplicate = [];

            if (isset($_POST["IntSurvey"])){
                foreach($_POST["IntSurvey"] as $int_survey){

                    $model_intsurvey = new IntSurvey();
                    
                    if (isset($int_survey["consultantid"]) && $int_survey["consultantid"] != ""){
                        $model_intsurvey->consultantid = $int_survey["consultantid"];   
                        if (in_array($model_intsurvey->consultantid, $arrDuplicate)){
                            $model_intsurvey->addError('consultantid', 'Duplicate consultant on internal survey');
                            $flag = false;
                        }else{
                            $arrDuplicate[] = $model_intsurvey->consultantid;
                        }
                    }
                    if (isset($int_survey["score"]) && $int_survey["score"] != ""){
                        $model_intsurvey->score = $int_survey["score"];   
                    }
                    $intsurveys[] = $model_intsurvey;
                }
            }else{
                $model_intsurvey = new IntSurvey();
                $model_intsurvey->validate();
                $intsurveys[] = $model_intsurvey;
                $flag = false;
            }

        if (isset($_POST["FinalizationProject"])){
            if (isset($_POST["FinalizationProject"]["finalizationprojectid"]) && $_POST["FinalizationProject"]["finalizationprojectid"] != ""){
                $model_finalization = FinalizationProject::findOne($_POST["FinalizationProject"]["finalizationprojectid"]);
            }
            if (isset($_POST["FinalizationProject"]["remark"]) && $_POST["FinalizationProject"]["remark"] != ""){
                $model_finalization->remark = $_POST["FinalizationProject"]["remark"];   
            }else{
                $model_finalization->remark = null;
            }
            if (isset($_POST["FinalizationProject"]["intsurveyscore"]) && $_POST["FinalizationProject"]["intsurveyscore"] != ""){
                $model_finalization->intsurveyscore = $_POST["FinalizationProject"]["intsurveyscore"];   
            }else{
                $model_finalization->intsurveyscore = null;
            }
            if (isset($_POST["FinalizationProject"]["extsurveyscore"]) && $_POST["FinalizationProject"]["extsurveyscore"] != ""){
                $model_finalization->extsurveyscore = $_POST["FinalizationProject"]["extsurveyscore"];   
            }else{
                $model_finalization->extsurveyscore = null;
            }
            if (isset($_POST["FinalizationProject"]["postingdate"]) && $_POST["FinalizationProject"]["postingdate"] != ""){
                $model_finalization->postingdate = $_POST["FinalizationProject"]["postingdate"];
            }else{
                $model_finalization->postingdate = null;
            }
            if (isset($_POST["FinalizationProject"]["link"]) && $_POST["FinalizationProject"]["link"] != ""){
                $model_finalization->link = $_POST["FinalizationProject"]["link"];
            }else{
                $model_finalization->link = null;
            }
             if (isset($_POST["FinalizationProject"]["customerpic"]) && $_POST["FinalizationProject"]["customerpic"] != ""){
                $model_finalization->customerpic = $_POST["FinalizationProject"]["customerpic"];
            }else{
                $model_finalization->customerpic = null;
            }
            if (isset($_POST["FinalizationProject"]["file"]) && $_POST["FinalizationProject"]["file"] != ""){
                $model_finalization->file = $_POST["FinalizationProject"]["file"];   
            }else{
                $model_finalization->file = null;
            }       
        }

            if (!$flag){
                return $this->render('create', [
                    'model' => $model,
                    'units' => $units,
                    'departments' => $departments,
                    'intsurveys' => $intsurveys,
                    'model_finalization' => $model_finalization,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            foreach($units as $unit_model){
                $unit_model->projectid = $model->projectid;
                $unit_model->userin = Yii::$app->user->identity->username;
                $unit_model->datein = new \yii\db\Expression('NOW()');

                if (!$unit_model->save()){
                    $transaction->rollBack();
                               
                    return $this->render('create', [
                        'model' => $model,
                        'units' => $units,
                        'departments' => $departments,
                        'intsurveys' => $intsurveys,
                        'model_finalization' => $model_finalization,
                    ]);
                }
            }

            foreach($departments as $department_model){
                $department_model->projectid = $model->projectid;
                $department_model->userin = Yii::$app->user->identity->username;
                $department_model->datein = new \yii\db\Expression('NOW()');

                if (!$department_model->save()){
                    $transaction->rollBack();
                               
                    return $this->render('create', [
                        'model' => $model,
                        'units' => $units,
                        'departments' => $departments,
                        'intsurveys' => $intsurveys,
                        'model_finalization' => $model_finalization,
                    ]);
                }
            }

            foreach($intsurveys as $intsurvey_model){
                if ($intsurvey_model->consultantid != null || $intsurvey_model->score != null){
                    $intsurvey_model->projectid = $model->projectid;
                    $intsurvey_model->userin = Yii::$app->user->identity->username;
                    $intsurvey_model->datein = new \yii\db\Expression('NOW()');

                    if (!$intsurvey_model->save()){
                        $transaction->rollBack();
                                   
                        return $this->render('create', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                            'intsurveys' => $intsurveys,
                            'model_finalization' => $model_finalization,
                        ]);
                    }
                }
            }
            
            $file1 = UploadedFile::getInstance($model_finalization, 'file');

            if ($file1 != null){
                date_default_timezone_set('Asia/Jakarta');
                $model_finalization->filename = str_replace('/', '.', $model->code).'_'.date('d.M.Y').'_'.date('His').'_'.'Finalization'. '.' . $file1->extension;
                $model_finalization->filename = strtoupper($model_finalization->filename);
                $model_finalization->file = $file1;
            }

            $model_finalization->projectid = $model->projectid;
            if ($model_finalization->postingdate != null){
                $model_finalization->postingdate = date('Y-m-d', strtotime($model_finalization->postingdate));   
            }

            if (!$model_finalization->save()){
                $model_finalization->postingdate = date('d-M-Y', strtotime($model_finalization->postingdate));   
                $transaction->rollBack();
                                                   
                return $this->render('update', [
                    'model' => $model,
                    'units' => $units,
                    'departments' => $departments,
                    'intsurveys' => $intsurveys,
                    'model_finalization' => $model_finalization,
                ]);
            }

            if ($model_finalization->file != null && $model_finalization->file != "")
            {
                $model_finalization->file->saveAs('uploads/' . $model_finalization->filename); 
            }     

            $model->setProjectStatus();

            $transaction->commit();

            return $this->redirect(['view', 'projectid' => $model->projectid]);
        } else {

            $model_unit = new SharingValueUnit();
            $model_unit->unitid = $model->unitid;
            $model_unit->value = 0;
            $units[] = $model_unit;

            $sql = "select distinct ps_intagreement.* from ps_project
                    join ps_extagreement on ps_project.projectid = ps_extagreement.projectid
                    join ps_intagreement on ps_extagreement.extagreementid = ps_intagreement.extagreementid
                    where ps_project.projectid = :1";

            $model_intagreement = \app\models\IntAgreement::findBySql($sql, [':1'=>$projectid])->all();
            $tempArr = [];
            foreach($model_intagreement as $intagreement){
                if (!in_array($intagreement->departmentid, $tempArr)){
                    $model_department = new SharingValueDepartment();
                    $model_department->departmentid = $intagreement->departmentid;
                    $model_department->value = 0;
                    $departments[] = $model_department;
                    $tempArr[] = $intagreement->departmentid;   
                }
            }

            return $this->render('create', [
                'model' => $model,
                'units' => $units,
                'departments' => $departments,
                'intsurveys' => $intsurveys,
                'model_finalization' => $model_finalization,
            ]);
        }
    }

    /**
     * Updates an existing SharingValueDepartment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($projectid)
    {
        $model = $this->findModel($projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        $model_finalization = new FinalizationProject();
        $units = null;
        $departments = null;
        $intsurveys = null;

        if ($model->load(Yii::$app->request->post())) {
            $flag = true;
            $arrUnitId = [];
            $arrDepartmentId = [];
            $arrIntSurveyId = [];

            $arrDuplicate = [];

            if (isset($_POST["SharingValueUnit"])){
                foreach($_POST["SharingValueUnit"] as $sharing_unit){

                    $model_unit = new SharingValueUnit();
                    if (isset($sharing_unit["unitid"]) && $sharing_unit["unitid"] != ""){
                        $model_unit->unitid = $sharing_unit["unitid"];   
                    }
                    if (isset($sharing_unit["sharingvalueunitid"]) && $sharing_unit["sharingvalueunitid"] != ""){
                        $model_unit->sharingvalueunitid = $sharing_unit["sharingvalueunitid"];   
                        $arrUnitId[] = $model_unit->sharingvalueunitid;
                    }
                    if (isset($sharing_unit["value"]) && $sharing_unit["value"] != ""){
                        $model_unit->value = $sharing_unit["value"];   
                    }
                    if (isset($sharing_unit["cost"]) && $sharing_unit["cost"] != ""){
                        $model_unit->cost = $sharing_unit["cost"];   
                    }
                    $units[] = $model_unit;

                    if (in_array($model_unit->unitid, $arrDuplicate)){
                        $model_unit->addError('unitid', 'Duplicate unit on sharing value unit');
                        $flag = false;
                    }else{
                        $arrDuplicate[] = $model_unit->unitid;
                    }
                }
            }else{
                $sharing_unit = new SharingValueUnit();
                $sharing_unit->validate();
                $units[] = $sharing_unit;
                $flag = false;
            }

            $arrDuplicate = [];

            if (isset($_POST["SharingValueDepartment"])){
                foreach($_POST["SharingValueDepartment"] as $sharing_department){

                    $model_department = new SharingValueDepartment();
                    
                    if (isset($sharing_department["sharingvaluedepartmentid"]) && $sharing_department["sharingvaluedepartmentid"] != ""){
                        $model_department->sharingvaluedepartmentid = $sharing_department["sharingvaluedepartmentid"];   
                        $arrDepartmentId[] = $model_department->sharingvaluedepartmentid;
                    }
                    if (isset($sharing_department["departmentid"]) && $sharing_department["departmentid"] != ""){
                        $model_department->departmentid = $sharing_department["departmentid"];   
                    }
                    if (isset($sharing_department["value"]) && $sharing_department["value"] != ""){
                        $model_department->value = $sharing_department["value"];   
                    }
                    if (isset($sharing_department["cost"]) && $sharing_department["cost"] != ""){
                        $model_department->cost = $sharing_department["cost"];   
                    }
                    $departments[] = $model_department;

                    if (in_array($model_department->departmentid, $arrDuplicate)){
                        $model_department->addError('departmentid', 'Duplicate department on sharing value deparment');
                        $flag = false;
                    }else{
                        $arrDuplicate[] = $model_department->departmentid;
                    }
                }
            }else{
                $sharing_department = new SharingValueDepartment();
                $sharing_department->validate();
                $departments[] = $sharing_department;
                $flag = false;
            }

            $arrDuplicate = [];

            if (isset($_POST["IntSurvey"])){
                foreach($_POST["IntSurvey"] as $int_survey){

                    $model_intsurvey = new IntSurvey();
                    
                    if (isset($int_survey["intsurveryid"]) && $int_survey["intsurveryid"] != ""){
                        $model_intsurvey->intsurveryid = $int_survey["intsurveryid"];   
                        $arrIntSurveyId[] = $model_intsurvey->intsurveryid;
                    }
                    if (isset($int_survey["consultantid"]) && $int_survey["consultantid"] != ""){
                        $model_intsurvey->consultantid = $int_survey["consultantid"];   
                        if (in_array($model_intsurvey->consultantid, $arrDuplicate)){
                            $model_intsurvey->addError('consultantid', 'Duplicate consultant on internal survey');
                            $flag = false;
                        }else{
                            $arrDuplicate[] = $model_intsurvey->consultantid;
                        }
                    }else{
                        $model_intsurvey->addError('consultantid', 'Consultant cannot be blank.');
                        $flag = false;
                    }
                    if (isset($int_survey["score"]) && $int_survey["score"] != ""){
                        $model_intsurvey->score = $int_survey["score"];   
                    }
                    $intsurveys[] = $model_intsurvey;
                }
            }else{
                $model_intsurvey = new IntSurvey();
                $model_intsurvey->validate();
                $intsurveys[] = $model_intsurvey;
                $flag = false;
            }

        if (isset($_POST["FinalizationProject"])){
            if (isset($_POST["FinalizationProject"]["finalizationprojectid"]) && $_POST["FinalizationProject"]["finalizationprojectid"] != ""){
                $model_finalization = FinalizationProject::findOne($_POST["FinalizationProject"]["finalizationprojectid"]);
            }
            if (isset($_POST["FinalizationProject"]["remark"]) && $_POST["FinalizationProject"]["remark"] != ""){
                $model_finalization->remark = $_POST["FinalizationProject"]["remark"];   
            }else{
                $model_finalization->remark = null;
            }
            if (isset($_POST["FinalizationProject"]["intsurveyscore"]) && $_POST["FinalizationProject"]["intsurveyscore"] != ""){
                $model_finalization->intsurveyscore = $_POST["FinalizationProject"]["intsurveyscore"];   
            }else{
                $model_finalization->intsurveyscore = null;
            }
            if (isset($_POST["FinalizationProject"]["extsurveyscore"]) && $_POST["FinalizationProject"]["extsurveyscore"] != ""){
                $model_finalization->extsurveyscore = $_POST["FinalizationProject"]["extsurveyscore"];   
            }else{
                $model_finalization->extsurveyscore = null;
            }
            if (isset($_POST["FinalizationProject"]["postingdate"]) && $_POST["FinalizationProject"]["postingdate"] != ""){
                $model_finalization->postingdate = $_POST["FinalizationProject"]["postingdate"];
            }else{
                $model_finalization->postingdate = null;
            }
            if (isset($_POST["FinalizationProject"]["link"]) && $_POST["FinalizationProject"]["link"] != ""){
                $model_finalization->link = $_POST["FinalizationProject"]["link"];
            }else{
                $model_finalization->link = null;
            }
            if (isset($_POST["FinalizationProject"]["customerpic"]) && $_POST["FinalizationProject"]["customerpic"] != ""){
                $model_finalization->customerpic = $_POST["FinalizationProject"]["customerpic"];
            }else{
                $model_finalization->customerpic = null;
            }
            if (isset($_POST["FinalizationProject"]["file"]) && $_POST["FinalizationProject"]["file"] != ""){
                $model_finalization->file = $_POST["FinalizationProject"]["file"];   
            }else{
                $model_finalization->file = null;
            }       
        }

            if (!$flag){
                return $this->render('update', [
                    'model' => $model,
                    'units' => $units,
                    'departments' => $departments,
                    'intsurveys' => $intsurveys,
                    'model_finalization' => $model_finalization,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            $deleteUnit = SharingValueUnit::find()->where('projectid = :1', [':1'=>$model->projectid])->all();
            foreach($deleteUnit as $unit){
                if (!in_array($unit->sharingvalueunitid, $arrUnitId)){
                    SharingValueUnit::deleteAll('sharingvalueunitid = :1', [':1'=>$unit->sharingvalueunitid]);
                }
            }

            $deleteDepartment = SharingValueDepartment::find()->where('projectid = :1', [':1'=>$model->projectid])->all();
            foreach($deleteDepartment as $department){
                if (!in_array($department->sharingvaluedepartmentid, $arrDepartmentId)){
                    SharingValueDepartment::deleteAll('sharingvaluedepartmentid = :1', [':1'=>$department->sharingvaluedepartmentid]);
                }
            }

            $deleteIntSurvey = IntSurvey::find()->where('projectid = :1', [':1'=>$model->projectid])->all();
            foreach($deleteIntSurvey as $intsurvey){
                if (!in_array($intsurvey->intsurveryid, $arrIntSurveyId)){
                    IntSurvey::deleteAll('intsurveryid = :1', [':1'=>$intsurvey->intsurveryid]);
                }
            }

            foreach($units as $unit_model){
                if (isset($unit_model->sharingvalueunitid) && $unit_model->sharingvalueunitid != null && $unit_model->sharingvalueunitid != "")
                {         
                    $model_unit = SharingValueUnit::findOne($unit_model->sharingvalueunitid);
                    $model_unit->projectid = $model->projectid;
                    $model_unit->value = $unit_model->value;
                    $model_unit->cost = $unit_model->cost;
                    $model_unit->unitid = $unit_model->unitid;
                    $model_unit->userup = Yii::$app->user->identity->username;
                    $model_unit->dateup = new \yii\db\Expression('NOW()');

                    //var_dump($model_unit);
                    
                    if (!$model_unit->save()){
                        $transaction->rollBack();
                                                           
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                            'intsurveys' => $intsurveys,
                            'model_finalization' => $model_finalization,
                        ]);
                    }
                }else {
                    $unit_model->projectid = $model->projectid;
                    $unit_model->userin = Yii::$app->user->identity->username;
                    $unit_model->datein = new \yii\db\Expression('NOW()');

                    if (!$unit_model->save()){
                        $transaction->rollBack();
                                   
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                            'intsurveys' => $intsurveys,
                            'model_finalization' => $model_finalization,
                        ]);
                    }
                }
            }

            foreach($departments as $department_model){
                if (isset($department_model->sharingvaluedepartmentid) && $department_model->sharingvaluedepartmentid != null && 
                    $department_model->sharingvaluedepartmentid != "")
                {         
                    $model_department = SharingValueDepartment::findOne($department_model->sharingvaluedepartmentid);
                    $model_department->projectid = $model->projectid;
                    $model_department->value = $department_model->value;
                    $model_department->cost = $department_model->cost;
                    $model_department->departmentid = $department_model->departmentid;

                    $model_department->userup = Yii::$app->user->identity->username;
                    $model_department->dateup = new \yii\db\Expression('NOW()');
                    
                    if (!$model_department->save()){
                        $transaction->rollBack();
                                                           
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                            'intsurveys' => $intsurveys,
                            'model_finalization' => $model_finalization,
                        ]);
                    }
                }else {
                    $department_model->projectid = $model->projectid;
                    $department_model->userin = Yii::$app->user->identity->username;
                    $department_model->datein = new \yii\db\Expression('NOW()');

                    if (!$department_model->save()){
                        $transaction->rollBack();
                                   
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                            'intsurveys' => $intsurveys,
                            'model_finalization' => $model_finalization,
                        ]);
                    }
                }
            }

            foreach($intsurveys as $intsurvey_model){
                if (isset($intsurvey_model->intsurveryid) && $intsurvey_model->intsurveryid != null && 
                    $intsurvey_model->intsurveryid != "")
                {         
                    $model_intsurvey = IntSurvey::findOne($intsurvey_model->intsurveryid);
                    $model_intsurvey->projectid = $model->projectid;
                    $model_intsurvey->score = $intsurvey_model->score;
                    $model_intsurvey->consultantid = $intsurvey_model->consultantid;

                    $model_intsurvey->userup = Yii::$app->user->identity->username;
                    $model_intsurvey->dateup = new \yii\db\Expression('NOW()');
                    
                    if (!$model_intsurvey->save()){
                        $transaction->rollBack();
                                                           
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                            'intsurveys' => $intsurveys,
                            'model_finalization' => $model_finalization,
                        ]);
                    }
                }else {
                    if ($intsurvey_model->consultantid != null || $intsurvey_model->score != null){
                        $intsurvey_model->projectid = $model->projectid;
                        $intsurvey_model->userin = Yii::$app->user->identity->username;
                        $intsurvey_model->datein = new \yii\db\Expression('NOW()');

                        if (!$intsurvey_model->save()){
                            $transaction->rollBack();
                                       
                            return $this->render('update', [
                                'model' => $model,
                                'units' => $units,
                                'departments' => $departments,
                                'intsurveys' => $intsurveys,
                                'model_finalization' => $model_finalization,
                            ]);
                        }
                    }
                }
            }

            $file1 = UploadedFile::getInstance($model_finalization, 'file');

            if ($file1 != null){
                date_default_timezone_set('Asia/Jakarta');
                $model_finalization->filename = str_replace('/', '.', $model->code).'_'.date('d.M.Y').'_'.date('His').'_'.'Finalization'. '.' . $file1->extension;
                $model_finalization->filename = strtoupper($model_finalization->filename);
                $model_finalization->file = $file1;
            }

            $model_finalization->projectid = $model->projectid;
            if ($model_finalization->postingdate != null){
                $model_finalization->postingdate = date('Y-m-d', strtotime($model_finalization->postingdate));   
            }

            if (!$model_finalization->save()){
                $model_finalization->postingdate = date('d-M-Y', strtotime($model_finalization->postingdate));   
                $transaction->rollBack();
                                                   
                return $this->render('update', [
                    'model' => $model,
                    'units' => $units,
                    'departments' => $departments,
                    'intsurveys' => $intsurveys,
                    'model_finalization' => $model_finalization,
                ]);
            }

            if ($model_finalization->file != null && $model_finalization->file != "")
            {
                $model_finalization->file->saveAs('uploads/' . $model_finalization->filename); 
            }            

            $model->setProjectStatus();

            $transaction->commit();

            return $this->redirect(['view', 'projectid' => $model->projectid]);
        } else {
            if (isset($model->sharingvalueunits)){
                foreach($model->sharingvalueunits as $unit){
                    $units[] = $unit;
                }
            }

            if (isset($model->sharingvaluedepartments)){
                foreach($model->sharingvaluedepartments as $department){
                    $departments[] = $department;
                }
            }

            if (isset($model->intsurveys)){
                foreach($model->intsurveys as $intsurvey){
                    $intsurveys[] = $intsurvey;
                }
            }

            if ($model->finalizationprojects != null){
                $model_finalization = $model->finalizationprojects;
                if ($model_finalization->postingdate != null){
                    $model_finalization->postingdate = date('d-M-Y', strtotime($model_finalization->postingdate));   
                }
            }

            return $this->render('update', [
                'model' => $model,
                'units' => $units,
                'departments' => $departments,
                'intsurveys' => $intsurveys,
                'model_finalization' => $model_finalization,
            ]);
        }
    }

    /**
     * Deletes an existing SharingValueDepartment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteSharing($projectid)
    {
        $project = $this->findModel($projectid);
        $this->validateProject($projectid);
        $this->validateCancelProject($projectid);

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction(); 

        if (count($project->sharingvalueunits) > 0){
            SharingValueUnit::deleteAll('projectid = :1', [':1'=>$project->projectid]);
        }

        if (count($project->sharingvaluedepartments) > 0){
            SharingValueDepartment::deleteAll('projectid = :1', [':1'=>$project->projectid]);
        }

        if (count($project->finalizationprojects) > 0){
            FinalizationProject::deleteAll('projectid = :1', [':1'=>$project->projectid]);
        }

        if (count($project->intsurveys) > 0){
            IntSurvey::deleteAll('projectid = :1', [':1'=>$project->projectid]);
        }

        $project->setProjectStatus();

        $transaction->commit();

        return $this->redirect(['index', 'projectid'=>$projectid]);
    }

    /**
     * Finds the SharingValueDepartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SharingValueDepartment the loaded model
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

    public function actionRenderSharingUnit($index){
        $model = new SharingValueUnit();

        return $this->renderAjax('sharing-unit/_form', [
                'model'=>$model,
                'index'=>$index,                
            ]);
    }

    public function actionRenderSharingDepartment($index){
        $model = new SharingValueDepartment();

        return $this->renderAjax('sharing-department/_form', [
                'model'=>$model,
                'index'=>$index,                
            ]);
    }

    public function actionRenderIntSurvey($index, $projectid){
        $model = new IntSurvey();

        return $this->renderAjax('int-survey/_form', [
                'model'=>$model,
                'index'=>$index,
            ]);
    }


    public function validateCancelProject($projectid){
        $project = \app\models\Project::findOne($projectid);
        if (strpos(strtolower($project->status->name), 'cancel') !== false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function validateProject($projectid){
        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();

        $model_project = Project::find()->where(['in', 'unitid', $user->accessUnit])
                ->andWhere(['projectid'=>$projectid])
                ->one();

        if ($model_project !== null) {
            return $model_project;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

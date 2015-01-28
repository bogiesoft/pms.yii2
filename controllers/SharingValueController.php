<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\SharingValueUnit;
use app\models\SharingValueDepartment;
use app\models\SharingValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
        $model = Project::find()->where(['projectid'=>$projectid])->one();
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

            if (isset($_POST["SharingValueDepartment"])){
                foreach($_POST["SharingValueDepartment"] as $sharing_department){

                    $model_department = new SharingValueDepartment();
                    
                    if (isset($sharing_department["departmentid"]) && $sharing_department["departmentid"] != ""){
                        $model_department->departmentid = $sharing_department["departmentid"];   
                    }
                    if (isset($sharing_department["value"]) && $sharing_department["value"] != ""){
                        $model_department->value = $sharing_department["value"];   
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

            if (!$flag){
                return $this->render('create', [
                    'model' => $model,
                    'units' => $units,
                    'departments' => $departments,
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
                    ]);
                }
            }

            $transaction->commit();

            return $this->redirect(['view', 'projectid' => $model->projectid]);
        } else {

            $model_unit = new SharingValueUnit();
            $model_unit->unitid = $model->unitid;
            $model_unit->value = 0;
            $units[] = $model_unit;

            $sql = "select ps_intagreement.* from ps_project
                    left join ps_extagreement on ps_project.projectid = ps_extagreement.projectid
                    left join ps_intagreement on ps_extagreement.extagreementid = ps_intagreement.extagreementid
                    where ps_project.projectid = :1";

            $model_intagreement = \app\models\IntAgreement::findBySql($sql, [':1'=>$projectid])->all();
            foreach($model_intagreement as $intagreement){
                $model_department = new SharingValueDepartment();
                $model_department->departmentid = $intagreement->departmentid;
                $model_department->value = 0;
                $departments[] = $model_department;
            }

            return $this->render('create', [
                'model' => $model,
                'units' => $units,
                'departments' => $departments,
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
        $units = null;
        $departments = null;

        if ($model->load(Yii::$app->request->post())) {
            $flag = true;
            $arrUnitId = null;
            $arrDepartmentId = null;

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

            if (!$flag){
                return $this->render('update', [
                    'model' => $model,
                    'units' => $units,
                    'departments' => $departments,
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

            foreach($units as $unit_model){
                if (isset($unit_model->sharingvalueunitid) && $unit_model->sharingvalueunitid != null && $unit_model->sharingvalueunitid != "")
                {         
                    $model_unit = SharingValueUnit::findOne($unit_model->sharingvalueunitid);
                    $model_unit->projectid = $model->projectid;
                    $model_unit->value = $unit_model->value;
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
                        ]);
                    }
                }else {
                    $unit_model->projectid = $model->projectid;
                    $unit_model->userup = Yii::$app->user->identity->username;
                    $unit_model->dateup = new \yii\db\Expression('NOW()');

                    if (!$unit_model->save()){
                        $transaction->rollBack();
                                   
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
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
                    $model_department->departmentid = $department_model->departmentid;

                    $model_department->userup = Yii::$app->user->identity->username;
                    $model_department->dateup = new \yii\db\Expression('NOW()');
                    
                    if (!$model_department->save()){
                        $transaction->rollBack();
                                                           
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                        ]);
                    }
                }else {
                    $department_model->projectid = $model->projectid;
                    $department_model->userup = Yii::$app->user->identity->username;
                    $department_model->dateup = new \yii\db\Expression('NOW()');

                    if (!$department_model->save()){
                        $transaction->rollBack();
                                   
                        return $this->render('update', [
                            'model' => $model,
                            'units' => $units,
                            'departments' => $departments,
                        ]);
                    }
                }
            }

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

            return $this->render('update', [
                'model' => $model,
                'units' => $units,
                'departments' => $departments,
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

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction(); 

        if (count($project->sharingvalueunits) > 0){
            SharingValueUnit::deleteAll('projectid = :1', [':1'=>$project->projectid]);
        }

        if (count($project->sharingvaluedepartments) > 0){
            SharingValueDepartment::deleteAll('projectid = :1', [':1'=>$project->projectid]);
        }

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
}

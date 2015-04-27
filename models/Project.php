<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_project".
 *
 * @property integer $projectid
 * @property integer $unitid
 * @property string $code
 * @property string $name
 * @property integer $customerid
 * @property string $description
 * @property integer $producttypeid
 * @property string $initiationyear
 * @property integer $statusid
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 * @property string $cancelremark 
 *
 * @property PsBusinessassurance[] $psBusinessassurances
 * @property PsCostingapproval[] $psCostingapprovals
 * @property PsExtagreement[] $psExtagreements
 * @property PsFinalizationproject[] $psFinalizationprojects 
 * @property PsIntsurvey[] $psIntsurveys 
 * @property PsUnit $unit
 * @property PsCustomer $customer
 * @property PsStatus $status
 * @property PsProducttype $producttype
 * @property PsProjectpic[] $psProjectpics
 * @property PsProposal[] $psProposals
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unitid', 'code', 'name', 'customerid', 'producttypeid', 'initiationyear', 'statusid'], 'required'],
            [['unitid', 'customerid', 'producttypeid', 'statusid'], 'integer'],
            [['datein', 'dateup', 'initiationyear'], 'safe'], 
            [['code'], 'string', 'max' => 8],
            [['name', 'userin', 'userup'], 'string', 'max' => 50],
            [['description', 'cancelremark'], 'string', 'max' => 250],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectid' => 'Project',
            'unitid' => 'Unit',
            'code' => 'Code',
            'name' => 'Name',
            'customerid' => 'Customer',
            'description' => 'Description',
            'producttypeid' => 'Product Type',
            'initiationyear' => 'Initiation Date',
            'statusid' => 'Status',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
            'cancelremark' => 'Remarks', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessassurances()
    {
        return $this->hasMany(BusinessAssurance::className(), ['projectid' => 'projectid'])->orderBy('date desc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCostingapprovals()
    {
        return $this->hasMany(CostingApproval::className(), ['projectid' => 'projectid'])->orderBy('date desc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtagreements()
    {
        return $this->hasMany(ExtAgreement::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['unitid' => 'unitid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['statusid' => 'statusid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducttype()
    {
        return $this->hasOne(ProductType::className(), ['producttypeid' => 'producttypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectpic()
    {
        return $this->hasMany(ProjectPic::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProposal()
    {
        return $this->hasMany(Proposal::className(), ['projectid' => 'projectid'])->orderBy('date desc');
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIntsurveys()
    {
        return $this->hasMany(IntSurvey::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return [unit code] - [unit name]
     */
    public function getUnitDescr()
    {
        return $this->unit->code . ' - ' . $this->unit->Name;
    }

    /**
     * @return [producttype code] - [producttype name]
     */
    public function getProductTypeDescr()
    {
        return $this->producttype->code . ' - ' . $this->producttype->name;
    }
    
    /**
     * @return [extagreement code] - [extagreement name]
     */
    public function getExtAgreementDescr()
    {
        return $this->extagreements->agreementno . ' - ' . $this->extagreements->description;
    }

    public function setProjectStatus(){
        $this->userup = Yii::$app->user->identity->username;
        $this->dateup = new \yii\db\Expression('NOW()');

        if (count($this->proposal) == 0 && count($this->costingapprovals) == 0){
            $status = \app\models\Status::find()->where("name like '%potential%'")->one();
            $this->statusid = isset($status->statusid) ? $status->statusid : 0;
            $this->save();
            return true;
        }

        if (count($this->businessassurances) == 0){
            $status = \app\models\Status::find()->where("name like '%preparation%'")->one();
            $this->statusid = isset($status->statusid) ? $status->statusid : 0;
            $this->save();
            return true;
        }

        if (count($this->extagreements) == 0){
            $status = \app\models\Status::find()->where("name like '%Business%Assurance%'")->one();
            $this->statusid = isset($status->statusid) ? $status->statusid : 0;
            $this->save();
            return true;
        }

        $count_ext_payment = 0;
        foreach($this->extagreements as $agreement){
            foreach($agreement->extdeliverables as $deliverable){
                if (!isset($deliverable->extagreementpayments) || $deliverable->extagreementpayments->date == null ||
                    $deliverable->extagreementpayments->date == ""){
                    
                    $count_ext_payment++;
                }
            }
        }

        if ($count_ext_payment > 0){
            $status = \app\models\Status::find()->where("name like '%in%progress%'")->one();
            $this->statusid = isset($status->statusid) ? $status->statusid : 0;
            $this->save();
            return true;   
        }

        if (!isset($this->finalizationprojects) ||
            $this->finalizationprojects->filename == null || 
            $this->finalizationprojects->filename == "" || 
            $this->finalizationprojects->remark == null || 
            $this->finalizationprojects->remark == "" || 
            $this->finalizationprojects->intsurveyscore == null || 
            $this->finalizationprojects->intsurveyscore == "" || 
            $this->finalizationprojects->extsurveyscore == null || 
            $this->finalizationprojects->extsurveyscore == "" ||
            count($this->sharingvaluedepartments) < 1 || 
            count($this->sharingvalueunits) < 1
        ){
            $status = \app\models\Status::find()->where("name like '%finalization%'")->one();
            $this->statusid = isset($status->statusid) ? $status->statusid : 0;
            $this->save();
            return true;   
        }

        $status = \app\models\Status::find()->where("name like '%done%'")->one();
        $this->statusid = isset($status->statusid) ? $status->statusid : 0;
        $this->save();
        return true;
    }

    public function getInitiationyearformat(){
        if (isset($this->initiationyear) && $this->initiationyear != null && $this->initiationyear != ""){
            return date('d-M-Y', strtotime($this->initiationyear));
        }
        return null;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSharingvaluedepartments()
    {
        return $this->hasMany(SharingValueDepartment::className(), ['projectid' => 'projectid']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSharingvalueunits()
    {
        return $this->hasMany(SharingValueUnit::className(), ['projectid' => 'projectid']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getFinalizationprojects()
    {
        return $this->hasOne(FinalizationProject::className(), ['projectid' => 'projectid']);
    }

    public function getDownloadFile(){
        $index = 0;
        $arrFiles = [];
        foreach($this->proposal as $file){
            if(file_exists('./uploads/'.$file->filename)){
                if ($index == 0){
                    $arrFiles[] = ['Proposal/' . $file->filename, $file->filename];
                }else{
                    $arrFiles[] = ['Proposal/Revision/' . $file->filename, $file->filename];
                }
                $index++;
            }
        }

        $index = 0;
        foreach($this->costingapprovals as $file){
            if(file_exists('./uploads/'.$file->filename)){
                if ($index == 0){
                    $arrFiles[] = ['Costing Approval/' . $file->filename, $file->filename];
                }else{
                    $arrFiles[] = ['Costing Approval/Revision/' . $file->filename, $file->filename];
                }
                $index++;
            }
        }

        $index = 0;
        foreach($this->businessassurances as $file){
            if(file_exists('./uploads/'.$file->filename)){
                if ($index == 0){
                    $arrFiles[] = ['Business Assurance/' . $file->filename, $file->filename];
                }else{
                    $arrFiles[] = ['Business Assurance/Revision/' . $file->filename, $file->filename];
                }
                $index++;
            }
        }

        foreach($this->extagreements as $file){
            if(file_exists('./uploads/'.$file->filename)){
                $arrFiles[] = ['External Agreement/' . $file->filename, $file->filename];

                $sql = "select * from ps_extagreement_log
                        where extagreementid = :1 and action = 'U' and filename not like (
                            select filename from ps_extagreement where extagreementid = :1
                        )";
                $extagreement_log = ExtAgreement::findBySql($sql, [':1'=>$file->extagreementid])->all();
                foreach($extagreement_log as $file1){
                    if(file_exists('./uploads/'.$file1->filename)){
                        $arrFiles[] = ['External Agreement/Revision/' . $file1->filename, $file1->filename];
                    }
                }
            }

            foreach($file->intagreements as $file2){
                if(file_exists('./uploads/'.$file2->filename)){
                    $arrFiles[] = ['Internal Agreement/' . $file2->filename, $file2->filename];

                    $sql = "select * from ps_intagreement_log
                            where intagreementid = :1 and action = 'U' and filename not like (
                                select filename from ps_intagreement where intagreementid = :1
                            )";
                    $intagreement_log = ExtAgreement::findBySql($sql, [':1'=>$file2->intagreementid])->all();
                    foreach($intagreement_log as $file3){
                        if(file_exists('./uploads/'.$file3->filename)){
                            $arrFiles[] = ['Internal Agreement/Revision/' . $file3->filename, $file3->filename];
                        }
                    }
                }
            }
        }
        
        $file = $this->finalizationprojects;
        if(file_exists('./uploads/'.$file->filename)){
            $arrFiles[] = ['Finalization Project/' . $file->filename, $file->filename];

            $sql = "select * from ps_finalizationproject_log
                    where finalizationprojectid = :1 and action = 'U' and filename not like (
                        select filename from ps_finalizationproject where finalizationprojectid = :1
                    )";
            $log = FinalizationProject::findBySql($sql, [':1'=>$file->finalizationprojectid])->all();
            foreach($log as $file1){
                if(file_exists('./uploads/'.$file1->filename)){
                    $arrFiles[] = ['Finalization Project/Revision/' . $file1->filename, $file1->filename];
                }
            }
        }

        $files = array('Project.php');
        $filename = "./uploads/".str_replace('/', '.', $this->code)." ".$this->name.".zip";

        $zip = new \ZipArchive();        

        if(file_exists($filename)){
            unlink($filename);
        }

        if (!$zip->open($filename, \ZIPARCHIVE::CREATE)) {
            return null;
        }
        
        foreach($arrFiles as $file){
            $zip->addFile("./uploads/".$file[1], $file[0]);   
        }
        
        $zip->close();
        unset($zip);

        return $filename;
    }

    public function getInitiationdateformat(){
        if ($this->initiationyear != null && $this->initiationyear != ""){
            return date('d-M-Y', strtotime($this->initiationyear));
        }

        return null;
    }
}

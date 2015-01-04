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
 *
 * @property PsBusinessassurance[] $psBusinessassurances
 * @property PsCostingapproval[] $psCostingapprovals
 * @property PsExtagreement[] $psExtagreements
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
            [['unitid', 'customerid', 'producttypeid', 'statusid','initiationyear'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['code', 'initiationyear'], 'string', 'max' => 5],
            [['name', 'userin', 'userup'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectid' => 'ID',
            'unitid' => 'Unit',
            'code' => 'Code',
            'name' => 'Name',
            'customerid' => 'Customer',
            'description' => 'Description',
            'producttypeid' => 'Product Type',
            'initiationyear' => 'Initiation Year',
            'statusid' => 'Status',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessassurances()
    {
        return $this->hasMany(BusinessAssurance::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCostingapprovals()
    {
        return $this->hasMany(CostingApproval::className(), ['projectid' => 'projectid']);
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
        return $this->hasMany(Proposal::className(), ['projectid' => 'projectid']);
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
    
}

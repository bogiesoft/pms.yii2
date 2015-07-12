<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_intdeliverables".
 *
 * @property integer $intdeliverableid
 * @property integer $intagreementid
 * @property integer $extdeliverableid
 * @property integer $positionid
 * @property string $description
 * @property integer $frequency
 * @property integer $rateid
 * @property integer $rate
 * @property string $duedate 
 * @property string $deliverdate
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsIntagreementpayment[] $psIntagreementpayments 
 * @property PsIntagreement $intagreement
 * @property PsExtdeliverables $extdeliverable
 * @property PsConsultantposition $position
 * @property PsProjectrate $rate0
 */
class IntDeliverables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_intdeliverables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intagreementid', 'extdeliverableid', 'positionid', 'frequency', 'rateid', 'rate', 'description', 'duedate'], 'required'],
            [['intagreementid', 'extdeliverableid', 'positionid', 'rateid'], 'integer'],
            [['rate', 'frequency'], 'number'],
            [['datein', 'dateup', 'duedate', 'deliverdate'], 'safe'],
            [['description'], 'string', 'max' => 250],
            [['userin', 'userup'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intdeliverableid' => 'Intdeliverableid',
            'intagreementid' => 'Intagreementid',
            'extdeliverableid' => 'External Deliverable',
            'positionid' => 'Consultant Position',
            'description' => 'Deliverable Name',
            'frequency' => 'Frequency',
            'rateid' => 'Rate Unit',
            'rate' => 'Rate',
            'duedate' => 'Due Date', 
            'deliverdate' => 'Deliverable Date',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntagreement()
    {
        return $this->hasOne(IntAgreement::className(), ['intagreementid' => 'intagreementid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtdeliverables()
    {
        return $this->hasOne(ExtDeliverables::className(), ['extdeliverableid' => 'extdeliverableid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultantposition()
    {
        return $this->hasOne(ConsultantPosition::className(), ['positionid' => 'positionid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectrate()
    {
        return $this->hasOne(ProjectRate::className(), ['rateid' => 'rateid']);
    }

    public function getIntagreementpayments()
    {
        return $this->hasOne(IntAgreementPayment::className(), ['intdeliverableid' => 'intdeliverableid']);
    }

    public function getDeliverablenamewithcode(){
        return $this->description;
    }

    public function getDuedateformat(){
        return date('d-M-Y', strtotime($this->duedate));
    }

    public function getRateUnitDescr(){
        return $this->projectrate->role . ' (' . $this->projectrate->mindunit->name . ')';
    }

    public function getRateNumberFormat(){
        return number_format($this->rate);
    }

    public function getDeliverdateformat(){
        if ($this->deliverdate != null && $this->deliverdate != ""){
            return date('d-M-Y', strtotime($this->deliverdate));   
        }
        return null;
    }

    public function getPaymentdateformat(){
        if (isset($this->intagreementpayments->date) && $this->intagreementpayments->date != null && $this->intagreementpayments->date != ""){
            return date('d-M-Y', strtotime($this->intagreementpayments->date));   
        }
        return null;
    }
}

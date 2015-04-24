<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_extagreementpayment".
 *
 * @property integer $extagreementpaymentid
 * @property integer $extdeliverableid
 * @property string $date
 * @property string $remark
 * @property string $invoicedate 
 * @property string $sentdate 
 * @property string $invoicedeadline 
 * @property string $targetdate 
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsExtdeliverables $extdeliverable
 */
class ExtAgreementPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_extagreementpayment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extdeliverableid', 'date'], 'required'],
            [['extdeliverableid'], 'integer'],
            [['date', 'invoicedate', 'sentdate', 'invoicedeadline', 'targetdate', 'datein', 'dateup'], 'safe'],
            [['remark'], 'string', 'max' => 250],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'extagreementpaymentid' => 'Extagreementpaymentid',
            'extdeliverableid' => 'External Deliverable',
            'date' => 'Payment Date',
            'remark' => 'Remark',
            'invoicedate' => 'Invoice Date', 
            'sentdate' => 'Sent Date', 
            'invoicedeadline' => 'Invoice Deadline', 
            'targetdate' => 'Target Date', 
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtdeliverable()
    {
        return $this->hasOne(ExtDeliverables::className(), ['extdeliverableid' => 'extdeliverableid']);
    }

    public function getInvoiceDateFormat(){
        if ($this->invoicedate != null)
            return date('d-M-Y', strtotime($this->invoicedate));
        
        return null;
    }

    public function getSentDateFormat(){
        if ($this->sentdate != null)
            return date('d-M-Y', strtotime($this->sentdate));
        
        return null;
    }

    public function getInvoiceDeadlineFormat(){
        if ($this->invoicedeadline != null)
            return date('d-M-Y', strtotime($this->invoicedeadline));
        
        return null;
    }

    public function getTargetDateFormat(){
        if ($this->targetdate != null)
            return date('d-M-Y', strtotime($this->targetdate));
        
        return null;
    }

    public function getPaymentDateFormat(){
        if ($this->date != null)
            return date('d-M-Y', strtotime($this->date));
        
        return null;
    }
}

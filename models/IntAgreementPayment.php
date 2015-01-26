<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_intagreementpayment".
 *
 * @property integer $intagreementpaymentid
 * @property integer $intdeliverableid
 * @property string $date
 * @property string $remark
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsIntdeliverables $intdeliverable
 */
class IntAgreementPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_intagreementpayment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intdeliverableid', 'date'], 'required'],
            [['intdeliverableid'], 'integer'],
            [['date', 'datein', 'dateup'], 'safe'],
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
            'intagreementpaymentid' => 'Intagreementpaymentid',
            'intdeliverableid' => 'Internal Deliverable',
            'date' => 'Payment Date',
            'remark' => 'Remark',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntdeliverable()
    {
        return $this->hasOne(PsIntdeliverables::className(), ['intdeliverableid' => 'intdeliverableid']);
    }
}

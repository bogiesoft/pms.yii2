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
            'extagreementpaymentid' => 'Extagreementpaymentid',
            'extdeliverableid' => 'External Deliverable',
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
    public function getExtdeliverable()
    {
        return $this->hasOne(ExtDeliverables::className(), ['extdeliverableid' => 'extdeliverableid']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_consultantbank".
 *
 * @property integer $consultantbankid
 * @property integer $consultantid
 * @property integer $bankid
 * @property string $branch
 * @property string $account
 * @property string $active
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsConsultant $consultant
 * @property PsBank $bank
 */
class ConsultantBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_consultantbank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultantid', 'bankid', 'branch', 'account'], 'required'],
            [['consultantid', 'bankid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['branch', 'userin', 'userup'], 'string', 'max' => 50],
            [['account'], 'string', 'max' => 15],
            [['active'], 'string', 'max' => 1],
            [['consultantid', 'bankid', 'account'], 'unique', 'targetAttribute' => ['consultantid', 'bankid', 'account'], 'message' => 'The combination of Consultantid, Bankid and Account has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'consultantbankid' => 'Consultantbankid',
            'consultantid' => 'Consultantid',
            'bankid' => 'Bankid',
            'branch' => 'Branch',
            'account' => 'Account',
            'active' => 'Active',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(PsConsultant::className(), ['consultantid' => 'consultantid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(PsBank::className(), ['bankid' => 'bankid']);
    }
}

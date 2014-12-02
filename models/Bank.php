<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_bank".
 *
 * @property integer $bankid
 * @property string $code
 * @property string $name
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsConsultantbank[] $psConsultantbanks
 * @property PsUnit[] $psUnits
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['datein', 'dateup'], 'safe'],
            [['code'], 'string', 'max' => 5],
            [['name', 'userin', 'userup'], 'string', 'max' => 50],
            [['code', 'name'], 'unique', 'targetAttribute' => ['code', 'name'], 'message' => 'The combination of Code and Name has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bankid' => 'Bankid',
            'code' => 'Code',
            'name' => 'Name',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsConsultantbanks()
    {
        return $this->hasMany(PsConsultantbank::className(), ['bankid' => 'bankid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsUnits()
    {
        return $this->hasMany(PsUnit::className(), ['BankId' => 'bankid']);
    }
}

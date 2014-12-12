<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_unit".
 *
 * @property integer $unitid
 * @property string $code
 * @property string $Name
 * @property integer $BankId
 * @property string $BankAcc
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsGroupaccessdata[] $psGroupaccessdatas
 * @property PsProject[] $psProjects
 * @property PsBank $bank
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'Name', 'BankId', 'BankAcc'], 'required'],
            [['BankId'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['code'], 'string', 'max' => 5],
            [['Name', 'userin', 'userup'], 'string', 'max' => 50],
            [['BankAcc'], 'string', 'max' => 15],
            [['BankAcc'], 'integer'],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unitid' => 'ID',
            'code' => 'Code',
            'Name' => 'Name',
            'BankId' => 'Bank',
            'BankAcc' => 'Account',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsGroupaccessdatas()
    {
        return $this->hasMany(Groupaccessdata::className(), ['unitid' => 'unitid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsProjects()
    {
        return $this->hasMany(Project::className(), ['unitid' => 'unitid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['bankid' => 'BankId']);
    }

    /**
     * @return [bank code] - [bank name]
     */
    public function getBankDescr()
    {
        return $this->bank->code . ' - ' . $this->bank->name;
    }
}

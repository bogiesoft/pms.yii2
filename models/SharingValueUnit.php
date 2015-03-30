<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_sharingvalueunit".
 *
 * @property integer $sharingvalueunitid
 * @property integer $projectid
 * @property integer $unitid
 * @property integer $value
 * @property integer $cost
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 * @property PsUnit $unit
 */
class SharingValueUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_sharingvalueunit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'unitid', 'value'], 'required'],
            [['projectid', 'unitid'], 'integer'],
            [['value', 'cost'], 'number'],
            [['datein', 'dateup'], 'safe'],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sharingvalueunitid' => 'Sharing Value Unit',
            'projectid' => 'Project',
            'unitid' => 'Unit',
            'value' => 'Value',
            'cost' => 'Cost',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(PsProject::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['unitid' => 'unitid']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_projectrate".
 *
 * @property integer $rateid
 * @property string $role
 * @property integer $mindunitid
 * @property integer $rate
 * @property string $description
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsIntdeliverables[] $psIntdeliverables
 * @property PsMindunit $mindunit
 */
class ProjectRate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_projectrate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'mindunitid', 'rate'], 'required'],
            [['mindunitid', 'rate'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['role', 'userin', 'userup'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250],
            [['role', 'mindunitid'], 'unique', 'targetAttribute' => ['role', 'mindunitid'], 'message' => 'The combination of Role and Mindunitid has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rateid' => 'ID',
            'role' => 'Role',
            'mindunitid' => 'Mind unit',
            'rate' => 'Rate',
            'description' => 'Description',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsIntdeliverables()
    {
        return $this->hasMany(IntDeliverables::className(), ['rateid' => 'rateid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMindunit()
    {
        return $this->hasOne(MindUnit::className(), ['mindunitid' => 'mindunitid']);
    }

    public function getRateText(){
        return number_format($this->rate);
    }
    
}

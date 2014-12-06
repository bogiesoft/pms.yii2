<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_consultantposition".
 *
 * @property integer $positionid
 * @property string $name
 * @property string $description
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsIntdeliverables[] $psIntdeliverables
 */
class ConsultantPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_consultantposition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['datein', 'dateup'], 'safe'],
            [['name', 'userin', 'userup'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'positionid' => 'Positionid',
            'name' => 'Name',
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
        return $this->hasMany(IntDeliverables::className(), ['positionid' => 'positionid']);
    }
}

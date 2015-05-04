<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_mindunit".
 *
 * @property integer $mindunitid
 * @property string $name
 * @property string $description
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProjectrate[] $psProjectrates
 */
class MindUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_mindunit';
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
            'mindunitid' => 'Mindunitid',
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
    public function getProjectrates()
    {
        return $this->hasMany(Projectrate::className(), ['mindunitid' => 'mindunitid']);
    }
}

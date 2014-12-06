<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_status".
 *
 * @property integer $statusid
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject[] $psProjects
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statusid' => 'Statusid',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsProjects()
    {
        return $this->hasMany(Project::className(), ['statusid' => 'statusid']);
    }
}

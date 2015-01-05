<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_projectlog".
 *
 * @property integer $projectlogid
 * @property integer $projectid
 * @property string $date
 * @property string $remark
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 */
class ProjectLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_projectlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'date', 'remark'], 'required'],
            [['projectid'], 'integer'],
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
            'projectlogid' => 'Projectlogid',
            'projectid' => 'Projectid',
            'date' => 'Date',
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return [project code] - [project name]
     */
    public function getProjectDescr()
    {
        return $this->project->code . ' - ' . $this->project->name;
    }
}

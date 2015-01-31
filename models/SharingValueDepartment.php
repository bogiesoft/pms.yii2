<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_sharingvaluedepartment".
 *
 * @property integer $sharingvaluedepartmentid
 * @property integer $projectid
 * @property integer $departmentid
 * @property integer $value
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 * @property PsDepartment $department
 */
class SharingValueDepartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_sharingvaluedepartment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'departmentid', 'value'], 'required'],
            [['projectid', 'departmentid', 'value'], 'integer'],
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
            'sharingvaluedepartmentid' => 'Sharingvaluedepartmentid',
            'projectid' => 'Projectid',
            'departmentid' => 'Department',
            'value' => 'Value',
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
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['departmentid' => 'departmentid']);
    }
}

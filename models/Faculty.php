<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_faculty".
 *
 * @property integer $facultyid
 * @property string $code
 * @property string $name
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsDepartment[] $psDepartments
 */
class Faculty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_faculty';
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
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'facultyid' => 'Facultyid',
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
    public function getPsDepartments()
    {
        return $this->hasMany(Department::className(), ['facultyid' => 'facultyid']);
    }
}

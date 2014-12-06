<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_department".
 *
 * @property integer $departmentid
 * @property integer $facultyid
 * @property string $name
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsFaculty $faculty
 * @property PsIntagreement[] $psIntagreements
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facultyid', 'name'], 'required'],
            [['facultyid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['name', 'userin', 'userup'], 'string', 'max' => 50],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [            
            'departmentid' => 'Departmentid',
            'facultyid' => 'Facultyid',
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
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['facultyid' => 'facultyid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsIntagreements()
    {
        return $this->hasMany(IntAgreement::className(), ['departmentid' => 'departmentid']);
    }

    /**
     * @return [faculty code] - [faculty name]
     */
    public function getFacultyDescr()
    {
        return $this->faculty->code . ' - ' . $this->faculty->name;
    }
}

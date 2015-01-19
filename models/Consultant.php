<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_consultant".
 *
 * @property integer $consultantid
 * @property string $lectureid
 * @property string $employeeid
 * @property string $name
 * @property string $residentid
 * @property integer $categoryid
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsCategory $category
 * @property PsConsultantbank[] $psConsultantbanks
 * @property PsConsultantemail[] $psConsultantemails
 * @property PsConsultantphone[] $psConsultantphones
 * @property PsIntagreement[] $psIntagreements
 */
class Consultant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_consultant';
    }

    public $varCategory;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'residentid', 'categoryid'], 'required'],
            [['categoryid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['lectureid'], 'string', 'max' => 8],
            [['employeeid'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 150],
            [['residentid', 'userin', 'userup'], 'string', 'max' => 50],
            [['residentid'], 'unique'],
            [['lectureid'], 'unique'],
            [['employeeid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'consultantid' => 'Consultantid',
            'lectureid' => 'Lecturer ID',
            'employeeid' => 'Employee ID',
            'name' => 'Name',
            'residentid' => 'Resident ID',
            'categoryid' => 'Category',
            'varCategory' => 'Category',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['categoryid' => 'categoryid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultantbanks()
    {
        return $this->hasMany(ConsultantBank::className(), ['consultantid' => 'consultantid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultantemails()
    {
        return $this->hasMany(ConsultantEmail::className(), ['consultantid' => 'consultantid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultantphones()
    {
        return $this->hasMany(ConsultantPhone::className(), ['consultantid' => 'consultantid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntagreements()
    {
        return $this->hasMany(IntAgreement::className(), ['consultantid' => 'consultantid']);
    }
}

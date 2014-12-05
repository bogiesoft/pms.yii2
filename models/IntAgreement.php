<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_intagreement".
 *
 * @property integer $intagreementid
 * @property integer $extagreementid
 * @property integer $consultantid
 * @property integer $departmentid
 * @property string $description
 * @property string $startdate
 * @property string $enddate
 * @property string $filename
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsExtagreement $extagreement
 * @property PsConsultant $consultant
 * @property PsDepartment $department
 * @property PsIntdeliverables[] $psIntdeliverables
 */
class IntAgreement extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_intagreement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extagreementid', 'consultantid', 'departmentid', 'startdate', 'enddate', 'filename'], 'required'],
            [['extagreementid', 'consultantid', 'departmentid'], 'integer'],
            [['startdate', 'enddate', 'datein', 'dateup'], 'safe'],
            [['description', 'filename'], 'string', 'max' => 250],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['startdate','enddate'], 'string', 'max' => 250],        
            [['file'],'safe'],
            [['file'], 'file', 'skipOnEmpty' => false],
            [['file'], 'file', 'extensions' => 'doc, docx', 'mimeTypes' => 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intagreementid' => 'Intagreementid',
            'extagreementid' => 'Extagreementid',
            'consultantid' => 'Consultantid',
            'departmentid' => 'Departmentid',
            'description' => 'Description',
            'startdate' => 'Startdate',
            'enddate' => 'Enddate',
            'filename' => 'Filename',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtagreement()
    {
        return $this->hasOne(ExtAgreement::className(), ['extagreementid' => 'extagreementid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultantid' => 'consultantid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['departmentid' => 'departmentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsIntdeliverables()
    {
        return $this->hasMany(IntDeliverables::className(), ['intagreementid' => 'intagreementid']);
    }
    
}

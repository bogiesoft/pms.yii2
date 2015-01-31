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
 * @property string $signdate 
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
            [['extagreementid', 'consultantid', 'departmentid', 'startdate', 'enddate', 'filename', 'signdate'], 'required'],
            [['extagreementid', 'consultantid', 'departmentid'], 'integer'],
            [['startdate', 'enddate', 'datein', 'dateup', 'signdate'], 'safe'],
            [['description', 'filename'], 'string', 'max' => 250],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['startdate','enddate'], 'string', 'max' => 250],        
            [['file'],'safe'],
            [['file'], 'file', 'skipOnEmpty' => false, 'on' => 'insert'],
            //[['file'], 'file', 'extensions' => 'doc, docx', 'mimeTypes' => 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intagreementid' => 'Intagreementid',
            'extagreementid' => 'External Agreement',
            'consultantid' => 'Consultant',
            'departmentid' => 'Department',
            'description' => 'Comment',
            'startdate' => 'Agreement Period',
            'enddate' => 'End Date',
            'signdate' => 'Sign Date',
            'filename' => 'Filename',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
            'extagreement'=>'External Agreement'
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
    public function getIntdeliverables()
    {
        return $this->hasMany(IntDeliverables::className(), ['intagreementid' => 'intagreementid']);
    }

    public function getUrlFile(){
        return yii\helpers\Html::a($this->filename, \Yii::$app->request->BaseUrl.'/uploads/'.$this->filename, ['class'=>'download']);
    }
    
}

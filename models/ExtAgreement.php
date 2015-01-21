<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_extagreement".
 *
 * @property integer $extagreementid
 * @property integer $projectid
 * @property string $agreementno
 * @property string $description
 * @property string $startdate
 * @property string $enddate
 * @property string $filename
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 * @property PsExtdeliverables[] $psExtdeliverables
 * @property PsIntagreement[] $psIntagreements
 */
class ExtAgreement extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_extagreement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'agreementno', 'startdate', 'enddate', 'filename'], 'required'],
            [['projectid'], 'integer'],
            [['startdate', 'enddate', 'datein', 'dateup'], 'safe'],
            [['agreementno', 'userin', 'userup'], 'string', 'max' => 50],
            [['description', 'filename'], 'string', 'max' => 250],
            [['startdate','enddate'], 'string', 'max' => 250],        
            [['file'],'safe'],
            [['file'], 'file', 'skipOnEmpty' => false, 'on' => 'insert'],
            //[['file'], 'file', 'extensions' => 'doc, docx', 'mimeTypes' => 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document',],
            [['projectid', 'agreementno'], 'unique', 'targetAttribute' => ['projectid', 'agreementno'], 'message' => 'The combination of Projectid and Agreementno has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'extagreementid' => 'Extagreementid',
            'projectid' => 'Project',
            'agreementno' => 'Agreement No',
            'description' => 'Description',
            'startdate' => 'Date',
            'enddate' => 'Date',
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['projectid' => 'projectid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtdeliverables()
    {
        return $this->hasMany(ExtDeliverables::className(), ['extagreementid' => 'extagreementid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntagreements()
    {
        return $this->hasMany(IntAgreement::className(), ['extagreementid' => 'extagreementid']);
    }

    /**
     * @return [project code] - [project name]
     */
    public function getProjectDescr()
    {
        return $this->project->code . ' - ' . $this->project->name;
    }
}

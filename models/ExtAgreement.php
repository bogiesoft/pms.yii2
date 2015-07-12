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
 * @property string $signdate
 * @property string $filename
 * @property integer $ppn
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
            [['projectid', 'agreementno', 'startdate', 'enddate', 'filename', 'signdate'], 'required'],
            [['projectid'], 'integer'],
            [['ppn'], 'number'],
            [['startdate', 'enddate', 'datein', 'dateup', 'signdate'], 'safe'],
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
            'description' => 'Comment',
            'startdate' => 'Agreement Period',
            'enddate' => 'End Date',
            'signdate' => 'Sign Date',
            'filename' => 'Filename',
            'ppn' => 'PPN (%)', 
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

    public function getFileURL(){
        return '<a class="download" href="'. \Yii::$app->request->BaseUrl .'/uploads/'. $this->filename .'">'.$this->filename .'</a>';
    }

    public function getStartdateformat(){
        return date('d-M-Y', strtotime($this->startdate));
    }

    public function getEnddateformat(){
        return date('d-M-Y', strtotime($this->enddate));
    }

    public function getExternalagreementformat(){
        return $this->agreementno . ' - ' . $this->description;
    }
}

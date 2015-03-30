<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_businessassurance".
 *
 * @property integer $businessassuranceid
 * @property integer $projectid
 * @property string $date
 * @property string $remark
 * @property string $filename
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 */
class BusinessAssurance extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_businessassurance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'date', 'remark', 'filename'], 'required'],
            [['projectid'], 'integer'],
            [['date', 'datein', 'dateup'], 'safe'],
            [['remark'], 'string', 'max' => 250],
            [['file'],'safe'],
            [['file'], 'file', 'skipOnEmpty' => false, 'on' => 'insert'],
            //[['file'], 'file', 'extensions' => 'doc, docx', 'mimeTypes' => 'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document',],
            [['filename'], 'string', 'max' => 150],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'businessassuranceid' => 'Businessassuranceid',
            'projectid' => 'Project',
            'date' => 'Date',
            'remark' => 'Remark',
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
     * @return [project code] - [project name]
     */
    public function getProjectDescr()
    {
        return $this->project->code . ' - ' . $this->project->name;
    }

    public function getUrlFile(){
        return yii\helpers\Html::a($this->filename, \Yii::$app->request->BaseUrl.'/uploads/'.$this->filename);
    }

    public function getDateFormat(){
        return date('d-M-Y', strtotime($this->date));
    }
}

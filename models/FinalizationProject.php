<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_finalizationproject".
 *
 * @property integer $finalizationprojectid
 * @property integer $projectid
 * @property string $filename
 * @property string $remark
 * @property string $intsurveyscore
 * @property string $extsurveyscore
 * @property string $postingdate 
 * @property string $link
 * @property string $customerpic 
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 */
class FinalizationProject extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_finalizationproject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid'], 'required'],
            [['projectid'], 'integer'],
            [['postingdate', 'datein', 'dateup'], 'safe'],
            [['filename', 'link'], 'string', 'max' => 250],
            [['remark'], 'string', 'max' => 500],
            [['intsurveyscore', 'extsurveyscore'], 'string', 'max' => 16],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['file'],'safe'],
            [['customerpic'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'finalizationprojectid' => 'Finalizationprojectid',
            'projectid' => 'Projectid',
            'filename' => 'Filename',
            'remark' => 'Lessons Learned',
            'intsurveyscore' => 'Internal Survey Score',
            'extsurveyscore' => 'External Survey Score',
            'postingdate' => 'Posting Date',
            'link' => 'Link',
            'customerpic' => 'Customer PIC', 
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
}

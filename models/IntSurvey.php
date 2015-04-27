<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_intsurvey".
 *
 * @property integer $intsurveryid
 * @property integer $projectid
 * @property integer $consultantid
 * @property integer $score
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsProject $project
 * @property PsConsultant $consultant
 */
class IntSurvey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_intsurvey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectid', 'consultantid', 'score'], 'required'],
            [['projectid', 'consultantid', 'score'], 'integer'],
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
            'intsurveryid' => 'Intsurveryid',
            'projectid' => 'Projectid',
            'consultantid' => 'Consultant',
            'score' => 'Score',
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
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['consultantid' => 'consultantid']);
    }
}

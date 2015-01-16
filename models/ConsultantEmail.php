<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_consultantemail".
 *
 * @property integer $consultantemailid
 * @property integer $consultantid
 * @property string $email
 * @property string $active
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsConsultant $consultant
 */
class ConsultantEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_consultantemail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultantid', 'email'], 'required'],
            [['consultantid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['email'], 'string', 'max' => 150],
            [['active'], 'string', 'max' => 1],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['consultantid', 'email'], 'unique', 'targetAttribute' => ['consultantid', 'email'], 'message' => 'The combination of Consultantid and Email has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'consultantemailid' => 'Consultantemailid',
            'consultantid' => 'Consultantid',
            'email' => 'Email',
            'active' => 'Active',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(PsConsultant::className(), ['consultantid' => 'consultantid']);
    }
}

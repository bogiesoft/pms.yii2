<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_consultantphone".
 *
 * @property integer $consultantphoneid
 * @property integer $consultantid
 * @property integer $phonetypeid
 * @property string $phone
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsConsultant $consultant
 * @property PsPhonetype $phonetype
 */
class ConsultantPhone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_consultantphone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consultantid', 'phonetypeid', 'phone'], 'required'],
            [['consultantid', 'phonetypeid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['phone'], 'string', 'max' => 15],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'consultantphoneid' => 'Consultantphoneid',
            'consultantid' => 'Consultantid',
            'phonetypeid' => 'Phonetypeid',
            'phone' => 'Phone',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhonetype()
    {
        return $this->hasOne(PhoneType::className(), ['phonetypeid' => 'phonetypeid']);
    }
}

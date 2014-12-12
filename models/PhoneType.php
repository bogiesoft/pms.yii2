<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_phonetype".
 *
 * @property integer $phonetypeid
 * @property string $name
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsConsultantphone[] $psConsultantphones
 * @property PsContactperson[] $psContactpeople
 */
class PhoneType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_phonetype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['datein', 'dateup'], 'safe'],
            [['name', 'userin', 'userup'], 'string', 'max' => 50],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phonetypeid' => 'Phonetypeid',
            'name' => 'Name',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultantphones()
    {
        return $this->hasMany(ConsultantPhone::className(), ['phonetypeid' => 'phonetypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactpeople3()
    {
        return $this->hasMany(ContactPerson::className(), ['phonetypeid_3' => 'phonetypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactpeople2()
    {
        return $this->hasMany(ContactPerson::className(), ['phonetypeid_2' => 'phonetypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactpeople()
    {
        return $this->hasMany(ContactPerson::className(), ['phonetypeid' => 'phonetypeid']);
    }
}

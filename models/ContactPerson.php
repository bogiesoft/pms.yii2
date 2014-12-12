<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_contactperson".
 *
 * @property integer $contactpersonid
 * @property integer $customerid
 * @property string $name
 * @property string $email
 * @property string $job
 * @property integer $phonetypeid
 * @property string $phone
 * @property integer $phonetypeid_2
 * @property string $phone_2
 * @property integer $phonetypeid_3
 * @property string $phone_3
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsCustomer $customer
 * @property PsPhonetype $phonetype
 * @property PsPhonetype $phonetypeid2
 * @property PsPhonetype $phonetypeid3
 */
class ContactPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_contactperson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerid', 'name', 'email', 'job', 'phonetypeid', 'phone'], 'required'],
            [['customerid', 'phonetypeid', 'phonetypeid_2', 'phonetypeid_3'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['name', 'email', 'job'], 'string', 'max' => 150],
            [['phone', 'phone_2', 'phone_3'], 'string', 'max' => 15],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contactpersonid' => 'Contactpersonid',
            'customerid' => 'Customerid',
            'name' => 'Name',
            'email' => 'Email',
            'job' => 'Job',
            'phonetypeid' => 'Phonetypeid',
            'phone' => 'Phone',
            'phonetypeid_2' => 'Phonetypeid 2',
            'phone_2' => 'Phone 2',
            'phonetypeid_3' => 'Phonetypeid 3',
            'phone_3' => 'Phone 3',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(PsCustomer::className(), ['customerid' => 'customerid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhonetype()
    {
        return $this->hasOne(PsPhonetype::className(), ['phonetypeid' => 'phonetypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhonetypeid2()
    {
        return $this->hasOne(PsPhonetype::className(), ['phonetypeid' => 'phonetypeid_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhonetypeid3()
    {
        return $this->hasOne(PsPhonetype::className(), ['phonetypeid' => 'phonetypeid_3']);
    }
}

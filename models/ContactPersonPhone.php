<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_contactpersonphone".
 *
 * @property integer $contactpersonphoneid
 * @property integer $contactpersonid
 * @property integer $phonetypeid
 * @property string $phone
 *
 * @property PsContactperson $contactperson
 * @property PsPhonetype $phonetype
 */
class ContactPersonPhone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_contactpersonphone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contactpersonid', 'phonetypeid', 'phone'], 'required'],
            [['contactpersonid', 'phonetypeid'], 'integer'],
            [['phone'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contactpersonphoneid' => 'Contactpersonphoneid',
            'contactpersonid' => 'Contactpersonid',
            'phonetypeid' => 'Phone Type',
            'phone' => 'Phone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactPerson()
    {
        return $this->hasOne(ContactPerson::className(), ['contactpersonid' => 'contactpersonid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhonetype()
    {
        return $this->hasOne(PhoneType::className(), ['phonetypeid' => 'phonetypeid']);
    }
}

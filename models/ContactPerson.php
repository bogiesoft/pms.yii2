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
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsCustomer $customer
 * @property PsContactpersonphone[] $psContactpersonphones
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
            [['customerid', 'name', 'email', 'job'], 'required'],
            [['customerid'], 'integer'],
            [['email'], 'email'],
            [['datein', 'dateup'], 'safe'],
            [['name', 'email', 'job'], 'string', 'max' => 150],
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
    public function getContactpersonphones()
    {
        return $this->hasMany(ContactPersonPhone::className(), ['contactpersonid' => 'contactpersonid']);
    }

    public $phones = null;
}

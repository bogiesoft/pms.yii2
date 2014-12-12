<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_country".
 *
 * @property integer $countryid
 * @property string $iso3
 * @property string $name
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsCustomer[] $psCustomers
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['datein', 'dateup'], 'safe'],
            [['iso3'], 'string', 'max' => 3],
            [['name', 'userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'countryid' => 'Countryid',
            'iso3' => 'ISO3',
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
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['countryid' => 'countryid']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_partnertype".
 *
 * @property integer $partnertypeid
 * @property string $name
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsCustomer[] $psCustomers
 */
class PartnerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_partnertype';
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
            'partnertypeid' => 'Partnertypeid',
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
    public function getPsCustomers()
    {
        return $this->hasMany(Customer::className(), ['partnertypeid' => 'partnertypeid']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_producttype".
 *
 * @property integer $producttypeid
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_producttype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'producttypeid' => 'Producttypeid',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}

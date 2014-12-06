<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_category".
 *
 * @property integer $categoryid
 * @property string $category
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsConsultant[] $psConsultants
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['datein', 'dateup'], 'safe'],
            [['category', 'userin', 'userup'], 'string', 'max' => 50],
            [['category'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryid' => 'Categoryid',
            'category' => 'Category',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsConsultants()
    {
        return $this->hasMany(Consultant::className(), ['categoryid' => 'categoryid']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_groupaccess".
 *
 * @property integer $groupid
 * @property integer $menuid
 *
 * @property PsGroup $group
 * @property PsMenu $menu
 */
class GroupAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_groupaccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupid', 'menuid'], 'required'],
            [['groupid', 'menuid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupid' => 'Groupid',
            'menuid' => 'Menuid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['groupid' => 'groupid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(PsMenu::className(), ['menuid' => 'menuid']);
    }
}

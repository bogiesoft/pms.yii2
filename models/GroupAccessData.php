<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_groupaccessdata".
 *
 * @property integer $groupid
 * @property integer $unitid
 *
 * @property PsGroup $group
 * @property PsUnit $unit
 */
class GroupAccessData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_groupaccessdata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupid', 'unitid'], 'required'],
            [['groupid', 'unitid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupid' => 'Groupid',
            'unitid' => 'Unitid',
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
    public function getUnit()
    {
        return $this->hasOne(PsUnit::className(), ['unitid' => 'unitid']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_groupuser".
 *
 * @property integer $groupid
 * @property integer $userid
 *
 * @property PsGroup $group
 * @property PsUser $user
 */
class GroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_groupuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupid', 'userid'], 'required'],
            [['groupid', 'userid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupid' => 'Groupid',
            'userid' => 'Userid',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userid' => 'userid']);
    }
}

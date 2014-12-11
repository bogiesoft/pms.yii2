<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_useraccessdata".
 *
 * @property integer $userid
 * @property integer $unitid
 *
 * @property PsUser $user
 * @property PsUnit $unit
 */
class UserAccessData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_useraccessdata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'unitid'], 'required'],
            [['userid', 'unitid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'Userid',
            'unitid' => 'Unitid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(PsUser::className(), ['userid' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(PsUnit::className(), ['unitid' => 'unitid']);
    }
}

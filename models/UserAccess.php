<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_useraccess".
 *
 * @property integer $useraccessid
 * @property integer $userid
 * @property integer $menuid
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsUser $user
 * @property PsMenu $menu
 */
class UserAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_useraccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'menuid'], 'required'],
            [['userid', 'menuid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['userin', 'userup'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'useraccessid' => 'Useraccessid',
            'userid' => 'Userid',
            'menuid' => 'Menuid',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
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
    public function getMenu()
    {
        return $this->hasOne(PsMenu::className(), ['menuid' => 'menuid']);
    }
}

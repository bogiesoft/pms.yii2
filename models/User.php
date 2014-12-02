<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_user".
 *
 * @property integer $userid
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $active
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsGroupuser[] $psGroupusers
 * @property PsProjectpic[] $psProjectpics
 * @property PsUseraccess[] $psUseraccesses
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $varPassword;
    public $varActive;

    public static function tableName()
    {
        return 'ps_user';
    }

    public function getactiveText(){
        if ($this->active == "1"){
            return "Yes";
        }
        return "No";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'email', 'phone', 'password', 'varPassword', 'active'], 'required'],
            [['datein', 'dateup'], 'safe'],
            [['username'], 'string', 'max' => 25],
            [['name', 'email', 'password'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 15],
            [['active'], 'string', 'max' => 1],
            [['userin', 'userup'], 'string', 'max' => 50],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'],'integer','message'=>'{attribute} numbers must be numeric only.'],
            [['email'],'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'varPassword' => 'Confirm Password',
            'active' => 'Active',
            'datein' => 'Datein',
            'userin' => 'Userin',
            'dateup' => 'Dateup',
            'userup' => 'Userup',
            'activeText' => 'Active',
            'varActive' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsGroupusers()
    {
        return $this->hasMany(GroupUser::className(), ['userid' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsProjectpics()
    {
        return $this->hasMany(ProjectPIC::className(), ['userid' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsUseraccesses()
    {
        return $this->hasMany(UserAccess::className(), ['userid' => 'userid']);
    }
}

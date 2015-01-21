<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

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
 *
 * @property PsGroupuser[] $psGroupusers
 * @property PsGroup[] $groups 
 * @property PsProjectpic[] $psProjectpics
 * @property PsProject[] $projects 
 * @property PsUseraccess[] $psUseraccesses
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['username'], 'string', 'max' => 25],
            [['name', 'email', 'password'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 15],
            [['active'], 'string', 'max' => 1],
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
            'groupusersText' => 'Groups',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupusers()
    {
        return $this->hasMany(GroupUser::className(), ['userid' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectpics()
    {
        return $this->hasMany(ProjectPIC::className(), ['userid' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUseraccesses()
    {
        return $this->hasMany(UserAccess::className(), ['userid' => 'userid']);
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findByUsername($username)
    {        
        return static::findOne(['username' => $username, 'active' => '1']);
    }

    public static function findByEmail($email)
    {        
        return static::findOne(['email' => $email, 'active' => '1']);
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

     /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return "CREATE-AUTH";
    }

     /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

     /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return null;
    }

    public function getIsAccessMenu($accessid){
        if (!isset(Yii::$app->user->identity->userid)){
            return false;
        }

        $access = Menu::findBySql("
            select * from ps_menu 
            where menuid in (
                select menuid from ps_useraccess
                where userid = :1
                union
                select menuid from ps_groupaccess
                where groupid in (
                    select groupid from ps_groupuser
                    where userid = :1
                )
            ) and active = 1 and accessid = :2", [':1'=>Yii::$app->user->identity->userid, ':2'=>$accessid])->one();

        if (isset($access->menuid) && $access->menuid != null){
            return true;
        }else{
            return false;
        }
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ps_menu".
 *
 * @property integer $menuid
 * @property string $caption
 * @property string $link
 * @property string $icon
 * @property string $description
 * @property string $active
 * @property integer $parentid
 * @property string $datein
 * @property string $userin
 * @property string $dateup
 * @property string $userup
 *
 * @property PsGroupaccess[] $psGroupaccesses
 * @property Menu $parent
 * @property Menu[] $menus
 * @property PsUseraccess[] $psUseraccesses
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_menu';
    }

    public $varActive;

    public function getactiveText(){
        if ($this->active == "1"){
            return "Yes";
        }else{
            return "No";
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['caption'], 'required'],
            [['parentid'], 'integer'],
            [['datein', 'dateup'], 'safe'],
            [['caption', 'userin', 'userup'], 'string', 'max' => 50],
            [['link', 'icon', 'description'], 'string', 'max' => 250],
            [['active'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menuid' => 'Menuid',
            'caption' => 'Caption',
            'link' => 'Link',
            'icon' => 'Icon',
            'description' => 'Description',
            'active' => 'Active',
            'parentid' => 'Parent',
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
    public function getPsGroupaccesses()
    {
        return $this->hasMany(PsGroupaccess::className(), ['menuid' => 'menuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Menu::className(), ['menuid' => 'parentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parentid' => 'menuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsUseraccesses()
    {
        return $this->hasMany(PsUseraccess::className(), ['menuid' => 'menuid']);
    }
}

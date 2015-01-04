<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

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
 * @property integer $index
 *
 * @property PsGroupaccess[] $psGroupaccesses
 * @property PsGroup[] $groups 
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
            [['parentid', 'index'], 'integer'],
            [['caption'], 'string', 'max' => 50],
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
            'activeText' => 'Active',
            'varActive' => 'Active',
            'index' => 'Index',
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
    public function getGroups() 
    { 
        return $this->hasMany(Group::className(), ['groupid' => 'groupid'])->viaTable('ps_groupaccess', ['menuid' => 'menuid']); 
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
        return $this->hasMany(Menu::className(), ['parentid' => 'menuid'])->orderBy('index, caption');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsUseraccesses()
    {
        return $this->hasMany(PsUseraccess::className(), ['menuid' => 'menuid']);
    }

    public function getStructureTree($checked, $disable, $id, $name){
        $menu = $this->findBySql('select * from ps_menu where parentid is null order by `index`, caption')->all();
        $str = '';
        foreach($menu as $data){
            $str = $str . $this->getChild($data, $checked, $disable, $id, $name);
        }
        return $str;
    }

    public function getStructureTreeLink(){
        $menu = $this->findBySql('select * from ps_menu where parentid is null order by `index`, caption')->all();
        $str = '';
        foreach($menu as $data){
            $str = $str . $this->getChildLink($data);
        }
        return $str;
    }

    public function getStructureLabel($checked, $disable, $id, $name, $groups){
        $menu = $this->findBySql('select * from ps_menu where parentid is null order by `index`, caption')->all();
        $str = '';
        foreach($menu as $data){
            $str = $str . $this->getChildLabel($data, $checked, $disable, $id, $name, $groups);
        }
        return $str;
    }

    public function getChild($data, $checked, $disable, $id, $name){
        $attr = "";
        if (in_array($data->menuid, $checked)){
            $attr = "checked";
        }

        $str = '<li><div class="checkbox"><input '.$attr.' type="checkbox" '.$disable.' id="'.$id.'-'.$data->menuid.'" 
            name="'.$name.'['.$data->menuid.']"><label class="noselect" for="'.$id.'-'.$data->menuid.'">'.$data->caption.'</label></div>';
        if (count($data->menus) > 0){
            $str = $str . '<ul class="ul">';
            foreach($data->menus as $child){
                $str = $str . $this->getChild($child, $checked, $disable, $id, $name);
            }
            $str = $str . '</ul>';
        }
        
        return $str;
    }

    public function getChildLink($data){
        $link = Html::a('<i class="'.$data->icon.'"></i>'.$data->caption, ['menu/view?id='.$data->menuid], ['class'=>'a']);
        $str = '<li>'.$link;
        if (count($data->menus) > 0){
            $str = $str . '<ul class="ul">';
            foreach($data->menus as $child){
                $str = $str . $this->getChildLink($child);
            }
            $str = $str . '</ul>';
        }
        
        return $str;
    }

    public function getChildLabel($data, $checked, $disable, $id, $name, $groups){
        $attr = "";
        $description = "";
        if (in_array($data->menuid, $checked)){
            $attr = "checked";
            $description = $description . ' <span class="label label-primary">User</span>';
        }

        foreach ($groups as $group){
            if ($group->group->active == 1){
                $groupAccess = \app\models\GroupAccess::find()->where('groupid = :1 and menuid = :2', 
                    [':1'=>$group->groupid, ':2'=>$data->menuid])->one();
                if ($groupAccess != null){
                    $attr = "checked";
                    $description = $description . ' <span class="label label-default">'.$group->group->name.'</span>';
                }   
            }
        }

        $str = '<li><div class="checkbox"><input '.$attr.' type="checkbox" '.$disable.' id="'.$id.'-'.$data->menuid.'" 
            name="'.$name.'['.$data->menuid.']"><label class="noselect" for="'.$id.'-'.$data->menuid.'">'.$data->caption.'</label>'.$description.'</div>';

        if (count($data->menus) > 0){
            $str = $str . '<ul class="ul">';
            foreach($data->menus as $child){
                $str = $str . $this->getChildLabel($child, $checked, $disable, $id, $name, $groups);
            }
            $str = $str . '</ul>';
        }
        
        return $str;
    }
}

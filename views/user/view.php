<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->userid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->userid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<?php
    $groups = null;

    $initial_group = \app\models\Group::findBySql('select * from ps_group where active = "1" order by name')->all();
    $groups = \app\models\GroupUser::find()->where('userid = :1', [':1'=>$model->userid])->all();

    $arr_check_group = [];
    foreach ($groups as $group){
        array_push($arr_check_group, $group->groupid);
    }

    $groupTree = "";
    foreach($initial_group as $data){
        $attr = "";
        if (in_array($data->groupid, $arr_check_group)){
            $attr = "checked";
        }
        $groupTree = $groupTree. '<div class="checkbox"><input disabled '.$attr.' type="checkbox" id="UserGroup-'.$data->groupid.'" name="User[UserGroup]['.$data->groupid.']" />';
        $groupTree = $groupTree. '<label class="noselect" for="UserGroup-'.$data->groupid.'">'.$data->name.'</label></div>';
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $menus = [];
    $arr = \app\models\UserAccess::find()->where('userid = :1',[':1'=>$model->userid,])->asArray()->all();
    foreach($arr as $data){
        array_push($menus, $data["menuid"]);
    }

    $menu = new \app\models\Menu();    
    $strTree = $menu->getStructureLabel($menus, 'disabled', 'UserAccess', 'User[UserAccess]', $groups);
    $strTree = '<div id="tree"><ul class="ul">' . $strTree;
    $strTree = $strTree . '</ul></div>';

    if ($strTree == ''){
        $strTree = Html::a('Menu is empty. Please add menu first...', ['menu/index']);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $units = [];
    $unit = \app\models\Unit::findBySql('select * from ps_unit order by name')->all();
    $unitTree = '';
    $arr = \app\models\UserAccessData::find()->where('userid = :1',[':1'=>$model->userid,])->asArray()->all();
    foreach($arr as $data){
        array_push($units, $data["unitid"]);
    }

    foreach($unit as $data){
        $attr = "";
        $description = "";

        if (in_array($data->unitid, $units)){
            $attr = "checked";
            $description = $description . ' <span class="label label-primary">User</span>';
        }

        foreach ($groups as $group){
            if ($group->group->active == 1){
                $groupAccess = \app\models\GroupAccessData::find()->where('groupid = :1 and unitid = :2', 
                    [':1'=>$group->groupid, ':2'=>$data->unitid])->one();
                if ($groupAccess != null){
                    $attr = "checked";
                    $description = $description . ' <span class="label label-default">'.$group->group->name.'</span>';
                }
            }
        }

        $unitTree = $unitTree. '<div class="checkbox"><input disabled '.$attr.' type="checkbox" id="UserUnit-'.$data->unitid.'" name="User[UserUnit]['.$data->unitid.']" />';
        $unitTree = $unitTree. '<label class="noselect" for="UserUnit-'.$data->unitid.'">'.$data->Name.'</label>'.$description.'</div>';
    }

    if ($unitTree == ""){
        $unitTree = Html::a('Business unit is empty. Please add unit first...', ['unit/index']);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $items = [
        [
            'label'=>'<i class="fa fa-user"></i> User',
            'content'=>
                 DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'username',
                        'name',
                        'email:email',
                        'phone',
                        'activeText',
                    ],
                ]) 
            ,
            'active'=>true
        ],
        [
            'label'=>'<i class="fa fa-group"></i> Group',
            'content'=>'<div class="form-horizontal">'.$groupTree.'</div>',
        ],
        [
            'label'=>'<i class="fa fa-list-ul"></i> Menu',
            'content'=>'<div class="form-horizontal">'. $strTree .'</div>',
        ],
        [
            'label'=>'<i class="fa fa-building-o"></i> Unit',
            'content'=>'<div class="form-horizontal">'.$unitTree.'</div>',
        ],
    ];

    echo TabsX::widget([
        'items'=>$items,
        'position'=>TabsX::POS_ABOVE,
        'bordered'=>true,
        'encodeLabels'=>false
    ]);
?>

</div>

<style>
    .form-group{
        margin-bottom:0px;
    }
    .tab-content{
        min-height: 200px;
    }
    .noselect {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        padding-left: 0px !important;
    }
    .ui-widget-content{
        border: none;
    }
    .ul{
        padding-left:20px !important;
    }
    .checkbox{
        margin-left: 25px;
    }
    .table {
        margin-bottom: 0px;
    }
</style>

<?php
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jquery/jquery-1.11.1.min.js", [\yii\web\View::POS_HEAD]);
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jquery-ui/jquery-ui.js", [\yii\web\View::POS_HEAD]);
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jtree/jquery.tree.min.js", [\yii\web\View::POS_HEAD]);

$this->registerCssFile(yii\helpers\BaseUrl::base()."/plugin/jquery-ui/jquery-ui.css", [\yii\web\View::POS_HEAD]);
$this->registerCssFile(yii\helpers\BaseUrl::base()."/plugin/jtree/jquery.tree.min.css", [\yii\web\View::POS_HEAD]);
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tree').tree({
            'dnd':false,
        });
    });
</script>

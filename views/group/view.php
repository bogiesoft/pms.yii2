<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->groupid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->groupid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<?php 

    $users = null;

    $initial_user = \app\models\User::findBySql('select * from ps_user where active = "1" order by username')->all();
    $users = \app\models\GroupUser::find()->where('groupid = :1', [':1'=>$model->groupid])->all();

    $arr_check_user = [];
    foreach ($users as $user){
        array_push($arr_check_user, $user->userid);
    }

    $userTree = "";
    foreach($initial_user as $data){
        $attr = "";
        if (in_array($data->userid, $arr_check_user)){
            $attr = "checked";
        }
        $userTree = $userTree. '<div class="checkbox"><input disabled '.$attr.' type="checkbox" id="UserGroup-'.$data->userid.'" name="User[UserGroup]['.$data->userid.']" />';
        $userTree = $userTree. '<label class="noselect" for="UserGroup-'.$data->userid.'">'.$data->username.'</label></div>';
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $menus = [];
    $menu = \app\models\Menu::findBySql('select * from ps_menu where active = "1" order by coalesce(parentid, menuid)')->all();
    $arr = \app\models\GroupAccess::find()->where('groupid = :1',[':1'=>$model->groupid,])->asArray()->all();
    foreach($arr as $data){
        array_push($menus, $data["menuid"]);
    }

    $strTree = '<div id="tree">';
    $index = 0;
    foreach($menu as $data){
        $attr = "";

        if (in_array($data->menuid, $menus)){
            $attr = "checked";
        }

        if ($index < $data->level){
            $strTree = $strTree.'<ul class="ul">';
        }

        if ($index > $data->level){
            for($i = 0; $i < $index - $data->level; $i++){
                $strTree = $strTree.'</ul>';
            }
        }

        $strTree = $strTree.'<li><div class="checkbox"><input disabled type="checkbox" '.$attr.' id="UserAccess-'.$data->menuid.'" name="User[UserAccess]['.$data->menuid.']"><label class="noselect" for="UserAccess-'.$data->menuid.'">'.$data->caption.'</label></div>';
        $index = $data->level;
    }
    $strTree = $strTree . '</div>';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $units = [];
    $unit = \app\models\Unit::findBySql('select * from ps_unit order by name')->all();
    $unitTree = '';
    $arr = \app\models\GroupAccessData::find()->where('groupid = :1',[':1'=>$model->groupid,])->asArray()->all();
    foreach($arr as $data){
        array_push($units, $data["unitid"]);
    }

    foreach($unit as $data){
        $attr = "";

        if (in_array($data->unitid, $units)){
            $attr = "checked";
        }

        $unitTree = $unitTree. '<div class="checkbox"><input disabled '.$attr.' type="checkbox" id="UserUnit-'.$data->unitid.'" name="User[UserUnit]['.$data->unitid.']" />';
        $unitTree = $unitTree. '<label class="noselect" for="UserUnit-'.$data->unitid.'">'.$data->Name.'</label></div>';
    }

    if ($unitTree == ""){
        $unitTree = Html::a('Business unit is empty. Please add unit first...', ['unit/index']);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $items = [
        [
            'label'=>'<i class="fa fa-group"></i> Group',
            'content'=>
                 DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description',
                        [
                            'attribute'=>'active',
                            'value'=>$model->activeText
                        ],
                    ],
                ]) 
            ,
            'active'=>true
        ],
        [
            'label'=>'<i class="fa fa-user"></i> User',
            'content'=>'<div class="form-horizontal">'.$userTree.'</div>',
        ],
        [
            'label'=>'<i class="fa fa-list-ul"></i> Menu',
            'content'=>'<div class="form-horizontal">'.$strTree.'</div>',
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

$this->registerCssFile(yii\helpers\BaseUrl::base()."/plugin/font-awesome/css/font-awesome.min.css", [\yii\web\View::POS_HEAD]);
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

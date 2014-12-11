<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

<?php

////////////////////////////Setting User Form////////////////////////////////////////////////////////////////////
    $user = \app\models\User::findBySql('select * from ps_user where active = "1" order by username')->all();
    $userTree = '';

    foreach($user as $data){
        $attr = "";
        if (in_array($data->userid, $users)){
            $attr = "checked";
        }
        $userTree = $userTree. '<div class="checkbox"><input '.$attr.' type="checkbox" id="UserGroup-'.$data->userid.'" name="Group[UserGroup]['.$data->userid.']" />';
        $userTree = $userTree. '<label class="noselect" for="UserGroup-'.$data->userid.'">'.$data->username.' - '.$data->name.'</label></div>';
    }

    if ($userTree == ""){
        $userTree = Html::a('User is empty. Please add user first...', ['user/index']);
    }
////////////////////////////End Setting User Form////////////////////////////////////////////////////////////////////

////////////////////////////Setting Menu Form////////////////////////////////////////////////////////////////////

    $menu = \app\models\Menu::findBySql('select * from ps_menu where active = "1" order by coalesce(parentid, menuid)')->all();

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

        $strTree = $strTree.'<li><div class="checkbox"><input type="checkbox" '.$attr.' id="GroupAccess-'.$data->menuid.'" name="Group[GroupAccess]['.$data->menuid.']"><label class="noselect" for="GroupAccess-'.$data->menuid.'">'.$data->caption.'</label></div>';
        $index = $data->level;
    }
    $strTree = $strTree . '</div>';

    if (sizeof($menu) == 0){
        $strTree = Html::a('Menu is empty. Please add menu first...', ['menu/index']);
    }

////////////////////////////End Setting Menu Form////////////////////////////////////////////////////////////////////

////////////////////////////Setting Unit Form////////////////////////////////////////////////////////////////////
    $unit = \app\models\Unit::findBySql('select * from ps_unit order by name')->all();
    $unitTree = '';

    foreach($unit as $data){
        $attr = "";
        if (in_array($data->unitid, $units)){
            $attr = "checked";
        }
        $unitTree = $unitTree. '<div class="checkbox"><input '.$attr.' type="checkbox" id="GroupUnit-'.$data->unitid.'" name="Group[GroupUnit]['.$data->unitid.']" />';
        $unitTree = $unitTree. '<label class="noselect" for="GroupUnit-'.$data->unitid.'">'.$data->Name.'</label></div>';
    }

    if ($unitTree == ""){
        $unitTree = Html::a('Business unit is empty. Please add unit first...', ['unit/index']);
    }

////////////////////////////End Setting Unit Form////////////////////////////////////////////////////////////////////

	$items = [
        [
            'label'=>'<i class="fa fa-group"></i> Group',
            'content'=>
            $form->field($model, 'name', 
	            [
	                        'labelOptions' => [
	                    'class' => 'col-sm-2 control-label'
	                ],
	                'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
	            ])->textInput(['maxlength' => 50]).
			$form->field($model, 'description', 
                [
                        'labelOptions' => [
                        'class' => 'col-sm-2 control-label'
                    ],
                    'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                ])->textArea(['maxlength' => 250, 'style'=>'height:120px']).
			$form->field($model, 'active', 
                [
                        'labelOptions' => [
                        'class' => 'col-sm-2 control-label'
                    ],
                    'template' => '{label}<div class="col-sm-10 radio">{input}{error}{hint}</div>'
                ])->radioList(['1'=>'Yes', '0'=>'No'],['separator'=>'<span style="margin-right:20px"></span>']),
            'active'=>true
        ],
        [
            'label'=>'<i class="fa fa-user"></i> User',
            'content'=>$userTree,
        ],
        [
            'label'=>'<i class="fa fa-list-ul"></i> Menu',
            'content'=>$strTree,
        ],
        [
            'label'=>'<i class="fa fa-building-o"></i> Unit',
            'content'=>$unitTree,
        ],
    ];

    echo TabsX::widget([
        'items'=>$items,
        'position'=>TabsX::POS_ABOVE,
        'bordered'=>true,
        'encodeLabels'=>false
    ]);

?>



    <div class="form-group" style="margin-left: 0px; margin-top: 10px; ">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

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
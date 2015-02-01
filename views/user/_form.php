<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

<?php
////////////////////////////Setting Group Form////////////////////////////////////////////////////////////////////
    $group = \app\models\Group::findBySql('select * from ps_group where active = "1" order by name')->all();
    $groupTree = '';
    
    foreach($group as $data){
        $attr = "";
        if (in_array($data->groupid, $groups)){
            $attr = "checked";
        }
        $groupTree = $groupTree. '<div class="checkbox"><input '.$attr.' type="checkbox" id="UserGroup-'.$data->groupid.'" name="User[UserGroup]['.$data->groupid.']" />';
        $groupTree = $groupTree. '<label class="noselect" for="UserGroup-'.$data->groupid.'">'.$data->name.'</label></div>';
    }

    if ($groupTree == ""){
        $groupTree = Html::a('Group is empty. Please add group first...', ['group/index']);
    }
////////////////////////////End Setting Group Form////////////////////////////////////////////////////////////////////

////////////////////////////Setting Unit Form////////////////////////////////////////////////////////////////////
    $unit = \app\models\Unit::findBySql('select * from ps_unit order by name')->all();
    $unitTree = '';

    foreach($unit as $data){
        $attr = "";
        if (in_array($data->unitid, $units)){
            $attr = "checked";
        }
        $unitTree = $unitTree. '<div class="checkbox"><input '.$attr.' type="checkbox" id="UserUnit-'.$data->unitid.'" name="User[UserUnit]['.$data->unitid.']" />';
        $unitTree = $unitTree. '<label class="noselect" for="UserUnit-'.$data->unitid.'">'.$data->Name.'</label></div>';
    }

    if ($unitTree == ""){
        $unitTree = Html::a('Business unit is empty. Please add unit first...', ['unit/index']);
    }

////////////////////////////End Setting Unit Form////////////////////////////////////////////////////////////////////

////////////////////////////Setting Menu Form////////////////////////////////////////////////////////////////////

    $menu = new \app\models\Menu();
    $strTree = $menu->getStructureTree($menus, '', 'UserAccess', 'User[UserAccess]');
    $strTree = '<div id="tree"><ul class="ul">' . $strTree;
    $strTree = $strTree . '</ul></div>';

    if ($strTree == ''){
        $strTree = Html::a('Menu is empty. Please add menu first...', ['menu/index']);
    }

////////////////////////////End Setting Menu Form////////////////////////////////////////////////////////////////////

    
    $items = [
        [
            'label'=>'<i class="fa fa-user"></i> User',
            'content'=>
                $form->field($model, 'username', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                    ]
                )->textInput(['maxlength' => 25, !$model->isNewRecord ? 'disabled' : ''=>'']).
                
                $form->field($model, 'name', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                    ])->textInput(['maxlength' => 150]).

                $form->field($model, 'email', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                    ])->textInput(['maxlength' => 150]).

                $form->field($model, 'phone', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                    ])->textInput(['maxlength' => 15]).

                $form->field($model, 'password', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                    ])->passwordInput(['maxlength' => 150]).

                $form->field($model, 'varPassword', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
                    ])->passwordInput(['maxlength' => 150]).

                $form->field($model, 'active', 
                    [
                        'labelOptions' => [
                            'class' => 'col-sm-2 control-label'
                        ],
                        'template' => '{label}<div class="col-sm-10 radio">{input}</div>{error}{hint}'
                    ])->radioList(['1'=>'Yes', '0'=>'No'],['separator'=>'<span style="margin-right:20px"></span>']),
            'active'=>true
        ],
        [
            'label'=>'<i class="fa fa-group"></i> Group',
            'content'=>$groupTree,
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
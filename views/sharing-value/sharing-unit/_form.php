<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use kartik\money\MaskMoney;

use app\models\Unit;

/* @var $this yii\web\View */
/* @var $model app\models\SharingValueUnit */
/* @var $form ActiveForm */
?>
<style>
.col-md-2, .col-md-3, .col-md-4{
    padding-right:5px;
    padding-left:0px;
}
@media screen and (max-width: 1024px){
    .col-md-2, .col-md-3, .col-md-4{
        width:100%;
        width:100%;
    }
    .input-group.date{
        width:100%;   
    }
    .input-group-addon{
        width: 1% !important;
    }
}
.sharing-unit-form{
    clear:both;
}
</style>
<div class="sharing-unit-form">
    
    <div class="form-inline" role="form">

    <?php
        if ($model->hasErrors('unitid')){
            echo '<div class="form-group required has-error col-md-4">';
        }else{
            echo '<div class="form-group col-md-4">';
        }
    ?>
    <?php
        
        $data = [];
        $sql = "select unitid, concat(code, ' - ', name) as descr from ps_unit";
        $data += ArrayHelper::map(Unit::findBySql($sql)->asArray()->all(), 'unitid', 'descr');

        echo Html::activeHiddenInput($model, '[' . $index . ']sharingvalueunitid');
        echo Select2::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']unitid',
            'data'=>$data,
            'options' => [
                'placeholder' => 'Select a unit..', 
                'class'=>'unitddl form-control', 
                'style' => 'width:100%;'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        echo Html::error($model, 'unitid', ['class'=>'help-block']);

    ?>    
    </div>

    <?php
        if ($model->hasErrors('value')){
            echo '<div class="form-group required has-error col-md-3">';
        }else{
            echo '<div class="form-group col-md-3">';
        }
    ?>
    <?php
        echo MaskMoney::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']value',
            'options'=>[
                'maxlength' => 20,
                'title'=>'Enter sharing value..',
                'style'=>'width:100%;',
                'class'=>'form-control unitvalueinput',
            ],
            'pluginOptions' => [
                'prefix' => '',
                'suffix' => '',
                'allowNegative' => false,
                'thousands' => ',',
                'precision' => 2,
                'allowZero' => true,
            ]
        ]);
        echo Html::error($model, 'value', ['class'=>'help-block']);
    ?>    
    </div>
    <?php
        if ($model->hasErrors('cost')){
            echo '<div class="form-group required has-error col-md-3">';
        }else{
            echo '<div class="form-group col-md-3">';
        }
    ?>
    <?php
        echo MaskMoney::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']cost',
            'options'=>[
                'maxlength' => 20,
                'title'=>'Enter cost..',
                'style'=>'width:100%;',
                'class'=>'form-control unitcostinput',
            ],
            'pluginOptions' => [
                'prefix' => '',
                'suffix' => '',
                'allowNegative' => false,
                'thousands' => ',',
                'precision' => 2,
                'allowZero' => true,
            ]
        ]);
        echo Html::error($model, 'cost', ['class'=>'help-block']);
    ?>    
    </div>
        
    <a type="button" class="btnAddSharingUnit btn btn-primary" style="vertical-align: top; margin-bottom:15px"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeleteSharingUnit btn btn-danger" style="vertical-align: top;margin-bottom:15px"><i class="glyphicon glyphicon-minus"></i></a>

    </div>

</div><!-- _form -->
<script>
$('.unitddl').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-4");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Unit cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-4");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.unitvalueinput').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-3");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Sharing value cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-3");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.unitcostinput').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-3");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Cost cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-3");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});
</script>
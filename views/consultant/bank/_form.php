<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultantBank */
/* @var $form ActiveForm */
?>
<div class="consultant-bank-form">

    <?php
        if ($model->hasErrors('bankid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
     <?php 

    $data = [];
    $sql = "select bankid, concat(code, ' - ', name) as descr  from ps_bank order by name";
    $data += yii\helpers\ArrayHelper::map(app\models\Bank::findBySql($sql)->asArray()->all(), 'bankid', 'descr'); 
    echo Html::activeHiddenInput($model, '[' . $index . ']consultantbankid');
    echo Html::activeLabel($model, '[' . $index . ']bankid', ['class'=>'col-sm-2 control-label']);
    echo '<div class="col-sm-10">';
    echo Select2::widget([
        'model'=>$model,
        'attribute'=> '['.$index.']bankid',
        'data'=>$data,
        'options' => [
            'placeholder' => 'Select a bank..', 
            'class'=>'bankddl form-control', 
        ],
    ]);
    echo Html::error($model, 'bankid', ['class'=>'help-block']);
    echo '</div>';
    ?>
    </div>

    <?php
        if ($model->hasErrors('branch')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']branch', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Html::activeTextInput($model, '[' . $index . ']branch', [
            'maxlength' => 50, 
            'class'=>'form-control branchinput',
            'placeholder'=>'Enter bank branch..'
        ]);
        echo Html::error($model, 'branch', ['class'=>'help-block']);
        echo '</div>';
    ?>
    </div>

    <?php
        if ($model->hasErrors('account')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']account', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Html::activeTextInput($model, '[' . $index . ']account', [
            'maxlength' => 15, 
            'class'=>'form-control accountinput',
            'style'=>'min-width:300px;',
            'placeholder'=>'Enter bank account number..'
        ]);
        echo Html::error($model, 'account', ['class'=>'help-block']);
        echo '</div>';
    ?>
    </div>

    <div class="form-group">
    <?php
        echo Html::activeLabel($model, '[' . $index . ']active', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo '<div class="checkbox">';
        echo Html::activeRadioList($model, '[' . $index . ']active', [
        '1'=>'Yes','0'=>'No'
        ]);
        echo Html::error($model, 'active', ['class'=>'help-block']);
        echo '</div></div>';
    ?>
    </div>

    <div class="form-group" style="margin-bottom:15px">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <a style="cursor:pointer; margin-right:5px" class="btnDeleteBank">Delete..</a>
            <a style="cursor:pointer;" class="btnAddBank">Add more bank account..</a>
        </div>
    </div>
        
</div><!-- consultant-bank-form -->
<script>
$(".branchinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Branch cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".accountinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Account cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.bankddl').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Bank cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});
</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultantPhone */
/* @var $form ActiveForm */
?>
<div class="consultant-phone-form">

    <div class="form-inline" role="form">

    <?php
        if ($model->hasErrors('phonetypeid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
     <?php 

    $data = [];
    $data += yii\helpers\ArrayHelper::map(\app\models\PhoneType::find()->asArray()->orderBy('name')->all(), 
        'phonetypeid', 'name');
    
    $mobile = \app\models\PhoneType::find()->where(['like','name','mobile'])->one();
    if ($mobile != null && ($model->phonetypeid == null || $model->phonetypeid == "")){
        $model->phonetypeid = $mobile->phonetypeid;   
    }
    echo Html::activeHiddenInput($model, '[' . $index . ']consultantphoneid');
    echo Select2::widget([
        'model'=>$model,
        'attribute'=> '['.$index.']phonetypeid',
        'data'=>$data,
        'options' => [
            'placeholder' => 'Select phone type..', 
            'class'=>'phonetypeddl form-control', 
            'style' => 'width:100%;min-width:250px;'
        ],
    ]);
    echo Html::error($model, 'phonetypeid', ['class'=>'help-block']);

    ?>
    </div>

    <?php
        if ($model->hasErrors('phone')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeTextInput($model, '[' . $index . ']phone', [
            'maxlength' => 25, 
            'class'=>'form-control phoneinput',
            'style'=>'min-width:300px;',
            'placeholder'=>'Enter phone number..'
        ]);
        echo Html::error($model, 'phone', ['class'=>'help-block']);
    ?>
    </div>
    <a type="button" class="btnAddPhone btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeletePhone btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
        
    </div>

</div><!-- consultant-phone-_form -->
<script>
    $(".phoneinput").blur(function(e){
        if ($(e.currentTarget).val() == ""){
            $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
            $(e.currentTarget).closest(".form-group").find(".help-block").text("Phone cannot be blank.");
            $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
        }else{
            $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
            $(e.currentTarget).closest(".form-group").find(".help-block").text("");
            $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $('.phonetypeddl').change(function(e){
        if ($(e.currentTarget).val() == ""){
            $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
            $(e.currentTarget).closest(".form-group").find(".help-block").text("Phone type cannot be blank.");
            $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
        }else{
            $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
            $(e.currentTarget).closest(".form-group").find(".help-block").text("");
            $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

</script>
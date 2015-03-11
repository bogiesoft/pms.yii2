<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ContactPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-person-phone-form">

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
    echo Html::activeHiddenInput($model, '[' . $index . ']contactpersonphoneid', [
        'name'=>'ContactPerson['.$target.'][ContactPersonPhone][' . $index . '][contactpersonphoneid]']);
    echo Select2::widget([
        'value'=>$model->phonetypeid,
        'id'=>'ContactPerson-'.$target.'-ContactPersonPhone-' . $index . '-phonetypeid',
        'name'=>'ContactPerson['.$target.'][ContactPersonPhone][' . $index . '][phonetypeid]',
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
            'placeholder'=>'Enter phone number..',
            'class'=>'form-control phoneinput',
            'style'=>'margin-right:50px;min-width:300px;',
            'name'=>'ContactPerson['.$target.'][ContactPersonPhone][' . $index . '][phone]'
        ]);
        echo Html::error($model, 'phone', ['class'=>'help-block']);
    ?>
    </div>
    <a type="button" class="btnAddPhone btn btn-primary" data-target="<?= $target ?>" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeletePhone btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
        
    </div>

</div>
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
</script>
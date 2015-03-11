<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultantEmail */
/* @var $form ActiveForm */
?>
<div class="consultant-email-form">

    <div class="form-inline" role="form">

    <?php
        if ($model->hasErrors('email')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeHiddenInput($model, '[' . $index . ']consultantemailid');
        echo Html::activeTextInput($model, '[' . $index . ']email', [
            'maxlength' => 150, 
            'class'=>'form-control emailinput',
            'style'=>'min-width:400px;',
            'placeholder'=>'Enter email address..'
        ]);
        echo Html::error($model, 'email', ['class'=>'help-block']);
    ?>
    </div>

    <a type="button" class="btnAddEmail btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeleteEmail btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
        
    </div>

</div><!-- consultant-email-_form -->
<script>
$(".emailinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Email cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});
</script>
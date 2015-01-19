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
        ]);
        echo Html::error($model, 'email', ['class'=>'help-block']);
    ?>
    </div>

    <a type="button" class="btnAddEmail btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeleteEmail btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
        
    </div>

</div><!-- consultant-email-_form -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    echo Html::activeHiddenInput($model, '[' . $index . ']consultantphoneid');
    echo Html::activeDropDownList($model, '[' . $index . ']phonetypeid', $data, [
        'style'=>'width:100%;min-width:250px;',
        'class'=>'phonetypeddl form-control select2',
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
            'maxlength' => 15, 
            'class'=>'form-control phoneinput',
            'style'=>'min-width:300px;',
        ]);
        echo Html::error($model, 'phone', ['class'=>'help-block']);
    ?>
    </div>
    <a type="button" class="btnAddPhone btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeletePhone btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
        
    </div>

</div><!-- consultant-phone-_form -->

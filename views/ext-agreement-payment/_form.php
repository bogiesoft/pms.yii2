<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreementPayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-agreement-payment-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
         echo $form->field($model, 'invoicedate')->widget(DatePicker::classname(), 
         [
            'options' => ['placeholder' => 'Enter invoice date..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?php
         echo $form->field($model, 'sentdate')->widget(DatePicker::classname(), 
         [
            'options' => ['placeholder' => 'Enter sent date..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?php
         echo $form->field($model, 'invoicedeadline')->widget(DatePicker::classname(), 
         [
            'options' => ['placeholder' => 'Enter invoice deadline..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?php
         echo $form->field($model, 'targetdate')->widget(DatePicker::classname(), 
         [
            'options' => ['placeholder' => 'Enter target date..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?php
         echo $form->field($model, 'date')->widget(DatePicker::classname(), 
         [
            'options' => ['placeholder' => 'Enter payment date..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?= $form->field($model, 'remark')->textArea(['maxlength' => 250, 'placeholder'=>'Enter remark..', 'style'=>'height:120px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

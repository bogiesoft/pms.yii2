<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Term */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="term-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'priod')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'kdsem')->textInput(['maxlength' => 1]) ?>

    <?php
        echo $form->field($model, 'startdate')->widget(
            DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter term start date..'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'd-M-yyyy'
                ]
            ]
        );
    ?>

    <?php
        echo $form->field($model, 'enddate')->widget(
            DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter term end date..'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'd-M-yyyy'
                ]
            ]
        );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

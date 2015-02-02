<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MindUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mind-unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50, 'placeholder'=>'Enter rate unit name..']) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style'=>'height:120px', 'placeholder'=>'Enter rate unit description..']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

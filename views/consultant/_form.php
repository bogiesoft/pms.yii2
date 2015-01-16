<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lectureid')->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'employeeid')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'residentid')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'categoryid')->textInput() ?>

    <?= $form->field($model, 'datein')->textInput() ?>

    <?= $form->field($model, 'userin')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'dateup')->textInput() ?>

    <?= $form->field($model, 'userup')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

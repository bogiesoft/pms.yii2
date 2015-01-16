<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'consultantid') ?>

    <?= $form->field($model, 'lectureid') ?>

    <?= $form->field($model, 'employeeid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'residentid') ?>

    <?php // echo $form->field($model, 'categoryid') ?>

    <?php // echo $form->field($model, 'datein') ?>

    <?php // echo $form->field($model, 'userin') ?>

    <?php // echo $form->field($model, 'dateup') ?>

    <?php // echo $form->field($model, 'userup') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

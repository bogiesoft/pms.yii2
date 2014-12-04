<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-rate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rateid') ?>

    <?= $form->field($model, 'role') ?>

    <?= $form->field($model, 'mindunitid') ?>

    <?= $form->field($model, 'rate') ?>

    <?= $form->field($model, 'description') ?>

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

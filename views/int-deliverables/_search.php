<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IntDeliverablesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="int-deliverables-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'intdeliverableid') ?>

    <?= $form->field($model, 'intagreementid') ?>

    <?= $form->field($model, 'extdeliverableid') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'positionid') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'frequency') ?>

    <?php // echo $form->field($model, 'rateid') ?>

    <?php // echo $form->field($model, 'rate') ?>

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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PhoneTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phone-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'phonetypeid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'datein') ?>

    <?= $form->field($model, 'userin') ?>

    <?= $form->field($model, 'dateup') ?>

    <?php // echo $form->field($model, 'userup') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
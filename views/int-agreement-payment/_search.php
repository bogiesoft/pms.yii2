<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreementPaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="int-agreement-payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'intagreementpaymentid') ?>

    <?= $form->field($model, 'intdeliverableid') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'remark') ?>

    <?= $form->field($model, 'datein') ?>

    <?php // echo $form->field($model, 'userin') ?>

    <?php // echo $form->field($model, 'dateup') ?>

    <?php // echo $form->field($model, 'userup') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

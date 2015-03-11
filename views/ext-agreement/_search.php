<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-agreement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'extagreementid') ?>

    <?= $form->field($model, 'projectid') ?>

    <?= $form->field($model, 'agreementno') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'startdate') ?>

    <?php echo $form->field($model, 'enddate') ?>

    <?php echo $form->field($model, 'filename') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

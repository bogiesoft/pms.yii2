<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContactPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'job')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'phonetypeid')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'phonetypeid_2')->textInput() ?>

    <?= $form->field($model, 'phone_2')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'phonetypeid_3')->textInput() ?>

    <?= $form->field($model, 'phone_3')->textInput(['maxlength' => 15]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

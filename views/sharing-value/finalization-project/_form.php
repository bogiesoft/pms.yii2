<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FinalizationProject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finalization-project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'projectid')->textInput() ?>

    <?= $form->field($model, 'filename')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'intsurveyscore')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'extsurveyscore')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'datein')->textInput() ?>

    <?= $form->field($model, 'userin')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'dateup')->textInput() ?>

    <?= $form->field($model, 'userup')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

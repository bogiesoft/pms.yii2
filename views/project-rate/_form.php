<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\MindUnit;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-rate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => 50]) ?>

    <?php 
        $dataCategory = [];
        $dataCategory += ArrayHelper::map(MindUnit::find()->asArray()->all(), 'mindunitid', 'name');        
    ?>

    <?= $form->field($model, 'mindunitid')->dropDownList($dataCategory, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

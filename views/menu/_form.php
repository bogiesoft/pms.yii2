<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caption')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style' => 'height:120px']) ?>

    <?php 
        $dataCategory = [];
        array_push($dataCategory, ' ');
        $dataCategory += yii\helpers\ArrayHelper::map(\app\models\Menu::find()->asArray()->all(), 'menuid', 'caption');
    ?>

    <?= $form->field($model, 'parentid')->dropDownList($dataCategory) ?>


    <?= $form->field($model, 'active')->radioList(['1'=>'Yes', '0'=>'No'],['separator'=>'<span style="margin-right:20px"></span>']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

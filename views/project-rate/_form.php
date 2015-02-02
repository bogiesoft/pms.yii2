<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\MindUnit;
use kartik\select2\Select2;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-rate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => 50, 'placeholder' => 'Enter role..']) ?>

    <?php 
        $data = [];
        $data += ArrayHelper::map(MindUnit::find()->asArray()->all(), 'mindunitid', 'name');        

        echo $form->field($model, 'mindunitid')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select a rate unit..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        echo $form->field($model, 'rate')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => '',
                'suffix' => '',
                'allowNegative' => false,
                'thousands' => ',',
                'precision' => 2,
                'allowZero' => true,
            ],
            'options'=>[
                'maxlength' => 20,
            ],
        ]);
    ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style'=>'height:120px', 'placeholder' => 'Enter project rate description..']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

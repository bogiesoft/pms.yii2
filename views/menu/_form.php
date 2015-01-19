<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

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
        if ($model->menuid == null){
            $model->menuid = 0;
        }
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\Menu::find()->where('menuid != :1', [':1'=>$model->menuid])->orderBy('caption')->asArray()->all(), 'menuid', 'caption');
        echo $form->field($model, 'parentid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a parent ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'index')->textInput() ?>

    <?= $form->field($model, 'accessid')->textInput() ?>

    <?= $form->field($model, 'active')->radioList(['1'=>'Yes', '0'=>'No'],['separator'=>'<span style="margin-right:20px"></span>']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

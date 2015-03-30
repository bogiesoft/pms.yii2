<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;
use kartik\select2\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\BusinessAssurance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="business-assurance-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
        $dataCategory = [];
        $sql = "select projectid, concat(code,' - ',name) as project_descr from ps_project where projectid = ".$model->projectid;        
        $dataCategory += ArrayHelper::map(Project::findBySql($sql)->asArray()->all(), 'projectid', 'project_descr');      

        echo $form->field($model, 'projectid')->widget(Select2::classname(), [
            'data' =>$dataCategory,
            'options' => ['placeholder' => 'Select a Project ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php
        echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter business assurance date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?= $form->field($model, 'remark')->textArea(['maxlength' => 250, 'style' => 'height:120px']) ?>

    <?php //$form->field($model, 'filename')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'file')->fileInput() ?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-log-form">

    <?php $form = ActiveForm::begin(); ?>

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
        echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'date',
                'options' => ['placeholder'=>'Date'],
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'form' => $form,
                'pluginOptions' => [
                    'format' => 'dd-M-yyyy',
                    'autoclose' => true,
                ]
            ]);
    ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => 250]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

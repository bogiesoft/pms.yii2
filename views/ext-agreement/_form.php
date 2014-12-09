<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;
//use yii\jui\DatePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-agreement-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
        $dataCategory = [];
        $sql = "select projectid, concat(code,' - ',name) as project_descr from ps_project ";        
        $dataCategory += ArrayHelper::map(Project::findBySql($sql)->asArray()->all(), 'projectid', 'project_descr');        
    ?>

    <?= $form->field($model, 'projectid')->dropDownList($dataCategory, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'agreementno')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <?php
        echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'startdate',
                'attribute2' => 'enddate',
                'options' => ['placeholder'=>'Start Date'],
                'options2' => ['placeholder'=>'End Date'],
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'pluginOptions' => [
                    'format' => 'dd-M-yyyy',
                    'autoclose' => true,
                ]
            ]);
    ?>
    
    <?php //$form->field($model, 'filename')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'file')->fileInput() ?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

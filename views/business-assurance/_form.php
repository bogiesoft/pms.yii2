<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;

/* @var $this yii\web\View */
/* @var $model app\models\BusinessAssurance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="business-assurance-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
        $dataCategory = [];
        $sql = "select projectid, concat(code,' - ',name) as project_descr from ps_project ";        
        $dataCategory += ArrayHelper::map(Project::findBySql($sql)->asArray()->all(), 'projectid', 'project_descr');        
    ?>

    <?= $form->field($model, 'projectid')->dropDownList($dataCategory, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => 250]) ?>

    <?php //$form->field($model, 'filename')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'file')->fileInput() ?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

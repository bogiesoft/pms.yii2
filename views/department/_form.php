<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Faculty;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $dataCategory = [];
        $sql = "select facultyid, concat(code,' - ',name) as faculty_descr from ps_faculty ";        
        $dataCategory += ArrayHelper::map(Faculty::findBySql($sql)->asArray()->all(), 'facultyid', 'faculty_descr');        
    ?>

    <?= $form->field($model, 'facultyid')->dropDownList($dataCategory, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

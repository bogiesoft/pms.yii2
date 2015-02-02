<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Faculty;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $data = [];
        $sql = "select facultyid, concat(code,' - ',name) as faculty_descr from ps_faculty ";        
        $data += ArrayHelper::map(Faculty::findBySql($sql)->asArray()->all(), 'facultyid', 'faculty_descr');        

        echo $form->field($model, 'facultyid')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select a faculty..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50, 'placeholder'=>'Enter department name..']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

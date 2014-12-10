<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectPic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-pic-form" id='project-pic-['<?= $index ?>']' ?>

    <?php //$form = ActiveForm::begin(); ?>

    <?php 
        $dataCategory = [];
        array_push($dataCategory, ' ');
        $dataCategory += ArrayHelper::map(User::find()->asArray()->all(), 'userid', 'name');

        echo HTML::activeDropDownList($model, '['.$index.']userid', $dataCategory4);
    ?>

    <?php //$form->field($model, 'userid')->dropDownList($dataCategory) ?>
    <!-- <div class="form-group">
        <?php //Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div> -->
    <?php //ActiveForm::end(); ?>

</div>

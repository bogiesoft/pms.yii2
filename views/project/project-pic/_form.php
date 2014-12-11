<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectPic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-pic-form" id="project-pic-[<?= $index ?>]" ?>
    <a style="cursor:pointer;text-decoration:none;" onclick="deletePhone(this)">Delete</a>
    <?php 
        $dataCategory = [];
        $dataCategory += ArrayHelper::map(User::find()->asArray()->all(), 'userid', 'name');

        echo HTML::activeDropDownList($model, '['.$index.']userid', $dataCategory, array('prompt'=>' '));
        echo HTML::Error($model, '['.$index.']userid');
    ?>

</div>

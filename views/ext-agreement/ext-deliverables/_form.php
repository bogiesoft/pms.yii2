<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-deliverables-form" id="ext-deliverables-[<?= $index ?>]" ?>
    <a style="cursor:pointer;text-decoration:none;" onclick="deleteExtDeliverables(this)">Delete</a>    
    </br>
    <?php 
        echo HTML::activeLabel($model, '['.$index.']code');
    	echo HTML::activeInput('text', $model, '['.$index.']code',['maxlength'=> 5]); 
    	echo HTML::Error($model, '['.$index.']code');
    ?>

    <?php 
        echo HTML::activeLabel($model, '['.$index.']description');
    	echo HTML::activeInput('text', $model, '['.$index.']description',['maxlength'=> 250]); 
    	echo HTML::Error($model, '['.$index.']description');
    ?>

    <?php 
        echo HTML::activeLabel($model, '['.$index.']rate');
    	echo HTML::activeInput('text', $model, '['.$index.']rate'); 
    	echo HTML::Error($model, '['.$index.']rate');
    ?>

</div>

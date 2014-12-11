<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;

use app\models\ExtDeliverables;
use app\models\ConsultantPosition;
use app\models\ProjectRate;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-deliverables-form" id="ext-deliverables-[<?= $index ?>]" ?>
    <a style="cursor:pointer;text-decoration:none;" onclick="deleteIntDeliverables(this)">Delete</a>    
    </br>
    <?php 
        $dataCategory1 = [];
        $dataCategory1 += ArrayHelper::map(ExtDeliverables::find()->asArray()->all(), 'extdeliverableid', 'description');        

        echo HTML::activeLabel($model, '['.$index.']extdeliverableid');
    	echo HTML::activeDropDownList($model, '['.$index.']extdeliverableid', $dataCategory1, array('prompt'=>' ')); 
    	echo HTML::Error($model, '['.$index.']extdeliverableid');
    ?>

    <?php 
        echo HTML::activeLabel($model, '['.$index.']code');
    	echo HTML::activeInput('text', $model, '['.$index.']code',['maxlength'=> 5]); 
    	echo HTML::Error($model, '['.$index.']code');
    ?>

    <?php 
        $dataCategory2 = [];
        $dataCategory2 += ArrayHelper::map(ConsultantPosition::find()->asArray()->all(), 'positionid', 'name');        

        echo HTML::activeLabel($model, '['.$index.']positionid');
    	echo HTML::activeDropDownList($model, '['.$index.']positionid', $dataCategory2, array('prompt'=>' ')); 
    	echo HTML::Error($model, '['.$index.']positionid');
    ?>

    <?php 
        echo HTML::activeLabel($model, '['.$index.']description');
        echo HTML::activeInput('text', $model, '['.$index.']description',['maxlength'=> 250]); 
        echo HTML::Error($model, '['.$index.']description');
    ?>

    <?php 
        echo HTML::activeLabel($model, '['.$index.']frequency');
        echo HTML::activeInput('text', $model, '['.$index.']frequency');
        echo HTML::Error($model, '['.$index.']frequency');
    ?>

    <?php 
        $dataCategory3 = [];
        $dataCategory3 += ArrayHelper::map(ProjectRate::find()->asArray()->all(), 'rateid', 'role');        

        echo HTML::activeLabel($model, '['.$index.']rateid');
        echo HTML::activeDropDownList($model, '['.$index.']rateid', $dataCategory3, array('prompt'=>' ')); 
        echo HTML::Error($model, '['.$index.']rateid');
    ?>    
    
    <?php 
        echo HTML::activeLabel($model, '['.$index.']rate');
        echo HTML::activeInput('text', $model, '['.$index.']rate');
        echo HTML::Error($model, '['.$index.']rate');
    ?>

</div>

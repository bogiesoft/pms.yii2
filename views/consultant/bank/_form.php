<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultantBank */
/* @var $form ActiveForm */
?>
<div class="consultant-bank-form">

    <?php
        if ($model->hasErrors('bankid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
     <?php 

    $data = [];
    $sql = "select bankid, concat(code, ' - ', name) as descr  from ps_bank order by name";
    $data += yii\helpers\ArrayHelper::map(app\models\Bank::findBySql($sql)->asArray()->all(), 'bankid', 'descr'); 
    echo Html::activeHiddenInput($model, '[' . $index . ']consultantbankid');
    echo Html::activeLabel($model, '[' . $index . ']bankid', ['class'=>'col-sm-2 control-label']);
    echo '<div class="col-sm-10">';
    echo Html::activeDropDownList($model, '[' . $index . ']bankid', $data, [
        'class'=>'bankddl form-control select2',
    ]);
    echo Html::error($model, 'bankid', ['class'=>'help-block']);
    echo '</div>';
    ?>
    </div>

    <?php
        if ($model->hasErrors('branch')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']branch', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Html::activeTextInput($model, '[' . $index . ']branch', [
            'maxlength' => 50, 
            'class'=>'form-control branchinput',
        ]);
        echo Html::error($model, 'branch', ['class'=>'help-block']);
        echo '</div>';
    ?>
    </div>

    <?php
        if ($model->hasErrors('account')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']account', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Html::activeTextInput($model, '[' . $index . ']account', [
            'maxlength' => 15, 
            'class'=>'form-control accountinput',
            'style'=>'min-width:300px;',
        ]);
        echo Html::error($model, 'account', ['class'=>'help-block']);
        echo '</div>';
    ?>
    </div>

    <div class="form-group">
    <?php
        echo Html::activeLabel($model, '[' . $index . ']active', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo '<div class="checkbox">';
        echo Html::activeRadioList($model, '[' . $index . ']active', [
        '1'=>'Yes','0'=>'No'
        ]);
        echo Html::error($model, 'active', ['class'=>'help-block']);
        echo '</div></div>';
    ?>
    </div>

    <div class="form-group" style="margin-bottom:15px">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <a style="cursor:pointer; margin-right:5px" class="btnDeleteBank">Delete..</a>
            <a style="cursor:pointer;" class="btnAddBank">Add more bank account..</a>
        </div>
    </div>
        
</div><!-- consultant-bank-form -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Bank;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => 50]) ?>

    <?php 
        $dataCategory = [];
        array_push($dataCategory, ' ');
        $sql = "select bankid, concat(code,' - ',name) as bank_descr from ps_bank ";        
        $dataCategory += ArrayHelper::map(Bank::findBySql($sql)->asArray()->all(), 'bankid', 'bank_descr');        
    ?>

    <?= $form->field($model, 'BankId')->dropDownList($dataCategory) ?>

    <?= $form->field($model, 'BankAcc')->textInput(['maxlength' => 15]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

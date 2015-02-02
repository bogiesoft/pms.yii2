<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Bank;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 5, 'placeholder'=>'Enter unit code..']) ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => 50, 'placeholder'=>'Enter unit name..']) ?>

    <?php 
        $data = [];
        $sql = "select bankid, concat(code,' - ',name) as bank_descr from ps_bank ";        
        $data += ArrayHelper::map(Bank::findBySql($sql)->asArray()->all(), 'bankid', 'bank_descr');        

        echo $form->field($model, 'BankId')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select a bank..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?= $form->field($model, 'BankAcc')->textInput(['maxlength' => 15, 'placeholder'=>'Enter account number..']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreementPayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-agreement-payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $data = [];
        $sql = "select extdeliverableid, concat(code, ' - ', description) as descr from ps_extdeliverables where extdeliverableid = :1";
        $data += ArrayHelper::map(app\models\ExtDeliverables::findBySql($sql, [':1'=>Yii::$app->request->get('id')])->orderBy('name')->asArray()->all(), 'extdeliverableid', 'descr'); 

        echo $form->field($model, 'extdeliverableid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a external deliverable..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php
         echo $form->field($model, 'date')->widget(DatePicker::classname(), 
         [
            'options' => ['placeholder' => 'Enter date..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?= $form->field($model, 'remark')->textArea(['maxlength' => 250, 'placeholder'=>'Enter remark..', 'style'=>'height:120px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

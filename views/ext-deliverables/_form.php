<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-deliverables-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $dataCategory = [];
        array_push($dataCategory, ' ');
        $dataCategory += ArrayHelper::map(ExtAgreement::find()->asArray()->all(), 'extagreementid', 'description');        
    ?>

    <?= $form->field($model, 'extagreementid')->dropDownList($dataCategory) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\IntAgreement;
use app\models\ExtDeliverables;
use app\models\ConsultantPosition;
use app\models\ProjectRate;

/* @var $this yii\web\View */
/* @var $model app\models\IntDeliverables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="int-deliverables-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $dataCategory = [];
        $dataCategory += ArrayHelper::map(IntAgreement::find()->asArray()->all(), 'intagreementid', 'description');        
    ?>

    <?= $form->field($model, 'intagreementid')->dropDownList($dataCategory, array('prompt'=>' ')) ?>

    <?php 
        $dataCategory1 = [];
        $dataCategory1 += ArrayHelper::map(ExtDeliverables::find()->asArray()->all(), 'extdeliverableid', 'description');        
    ?>

    <?= $form->field($model, 'extdeliverableid')->dropDownList($dataCategory1, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>

    <?php 
        $dataCategory2 = [];
        $dataCategory2 += ArrayHelper::map(ConsultantPosition::find()->asArray()->all(), 'positionid', 'name');        
    ?>

    <?= $form->field($model, 'positionid')->dropDownList($dataCategory2, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'frequency')->textInput() ?>

    <?php 
        $dataCategory3 = [];
        $dataCategory3 += ArrayHelper::map(ProjectRate::find()->asArray()->all(), 'rateid', 'role');        
    ?>

    <?= $form->field($model, 'rateid')->dropDownList($dataCategory3, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'rate')->textInput() ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

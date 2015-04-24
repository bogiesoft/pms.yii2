<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Unit;
use app\models\Customer;
use app\models\ProductType;
use app\models\Status;
use kartik\select2\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Cancel Project: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->projectid]];
$this->params['breadcrumbs'][] = 'Cancel Project';
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="project-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'cancelremark')->textArea(['maxlength' => 250, 'style' => 'height:120px']) ?>

        <div class="form-group">
            <?= Html::submitButton('Cancel Project', ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
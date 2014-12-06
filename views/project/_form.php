<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Unit;
use app\models\Customer;
use app\models\ProductType;
use app\models\Status;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $dataCategory = [];
        array_push($dataCategory, ' ');
        $sql = "select unitid, concat(code,' - ',Name) as unit_descr from ps_unit ";        
        $dataCategory += ArrayHelper::map(Unit::findBySql($sql)->asArray()->all(), 'unitid', 'unit_descr');        
    ?>

    <?= $form->field($model, 'unitid')->dropDownList($dataCategory) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?php 
        $dataCategory1 = [];
        array_push($dataCategory1, ' ');                
        $dataCategory1 += ArrayHelper::map(Customer::find()->asArray()->all(), 'customerid', 'company');        
    ?>

    <?= $form->field($model, 'customerid')->dropDownList($dataCategory1) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <?php 
        $dataCategory2= [];
        array_push($dataCategory2, ' ');                
        $sql1 = "select producttypeid, concat(code,' - ',name) as producttype_descr from ps_producttype ";        
        $dataCategory2 += ArrayHelper::map(ProductType::findBySql($sql1)->asArray()->all(), 'producttypeid', 'producttype_descr');             
    ?>

    <?= $form->field($model, 'producttypeid')->dropDownList($dataCategory2) ?>

    <?= $form->field($model, 'initiationyear')->textInput(['maxlength' => 5]) ?>

    <?php 
        $dataCategory3= [];
        array_push($dataCategory3, ' ');                        
        $dataCategory3 += ArrayHelper::map(Status::find()->asArray()->all(), 'statusid', 'name');             
    ?>

    <?= $form->field($model, 'statusid')->dropDownList($dataCategory3) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

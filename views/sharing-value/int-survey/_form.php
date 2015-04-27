<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\SharingValueUnit */
/* @var $form ActiveForm */
?>
<style>
.col-md-2, .col-md-3, .col-md-4{
    padding-right:5px;
    padding-left:0px;
}
@media screen and (max-width: 1024px){
    .col-md-2, .col-md-3, .col-md-4{
        width:100%;
        width:100%;
    }
    .input-group.date{
        width:100%;   
    }
    .input-group-addon{
        width: 1% !important;
    }
}
.int-survey-form{
    clear:both;
}
</style>
<div class="int-survey-form">
    
    <div class="form-inline" role="form">

    <?php
        if ($model->hasErrors('consultantid')){
            echo '<div class="form-group required has-error col-md-4">';
        }else{
            echo '<div class="form-group col-md-4">';
        }
    ?>
    <?php
        
        $data = [];
        $sql = "select d.consultantid, d.name
            from ps_project a
            join ps_extagreement b on a.projectid = b.projectid
            join ps_intagreement c on b.extagreementid = c.extagreementid
            join ps_consultant d on c.consultantid = d.consultantid
            where a.projectid = :1";

        $data += ArrayHelper::map(app\models\Consultant::findBySql($sql, [':1'=>Yii::$app->request->get('projectid')])->orderBy('name')->asArray()->all(), 'consultantid', 'name'); 

        echo Html::activeHiddenInput($model, '[' . $index . ']intsurveryid');
        echo Select2::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']consultantid',
            'data'=>$data,
            'options' => [
                'placeholder' => 'Select a consultant..', 
                'class'=>'consultantddl form-control', 
                'style' => 'width:100%;'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        echo Html::error($model, 'consultantid', ['class'=>'help-block']);

    ?>    
    </div>

    <?php
        if ($model->hasErrors('score')){
            echo '<div class="form-group required has-error col-md-3">';
        }else{
            echo '<div class="form-group col-md-3">';
        }
    ?>
    <?php
        echo Html::activeTextInput($model, '[' . $index . ']score', ['class'=>'form-control', 'maxlength' => 16, 'style'=>'width:100%']);
        echo Html::error($model, '[' . $index . ']score', ['class'=>'help-block']);
    ?>    
    </div>
    
    <a type="button" class="btnAddIntScore btn btn-primary" style="vertical-align: top; margin-bottom:15px"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeleteIntScore btn btn-danger" style="vertical-align: top;margin-bottom:15px"><i class="glyphicon glyphicon-minus"></i></a>

    </div>

</div><!-- _form -->
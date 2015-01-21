<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;
use kartik\daterange\DateRangePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
.col-md-2, .col-md-4{
    padding-right:5px;
    padding-left:0px;
}
@media screen and (max-width: 1024px){
    .col-md-2, .col-md-4{
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
.ext-deliverables-form{
    clear:both;
}
</style>

<div class="ext-deliverables-form">
    
    <div class="form-inline" role="form">
    
    <?php
        if ($model->hasErrors('code')){
            echo '<div class="form-group required has-error col-md-2">';
        }else{
            echo '<div class="form-group col-md-2">';
        }
    ?>
    <?php
        echo Html::activeHiddenInput($model, '[' . $index . ']extdeliverableid');
        echo Html::activeTextInput($model, '[' . $index . ']code', [
            'maxlength' => 5, 'placeholder'=>'Enter number..',
            'class'=>'form-control codeinput',
            'style'=>'width:100%;',
        ]);
        echo Html::error($model, 'code', ['class'=>'help-block']);
    ?>    
    </div>

    <?php
        if ($model->hasErrors('description')){
            echo '<div class="form-group required has-error col-md-4">';
        }else{
            echo '<div class="form-group col-md-4">';
        }
    ?>
    <?php
        echo Html::activeTextInput($model, '[' . $index . ']description', [
            'maxlength' => 250, 'placeholder'=>'Enter deliverable name..',
            'class'=>'form-control descriptioninput',
            'style'=>'width:100%;',
        ]);
        echo Html::error($model, 'description', ['class'=>'help-block']);
    ?>    
    </div>

    <?php
        if ($model->hasErrors('rate')){
            echo '<div class="form-group required has-error col-md-2">';
        }else{
            echo '<div class="form-group col-md-2">';
        }
    ?>
    <?php
        echo Html::activeTextInput($model, '[' . $index . ']rate', [
            'maxlength' => 11, 'placeholder'=>'Enter investment..',
            'class'=>'form-control rateinput',
            'style'=>'width:100%;',
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]);
        echo Html::error($model, 'rate', ['class'=>'help-block']);
    ?>    
    </div>

    <?php
        if ($model->hasErrors('duedate')){
            echo '<div class="form-group required has-error col-md-2">';
        }else{
            echo '<div class="form-group col-md-2">';
        }
    ?>
    <?php
        echo DatePicker::widget([
            'model' => $model, 
            'attribute' => '[' . $index . ']duedate',
            'options' => ['placeholder' => 'Enter due date...', 'style'=>'width:100%;', 'class'=>'duedateinput'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format'=>'d.M.yyyy',
            ]
        ]);
        echo Html::error($model, 'duedate', ['class'=>'help-block']);
    ?>    
    </div>
    
    <a type="button" class="btnAddDeliverable btn btn-primary" style="vertical-align: top; margin-bottom:15px"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeleteDeliverable btn btn-danger" style="vertical-align: top;margin-bottom:15px"><i class="glyphicon glyphicon-minus"></i></a>

    </div>

</div>
<?php
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/igorescobar/jquery-2.1.1.min.js", [\yii\web\View::POS_END]);
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/igorescobar/jquery.mask.js", [\yii\web\View::POS_END]);
?>
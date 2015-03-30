<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;

use app\models\ExtDeliverables;
use app\models\ConsultantPosition;
use app\models\ProjectRate;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ext-deliverables-form">
    
    <div class="form-horizontal" role="form">

    <?php
        if ($model->hasErrors('extdeliverableid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        
        $data = [];
        $sql = "select extdeliverableid, concat(code, ' - ', description) as descr from ps_extdeliverables where extagreementid = :1";
        $data += ArrayHelper::map(ExtDeliverables::findBySql($sql, [':1' => $extagreementid])
            ->asArray()->all(), 'extdeliverableid', 'descr');

        echo Html::activeHiddenInput($model, '[' . $index . ']intdeliverableid');
        echo Html::activeLabel($model, '[' . $index . ']extdeliverableid', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Select2::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']extdeliverableid',
            'data'=>$data,
            'options' => [
                'placeholder' => 'Select external deliverable..', 
                'class'=>'extdeliverableddl form-control', 
                'style' => 'width:100%;'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        echo Html::error($model, 'extdeliverableid', ['class'=>'help-block']);
        echo '</div>';
    ?>    
    </div>

    <?php
        if ($model->hasErrors('positionid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php 
        $data2 = [];
        $data2 += ArrayHelper::map(ConsultantPosition::find()->asArray()->all(), 'positionid', 'name');        

        echo Html::activeLabel($model, '[' . $index . ']positionid', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Select2::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']positionid',
            'data'=>$data2,
            'options' => [
                'placeholder' => 'Select position..', 
                'class'=>'positionddl form-control',
                'style' => 'width:100%;'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        echo Html::error($model, 'positionid', ['class'=>'help-block']);
        echo '</div>';
    ?>
    </div>

    <?php
        if ($model->hasErrors('description')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']description', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Html::activeTextInput($model, '[' . $index . ']description', [
            'maxlength' => 250, 'placeholder'=>'Enter deliverable name..',
            'class'=>'form-control descriptioninput',
            'style'=>'width:100%;',
        ]);
        echo Html::error($model, 'description', ['class'=>'help-block']);
        echo '</div>';
    ?>    
    </div>

    <?php
        if ($model->hasErrors('frequency')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']frequency', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Html::activeTextInput($model, '[' . $index . ']frequency', [
            'maxlength' => 11, 'placeholder'=>'Enter frequency..',
            'class'=>'form-control frequencyinput',
            'style'=>'width:100%;',
        ]);
        echo Html::error($model, 'frequency', ['class'=>'help-block']);
        echo '</div>';
    ?>    
    </div>

    <?php
        if ($model->hasErrors('positionid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php 
        $data3 = [];
        $sql = "select ps_projectrate.rateid, concat(ps_projectrate.role, ' (', ps_mindunit.name, ') @', 
            CAST(format(ps_projectrate.rate, 2) as char character set utf8)) as descr
                from ps_projectrate
                left join ps_mindunit on ps_projectrate.mindunitid = ps_mindunit.mindunitid";
        $data3 += ArrayHelper::map(ProjectRate::findBySql($sql)->asArray()->all(), 'rateid', 'descr');         

        echo Html::activeLabel($model, '[' . $index . ']rateid', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo Select2::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']rateid',
            'data'=>$data3,
            'options' => [
                'placeholder' => 'Select rate unit..',
                'class'=>'rateddl form-control',
                'style' => 'width:100%;'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        echo Html::error($model, 'rateid', ['class'=>'help-block']);
        echo '</div>';
    ?>
    </div>

    <?php
        if ($model->hasErrors('rate')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']rate', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
        echo MaskMoney::widget([
            'model'=>$model,
            'attribute'=> '['.$index.']rate',
            'options'=>[
                'maxlength' => 11,
                'title'=>'Rate..',
                'style'=>'width:100%;',
                'class'=>'form-control rateinput',
                'readonly'=>true
            ],
            'pluginOptions' => [
                'prefix' => '',
                'suffix' => '',
                'allowNegative' => false,
                'thousands' => ',',
                'precision' => 2,
                'allowZero' => true,
            ]
        ]);
        echo Html::error($model, 'rate', ['class'=>'help-block']);
        echo '</div>';
    ?>    
    </div>

    <?php
        if ($model->hasErrors('duedate')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeLabel($model, '[' . $index . ']duedate', ['class'=>'col-sm-2 control-label']);
        echo '<div class="col-sm-10">';
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
        echo '</div>';
    ?>    
    </div>

    <div class="form-group" style="margin-bottom:20px">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <a style="cursor:pointer; margin-right:5px" class="btnDeleteDeliverable">Delete..</a>
            <a style="cursor:pointer;" class="btnAddDeliverable">Add more deliverable..</a>
        </div>
    </div>

    </div>

</div>
<script>
$('.rateddl').change(function(e){
    $form = $(this).closest('.ext-deliverables-form');
    var freq = $form.find('.frequencyinput').val();
    var rateid = $form.find('select.rateddl').val();

    $form.find('.rateinput[id*="disp"]').val(CalculateRate(freq, rateid));
    $form.find('.rateinput[id*="disp"]').focus().blur();
});

$('.frequencyinput').keyup(function(e){
    $form = $(this).closest('.ext-deliverables-form');
    var freq = $form.find('.frequencyinput').val();
    var rateid = $form.find('select.rateddl').val();

    $form.find('.rateinput[id*="disp"]').val(CalculateRate(freq, rateid));
    $form.find('.rateinput[id*="disp"]').focus().blur();
    $(this).focus();
});

$('.rateddl').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Rate unit cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.positionddl').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Consultant position cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.extdeliverableddl').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("External deliverable cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.frequencyinput').blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Frequency cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.descriptioninput').blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Deliverable name cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.duedateinput').blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.rateinput').blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Rate cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$('.duedateinput').change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

function CalculateRate(freq, rateid){
    if (freq == "" || rateid == ""){
        return "";
    }

    var rate = 0;

    $.ajax({
        url: "<?= yii\helpers\URL::toRoute('int-agreement/rate')?>?rateid="+rateid,
        async: false,
        success: function(data){
            rate = freq * data;
        }
    });    

    return rate.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

</script>
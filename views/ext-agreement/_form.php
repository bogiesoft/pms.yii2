<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;
use kartik\select2\Select2;

use kartik\daterange\DateRangePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.tag{
    font-size:11px;
    vertical-align:middle;
}
</style>
<div class="ext-agreement-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
        $dataCategory = [];
        $sql = "select projectid, concat(code,' - ',name) as project_descr from ps_project where projectid = ".$model->projectid;        
        $dataCategory += ArrayHelper::map(Project::findBySql($sql)->asArray()->all(), 'projectid', 'project_descr');        

        echo $form->field($model, 'projectid')->widget(Select2::classname(), [
            'data' =>$dataCategory,
            'options' => ['placeholder' => 'Select a Project ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'agreementno')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style' => 'height:120px']) ?>

    <?php
        echo $form->field($model, 'startdate')->widget(DateRangePicker::classname(),
        [
            'convertFormat'=>true,
            'useWithAddon'=>true,
            'hideInput'=>1, 
            'pluginOptions'=>[
                'format'=>'d.M.Y',
                'separator'=>' - '
            ],

        ]);
    ?>

    <?php
        echo $form->field($model, 'signdate')->widget(DatePicker::classname(),
        [
            'options' => ['placeholder' => 'Enter sign date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd.M.yyyy'
            ]       

        ]);
    ?>

    <?php
        echo $form->field($model, 'ppn')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'suffix' => '',
                'allowNegative' => false,
                'precision' => 2,
                'allowZero' => true,
            ],
            'options'=>[
                'maxlength' => 5,
            ],
        ]);
    ?>

    <?= Html::activeHiddenInput($model, 'filename') ?> 

    <?= $form->field($model, 'file', ['template' => 
        '<label class="control-label" for="extagreement-file">File <i class="tag">(upload the signed document)</i></label>{input}{hint}{error}'
    ])->fileInput() ?> 

    <div>
        <label class="control-label">External Deliverables</label>
        <div id="ext-deliverables">
        <?php
            $index = 1;
            if (isset($model_extdeliverables) && $model_extdeliverables != null){
                //var_dump($model_extdeliverables);
                foreach($model_extdeliverables as $extDev){
                    echo $this->render('ext-deliverables/_form',  ['model' => $extDev, 'index' => $index]);
                    $index++;
                }
            }
        ?>
        </div>
    </div>

    <div class="form-group" style="clear:both">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php    

$this->registerJs('
var _index = ' . $index . ';

function addDeliverable(){
    var _url = "' . yii\helpers\Url::toRoute('ext-agreement/add') . '?index="+_index;
    $.ajax({
        url: _url,
        async: false,
        dataType: "html",
        success:function(response){
            $("#ext-deliverables").append(response);
            $("#ext-deliverables .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnAddDeliverable").click(function (elm){
                $(".btnAddDeliverable").unbind( "click" );
                elm.stopImmediatePropagation();
                addDeliverable();
            });

            $(".btnDeleteDeliverable").click(function (elm){ 
                if ($(".ext-deliverables-form").length >1){
                    element=$(elm.currentTarget).closest(".ext-deliverables-form");
                    /* animate div */
                    $(element).animate(
                    {
                        opacity: 0.25,
                        left: "+=50",
                        height: "toggle"
                    }, 400,
                    function() {
                        /* remove div */
                        $(element).remove();
                        if ($("#ext-deliverables").find("div.has-error").length < 1){
                            $("#ext-deliverables").find("label").css("color", "");
                        }
                    });
                }else{
                    alert("Required at least one external deliverable.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".codeinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Number cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });

            $(".descriptioninput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-4");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Deliverable name cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-4");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });

            $(".rateinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Investment cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });

            $(".duedateinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });

            $(".duedateinput").change(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });
        }
    });

    _index++;
}

if ($("#ext-deliverables").find(".ext-deliverables-form").length == 0){
    addDeliverable();
}

$(".btnAddDeliverable").click(function (elm){
    $(".btnAddDeliverable").unbind( "click" );
    elm.stopImmediatePropagation();
    addDeliverable();
});

$(".btnDeleteDeliverable").click(function (elm){ 
    if ($(".ext-deliverables-form").length >1){
        element=$(elm.currentTarget).closest(".ext-deliverables-form");
        /* animate div */
        $(element).animate(
        {
            opacity: 0.25,
            left: "+=50",
            height: "toggle"
        }, 400,
        function() {
            /* remove div */
            $(element).remove();
            if ($("#ext-deliverables").find("div.has-error").length < 1){
                $("#ext-deliverables").find("label").css("color", "");
            }
        });
        
    }else{
        alert("Required at least one external deliverable.");
        elm.stopImmediatePropagation();
    }                
});

$(".codeinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Number cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".descriptioninput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-4");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Deliverable name cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-4");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".rateinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Investment cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".duedateinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".duedateinput").change(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success col-md-2");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

//////////////////////////////////////////////////////Form Submit/////////////////////////////////////////////////
$("#w0").submit(function(e){
    var flag = true;
    $("#ext-deliverables .codeinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error col-md-2");
            $(this).closest(".form-group").find(".help-block").text("Number cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success col-md-2");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#ext-deliverables .descriptioninput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error col-md-4");
            $(this).closest(".form-group").find(".help-block").text("Deliverable name cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success col-md-4");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#ext-deliverables .rateinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error col-md-2");
            $(this).closest(".form-group").find(".help-block").text("Investment cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success col-md-2");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#ext-deliverables .duedateinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error col-md-2");
            $(this).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success col-md-2");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    return flag;
});

')

?>
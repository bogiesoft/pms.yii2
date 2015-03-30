<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;
use app\models\Consultant;
use app\models\Department;

use kartik\daterange\DateRangePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-horizontal .form-group{
        margin-bottom: 0px;
        vertical-align: top !important;
    }
    .tag{
        font-size:11px;
        vertical-align:middle;
    }
</style>
<div class="int-agreement-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 

        $data = [];
        $sql = "select extagreementid, concat(agreementno, ' - ', description) as descr from ps_extagreement where extagreementid = :1";
        $data += ArrayHelper::map(ExtAgreement::findBySql($sql, [':1' => Yii::$app->request->get('extagreementid')])->asArray()->all(), 'extagreementid', 'descr');

        echo $form->field($model, 'extagreementid')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select External Agreement ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php 
        $dataCategory1 = [];
        $dataCategory1 += ArrayHelper::map(Consultant::find()->asArray()->all(), 'consultantid', 'name');        

        echo $form->field($model, 'consultantid')->widget(Select2::classname(), [
            'data' =>$dataCategory1,
            'options' => ['placeholder' => 'Select Consultant ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php 
        $dataCategory2 = [];
        $dataCategory2 += ArrayHelper::map(Department::find()->asArray()->all(), 'departmentid', 'name');        

        echo $form->field($model, 'departmentid')->widget(Select2::classname(), [
            'data' =>$dataCategory2,
            'options' => ['placeholder' => 'Select Department ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

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

    <?= $form->field($model, 'file', ['template' => 
        '<label class="control-label" for="intagreement-file">File <i class="tag">(upload the signed document)</i></label>{input}{hint}{error}'
    ])->fileInput() ?> 

<label class="control-label">Internal Deliverables</label>
<div class="panel panel-default">
<div class="panel-body">
    <div>
        <div id="int-deliverables">
            <?php
                $index = 1;
                if (isset($model_intdeliverables) && $model_intdeliverables != null){
                    foreach($model_intdeliverables as $deliverable){
                        echo $this->render('int-deliverables/_form',  [
                            'model' => $deliverable, 
                            'index' => $index,
                            'extagreementid'=>Yii::$app->request->get('extagreementid')
                        ]);
                        $index++;
                    }
                }
            ?>
        </div>
    </div>
</div></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php    
    
$this->registerJs('
var _index = ' . $index . ';

function addDeliverable(){
    var _url = "' . yii\helpers\Url::toRoute('int-agreement/add') . '?index="+_index+"&extagreementid='. Yii::$app->request->get('extagreementid') .'";
    $.ajax({
        url: _url,
        async: false,
        dataType: "html",
        success:function(response){
            $("#int-deliverables").append(response);
            $("#int-deliverables .crow").last().animate({
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
                        if ($("#int-deliverables").find("div.has-error").length < 1){
                            $("#int-deliverables").find("label").css("color", "");
                        }
                    });

                }else{
                    alert("Required at least one internal deliverable.");
                    elm.stopImmediatePropagation();
                }                
            });
        }
    });

    _index++;
}

if ($("#int-deliverables").find(".ext-deliverables-form").length == 0){
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
            if ($("#int-deliverables").find("div.has-error").length < 1){
                $("#int-deliverables").find("label").css("color", "");
            }
        });
        

    }else{
        alert("Required at least one internal deliverable.");
        elm.stopImmediatePropagation();
    }                
});

//////////////////////////////////////////////////////Form Submit/////////////////////////////////////////////////
$("#w0").submit(function(e){
    var flag = true;
console.log(1);
    $("select.rateddl").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Rate unit cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("select.positionddl").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Consultant position cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("select.positionddl").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Consultant position cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("select.extdeliverableddl").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("External deliverable cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $(".frequencyinput").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Frequency cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });
    
    $(".descriptioninput").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Deliverable name cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $(".duedateinput").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Due date cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    return flag;
});

$(document).ready(function(){
    $(document).find(".ext-deliverables-form").each(function( index ) {
        var freq = $(this).find(".frequencyinput").val();
        var rateid = $(this).find("select.rateddl").val();
        $(this).find(".rateinput[id*=\'disp\']").val(CalculateRate(freq, rateid));
        $(this).find(".rateinput[id*=\'disp\']").focus().blur();
    });
});


')

?>

<script>
    function deleteIntDeliverables(e){
        $(e).parent().remove();        
    }
</script>
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
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        echo $form->field($model, 'initiationyear')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter initiation date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?php 
        $data = [];
        $sql = "select unitid, concat(code,' - ',Name) as unit_descr from ps_unit order by name";        
        $data += ArrayHelper::map(Unit::findBySql($sql)->asArray()->all(), 'unitid', 'unit_descr');        

        echo $form->field($model, 'unitid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a unit ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?php 
        $data = [];         
        $data += ArrayHelper::map(Customer::find()->orderBy('company')->asArray()->all(), 'customerid', 'company');        

        echo $form->field($model, 'customerid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a customer ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style' => 'height:120px']) ?>

    <?php 
        $data= [];
        $sql1 = "select producttypeid, concat(code,' - ',name) as producttype_descr from ps_producttype order by name";        
        $data += ArrayHelper::map(ProductType::findBySql($sql1)->asArray()->all(), 'producttypeid', 'producttype_descr');

        echo $form->field($model, 'producttypeid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a product type ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);             
    ?>
    
    <div class="form-group">
    <label class="control-label" for="project-statusid">Project PICs</label>
    <div id="project-pic">
        <?php
            $index = 1;
            if (isset($model_projectpic)){
                foreach($model_projectpic as $projectpic){
                    echo $this->render('project-pic/_form', [
                        'model' => $projectpic,
                        'index' => $index,
                    ]);
                    $index++;
                }   
            }
        ?>
    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php    
$this->registerJs('
var _index = "'.$index.'";

function addUser(){
    var _url = "' . yii\helpers\Url::toRoute('project/add') . '?index="+_index;
    $.ajax({
        url: _url,
        async: false,
        success:function(response){
            $("#project-pic").append(response);
            $("#project-pic .select2").select2();
            $("#project-pic .select2").removeClass("select2");
            $("#project-pic .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnDeleteUser").click(function (elm){ 
                if ($(".project-pic-form").length >1){
                    element=$(elm.currentTarget).closest(".project-pic-form");
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
                        if ($("#project-pic").find("div.has-error").length < 1){
                            $("#project-pic").find("label").css("color", "");
                        }
                    });
                }else{
                    alert("Required at least one project pic.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".btnAddUser").click(function (elm){
                $(".btnAddUser").unbind( "click" );
                elm.stopImmediatePropagation();
                addUser();
            });
        }
    });

    _index++;
}

$(".btnDeleteUser").click(function (elm){ 
    if ($(".project-pic-form").length >1){
        element=$(elm.currentTarget).closest(".project-pic-form");
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
            if ($("#project-pic").find("div.has-error").length < 1){
                $("#project-pic").find("label").css("color", "");
            }
        });
    }else{
        alert("Required at least one project pic.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnAddUser").click(function (elm){
    $(".btnAddUser").unbind( "click" );
    elm.stopImmediatePropagation();
    addUser();
});

$("#project-pic .select2").select2();
$("#project-pic .select2").removeClass("select2");

if ($("#project-pic").find(".project-pic-form").length == 0){
    addUser();
}

')

?>

<script>
    function deletePhone(e){
        $(e).parent().remove();        
    }
</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    .form-inline .form-control{
        width:100% !important;
    }
    .form-inline .form-group{
        margin-right: 0px !important;
        margin-left: 0px !important;
    }
    .form-group{
        margin-bottom: 0px;
        vertical-align: top !important;
    }
</style>
<div class="customer-form">

<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <i class="glyphicon glyphicon-info-sign"></i> Customer Information
  </div>
  <div class="panel-body">
<?php
    echo $form->field($model, 'company',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 50, 'placeholder'=>'Enter customer name..']);
    
    echo $form->field($model, 'dayofjoin',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Enter customer join date..'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);

    echo $form->field($model, 'npwp',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 20, 'placeholder'=>'Enter customer NPWP..']);

    echo $form->field($model, 'phone',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 15, 'placeholder'=>'Enter customer phone number..']);

    echo $form->field($model, 'fax',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 15, 'placeholder'=>'Enter customer fax number..']);

    echo $form->field($model, 'address',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textArea(['maxlength' => 150,'style'=>'height:120px', 'placeholder'=>'Enter customer address..']);

    echo $form->field($model, 'city',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 50, 'placeholder'=>'Enter the city where the customer is located..']);

    echo $form->field($model, 'state',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 50, 'placeholder'=>'Enter the state where the customer is located..']);

    $data = [];
    $sql = 'select countryid, concat(iso3, " - ", name) as descr from ps_country order by name';
    $data += ArrayHelper::map(app\models\Country::findBySql($sql)->orderBy('name')->asArray()->all(), 'countryid', 'descr'); 

    echo $form->field($model, 'countryid',[
                    'labelOptions' => [
                    'class' => 'col-sm-2 control-label'
                ],
                'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
            ])->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select the country where the customer is located...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    $data = [];
    $data += ArrayHelper::map(app\models\PartnerType::find()->orderBy('name')->asArray()->all(), 'partnertypeid', 'name'); 

    echo $form->field($model, 'partnertypeid',[
                    'labelOptions' => [
                    'class' => 'col-sm-2 control-label'
                ],
                'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
            ])->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select customer partner type..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    
    echo $form->field($model, 'webpage',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 150, 'placeholder'=>'Enter webpage URL..']);
    
    echo $form->field($model, 'global',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10" style="margin-top:7px">{input}{error}{hint}</div>'
        ])->radioList(['1'=>'Yes', '0'=>'No'],['separator'=>'<span style="margin-right:20px"></span>']);

echo '</div></div>';
    echo '<div class="divcontact panel panel-default"><div class="panel-heading">
    <i class="glyphicon glyphicon-user"></i> Contact Person
  </div><div id="contact" class="panel-body">';
            
            if (isset($contacts) && $contacts != null){
                $index = 1;
                $indexPhone = 1;
                foreach($contacts as $contact){
                    echo $this->render('contact/_form',  ['model' => $contact, 'index' => $index, 'indexPhone' => $indexPhone]);
                    $indexPhone = $indexPhone + count($contact->phones);
                    $index++;
                }
            }
    echo '</div></div>';

?>

    <div class="form-group" style="margin-top:15px; margin-left:0px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs('
var _index = ' . $index . ';
var _indexPhone = ' . $indexPhone . ';

function addContact(){
    var _url = "' . yii\helpers\Url::toRoute('customer/render-contact') . '?index="+_index;
    $.ajax({
        url: _url,
        async: false,
        success:function(response){
            $("#contact").append(response);
            $("#contact .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });
            $(".btnDelete").click(function (elm){ 
                if ($(".contact-person-form").length >1){
                    element=$(elm.currentTarget).closest(".contact-person-form");
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
                        if ($("#contact").find("div.has-error").length < 1){
                            $(".divcontact").find("label").css("color", "");
                        }
                    });
                    

                }else{
                    alert("Required at least one contact person.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".btnAdd").click(function (elm){
                $( ".btnAdd").unbind( "click" );
                elm.stopImmediatePropagation();
                addContact();
            });
        }
    });

    if ($(".divphone-"+_index).find("input").length == 0){
        addPhone(_index);
    }
    _index++;
}

function addPhone($id){
    var _url = "' . yii\helpers\Url::toRoute('customer/render-contact-phone') . '?index="+_indexPhone+"&target="+$id;
    $.ajax({
        url: _url,
        async: false,
        success:function(response){
            $(".ContactPerson-"+$id).append(response);
            $(".ContactPerson-"+$id + " .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnDeletePhone").click(function (elm){ 

                if ($(elm.target).closest(".contact-person-form").find(".contact-person-phone-form").length > 1){
                    element=$(elm.currentTarget).closest(".contact-person-phone-form");
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
                        if ($(".ContactPerson-"+$id).find("div.has-error").length < 1){
                            $(".label-phone-"+$id).css("color", "");
                        }
                    });
                }else{
                    alert("Required at least one contact person phone.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".btnAddPhone").click(function (elm){
                $( ".btnAddPhone").unbind( "click" );
                elm.stopImmediatePropagation();
                addPhone($(elm.currentTarget).attr("data-target"));
            });
        }
    });
    _indexPhone++;
}

if ($("#contact").find("input").length == 0){
    addContact();
}

$("#w0").submit(function(e){
    var flag = true;
    $("#contact .nameinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Name cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#contact .emailinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Email cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#contact .jobinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Job cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#contact .phoneinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Phone cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#contact select.phonetypeddl").each(function(e){
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Phone type cannot be blank.");
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

$(".btnAdd").click(function (elm){
    $( ".btnAdd").unbind( "click" );
    elm.stopImmediatePropagation();
    addContact();
});

$(".btnDelete").click(function (elm){ 
    if ($(".contact-person-form").length >1){
        element=$(elm.currentTarget).closest(".contact-person-form");
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
            if ($("#contact").find("div.has-error").length < 1){
                $(".divcontact").find("label").css("color", "");
            }
        });
        

    }else{
        alert("Required at least one contact person.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnDeletePhone").click(function (elm){ 

    if ($(elm.target).closest(".contact-person-form").find(".contact-person-phone-form").length > 1){
        element=$(elm.currentTarget).closest(".contact-person-phone-form");
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
            if ($(".ContactPerson-"+$id).find("div.has-error").length < 1){
                $(".label-phone-"+$id).css("color", "");
            }
        });
    }else{
        alert("Required at least one contact person phone.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnAddPhone").click(function (elm){
    $( ".btnAddPhone").unbind( "click" );
    elm.stopImmediatePropagation();
    addPhone($(elm.currentTarget).attr("data-target"));
});

');
?>
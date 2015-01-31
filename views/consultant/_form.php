<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */
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
    .radio label, .checkbox label:first-child{
        padding-left: 0px;
    }
</style>
<div class="consultant-form">

<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

<div class="panel panel-default">

<div class="panel-heading"><i class="fa fa-info-circle"></i> Consultant Information</div>
<div class="panel-body">
    <?= $form->field($model, 'lectureid',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'employeeid',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'name',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'residentid',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 50]) ?>
    
    <?= $form->field($model, 'npwp',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->textInput(['maxlength' => 20]) ?>
    
    <?php

        $data = [];
        $sql = 'select categoryid, category from ps_category order by category';
        $data += ArrayHelper::map(app\models\Category::findBySql($sql)->orderBy('category')->asArray()->all(), 'categoryid', 'category'); 

        echo $form->field($model, 'categoryid',[
                'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ],
            'template' => '{label}<div class="col-sm-10">{input}{error}{hint}</div>'
        ])->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a category ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>    
</div></div>

<div class="panel panel-default">

<div class="panel-heading"><i class="fa fa-phone"></i> Consultant Phones</div>
<div class="panel-body">
    
    <div class="form-group">
    <label class="col-sm-2 control-label">Phones</label>
    <div id="phone" class="col-sm-10">
        <?php
            if (isset($phones) && $phones != null){
                $index = 1;
                foreach($phones as $ph){
                    echo $this->render('phone/_form',  ['model' => $ph, 'index' => $index]);
                    $index++;
                }
            }
        ?>
    </div>
    </div>

</div></div>

<div class="panel panel-default">

<div class="panel-heading"><i class="fa fa-envelope"></i> Consultant Emails</div>
<div class="panel-body">
    
    <div class="form-group">
    <label class="col-sm-2 control-label">Emails</label>
    <div id="email" class="col-sm-10">
        <?php
            if (isset($emails) && $emails != null){
                $indexEmail = 1;
                foreach($emails as $em){
                    echo $this->render('email/_form',  ['model' => $em, 'index' => $indexEmail]);
                    $indexEmail++;
                }
            }
        ?>
    </div>
    </div>

</div></div>

<div class="panel panel-default">

<div class="panel-heading"><i class="fa fa-bank"></i> Consultant Banks</div>
<div class="panel-body">

    <div id="bank">
        <?php
            if (isset($banks) && $banks != null){
                $indexBank = 1;
                foreach($banks as $bk){
                    echo $this->render('bank/_form',  ['model' => $bk, 'index' => $indexBank]);
                    $indexBank++;
                }
            }
        ?>
    </div>


</div></div>

    <div class="form-group" style="margin-top:15px; margin-left:0px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs('
var _index = ' . $index . ';
var _indexEmail = ' . $indexEmail . ';
var _indexBank = ' . $indexBank . ';

function addPhone(){
    var _url = "' . yii\helpers\Url::toRoute('consultant/render-phone') . '?index="+_index;
    $.ajax({
        url: _url,
        async: false,
        success:function(response){
            $("#phone").append(response);
            $("#phone .select2").select2();
            $("#phone .select2").removeClass("select2");
            $("#phone .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnDeletePhone").click(function (elm){ 
                if ($(".consultant-phone-form").length >1){
                    element=$(elm.currentTarget).closest(".consultant-phone-form");
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
                        if ($("#phone").find("div.has-error").length < 1){
                            $("#phone").find("label").css("color", "");
                        }
                    });
                    

                }else{
                    alert("Required at least one consultant phone.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".btnAddPhone").click(function (elm){
                $(".btnAddPhone").unbind( "click" );
                elm.stopImmediatePropagation();
                addPhone();
            });

            $(".phoneinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Phone cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });
        }
    });

    _index++;
}

$(".btnDeletePhone").click(function (elm){ 
    if ($(".consultant-phone-form").length >1){
        element=$(elm.currentTarget).closest(".consultant-phone-form");
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
            if ($("#phone").find("div.has-error").length < 1){
                $("#phone").find("label").css("color", "");
            }
        });
        

    }else{
        alert("Required at least one consultant phone.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnAddPhone").click(function (elm){
    $(".btnAddPhone").unbind( "click" );
    elm.stopImmediatePropagation();
    addPhone();
});

$(".phoneinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Phone cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$("#phone .select2").select2();
$("#phone .select2").removeClass("select2");

function addEmail(){
    var _url = "' . yii\helpers\Url::toRoute('consultant/render-email') . '?index="+_indexEmail;
    $.ajax({
        url: _url,
        async: false,
        success:function(response){
            $("#email").append(response);
            $("#email .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnDeleteEmail").click(function (elm){ 
                if ($(".consultant-email-form").length >1){
                    element=$(elm.currentTarget).closest(".consultant-email-form");
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
                        if ($("#email").find("div.has-error").length < 1){
                            $("#email").find("label").css("color", "");
                        }
                    });
                }else{
                    alert("Required at least one consultant email.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".btnAddEmail").click(function (elm){
                $(".btnAddEmail").unbind( "click" );
                elm.stopImmediatePropagation();
                addEmail();
            });

            $(".emailinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Email cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });
        }
    });

    _indexEmail++;
}

$(".btnDeleteEmail").click(function (elm){ 
    if ($(".consultant-email-form").length >1){
        element=$(elm.currentTarget).closest(".consultant-email-form");
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
            if ($("#email").find("div.has-error").length < 1){
                $("#email").find("label").css("color", "");
            }
        });
    }else{
        alert("Required at least one consultant email.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnAddEmail").click(function (elm){
    $(".btnAddEmail").unbind( "click" );
    elm.stopImmediatePropagation();
    addEmail();
});

$(".emailinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Email cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

function addBank(){
    var _url = "' . yii\helpers\Url::toRoute('consultant/render-bank') . '?index="+_indexBank;
    $.ajax({
        url: _url,
        async: false,
        success:function(response){
            $("#bank").append(response);
            $("#bank .select2").select2();
            $("#bank .select2").removeClass("select2");
            $("#bank .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnDeleteBank").click(function (elm){ 
                if ($(".consultant-bank-form").length >1){
                    element=$(elm.currentTarget).closest(".consultant-bank-form");
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
                        if ($("#bank").find("div.has-error").length < 1){
                            $("#bank").find("label").css("color", "");
                        }
                    });
                }else{
                    alert("Required at least one consultant bank account.");
                    elm.stopImmediatePropagation();
                }                
            });

            $(".btnAddBank").click(function (elm){
                $(".btnAddBank").unbind( "click" );
                elm.stopImmediatePropagation();
                addBank();
            });

            $(".branchinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Branch cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });

            $(".accountinput").blur(function(e){
                if ($(e.currentTarget).val() == ""){
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("Account cannot be blank.");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
                    $(e.currentTarget).closest(".form-group").find(".help-block").text("");
                    $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
                }
            });
        }
    });

    _indexBank++;
}

$("#bank .select2").select2();
$("#bank .select2").removeClass("select2");

$(".btnDeleteBank").click(function (elm){ 
    if ($(".consultant-bank-form").length >1){
        element=$(elm.currentTarget).closest(".consultant-bank-form");
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
            if ($("#bank").find("div.has-error").length < 1){
                $("#bank").find("label").css("color", "");
            }
        });
    }else{
        alert("Required at least one consultant bank account.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnAddBank").click(function (elm){
    $(".btnAddBank").unbind( "click" );
    elm.stopImmediatePropagation();
    addBank();
});

$(".branchinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Branch cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".accountinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Account cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

if ($("#phone").find(".consultant-phone-form").length == 0){
    addPhone();
}
if ($("#email").find(".consultant-email-form").length == 0){
    addEmail();
}
if ($("#bank").find(".consultant-bank-form").length == 0){
    addBank();
}

$("#w0").submit(function(e){
    var flag = true;
    $("#phone .phoneinput").each(function( e ) {
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

    $("#email .emailinput").each(function( e ) {
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

    $("#bank .branchinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Branch cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $("#bank .accountinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Account cannot be blank.");
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


', \yii\web\View::POS_END);
?>
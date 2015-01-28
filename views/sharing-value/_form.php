<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\SharingValueUnit;
use app\models\SharingValueDepartment;

/* @var $this yii\web\View */
/* @var $model app\models\SharingValueDepartment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sharing-value-department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $data = [];
        $sql = "select projectid, concat(code, ' - ', name) as descr from ps_project where projectid = :1";
        $data += ArrayHelper::map(app\models\Project::findBySql($sql, [':1'=>Yii::$app->request->get('projectid')])->orderBy('name')->asArray()->all(), 'projectid', 'descr'); 

        echo $form->field($model, 'projectid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a project..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <div style="clear:both;">
        <label class="control-label">Sharing Value Unit</label>
        <div id="sharing-unit">
            <?php
                $index = 1;
                if (isset($units)){
                    foreach($units as $model_unit){
                        echo $this->render('sharing-unit/_form', [
                            'model'=>$model_unit,
                            'index'=>$index,
                        ]);
                        $index++;
                    }   
                }
            ?>
        </div>
    </div>

    <div style="clear:both;">
        <label class="control-label">Sharing Value Department</label>
        <div id="sharing-department">
            <?php
                $index1 = 1;
                if (isset($departments)){
                    foreach($departments as $model_department){
                        echo $this->render('sharing-department/_form', [
                            'model'=>$model_department,
                            'index'=>$index1,
                        ]);
                        $index1++;
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
var _index1 = ' . $index1 . ';

function addSharingUnit(){
    var _url = "' . yii\helpers\Url::toRoute('sharing-value/render-sharing-unit') . '?index="+_index;
    $.ajax({
        url: _url,
        async: false,
        dataType: "html",
        success:function(response){
            $("#sharing-unit").append(response);
            $("#sharing-unit .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnAddSharingUnit").click(function (elm){
                $(".btnAddSharingUnit").unbind( "click" );
                elm.stopImmediatePropagation();
                addSharingUnit();
            });

            $(".btnDeleteSharingUnit").click(function (elm){ 
                if ($(".sharing-unit-form").length >1){
                    element=$(elm.currentTarget).closest(".sharing-unit-form");
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
                        if ($("#sharing-unit").find("div.has-error").length < 1){
                            $("#sharing-unit").find("label").css("color", "");
                        }
                    });
                    

                }else{
                    alert("Required at least one unit.");
                    elm.stopImmediatePropagation();
                }                
            });
        }
    });

    _index++;
}

function addSharingDepartment(){
    var _url = "' . yii\helpers\Url::toRoute('sharing-value/render-sharing-department') . '?index="+_index1;
    $.ajax({
        url: _url,
        async: false,
        dataType: "html",
        success:function(response){
            $("#sharing-department").append(response);
            $("#sharing-department .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });

            $(".btnAddSharingDepartment").click(function (elm){
                $(".btnAddSharingDepartment").unbind( "click" );
                elm.stopImmediatePropagation();
                addSharingDepartment();
            });

            $(".btnDeleteSharingDepartment").click(function (elm){ 
                if ($(".sharing-department-form").length >1){
                    element=$(elm.currentTarget).closest(".sharing-department-form");
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
                        if ($("#sharing-department").find("div.has-error").length < 1){
                            $("#sharing-department").find("label").css("color", "");
                        }
                    });
                    

                }else{
                    alert("Required at least one department.");
                    elm.stopImmediatePropagation();
                }                
            });
        }
    });

    _index1++;
}

if ($("#sharing-unit").find(".sharing-unit-form").length == 0){
    addSharingUnit();
}

if ($("#sharing-department").find(".sharing-department-form").length == 0){
    addSharingDepartment();
}

////////////////////////////////////////////////////Button Action//////////////////////////////////
$(".btnAddSharingUnit").click(function (elm){
    $(".btnAddSharingUnit").unbind( "click" );
    elm.stopImmediatePropagation();
    addSharingUnit();
});

$(".btnDeleteSharingUnit").click(function (elm){ 
    if ($(".sharing-unit-form").length >1){
        element=$(elm.currentTarget).closest(".sharing-unit-form");
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
            if ($("#sharing-unit").find("div.has-error").length < 1){
                $("#sharing-unit").find("label").css("color", "");
            }
        });
        

    }else{
        alert("Required at least one unit.");
        elm.stopImmediatePropagation();
    }                
});

$(".btnAddSharingDepartment").click(function (elm){
    $(".btnAddSharingDepartment").unbind( "click" );
    elm.stopImmediatePropagation();
    addSharingDepartment();
});

$(".btnDeleteSharingDepartment").click(function (elm){ 
    if ($(".sharing-department-form").length >1){
        element=$(elm.currentTarget).closest(".sharing-department-form");
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
            if ($("#sharing-department").find("div.has-error").length < 1){
                $("#sharing-department").find("label").css("color", "");
            }
        });
        

    }else{
        alert("Required at least one department.");
        elm.stopImmediatePropagation();
    }                
});


')

?>
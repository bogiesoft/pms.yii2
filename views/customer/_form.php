<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => 50]) ?>

    <?php
        echo $form->field($model, 'dayofjoin')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter join date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'd-M-yyyy'
            ]
        ]);
    ?>

    <?= $form->field($model, 'npwp')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'address')->textArea(['maxlength' => 150,'style'=>'height:120px']) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => 50]) ?>

    <?php
        $data = [];
        $sql = 'select countryid, concat(iso3, " - ", name) as descr from ps_country order by name';
        $data += ArrayHelper::map(app\models\Country::findBySql($sql)->orderBy('name')->asArray()->all(), 'countryid', 'descr'); 

        echo $form->field($model, 'countryid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a country ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <?php
        $data = [];
        $data += ArrayHelper::map(app\models\PartnerType::find()->orderBy('name')->asArray()->all(), 'partnertypeid', 'name'); 

        echo $form->field($model, 'partnertypeid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a partner type ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

    ?>

    <div style="margin-top:-3px" class="form-group divcontact">
        <div id="contact">

        </div>
    </div>

    <?= $form->field($model, 'webpage')->textInput(['maxlength' => 150]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs('
var _index = ' . $index . ';
function addContact(){
    var _url = "' . yii\helpers\Url::toRoute('customer/render-contact') . '?index="+_index;
    $.ajax({
        url: _url,
        success:function(response){
            $("#contact").append(response);
            $("#contact .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });
            $(".btnDeletePhone").click(function (elm){ 
                if ($("#contact").find("input").length >1){
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
                    alert("Required at least one phone number.");
                }                
            });

            $(".btnAddPhone").click(function (elm){
                $( ".btnAddPhone").unbind( "click" );
                addContact();
            });
        }
    });
    _index++;
}

if ($("#contact").find("input").length == 0){
    addContact();
}



', \yii\web\View::POS_END);
?>
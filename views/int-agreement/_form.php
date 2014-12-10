<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ExtAgreement;
use app\models\Consultant;
use app\models\Department;
//use yii\jui\DatePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="int-agreement-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
        $dataCategory = [];
        $dataCategory += ArrayHelper::map(ExtAgreement::find()->asArray()->all(), 'extagreementid', 'description');        
    ?>

    <?= $form->field($model, 'extagreementid')->dropDownList($dataCategory, array('prompt'=>' ')) ?>

    <?php 
        $dataCategory1 = [];
        $dataCategory1 += ArrayHelper::map(Consultant::find()->asArray()->all(), 'consultantid', 'name');        
    ?>

    <?= $form->field($model, 'consultantid')->dropDownList($dataCategory1, array('prompt'=>' ')) ?>

    <?php 
        $dataCategory2 = [];
        $dataCategory2 += ArrayHelper::map(Department::find()->asArray()->all(), 'departmentid', 'name');        
    ?>

    <?= $form->field($model, 'departmentid')->dropDownList($dataCategory2, array('prompt'=>' ')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <?php
        echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'startdate',
                'attribute2' => 'enddate',
                'options' => ['placeholder'=>'Start Date'],
                'options2' => ['placeholder'=>'End Date'],
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'pluginOptions' => [
                    'format' => 'dd-M-yyyy',
                    'autoclose' => true,
                ]
            ]);
    ?>

    <?= $form->field($model, 'file')->fileInput() ?> 

    <div id="int-deliverables">
        <a id='addIntDeliverable' >Add New Internal Deliverables</a>
        <?php
            $index = 0;
    
            foreach($model_intdeliverables as $i => $intdeliverables){
                echo $this->render('int-deliverables/_form', [
                    'model' => $intdeliverables,
                    'index' => $i,
                ]);
                $index = $i;                
            }
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php    
    $this->registerJs('
        index = "'.++$index.'";
        $("#addIntDeliverable").click(function(e){            
            $.ajax({
                url: "'.yii\helpers\URL::toRoute('int-agreement/add').'?index="+index,
                dataType: "html",
                success: function(data){
                    $intDeliverables = $(data).clone();
                    $("#int-deliverables").append($intDeliverables);
                }
            });    
            index++;
        });
    ')

?>

<script>
    function deleteIntDeliverables(e){
        $(e).parent().remove();        
    }
</script>
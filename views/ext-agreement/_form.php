<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;
//use yii\jui\DatePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */
/* @var $form yii\widgets\ActiveForm */
?>

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
    
    <?php //$form->field($model, 'filename')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'file')->fileInput() ?> 

    <div id="ext-deliverables">
        <a id='addExtDeliverable' >Add New External Deliverables</a>
        <?php
            $index = 0;
    
            foreach($model_extdeliverables as $i => $extdeliverables){
                echo $this->render('ext-deliverables/_form', [
                    'model' => $extdeliverables,
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
        $("#addExtDeliverable").click(function(e){            
            $.ajax({
                url: "'.yii\helpers\URL::toRoute('ext-agreement/add').'?index="+index,
                dataType: "html",
                success: function(data){
                    $extDeliverables = $(data).clone();
                    $("#ext-deliverables").append($extDeliverables);
                }
            });    
            index++;
        });
    ')

?>

<script>
    function deleteExtDeliverables(e){
        $(e).parent().remove();        
    }
</script>
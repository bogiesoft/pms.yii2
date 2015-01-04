<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Unit;
use app\models\Customer;
use app\models\ProductType;
use app\models\Status;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <?= $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>

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

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

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

    <?= $form->field($model, 'initiationyear')->textInput(['maxlength' => 5]) ?>

    <?php 
        $data= [];                   
        $data += ArrayHelper::map(Status::find()->orderBy('name')->asArray()->all(), 'statusid', 'name');             

        echo $form->field($model, 'statusid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a status ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);  
    ?>

    <div id="project-pic">
        <a id='addPIC' >Add New PIC </a>        
        <?php
            $index = 0;
    
            foreach($model_projectpic as $i => $projectpic){
                echo $this->render('project-pic/_form', [
                    'model' => $projectpic,
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
        $("#addPIC").click(function(e){            
            $.ajax({
                url: "'.yii\helpers\URL::toRoute('project/add').'?index="+index,                        
                dataType: "html",
                success: function(data){
                    $pic = $(data).clone();
                    $("#project-pic").append($pic);                    
                }
            });    
            index++;
        });
    ')

?>

<script>
    function deletePhone(e){
        $(e).parent().remove();        
    }
</script>
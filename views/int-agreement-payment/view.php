<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\editable\Editable;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreementPayment */

$this->title = 'Internal Deliverable';

$this->params['breadcrumbs'][] = ['label' => 'Monitoring Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Monitoring Internal Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.inside td{
    border-top:none !important;
    border-left:none !important;
}
.inside th{
    border-top:none !important;
    border-left:none !important;
}
.inside th:last-child{
    border-right:none !important;
}
.inside td:last-child{
    border-right:none !important;
}
.inside tr:last-child td{
    border-bottom:none !important;
}
</style>

<div class="int-agreement-payment-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>

<?php
if ($model->deliverdate != null && $model->deliverdate != ""){
    $model->deliverdate = date('d-M-Y', strtotime($model->deliverdate));   
    echo Html::a('<i class="fa fa-undo"></i> Cancel Submission', ['cancel-deliver', 'id' => $model->intdeliverableid, 'projectid'=>Yii::$app->request->get('projectid')], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to cancel deliver this item?',
            'method' => 'post',
        ],
    ]);
}
?>

<?php
$date = null;
if (isset($model->intagreementpayments->date) && $model->intagreementpayments->date != null && $model->intagreementpayments->date != ""){
    $date = date('d-M-Y', strtotime($model->intagreementpayments->date));

    echo Html::a('<i class="fa fa-undo"></i> Cancel Payment', ['cancel-payment', 'id' => $model->intagreementpayments->intagreementpaymentid, 'projectid'=>Yii::$app->request->get('projectid')], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to cancel payment this item?',
            'method' => 'post',
        ],
    ]);

    echo ' ' . Html::a('<i class="glyphicon glyphicon-pencil"></i> Update Payment', ['update', 'paymentid' => $model->intagreementpayments->intagreementpaymentid, 'projectid'=>Yii::$app->request->get('projectid'), 'id'=>Yii::$app->request->get('id')], [
        'class' => 'btn btn-primary',
    ]);
}else{
    $date = '<span class="not-set">(not set)</span>';
    echo Html::a('Create Payment', ['create', 'id' => $model->intdeliverableid, 'projectid' => Yii::$app->request->get('projectid')], [
        'class' => 'btn btn-success',
    ]);
}
?>

    </p>


    <table class="table table-striped table-bordered detail-view">
        <tbody>
        
        <tr><th>Consultant</th>  <td><?= $model->intagreement->consultant->name ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('code') ?></th> <td><?= $model->code ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('description') ?></th>  <td><?= $model->description ?></td></tr>
        <tr><th>Consultant Position</th>  <td><?= $model->consultantposition->name ?></td></tr>
        <tr><th>Rate Unit</th>  <td><?= $model->rateUnitDescr ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('frequency') ?></th>  <td><?= $model->frequency ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('rateNumberFormat') ?></th>  <td><?= $model->rateNumberFormat ?></td></tr>
        <tr><th>Due Date</th>  <td><?= $model->duedateformat ?></td></tr>
<tr><th><?= $model->getAttributeLabel('deliverdate') ?></th>  
    <td>
        <?php
            echo Editable::widget([
                'model'=>$model, 
                'attribute' => 'deliverdate',
                'type'=>'primary',
                'displayValue' => $model->deliverdateformat,
                'size'=>'md',
                'inputType' => Editable::INPUT_DATE,
                'afterInput'=>function($form, $widget) {
                    echo Html::activeHiddenInput($widget->model, 'intdeliverableid');
                },
                'options'=>[
                    'options' => ['placeholder' => 'Enter deliverable date..'],
                    'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'd-M-yyyy'
                        ]
                    
                ],
                'pluginEvents'=>[
                    'editableSuccess'=>"function(event, val) { location.reload(); }",
                ]
            ]);
        ?>
    </td>
</tr>
        <tr><th>Payment Date</th>  <td><?= $date ?></td></tr>
        
        </tbody>
    </table>

</div>
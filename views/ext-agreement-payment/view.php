<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\editable\Editable;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreementPayment */

$this->title = 'External Deliverable';
$this->params['breadcrumbs'][] = ['label' => 'Monitoring External Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Monitoring External Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-agreement-payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<?php
$project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
    if ($model->deliverdate != null && $model->deliverdate != ""){
        $model->deliverdate = date('d-M-Y', strtotime($model->deliverdate));   
        echo Html::a('<i class="fa fa-undo"></i> Cancel Submission', ['cancel-deliver', 'id' => $model->extdeliverableid, 'projectid'=>Yii::$app->request->get('projectid')], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to cancel deliver this item?',
                'method' => 'post',
            ],
        ]);
    }

    if (isset($model->extagreementpayments->date) && $model->extagreementpayments->date != null && $model->extagreementpayments->date != ""){
        echo Html::a('<i class="fa fa-undo"></i> Cancel Payment', ['cancel-payment', 'id' => $model->extagreementpayments->extagreementpaymentid, 'projectid'=>Yii::$app->request->get('projectid')], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to cancel payment this item?',
                'method' => 'post',
            ],
        ]);

        echo ' ' . Html::a('<i class="glyphicon glyphicon-pencil"></i> Update Payment', ['update', 'paymentid' => $model->extagreementpayments->extagreementpaymentid, 'projectid'=>Yii::$app->request->get('projectid'), 'id' => Yii::$app->request->get('id')], [
            'class' => 'btn btn-primary',
        ]);
    }else{
        echo Html::a('Create Payment', ['create', 'id' => $model->extdeliverableid, 'projectid' => Yii::$app->request->get('projectid')], [
            'class' => 'btn btn-success',
        ]);
    }
}

$date = null;
if (isset($model->extagreementpayments->date) && $model->extagreementpayments->date != null && $model->extagreementpayments->date != ""){
    $date = date('d-M-Y', strtotime($model->extagreementpayments->date));
}else{
    $date = '<span class="not-set">(not set)</span>';
}
?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
        
        <tr><th>Project</th>  <td><?= $model->extagreement->project->name ?></td></tr>
        <tr><th>Customer</th>  <td><?= $model->extagreement->project->customer->company ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('code') ?></th> <td><?= $model->code ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('description') ?></th>  <td><?= $model->description ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('rate') ?></th>  <td><?= number_format($model->rate) ?></td></tr>
        <tr><th>Due Date</th>  <td><?= $model->duedateformat ?></td></tr>
<tr><th><?= $model->getAttributeLabel('deliverdate') ?></th>  
    <td>
        <?php
        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
            echo Editable::widget([
                'model'=>$model, 
                'attribute' => 'deliverdate',
                'type'=>'primary',
                'displayValue' => $model->deliverdateformat,
                'size'=>'md',
                'inputType' => Editable::INPUT_DATE,
                'afterInput'=>function($form, $widget) {
                    echo Html::activeHiddenInput($widget->model, 'extdeliverableid');
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
        }else{
            if($model->deliverdateformat != null){
                echo $model->deliverdateformat;
            }else{
                echo '<span class="not-set">(not set)</span>';
            }
        }
        ?>
    </td>
</tr>
        <tr><th>Payment Date</th>  <td><?= $date ?></td></tr>
        
        </tbody>
    </table>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */

$this->title = 'Internal Agreement: ' . $model->consultant->name;
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreements', 'url' => ['index', 'extagreementid'=>Yii::$app->request->get('extagreementid')]];
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
<div class="int-agreement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
        $extagreement = \app\models\ExtAgreement::findOne(Yii::$app->request->get('extagreementid'));
        if (!(strpos(strtolower($extagreement->project->status->name), 'cancel') !== false)){
            echo Html::a('Update', ['update', 'id' => $model->intagreementid, 'extagreementid' => Yii::$app->request->get('extagreementid')], ['class' => 'btn btn-primary']);
            echo ' ' . Html::a('Delete', ['delete', 'id' => $model->intagreementid, 'extagreementid' => $model->extagreementid], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
    ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
        
        <tr><th><?= $model->getAttributeLabel('extagreement') ?></th>  
            <td><?= $model->extagreement->agreementno . ' - ' . $model->extagreement->description ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('consultant') ?></th> <td><?= $model->consultant->name ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('department') ?></th> <td><?= $model->department->name ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('description') ?></th>  <td><?= $model->description ?></td></tr>
        <tr><th>Start Date</th> <td><?= date('d-M-Y', strtotime($model->startdate)) ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('enddate') ?></th> <td><?= date('d-M-Y', strtotime($model->enddate)) ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('signdate') ?></th> <td><?= date('d-M-Y', strtotime($model->signdate)) ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('filename') ?></th> <td><a download href="<?= \Yii::$app->request->BaseUrl ?>/uploads/<?= $model->filename ?>"><?= $model->filename ?></a></td></tr>

        <tr><th>Deliverables</th><td style="padding: 0px;">
                <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>External Deliverable</th>
                        <th>Consultant Position</th>
                        <th>Deliverable Name</th>
                        <th>Frequency x Rate Unit</th>
                        <th>Rate</th>
                        <th>Due Date</th>
                    </tr>
                <?php 
                    $totalRate = 0;
                   foreach($model->intdeliverables as $deliverable){
                        echo '<tr>';
                        echo '<td>'.$deliverable->extdeliverables->code . ' - ' .$deliverable->extdeliverables->description.'</td>';
                        echo '<td>'.$deliverable->consultantposition->name.'</td>';
                        echo '<td>'.$deliverable->description.'</td>';
                        echo '<td>'.$deliverable->frequency . ' x ' . $deliverable->projectrate->role . ' ('. $deliverable->projectrate->mindunit->name .')</td>';
                        echo '<td>'.number_format($deliverable->rate).'</td>';
                        echo '<td>'.date('d-M-Y', strtotime($deliverable->duedate)) .'</td>';  
                        echo '</tr>';
                        $totalRate += $deliverable->rate;
                    }
                    echo '<tr><td colspan=4 style="text-align:center"><b>Total</b></td><td colspan=2>'.number_format($totalRate).'</td></tr>';
                ?>
                </table>
            </td></tr>


        </tbody>
    </table>

</div>

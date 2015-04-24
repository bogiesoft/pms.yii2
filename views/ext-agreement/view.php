<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */

$this->title = $model->agreementno;
$this->params['breadcrumbs'][] = ['label' => 'External Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'External Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
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
<div class="ext-agreement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
            echo Html::a('Update', ['update', 'id' => $model->extagreementid, 'projectid'=>Yii::$app->request->get('projectid')], ['class' => 'btn btn-primary']);
             
            echo ' ' . Html::a('Delete', ['delete', 'id' => $model->extagreementid, 'projectid'=>$model->projectid], [
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
        
        <tr><th><?= $model->getAttributeLabel('project') ?></th>  <td><?= $model->project->code. ' - ' .$model->project->name ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('agreementno') ?></th> <td><?= $model->agreementno ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('description') ?></th> <td><?= $model->description ?></td></tr>
        <tr><th>Start Date</th>  <td><?= date('d-M-Y', strtotime($model->startdate)) ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('enddate') ?></th> <td><?= date('d-M-Y', strtotime($model->enddate)) ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('signdate') ?></th> <td><?= date('d-M-Y', strtotime($model->signdate)) ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('ppn') ?></th> <td><?= $model->ppn ?>%</td></tr>
        <tr><th><?= $model->getAttributeLabel('filename') ?></th> <td><a download href="<?= \Yii::$app->request->BaseUrl ?>/uploads/<?= $model->filename ?>"><?= $model->filename ?></a></td></tr>

        <tr><th>Deliverables</th><td style="padding: 0px;">
                <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>Number</th>
                        <th>Deliverable Name</th>
                        <th>Invesment</th>
                        <th>Due Date</th>
                    </tr>
                <?php 
                    foreach($model->extdeliverables as $deliverable){
                        echo '<tr>';
                        echo '<td>'.$deliverable->code.'</td>';
                        echo '<td>'.$deliverable->description.'</td>';
                        echo '<td>'.number_format($deliverable->rate).'</td>';
                        echo '<td>'.$deliverable->duedate.'</td>';
                        echo '</tr>';
                    }
                ?>
                </table>
            </td></tr>

        </tbody>
    </table>

</div>

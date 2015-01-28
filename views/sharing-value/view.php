<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SharingValueDepartment */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Sharing Value: Select Project', 'url' => ['index']];
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
<div class="sharing-value-department-view">

    <h1><?= Html::encode($this->title . ' - ' . $model->name) ?></h1>

    <p>
<?php
if ($model->projectid != null && $model->projectid != ""){
    if (isset($model->sharingvalueunits) && isset($model->sharingvaluedepartments) && (
            count($model->sharingvalueunits) > 0 || count($model->sharingvaluedepartments) > 0)
        ){
        
        echo Html::a('Update Sharing Value', ['update', 'projectid' => $model->projectid], [
            'class' => 'btn btn-primary',
        ]);

        echo ' ' . Html::a('Delete Sharing Value', ['delete-sharing', 'projectid'=>$model->projectid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete sharing value of this item?',
                'method' => 'post',
            ],
        ]);
    } else{
        echo Html::a('Create Sharing Value', ['create', 'projectid' => $model->projectid], [
            'class' => 'btn btn-success',
        ]);
    }
}

?>
    </p>


    <table class="table table-striped table-bordered detail-view">
        <tbody>
        
        <tr><th>Unit</th>  <td><?= $model->unit->Name ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('code') ?></th> <td><?= $model->code ?></td></tr>
        <tr><th>Project</th>  <td><?= $model->name ?></td></tr>
        <tr><th>Customer</th>  <td><?= $model->customer->company ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('description') ?></th>  <td><?= $model->description ?></td></tr>
        <tr><th>Product Type</th>  <td><?= $model->producttype->name ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('initiationyear') ?></th>  <td><?= $model->initiationyearformat ?></td></tr>
        <tr><th>Status</th>  <td><?= $model->status->name ?></td></tr>

        <tr><th>Sharing Value Unit</th>  <td style="padding: 0px;">
            <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>Unit</th>
                        <th>Value</th>
                    </tr>
                <?php 
                   foreach($model->sharingvalueunits as $units){
                        echo '<tr>';
                        echo '<td>'.$units->unit->code . ' - ' . $units->unit->Name.'</td>';
                        echo '<td>'.number_format($units->value).'</td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </td></tr>

        <tr><th>Sharing Value Department</th>  <td style="padding: 0px;">
            <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>Faculty</th>
                        <th>Department</th>
                        <th>Value</th>
                    </tr>
                <?php 
                   foreach($model->sharingvaluedepartments as $departments){
                        echo '<tr>';
                        echo '<td>'.$departments->department->faculty->code . ' - ' . $departments->department->faculty->name.'</td>';
                        echo '<td>'.$departments->department->name.'</td>';
                        echo '<td>'.number_format($departments->value).'</td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </td></tr>
        
        </tbody>
    </table>

</div>

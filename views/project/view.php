<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
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
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->projectid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->projectid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?php
        if (!(strpos(strtolower($model->status->name), 'cancel') !== false)){
            echo Html::a('Cancel Project', ['cancel-project', 'id' => $model->projectid], [
            'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to cancel this project?',
                    'method' => 'post',
                ],
            ]);
        }else{
            echo Html::a('Undo Cancel Project', ['undo-cancel-project', 'id' => $model->projectid], [
            'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to undo cancel this project?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th><?= $model->getAttributeLabel('unit') ?></th> 
            <td><?= $model->unit->code.' - '.$model->unit->Name ?></td></tr>
        <tr>
            <th><?= $model->getAttributeLabel('initiationyear') ?></th>
            <td><?= date('d-M-Y', strtotime($model->initiationyear)) ?></td></tr>
        <tr>
            <th><?= $model->getAttributeLabel('code') ?></th> 
            <td><?= $model->code ?></td></tr>
        <tr>
            <th><?= $model->getAttributeLabel('name') ?></th>  
            <td><?= $model->name ?></td></tr>
        <tr>
            <th><?= $model->getAttributeLabel('customer') ?></th>  
            <td><?= $model->customer->company ?></td></tr>
        <tr>
            <th><?= $model->getAttributeLabel('description') ?></th>  
            <td><?= $model->description ?></td></tr>
        <tr>
            <th>Product Type</th>  
            <td><?= $model->producttype->code.' - '.$model->producttype->name ?></td></tr>
        <tr>
            <th>Status</th>  
            <td><?= $model->status->name ?></td></tr>
        <tr>
            <th>Project PICs</th><td style="padding: 0px;">
            <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>PIC Name</th>
                    </tr>
                <?php 
                    foreach($model->projectpic as $pic){
                        echo '<tr>';
                        echo '<td>'.$pic->user->name.'</td>';
                        echo '</tr>';
                    }
                ?>
                </table>
            </td></tr>
        <tr><th>Project File</th>  <td>

            <a download href=""></a>
            <?php
                echo Html::a('<i class="fa fa-download"></i> Download Project Files', ['download-project', 'id' => $model->projectid], [
                    'data' => [
                        'method' => 'post',
                    ],
                ]);
            ?>

            </td></tr>    
        </tbody>
    </table>

</div>

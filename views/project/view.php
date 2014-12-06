<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            [
                'attribute'=>'unit',
                'value'=>$model->unit->code.' - '.$model->unit->Name,
                'label'=>'Unit',
            ],
            'code',
            'name',
            [
                'attribute'=>'customer',
                'value'=>$model->customer->company,
                'label'=>'Customer',
            ],
            'description',
            [
                'attribute'=>'producttype',
                'value'=>$model->producttype->code.' - '.$model->producttype->name,
                'label'=>'Product Type'
            ],
            'initiationyear',
            [
                'attribute'=>'status',
                'value'=>$model->status->name,
                'label'=>'Status'
            ],
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */

$this->title = $model->extdeliverableid;
$this->params['breadcrumbs'][] = ['label' => 'Ext Deliverables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-deliverables-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->extdeliverableid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->extdeliverableid], [
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
                'attribute' => 'extagreement',
                'value' => $model->extagreement->description
            ],
            'code',
            'description',
            'rate',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\IntDeliverables */

$this->title = $model->intdeliverableid;
$this->params['breadcrumbs'][] = ['label' => 'Int Deliverables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-deliverables-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->intdeliverableid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->intdeliverableid], [
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
                'attribute' => 'intagreement',
                'value' => $model->intagreement->description,
            ],            
            [
                'attribute' => 'extdeliverables',
                'value' => $model->extdeliverables->description,
            ],
            'code',
            [
                'attribute' => 'consultantposition',
                'value' => $model->consultantposition->name,
            ],
            'description',
            'frequency',
            [
                'attribute' => 'projectrate',
                'value' => $model->projectrate->role,
            ],
            'rate',
        ],
    ]) ?>

</div>

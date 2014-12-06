<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */

$this->title = $model->intagreementid;
$this->params['breadcrumbs'][] = ['label' => 'Int Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-agreement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->intagreementid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->intagreementid], [
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
            [
                'attribute' => 'consultant',
                'value' => $model->consultant->name
            ],
            [
                'attribute' => 'department',
                'value' => $model->department->name
            ],
            'description',
            'startdate',
            'enddate',
            'filename',
        ],
    ]) ?>

</div>

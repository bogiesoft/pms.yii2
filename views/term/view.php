<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Term */

$this->title = $model->priod . ' - ' . $model->kdsem;
$this->params['breadcrumbs'][] = ['label' => 'Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->termid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->termid], [
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
            'priod',
            'kdsem',
            [
                'attribute'=>'startdate',
                'value'=>$model->startDateText
            ],
            [
                'attribute'=>'enddate',
                'value'=>$model->endDateText
            ],
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectLog */

$this->title = $model->projectlogid;
$this->params['breadcrumbs'][] = ['label' => 'Project Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->projectlogid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->projectlogid], [
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
            'projectlogid',
            'projectid',
            'date',
            'remark',
            'datein',
            'userin',
            'dateup',
            'userup',
        ],
    ]) ?>

</div>

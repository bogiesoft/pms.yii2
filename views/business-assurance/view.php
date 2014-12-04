<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BusinessAssurance */

$this->title = $model->businessassuranceid;
$this->params['breadcrumbs'][] = ['label' => 'Business Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-assurance-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->businessassuranceid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->businessassuranceid], [
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
                'attribute'=>'project',
                'value'=>$model->project->code. ' - ' .$model->project->name,                
            ],
            'date',
            'remark',
            'filename',
        ],
    ]) ?>

</div>

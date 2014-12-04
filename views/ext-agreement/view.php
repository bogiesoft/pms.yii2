<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */

$this->title = $model->extagreementid;
$this->params['breadcrumbs'][] = ['label' => 'Ext Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-agreement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->extagreementid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->extagreementid], [
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
            'agreementno',
            'description',
            'startdate',
            'enddate',
            'filename',            
        ],
    ]) ?>

</div>

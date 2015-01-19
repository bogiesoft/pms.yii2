<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Proposal */
$this->title = 'Proposal@'.date('d.M.Y H:i:s', strtotime($model->date));
$this->params['breadcrumbs'][] = ['label' => 'Proposals: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Proposals', 'url' => ['index?projectid='.Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->proposalid, 'projectid'=>Yii::$app->request->get('projectid')], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->proposalid], [
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
            [
                'attribute'=>'date',
                'value'=>$model->dateFormat,
            ],
            'remark',
            [
                'attribute' => 'filename',
                'value'=>Html::a($model->filename, \Yii::$app->request->BaseUrl.'/uploads/'.$model->filename),
                'format' => 'html'
            ],

        ],
    ]) ?>

</div>

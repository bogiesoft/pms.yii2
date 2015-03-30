<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Proposal */
$this->title = 'Proposal@'.date('d.M.Y', strtotime($model->date));
$this->params['breadcrumbs'][] = ['label' => 'Proposal: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Proposals', 'url' => ['index?projectid='.Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
            echo Html::a('Update', ['update', 'id' => $model->proposalid, 'projectid'=>Yii::$app->request->get('projectid')], ['class' => 'btn btn-primary']);

            echo ' ' . Html::a('Delete', ['delete', 'id' => $model->proposalid, 'projectid' => $model->project->projectid], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
    ?>
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

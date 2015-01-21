<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CostingApproval */

$this->title = 'Costing Approval@'.date('d.M.Y H:i:s', strtotime($model->date));
$this->params['breadcrumbs'][] = ['label' => 'Costing Approval: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Costing Approvals', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-approval-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->costingapprovalid, 'projectid' => Yii::$app->request->get('projectid')], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->costingapprovalid], [
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
            [
                'attribute' => 'filename',
                'value'=>Html::a($model->filename, \Yii::$app->request->BaseUrl.'/uploads/'.$model->filename),
                'format' => 'html'
            ],        
        ],
    ]) ?>

</div>

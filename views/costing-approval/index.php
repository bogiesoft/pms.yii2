<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CostingApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Costing Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Costing Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'project',
                'value'=>'ProjectDescr',
            ],
            'date',
            'remark',
            'filename',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

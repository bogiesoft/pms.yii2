<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CostingApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Costing Approvals';
$this->params['breadcrumbs'][] = ['label' => 'Costing Approval: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Costing Approval', ['create' , 'projectid' => Yii::$app->request->get('projectid')], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'filename',
                'value'=>'urlFile',
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['costing-approval/view','projectid'=>$model->projectid, 'id'=>$model->costingapprovalid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \yii\helpers\Url::toRoute(['costing-approval/update','projectid'=>$model->projectid, 'id'=>$model->costingapprovalid],false), [
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>

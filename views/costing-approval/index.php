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
    <h6><em style="color:red">*</em> If there is more than one file, please upload as zip/rar file.</h6>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php
        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
            echo Html::a('Create Costing Approval', ['create' , 'projectid' => Yii::$app->request->get('projectid')], ['class' => 'btn btn-success']);
        }
    ?>
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
            [
                'attribute'=>'date',
                'value'=>'dateFormat'
            ],
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
                        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
                        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \yii\helpers\Url::toRoute(['costing-approval/update','projectid'=>$model->projectid, 'id'=>$model->costingapprovalid],false), [
                                'title' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]);
                        }
                    },
                    'delete' => function($url, $model, $key){                    
                        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
                        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                                ['delete', 'id' => $model->costingapprovalid, 'projectid' => $model->project->projectid], 
                                [
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);          
                        }
                    },
                ]
            ],
        ],
    ]); ?>

</div>

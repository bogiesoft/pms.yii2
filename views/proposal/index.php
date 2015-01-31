<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProposalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proposals';
$this->params['breadcrumbs'][] = ['label' => 'Proposal: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h6><em style="color:red">*</em> If there is more than one file, please upload as zip/rar file.</h6>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Proposal', ['create', 'projectid' => Yii::$app->request->get('projectid')], ['class' => 'btn btn-success']) ?>
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
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['proposal/view','projectid'=>$model->projectid, 'id'=>$model->proposalid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \yii\helpers\Url::toRoute(['proposal/update','projectid'=>$model->projectid, 'id'=>$model->proposalid],false), [
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', \yii\helpers\Url::toRoute(['proposal/delete','projectid'=>$model->projectid, 'id'=>$model->proposalid],false), [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-pjax' => '0',
                        ]);
                    },

                ]
            ],
        ],
    ]); ?>

</div>

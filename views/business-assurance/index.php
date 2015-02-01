<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BusinessAssuranceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Business Assurances';
$this->params['breadcrumbs'][] = ['label' => 'Business Assurance: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-assurance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h6><em style="color:red">*</em> If there is more than one file, please upload as zip/rar file.</h6>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php
        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
            echo Html::a('Create Business Assurance', ['create', 'projectid' => Yii::$app->request->get('projectid')], ['class' => 'btn btn-success']);
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
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['business-assurance/view','projectid'=>$model->projectid, 'id'=>$model->businessassuranceid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function($url, $model, $key){                    
                        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
                        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \yii\helpers\Url::toRoute(['business-assurance/update','projectid'=>$model->projectid, 'id'=>$model->businessassuranceid],false), [
                                'title' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]);
                        }
                    },
                    'delete' => function($url, $model, $key){                    
                        $project = \app\models\Project::findOne(Yii::$app->request->get('projectid'));
                        if (!(strpos(strtolower($project->status->name), 'cancel') !== false)){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', \yii\helpers\Url::toRoute(['business-assurance/delete','projectid'=>$model->projectid, 'id'=>$model->businessassuranceid],false), [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-pjax' => '0',
                            ]);
                        }
                    },
                ]
            ],
        ],
    ]); ?>

</div>

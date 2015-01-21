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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Business Assurance', ['create', 'projectid' => Yii::$app->request->get('projectid')], ['class' => 'btn btn-success']) ?>
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
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \yii\helpers\Url::toRoute(['business-assurance/update','projectid'=>$model->projectid, 'id'=>$model->businessassuranceid],false), [
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>

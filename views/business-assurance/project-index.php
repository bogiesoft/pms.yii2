<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Business Assurance: Select Project';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=>'unit',
                'value'=>'UnitDescr',
            ],
            'code',
            'name',
            [
                'attribute'=>'customer',
                'value'=>'customer.company',
            ],
            // 'description',
            [
                'attribute'=>'producttype',
                'value'=>'ProductTypeDescr',
                'label'=>'Product Type',
            ],
            [
                'attribute' => 'initiationyear',
                'value' => 'initiationdateformat'
            ],
            [
                'attribute'=>'status',
                'value'=>'status.name',
            ],  

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['business-assurance/index','projectid'=>$model->projectid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                }]
            ],
        ],
    ]); ?>

</div>

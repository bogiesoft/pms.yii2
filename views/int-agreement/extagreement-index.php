<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Internal Agreement: Select Project';
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
                'value'=> function($data){ return $data['project']['unit']['code'].' - '. $data['project']['unit']['Name']; },
            ],
            [
                'attribute'=>'project',
                'value'=> function($data){ return $data['project']['code'].' - '. $data['project']['name']; },  
            ],
            [
                'attribute'=>'customer',
                'value'=>function($data){ return $data['project']['customer']['company']; },
            ],
            // 'description',
            [
                'attribute'=>'producttype',
                'value'=>'project.producttype.name',
                'label'=>'Product Type',
            ],
            [
                'attribute' => 'initiationyear',
                'value' => 'project.initiationdateformat',
                'label'=>'Initiation Date',
            ],
            [
                'attribute'=>'status',
                'value'=>'project.status.name',
            ],
            [
                'attribute' => 'agreementno',
                'value' => function($data) { return $data['agreementno']. ' - '. $data['description']; },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['int-agreement/index','extagreementid'=>$model->extagreementid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                }]
            ],
            
        ],
    ]); ?>

</div>

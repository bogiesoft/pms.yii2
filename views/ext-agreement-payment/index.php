<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExtAgreementPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monitoring External Agreements';
$this->params['breadcrumbs'][] = ['label' => 'Monitoring External Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-agreement-payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'customer',
                'label' => 'Customer',
                'value' => 'extagreement.project.customer.company',

            ],
            [
                'attribute' => 'deliverable',
                'label' => 'Deliverable Name',
                'value' => 'deliverableformat',

            ],
            [
                'attribute' => 'duedate',
                'value' => 'duedateformat',
            ],
            [
                'attribute' => 'deliverdate',
                'value' => 'deliverdateformat',
            ],
            [
                'attribute' => 'payment',
                'label' => 'Payment Date',
                'value' => 'paymentdateformat',

            ],
            //'datein',
            // 'userin',
            // 'dateup',
            // 'userup',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['ext-agreement-payment/view','projectid'=>Yii::$app->request->get('projectid'), 'id'=>$model->extdeliverableid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                }]
            ],
        ],
    ]); ?>

</div>

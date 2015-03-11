<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IntAgreementPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monitoring Internal Agreements';
$this->params['breadcrumbs'][] = ['label' => 'Monitoring Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-agreement-payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php 
$data = \app\models\IntAgreement::find()->where(['intagreementid'=>7])->one();
//var_dump($data->intdeliverables);

?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'consultant',
                'label' => 'Consultant Name',
                'value' => 'intagreement.consultant.name',

            ],
            
            [
                'attribute' => 'deliverable',
                'label' => 'Deliverable Name',
                'value' => 'deliverablenamewithcode'
            ],
            [
                'attribute' => 'duedate',
                'value' => 'duedateformat'
            ],
            [
                'attribute' => 'deliverdate',
                'value' => 'deliverdateformat'
            ],
            [
                'attribute'=>'payment',
                'label' => 'Payment Date',
                'value'=>'paymentdateformat'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['int-agreement-payment/view','projectid'=>Yii::$app->request->get('projectid'), 'id'=>$model->intdeliverableid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                }]
            ],
        ],
    ]); ?>
    
</div>

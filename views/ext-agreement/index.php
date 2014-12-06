<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExtAgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ext Agreements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-agreement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ext Agreement', ['create'], ['class' => 'btn btn-success']) ?>
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
            'agreementno',
            'description',
            'startdate',
            'enddate',
            'filename',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

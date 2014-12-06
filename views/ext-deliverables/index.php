<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExtDeliverablesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ext Deliverables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-deliverables-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ext Deliverables', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'extagreement',
                'value' => 'extagreement.description',
            ],
            'code',
            'description',
            'rate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

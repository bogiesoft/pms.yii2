<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IntDeliverablesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Int Deliverables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-deliverables-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Int Deliverables', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                        
            [
                'attribute' => 'intagreement',
                'value' => 'intagreement.description',
            ],
            [
                'attribute' => 'extdeliverables',
                'value' => 'extdeliverables.description',
            ],
            'code',
            [
                'attribute' => 'consultantposition',
                'value' => 'consultantposition.name',
            ],
            'description',
            'frequency',
            [
                'attribute' => 'projectrate',
                'value' => 'projectrate.role',
            ],
            'rate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

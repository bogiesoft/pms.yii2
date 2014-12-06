<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectRateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-rate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Rate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'role',
            [
                'attribute'=>'mindunit',
                'value'=>'mindunit.name',
                'label'=>'Mind Unit'
            ],
            'rate',
            'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

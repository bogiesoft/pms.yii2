<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IntAgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Int Agreements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-agreement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Int Agreement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'extagreement',
                'value' => 'extagreement.description'
            ],
            [
                'attribute' => 'consultant',
                'value' => 'consultant.name'
            ],
            [
                'attribute' => 'department',
                'value' => 'department.name'
            ],
            'description',
            'startdate',
            'enddate',
            'filename',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Consultant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'consultantid',
            'lectureid',
            'employeeid',
            'name',
            'residentid',
            // 'categoryid',
            // 'datein',
            // 'userin',
            // 'dateup',
            // 'userup',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

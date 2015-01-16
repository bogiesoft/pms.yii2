<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Consultants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->consultantid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->consultantid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'consultantid',
            'lectureid',
            'employeeid',
            'name',
            'residentid',
            'categoryid',
            'datein',
            'userin',
            'dateup',
            'userup',
        ],
    ]) ?>

</div>

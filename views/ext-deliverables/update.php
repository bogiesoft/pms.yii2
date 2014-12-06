<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */

$this->title = 'Update Ext Deliverables: ' . ' ' . $model->extdeliverableid;
$this->params['breadcrumbs'][] = ['label' => 'Ext Deliverables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->extdeliverableid, 'url' => ['view', 'id' => $model->extdeliverableid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ext-deliverables-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

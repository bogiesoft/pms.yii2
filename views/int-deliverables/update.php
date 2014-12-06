<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IntDeliverables */

$this->title = 'Update Int Deliverables: ' . ' ' . $model->intdeliverableid;
$this->params['breadcrumbs'][] = ['label' => 'Int Deliverables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->intdeliverableid, 'url' => ['view', 'id' => $model->intdeliverableid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="int-deliverables-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

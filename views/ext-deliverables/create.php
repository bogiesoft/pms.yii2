<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExtDeliverables */

$this->title = 'Create Ext Deliverables';
$this->params['breadcrumbs'][] = ['label' => 'Ext Deliverables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-deliverables-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

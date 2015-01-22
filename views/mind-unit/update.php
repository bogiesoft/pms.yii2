<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MindUnit */

$this->title = 'Update Rate Unit: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rate Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->mindunitid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mind-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

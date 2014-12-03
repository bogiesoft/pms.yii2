<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PartnerType */

$this->title = 'Update Partner Type: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Partner Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->partnertypeid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partner-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

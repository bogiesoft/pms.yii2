<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BusinessAssurance */

$this->title = 'Update Business Assurance: ' . ' ' . $model->businessassuranceid;
$this->params['breadcrumbs'][] = ['label' => 'Business Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->businessassuranceid, 'url' => ['view', 'id' => $model->businessassuranceid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="business-assurance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

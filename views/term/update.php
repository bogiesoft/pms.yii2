<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Term */

$this->title = 'Update Term: ' . ' ' . $model->priod . ' - ' . $model->kdsem;
$this->params['breadcrumbs'][] = ['label' => 'Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->priod . ' - ' . $model->kdsem, 'url' => ['view', 'id' => $model->termid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="term-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

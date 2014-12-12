<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRate */

$this->title = 'Update Project Rate: ' . ' ' . $model->role;
$this->params['breadcrumbs'][] = ['label' => 'Project Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role, 'url' => ['view', 'id' => $model->rateid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-rate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

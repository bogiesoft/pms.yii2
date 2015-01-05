<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectLog */

$this->title = 'Update Project Log: ' . ' ' . $model->projectlogid;
$this->params['breadcrumbs'][] = ['label' => 'Project Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->projectlogid, 'url' => ['view', 'id' => $model->projectlogid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectLog */

$this->title = 'Create Project Log';
$this->params['breadcrumbs'][] = ['label' => 'Project Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

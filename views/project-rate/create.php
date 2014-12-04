<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectRate */

$this->title = 'Create Project Rate';
$this->params['breadcrumbs'][] = ['label' => 'Project Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-rate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

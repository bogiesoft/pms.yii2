<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultantPosition */

$this->title = 'Update Consultant Position: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Consultant Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->positionid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consultant-position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

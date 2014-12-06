<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PhoneType */

$this->title = 'Update Phone Type: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Phone Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->phonetypeid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="phone-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

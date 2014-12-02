<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductType */

$this->title = 'Update Product Type: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->producttypeid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MindUnit */

$this->title = 'Create Rate Unit';
$this->params['breadcrumbs'][] = ['label' => 'Rate Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mind-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

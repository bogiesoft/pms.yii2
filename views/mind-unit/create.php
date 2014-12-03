<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MindUnit */

$this->title = 'Create Mind Unit';
$this->params['breadcrumbs'][] = ['label' => 'Mind Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mind-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

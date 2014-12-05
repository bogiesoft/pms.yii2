<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\IntDeliverables */

$this->title = 'Create Int Deliverables';
$this->params['breadcrumbs'][] = ['label' => 'Int Deliverables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-deliverables-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

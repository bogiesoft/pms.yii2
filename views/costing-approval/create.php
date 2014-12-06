<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CostingApproval */

$this->title = 'Create Costing Approval';
$this->params['breadcrumbs'][] = ['label' => 'Costing Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CostingApproval */

$this->title = 'Update Costing Approval: ' . ' ' . $model->costingapprovalid;
$this->params['breadcrumbs'][] = ['label' => 'Costing Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->costingapprovalid, 'url' => ['view', 'id' => $model->costingapprovalid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="costing-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

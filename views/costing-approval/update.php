<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CostingApproval */

$this->title = 'Update Costing Approval';
$this->params['breadcrumbs'][] = ['label' => 'Costing Approval: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Costing Approvals', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = ['label' => 'Costing Approval@'.date('d.M.Y', strtotime($model->date)), 'url' => ['view', 'id' => $model->costingapprovalid, 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="costing-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Proposal */

$this->title = 'Update Proposal';
$this->params['breadcrumbs'][] = ['label' => 'Proposal: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Proposals', 'url' => ['index?projectid='.Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = ['label' => 'Proposal@'.date('d.M.Y', strtotime($model->date)), 'url' => ['view', 'id' => $model->proposalid, 'projectid' => Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proposal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

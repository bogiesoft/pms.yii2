<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Proposal */

$this->title = 'Create Proposal';
$this->params['breadcrumbs'][] = ['label' => 'Proposal: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Proposals', 'url' => ['index?projectid='.Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

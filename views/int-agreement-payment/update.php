<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreementPayment */

$this->title = 'Update Payment';
$this->params['breadcrumbs'][] = ['label' => 'Monitoring Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Monitoring Internal Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = ['label' => 'Internal Deliverable', 'url' => ['view', 'id'=>Yii::$app->request->get('id'), 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="int-agreement-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

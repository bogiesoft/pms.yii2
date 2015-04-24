<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreementPayment */

$this->title = 'Update Payment';
$this->params['breadcrumbs'][] = ['label' => 'Monitoring External Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Monitoring External Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = ['label' => 'External Deliverable', 'url' => ['view', 'id'=>Yii::$app->request->get('id'), 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ext-agreement-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model_payment,
    ]) ?>

</div>

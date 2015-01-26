<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreementPayment */

$this->title = 'Update Ext Agreement Payment: ' . ' ' . $model->extagreementpaymentid;
$this->params['breadcrumbs'][] = ['label' => 'Ext Agreement Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->extagreementpaymentid, 'url' => ['view', 'id' => $model->extagreementpaymentid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ext-agreement-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

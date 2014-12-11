<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */

$this->title = 'Update Ext Agreement: ' . ' ' . $model->extagreementid;
$this->params['breadcrumbs'][] = ['label' => 'Ext Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->extagreementid, 'url' => ['view', 'id' => $model->extagreementid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ext-agreement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_extdeliverables' => $model_extdeliverables,
    ]) ?>

</div>

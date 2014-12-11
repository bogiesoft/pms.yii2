<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */

$this->title = 'Update Int Agreement: ' . ' ' . $model->intagreementid;
$this->params['breadcrumbs'][] = ['label' => 'Int Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->intagreementid, 'url' => ['view', 'id' => $model->intagreementid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="int-agreement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_intdeliverables' => $model_intdeliverables,
    ]) ?>

</div>

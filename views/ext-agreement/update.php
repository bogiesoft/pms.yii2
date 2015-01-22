<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */

$this->title = 'Update Ext Agreement';
$this->params['breadcrumbs'][] = ['label' => 'External Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'External Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = ['label' => $model->agreementno, 'url' => ['view', 'id' => $model->extagreementid, 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ext-agreement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_extdeliverables' => $model_extdeliverables,
    ]) ?>

</div>

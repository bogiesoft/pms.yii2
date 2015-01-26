<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */

$this->title = 'Update Internal Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreements', 'url' => ['index', 'extagreementid'=>Yii::$app->request->get('extagreementid')]];
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreement: '.$model->consultant->name, 'url' => ['view', 'id' => $model->intagreementid, 'extagreementid'=>Yii::$app->request->get('extagreementid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="int-agreement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_intdeliverables' => $model_intdeliverables,
    ]) ?>

</div>

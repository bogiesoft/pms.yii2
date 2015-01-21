<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BusinessAssurance */

$this->title = 'Update Business Assurance';
$this->params['breadcrumbs'][] = ['label' => 'Business Assurance: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Business Assurances', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = ['label' => 'Business Assurance@'.date('d.M.Y H:i:s', strtotime($model->date)), 'url' => ['view', 'id' => $model->businessassuranceid, 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="business-assurance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

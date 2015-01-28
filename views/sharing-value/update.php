<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SharingValueDepartment */

$this->title = 'Update Sharing Value';
$this->params['breadcrumbs'][] = ['label' => 'Sharing Value: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sharing-value-department-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'units' => $units,
		'departments' => $departments,
    ]) ?>

</div>

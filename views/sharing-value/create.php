<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SharingValueDepartment */

$this->title = 'Create Sharing Value & Finalization';
$this->params['breadcrumbs'][] = ['label' => 'Sharing Value & Finalization: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="sharing-value-department-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'units' => $units,
      	'departments' => $departments,
      	'model_finalization' => $model_finalization,
    ]) ?>

</div>

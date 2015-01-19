<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */

$this->title = 'Update Consultant: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Consultants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->consultantid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consultant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'index' => $index,
        'indexEmail' => $indexEmail,
        'indexBank' => $indexBank,
        'phones' => $phones,
        'emails' => $emails,
        'banks' => $banks,
    ]) ?>

</div>

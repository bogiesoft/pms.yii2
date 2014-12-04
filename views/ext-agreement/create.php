<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */

$this->title = 'Create Ext Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Ext Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-agreement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

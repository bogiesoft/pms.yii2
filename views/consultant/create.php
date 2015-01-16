<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Consultant */

$this->title = 'Create Consultant';
$this->params['breadcrumbs'][] = ['label' => 'Consultants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

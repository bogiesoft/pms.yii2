<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ConsultantPosition */

$this->title = 'Create Consultant Position';
$this->params['breadcrumbs'][] = ['label' => 'Consultant Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultant-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

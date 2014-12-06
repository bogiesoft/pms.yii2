<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */

$this->title = 'Create Int Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Int Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-agreement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

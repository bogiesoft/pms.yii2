<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExtAgreement */

$this->title = 'Create External Agreement';
$this->params['breadcrumbs'][] = ['label' => 'External Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'External Agreements', 'url' => ['index', 'projectid'=>Yii::$app->request->get('projectid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ext-agreement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // $this->render('_form', [
        //'model' => $model,
    //]) 
    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'model_extdeliverables' => $model_extdeliverables,
    ]) ?>

</div>

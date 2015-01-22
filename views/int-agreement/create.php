<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\IntAgreement */

$this->title = 'Create Internal Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreement', 'url' => ['index', 'extagreementid'=>Yii::$app->request->get('extagreementid')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-agreement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_intdeliverables' => $model_intdeliverables,
    ]) ?>

</div>

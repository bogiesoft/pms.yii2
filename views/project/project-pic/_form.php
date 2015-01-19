<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectPic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-pic-form">

	<div class="form-inline" role="form">
	<?php
        if ($model->hasErrors('userid')){
            echo '<div class="form-group required has-error" style="width:60%">';
        }else{
            echo '<div class="form-group" style="width:60%">';
        }
    ?>

    <?php 
        $dataCategory = [];
        $dataCategory += ArrayHelper::map(User::find()->asArray()->all(), 'userid', 'name');

        echo Html::activeDropDownList($model, '[' . $index . ']userid', $dataCategory, [
	        'style'=>'width:100%;min-width:100%;',
	        'class'=>'userddl form-control select2',
	    ]);
        echo Html::error($model, 'userid', ['class'=>'help-block']);
    ?>
    </div>
    <a type="button" class="btnAddUser btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeleteUser btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
    </div>
</div>

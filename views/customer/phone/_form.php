<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContactPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-person-phone-form">

    <div class="form-inline" role="form">

    <?php
        if ($model->hasErrors('phonetypeid')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
     <?php 

    $data = [];
    $data += yii\helpers\ArrayHelper::map(\app\models\PhoneType::find()->asArray()->orderBy('name')->all(), 
        'phonetypeid', 'name');
    $mobile = \app\models\PhoneType::find()->where(['like','name','mobile'])->one();
    if ($mobile != null && ($model->phonetypeid == null || $model->phonetypeid == "")){
        $model->phonetypeid = $mobile->phonetypeid;   
    }

    echo Html::activeDropDownList($model, '[' . $index . ']phonetypeid', $data, [
        'style'=>'width:100%;min-width:250px;',
        'class'=>'phonetypeddl form-control select2',
        'name'=>'ContactPerson['.$target.'][ContactPersonPhone][' . $index . '][phonetypeid]'
    ]);
    echo Html::error($model, 'phonetypeid', ['class'=>'help-block']);

    ?>
    </div>

    <?php
        if ($model->hasErrors('phone')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
    <?php
        echo Html::activeTextInput($model, '[' . $index . ']phone', [
            'maxlength' => 25, 
            'class'=>'form-control phoneinput',
            'style'=>'margin-right:50px;min-width:300px;',
            'name'=>'ContactPerson['.$target.'][ContactPersonPhone][' . $index . '][phone]'
        ]);
        echo Html::error($model, 'phone', ['class'=>'help-block']);
    ?>
    </div>
    <a type="button" class="btnAddPhone btn btn-primary" data-target="<?= $target ?>" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
    <a type="button" class="btnDeletePhone btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
        
    </div>

</div>
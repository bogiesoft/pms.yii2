<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContactPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-person-form">

	<?php
        if ($model->hasErrors('name')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
	<?php
	 	echo Html::activeHiddenInput($model, '[' . $index . ']contactpersonid');
		echo Html::activeLabel($model, '[' . $index . ']name', ['class'=>'col-sm-2 control-label']);
		echo '<div class="col-sm-10">';
		echo Html::activeTextInput($model, '[' . $index . ']name', [
			'maxlength' => 150, 
			'placeholder'=>'Name',
			'class'=>'form-control nameinput',
		]);
		echo Html::error($model, 'name', ['class'=>'help-block']);
		echo '</div>';
	?>
	</div>

	<?php
        if ($model->hasErrors('email')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
	<?php
		echo Html::activeLabel($model, '[' . $index . ']email', ['class'=>'col-sm-2 control-label']);
		echo '<div class="col-sm-10">';
		echo Html::activeTextInput($model, '[' . $index . ']email', [
			'maxlength' => 150, 
			'placeholder'=>'Email',
			'class'=>'form-control emailinput',
		]);

		echo Html::error($model, 'email', ['class'=>'help-block']);
		echo '</div>';
	?>
	</div>

	<?php
        if ($model->hasErrors('job')){
            echo '<div class="form-group required has-error">';
        }else{
            echo '<div class="form-group">';
        }
    ?>
	<?php
		echo Html::activeLabel($model, '[' . $index . ']job', ['class'=>'col-sm-2 control-label']);
		echo '<div class="col-sm-10">';
		echo Html::activeTextInput($model, '[' . $index . ']job', [
			'maxlength' => 150, 
			'placeholder'=>'Job',
			'class'=>'form-control jobinput',
		]);
		echo Html::error($model, 'job', ['class'=>'help-block']);
		echo '</div>';
	?>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label label-phone-<?= $index ?>">Phones</label>
		<div class="col-sm-10">
			<div class="ContactPerson-<?= $index ?>">
				<?php
					if (!isset($indexPhone))
						$indexPhone = 1;
					if (isset($model->phones) && $model->phones != null){
						foreach($model->phones as $phone){
	                        echo $this->render('../phone/_form',  ['model' => $phone, 'index' => $indexPhone, 'target' => $index,]);
	                        $indexPhone++;
	                    }
					}
				?>
			</div>
		</div>
	</div>

	<div class="form-group" style="margin-bottom:15px">
		<div class="col-sm-2"></div>
		<div class="col-sm-10">
			<a style="cursor:pointer; margin-right:5px" class="btnDelete">Delete..</a>
			<a style="cursor:pointer;" class="btnAdd">Add more contact person..</a>
		</div>
	</div>


</div>
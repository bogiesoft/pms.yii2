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
			'placeholder'=>'Enter contact person name..',
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
			'placeholder'=>'Enter contact person email address..',
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
			'placeholder'=>'Enter contact person job or position..',
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
<script>
$(".nameinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Name cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".emailinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Email cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

$(".jobinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Job cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});
</script>
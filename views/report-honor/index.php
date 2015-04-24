<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
$this->title = 'Lecturer Honor Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Lecturer Honor Report</h1>
<?php $form = ActiveForm::begin(); ?>
<div class="form-group">
<?php 
echo '<label class="control-label">Date</label>';
echo DatePicker::widget([
    'name' => 'date',
    'id' => 'dpDate',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => $date,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'M-yyyy',
        'minViewMode' => 'true',
    ]
]);
?>
<div class="help-block"></div>
<button type="submit" class="btn btn-success">Load Report</button>
<?php 
	if (isset($data) && $data != null){
?>
	
	<?= Html::a('Export as Excel', ['export-excel', 'date' => $date], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>

	<?= Html::a('Export as DBF', ['export-dbf', 'date' => $date], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
<?php
	}
?>
</div>
<?php ActiveForm::end(); ?>
<br>
<?php 
	if (isset($data) && $data != null){
?>
<table class="table table-bordered">
	<tr>
		<th>PRIOD</th>
		<th>KDSEM</th>
		<th>BULAN</th>
		<th>TAHUN</th>
		<th>KODE</th>
		<th>BRUTTO</th>
		<th>SIHARTA</th>
		<th>JMTRANS</th>
	</tr>
<?php
	foreach($data as $payment){
		echo "<tr>";
		echo "<td>".$payment["PRIOD"]."</td>";
		echo "<td>".$payment["KDSEM"]."</td>";
		echo "<td>".$payment["BULAN"]."</td>";
		echo "<td>".$payment["TAHUN"]."</td>";
		echo "<td>".$payment["KODE"]."</td>";
		echo "<td>".$payment["BRUTTO"]."</td>";
		echo "<td>".$payment["SIHARTA"]."</td>";
		echo "<td>".$payment["JMTRANS"]."</td>";
		echo "</tr>";
	}
?>
</table>
<?php
}
?>
<script>
	$("#w0").submit(function(e){
		if ($('#dpDate').val() == ""){
			$('#dpDate').closest(".form-group").attr("class", "form-group required has-error");
            $('#dpDate').closest(".form-group").find(".help-block").text("Date cannot be blank.");
			return false;
		}else{
			$('#dpDate').closest(".form-group").attr("class", "form-group required has-success");
            $('#dpDate').closest(".form-group").find(".help-block").text("");
		}
	});

	$('#dpDate').blur(function(e) {
		if ($('#dpDate').val() == ""){
			$('#dpDate').closest(".form-group").attr("class", "form-group required has-error");
            $('#dpDate').closest(".form-group").find(".help-block").text("Date cannot be blank.");
			return false;
		}else{
			$('#dpDate').closest(".form-group").attr("class", "form-group required has-success");
            $('#dpDate').closest(".form-group").find(".help-block").text("");
		}
	});

	$('#dpDate').change(function(e) {
		if ($('#dpDate').val() == ""){
			$('#dpDate').closest(".form-group").attr("class", "form-group required has-error");
            $('#dpDate').closest(".form-group").find(".help-block").text("Date cannot be blank.");
			return false;
		}else{
			$('#dpDate').closest(".form-group").attr("class", "form-group required has-success");
            $('#dpDate').closest(".form-group").find(".help-block").text("");
		}
	});
</script>
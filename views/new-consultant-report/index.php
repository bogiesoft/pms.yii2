<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

$this->title = 'New Consultant Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
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
		$year = date('Y', strtotime($date));
?>
	
	<?= Html::a('Export as Excel', ['export-excel', 'date' => $date], [
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
<div style="overflow-x:scroll">
<table class="table table-bordered" style="width:200%">
<?php
$no = 0;
$jan = 0;
$feb = 0;
$mar = 0;
$apr = 0;
$may = 0;
$jun = 0;
$jul = 0;
$aug = 0;
$sep = 0;
$oct = 0;
$nov = 0;
$decm = 0;
$str = "";

	foreach($data as $row){
		$str = $str . "<tr>";

	$jan = $jan + $row["jan"];
	$feb = $feb + $row["feb"];
	$mar = $mar + $row["mar"];
	$apr = $apr + $row["apr"];
	$may = $may + $row["may"];
	$jun = $jun + $row["jun"];
	$jul = $jul + $row["jul"];
	$aug = $aug + $row["aug"];
	$sep = $sep + $row["sep"];
	$oct = $oct + $row["oct"];
	$nov = $nov + $row["nov"];
	$decm = $decm + $row["decm"];

	$str = $str . "<td style='text-align:center; vertical-align:middle'>".++$no."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["company"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["project"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["consultant"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["role"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["agreementno"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["jan"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["feb"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["mar"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["apr"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["may"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["jun"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["jul"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["aug"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["sep"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["oct"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["nov"]."</td>";
	$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["decm"]."</td>";
	
		$str = $str . "</tr>";
	}
?>
	<tr>
		<th rowspan="3" style="text-align:center; vertical-align:middle">No</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Client</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Project</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">New Consultant</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Role</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Agreement No</th>
		<th colspan="12" style="text-align:center; vertical-align:middle">#New Consultant (cumulative)</th>
	</tr>
	<tr>
		<th style="text-align:center"><?= $jan ?></th>
		<th style="text-align:center"><?= $jan+$feb ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun+$jul ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov ?></th>
		<th style="text-align:center"><?= $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$decm ?></th>
	</tr>
	<tr>
		<th style="text-align:center">Jan</th>
		<th style="text-align:center">Feb</th>
		<th style="text-align:center">Mar</th>
		<th style="text-align:center">Apr</th>
		<th style="text-align:center">May</th>
		<th style="text-align:center">Jun</th>
		<th style="text-align:center">Jul</th>
		<th style="text-align:center">Aug</th>
		<th style="text-align:center">Sep</th>
		<th style="text-align:center">Oct</th>
		<th style="text-align:center">Nov</th>
		<th style="text-align:center">Dec</th>
	</tr>
	<?= $str ?>
</table>
</div>
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
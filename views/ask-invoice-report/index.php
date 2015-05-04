<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

$this->title = 'Ask Invoice Report';
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
$jan = 0; $janavg = 0;
$feb = 0; $febavg = 0;
$mar = 0; $maravg = 0;
$apr = 0; $apravg = 0;
$may = 0; $mayavg = 0;
$jun = 0; $junavg = 0;
$jul = 0; $julavg = 0;
$aug = 0; $augavg = 0;
$sep = 0; $sepavg = 0;
$oct = 0; $octavg = 0;
$nov = 0; $novavg = 0;
$decm = 0; $decmavg = 0;
$str = "";

	foreach($data as $row){
		$str = $str . "<tr>";

	$jan = $jan + $row["jan"];
	if ($row["jan"] != ""){
		$janavg = $janavg + 1;
	}
	$feb = $feb + $row["feb"];
	if ($row["feb"] != ""){
		$febavg = $febavg + 1;
	}
	$mar = $mar + $row["mar"];
	if ($row["mar"] != ""){
		$maravg = $maravg + 1;
	}
	$apr = $apr + $row["apr"];
	if ($row["apr"] != ""){
		$apravg = $apravg + 1;
	}
	$may = $may + $row["may"];
	if ($row["may"] != ""){
		$mayavg = $mayavg + 1;
	}
	$jun = $jun + $row["jun"];
	if ($row["jun"] != ""){
		$junavg = $junavg + 1;
	}
	$jul = $jul + $row["jul"];
	if ($row["jul"] != ""){
		$julavg = $julavg + 1;
	}
	$aug = $aug + $row["aug"];
	if ($row["aug"] != ""){
		$augavg = $augavg + 1;
	}
	$sep = $sep + $row["sep"];
	if ($row["sep"] != ""){
		$sepavg = $sepavg + 1;
	}
	$oct = $oct + $row["oct"];
	if ($row["oct"] != ""){
		$octavg = $octavg + 1;
	}
	$nov = $nov + $row["nov"];
	if ($row["nov"] != ""){
		$novavg = $novavg + 1;
	}
	$decm = $decm + $row["decm"];
	if ($row["decm"] != ""){
		$decmavg = $decmavg + 1;
	}

	$str = $str . "<td style='text-align:center; vertical-align:middle'>".++$no."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["signdate"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["company"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["project"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["customerpic"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["pic"]."</td>";
	$str = $str . "<td style='vertical-align:middle'>".$row["extsurveyscore"]."</td>";
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
		<th rowspan="3" style="text-align:center; vertical-align:middle">Agreement Date</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Client</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Project</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Customer PIC</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Business Development PIC</th>
		<th rowspan="3" style="text-align:center; vertical-align:middle">Satisfaction Index Cummulative</th>
		<th colspan="12" style="text-align:center; vertical-align:middle">Satisfication Index by Month (cummulative)</th>
	</tr>
	<tr>
		<th style="text-align:center">
<?php 
	$sum = $jan; 
	$div = $janavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $feb; 
	$div = $div + $febavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $mar; 
	$div = $div + $maravg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $apr; 
	$div = $div + $apravg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $may; 
	$div = $div + $mayavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $jun; 
	$div = $div + $junavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $jul; 
	$div = $div + $julavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $aug; 
	$div = $div + $augavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $sep; 
	$div = $div + $sepavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $oct; 
	$div = $div + $octavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $nov; 
	$div = $div + $novavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
		<th style="text-align:center">
<?php 
	$sum = $sum + $decm; 
	$div = $div + $decmavg;
?>
		<?= $div > 0 ? round($sum/$div, 2) : $sum ?></th>
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
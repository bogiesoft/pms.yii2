<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

$this->title = 'Project Detail Report';
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
	<tr>
		<th>Project Code</th>
		<th>Status</th>
		<th>Patner Name</th>
		<th>Project Name</th>
		<th>BDD PIC</th>
		<th>Agreement Signed/ Other Value Calculation Starting Point (month)</th>
		<th>Remarks/ Cancellation Remarks</th>
		<th>Faculty/ School</th>
		<th>Department</th>
		<th>PIC</th>
		<th>Project Overview</th>
		<th>Patner Type</th>
		<th>Product Type</th>
		<th>Target Cash In from Outstanding Project <?=$year-1?></th>
		<th>Target Project Value <?=$year?></th>
		<th>Cash In (Project <?=$year - 1?>)</th>
		<th>Cash In (Project <?=$year?>)</th>
		<th>Current Total Installment per Project</th>
		<th>% installment</th>
		<th>Non Tuition Type</th>
		<th>Jan</th>
		<th>Feb</th>
		<th>Mar</th>
		<th>Apr</th>
		<th>May</th>
		<th>Jun</th>
		<th>Jul</th>
		<th>Aug</th>
		<th>Sep</th>
		<th>Oct</th>
		<th>Nov</th>
		<th>Dec</th>
		<th>Expenses Actualized</th>
		<th>Profit Actualized in <?=$year?></th>
	</tr>
<?php
	foreach($data as $row){
		echo "<tr>";
		echo "<td>".$row["projectcode"]."</td>";
	echo "<td>".$row["status"]."</td>";
	echo "<td>".$row["company"]."</td>";
	echo "<td>".$row["projectname"]."</td>";
	echo "<td>".$row["bddpic"]."</td>";
	echo "<td>".$row["signed"]."</td>";
	echo "<td>".$row["cancelremark"]."</td>";
	echo "<td>".$row["faculty"]."</td>";
	echo "<td>".$row["department"]."</td>";
	echo "<td>".$row["pic"]."</td>";
	echo "<td>".$row["overview"]."</td>";
	echo "<td>".$row["partnertype"]."</td>";
	echo "<td>".$row["producttype"]."</td>";
	echo "<td>".$row["targetprev"]."</td>";
	echo "<td>".$row["targetyear"]."</td>";
	echo "<td>".$row["cashinprev"]."</td>";
	echo "<td>".$row["cashin"]."</td>";
	echo "<td>".$row["totalinstall"]."</td>";
	echo "<td>".$row["percentinstall"]."</td>";
	echo "<td>".$row["tuitiontype"]."</td>";
	echo "<td>".$row["jan"]."</td>";
	echo "<td>".$row["feb"]."</td>";
	echo "<td>".$row["mar"]."</td>";
	echo "<td>".$row["apr"]."</td>";
	echo "<td>".$row["may"]."</td>";
	echo "<td>".$row["jun"]."</td>";
	echo "<td>".$row["jul"]."</td>";
	echo "<td>".$row["aug"]."</td>";
	echo "<td>".$row["sep"]."</td>";
	echo "<td>".$row["oct"]."</td>";
	echo "<td>".$row["nov"]."</td>";
	echo "<td>".$row["decm"]."</td>";
	echo "<td>".$row["cost"]."</td>";
	echo "<td>".$row["profitactual"]."</td>";
		echo "</tr>";
	}
?>
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
<?php

namespace app\controllers;

class ExternalPaymentReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$date = null;

    	if (isset($_POST["date"])){
    		$date = $_POST["date"];
    	}

    	if ($date != null){
    		
    		$connection = \Yii::$app->db;

			$model = $connection->createCommand("
				select b.agreementno, c.company, a.code, a.name, d.description, d.rate, 
					d.rate * (1 + (b.ppn/100)) as rateppn, date_format(e.invoicedate, '%d-%b-%Y') invoicedate, 
					date_format(e.sentdate, '%d-%b-%Y') sentdate, 
					date_format(e.invoicedeadline, '%d-%b-%Y') as invoicedeadline, 
					date_format(e.targetdate, '%d-%b-%Y') as targetdate, 
					date_format(e.date, '%d-%b-%Y') as date, DATEDIFF(e.date, e.invoicedate) as duration,
					e.remark, jan.duration as jan, feb.duration as feb,
					mar.duration as mar, apr.duration as apr,
					may.duration as may, jun.duration as jun, jul.duration as jul,
					aug.duration as aug, sep.duration as sep, oct.duration as oct,
					nov.duration as nov, decm.duration as decm
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_customer c on a.customerid = c.customerid
				join ps_extdeliverables d on b.extagreementid = d.extagreementid
				left join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '01' and date_format(e.date, '%Y') = :1
				) jan on a.projectid = jan.projectid and b.extagreementid = jan.extagreementid and 
					d.extdeliverableid = jan.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '02' and date_format(e.date, '%Y') = :1
				) feb on a.projectid = feb.projectid and b.extagreementid = feb.extagreementid and 
					d.extdeliverableid = feb.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '03' and date_format(e.date, '%Y') = :1
				) mar on a.projectid = mar.projectid and b.extagreementid = mar.extagreementid and 
					d.extdeliverableid = mar.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '04' and date_format(e.date, '%Y') = :1
				) apr on a.projectid = apr.projectid and b.extagreementid = apr.extagreementid and 
					d.extdeliverableid = apr.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '05' and date_format(e.date, '%Y') = :1
				) may on a.projectid = may.projectid and b.extagreementid = may.extagreementid and 
					d.extdeliverableid = may.extdeliverableid

				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '06' and date_format(e.date, '%Y') = :1
				) jun on a.projectid = jun.projectid and b.extagreementid = jun.extagreementid and 
					d.extdeliverableid = jun.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '07' and date_format(e.date, '%Y') = :1
				) jul on a.projectid = jul.projectid and b.extagreementid = jul.extagreementid and 
					d.extdeliverableid = jul.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '08' and date_format(e.date, '%Y') = :1
				) aug on a.projectid = aug.projectid and b.extagreementid = aug.extagreementid and 
					d.extdeliverableid = aug.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '09' and date_format(e.date, '%Y') = :1
				) sep on a.projectid = sep.projectid and b.extagreementid = sep.extagreementid and 
					d.extdeliverableid = sep.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '10' and date_format(e.date, '%Y') = :1
				) oct on a.projectid = oct.projectid and b.extagreementid = oct.extagreementid and 
					d.extdeliverableid = oct.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '11' and date_format(e.date, '%Y') = :1
				) nov on a.projectid = nov.projectid and b.extagreementid = nov.extagreementid and 
					d.extdeliverableid = nov.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '12' and date_format(e.date, '%Y') = :1
				) decm on a.projectid = decm.projectid and b.extagreementid = decm.extagreementid and 
					d.extdeliverableid = decm.extdeliverableid
				
				order by b.agreementno, c.company, a.code, a.name, d.description, d.rate
			");
			
			$model->bindValue(':1', date('Y', strtotime($date)));

			$data = $model->queryAll();


		    return $this->render('index', [
	            'data' => $data,
	            'date' => $date,
	        ]);
    	}else{
    		return $this->render('index', [
	            'date' => $date,
	        ]);	
    	}
    }

    public function actionExportExcel($date)
    {
    	$date = null;

    	if (isset($_GET["date"])){
    		$date = $_GET["date"];
    	}

    	if ($date != null){
    		$connection = \Yii::$app->db;

			$model = $connection->createCommand("
				select b.agreementno, c.company, a.code, a.name, d.description, d.rate, 
					d.rate * (1 + (b.ppn/100)) as rateppn, date_format(e.invoicedate, '%d-%b-%Y') invoicedate, 
					date_format(e.sentdate, '%d-%b-%Y') sentdate, 
					date_format(e.invoicedeadline, '%d-%b-%Y') as invoicedeadline, 
					date_format(e.targetdate, '%d-%b-%Y') as targetdate, 
					date_format(e.date, '%d-%b-%Y') as date, DATEDIFF(e.date, e.invoicedate) as duration,
					e.remark, jan.duration as jan, feb.duration as feb,
					mar.duration as mar, apr.duration as apr,
					may.duration as may, jun.duration as jun, jul.duration as jul,
					aug.duration as aug, sep.duration as sep, oct.duration as oct,
					nov.duration as nov, decm.duration as decm
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_customer c on a.customerid = c.customerid
				join ps_extdeliverables d on b.extagreementid = d.extagreementid
				left join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '01' and date_format(e.date, '%Y') = :1
				) jan on a.projectid = jan.projectid and b.extagreementid = jan.extagreementid and 
					d.extdeliverableid = jan.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '02' and date_format(e.date, '%Y') = :1
				) feb on a.projectid = feb.projectid and b.extagreementid = feb.extagreementid and 
					d.extdeliverableid = feb.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '03' and date_format(e.date, '%Y') = :1
				) mar on a.projectid = mar.projectid and b.extagreementid = mar.extagreementid and 
					d.extdeliverableid = mar.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '04' and date_format(e.date, '%Y') = :1
				) apr on a.projectid = apr.projectid and b.extagreementid = apr.extagreementid and 
					d.extdeliverableid = apr.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '05' and date_format(e.date, '%Y') = :1
				) may on a.projectid = may.projectid and b.extagreementid = may.extagreementid and 
					d.extdeliverableid = may.extdeliverableid

				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '06' and date_format(e.date, '%Y') = :1
				) jun on a.projectid = jun.projectid and b.extagreementid = jun.extagreementid and 
					d.extdeliverableid = jun.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '07' and date_format(e.date, '%Y') = :1
				) jul on a.projectid = jul.projectid and b.extagreementid = jul.extagreementid and 
					d.extdeliverableid = jul.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '08' and date_format(e.date, '%Y') = :1
				) aug on a.projectid = aug.projectid and b.extagreementid = aug.extagreementid and 
					d.extdeliverableid = aug.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '09' and date_format(e.date, '%Y') = :1
				) sep on a.projectid = sep.projectid and b.extagreementid = sep.extagreementid and 
					d.extdeliverableid = sep.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '10' and date_format(e.date, '%Y') = :1
				) oct on a.projectid = oct.projectid and b.extagreementid = oct.extagreementid and 
					d.extdeliverableid = oct.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '11' and date_format(e.date, '%Y') = :1
				) nov on a.projectid = nov.projectid and b.extagreementid = nov.extagreementid and 
					d.extdeliverableid = nov.extdeliverableid
				left join (
					select b.projectid, b.extagreementid, d.extdeliverableid, 
						coalesce(DATEDIFF(e.date, e.invoicedate), 0) as duration
					from ps_extagreement b
					join ps_extdeliverables d on b.extagreementid = d.extagreementid
					join ps_extagreementpayment e on d.extdeliverableid = e.extdeliverableid
					where date_format(e.date, '%m') = '12' and date_format(e.date, '%Y') = :1
				) decm on a.projectid = decm.projectid and b.extagreementid = decm.extagreementid and 
					d.extdeliverableid = decm.extdeliverableid
				
				order by b.agreementno, c.company, a.code, a.name, d.description, d.rate");
			
			$model->bindValue(':1', date('Y', strtotime($date)));
			
			$data = $model->queryAll();
			$content = "<table border='1'>";
			$no = 0; $str = "";
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
				$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["agreementno"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["company"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["code"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["name"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".number_format($row["rate"])."</td>";
				$str = $str . "<td style='vertical-align:middle'>".number_format($row["rateppn"])."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["invoicedate"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["sentdate"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["invoicedeadline"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["targetdate"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["date"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["duration"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["remark"]."</td>";
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

			$content = $content . '<tr><th rowspan="3" style="text-align:center; vertical-align:middle">No</th><th rowspan="3" style="text-align:center; vertical-align:middle">No PKS</th><th rowspan="3" style="text-align:center; vertical-align:middle">Klien</th><th rowspan="3" style="text-align:center; vertical-align:middle">Project No</th><th rowspan="3" style="text-align:center; vertical-align:middle">Proyek</th><th rowspan="3" style="text-align:center; vertical-align:middle">Nilai Tagihan</th><th rowspan="3" style="text-align:center; vertical-align:middle">Nilai Tagihan (+PPN/No)</th><th rowspan="3" style="text-align:center; vertical-align:middle">Tgl Invoice</th><th rowspan="3" style="text-align:center; vertical-align:middle">Tgl Kirim</th><th rowspan="3" style="text-align:center; vertical-align:middle">Jatuh Tempo Invoice</th><th rowspan="3" style="text-align:center; vertical-align:middle">Target</th><th rowspan="3" style="text-align:center; vertical-align:middle">Tgl Payment</th><th rowspan="3" style="text-align:center; vertical-align:middle">Payment Duration</th><th rowspan="3" style="text-align:center; vertical-align:middle">Remark</th><th colspan="12" style="text-align:center; vertical-align:middle">Jumlah hari dari Tanggal Invoice - Tanggal Bayar Per Bulan</th></tr>';

			$sum = $jan; 
			$div = $janavg;
			$content = $content . '<tr><th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $feb; 
			$div = $div + $febavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $mar; 
			$div = $div + $maravg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $apr; 
			$div = $div + $apravg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $may; 
			$div = $div + $mayavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $jun; 
			$div = $div + $junavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $jul; 
			$div = $div + $julavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $aug; 
			$div = $div + $augavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $sep; 
			$div = $div + $sepavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $oct; 
			$div = $div + $octavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $nov; 
			$div = $div + $novavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th>';

			$sum = $sum + $decm; 
			$div = $div + $decmavg;
			$content = $content . '<th style="text-align:center">' . ($div > 0 ? round($sum/$div, 2) : $sum) . '</th></tr>';
	
			$content = $content . '<tr><th style="text-align:center">Jan</th><th style="text-align:center">Feb</th><th style="text-align:center">Mar</th><th style="text-align:center">Apr</th><th style="text-align:center">May</th><th style="text-align:center">Jun</th><th style="text-align:center">Jul</th><th style="text-align:center">Aug</th><th style="text-align:center">Sep</th><th style="text-align:center">Oct</th><th style="text-align:center">Nov</th><th style="text-align:center">Dec</th></tr>';

			$content = $content . $str;
			$content = $content . "</table>";

			$filename ="external_payment.xls";
			
			ob_get_clean();
		    header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    header("Cache-Control: private", false);
		    header('Content-type: application/vnd-ms-excel');
			header('Content-Disposition: attachment; filename='.$filename);
		    header("Content-Transfer-Encoding: binary");
			echo $content;

			return $this->redirect(['index']);
		}
    }
}

<?php

namespace app\controllers;

class InternalPaymentReportController extends \yii\web\Controller
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
				select a.nopks, a.klien, a.proyek, a.nodeliverable, a.ketdeliverable, 
					date_format(a.tglbast, '%d-%b-%Y') as tglbast, a.nilaihonor,
					date_format(a.targethonor, '%b-%Y') as targethonor,
					date_format(a.paymentdate, '%d-%b-%Y') as paymentdate, 
					date_format(a.honordate, '%d-%b-%Y') as honordate,
					a.remark,
					case when date_format(a.paymentdate, '%m') = '01' then a.remark end as jan,
					case when date_format(a.paymentdate, '%m') = '02' then a.remark end as feb,
					case when date_format(a.paymentdate, '%m') = '03' then a.remark end as mar,
					case when date_format(a.paymentdate, '%m') = '04' then a.remark end as apr,
					case when date_format(a.paymentdate, '%m') = '05' then a.remark end as may,
					case when date_format(a.paymentdate, '%m') = '06' then a.remark end as jun,
					case when date_format(a.paymentdate, '%m') = '07' then a.remark end as jul,
					case when date_format(a.paymentdate, '%m') = '08' then a.remark end as aug,
					case when date_format(a.paymentdate, '%m') = '09' then a.remark end as sep,
					case when date_format(a.paymentdate, '%m') = '10' then a.remark end as oct,
					case when date_format(a.paymentdate, '%m') = '11' then a.remark end as nov,
					case when date_format(a.paymentdate, '%m') = '12' then a.remark end as decm
				from (
				select b.agreementno as nopks, d.company as klien, a.name as proyek, e.code as nodeliverable, 
					f.description as ketdeliverable, f.duedate as tglbast, f.rate as nilaihonor,
					case when date_format(f.duedate, '%d') < '05' then f.duedate
						else DATE_ADD(f.duedate, INTERVAL 1 MONTH) end as targethonor, 
					g.date as paymentdate, g.honordate,
					case when (date_format(g.honordate, '%m-%Y') > date_format(f.duedate, '%m-%Y') and 
						date_format(f.duedate, '%d') < '05') or 
					(date_format(g.honordate, '%m-%Y') > date_format(DATE_ADD(f.duedate, INTERVAL 1 MONTH), '%m-%Y') and 
						date_format(f.duedate, '%d') >= '05') then 
						case when g.honordate is not null then 0 else null end else 
						case when g.honordate is not null then 1 else null end
					end as remark
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_intagreement c on b.extagreementid = c.extagreementid
				join ps_extdeliverables e on b.extagreementid = e.extagreementid
				join ps_intdeliverables f on f.extdeliverableid = e.extdeliverableid and f.intagreementid = c.intagreementid
				left join ps_intagreementpayment g on f.intdeliverableid = g.intdeliverableid
				join ps_customer d on a.customerid = d.customerid 
				where date_format(f.duedate, '%Y') = :1
				) a");
			
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
				select a.nopks, a.klien, a.proyek, a.nodeliverable, a.ketdeliverable, 
					date_format(a.tglbast, '%d-%b-%Y') as tglbast, a.nilaihonor,
					date_format(a.targethonor, '%b-%Y') as targethonor,
					date_format(a.paymentdate, '%d-%b-%Y') as paymentdate, 
					date_format(a.honordate, '%d-%b-%Y') as honordate,
					a.remark,
					case when date_format(a.paymentdate, '%m') = '01' then a.remark end as jan,
					case when date_format(a.paymentdate, '%m') = '02' then a.remark end as feb,
					case when date_format(a.paymentdate, '%m') = '03' then a.remark end as mar,
					case when date_format(a.paymentdate, '%m') = '04' then a.remark end as apr,
					case when date_format(a.paymentdate, '%m') = '05' then a.remark end as may,
					case when date_format(a.paymentdate, '%m') = '06' then a.remark end as jun,
					case when date_format(a.paymentdate, '%m') = '07' then a.remark end as jul,
					case when date_format(a.paymentdate, '%m') = '08' then a.remark end as aug,
					case when date_format(a.paymentdate, '%m') = '09' then a.remark end as sep,
					case when date_format(a.paymentdate, '%m') = '10' then a.remark end as oct,
					case when date_format(a.paymentdate, '%m') = '11' then a.remark end as nov,
					case when date_format(a.paymentdate, '%m') = '12' then a.remark end as decm
				from (
				select b.agreementno as nopks, d.company as klien, a.name as proyek, e.code as nodeliverable, 
					f.description as ketdeliverable, f.duedate as tglbast, f.rate as nilaihonor,
					case when date_format(f.duedate, '%d') < '05' then f.duedate
						else DATE_ADD(f.duedate, INTERVAL 1 MONTH) end as targethonor, 
					g.date as paymentdate, g.honordate,
					case when (date_format(g.honordate, '%m-%Y') > date_format(f.duedate, '%m-%Y') and 
						date_format(f.duedate, '%d') < '05') or 
					(date_format(g.honordate, '%m-%Y') > date_format(DATE_ADD(f.duedate, INTERVAL 1 MONTH), '%m-%Y') and 
						date_format(f.duedate, '%d') >= '05') then 
						case when g.honordate is not null then 0 else null end else 
						case when g.honordate is not null then 1 else null end
					end as remark
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_intagreement c on b.extagreementid = c.extagreementid
				join ps_extdeliverables e on b.extagreementid = e.extagreementid
				join ps_intdeliverables f on f.extdeliverableid = e.extdeliverableid and f.intagreementid = c.intagreementid
				left join ps_intagreementpayment g on f.intdeliverableid = g.intdeliverableid
				join ps_customer d on a.customerid = d.customerid 
				where date_format(f.duedate, '%Y') = :1
				) a");
			
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
				$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["nopks"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["klien"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["proyek"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["nodeliverable"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["ketdeliverable"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["tglbast"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["nilaihonor"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["targethonor"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["paymentdate"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["honordate"]."</td>";
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

			$content = $content . '<tr><th rowspan="3" style="text-align:center; vertical-align:middle">No</th><th rowspan="3" style="text-align:center; vertical-align:middle">No PKS</th><th rowspan="3" style="text-align:center; vertical-align:middle">Klien</th><th rowspan="3" style="text-align:center; vertical-align:middle">Proyek</th><th rowspan="3" style="text-align:center; vertical-align:middle">No Deliverable</th><th rowspan="3" style="text-align:center; vertical-align:middle">Keterangan Deliverable</th><th rowspan="3" style="text-align:center; vertical-align:middle">Tanggal BAST</th><th rowspan="3" style="text-align:center; vertical-align:middle">Nilai Honor</th><th rowspan="3" style="text-align:center; vertical-align:middle">Target Bulan Honor</th><th rowspan="3" style="text-align:center; vertical-align:middle">Tanggal dibayarkan</th><th rowspan="3" style="text-align:center; vertical-align:middle">Aktualiasi Bulan Honor</th><th rowspan="3" style="text-align:center; vertical-align:middle">Remark</th><th colspan="12" style="text-align:center; vertical-align:middle">Ketepatan Pembayaran Honor</th></tr>';

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

			$filename ="internal_payment.xls";
			
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

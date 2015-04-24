<?php

namespace app\controllers;

class GlobalCompanyReportController extends \yii\web\Controller
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
				select distinct date_format(c.signdate, '%b-%Y') as agreementmonth, b.company, a.name, 
					'Global Client' as remarks, a.projectid, count(jan.customerid) jan, count(feb.customerid) feb,
					count(mar.customerid) mar, count(apr.customerid) apr, count(may.customerid) may, count(jun.customerid) jun,
					count(jul.customerid) jul, count(aug.customerid) aug, count(sep.customerid) sep, count(oct.customerid) oct, 
					count(nov.customerid) nov, count(decm.customerid) decm
				from ps_project a
				join ps_customer b on a.customerid = b.customerid and b.global = 1
				join ps_extagreement c on a.projectid = c.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '01' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) jan on a.customerid = jan.customerid and a.projectid = jan.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '02' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) feb on a.customerid = feb.customerid and a.projectid = feb.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '03' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) mar on a.customerid = mar.customerid and a.projectid = mar.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '04' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) apr on a.customerid = apr.customerid and a.projectid = apr.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '05' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) may on a.customerid = may.customerid and a.projectid = may.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '06' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) jun on a.customerid = jun.customerid and a.projectid = jun.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '07' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) jul on a.customerid = jul.customerid and a.projectid = jul.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '08' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) aug on a.customerid = aug.customerid and a.projectid = aug.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '09' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) sep on a.customerid = sep.customerid and a.projectid = sep.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '10' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) oct on a.customerid = oct.customerid and a.projectid = oct.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '11' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) nov on a.customerid = nov.customerid and a.projectid = nov.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '12' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) decm on a.customerid = decm.customerid and a.projectid = decm.projectid
				where date_format(c.signdate, '%Y') = :1
				group by c.signdate, b.company, a.name, a.projectid");
			
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
				select distinct date_format(c.signdate, '%b-%Y') as agreementmonth, b.company, a.name, 
					'Global Client' as remarks, a.projectid, count(jan.customerid) jan, count(feb.customerid) feb,
					count(mar.customerid) mar, count(apr.customerid) apr, count(may.customerid) may, count(jun.customerid) jun,
					count(jul.customerid) jul, count(aug.customerid) aug, count(sep.customerid) sep, count(oct.customerid) oct, 
					count(nov.customerid) nov, count(decm.customerid) decm
				from ps_project a
				join ps_customer b on a.customerid = b.customerid and b.global = 1
				join ps_extagreement c on a.projectid = c.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '01' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) jan on a.customerid = jan.customerid and a.projectid = jan.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '02' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) feb on a.customerid = feb.customerid and a.projectid = feb.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '03' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) mar on a.customerid = mar.customerid and a.projectid = mar.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '04' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) apr on a.customerid = apr.customerid and a.projectid = apr.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '05' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) may on a.customerid = may.customerid and a.projectid = may.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '06' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) jun on a.customerid = jun.customerid and a.projectid = jun.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '07' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) jul on a.customerid = jul.customerid and a.projectid = jul.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '08' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) aug on a.customerid = aug.customerid and a.projectid = aug.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '09' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) sep on a.customerid = sep.customerid and a.projectid = sep.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '10' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) oct on a.customerid = oct.customerid and a.projectid = oct.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '11' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) nov on a.customerid = nov.customerid and a.projectid = nov.projectid
				left join (
					select a.customerid, min(a.projectid) projectid from ps_project a
					join ps_customer b on a.customerid = b.customerid and b.global = 1
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where date_format(c.signdate, '%m') = '12' and c.signdate in (
						select min(cc.signdate) from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.CustomerId = a.customerid and date_format(cc.signdate, '%Y') = :1
					)
					group by a.customerid
				) decm on a.customerid = decm.customerid and a.projectid = decm.projectid
				where date_format(c.signdate, '%Y') = :1
				group by c.signdate, b.company, a.name, a.projectid");
			
			$model->bindValue(':1', date('Y', strtotime($date)));
			
			$data = $model->queryAll();
			$content = "<table border='1'>";
			$no = 0; $jan = 0; $feb = 0; $mar = 0; $apr = 0;
			$may = 0; $jun = 0; $jul = 0; $aug = 0; $sep = 0;
			$oct = 0; $nov = 0; $decm = 0; $str = "";

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
				$str = $str . "<td style='text-align:center; vertical-align:middle'>".$row["agreementmonth"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["company"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["name"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["remarks"]."</td>";
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

			$content = $content . '<tr><th rowspan="3" style="text-align:center; vertical-align:middle">No</th><th rowspan="3" style="text-align:center; vertical-align:middle">Agreement Month</th><th rowspan="3" style="text-align:center; vertical-align:middle">Client</th><th rowspan="3" style="text-align:center; vertical-align:middle">Project</th><th rowspan="3" style="text-align:center; vertical-align:middle">Remarks</th><th colspan="12" style="text-align:center; vertical-align:middle">Recurring Month (cumulative)</th></tr><tr><th style="text-align:center">'. ($jan) .'</th><th style="text-align:center">'. ($jan+$feb) .'</th><th style="text-align:center">'. ($jan+$feb+$mar) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$decm) .'</th></tr><tr><th style="text-align:center">Jan</th><th style="text-align:center">Feb</th><th style="text-align:center">Mar</th><th style="text-align:center">Apr</th><th style="text-align:center">May</th><th style="text-align:center">Jun</th><th style="text-align:center">Jul</th><th style="text-align:center">Aug</th><th style="text-align:center">Sep</th><th style="text-align:center">Oct</th><th style="text-align:center">Nov</th><th style="text-align:center">Dec</th></tr>';

			$content = $content . $str;
			$content = $content . "</table>";

			$filename ="global_company.xls";
			
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

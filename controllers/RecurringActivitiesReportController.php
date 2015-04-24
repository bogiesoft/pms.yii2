<?php

namespace app\controllers;

class RecurringActivitiesReportController extends \yii\web\Controller
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
					count(jan.projectid) as jan, count(feb.projectid) as feb,
					count(mar.projectid) as mar, count(apr.projectid) as apr,
					count(may.projectid) as may, count(jun.projectid) as jun,
					count(jul.projectid) as jul, count(aug.projectid) as aug,
					count(sep.projectid) as sep, count(oct.projectid) as oct,
					count(nov.projectid) as nov, count(decm.projectid) as decm
				from ps_project a
				join ps_customer b on a.customerid = b.customerid
				join ps_extagreement c on a.projectid = c.projectid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '01'
				) jan on a.projectid = jan.projectid and c.extagreementid = jan.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '02'
				) feb on a.projectid = feb.projectid and c.extagreementid = feb.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '03'
				) mar on a.projectid = mar.projectid and c.extagreementid = mar.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '04'
				) apr on a.projectid = apr.projectid and c.extagreementid = apr.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '05'
				) may on a.projectid = may.projectid and c.extagreementid = may.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '06'
				) jun on a.projectid = jun.projectid and c.extagreementid = jun.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '07'
				) jul on a.projectid = jul.projectid and c.extagreementid = jul.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '08'
				) aug on a.projectid = aug.projectid and c.extagreementid = aug.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '09'
				) sep on a.projectid = sep.projectid and c.extagreementid = sep.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '10'
				) oct on a.projectid = oct.projectid and c.extagreementid = oct.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '10'
				) nov on a.projectid = nov.projectid and c.extagreementid = nov.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '11'
				) decm on a.projectid = decm.projectid and c.extagreementid = decm.extagreementid
				where date_format(c.signdate, '%Y') = :1
				group by c.signdate, b.company, a.name, a.projectid
				order by c.signdate, b.company, a.name, a.projectid");
			
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
					count(jan.projectid) as jan, count(feb.projectid) as feb,
					count(mar.projectid) as mar, count(apr.projectid) as apr,
					count(may.projectid) as may, count(jun.projectid) as jun,
					count(jul.projectid) as jul, count(aug.projectid) as aug,
					count(sep.projectid) as sep, count(oct.projectid) as oct,
					count(nov.projectid) as nov, count(decm.projectid) as decm
				from ps_project a
				join ps_customer b on a.customerid = b.customerid
				join ps_extagreement c on a.projectid = c.projectid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '01'
				) jan on a.projectid = jan.projectid and c.extagreementid = jan.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '02'
				) feb on a.projectid = feb.projectid and c.extagreementid = feb.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '03'
				) mar on a.projectid = mar.projectid and c.extagreementid = mar.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '04'
				) apr on a.projectid = apr.projectid and c.extagreementid = apr.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '05'
				) may on a.projectid = may.projectid and c.extagreementid = may.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '06'
				) jun on a.projectid = jun.projectid and c.extagreementid = jun.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '07'
				) jul on a.projectid = jul.projectid and c.extagreementid = jul.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '08'
				) aug on a.projectid = aug.projectid and c.extagreementid = aug.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '09'
				) sep on a.projectid = sep.projectid and c.extagreementid = sep.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '10'
				) oct on a.projectid = oct.projectid and c.extagreementid = oct.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '10'
				) nov on a.projectid = nov.projectid and c.extagreementid = nov.extagreementid
				left join (
					select distinct a.customerid, a.projectid, c.signdate, c.extagreementid
					from ps_project a
					join ps_extagreement c on a.projectid = c.projectid and date_format(c.signdate, '%Y') = :1
					where a.projectid not in (
						select min(projectid) from ps_project where customerid = a.customerid
					) and date_format(c.signdate, '%m-%Y') in (
						select date_format(min(signdate), '%m-%Y') from ps_project aa
						join ps_extagreement cc on aa.projectid = cc.projectid
						where aa.projectid = a.projectid
					) and date_format(c.signdate, '%m') = '11'
				) decm on a.projectid = decm.projectid and c.extagreementid = decm.extagreementid
				where date_format(c.signdate, '%Y') = :1
				group by c.signdate, b.company, a.name, a.projectid
				order by c.signdate, b.company, a.name, a.projectid");
			
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

			$content = $content . '<tr><th rowspan="3" style="text-align:center; vertical-align:middle">No</th><th rowspan="3" style="text-align:center; vertical-align:middle">Agreement Month</th><th rowspan="3" style="text-align:center; vertical-align:middle">Client</th><th rowspan="3" style="text-align:center; vertical-align:middle">Project</th><th colspan="12" style="text-align:center; vertical-align:middle">Recurring Month (cumulative)</th></tr><tr><th style="text-align:center">'. ($jan) .'</th><th style="text-align:center">'. ($jan+$feb) .'</th><th style="text-align:center">'. ($jan+$feb+$mar) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$decm) .'</th></tr><tr><th style="text-align:center">Jan</th><th style="text-align:center">Feb</th><th style="text-align:center">Mar</th><th style="text-align:center">Apr</th><th style="text-align:center">May</th><th style="text-align:center">Jun</th><th style="text-align:center">Jul</th><th style="text-align:center">Aug</th><th style="text-align:center">Sep</th><th style="text-align:center">Oct</th><th style="text-align:center">Nov</th><th style="text-align:center">Dec</th></tr>';

			$content = $content . $str;
			$content = $content . "</table>";

			$filename ="recurring_activities.xls";
			
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

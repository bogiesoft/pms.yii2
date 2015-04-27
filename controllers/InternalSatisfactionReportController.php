<?php

namespace app\controllers;

class InternalSatisfactionReportController extends \yii\web\Controller
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
				select distinct a.projectid, c.signdate, d.company, a.name as project, f.name as consultant, g.pic, e.score,
					case when date_format(c.signdate, '%m') = '01' then e.score end as jan,
					case when date_format(c.signdate, '%m') = '02' then e.score end as feb,
					case when date_format(c.signdate, '%m') = '03' then e.score end as mar,
					case when date_format(c.signdate, '%m') = '04' then e.score end as apr,
					case when date_format(c.signdate, '%m') = '05' then e.score end as may,
					case when date_format(c.signdate, '%m') = '06' then e.score end as jun,
					case when date_format(c.signdate, '%m') = '07' then e.score end as jul,
					case when date_format(c.signdate, '%m') = '08' then e.score end as aug,
					case when date_format(c.signdate, '%m') = '09' then e.score end as sep,
					case when date_format(c.signdate, '%m') = '10' then e.score end as oct,
					case when date_format(c.signdate, '%m') = '11' then e.score end as nov,
					case when date_format(c.signdate, '%m') = '12' then e.score end as decm
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_intagreement c on b.extagreementid = c.extagreementid
				join ps_customer d on a.customerid = d.customerid
				left join ps_intsurvey e on a.projectid = e.projectid and c.consultantid = e.consultantid
				left join ps_consultant f on e.consultantid = f.consultantid
				left join (
						select g.projectid, group_concat(h.name separator ', ') as pic from ps_projectpic g
						join ps_user h on g.userid = h.userid
						group by g.projectid
					) g on a.projectid = g.projectid
				where date_format(c.signdate, '%Y') = :1
				order by c.signdate, d.company, a.name
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
				select distinct a.projectid, c.signdate, d.company, a.name as project, f.name as consultant, g.pic, e.score,
					case when date_format(c.signdate, '%m') = '01' then e.score end as jan,
					case when date_format(c.signdate, '%m') = '02' then e.score end as feb,
					case when date_format(c.signdate, '%m') = '03' then e.score end as mar,
					case when date_format(c.signdate, '%m') = '04' then e.score end as apr,
					case when date_format(c.signdate, '%m') = '05' then e.score end as may,
					case when date_format(c.signdate, '%m') = '06' then e.score end as jun,
					case when date_format(c.signdate, '%m') = '07' then e.score end as jul,
					case when date_format(c.signdate, '%m') = '08' then e.score end as aug,
					case when date_format(c.signdate, '%m') = '09' then e.score end as sep,
					case when date_format(c.signdate, '%m') = '10' then e.score end as oct,
					case when date_format(c.signdate, '%m') = '11' then e.score end as nov,
					case when date_format(c.signdate, '%m') = '12' then e.score end as decm
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_intagreement c on b.extagreementid = c.extagreementid
				join ps_customer d on a.customerid = d.customerid
				left join ps_intsurvey e on a.projectid = e.projectid and c.consultantid = e.consultantid
				left join ps_consultant f on e.consultantid = f.consultantid
				left join (
						select g.projectid, group_concat(h.name separator ', ') as pic from ps_projectpic g
						join ps_user h on g.userid = h.userid
						group by g.projectid
					) g on a.projectid = g.projectid
				where date_format(c.signdate, '%Y') = :1
				order by c.signdate, d.company, a.name");
			
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
				$str = $str . "<td style='vertical-align:middle'>".$row["signdate"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["company"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["project"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["consultant"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["pic"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["score"]."</td>";
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

			$content = $content . '<tr><th rowspan="3" style="text-align:center; vertical-align:middle">No</th><th rowspan="3" style="text-align:center; vertical-align:middle">Agreement Date</th><th rowspan="3" style="text-align:center; vertical-align:middle">Client</th><th rowspan="3" style="text-align:center; vertical-align:middle">Project</th><th rowspan="3" style="text-align:center; vertical-align:middle">Resources</th><th rowspan="3" style="text-align:center; vertical-align:middle">Business Development PIC</th><th rowspan="3" style="text-align:center; vertical-align:middle">Satisfaction Index Cummulative</th><th colspan="12" style="text-align:center; vertical-align:middle">Satisfication Index by Month (cummulative)</th></tr>';

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

			$filename ="Internal_Satisfaction.xls";
			
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

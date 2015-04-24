<?php

namespace app\controllers;

class ArticleReportController extends \yii\web\Controller
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
				select distinct b.company, a.name, date_format(c.postingdate, '%d-%b-%Y') as postingdate, c.link,
					case when date_format(c.postingdate, '%m') = '01' then 1 end jan,
					case when date_format(c.postingdate, '%m') = '02' then 1 end feb,
					case when date_format(c.postingdate, '%m') = '03' then 1 end mar,
					case when date_format(c.postingdate, '%m') = '04' then 1 end apr,
					case when date_format(c.postingdate, '%m') = '05' then 1 end may,
					case when date_format(c.postingdate, '%m') = '06' then 1 end jun,
					case when date_format(c.postingdate, '%m') = '07' then 1 end jul,
					case when date_format(c.postingdate, '%m') = '08' then 1 end aug,
					case when date_format(c.postingdate, '%m') = '09' then 1 end sep,
					case when date_format(c.postingdate, '%m') = '10' then 1 end oct,
					case when date_format(c.postingdate, '%m') = '11' then 1 end nov,
					case when date_format(c.postingdate, '%m') = '12' then 1 end decm
				from ps_project a
				join ps_customer b on a.customerid = b.customerid
				left join ps_finalizationproject c on a.projectid = c.projectid
				where date_format(c.postingdate, '%Y') = :1
				order by b.company, a.name, c.postingdate, c.link");
			
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
				select distinct b.company, a.name, date_format(c.postingdate, '%d-%b-%Y') as postingdate, c.link,
					case when date_format(c.postingdate, '%m') = '01' then 1 end jan,
					case when date_format(c.postingdate, '%m') = '02' then 1 end feb,
					case when date_format(c.postingdate, '%m') = '03' then 1 end mar,
					case when date_format(c.postingdate, '%m') = '04' then 1 end apr,
					case when date_format(c.postingdate, '%m') = '05' then 1 end may,
					case when date_format(c.postingdate, '%m') = '06' then 1 end jun,
					case when date_format(c.postingdate, '%m') = '07' then 1 end jul,
					case when date_format(c.postingdate, '%m') = '08' then 1 end aug,
					case when date_format(c.postingdate, '%m') = '09' then 1 end sep,
					case when date_format(c.postingdate, '%m') = '10' then 1 end oct,
					case when date_format(c.postingdate, '%m') = '11' then 1 end nov,
					case when date_format(c.postingdate, '%m') = '12' then 1 end decm
				from ps_project a
				join ps_customer b on a.customerid = b.customerid
				left join ps_finalizationproject c on a.projectid = c.projectid
				where date_format(c.postingdate, '%Y') = :1
				order by b.company, a.name, c.postingdate, c.link");
			
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
				$str = $str . "<td style='vertical-align:middle'>".$row["company"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["name"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["postingdate"]."</td>";
				$str = $str . "<td style='vertical-align:middle'>".$row["link"]."</td>";
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

			$content = $content . '<tr><th rowspan="3" style="text-align:center; vertical-align:middle">No</th><th rowspan="3" style="text-align:center; vertical-align:middle">Client</th><th rowspan="3" style="text-align:center; vertical-align:middle">Project</th><th rowspan="3" style="text-align:center; vertical-align:middle">Posting Date</th><th rowspan="3" style="text-align:center; vertical-align:middle">Link</th><th colspan="12" style="text-align:center; vertical-align:middle">Recurring Month (cumulative)</th></tr><tr><th style="text-align:center">'. ($jan) .'</th><th style="text-align:center">'. ($jan+$feb) .'</th><th style="text-align:center">'. ($jan+$feb+$mar) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov) .'</th><th style="text-align:center">'. ($jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$decm) .'</th></tr><tr><th style="text-align:center">Jan</th><th style="text-align:center">Feb</th><th style="text-align:center">Mar</th><th style="text-align:center">Apr</th><th style="text-align:center">May</th><th style="text-align:center">Jun</th><th style="text-align:center">Jul</th><th style="text-align:center">Aug</th><th style="text-align:center">Sep</th><th style="text-align:center">Oct</th><th style="text-align:center">Nov</th><th style="text-align:center">Dec</th></tr>';

			$content = $content . $str;
			$content = $content . "</table>";

			$filename ="articles.xls";
			
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

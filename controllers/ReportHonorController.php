<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\IntAgreementPayment;
use yii\db\Query;

class ReportHonorController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$date = null;

    	if (isset($_POST["date"])){
    		$date = $_POST["date"];
    	}

    	if ($date != null){
    		$strDate = explode(' - ',$date);

            if (isset($strDate[0])){
                $startDate = date("Y-m-d", strtotime($strDate[0]));   
            }
            if (isset($strDate[1])){
                $endDate = date("Y-m-d", strtotime($strDate[1]));   
            }

    		$connection = \Yii::$app->db;

			$model = $connection->createCommand("select 
						g.priod as PRIOD,
						g.kdsem as KDSEM, 
						case when DATE_FORMAT(f.date, '%d') <= 5 then
							DATE_FORMAT(DATE_SUB(f.date, INTERVAL 1 MONTH), '%m') 
						else
							DATE_FORMAT(f.date, '%m') 
						end
						as BULAN,
						case when DATE_FORMAT(f.date, '%d') <= 5  and DATE_FORMAT(f.date, '%m') = 1 then
							DATE_FORMAT(DATE_SUB(f.date, INTERVAL 1 YEAR), '%Y')
						else
							DATE_FORMAT(f.date, '%Y') 
						end
						as TAHUN,
						d.lectureid as KODE,
						TRUNCATE(e.rate, 5) as BRUTTO,
						'0.00000' as SIHARTA,
						'0.00000'as JMTRANS
					from ps_project a
					join ps_extagreement b on a.projectid = b.projectid
					join ps_intagreement c on b.extagreementid = c.extagreementid
					join ps_consultant d on c.consultantid = d.consultantid
					join ps_intdeliverables e on c.intagreementid = e.intagreementid
					join ps_intagreementpayment f on e.intdeliverableid = f.intdeliverableid
					left join ps_term_tbl g on f.date between g.startdate and g.enddate
					where f.date between STR_TO_DATE(:1, '%Y-%m-%d') and STR_TO_DATE(:2, '%Y-%m-%d')
					");
					//where date_format(f.date, '%b-%Y') = :1");
			
			$model->bindValue(':1', $startDate);
			$model->bindValue(':2', $endDate);

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

    public function actionExportDbf($date)
    {
    	$date = null;

    	if (isset($_GET["date"])){
    		$date = $_GET["date"];
    	}

    	if ($date != null){

    		$strDate = explode(' - ',$date);

            if (isset($strDate[0])){
                $startDate = date("Y-m-d", strtotime($strDate[0]));   
            }
            if (isset($strDate[1])){
                $endDate = date("Y-m-d", strtotime($strDate[1]));   
            }

    		$connection = \Yii::$app->db;

			$model = $connection->createCommand("select 
					g.priod as PRIOD,
					g.kdsem as KDSEM, 
					case when DATE_FORMAT(f.date, '%d') <= 5 then
						DATE_FORMAT(DATE_SUB(f.date, INTERVAL 1 MONTH), '%m') 
					else
						DATE_FORMAT(f.date, '%m') 
					end
					as BULAN,
					case when DATE_FORMAT(f.date, '%d') <= 5  and DATE_FORMAT(f.date, '%m') = 1 then
						DATE_FORMAT(DATE_SUB(f.date, INTERVAL 1 YEAR), '%Y')
					else
						DATE_FORMAT(f.date, '%Y') 
					end
					as TAHUN,
					d.lectureid as KODE,
					TRUNCATE(e.rate, 5) as BRUTTO,
					'0.00000' as SIHARTA,
					'0.00000'as JMTRANS
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_intagreement c on b.extagreementid = c.extagreementid
				join ps_consultant d on c.consultantid = d.consultantid
				join ps_intdeliverables e on c.intagreementid = e.intagreementid
				join ps_intagreementpayment f on e.intdeliverableid = f.intdeliverableid
				left join ps_term_tbl g on f.date between g.startdate and g.enddate
				where f.date between STR_TO_DATE(:1, '%Y-%m-%d') and STR_TO_DATE(:2, '%Y-%m-%d')
				");
				//where date_format(f.date, '%b-%Y') = :1");
			
			//$model->bindValue(':1', $date);
			$model->bindValue(':1', $startDate);
			$model->bindValue(':2', $endDate);

			$data = $model->queryAll();

			# Constants for dbf field types
			define ('BOOLEAN_FIELD',   'L');
			define ('CHARACTER_FIELD', 'C');
			define ('DATE_FIELD',      'D');
			define ('NUMBER_FIELD',    'N');

			# Constants for dbf file open modes
			define ('READ_ONLY',  '0');
			define ('WRITE_ONLY', '1');
			define ('READ_WRITE', '2');

			# Path to dbf file
			$db_file = 'honor_dosen.dbf';

			$db_structure = array
				(
				    array ('PRIOD', 	CHARACTER_FIELD, 4),
				    array ('KDSEM', 	CHARACTER_FIELD, 1),
				    array ('BULAN', 	CHARACTER_FIELD, 2),
				    array ('TAHUN', 	CHARACTER_FIELD, 4),
				    array ('KODE', 		CHARACTER_FIELD, 8),
				    array ('BRUTTO', 	CHARACTER_FIELD, 30),
				    array ('SIHARTA', 	CHARACTER_FIELD, 30),
				    array ('JMTRANS', 	CHARACTER_FIELD, 30)
				);

    		if (!dbase_create($db_file, $db_structure)) {
		 		echo "Error, can't create the database\n";
			}

			$id = dbase_open ($db_file, READ_WRITE);
			foreach ($data as $payment){
				dbase_add_record ($id, array(
					$payment["PRIOD"],
					$payment["KDSEM"],
					$payment["BULAN"],
					$payment["TAHUN"],
					$payment["KODE"],
					$payment["BRUTTO"],
					$payment["SIHARTA"],
					$payment["JMTRANS"]
				));
			}

			dbase_close($id);

			ob_get_clean();
		    header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    header("Cache-Control: private", false);
		    header("Content-Disposition: attachment; filename=" . basename($db_file) . ";" );
		    header("Content-Transfer-Encoding: binary");
		    header("Content-Length: " . filesize($db_file));
		    readfile($db_file);

			return $this->redirect(['index']);
		}
    }

    public function actionExportExcel($date)
    {
    	$date = null;

    	if (isset($_GET["date"])){
    		$date = $_GET["date"];
    	}

    	if ($date != null){
			$strDate = explode(' - ',$date);

            if (isset($strDate[0])){
                $startDate = date("Y-m-d", strtotime($strDate[0]));   
            }
            if (isset($strDate[1])){
                $endDate = date("Y-m-d", strtotime($strDate[1]));   
            }

    		$connection = \Yii::$app->db;

			$model = $connection->createCommand("select 
					g.priod as PRIOD,
					g.kdsem as KDSEM, 
					case when DATE_FORMAT(f.date, '%d') <= 5 then
						DATE_FORMAT(DATE_SUB(f.date, INTERVAL 1 MONTH), '%m') 
					else
						DATE_FORMAT(f.date, '%m') 
					end
					as BULAN,
					case when DATE_FORMAT(f.date, '%d') <= 5  and DATE_FORMAT(f.date, '%m') = 1 then
						DATE_FORMAT(DATE_SUB(f.date, INTERVAL 1 YEAR), '%Y')
					else
						DATE_FORMAT(f.date, '%Y') 
					end
					as TAHUN,
					d.lectureid as KODE,
					TRUNCATE(e.rate, 5) as BRUTTO,
					'0.00000' as SIHARTA,
					'0.00000'as JMTRANS
				from ps_project a
				join ps_extagreement b on a.projectid = b.projectid
				join ps_intagreement c on b.extagreementid = c.extagreementid
				join ps_consultant d on c.consultantid = d.consultantid
				join ps_intdeliverables e on c.intagreementid = e.intagreementid
				join ps_intagreementpayment f on e.intdeliverableid = f.intdeliverableid
				left join ps_term_tbl g on f.date between g.startdate and g.enddate
				where f.date between STR_TO_DATE(:1, '%Y-%m-%d') and STR_TO_DATE(:2, '%Y-%m-%d')
				");
				//where date_format(f.date, '%b-%Y') = :1");
			
			//$model->bindValue(':1', $date);
			$model->bindValue(':1', $startDate);
			$model->bindValue(':2', $endDate);
			
			$data = $model->queryAll();
			$content = "<table border='1'>";
			$content = $content . "<tr><th>PRIOD</th><th>KDSEM</th><th>BULAN</th><th>TAHUN</th>";
			$content = $content . "<th>KODE</th><th>BRUTTO</th><th>SIHARTA</th><th>JMTRANS</th></tr>";

			foreach ($data as $payment){
				$content = $content . "<tr>";
				$content = $content . "<td>".$payment["PRIOD"]."</td>";
				$content = $content . "<td>".$payment["KDSEM"]."</td>";
				$content = $content . "<td>".$payment["BULAN"]."</td>";
				$content = $content . "<td>".$payment["TAHUN"]."</td>";
				$content = $content . "<td>".$payment["KODE"]."</td>";
				$content = $content . "<td>".$payment["BRUTTO"]."</td>";
				$content = $content . "<td>".$payment["SIHARTA"]."</td>";
				$content = $content . "<td>".$payment["JMTRANS"]."</td>";
				$content = $content . "</tr>";
			}

			$content = $content . "</table>";

			$filename ="honor_dosen.xls";
			
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

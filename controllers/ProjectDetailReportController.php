<?php

namespace app\controllers;

class ProjectDetailReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$date = null;

    	if (isset($_POST["date"])){
    		$date = $_POST["date"];
    	}

        if ($date != null){
    		$connection = \Yii::$app->db;

    		$year = date('Y', strtotime($date));

			$model = $connection->createCommand("select distinct a.code as projectcode, b.name as status, c.company, a.name as projectname, 
				d.name as bddpic, min(f.signdate) as signed, a.cancelremark, i.name as faculty, h.name as department, j.name as pic,
				a.description as overview, k.name as partnertype,
				l.name as producttype,
				o.rate as targetprev, p.rate as targetyear, q.rate as cashinprev, r.rate as cashin,
				s.rate as totalinstall, 
				concat(truncate((coalesce(s.rate, 0)/(coalesce(p.rate, 0.00) + coalesce(o.rate, 0.00)) * 100), 2), ' %') as percentinstall,
				case when left(l.code, 1) = 'P' then 'Professional Service' else 'Non Professional Service' end as tuitiontype,
				t.cost,
				s.rate - t.cost as profitactual,
				jan.rate as jan,
				feb.rate as feb,
				mar.rate as mar,
				apr.rate as apr,
				may.rate as may,
				jun.rate as jun,
				jul.rate as jul,
				aug.rate as aug,
				sep.rate as sep,
				oct.rate as oct,
				nov.rate as nov,
				decm.rate as decm
				from ps_project a
				left join ps_status b on a.statusid = b.statusid
				left join ps_customer c on a.customerid = c.customerid
				left join (
					select d.projectid, group_concat(e.name separator ', ') as name
					from ps_projectpic d
					left join ps_user e on d.userid = e.userid
					group by d.projectid
				) d on a.projectid = d.projectid
				left join ps_extagreement f on a.projectid = f.projectid
				left join ps_intagreement g on f.extagreementid = g.extagreementid
				left join ps_department h on g.departmentid = h.departmentid
				left join ps_faculty i on h.facultyid = i.facultyid
				left join ps_contactperson j on a.customerid = j.customerid
				left join ps_partnertype k on c.partnertypeid = k.partnertypeid
				left join ps_producttype l on a.producttypeid = l.producttypeid
				left join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
				left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is null and date_format(m.duedate , '%Y') = :2
					group by a.projectid
				) o on a.projectid = o.projectid
				left join (
					select a.projectid, sum(m.rate)  rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is null and date_format(m.duedate , '%Y') = :1
					group by a.projectid
				) p on a.projectid = p.projectid
				left join (
					select a.projectid, sum(m.rate)  rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(m.duedate , '%Y') = :2
					group by a.projectid
				) q on a.projectid = q.projectid
				left join (
					select a.projectid, sum(m.rate)  rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(m.duedate , '%Y') = :1
					group by a.projectid
				) r on a.projectid = r.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1
					group by a.projectid
				) s on a.projectid = s.projectid
				left join (
					select projectid, sum(cost) as cost 
					from (
						select sharingvaluedepartmentid, projectid, cost
						from ps_sharingvaluedepartment
						union all
						select sharingvalueunitid, projectid, cost
						from ps_sharingvalueunit
					) a
					group by projectid
				) t on a.projectid = t.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '01'
					group by a.projectid
				) jan on a.projectid = jan.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '02'
					group by a.projectid
				) feb on a.projectid = feb.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '03'
					group by a.projectid
				) mar on a.projectid = mar.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '04'
					group by a.projectid
				) apr on a.projectid = apr.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '05'
					group by a.projectid
				) may on a.projectid = may.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '06'
					group by a.projectid
				) jun on a.projectid = jun.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '07'
					group by a.projectid
				) jul on a.projectid = jul.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '08'
					group by a.projectid
				) aug on a.projectid = aug.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '09'
					group by a.projectid
				) sep on a.projectid = sep.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '10'
					group by a.projectid
				) oct on a.projectid = oct.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '11'
					group by a.projectid
				) nov on a.projectid = nov.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '12'
					group by a.projectid
				) decm on a.projectid = decm.projectid
				group by a.code, b.name, c.company, a.name, d.name, i.name, h.name, j.name, a.description, 
					k.name, l.name
				;");
			
			//$model->bindValue(':1', $date);

			$model->bindValue(':1', $year);
			$model->bindValue(':2', ($year - 1));
			//$model->bindValue(':1', $startDate);
			//$model->bindValue(':2', $endDate);
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

    		$year = date('Y', strtotime($date));

			$model = $connection->createCommand("select distinct a.code as projectcode, b.name as status, c.company, a.name as projectname, 
				d.name as bddpic, min(f.signdate) as signed, a.cancelremark, i.name as faculty, h.name as department, j.name as pic,
				a.description as overview, k.name as partnertype,
				l.name as producttype,
				o.rate as targetprev, p.rate as targetyear, q.rate as cashinprev, r.rate as cashin,
				s.rate as totalinstall, 
				concat(truncate((coalesce(s.rate, 0)/(coalesce(p.rate, 0.00) + coalesce(o.rate, 0.00)) * 100), 2), ' %') as percentinstall,
				case when left(l.code, 1) = 'P' then 'Professional Service' else 'Non Professional Service' end as tuitiontype,
				t.cost,
				s.rate - t.cost as profitactual,
				jan.rate as jan,
				feb.rate as feb,
				mar.rate as mar,
				apr.rate as apr,
				may.rate as may,
				jun.rate as jun,
				jul.rate as jul,
				aug.rate as aug,
				sep.rate as sep,
				oct.rate as oct,
				nov.rate as nov,
				decm.rate as decm
				from ps_project a
				left join ps_status b on a.statusid = b.statusid
				left join ps_customer c on a.customerid = c.customerid
				left join (
					select d.projectid, group_concat(e.name separator ', ') as name
					from ps_projectpic d
					left join ps_user e on d.userid = e.userid
					group by d.projectid
				) d on a.projectid = d.projectid
				left join ps_extagreement f on a.projectid = f.projectid
				left join ps_intagreement g on f.extagreementid = g.extagreementid
				left join ps_department h on g.departmentid = h.departmentid
				left join ps_faculty i on h.facultyid = i.facultyid
				left join ps_contactperson j on a.customerid = j.customerid
				left join ps_partnertype k on c.partnertypeid = k.partnertypeid
				left join ps_producttype l on a.producttypeid = l.producttypeid
				left join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
				left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is null and date_format(m.duedate , '%Y') = :2
					group by a.projectid
				) o on a.projectid = o.projectid
				left join (
					select a.projectid, sum(m.rate)  rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is null and date_format(m.duedate , '%Y') = :1
					group by a.projectid
				) p on a.projectid = p.projectid
				left join (
					select a.projectid, sum(m.rate)  rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(m.duedate , '%Y') = :2
					group by a.projectid
				) q on a.projectid = q.projectid
				left join (
					select a.projectid, sum(m.rate)  rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(m.duedate , '%Y') = :1
					group by a.projectid
				) r on a.projectid = r.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1
					group by a.projectid
				) s on a.projectid = s.projectid
				left join (
					select projectid, sum(cost) as cost 
					from (
						select sharingvaluedepartmentid, projectid, cost
						from ps_sharingvaluedepartment
						union all
						select sharingvalueunitid, projectid, cost
						from ps_sharingvalueunit
					) a
					group by projectid
				) t on a.projectid = t.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '01'
					group by a.projectid
				) jan on a.projectid = jan.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '02'
					group by a.projectid
				) feb on a.projectid = feb.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '03'
					group by a.projectid
				) mar on a.projectid = mar.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '04'
					group by a.projectid
				) apr on a.projectid = apr.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '05'
					group by a.projectid
				) may on a.projectid = may.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '06'
					group by a.projectid
				) jun on a.projectid = jun.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '07'
					group by a.projectid
				) jul on a.projectid = jul.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '08'
					group by a.projectid
				) aug on a.projectid = aug.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '09'
					group by a.projectid
				) sep on a.projectid = sep.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '10'
					group by a.projectid
				) oct on a.projectid = oct.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '11'
					group by a.projectid
				) nov on a.projectid = nov.projectid
				left join (
					select a.projectid, sum(m.rate) rate
					from ps_project a
					join ps_extagreement f on a.projectid = f.projectid
					join ps_extdeliverables m on f.extagreementid = m.extagreementid and m.duedate
					left join ps_extagreementpayment n on m.extdeliverableid = n.extdeliverableid
					where n.extdeliverableid is not null and date_format(n.date, '%Y') = :1 and
						date_format(n.date, '%m') = '12'
					group by a.projectid
				) decm on a.projectid = decm.projectid
				group by a.code, b.name, c.company, a.name, d.name, i.name, h.name, j.name, a.description, 
					k.name, l.name
				");
			
			$model->bindValue(':1', $year);
			$model->bindValue(':2', ($year - 1));
			//$model->bindValue(':1', $startDate);
			//$model->bindValue(':2', $endDate);

			$data = $model->queryAll();

			$content = "<table border='1'>";
			$content = $content . "<tr><th>Project Code</th><th>Status</th><th>Patner Name</th><th>Project Name</th><th>BDD PIC</th><th>Agreement Signed/ Other Value Calculation Starting Point (month)</th><th>Remarks/ Cancellation Remarks</th><th>Faculty/ School</th><th>Department</th><th>PIC</th><th>Project Overview</th><th>Patner Type</th><th>Product Type</th><th>Target Cash In from Outstanding Project ".($year-1)."</th><th>Target Project Value ".$year."</th><th>Cash In (Project ".($year-1).")</th><th>Cash In (Project ".$year.")</th><th>Current Total Installment per Project</th><th>% installment</th><th>Non Tuition Type</th><th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Expenses Actualized</th><th>Profit Actualized in ".$year."</th></tr>";

			foreach($data as $row){
				$content = $content . "<tr>";
				$content = $content . "<td>".$row["projectcode"]."</td>";
				$content = $content . "<td>".$row["status"]."</td>";
				$content = $content . "<td>".$row["company"]."</td>";
				$content = $content . "<td>".$row["projectname"]."</td>";
				$content = $content . "<td>".$row["bddpic"]."</td>";
				$content = $content . "<td>".$row["signed"]."</td>";
				$content = $content . "<td>".$row["cancelremark"]."</td>";
				$content = $content . "<td>".$row["faculty"]."</td>";
				$content = $content . "<td>".$row["department"]."</td>";
				$content = $content . "<td>".$row["pic"]."</td>";
				$content = $content . "<td>".$row["overview"]."</td>";
				$content = $content . "<td>".$row["partnertype"]."</td>";
				$content = $content . "<td>".$row["producttype"]."</td>";
				$content = $content . "<td>".$row["targetprev"]."</td>";
				$content = $content . "<td>".$row["targetyear"]."</td>";
				$content = $content . "<td>".$row["cashinprev"]."</td>";
				$content = $content . "<td>".$row["cashin"]."</td>";
				$content = $content . "<td>".$row["totalinstall"]."</td>";
				$content = $content . "<td>".$row["percentinstall"]."</td>";
				$content = $content . "<td>".$row["tuitiontype"]."</td>";
				$content = $content . "<td>".$row["jan"]."</td>";
				$content = $content . "<td>".$row["feb"]."</td>";
				$content = $content . "<td>".$row["mar"]."</td>";
				$content = $content . "<td>".$row["apr"]."</td>";
				$content = $content . "<td>".$row["may"]."</td>";
				$content = $content . "<td>".$row["jun"]."</td>";
				$content = $content . "<td>".$row["jul"]."</td>";
				$content = $content . "<td>".$row["aug"]."</td>";
				$content = $content . "<td>".$row["sep"]."</td>";
				$content = $content . "<td>".$row["oct"]."</td>";
				$content = $content . "<td>".$row["nov"]."</td>";
				$content = $content . "<td>".$row["decm"]."</td>";
				$content = $content . "<td>".$row["cost"]."</td>";
				$content = $content . "<td>".$row["profitactual"]."</td>";
				$content = $content . "</tr>";
			}

			$content = $content . "</table>";

			$filename ="project-detail.xls";
			
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

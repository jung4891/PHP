<?php
header("Content-type: text/html; charset=utf-8");

class STC_Funds extends CI_Model {
  function __construct() {
    parent::__construct();
    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->cnum = $this->phpsession->get( 'cnum', 'stc' );
  }

  function funds_list_cnt($search1,$search2) {
    $sql = "select count(seq) as cnt from funds_report where year=".$search1." and company_code ='".$search2."'";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function funds_list($search1,$search2){

    if($search2 =="IT"){
      $search2 = "D_1','D_2";
    }

    $sql = "select company_code, year,sum(purpose_1) as purpose_1 ,sum(purpose_2) as purpose_2,sum(purpose_3) as purpose_3,sum(purpose_4) as purpose_4,sum(purpose_5) as purpose_5,sum(purpose_6) as purpose_6,sum(purpose_7) as purpose_7,sum(purpose_8) as purpose_8,sum(purpose_9) as purpose_9,sum(purpose_10) as purpose_10,sum(purpose_11) as purpose_11,sum(purpose_12) as purpose_12 from funds_report where year=".$search1." and company_code in ('".$search2."')";

    $query = $this->db->query($sql);

    if($query->num_rows()==0){
      $result[0] = array(
        'purpose_1' => '0',
        'purpose_2' => '0',
        'purpose_3' => '0',
        'purpose_4' => '0',
        'purpose_5' => '0',
        'purpose_6' => '0',
        'purpose_7' => '0',
        'purpose_8' => '0',
        'purpose_9' => '0',
        'purpose_10' => '0',
        'purpose_11' => '0',
        'purpose_12' => '0'
      );
    } else {
      $result = $query->result_array();
    }

    return $result;
  }

  function fund_forcasting(){

  }

	function funds_forcasting_sum($year,$month,$dept_code){
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

		$tmp = $year."-".$month."-01";

		$default = "and(TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') % division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') between 0 and 11";
		$default2 = "and(TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') between 0 and (replace(division_month,'m','')-1)";
		$sql = "select sum(if(division_month not like 'm%',forcasting_sales/(12/division_month),forcasting_sales/(replace(division_month,'m','')))) as sum from sales_forcasting where (division_month not like 'm%' ".$default." or division_month like 'm%' ".$default2.") and DEPT in ('$dept_code') and progress_step != '000' limit 1;";

		$query = $this->db->query($sql);

		return $query->result_array();

	}

  function forcasting_adjust($year, $month, $dept_code, $mode) {
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

    if ($month < 10) {
      $month = "0".$month;
    }

		$tmp = $year."-".$month."-01";

    $sql = "SELECT IFNULL(SUM(issuance_amount),0) AS sum
            FROM sales_forcasting_bill sfb
            JOIN sales_forcasting sf ON sfb.forcasting_seq = sf.seq
            WHERE sfb.`type` = '001'
            AND sfb.issuance_status = 'Y'
            AND DEPT in ('{$dept_code}')";

    if($mode == 'minus') {
      $sql .= " AND DATE_FORMAT(exception_saledate, '%Y-%m-01') = '{$tmp}'";
    } else {
      $sql .= " AND DATE_FORMAT(issuance_date, '%Y-%m-01') = '{$tmp}'";
    }

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function forcasting_sum($year,$month,$dept_code,$type){
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

    if ($month < 10) {
      $month = "0".$month;
    }

    if($type=="sale"){
      $type = 1;
    } else if ($type=="service"){
      $type = 2;
    } else if ($type=="support"){
      $type = 4;
    }

    $sql = "SELECT ifnull(sum(a.issuance_amount),0) as sum FROM sales_forcasting_bill a JOIN sales_forcasting b ON a.forcasting_seq = b.seq WHERE a.issuance_status != 'N' AND a.TYPE = '001' AND a.issuance_month = '{$year}-{$month}' AND b.type = {$type} AND b.dept IN ('{$dept_code}')";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function maintain_forcasting_sum($year, $month, $dept_code) {
    if($dept_code == "IT") {
      $dept_code = "사업1부','사업2부','기술지원부";
    } else if ($dept_code == "D_1") {
      $dept_code = "사업1부";
    } else if ($dept_code == "D_2") {
      $dept_code = "사업2부','기술지원부";
    }

    if ($month < 10) {
      $month = "0".$month;
    }

    $sql = "SELECT IFNULL(SUM(smb.issuance_amount),0) AS sum
            FROM sales_maintain sm
            JOIN sales_maintain_bill smb ON sm.seq = smb.maintain_seq
            WHERE 1=1
            AND smb.type = '001' AND smb.issuance_status = 'N' AND smb.issue_schedule_date LIKE ('{$year}-{$month}-%')";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function achieve_maintain_sum($year,$month,$dept_code){
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

		if ($month < 10) {
      $month = "0".$month;
    }


    $sql = "SELECT sum(sum) as sum from (SELECT ifnull(sum(a.issuance_amount),0) as sum FROM sales_maintain_bill a JOIN sales_maintain b ON a.maintain_seq = b.seq WHERE a.issuance_status = 'Y' AND a.TYPE = '001' AND a.issuance_month = '{$year}-{$month}' AND b.dept IN ('{$dept_code}') union SELECT ifnull(sum(a.issuance_amount),0) as sum FROM sales_forcasting_bill a JOIN sales_forcasting b ON a.forcasting_seq = b.seq WHERE a.issuance_status = 'Y' AND a.TYPE = '001' AND a.issuance_month = '{$year}-{$month}' AND b.type = 3 AND b.dept IN ('{$dept_code}')) a";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function purchase_sum($year,$month,$dept_code,$type){
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

    if ($month < 10) {
      $month = "0".$month;
    }

    if($type=="forcasting"){
      $sql = "SELECT ifnull(sum(a.issuance_amount),0) as sum FROM sales_forcasting_bill a JOIN sales_forcasting b ON a.forcasting_seq = b.seq WHERE a.issuance_status = 'Y' AND a.TYPE = '002' AND a.issuance_month = '{$year}-{$month}' AND b.dept IN ('{$dept_code}')";
    } else if ($type=="maintain"){
      $sql = "SELECT ifnull(sum(a.issuance_amount),0) as sum FROM sales_maintain_bill a JOIN sales_maintain b ON a.maintain_seq = b.seq WHERE a.issuance_status = 'Y' AND a.TYPE = '002' AND a.issuance_month = '{$year}-{$month}' AND b.dept IN ('{$dept_code}')";
    } else if ($type=="request") {
      $sql = "SELECT ifnull(sum(issuance_amount),0) as sum FROM request_tech_support_bill WHERE issuance_status = 'Y' AND issuance_month = '{$year}-{$month}'";
    }

    $query = $this->db->query($sql);
// echo $sql.'<br><br>';
    return $query->result_array();
  }

  function funds_input($data,$mode){
  	$sql="";

  	if($mode==0){
  		$sql = "insert into funds_report (company_code,year,purpose_1,purpose_2,purpose_3,purpose_4,purpose_5,purpose_6,purpose_7,purpose_8,purpose_9,purpose_10,purpose_11,purpose_12)  values ('$data[0]',$data[1],'$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]' )";
  	} else if ($mode==1) {
  		$sql = "update funds_report set purpose_1='$data[2]', purpose_2='$data[3]', purpose_3='$data[4]', purpose_4='$data[5]', purpose_5='$data[6]', purpose_6='$data[7]', purpose_7='$data[8]', purpose_8='$data[9]', purpose_9='$data[10]', purpose_10='$data[11]', purpose_11='$data[12]', purpose_12='$data[13]' where company_code='$data[0]' and year=$data[1]";
  	}else{
  		return -1;
  	}

    $query = $this->db->query($sql);

    return $query;
  }

  function funds_list_detail_seq ($year,$month,$dept_code){
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

    if($month<10){
      $month = "0".$month;
    }
    $target_date = $year."-".$month;
    $date_string = " = '{$target_date}'";


    $sql = "SELECT DISTINCT(t.seq) FROM ((SELECT fbf.*, p.product_company, p.product_name FROM ( SELECT CONCAT('f_',f.seq) AS seq, f.type, fb.issuance_date FROM sales_forcasting_bill fb JOIN sales_forcasting f ON fb.forcasting_seq = f.seq WHERE fb.issuance_status != 'N' AND fb.issuance_month {$date_string} and DEPT in ('$dept_code')) fbf JOIN ( SELECT * FROM sales_forcasting_product GROUP BY forcasting_seq) sfp ON  REPLACE(fbf.seq,'f_','') = sfp.forcasting_seq JOIN product p ON sfp.product_code = p.seq) UNION ( SELECT mbm.*, p.product_company, p.product_name FROM ( SELECT CONCAT('m_',m.seq) AS seq, 3 as type, mb.issuance_date FROM sales_maintain_bill mb JOIN sales_maintain m ON mb.maintain_seq = m.seq WHERE mb.issuance_status != 'N' AND mb.issuance_month {$date_string} and DEPT in ('$dept_code')) mbm JOIN ( SELECT * FROM sales_maintain_product GROUP BY maintain_seq) smp ON REPLACE(mbm.seq,'m_','') = smp.maintain_seq JOIN product p ON smp.product_code = p.seq) ORDER BY field(type, 1,2,4,3,0), issuance_date ) t";

    $query = $this->db->query($sql);
    // echo $sql;
		return $query->result_array();
  }

  function funds_list_detail_data ($year,$month,$dept_code) {
    if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부','기술지원부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부','기술지원부";
		}

    if($month<10){
      $month = "0".$month;
    }
    $target_date = $year."-".$month;
    $date_string = " = '{$target_date}'";

      $sql = "(SELECT mbm.*, p.product_company, p.product_name FROM ( SELECT CONCAT('m_',m.seq) AS seq, 3 as type, mb.`type` AS bill_type, m.customer_companyname, m.sales_companyname, m.project_name, mb.company_name, mb.issuance_date, m.progress_step, mb.pay_session, mb.issuance_amount, m.cooperation_companyname, m.dept, m.cooperation_username FROM sales_maintain_bill mb JOIN sales_maintain m ON mb.maintain_seq = m.seq WHERE mb.issuance_month {$date_string} and DEPT in ('$dept_code')) mbm JOIN (SELECT * FROM sales_maintain_product GROUP BY maintain_seq) smp ON replace(mbm.seq,'m_','') = smp.maintain_seq JOIN product p ON smp.product_code = p.seq)";
      $sql.= " UNION ALL ";
      $sql .= "(SELECT fbf.*, p.product_company, p.product_name FROM ( SELECT CONCAT('f_',f.seq) AS seq, f.type, fb.`type` AS bill_type, f.customer_companyname, f.sales_companyname, f.project_name, fb.company_name, fb.issuance_date, f.progress_step, concat(fb.percentage,'%') AS pay_session, fb.issuance_amount, f.cooperation_companyname, f.dept, f.cooperation_username FROM sales_forcasting_bill fb JOIN sales_forcasting f ON fb.forcasting_seq = f.seq WHERE fb.issuance_month {$date_string} AND DEPT in ('$dept_code')) fbf JOIN ( SELECT * FROM sales_forcasting_product GROUP BY forcasting_seq) sfp ON REPLACE(fbf.seq,'f_','') = sfp.forcasting_seq JOIN product p ON sfp.product_code = p.seq) ORDER BY bill_type, issuance_date";
      $query = $this->db->query($sql);
      // echo $sql.'<br><br>';
  		return $query->result_array();
  }

  function maintain_type($seq) {
    $sql = "SELECT COUNT(*) AS cnt FROM sales_maintain_product WHERE maintain_seq = {$seq} AND (integration_maintain_seq IS NOT NULL OR integration_maintain_product_seq IS NOT NULL)";

    $query = $this->db->query( $sql );
    return $query->row();
  }

  function request_tech_support_bill($year, $month) {
    if($month<10){
      $month = "0".$month;
    }
    $target_date = $year."-".$month;
    $date_string = " = '{$target_date}'";

    $sql = "SELECT CONCAT('r_', rts.seq) AS seq, '2' AS type, '002' AS bill_type, rts.customer_company AS customer_companyname, '' AS sales_companyname,
SUBSTRING_INDEX(approval_doc_name, ']', -1) AS project_name, '' AS company_name,
rtsb.issuance_date, '' AS progress_step, '' AS pay_session, rtsb.issuance_amount,
'두리안정보기술' AS cooperation_companyname, '사업2부' AS dept, ead.writer_name AS cooperation_username,
'' AS product_company, '설치지원' AS product_name
FROM request_tech_support_bill rtsb JOIN electronic_approval_doc ead ON rtsb.annual_doc_seq = ead.seq
JOIN request_tech_support rts ON SUBSTRING_INDEX(ead.req_support_seq, '_', 1) = rts.seq
WHERE rtsb.issuance_status = 'Y' AND rtsb.issuance_month {$date_string}";

    $query = $this->db->query($sql);
    // echo $sql.'<br><br>';
    return $query->result_array();
  }


//   	function funds_list_detail_view($year,$month,$dept_code){
//   		if($dept_code=="IT"){
//   			$dept_code = "사업1부','사업2부";
//   		}else if($dept_code=="D_1"){
//   			$dept_code = "사업1부";
//   		}else if($dept_code=="D_2"){
//   			$dept_code = "사업2부";
//   		}
//
// //       (SELECT f.seq AS f_seq, NULL AS m_seq, f.type, fb.`type` AS bill_type, f.customer_companyname, f.project_name, fb.company_name, fb.issuance_date,
// // f.progress_step, fb.percentage AS pay_session, fb.issuance_amount, f.cooperation_companyname, f.dept, f.cooperation_username
// // FROM sales_forcasting_bill fb
// // JOIN sales_forcasting f ON fb.forcasting_seq = f.seq
// // WHERE fb.issuance_month = "2021-02" AND fb.issuance_status = "Y")
// // UNION
// // (SELECT NULL AS f_seq, m.seq AS m_seq, m.type, mb.`type` AS bill_type, m.customer_companyname, m.project_name, mb.company_name, mb.issuance_date,
// // m.progress_step, mb.pay_session, mb.issuance_amount, m.cooperation_companyname, m.dept, m.cooperation_username
// // FROM sales_maintain_bill mb
// // JOIN sales_maintain m ON mb.maintain_seq = m.seq
// // WHERE mb.issuance_month = "2021-02" AND mb.issuance_status = "Y")
// // ORDER BY issuance_date 제품 붙이기전
//
//   		// $tmp = $year."-".$month."-01";
//   		// $searchstring = " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$tmp}') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$tmp}') between 0 and 11";
//   		// $searchstring2= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$tmp}') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$tmp}') between 0 and (replace(sf.division_month,'m','')-1)";
//   		// $sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and DEPT in ('$dept_code') and progress_step > '014' order by replace(sf.exception_saledate,'-','') DESC";
//       if($month<10){
//         $month = "0".$month;
//       }
//
//       $target_date = $year."-".$month;
//
//       $sql = "(SELECT fbf.*, p.product_company, p.product_name FROM ( SELECT f.seq AS f_seq, NULL AS m_seq, f.type, fb.`type` AS bill_type, f.customer_companyname, f.project_name, fb.company_name, fb.issuance_date, f.progress_step, concat(fb.percentage,'%') AS pay_session, fb.issuance_amount, f.cooperation_companyname, f.dept, f.cooperation_username FROM sales_forcasting_bill fb JOIN sales_forcasting f ON fb.forcasting_seq = f.seq WHERE fb.issuance_status = 'Y' and fb.issuance_month = '{$target_date}' and DEPT in ('$dept_code')) fbf JOIN ( SELECT * FROM sales_forcasting_product GROUP BY forcasting_seq) sfp ON fbf.f_seq = sfp.forcasting_seq JOIN product p ON sfp.product_code = p.seq) UNION ( SELECT mbm.*, p.product_company, p.product_name FROM ( SELECT NULL AS f_seq, m.seq AS m_seq, m.type, mb.`type` AS bill_type, m.customer_companyname, m.project_name, mb.company_name, mb.issuance_date, m.progress_step, mb.pay_session, mb.issuance_amount, m.cooperation_companyname, m.dept, m.cooperation_username FROM sales_maintain_bill mb JOIN sales_maintain m ON mb.maintain_seq = m.seq WHERE mb.issuance_status = 'Y' and mb.issuance_month = '{$target_date}' and DEPT in ('$dept_code')) mbm JOIN ( SELECT * FROM sales_maintain_product GROUP BY maintain_seq) smp ON mbm.m_seq = smp.maintain_seq JOIN product p ON smp.product_code = p.seq) ORDER BY issuance_date, f_seq, m_seq";
//
//   		$query = $this->db->query($sql);
//       // echo $sql;
//   		return $query->result_array();
//   	}

}


// (
//
// SELECT fbf.*, p.product_company, p.product_name
// FROM
// (
//
// SELECT CONCAT('f_',f.seq) AS seq, f.type, fb.`type` AS bill_type, f.customer_companyname, f.project_name, fb.company_name, fb.issuance_date, fb.issuance_month,
// f.progress_step, fb.percentage AS pay_session, fb.issuance_amount, f.cooperation_companyname, f.dept, f.cooperation_username
// FROM sales_forcasting_bill fb
// JOIN sales_forcasting f ON fb.forcasting_seq = f.seq
// WHERE fb.issuance_month BETWEEN '2021-01' AND '2021-03' AND fb.issuance_status = "Y" AND fb.type='001') fbf
// JOIN (
// SELECT *
// FROM sales_forcasting_product
// GROUP BY forcasting_seq) sfp ON fbf.seq = CONCAT('f',sfp.forcasting_seq)
// JOIN product p ON sfp.product_code = p.seq
//
// )
//
// UNION
//
// (
//
// SELECT mbm.*, p.product_company, p.product_name
// FROM
// (
// SELECT CONCAT('m_',m.seq) AS seq, m.type, mb.`type` AS bill_type, m.customer_companyname, m.project_name, mb.company_name, mb.issuance_date, mb.issuance_month,
// m.progress_step, mb.pay_session, mb.issuance_amount, m.cooperation_companyname, m.dept, m.cooperation_username
// FROM sales_maintain_bill mb
// JOIN sales_maintain m ON mb.maintain_seq = m.seq
// WHERE mb.issuance_month BETWEEN '2021-01' AND '2021-03' AND mb.issuance_status = "Y" AND mb.type='001') mbm
// JOIN (
// SELECT *
// FROM sales_maintain_product
// GROUP BY maintain_seq) smp ON mbm.seq = CONCAT('m_',smp.maintain_seq)
// JOIN product p ON smp.product_code = p.seq
//
// )
//
// ORDER BY issuance_date, seq;

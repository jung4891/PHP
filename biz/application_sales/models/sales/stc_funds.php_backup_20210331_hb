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
	
	function funds_input($data,$mode){

		$sql="";

		if($mode==0){
		
			$sql = "insert into funds_report (company_code,year,purpose_1,purpose_2,purpose_3,purpose_4,purpose_5,purpose_6,purpose_7,purpose_8,purpose_9,purpose_10,purpose_11,purpose_12)  values ('$data[0]',$data[1],'$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]' )";


		}else if($mode==1){

			$sql = "update funds_report set purpose_1='$data[2]', purpose_2='$data[3]', purpose_3='$data[4]', purpose_4='$data[5]', purpose_5='$data[6]', purpose_6='$data[7]', purpose_7='$data[8]', purpose_8='$data[9]', purpose_9='$data[10]', purpose_10='$data[11]', purpose_11='$data[12]', purpose_12='$data[13]' where company_code='$data[0]' and year=$data[1]";


		}else{

			return -1;

		}

                $query = $this->db->query($sql);

                return $query;


	}
	

	function funds_list_cnt($search1,$search2){

		$sql = "select count(seq) as cnt from funds_report where year=".$search1." and company_code ='".$search2."'";
		
                $query = $this->db->query($sql);

		return $query->result_array();


	}

	function funds_list($search1,$search2){
		
		if($search2 =="IT"){

			$search2 = "D_1','D_2";

		}


		$sql = "select company_code, year,sum(purpose_1) as purpose_1 ,sum(purpose_2) as purpose_2,sum(purpose_3) as purpose_3,sum(purpose_4) as purpose_4,sum(purpose_5) as purpose_5,sum(purpose_6) as purpose_6,sum(purpose_7) as purpose_7,sum(purpose_8) as purpose_8,sum(purpose_9) as purpose_9,sum(purpose_10) as purpose_10,sum(purpose_11) as purpose_11,sum(purpose_12) as purpose_12 from funds_report where year=".$search1." and company_code in ('".$search2."')";

//		echo $sql;

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
		
		}else{
			$result = $query->result_array();
		}


		return $result;

	}

	function funds_monthly_sum($year,$month,$dept_code){
		if($dept_code=="IT"){
		
			$dept_code = "사업1부','사업2부";

		}else if($dept_code=="D_1"){
			
			$dept_code = "사업1부";

		}else if($dept_code=="D_2"){
			
			$dept_code = "사업2부";

		}

		$tmp = $year."-".$month."-01";

		$default = "and(TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') % division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') between 0 and 11";
		$default2 = "and(TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'$tmp') between 0 and (replace(division_month,'m','')-1)";
		$sql = "select sum(if(division_month not like 'm%',forcasting_sales/(12/division_month),forcasting_sales/(replace(division_month,'m','')))) as sum from sales_forcasting where (division_month not like 'm%' ".$default." or division_month like 'm%' ".$default2.") and DEPT in ('$dept_code') and progress_step > '014' limit 1;";
		
		$query = $this->db->query($sql);

		return $query->result_array();

	}

	function funds_list_detail_view($year,$month,$dept_code){
		if($dept_code=="IT"){
			$dept_code = "사업1부','사업2부";
		}else if($dept_code=="D_1"){
			$dept_code = "사업1부";
		}else if($dept_code=="D_2"){
			$dept_code = "사업2부";
		}

		$tmp = $year."-".$month."-01";
		$searchstring = " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$tmp}') % sf.division_month)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$tmp}') between 0 and 11";
		$searchstring2= " and (TIMESTAMPDIFF(MONTH,DATE_FORMAT(sf.exception_saledate, '%Y-%m-01'),'{$tmp}') % 1)=0 and TIMESTAMPDIFF(MONTH,DATE_FORMAT(exception_saledate, '%Y-%m-01'),'{$tmp}') between 0 and (replace(sf.division_month,'m','')-1)";
		$sql = "select sf.seq,sf.type, sf.customer_companyname,sf.sales_companyname,sf.cooperation_companyname,sf.dept, sf.project_name, sf.cooperation_username, sf.progress_step, sf.write_id, sf.exception_saledate, sf.company_num, p.product_company, p.product_item, p.product_name, sf.forcasting_sales,sf.forcasting_purchase,sf.forcasting_profit,sf.division_month from sales_forcasting sf, (select * from sales_forcasting_product group by forcasting_seq) sp, product p where sf.seq = sp.forcasting_seq and p.seq = sp.product_code and (sf.division_month not like 'm%' " . $searchstring . " or sf.division_month like 'm%' " . $searchstring2 . ") and DEPT in ('$dept_code') and progress_step > '014' order by replace(sf.exception_saledate,'-','') DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}

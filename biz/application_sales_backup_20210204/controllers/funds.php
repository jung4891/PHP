<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Funds extends CI_Controller {

        var $id = '';

        function __construct() {
                parent::__construct();
                $this->id = $this->phpsession->get( 'id', 'stc' );
                $this->name = $this->phpsession->get( 'name', 'stc' );
                $this->lv = $this->phpsession->get( 'lv', 'stc' );
        }
	
	function funds_input() {

		$data = Array(

		);

		if(isset($_POST['search1'])) {
			$data['search1'] = $_POST['search1'];
                }else{
			$data['search1'] = date("Y");
		}

	
		if(isset($_POST['search2'])) {
			$data['search2'] = $_POST['search2'];
                }else{
			$data['search2'] = "IT";
		}

		$this->load->Model('STC_Funds');

		for($i=1;$i<13;$i++){

		
		$data['achieve_'.$i] = $this->STC_Funds->funds_monthly_sum($data['search1'],$i,$data['search2']);
		}

		$data['item'] = $this->STC_Funds->funds_list($data['search1'],$data['search2']); 
		

		$this->load->view('funds_input',$data);


	}


        function funds_list() {


		$data = Array(

		);

		$sum_achieve=0;
		$sum_purpose=0;

		if(isset($_POST['search1'])) {
			$data['search1'] = $_POST['search1'];
                }else{
			$data['search1'] = date("Y");
		}

	
		if(isset($_POST['search2'])) {
			$data['search2'] = $_POST['search2'];
                }else{
			$data['search2'] = "IT";
		}

		$this->load->Model('STC_Funds');

		for($i=1;$i<13;$i++){
		
			$data['achieve_'.$i] = $this->STC_Funds->funds_monthly_sum($data['search1'],$i,$data['search2']);

			$sum_achieve+=$data['achieve_'.$i][0]['sum'];

		}

	
		$data['item'] = $this->STC_Funds->funds_list($data['search1'],$data['search2']); 

		$data['sum_achieve']=$sum_achieve;

		foreach($data['item'][0] as $mon => $val){

			if(substr($mon,0,7)=='purpose')
				$sum_purpose += $val;

		}

		$data['sum_purpose']=$sum_purpose;
		
		//print_r($data);

		$this->load->view('funds_list',$data);

        }
	
	function funds_input_action() {



		$data = array(		

		$dept_code = $_POST['search2'],
		$year = $_POST['search1'],
		$purpose_1 = $_POST['purpose_1'],
		$purpose_2 = $_POST['purpose_2'],
		$purpose_3 = $_POST['purpose_3'],
		$purpose_4 = $_POST['purpose_4'],
		$purpose_5 = $_POST['purpose_5'],
		$purpose_6 = $_POST['purpose_6'],
		$purpose_7 = $_POST['purpose_7'],
		$purpose_8 = $_POST['purpose_8'],
		$purpose_9 = $_POST['purpose_9'],
		$purpose_10 = $_POST['purpose_10'],
		$purpose_11 = $_POST['purpose_11'],
		$purpose_12 = $_POST['purpose_12']

		);
	
		$this->load->Model('STC_Funds');
		$cnt = $this->STC_Funds->funds_list_cnt($year,$dept_code);	

		$result="";

		if($cnt[0]['cnt']=='0'){
			$result = $this->STC_Funds->funds_input($data,0);
		}else{
			$result = $this->STC_Funds->funds_input($data,1);
		}

		if($result) {
				echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/funds/funds_list'</script>";
		} else {
				echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	function funds_list_detail_view() {
		$this->load->Model('STC_Funds');
		$year = $_GET['year'];
		$month = $_GET['month'];
		$company= $_GET['company'];
		$data['list_val'] = $this->STC_Funds->funds_list_detail_view($year,$month,$company);
		$this->load->view('funds_list_detail_view',$data);
		
	}
	
}
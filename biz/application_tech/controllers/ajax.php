<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/KISA_SEED_CBC.php";

header("Content-type: text/html; charset=utf-8");

class Ajax extends CI_Controller {
	var $id = '';
	
	function __construct() {
		 parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
	}

	function index() {
		redirect('');
	}
	
	// 아이디체크
	function idcheck() {
		$uid = $this->input->post( 'id' );
		
		if( $uid == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->idcheck($uid);
			
			if($result == false) {
				$arr = array('result' => 'false');
				echo json_encode($arr);	
			} else {
				$arr = array('result' => 'true');
				echo json_encode($arr);
			}
		}
	}


	// 비번체크
	function pwcheck() {
		$uname = $this->input->post( 'name' );
		
		if( $uname == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->pwcheck($uname);
			
			echo json_encode($result);
		}
	}

	// 서명동의
	function signConsentUpdate(){
		$seq = $this->input->post( 'seq' );
		
		if( $seq == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->signConsentUpdate($seq);
			echo json_encode($result);
		}

	}

	// 서명동의취소
	function signConsentCancle(){
		$seq = $this->input->post( 'seq' );
		
		if( $seq == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->signConsentCancle($seq);
			echo json_encode($result);
		}

	}
	// 고객사서명동의
	function customerSignConsentUpdate(){
		$seq = $this->input->post( 'seq' );
		
		if( $seq == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->customerSignConsentUpdate($seq);
			echo json_encode($result);
		}

	}

	// 서명동의취소
	function customerSignConsentCancle(){
		$seq = $this->input->post( 'seq' );
		
		if( $seq == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->customerSignConsentCancle($seq);
			echo json_encode($result);
		}
	}

	// 고객사 서명 src저장
	function customerSignSrc(){
		//imagesrc 암호화 복호화
		$g_bszUser_key = null;
		if(isset($_POST['KEY']))
			$g_bszUser_key = $_POST['KEY'];
		if($g_bszUser_key == null)
		{
			$g_bszUser_key = "88,E3,4F,8F,08,17,79,F1,E9,F3,94,37,0A,D4,05,89";
		}
			
		$g_bszIV = null;
		if(isset($_POST['IV']))
			$g_bszIV = $_POST['IV'];
		if($g_bszIV == null)
		{
			$g_bszIV = "26,8D,66,A7,35,A8,1A,81,6F,BA,D9,FA,36,16,25,01";
		}

		function encrypt($bszIV, $bszUser_key, $str) {
			$planBytes = explode(",",$str);
			$keyBytes = explode(",",$bszUser_key);
			$IVBytes = explode(",",$bszIV);
			
			for($i = 0; $i < 16; $i++)
			{
				$keyBytes[$i] = hexdec($keyBytes[$i]);
				$IVBytes[$i] = hexdec($IVBytes[$i]);
			}
			for ($i = 0; $i < count($planBytes); $i++) {
				$planBytes[$i] = hexdec($planBytes[$i]);
			}
		
			if (count($planBytes) == 0) {
				return $str;
			}
			$ret = null;
			$bszChiperText = null;
			$pdwRoundKey = array_pad(array(),32,0);
		
			//방법 1
			$bszChiperText = KISA_SEED_CBC::SEED_CBC_Encrypt($keyBytes, $IVBytes, $planBytes, 0, count($planBytes));
		
			$r = count($bszChiperText);
		
			for($i=0;$i< $r;$i++) {
				$ret .=  sprintf("%02X", $bszChiperText[$i]).",";
			}
			return substr($ret,0,strlen($ret)-1);
		}

		function strToHex($string){
			$hex='';
			for ($i=0; $i < strlen($string); $i++){
				$hex .= "," . dechex(ord($string[$i]));
			}
			return $hex;
		}

		$seq = $this->input->post( 'seq' );
		$src = $this->input->post( 'src' );
		$signer = $this->input->post( 'signer' );

		$srcData = str_split($src, 128);
		$imageSrc = '';
		for($i =0; $i <count($srcData); $i++){ 
			$result = $srcData[$i];
			$result = strToHex($result);
			$result = substr( $result , 1, strlen($result));
			$result = encrypt($g_bszIV, $g_bszUser_key, $result);
			$imageSrc .= $result.'@';
		  }
		$src = $imageSrc;
		
		if( $seq == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->customerSignSrc($seq,$src,$signer);
			echo json_encode($result);
		}
	}

	//점검항목 가져오기
	function checkListSelect(){
		$this->load->Model(array('STC_tech_doc', 'STC_Common'));
		$productName = $this->input->post( 'productName' );
		$result = $this->STC_tech_doc->check_list_template($productName);
		echo json_encode($result);
	}

	//템플릿 가져오깅
	function template(){
		$this->load->Model(array('STC_tech_doc', 'STC_Common'));
		$product = $this->input->post( 'product' );
		$result = $this->STC_tech_doc->template($product);
		echo json_encode($result);
	}

	// wakeup
	function wakeup() {
		$this->load->model('WF_Command');

		$hp_ip = $this->input->post( 'hp_ip' );
		$hp_no = $this->input->post( 'hp_no' );
		$mc_ip = $this->input->post( 'mip' );
		
		$return_flag = $this->WF_Command->csocket(8, $hp_ip, $hp_no, $mc_ip);
		
		$arr = array('socket_result' => $return_flag);
		echo json_encode($arr);
	}

	//협력사 정보 가져오기
	function cooperative_company(){
		$this->load->Model('STC_request_tech_support');

		$seq = $this->input->post( 'seq' );
		$cooperative_staff = $this->STC_request_tech_support->cooperative_company_staff($seq);
		echo json_encode($cooperative_staff);
	}

	//협력사 엔지니어 정보 가져오기
	function cooperative_company_engineer(){
		$this->load->Model('STC_request_tech_support');

		$seq = $this->input->post( 'seq' );
		$cooperative_engineer = $this->STC_request_tech_support->cooperative_company_engineer($seq);
		echo json_encode($cooperative_engineer);
	}

	//협력사 멤버인지 확인
	function cooperative_company_member(){
		$this->load->Model('STC_User');

		$email = $this->input->post( 'email' );
		$cooperative_member= $this->STC_User->cooperative_company_member($email);
		echo json_encode($cooperative_member);
	}

	//협력사에 메일 보냈는지 체크
	function mailSendCheck(){
		$this->load->Model('STC_request_tech_support');
		$seq = $this->input->post( 'seq' );
		$check = $this->input->post( 'check' );
		$check_value = $this->input->post( 'check_value' );
		$result= $this->STC_request_tech_support->mailSendCheck($seq,$check,$check_value);
		echo json_encode($result);
	}

	//기술지원요청 최종승인
	function finalApproval(){
		$this->load->Model('STC_request_tech_support');
		$seq = $this->input->post( 'seq' );
		$result= $this->STC_request_tech_support->finalApproval($seq);
		echo json_encode($result);
	}

	//세금계산서 승인번호 저장
	function taxNumber(){
		$this->load->Model('STC_request_tech_support');
		$seq = $this->input->post( 'seq' );
		$tax = $this->input->post( 'tax' );
		$result= $this->STC_request_tech_support->taxNumber($seq,$tax);
		echo json_encode($result);
	}
}
?>

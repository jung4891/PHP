<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	function __construct() {
			parent::__construct();
			if(!isset($_SESSION)){
					session_start();
			}
			$this->load->helper('url');
			// $this->load->helper('form');
			// $this->load->helper('url');
			// $this->load->Model('m_login');
			$this->load->Model('M_group');
			$this->load->library('email');


    }

		// '주소록 추가' 버튼에서 주소록 정보 insert
		function address_action(){
			$user_name=$this->input->post("name"); // 뷰에서 ajax의 보낸 데이터의 value담긴 key값 가져온다!!!
			$user_email=$this->input->post("email");
			$user_department=$this->input->post("department");
			$user_group=$this->input->post("group");
			$user_id=$_SESSION['userid']; // session값 가져온다
			$user_comment=$this->input->post("comment");
			// $_SESSION['userid']

			$data = array(
				'name' => $user_name,
				'email' => $user_email,
				'department' => $user_department,
				'group' => $user_group,
				'id' => $user_id,
				'comment' => $user_comment
			);

			// $data['name'] =$this->input->post("name");
			// $keyword = $this->input->post('data');
	  	$result = $this->M_group->address_insert_action($data);
	  	echo json_encode($result);
		}


		// 주소록 추가한거 화면에 띄우기
		function address_book_view(){
				$address_data = $_SESSION['userid'];
				if($address_data == ""){
					$result['group_list'] = $this->M_group->address_book_view(); // 보낼 값이 없으면 넘길게 없어서 모델의 파라미터에 기본값을 설정해줘야한다(기본값 an--ddress_data=="")
				}else{
					$result['group_list'] = $this->M_group->address_book_view($address_data); // 값을 보내는  것, 아규먼트
				}
				$this->load->view('address_book_view', $result);
		}

		// db에 있는값 가져오기
		function detail_address_click(){
			$keyword = $this->input->get('s');
			$result= $this->M_group->detail_address_update($keyword);
			echo json_encode($result);
		}



}
?>

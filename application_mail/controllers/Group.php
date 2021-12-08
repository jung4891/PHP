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

			//url Heler 로딩
			$this->load->helper("url");
			//페이지네이션 라이브러리 로딩
			$this->load->library('pagination');

			// $config['base_url'] = 'http://example.com/index.php/group/paging/';
			// $config['total_rows'] = 27;
			// $config['per_page'] = 10;
			//
			// $this->pagination->initialize($config);
			//
			// // echo $this->pagination->create_links();

    	}


		// '주소록 추가' 버튼에서 주소록 정보 insert
		function address_action(){
			$user_name=$this->input->post("name"); // 뷰에서 ajax의 보낸 데이터의 value담긴 key값 가져온다!!!
			$user_email=$this->input->post("email");
			$user_department=$this->input->post("department");
			$user_group=$this->input->post("group");
			$user_id=$_SESSION['userid']; // session값 가져온다
			$user_comment=$this->input->post("comment");
			$user_date=$this->input->post("date");
			// $_SESSION['userid']

			$data = array(
				'name' => $user_name,
				'email' => $user_email,
				'department' => $user_department,
				'group' => $user_group,
				'id' => $user_id,
				'comment' => $user_comment,
				'insert_date' => date('Y-m-d H:i:s')
			);

	  	$result = $this->M_group->address_insert_action($data);
	  	echo json_encode($result);
		}




		// 주소록 추가한거 화면에 띄우기
		function address_book_view(){

				$address_data = $_SESSION['userid'];
				if($address_data == ""){
					redirect('');
				}else{

					if(isset($_GET['cur_page'])) {
						$cur_page = $_GET['cur_page'];
					} else {
						$cur_page = 0;
					}														//	현재 페이지
					$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

					if  ( $cur_page <= 0 ){
						$cur_page = 1;
					}

					$data['cur_page'] = $cur_page;
					$data['count'] = $this->M_group->address_book_count($address_data)->totalCount;

					$data['group_list'] = $this->M_group->address_book_view($address_data ,( $cur_page - 1 ) * $no_page_list, $no_page_list); // 값을 보내는  것, 아규먼트

					$total_page = 1;
					if  ( $data['count'] % $no_page_list == 0 )
						$total_page = floor( ( $data['count'] / $no_page_list ) );
					else
						$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );			//	전체 페이지 개수

					$start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
					$end_page = 0;
					if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
						$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
					else
						$end_page = $total_page;

					$data['no_page_list'] = $no_page_list;
					$data['total_page'] = $total_page;
					$data['start_page'] = $start_page;
					$data['end_page'] = $end_page;

					$this->load->view('address_book_view', $data);
				}

		}


		// db에 있는값 가져오기(수정)
		function detail_address_click(){
			$keyword = $this->input->get('seq');
			$result = $this->M_group->get_detail_address($keyword);
			echo json_encode($result);
		}


		// 주소록 checkbox 삭제
		function address_delete(){
			$data = $this->input->post('checkboxArr');
			$result = $this->M_group->address_delete($data);
			echo json_encode($result);
		}

		function detail_address_save(){
			$seq = $this->input->post("seq");
			$user_name=$this->input->post("name"); // 뷰에서 ajax의 보낸 데이터의 value담긴 key값 가져온다!!!
			$user_email=$this->input->post("email");
			$user_department=$this->input->post("department");
			$user_group=$this->input->post("group");
			$user_id=$_SESSION['userid']; // session값 가져온다
			$user_comment=$this->input->post("comment");
			$user_date=$this->input->post("date");
			// $_SESSION['userid']
			$update_data = array(
				'name' => $user_name,
				'email' => $user_email,
				'department' => $user_department,
				'group' => $user_group,
				'id' => $user_id,
				'comment' => $user_comment,
				'insert_date' => date('Y-m-d H:i:s')
			);
			$result = $this->M_group->address_modify_action($update_data, $seq);
	  	echo json_encode($result);
		}

}
?>

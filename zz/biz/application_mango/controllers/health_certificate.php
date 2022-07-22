<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Health_certificate extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'mango' );
		$this->name = $this->phpsession->get( 'name', 'mango' );
		$this->seq = $this->phpsession->get( 'seq', 'mango' );
		$this->admin = $this->phpsession->get( 'admin', 'mango' );

		$this->load->Model(array('STC_Health_certificate', 'STC_Common'));
		$this->load->library('user_agent');
	}

	//공지사항 리스트(공통)
	function doc_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		} else {
			$cur_page = 0;
		}														//	현재 페이지

		if(!isset($_GET['lpp']) || $_GET['lpp']=='') {
			$no_page_list = 15;										//	한페이지에 나타나는 목록 개수
		} else {
			$no_page_list = (int)$_GET['lpp'];
		}
		$data['lpp'] = $no_page_list;

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		} else {
			$search_keyword = "";
		}

		if(isset($_GET['search1'])) {
			$search1 = $_GET['search1'];
		} else {
			$search1 = "";
		}


		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Health_certificate->doc_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Health_certificate->doc_list_count($search_keyword, $search1)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$this->load->view( 'health_certificate/doc_list', $data );
	}

	function duple_check() {
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$result = $this->STC_Health_certificate->duple_check($year, $month);

		if($result == false) {
			$arr = array('result' => 'false');
		} else {
			$arr = array('result' => 'true');
		}

		echo json_encode($arr);
	}

	function generate_doc() {
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$data = array(
			'year'  => $year,
			'month' => $month,
			'write_id' => $this->id,
			'write_date' => date('Y-m-d H:i:s')
		);

		$doc_seq = $this->STC_Health_certificate->gen_doc($data);

		$user_list = $this->STC_Health_certificate->user_health_list();

		foreach($user_list as $ul) {
			$cData = array(
				'upper_seq' => $doc_seq,
				'user_seq'  => $ul['seq'],
				'user_name' => $ul['user_name'],
				'sdate'     => $ul['health_certificate_term_s'],
				'edate'     => $ul['health_certificate_term_e'],
			);

			$result = $this->STC_Health_certificate->insert_doc_contents($cData);
		}

		if($result) {
			echo "<script>alert('저장되었습니다.');location.href='".site_url()."/health_certificate/doc_view?seq=".$doc_seq."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
		}
	}

	function doc_view() {
		$seq = $this->input->get('seq');

		$data['seq'] = $seq;
		$data['view_val'] = $this->STC_Health_certificate->doc_data($seq);
		$data['contents'] = $this->STC_Health_certificate->contents_data($data['view_val']['seq']);

		$read = array(
			'target'    => 'health_certificate',
			'table_seq' => $seq,
			'user_seq'  => $this->seq
		);
		$this->STC_Common->board_read_insert($read);

		$this->load->view('health_certificate/doc_view', $data);
	}

	function doc_delete_action() {
		$seq = $this->input->get('seq');

		$result = $this->STC_Health_certificate->doc_delete($seq);

		if($result) {
			echo "<script>alert('저장되었습니다.');location.href='".site_url()."/health_certificate/doc_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
		}
	}

}
?>

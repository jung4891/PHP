<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Durian_car extends CI_Controller {
    var $id = '';

    function __construct() {
        parent::__construct();
        $this->id = $this->phpsession->get( 'id', 'stc' );
        $this->name = $this->phpsession->get( 'name', 'stc' );
        $this->lv = $this->phpsession->get( 'lv', 'stc' );
        $this->company = $this->phpsession->get( 'company', 'stc' );
        $this->email = $this->phpsession->get('email','stc');
        $this->pGroupName = $this->phpsession->get('pGroupName','stc');
    }

	function car_drive_list(){
	
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model(array('STC_tech_car'));
        if(isset($_GET['cur_page'])) {
            $cur_page = $_GET['cur_page'];
        }
        else {
            $cur_page = 0;
                }                                                                                                               //      현재 페이지

        $no_page_list = 10;                                                                             //      한페>이지에 나타나는 목록 개수

        if(isset($_GET['searchkeyword'])) {
            $search_keyword = $_GET['searchkeyword'];
        }
        else {
            $search_keyword = "";
        }

        if(isset($_GET['search1'])) {
            $search1 = $_GET['search1'];
        }
        else {
            $search1 = "";
        }

        $data['search_keyword'] = $search_keyword;
        $data['search1'] = $search1;
        if  ( $cur_page <= 0 )
            $cur_page = 1;
        $data['cur_page'] = $cur_page;

        $user_list_data = $this->STC_tech_car->tech_car_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_tech_car->tech_car_list_count($search_keyword, $search1)->ucount;
        $data['list_val'] = $user_list_data['data'];
        $data['list_val_count'] = $user_list_data['count'];
        $total_page = 1;
        if  ( $data['count'] % $no_page_list == 0 )
            $total_page = floor( ( $data['count'] / $no_page_list ) );
        else
            $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );                  //      전체 페이지 개수

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
        $this->load->view( 'car_drive_list', $data );


	}

	function car_drive_input(){

	$this->load->Model(array('STC_tech_car'));


      $data['view_val']=$this->STC_tech_car->car_max_km("37부1107");


	$this->load->view('car_drive_input',$data);

	}


	function car_drive_input_action(){
	
	$this->load->Model(array('STC_tech_car'));
	$seq = $this->input->post('seq');

	$carname_tmp = $this->input->post('carname');
	$carTok = explode('-',$carname_tmp);

	$data = array(
		'carname'	=> $carTok[0],
		'carnum'	=> $carTok[1],
		'd_point'	=> $this->input->post('d_point'),
		'a_point' 	=> $this->input->post('a_point'),
		'd_time' 	=> $this->input->post('d_time'),
		'a_time' 	=> $this->input->post('a_time'),
		'd_km'		=> $this->input->post('d_km'),
		'a_km'		=> $this->input->post('a_km'),
		'driver'	=> $this->input->post('driver'),
		'writer'	=> $this->input->post('writer'),
		'drive_date'	=> $this->input->post('drive_date'),
		'drive_purpose'	=> $this->input->post('drive_purpose'),
		'oil'		=> $this->input->post('oil'),
		'etc'		=> $this->input->post('etc')

		);
	if ($seq == null) { 
		$result = $this->STC_tech_car->tech_car_insert($data,$mode = 0);
	}else {
		$result = $this->STC_tech_car->tech_car_insert($data, $mode = 1, $seq);
	}

        if($result) {
          echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/durian_car/car_drive_list';</script>";
        } else {
        echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }

	}

    function car_drive_delete_action() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

	
        $this->load->model(array( 'STC_tech_car' ));

        $seq = $this->input->get( 'seq' );
        if ($seq != null) {
echo "1";
            $tdata = $this->STC_tech_car->tech_car_delete($seq);
echo "2";
        }
        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/durian_car/car_drive_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
        }
    }


    function car_drive_view() {

        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model('STC_tech_car');
        $this->load->Model('STC_User');

        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );

        $data['view_val'] = $this->STC_tech_car->car_drive_view($seq);
        $data['seq'] = $seq;
        $data['group_member'] = $this->STC_User ->same_group_member($this->pGroupName);

            if($mode == "view") {
                $this->load->view( 'car_drive_view', $data );
            } else {
                $this->load->view( 'car_drive_modify', $data );
            }
    }

    function search_car(){

        $this->load->Model(array('STC_tech_car'));

      $carnum = $_GET['carnum'];
      $sql = "select carnum, a_km from car_drive where carnum=? order by seq desc limit 1";
      $data = $this->db->query($sql,$carnum)->result();
      if(count($data)==0){
/*
      $data = Array(
	[0] => stdClass Object(
		[carnum] => $carnum
		[a_km]	 => 0)
        )
     */ } 
     $this->load->view('search_car',array('input'=>$data));
    }

}?>

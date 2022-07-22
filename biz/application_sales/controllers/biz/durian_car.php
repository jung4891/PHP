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
        $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

        if($this->cooperation_yn == 'Y') {
          echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
        }

        $this->load->Model(array('tech/STC_User', 'biz/STC_tech_car'));
    }

	function car_drive_list(){

        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model(array('STC_tech_car'));
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

        $biz_lv = substr($this->lv,0, 1);
        $user_list_data = $this->STC_tech_car->tech_car_list($this->id, $biz_lv, $search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_tech_car->tech_car_list_count($this->id, $biz_lv, $search_keyword, $search1)->ucount;
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

        $data['view_val']=$this->STC_tech_car->car_max_km("37부1107");


        $data['car_list']=$this->STC_tech_car->car_list($this->id, $biz_lv);

        $this->load->library('user_agent');

        if($this->agent->is_mobile()){
          $data['mobile'] = 'true';
          $data['title'] = '차량일지';
          $this->load->view('biz/car_drive_list_mobile', $data );
        } else {
          $data['mobile'] = 'false';
          $this->load->view('biz/car_drive_list', $data );
        }



	}

	// function car_drive_input(){
  //
	// // $this->load->Model(array('STC_tech_car'));
  //
  //
  //     $data['view_val']=$this->STC_tech_car->car_max_km("37부1107");
  //     $data['car_list']=$this->STC_tech_car->car_list();
  //
  //
	// $this->load->view('biz/car_drive_input',$data);
  //
	// }

  function check_km(){
    $carnum = $this->input->post('car_num');
    $result = $this->STC_tech_car->car_max_km($carnum, $seq);

    echo json_encode($result);

  }

	function car_drive_input_action(){
    $val_arr = $this->input->post('val_arr');
    foreach ($val_arr as $arr) {

      if(isset($arr['seq'])){
        $seq = $arr['seq'];
      }else{
        $seq = null;
      }

      $carname_tmp = $arr['carname'];
      $carTok = explode('-',$carname_tmp);

      $data = array(
    		'carname'	=> $carTok[0],
    		'carnum'	=> $carTok[1],
    		'd_point'	=> $arr['d_point'],
    		'a_point' 	=> $arr['a_point'],
    		'd_time' 	=> $arr['d_time'],
    		'a_time' 	=> $arr['a_time'],
    		'd_km'		=> $arr['d_km'],
    		'a_km'		=> $arr['a_km'],
    		'driver'	=> $arr['driver'],
    		'writer'	=> $this->name,
    		'drive_date'	=> $arr['drive_date'],
    		'drive_purpose'	=> $arr['drive_purpose'],
    		'oil'		=> $arr['oil'],
    		'etc'		=> $arr['etc'],
    		);

      if ($seq == null) {
        echo 1; //없으면 왜 ajax success가 안되는가.
        $result = $this->STC_tech_car->tech_car_insert($data,$mode = 0);
      }else {
        echo 2; //없으면 왜 ajax success가 안되는가.
        $result = $this->STC_tech_car->tech_car_insert($data, $mode = 1, $seq);
      }
    }

  	// $seq = $this->input->post('seq');
    //
  	// $carname_tmp = $this->input->post('carname');
  	// $carTok = explode('-',$carname_tmp);
    //
  	// $data = array(
  	// 	'carname'	=> $carTok[0],
  	// 	'carnum'	=> $carTok[1],
  	// 	'd_point'	=> $this->input->post('d_point'),
  	// 	'a_point' 	=> $this->input->post('a_point'),
  	// 	'd_time' 	=> $this->input->post('d_time'),
  	// 	'a_time' 	=> $this->input->post('a_time'),
  	// 	'd_km'		=> $this->input->post('d_km'),
  	// 	'a_km'		=> $this->input->post('a_km'),
  	// 	'driver'	=> $this->input->post('driver'),
  	// 	// 'writer'	=> $this->input->post('writer'),
  	// 	'writer'	=> $this->name,
  	// 	'drive_date'	=> $this->input->post('drive_date'),
  	// 	// 'drive_purpose'	=> $this->input->post('drive_purpose'),
  	// 	'oil'		=> $this->input->post('oil'),
  	// 	'etc'		=> $this->input->post('etc')
  	// 	);

  	// if ($seq == null) {
    //   echo 1; //없으면 왜 ajax success가 안되는가.
  	// 	$result = $this->STC_tech_car->tech_car_insert($data,$mode = 0);
  	// }else {
    //   echo 2; //없으면 왜 ajax success가 안되는가.
  	// 	$result = $this->STC_tech_car->tech_car_insert($data, $mode = 1, $seq);
  	// }

    // if($result) {
    //   echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/biz/durian_car/car_drive_list';</script>";
    // } else {
    //   echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
    // }

	}

    function car_drive_delete_action() {
        if( $this->id === null ) {
            redirect( 'account' );
        }


        // $this->load->Model(array( 'STC_tech_car' ));

        $seq = $this->input->post( 'seq' );
        if ($seq != null) {
          // echo "1";
          // $tdata = $this->STC_tech_car->tech_car_delete($seq);
            $this->STC_tech_car->tech_car_delete($seq);
        }
        // if ($tdata) {
        //     echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/biz/durian_car/car_drive_list';</script>";
        // } else {
        //     echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
        // }
    }


    function car_drive_view() {

        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model('STC_tech_car');
        // $this->load->Model('STC_User');

        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );

        $biz_lv = substr($this->lv,0, 1);

        $data['view_val'] = $this->STC_tech_car->car_drive_view($seq);
        $data['seq'] = $seq;
        $data['group_member'] = $this->STC_User ->same_group_member($this->pGroupName);
        $data['car_list']=$this->STC_tech_car->car_list($this->id, $biz_lv);

            if($mode == "view") {
                $this->load->view('biz/car_drive_view', $data );
            } else {
                $this->load->view('biz/car_drive_modify', $data );
            }
    }

    function search_car(){

        // $this->load->Model(array('STC_tech_car'));

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
     $this->load->view('biz/search_car',array('input'=>$data));
    }


    //변경할 리스트의 seq로 먼저 값을 받아오기
    // 모바일 일정 상세 보기
    function find_modify_seq(){
      $seq = $this->input->post('seq');
      $result = $this->STC_tech_car->find_modify_seq($seq);
      echo json_encode($result);
    }

    //해당 차종의 마지막 도착km 기록가져오기
    function find_last_a_km(){
      $carname = $this->input->post('carname');
      $carnum = $this->input->post('carnum');
      $result = $this->STC_tech_car->find_last_a_km($carname, $carnum);
      echo json_encode($result);
    }
    //해당 차종의 현재 seq 이전의 도착km 기록가져오기
    function find_before_a_km(){
      $seq = $this->input->post('seq');
      $carname = $this->input->post('carname');
      $carnum = $this->input->post('carnum');
      $data = array(
        'seq' => $seq,
        'carname' => $carname,
        'carnum' => $carnum
      );
      $result = $this->STC_tech_car->find_before_a_km($data);
      echo json_encode($result);
    }


    function change_km(){
      $seq = $this->input->post('seq');
      $carname = $this->input->post('carname');
      $carnum = $this->input->post('carnum');
      $data = array(
        'seq' => $seq,
        'carname' => $carname,
        'carnum' => $carnum
      );
      $result = $this->STC_tech_car->change_km($data);
      echo json_encode($result);
    }

    function find_before_seq(){
      $seq = $this->input->post('seq');
      $carname = $this->input->post('carname');
      $carnum = $this->input->post('carnum');
      $data = array(
        'seq' => $seq,
        'carname' => $carname,
        'carnum' => $carnum
      );
      $result = $this->STC_tech_car->find_before_seq($data);
      echo json_encode($result);
    }

    function excelDownload(){

      // $carname        = $this->input->post("add_carname"); // 차종
      // // $carnum         = $this->input->post("carnum"); // 차량번호
      // $d_point        = $this->input->post("add_d_point"); // 출발지
      // $a_point        = $this->input->post("add_a_point"); // 도착지
      // $d_km           = $this->input->post("add_d_km"); // 출발km
      // $a_km           = $this->input->post("add_a_km"); // 도착km
      // $drive_distance = $this->input->post("add_total_km");// 주행거리
      // $driver         = $this->input->post("add_driver"); // 운행자
      // // $writer         = $this->name // 등록자 ???
      // $drive_date     = $this->input->post("add_drive_date");// 운행일
      // $d_time         = $this->input->post("add_d_time"); // 출발시
      // $a_time         = $this->input->post("add_a_time"); // 도착시
      // $oil            = $this->input->post("add_oil"); // 주유비
      // $drive_purpose  = $this->input->post("add_drive_purpose"); // 운행목적
      // $etc            = $this->input->post("add_etc"); // 기타
      //
      // $data = array(
  		// 	'carname'                   => $carname,
  		// 	// 'carnum'                    => $carnum,
      //   'd_point'                   => $d_point,
      //   'a_point'                   => $a_point,
      //   'd_km'                      => $d_km,
      //   'a_km'                      => $a_km,
      //   'drive_distance'            => $drive_distance,
      //   'driver'                    => $driver,
      //   // 'writer'                    => $writer,
      //   'drive_date'                => $drive_date,
      //   'd_time'                    => $d_time,
      //   'a_time'                    => $a_time,
      //   'oil'                       => $oil,
      //   'drive_purpose'             => $drive_purpose,
      //   'etc'                       => $etc
  		// );

      $result = $this->STC_tech_car->excelDownload();
        echo json_encode($result);

    }

}?>

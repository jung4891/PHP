<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Annual_admin extends CI_Controller {

   var $id = '';

   function __construct() {
      parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );

      $this->load->Model(array('STC_Common', 'admin/STC_Annual_admin'));
   }

   function annual_management() {
      if( $this->id === null ) {
         redirect( 'account' );
      }
      if(isset($_POST['searchkeyword'])) {
			$search_keyword = $_POST['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}
      $data['search_keyword']=$search_keyword;
      $data['view_val'] = $this->STC_Annual_admin->annual_management(0,$search_keyword);
      $this->load->view('admin/annual_management', $data );
   }

   function attendance_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      if(isset($_GET['cur_page'])) {
         $cur_page = $_GET['cur_page'];
      }
      else {
         $cur_page = 0;
      }                                          //   현재 페이지
      $no_page_list = (int)$this->STC_Attendance_admin->user_count()->ucount;                              //   한페이지에 나타나는 목록 개수

      if(isset($_GET['searchkeyword'])) {
  			$search_keyword = $_GET['searchkeyword'];
  		}
  		else {
  			$search_keyword = "";
  		}

      $data['search_keyword'] = $search_keyword;

      if  ( $cur_page <= 0 )
         $cur_page = 1;

      $data['cur_page'] = $cur_page;

      $user_list_data = $this->STC_Attendance_admin->attendance_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Attendance_admin->attendance_list_count($search_keyword)->ucount;

      $data['list_val'] = $user_list_data['data'];
      $data['list_val_count'] = $user_list_data['count'];

      $total_page = 1;
      if  ( $data['count'] % $no_page_list == 0 )
         $total_page = floor( ( $data['count'] / $no_page_list ) );
      else
         $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );         //   전체 페이지 개수

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



      $this->load->view('admin/attendance_list', $data );
   }

   function attendance_input_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model( 'STC_Equipment' );
      $user_seq = $this->input->post('user_seq');
      $card_num = $this->input->post('card_num');
      $ws_time = $this->input->post('ws_time');
      $wc_time = $this->input->post('wc_time');

      $data = array(
         'user_seq' => $user_seq,
         'card_num' => $card_num,
         'ws_time' => $ws_time,
         'wc_time' => $wc_time,
         'insert_date' => date("Y-m-d H:i:s")
       );

     $count = $this->STC_Attendance_admin->attendance_user_count($user_seq)->ucount;

      if ($count==0) {
         $result = $this->STC_Attendance_admin->attendance_user_insert($data, $mode = 0);
      } else {
         $result = $this->STC_Attendance_admin->attendance_user_insert($data, $mode = 1, $user_seq);
      }

      if($result) {
         echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/admin/attendance_admin/attendance_user_list'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }

   }

   function attendance_user_info(){
     $seq = $this->input->post('seq');

     $result = $this->STC_Attendance_admin->attendance_user_info($seq);

     echo json_encode($result);
   }

   function attendance_card_info(){
     $name = $this->input->post('name');

     $result = $this->STC_Attendance_admin->attendance_card_info($name);

     echo json_encode($result);
   }

   //근태관리 수정!
   function attendance_individual(){
      $type = $this->input->post('type');
	   $seq = $this->input->post('seq');

      if($type ==0){//select
         $result = $this->STC_Attendance_admin->attendance_individual($type,$seq);
      }else if ($type ==1){//update
         $date = $this->input->post('date');
         $wstime = $this->input->post('wstime');
         $wctime = $this->input->post('wctime');

         if($wstime != ""){
               $wstime = explode(':',$wstime);
               $wstime = $date.(str_pad($wstime[0],2,"0",STR_PAD_LEFT)).$wstime[1]."00";
         }else{
            $wstime =null;
         }

         if($wctime != ""){
               $wctime = explode(':',$wctime);
               $wctime = $date.(str_pad($wctime[0],2,"0",STR_PAD_LEFT)).$wctime[1]."00";
         }else{
            $wctime =null;
         }

         $data=array(
            'seq' => $this->input->post('seq'),
            'ws_time' => $wstime,
            'wc_time' => $wctime,
            'status' => $this->input->post('status'),
            'update_time' => date("Y-m-d H:i:s"),
            'write_id' => 'admin'
         );
         $result = $this->STC_Attendance_admin->attendance_individual($type,$data);
      }
      echo json_encode($result);
   }


   //휴가 사용 현황
   function annual_usage_status() {
      if( $this->id === null ) {
         redirect( 'account' );
      }
      $data['view_val'] = $this->STC_Annual_admin->annual_usage_status();
      $this->load->view('admin/annual_usage_status', $data );
   }

   //휴가 사용 내역
   function annual_usage_status_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      //필터
      if(isset($_GET['searchkeyword'])) {
         $search_keyword = $_GET['searchkeyword'];
      }
      else {
         $search_keyword = "";
      }
      $data['search_keyword'] = $search_keyword;

      $data['view_val'] = $this->STC_Annual_admin->annual_usage_status_list($search_keyword);
      $this->load->view('admin/annual_usage_status_list', $data );
   }

   //연차 user
   function annual_management_user(){
      $seq = $this->input->post('seq');
      $result = $this->STC_Annual_admin-> annual_management($seq);
      echo json_encode($result);
   }

   //연차관리 수정
   function user_annual_update(){
      $type = $this->input->post('type');
      $seq = $this->input->post('seq');
      $month_annual_cnt =  $this->input->post('month_annual_cnt');
      $annual_cnt =  $this->input->post('annual_cnt');
      if($type == 1){//연차생성
         $data = array(
            'seq' => $seq,
            'month_annual_cnt' => (double)$month_annual_cnt,
            'annual_cnt' => (double)$annual_cnt,
            'update_date' => date("Y-m-d H:i:s")
         );
      }else if($type == 2){ //연차삭제
         $remainder_annual_cnt = $this->input->post('remainder_annual_cnt');
         $data=array(
            'seq' => $seq,
            'month_annual_cnt' => (double)$month_annual_cnt,
            'annual_cnt' => (double)$annual_cnt,
            'remainder_annual_cnt' => (double)$remainder_annual_cnt,
            'update_date' => date("Y-m-d H:i:s")
         );
      }
      $result = $this->STC_Annual_admin-> user_annual_update($type,$data);
      echo json_encode($result);
   }

   //조정연차관리
   function adjust_annual_save(){
      $type = $this->input->post('type');
      if($type == 0){//조정연차 select
         $data = $this->input->post('annual_seq');
      }else if($type == 1){//조정연차 insert
         $data = array(
            'annual_seq' => $this->input->post('annual_seq'),
            'adjust_annual_type' => $this->input->post('adjust_annual_type'),
            'insert_date' => $this->input->post('insert_date'),
            'adjust_annual_cnt' => $this->input->post('adjust_annual_cnt'),
            'comment' => $this->input->post('comment'),
            'write_id' => $this->id
         );
      }else if ($type == 2){//조정연차 delete
         $data = array(
            'seq' => $this->input->post('seq'),
            'annual_seq' => $this->input->post('annual_seq')
         );
      }
      $result = $this->STC_Annual_admin->adjust_annual_save($type,$data);
      echo json_encode($result);
   }

   //1월1일 user_annual 넣어주는 크론탭
   function make_user_annual(){
      $result = $this->STC_Annual_admin->make_user_annual();
   }
}
?>

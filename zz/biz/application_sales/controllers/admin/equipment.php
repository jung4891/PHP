<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Equipment extends CI_Controller {

   var $id = '';

   function __construct() {
      parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );

      $this->load->Model(array('STC_Common', 'admin/STC_Equipment', 'biz/STC_Schedule'));
   }

   function car_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      if(isset($_GET['cur_page'])) {
         $cur_page = $_GET['cur_page'];
      }
      else {
         $cur_page = 0;
      }                                          //   현재 페이지
      $no_page_list = 10;                              //   한페이지에 나타나는 목록 개수

      $search_keyword = "";
      $search1 = "";
      $search2 = "";

      if  ( $cur_page <= 0 )
         $cur_page = 1;

      $data['cur_page'] = $cur_page;

      $user_list_data = $this->STC_Equipment->car_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Equipment->car_list_count($search_keyword, $search1, $search2)->ucount;

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

      $data['parentGroup'] = $this->STC_Schedule->parentGroup();
      $data['user_group'] = $this->STC_Schedule->user_group();
      $data['userInfo'] = $this->STC_Schedule->userInfo();
      $data['userDepth'] = $this->STC_Schedule->userDepth();

      $this->load->view('admin/car_list', $data );
   }

   // 차량 쓰기 뷰
   function car_input() {
     if( $this->id === null ) {
       redirect( 'account' );
     }

     $this->load->view('admin/car_input');
   }

   //차량 입력/수정 처리
   function car_input_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model( 'STC_Equipment' );
      $seq = $this->input->post('seq');

      $data = array(
         'type' => $this->input->post('type'),
         'number' => $this->input->post('number'),
         'user_name' => $this->input->post('user_name'),
         'user_seq' => $this->input->post('user_seq'),
         'insert_date' => date("Y-m-d H:i:s")
       );

      if ($seq == null) {
         $result = $this->STC_Equipment->car_insert($data, $mode = 0);
      } else {
         $result = $this->STC_Equipment->car_insert($data, $mode = 1, $seq);
      }

      if($result) {
         echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/admin/equipment/car_list'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }

   }


   // 차량 보기/수정 뷰
   function car_view() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      $seq = $this->input->get( 'seq' );
      $mode = $this->input->get( 'mode' );

      $data['view_val'] = $this->STC_Equipment->car_view($seq);
      $data['seq'] = $seq;

      $data['parentGroup'] = $this->STC_Schedule->parentGroup();
      $data['user_group'] = $this->STC_Schedule->user_group();
      $data['userInfo'] = $this->STC_Schedule->userInfo();
      $data['userDepth'] = $this->STC_Schedule->userDepth();

      $this->load->view('admin/car_modify', $data );
   }

   // 차량 삭제
   function car_delete_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      $this->load->helper('alert');
      // $this->load->Model( 'STC_Equipment' );
      $seq = $this->input->post( 'seq' );

      if ($seq != null) {
         $tdata = $this->STC_Equipment->car_delete($seq);
      }

      if ($tdata) {
         echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/admin/equipment/car_list'</script>";
      } else {
         alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
      }
   }


   function meeting_room_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      if(isset($_GET['cur_page'])) {
         $cur_page = $_GET['cur_page'];
      }
      else {
         $cur_page = 0;
      }                                          //   현재 페이지
      $no_page_list = 10;                              //   한페이지에 나타나는 목록 개수

      $search_keyword = "";
      $search1 = "";
      $search2 = "";

      if  ( $cur_page <= 0 )
         $cur_page = 1;

      $data['cur_page'] = $cur_page;

      $user_list_data = $this->STC_Equipment->meeting_room_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Equipment->meeting_room_list_count($search_keyword, $search1, $search2)->ucount;

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

      $this->load->view('admin/meeting_room_list', $data );
   }

   // 회의실 쓰기 뷰
   function meeting_room_input() {
     if( $this->id === null ) {
       redirect( 'account' );
     }

     $this->load->view('admin/meeting_room_input');
   }

   //회의실 입력/수정 처리
   function meeting_room_input_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model( 'STC_Equipment' );
      $seq = $this->input->post('seq');

      $data = array(
        'room_name' => $this->input->post('room_name'),
        'location' => $this->input->post('location'),
        'insert_date' => date("Y-m-d H:i:s")
       );

      if ($seq == null) {
         $result = $this->STC_Equipment->meeting_room_insert($data, $mode = 0);
      } else {
         $result = $this->STC_Equipment->meeting_room_insert($data, $mode = 1, $seq);
      }

      if($result) {
         echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/admin/equipment/meeting_room_list'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }

   }


   // 회의실 보기/수정 뷰
   function meeting_room_view() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      $seq = $this->input->get( 'seq' );
      $mode = $this->input->get( 'mode' );

      $data['view_val'] = $this->STC_Equipment->meeting_room_view($seq);
      $data['seq'] = $seq;

      $this->load->view('admin/meeting_room_modify', $data );
   }

   // 회의실 삭제
   function meeting_room_delete_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      $this->load->helper('alert');
      // $this->load->Model( 'STC_Equipment' );
      $seq = $this->input->post( 'seq' );

      if ($seq != null) {
         $tdata = $this->STC_Equipment->meeting_room_delete($seq);
      }

      if ($tdata) {
         echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/admin/equipment/meeting_room_list'</script>";
      } else {
         alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
      }
   }

}
?>
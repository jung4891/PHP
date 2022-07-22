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
    } else {
      $search_keyword = "";
    }
    $data['search_keyword'] = $search_keyword;
    $data['view_val'] = $this->STC_Annual_admin->annual_management(0,$search_keyword);
    $this->load->view('admin/annual_management', $data);
  }

  function attendance_list() {
    if( $this->id === null ) {
      redirect( 'account' );
    }

    if(isset($_GET['cur_page'])) {
      $cur_page = $_GET['cur_page'];
    } else {
      $cur_page = 0;
    }
    $no_page_list = (int)$this->STC_Attendance_admin->user_count()->ucount;

    if(isset($_GET['searchkeyword'])) {
      $search_keyword = $_GET['searchkeyword'];
    } else {
      $search_keyword = "";
    }

    $data['search_keyword'] = $search_keyword;

    if ( $cur_page <= 0 ) {
      $cur_page = 1;
    }

    $data['cur_page'] = $cur_page;

    $user_list_data = $this->STC_Attendance_admin->attendance_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
    $data['count'] = $this->STC_Attendance_admin->attendance_list_count($search_keyword)->ucount;

    $data['list_val'] = $user_list_data['data'];
    $data['list_val_count'] = $user_list_data['count'];

    $total_page = 1;
    if ( $data['count'] % $no_page_list == 0 ) {
      $total_page = floor( ( $data['count'] / $no_page_list ) );
    } else {
      $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );
    }

    $start_page = floor( ( $cur_page - 1 ) / 10 ) * 10 + 1;
    $end_page = 0;
    if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ) {
      $end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
    } else {
      $end_page = $total_page;
    }

    $data['no_page_list'] = $no_page_list;
    $data['total_page'] = $total_page;
    $data['start_page'] = $start_page;
    $data['end_page'] = $end_page;

    $this->load->view('admin/attendance_list', $data);
  }

  function attendance_input_action() {
    if( $this->id === null ) {
      redirect( 'account' );
    }

    $user_seq = $this->input->post('user_seq');
    $card_num = $this->input->post('card_num');
    $ws_time = $this->input->post('ws_time');
    $wc_time = $this->input->post('wc_time');

    $data = array(
      'user_seq'    => $user_seq,
      'card_num'    => $card_num,
      'ws_time'     => $ws_time,
      'wc_time'     => $wc_time,
      'insert_date' => data("Y-m-d H:i:s")
    );
  }

}
 ?>

<?php
header("Content-type: text/html; charset=utf-8");
class Official_doc extends CI_Controller {

  var $id = '';

  function __construct() {
    parent::__construct();
    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->customerid = $this->phpsession->get( 'customerid', 'stc' );
    $this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->duty = $this->phpsession->get( 'duty', 'stc' );
    $this->company = $this->phpsession->get( 'company', 'stc' );
    $this->email = $this->phpsession->get('email','stc'); //김수성추가
    $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
    $this->group = $this->phpsession->get( 'group', 'stc' );
    $this->seq = $this->phpsession->get( 'seq', 'stc' );
    $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

    if($this->cooperation_yn == 'Y') {
      echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    }
    $this->load->helper('form');
    $this->load->helper('url');

    $this->load->model('biz/STC_Official_doc' );
    $this->load->library('user_agent');
  }

  // 공문 리스트
  function official_doc_list() {
    if( $this->id === null ) {
        redirect( 'account' );
    }

    //paging
    if(isset($_GET['cur_page'])) { //	현재 페이지
        $cur_page = $_GET['cur_page'];
    }else {
        $cur_page = 1;
    }

    //필터
    if(isset($_GET['searchkeyword'])) {
      $search_keyword = $_GET['searchkeyword'];
    }
    else {
      $search_keyword = "";
    }

    $data['search_keyword'] = $search_keyword;

    if(!isset($_GET['lpp']) || $_GET['lpp']=='') {
      $no_page_list = 15;										//	한페이지에 나타나는 목록 개수
    } else {
      $no_page_list = (int)$_GET['lpp'];
    }

    $data['lpp'] = $no_page_list;

    $data['cur_page'] = $cur_page;


    if($_GET['mode'] == 'user') {
      $data['view_val'] = $this->STC_Official_doc->official_doc_list('list', $this->id, $search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $list_cnt = $this->STC_Official_doc->official_doc_list('list', $this->id, $search_keyword);
    } else if ($_GET['mode'] == 'admin') {
      $data['view_val'] = $this->STC_Official_doc->official_doc_list('admin', $this->id, $search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $list_cnt = $this->STC_Official_doc->official_doc_list('admin', $this->id, $search_keyword);
    }


    $data['doc_form_list'] = $this->STC_Official_doc->official_doc_form('all');
    $data['approval_doc_form'] = $this->STC_Official_doc->official_doc_approval_doc_form();

    if(!empty($data['view_val'])){
        $data['count'] = count($list_cnt);
    }else{
        $data['count'] = 0;
    }

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
    $data['start_row'] = ( $cur_page - 1 ) * $no_page_list;
    $data['end_row'] = $no_page_list;


    $this->load->view('biz/official_doc_list', $data);
  }

  function official_doc_view() {
    $seq = $this->input->get('seq');

    $data['view_val'] = $this->STC_Official_doc->official_doc_view($seq);

    $this->load->view('biz/official_doc_view', $data);
  }

  function official_doc_input() {
    $data['personal_text'] = $this->STC_Official_doc->official_doc_personal_text($this->id);
    $data['doc_form_list'] = $this->STC_Official_doc->official_doc_form('all');

    if(isset($_GET['doc_type_seq'])) {
      $seq = $_GET['doc_type_seq'];
      $data['doc_form'] = $this->STC_Official_doc->official_doc_form($seq);
    }

    $this->load->view('biz/official_doc_input', $data);
  }

  function official_doc_modify() {
    $seq = $this->input->get('seq');

    $data['view_val'] = $this->STC_Official_doc->official_doc_view($seq);

    $data['personal_text'] = $this->STC_Official_doc->official_doc_personal_text($this->id);
    $data['doc_form_list'] = $this->STC_Official_doc->official_doc_form('all');

    $this->load->view('biz/official_doc_modify', $data);
  }

  function official_doc_print() {
    if(!isset($_GET['seq'])) {
      $data = array(
        'user_id' => $this->id,
        'doc_name' => $this->input->post('doc_name'),
        'doc_date' => $this->input->post('doc_date'),
        'to' => $this->input->post('to'),
        'cc' => $this->input->post('cc'),
        'from' => $this->input->post('from'),
        'subject' => $this->input->post('subject'),
        'content' => $this->input->post('content')
      );

      if($this->input->post('header_yn')=='Y') {
        $data['header_text'] = $this->input->post('header_text');
      } else {
        $data['header_text'] = NULL;
      }

      if($this->input->post('footer_yn')=='Y') {
        $data['footer_text'] = $this->input->post('footer_text');
      } else {
        $data['footer_text'] = NULL;
      }

      $my_prev_data = $this->STC_Official_doc->my_prev_data($this->id);

      if($my_prev_data['cnt'] == 0) {
        $this->STC_Official_doc->insert_prev_data($data, $mode = 1);
      } else {
        $this->STC_Official_doc->insert_prev_data($data, $mode = 2);
      }
    }

    if(isset($_GET['seq'])) {
      $data['mode'] = 'print';
      $data['seq'] = $_GET['seq'];
    } else {
      $data['mode'] = 'preview';
      $data['user_id'] = $this->id;
      $data['seq'] = 'preview';
    }

    $this->load->view('biz/official_doc_print', $data);
  }

  function official_doc_preview() {

    if(isset($_GET['seq'])) {
      $seq = $_GET['seq'];
      $user_id = '';
    } else {
      $seq = '';
      $user_id = $_GET['user_id'];
    }

    if($user_id != '') {
      $data['view_val'] = $this->STC_Official_doc->official_doc_preview($user_id);
    }

    if($seq != '') {
      $data['view_val'] = $this->STC_Official_doc->official_doc_view($seq);
    }

    $this->load->view('biz/official_doc_preview', $data);
  }

  function official_doc_footer() {
    if(isset($_GET['seq'])) {
      $seq = $_GET['seq'];
      $data['view_val'] = $this->STC_Official_doc->official_doc_view($seq);
    } else {
      $user_id = $_GET['user_id'];
      $data['view_val'] = $this->STC_Official_doc->official_doc_preview($user_id);
    }

    $this->load->view('biz/official_doc_footer', $data);
  }

  function official_doc_header() {
    if(isset($_GET['seq'])) {
      $seq = $_GET['seq'];
      $data['view_val'] = $this->STC_Official_doc->official_doc_view($seq);
    } else {
      $user_id = $_GET['user_id'];
      $data['view_val'] = $this->STC_Official_doc->official_doc_preview($user_id);
    }

    $this->load->view('biz/official_doc_header', $data);
  }

  function official_doc_input_action() {
    $seq = $this->input->post('seq');

    if($seq == '') {
      $data = array(
        'doc_type' => $this->input->post('doc_type'),
        'doc_name' => $this->input->post('doc_name'),
        'doc_date' => $this->input->post('doc_date'),
        'to' => $this->input->post('to'),
        'cc' => $this->input->post('cc'),
        'from' => $this->input->post('from'),
        'subject' => $this->input->post('subject'),
        'content' => $this->input->post('content'),
        'writer_name' => $this->name,
        'writer_group' => $this->group,
        'write_id' => $this->id,
        'write_date' => date("Y-m-d H:i:s")
      );

      if($this->input->post('header_yn')=='Y') {
        $data['header_text'] = $this->input->post('header_text');
      } else {
        $data['header_text'] = NULL;
      }

      if($this->input->post('footer_yn')=='Y') {
        $data['footer_text'] = $this->input->post('footer_text');
      } else {
        $data['footer_text'] = NULL;
      }

      $result = $this->STC_Official_doc->official_doc_input($data, $mode=1);
    } else {
      $data = array(
        'seq' => $seq,
        'doc_type' => $this->input->post('doc_type'),
        'doc_name' => $this->input->post('doc_name'),
        'doc_date' => $this->input->post('doc_date'),
        'to' => $this->input->post('to'),
        'cc' => $this->input->post('cc'),
        'from' => $this->input->post('from'),
        'subject' => $this->input->post('subject'),
        'content' => $this->input->post('content'),
        'write_date' => date("Y-m-d H:i:s")
      );

      if($this->input->post('header_yn')=='Y') {
        $data['header_text'] = $this->input->post('header_text');
      } else {
        $data['header_text'] = NULL;
      }

      if($this->input->post('footer_yn')=='Y') {
        $data['footer_text'] = $this->input->post('footer_text');
      } else {
        $data['footer_text'] = NULL;
      }

      $result = $this->STC_Official_doc->official_doc_input($data, $mode=2);
    }

    if($result) {
      echo "<script>alert('저장되었습니다.');location.href='".site_url()."/biz/official_doc/official_doc_list?mode=user'</script>";
    } else {
      echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
    }
  }

  function official_doc_delete_action() {
    $seq = $this->input->post('seq');

    $result = $this->STC_Official_doc->official_doc_delete($seq);

    if($result) {
      echo "<script>alert('삭제되었습니다');location.href='".site_url()."/biz/official_doc/official_doc_list?mode=user'</script>";
    } else {
      echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
    }
  }

  //공문 첨부 페이지 뷰
  function official_doc_attachment(){
      if( $this->id === null ) {
          redirect( 'account' );
      }
      //paging
      if(isset($_GET['cur_page'])) { //	현재 페이지
          $cur_page = $_GET['cur_page'];
      }else {
          $cur_page = 1;
      }

      //필터
      if(isset($_GET['searchkeyword'])) {
          $search_keyword = $_GET['searchkeyword'];
      }
      else {
          $search_keyword = "";
      }

      $data['search_keyword'] = $search_keyword;

      $no_page_list = 15; //10개씩 보여준다는고지

      $data['cur_page'] = $cur_page;

      $data['view_val'] = $this->STC_Official_doc->official_doc_list('attachment', $this->id, $search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);//완료된고
      $list_cnt = $this->STC_Official_doc->official_doc_list('attachment', $this->id, $search_keyword);
      $data['doc_form_list'] = $this->STC_Official_doc->official_doc_form('all');

      if(!empty($data['view_val'])){
          $data['count'] = count($list_cnt);
      }else{
          $data['count'] = 0;
      }

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
      $data['start_row'] = ( $cur_page - 1 ) * $no_page_list;
      $data['end_row'] = $no_page_list;

      //페이징 끝

  $this->load->view( 'biz/official_doc_attachment',$data);
  }

  function save_headerfooter() {
    $type = $this->input->post('type');
    $data['user_id'] = $this->id;

    $my_headerfooter = $this->STC_Official_doc->my_headerfooter($this->id);

    if($my_headerfooter['cnt'] == 0) {
      $this->STC_Official_doc->save_headerfooter($data, $mode = 1);
    }

    if($type == 'header') {
      $data['header'] = $this->input->post('header_text');
    } else if ($type == 'footer') {
      $data['footer'] = $this->input->post('footer_text');
    }

    $result = $this->STC_Official_doc->save_headerfooter($data, $mode = 2);

    echo json_encode($result);
  }
}
?>

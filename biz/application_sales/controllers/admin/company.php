<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Company extends CI_Controller {

   var $id = '';

   function __construct() {
      parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );
      $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

      if($this->cooperation_yn == 'Y') {
        echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
      }

      $this->load->library('user_agent');

      $this->load->Model(array('STC_Common', 'admin/STC_Company'));
   }

   //사업자등록번호 리스트(공통)
   function companynum_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model(array('STC_Company', 'STC_Common'));
//      $cur_page = $this->input->get( 'cur_page' );         //   현재 페이지
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

      $user_list_data = $this->STC_Company->companynum_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Company->companynum_list_count($search_keyword, $search1, $search2)->ucount;

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

      $data['category'] = $this->STC_Common->get_category();

      $data['no_page_list'] = $no_page_list;
      $data['total_page'] = $total_page;
      $data['start_page'] = $start_page;
      $data['end_page'] = $end_page;

      $this->load->view('admin/companynum_list', $data );
   }

   //사업자등록번호 입력/수정 처리
   function companynum_input_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model( 'STC_Company' );
      $seq = $this->input->post('seq');

      $data = array(
         'company_name' => $this->input->post('company_name'),
         'company_num' => $this->input->post('company_num'),
         'insert_date' => date("Y-m-d H:i:s")
       );

      if ($seq == null) {
         $result = $this->STC_Company->companynum_insert($data, $mode = 0);
      } else {
         $result = $this->STC_Company->companynum_insert($data, $mode = 1, $seq);
      }

      if($result) {
         echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/admin/company/companynum_list'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }

   }

   // 사업자등록번호 쓰기 뷰
   function companynum_input() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model(array('STC_Company', 'STC_Common'));
      $data['category'] = $this->STC_Common->get_category();
      $this->load->view('admin/companynum_input', $data );
   }

   // 사업자등록번호 보기/수정 뷰
   function companynum_view() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model(array('STC_Company', 'STC_Common'));
      $data['category'] = $this->STC_Common->get_category();
//      $user_id = $this->idx;

      $seq = $this->input->get( 'seq' );
      $mode = $this->input->get( 'mode' );

      $data['view_val'] = $this->STC_Company->companynum_view($seq);
      $data['seq'] = $seq;

      $this->load->view('admin/companynum_modify', $data );
   }

   // 사업자등록번호 삭제
   function companynum_delete_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      $this->load->helper('alert');
      // $this->load->Model( 'STC_Company' );
      $seq = $this->input->post( 'seq' );

      if ($seq != null) {
         $tdata = $this->STC_Company->companynum_delete($seq);
      }

      if ($tdata) {
         echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/admin/company/companynum_list'</script>";
      } else {
         alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
      }
   }

   //제품명 리스트(공통)
   function product_list() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model(array('STC_Company', 'STC_Common'));
//      $cur_page = $this->input->get( 'cur_page' );         //   현재 페이지
      if(isset($_GET['cur_page'])) {
         $cur_page = $_GET['cur_page'];
      }
      else {
         $cur_page = 0;
      }                                          //   현재 페이지
      $no_page_list = 10;                              //   한페이지에 나타나는 목록 개수

      if(isset($_GET['searchkeyword'])) {
         $search_keyword = $_GET['searchkeyword'];
      }
      else {
         $search_keyword = "";
      }


      $search1 = "";

      if(isset($_GET['search2'])) {
         $search2 = $_GET['search2'];
      }
      else {
         $search2 = "";
      }

      $data['search_keyword'] = $search_keyword;
      $data['search2'] = $search2;

      if  ( $cur_page <= 0 )
         $cur_page = 1;

      $data['cur_page'] = $cur_page;

      $user_list_data = $this->STC_Company->product_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      $data['count'] = $this->STC_Company->product_list_count($search_keyword, $search1, $search2)->ucount;

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

      $data['category'] = $this->STC_Common->get_category();

      $data['no_page_list'] = $no_page_list;
      $data['total_page'] = $total_page;
      $data['start_page'] = $start_page;
      $data['end_page'] = $end_page;

      if($this->agent->is_mobile()) {
        $data['title'] = '제품명';
        $this->load->view('admin/product_list_mobile', $data);
      } else {
        $this->load->view('admin/product_list', $data );
      }
   }

   //제품명 입력/수정 처리
   function product_input_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model( 'STC_Company' );
      $seq = $this->input->post('seq');

      $data = array(
         'user_id' => $this->id,
         'product_name' => $this->input->post('product_name'),
         'product_company' => $this->input->post('product_company'),
         'product_item' => $this->input->post('product_item'),
         'product_type' => $this->input->post('product_type'),
         'hardware_spec' => $this->input->post('hardware_spec'),
         'insert_date' => date("Y-m-d H:i:s")
       );

      if ($seq == null) {
         $result = $this->STC_Company->product_insert($data, $mode = 0);
      } else {
         $result = $this->STC_Company->product_insert($data, $mode = 1, $seq);
      }

      if($result) {
         echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/admin/company/product_list'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }

   }

   // 제품명 쓰기 뷰
   function product_input() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model(array('STC_Company', 'STC_Common'));
      $data['category'] = $this->STC_Common->get_category();
      $this->load->view('admin/product_input', $data );
   }

   // 제품명 보기/수정 뷰
   function product_view() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      // $this->load->Model(array('STC_Company', 'STC_Common'));
      $data['category'] = $this->STC_Common->get_category();
//      $user_id = $this->idx;

      $seq = $this->input->get( 'seq' );
      $mode = $this->input->get( 'mode' );

      $data['view_val'] = $this->STC_Company->product_view($seq);
      $data['seq'] = $seq;

      if($this->agent->is_mobile()) {
        $data['title'] = '제품명';
        $this->load->view('admin/product_modify_mobile', $data);
      } else {
        $this->load->view('admin/product_modify', $data );
      }
   }

   // 제품명 삭제
   function product_delete_action() {
      if( $this->id === null ) {
         redirect( 'account' );
      }

      $this->load->helper('alert');
      // $this->load->Model( 'STC_Company' );
      $seq = $this->input->post( 'seq' );

      if ($seq != null) {
         $tdata = $this->STC_Company->product_delete($seq);
      }

      if ($tdata) {
         echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/admin/company/product_list'</script>";
      } else {
         alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
      }
   }

}
?>

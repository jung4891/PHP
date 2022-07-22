<?php
header("Content-type: text/html; charset=utf-8");
class Management extends CI_Controller {

    var $id = '';

    function __construct() {
        parent::__construct();
        $this->id = $this->phpsession->get( 'id', 'stc' );
        $this->name = $this->phpsession->get( 'name', 'stc' );
        $this->lv = $this->phpsession->get( 'lv', 'stc' );
        $this->duty = $this->phpsession->get( 'duty', 'stc' );
        $this->email = $this->phpsession->get('email','stc'); //김수성추가
        $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
        $this->group = $this->phpsession->get( 'group', 'stc' );
        $this->seq = $this->phpsession->get( 'seq', 'stc' );
        $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

        if($this->cooperation_yn == 'Y') {
          echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
        }

        $this->load->model('admin/STC_Management' );
        $this->load->library('user_agent');
    }

    function site_management() {
      if(isset($_GET['cur_page']) && $_GET['cur_page'] != '') {
        $cur_page = $_GET['cur_page'];
      } else {
        $cur_page = 1;
      }
      if(isset($_GET['lpp'])==false || $_GET['lpp']=='') {
        $no_page_list = 50;										//	한페이지에 나타나는 목록 개수
      } else {
        $no_page_list = (int)$_GET['lpp'];
      }

      $data['lpp'] = $no_page_list;

      $data['pGroupName'] = $this->pGroupName;
      $data['group'] = $this->group;

      if(isset($_GET['search_group'])) {
        $search_group = $_GET['search_group'];
      } else {
        $search_group = '경영지원실';
        if($this->pGroupName == '영업본부') {
          $search_group = '영업본부';
        }
      }

      if(isset($_GET['search_company'])) {
        $search_company = $_GET['search_company'];
      } else {
        $search_company = '두리안정보기술';
      }

      if(isset($_GET['searchkeyword'])) {
        $searchkeyword = $_GET['searchkeyword'];
      } else {
        $searchkeyword = '';
      }

      $data['search_group'] = $search_group;
      $data['search_company'] = $search_company;
      $data['searchkeyword'] = $searchkeyword;

      $data['cur_page'] = $cur_page;


      $data['view_val'] = $this->STC_Management->site_management_list($search_group, $search_company, $searchkeyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
      if(!empty($data['view_val'])) {
        $data['count'] = count($this->STC_Management->site_management_list($search_group, $search_company, $searchkeyword));
      } else {
        $data['count'] = 0;
      }

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

      $this->load->view('admin/site_management', $data);
    }

    function site_management_save_action() {
      $mode = $this->input->post('mode');

      $data = array(
        'site_name'   => $this->input->post('site_name'),
        'site_url'    => $this->input->post('site_url'),
        'id'          => $this->input->post('id'),
        'password'    => $this->input->post('password'),
        'note1'       => $this->input->post('note1'),
        'note2'       => $this->input->post('note2'),
        'modifier'    => $this->id,
        'modify_date' => Date('Y-m-d H:i:s')
      );

      if ($mode == 'insert') {
        $data['group'] = $this->input->post('group');
        $data['company'] = $this->input->post('company');
        $result = $this->STC_Management->insert($data);
      }

      if ($mode == 'modify') {
        $seq = $this->input->post('seq');
        $result = $this->STC_Management->update($data, $seq);
      }

      echo json_encode($result);

    }

    function site_management_delete_action() {
      $seq = $this->input->post('delSeq');

      foreach($seq as $s) {
        $result = $this->STC_Management->delete($s);
      }

      echo json_encode($result);
    }

    function site_management_excel() {
      $search_group   = $this->input->post('search_group');
      $search_company = $this->input->post('search_company');
      $searchkeyword  = $this->input->post('searchkeyword');

      $result = $this->STC_Management->site_management_list($search_group, $search_company, $searchkeyword);

      echo json_encode($result);
    }

}
?>

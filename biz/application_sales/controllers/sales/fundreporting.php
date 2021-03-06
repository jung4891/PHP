<?php
class Fundreporting extends CI_Controller {
    function __construct(){
      parent::__construct();

      $this->id = $this->phpsession->get( 'id', 'stc' );
  		$this->name = $this->phpsession->get( 'name', 'stc' );
  		$this->lv = $this->phpsession->get( 'lv', 'stc' );
  		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );
      $this->group = $this->phpsession->get( 'group', 'stc' );
      $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
      $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

      if($this->cooperation_yn == 'Y') {
        echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
      }
      $this->load->database();
      ob_start();
      $this->load->library('session');
      $config['url_suffix'] = 'html';
      $firstCon = "true";

      $this->load->Model('sales/STC_Fundreporting');
    }

    function sort(){

      if( $this->id === null ) {
        redirect( 'account' );
      }
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정
      if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
        if ($pGroupName != '기술연구소' && $group != '기술2팀'){
          echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
        }
      }
      $data['pGroupName'] = $this->pGroupName;
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }

      if(isset($_GET['old_new']) && $_GET['old_new'] != '') {
        $old_new = $_GET['old_new'];
      } else {
        $old_new = 'old';
      }
      if ($pGroupName == '영업본부') {
        $old_new = 'old';
      }
      $data['old_new'] = $old_new;

      if(isset($_POST['searchday'])){
        $searchday = $_POST['searchday'];
        $data['day'] = $_POST['searchday'];
        $searchday_url = "&searchday=".$searchday;
      } else if (isset($_GET['searchday'])){
        $searchday = $_GET['searchday'];
        $data['day'] = $_GET['searchday'];
        $searchday_url = "&searchday=".$searchday;
      } else {
        $searchday = "";
        $searchday_url = '';
      }
      // $this->load->Model('STC_Fundreporting');
      $this->load->library('pagination');
      // 패치 전 수정
      $config['base_url'] = site_url().'/sales/fundreporting/sort/page/';
      $config['total_rows'] = $this->STC_Fundreporting->count($company, $old_new);
      $config['per_page'] = 100;
      $config['uri_segment'] = 5;
      $config['num_links'] = 9;
      $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
      $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $getUrl = '?company='.$company.'&old_new='.$old_new.$searchday_url;
      $config['suffix'] = $getUrl;
      $config['first_url'] = '1'.$getUrl;
      $this->pagination->initialize($config);
      $page = $this->uri->segment(5,1);
        if($page > 1){
              $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
              $start = ($page - 1) * $config['per_page'];
        }
      $lastPage = ceil($config['total_rows'] / $config['per_page']);
      $limit = $config['per_page'];

      $data['company'] = $company;
      $data['pagination'] = $this->pagination->create_links();
      $data['list'] = $this->STC_Fundreporting->accountlist($start, $limit,$company, $old_new);
      if($config['total_rows']<100){
        $data['pagingBalance'] = 0;
      } else if($page == ($lastPage-1)*100){
        $data['pagingBalance'] = 0;
      } else if($page==1){
        $limit = $config['total_rows'] - $config['per_page'];
        $data['pagingBalance'] = $this->STC_Fundreporting->pagingbalance($limit,$company,$old_new);
      } else {
        $limit = $config['total_rows'] - ($page + $config['per_page']);
        $data['pagingBalance'] = $this->STC_Fundreporting->pagingbalance($limit,$company,$old_new);
      }
      $data['set_balance'] = $this->STC_Fundreporting->set_balance($company, $old_new);

      $data['bankList'] = $this->STC_Fundreporting->bankList($company);
      $data['selectBanklist'] = $this->STC_Fundreporting->selectbankbook($company);
      $data['selectBankTypeList'] = $this->STC_Fundreporting->selectbanktypelist($company);

      $data['bankBook'] = $this->STC_Fundreporting->bankbook($company, $searchday);
      $data['bond'] = $this->STC_Fundreporting->bond($company, $searchday);
      $data['debt'] = $this->STC_Fundreporting->debt($company, $searchday);
      $data['bond_adjust'] = $this->STC_Fundreporting->bond_adjust($company, $searchday);
      $data['debt_adjust'] = $this->STC_Fundreporting->debt_adjust($company, $searchday);
      // $data['bond_adjust_minus'] = $this->STC_Fundreporting->bond_adjust_minus($company, $searchday);
      // $data['debt_adjust_minus'] = $this->STC_Fundreporting->debt_adjust_minus($company, $searchday);
      $data['sum_botong'] = $this->STC_Fundreporting->sum_botong($company, $searchday);
      $data['sum_not_botong'] = $this->STC_Fundreporting->sum_not_botong($company, $searchday);
      $data['sum_list_banktype'] = $this->STC_Fundreporting->sum_list_banktype($company, $searchday);

      $this->load->view( 'sales/fundreporting_list', $data);
    }

    function fundreporting_list(){
      // $this->output->enable_profiler(TRUE);
      if( $this->id === null ) {
        redirect( 'account' );
      }
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정
      if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
        if ($pGroupName != '기술연구소' && $group != '기술2팀'){
          echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
        }
      }
      $data['pGroupName'] = $this->pGroupName;
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }

      if(isset($_GET['old_new']) && $_GET['old_new'] != '') {
        $old_new = $_GET['old_new'];
      } else {
        $old_new = 'old';
      }
      if ($pGroupName == '영업본부') {
        $old_new = 'old';
      }
      $data['old_new'] = $old_new;

      // if ($this->load->library('pagination')==false){
      //   $firstCon = "true";
      //   redirect(site_url().'/fundreporting/fundreporting_list/page/100?company=DUIT');
      // }

      if(isset($_POST['searchday'])){
        $searchday = $_POST['searchday'];
        $data['day'] = $_POST['searchday'];
        $searchday_url = "&searchday=".$searchday;
      } else if (isset($_GET['searchday'])){
        $searchday = $_GET['searchday'];
        $data['day'] = $_GET['searchday'];
        $searchday_url = "&searchday=".$searchday;
      } else {
        $searchday = "";
        $searchday_url = '';
      }

      // $this->load->Model('STC_Fundreporting');
      $this->load->library('pagination');
      //패치 전 수정
      $config['base_url'] = site_url().'/sales/fundreporting/fundreporting_list/page/';
      $config['total_rows'] = $this->STC_Fundreporting->count($company, $old_new);
      if(strpos($_SERVER['REQUEST_URI'],'/page') !== false) {
        $data['firstPage'] = 0;
      } else {
        $data['firstPage'] = $this->STC_Fundreporting->firstPage($company, $old_new);
      }
      $config['per_page'] = 100;
      $config['uri_segment'] = 5;
      $config['num_links'] = 9;
      $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
      $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      // $config['num_tag_open'] = '<div style="width:17%;float:left;">';
      // $config['num_tag_close'] = '<div>';
      $getUrl = '?company='.$company.'&old_new='.$old_new.$searchday_url;
      $config['suffix'] = $getUrl;
      $config['first_url'] = '1'.$getUrl;
      $this->pagination->initialize($config);
      $page = $this->uri->segment(5,1);
        if($page > 1){
              $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
              $start = ($page - 1) * $config['per_page'];
        }
      $lastPage = ceil($config['total_rows'] / $config['per_page']);
      $limit = $config['per_page'];

      $data['company'] = $company;
      $data['pagination'] = $this->pagination->create_links();
      $data['list'] = $this->STC_Fundreporting->sort($start, $limit,$company, $old_new);
      if($config['total_rows']<100){
        $data['pagingBalance'] = 0;
      } else if($page == ($lastPage-1)*100){
        $data['pagingBalance'] = 0;
      } else if($page==1){
        $limit = $config['total_rows'] - $config['per_page'];
        $data['pagingBalance'] = $this->STC_Fundreporting->sortpagingbalance($limit,$company,$old_new);
      } else {
        $limit = $config['total_rows'] - ($page + $config['per_page']);
        $data['pagingBalance'] = $this->STC_Fundreporting->sortpagingbalance($limit,$company,$old_new);
      }
      $data['set_balance'] = $this->STC_Fundreporting->set_balance($company, $old_new);
      $data['bankList'] = $this->STC_Fundreporting->bankList($company);
      $data['selectBanklist'] = $this->STC_Fundreporting->selectbankbook($company);
      $data['selectBankTypeList'] = $this->STC_Fundreporting->selectbanktypelist($company);

      $data['bankBook'] = $this->STC_Fundreporting->bankbook($company, $searchday);
      $data['bond'] = $this->STC_Fundreporting->bond($company, $searchday);
      $data['debt'] = $this->STC_Fundreporting->debt($company, $searchday);
      $data['bond_adjust'] = $this->STC_Fundreporting->bond_adjust($company, $searchday);
      $data['debt_adjust'] = $this->STC_Fundreporting->debt_adjust($company, $searchday);
      // $data['bond_adjust_minus'] = $this->STC_Fundreporting->bond_adjust_minus($company, $searchday);
      // $data['debt_adjust_minus'] = $this->STC_Fundreporting->debt_adjust_minus($company, $searchday);
      $data['sum_botong'] = $this->STC_Fundreporting->sum_botong($company, $searchday);
      $data['sum_not_botong'] = $this->STC_Fundreporting->sum_not_botong($company, $searchday);
      $data['sum_list_banktype'] = $this->STC_Fundreporting->sum_list_banktype($company, $searchday);
      // $data['selectLoanBanklist']= $this->STC_Fundreporting->selectLoanAccount($company);
      // $data['selectSaveBanklist']= $this->STC_Fundreporting->selectSaveAccount($company);
      // $data['selectDepositBanklist']= $this->STC_Fundreporting->selectDepositAccount($company);

      $this->load->view( 'sales/fundreporting_list', $data);

    }

    function enduser(){
      if( $this->id === null ) {
        redirect( 'account' );
      }
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정
      if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
        if ($pGroupName != '기술연구소' && $group != '기술2팀'){
          echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
        }
      }
      $data['pGroupName'] = $this->pGroupName;
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }

      if(isset($_GET['old_new']) && $_GET['old_new'] != '') {
        $old_new = $_GET['old_new'];
      } else {
        $old_new = 'old';
      }
      if ($pGroupName == '영업본부') {
        $old_new = 'old';
      }
      $data['old_new'] = $old_new;

      if(isset($_POST['searchday'])){
        $searchday = $_POST['searchday'];
        $data['day'] = $_POST['searchday'];
        $searchday_url = "&searchday=".$searchday;
      } else if (isset($_GET['searchday'])){
        $searchday = $_GET['searchday'];
        $data['day'] = $_GET['searchday'];
        $searchday_url = "&searchday=".$searchday;
      } else {
        $searchday = "";
        $searchday_url = '';
      }
      // $this->load->Model('STC_Fundreporting');

      $this->load->library('pagination');
      //패치 전 수정
      $config['base_url'] = site_url().'/sales/fundreporting/enduser/page/';
      $config['total_rows'] = $this->STC_Fundreporting->count($company, $old_new);
      $config['per_page'] = 100;
      $config['uri_segment'] = 5;
      $config['num_links'] = 9;
      $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
      $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $getUrl = '?company='.$company.'&old_new='.$old_new.$searchday_url;
      $config['suffix'] = $getUrl;
      $config['first_url'] = '1'.$getUrl;
      $this->pagination->initialize($config);
      $page = $this->uri->segment(5,1);
        if($page > 1){
              $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
              $start = ($page - 1) * $config['per_page'];
        }
      $lastPage = ceil($config['total_rows'] / $config['per_page']);
      $limit = $config['per_page'];

      $data['company'] = $company;
      $data['pagination'] = $this->pagination->create_links();
      $data['list'] = $this->STC_Fundreporting->enduser($start, $limit,$company,$old_new);
      if($config['total_rows']<100){
        $data['pagingBalance'] = 0;
      } else if($page == ($lastPage-1)*100){
        $data['pagingBalance'] = 0;
      } else if($page==1){
        $limit = $config['total_rows'] - $config['per_page'];
        $data['pagingBalance'] = $this->STC_Fundreporting->enduserpagingbalance($limit,$company,$old_new);
      } else {
        $limit = $config['total_rows'] - ($page + $config['per_page']);
        $data['pagingBalance'] = $this->STC_Fundreporting->enduserpagingbalance($limit,$company,$old_new);
      }
      $data['set_balance'] = $this->STC_Fundreporting->set_balance($company, $old_new);
      $data['bankList'] = $this->STC_Fundreporting->bankList($company);
      $data['selectBanklist'] = $this->STC_Fundreporting->selectbankbook($company);
      $data['selectBankTypeList'] = $this->STC_Fundreporting->selectbanktypelist($company);

      $data['bankBook'] = $this->STC_Fundreporting->bankbook($company, $searchday);
      $data['bond'] = $this->STC_Fundreporting->bond($company, $searchday);
      $data['debt'] = $this->STC_Fundreporting->debt($company, $searchday);
      $data['bond_adjust'] = $this->STC_Fundreporting->bond_adjust($company, $searchday);
      $data['debt_adjust'] = $this->STC_Fundreporting->debt_adjust($company, $searchday);
      // $data['bond_adjust_minus'] = $this->STC_Fundreporting->bond_adjust_minus($company, $searchday);
      // $data['debt_adjust_minus'] = $this->STC_Fundreporting->debt_adjust_minus($company, $searchday);
      $data['sum_botong'] = $this->STC_Fundreporting->sum_botong($company, $searchday);
      $data['sum_not_botong'] = $this->STC_Fundreporting->sum_not_botong($company, $searchday);
      $data['sum_list_banktype'] = $this->STC_Fundreporting->sum_list_banktype($company, $searchday);
      // $data['selectLoanBanklist']= $this->STC_Fundreporting->selectLoanAccount($company);
      // $data['selectSaveBanklist']= $this->STC_Fundreporting->selectSaveAccount($company);
      // $data['selectDepositBanklist']= $this->STC_Fundreporting->selectDepositAccount($company);

      $this->load->view( 'sales/fundreporting_list', $data);
    }

    function delete(){
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }
        $delData = $this->input->post('data');
        // $this->load->Model('STC_Fundreporting');

        $data = array(
          'idx' => $delData
        );
        $result = $this->STC_Fundreporting->delete($data);
        $result = $this->STC_Fundreporting->bankbookupdate($company);
        echo json_encode($result);

      $id = $this->phpsession->get('id', 'stc');
      $trg = array(
          'idx' => $delData,
          'id' => $id
      );
      $this->STC_Fundreporting->deltrigger($trg);
      }

    function download(){
      $this->load->helper('download');
      $data = file_get_contents("./misc/excelFile/sample.xlsx");
      $name = 'sample.xlsx';

      force_download($name, $data);
    }

    function update() {
      // $this->output->enable_profiler(TRUE);
      $id = $this->phpsession->get('id', 'stc');
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }
      if($this->input->post('dateOfIssue')!=''){
        $dateOfIssue = $this->input->post('dateOfIssue');
      }else{
        $dateOfIssue = NULL;
      }
      if($this->input->post('fixedDate')!=''){
        $fixedDate = $this->input->post('fixedDate');
      }else{
        $fixedDate = NULL;
      }
      if($this->input->post('dueDate')!=''){
        $dueDate = $this->input->post('dueDate');
      }else{
        $dueDate = NULL;
      }
      if($this->input->post('type')!=''){
        $type = $this->input->post('type');
      }else{
        $type = NULL;
      }
      if($this->input->post('bankType')!=''){
        $bankType = $this->input->post('bankType');
      }else{
        $bankType = NULL;
      }
      if($this->input->post('requisition')!=''){
        $requisition = $this->input->post('requisition');
      }else{
        $requisition = NULL;
      }
      if($this->input->post('deposit')!=''){
        $deposit = $this->input->post('deposit');
      }else{
        $deposit = NULL;
      }
      if($this->input->post('withdraw')!=''){
        $withdraw = $this->input->post('withdraw');
      }else{
        $withdraw = NULL;
      }
      if($this->input->post('endUser')!=''){
        $endUser = $this->input->post('endUser');
      }else{
        $endUser = NULL;
      }
      $idx = $this->input->post('idx');
      if($this->input->post('bankType')!=''){
        $bankType = $this->input->post('bankType');
      }else{
        $bankType = NULL;
      }
      $customer = $this->input->post('customer');
      $breakdown = $this->input->post('breakdown');

      // $this->load->Model('STC_Fundreporting');
      $data = array(
        'dateOfIssue' => $dateOfIssue,
        'fixedDate' => $fixedDate,
        'dueDate' => $dueDate,
        'type' => $type,
        'bankType' => $bankType,
        'customer' => $customer,
        'endUser' => $endUser,
        'breakdown' => $breakdown,
        'requisition' => $requisition,
        'deposit' => $deposit,
        'withdraw' => $withdraw,
        'company' => $company,
        'id' => $id,
        'modifyDate' => date("Y-m-d H:i:s")
      );
    $updateResult=$this->STC_Fundreporting->update($data, $idx);
    $bankBookUpdateResult = $this->STC_Fundreporting->bankbookupdate($company);
    if ($updateResult=='true' && $bankBookUpdateResult == 'true'){
      echo json_encode("true");
    } else {
      echo json_encode("false");
    }
    }

    function insert() {
      $id = $this->phpsession->get('id', 'stc');
      $get = $this->input->get('company');

      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }
      if($this->input->post('dateOfIssue')!=''){
        $dateOfIssue = $this->input->post('dateOfIssue');
      }else{
        $dateOfIssue = NULL;
      }
      if($this->input->post('fixedDate')!=''){
        $fixedDate = $this->input->post('fixedDate');
      }else{
        $fixedDate = NULL;
      }
      if($this->input->post('dueDate')!=''){
        $dueDate = $this->input->post('dueDate');
      }else{
        $dueDate = NULL;
      }
      if($this->input->post('type')!=''){
        $type = $this->input->post('type');
      }else{
        $type = NULL;
      }
      if($this->input->post('bankType')!=''){
        $bankType = $this->input->post('bankType');
      }else{
        $bankType = NULL;
      }
      if($this->input->post('requisition')!=''){
        $requisition = $this->input->post('requisition');
      }else{
        $requisition = NULL;
      }
      if($this->input->post('deposit')!=''){
        $deposit = $this->input->post('deposit');
      }else{
        $deposit = NULL;
      }
      if($this->input->post('withdraw')!=''){
        $withdraw = $this->input->post('withdraw');
      }else{
        $withdraw = NULL;
      }
      if($this->input->post('endUser')!=''){
        $endUser = $this->input->post('endUser');
      }else{
        $endUser = NULL;
      }
      if($this->input->post('bankType')!=''){
        $bankType = $this->input->post('bankType');
      }else{
        $bankType = NULL;
      }
      if($this->input->post('customer')!=''){
        $customer = $this->input->post('customer');
      }else{
        $customer = NULL;
      }
      if($this->input->post('breakdown')!=''){
        $breakdown = $this->input->post('breakdown');
      }else{
        $breakdown = NULL;
      }

      $link_seq = $this->input->post('link_seq');

      // $this->load->Model('STC_Fundreporting');
      $data = array(
        'dateOfIssue' => $dateOfIssue,
        'fixedDate'   => $fixedDate,
        'dueDate'     => $dueDate,
        'type'        => $type,
        'bankType'    => $bankType,
        'customer'    => $customer,
        'endUser'     => $endUser,
        'breakdown'   => $breakdown,
        'requisition' => $requisition,
        'deposit'     => $deposit,
        'withdraw'    => $withdraw,
        'company'     => $company,
        'id'          => $id,
      );
    $insertResult = $this->STC_Fundreporting->insert($data, $link_seq);
    $bankBookUpdateResult = $this->STC_Fundreporting->bankbookupdate($company);
    if ($insertResult=='true' && $bankBookUpdateResult == 'true'){
      echo json_encode("true");
    } else {
      echo json_encode("false");
    }

    }

    function insertbankbook(){
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }
      $insertType = $this->input->post('insertType');
      $insertBank= $this->input->post('insertBank');
      if($this->input->post('insertBankType') != ''){
        $insertBankType = $this->input->post('insertBankType');
      }else{
        $insertBankType = null;
      }
      if($this->input->post('insertAccount') != ''){
        $insertAccount = $this->input->post('insertAccount');
      }else{
        $insertAccount = null;
      }
      $insertBreakdown = $this->input->post('insertBreakdown');
      if($this->input->post('insertBalance')!=null){
        $insertBalance = $this->input->post('insertBalance');
      }else{
        $insertBalance = '0';
      }
      // $this->load->Model('STC_Fundreporting');
      $data = array(
        'type' => $insertType,
        'bank' => $insertBank,
        'banktype' => $insertBankType,
        'account' => $insertAccount,
        'breakdown' => $insertBreakdown,
        'balance' => $insertBalance,
        'company' => $company,
        'id' => $this->id
      );
    $result = $this->STC_Fundreporting->insertbankbook($data);
    echo json_encode($result);
    }

    function updatebankbook(){
      $get = $this->input->get('company');
      if($get){
        $company = $get;
      } else {
        $company = 'DUIT';
      }
      $updateIdx = $this->input->post('updateIdx');
      $updateType = $this->input->post('updateType');
      $updateBank= $this->input->post('updateBank');
      if($this->input->post('updateBankType') != ''){
        $updateBankType = $this->input->post('updateBankType');
      }else{
        $updateBankType = null;
      }
      if($this->input->post('updateAccount')){
        $updateAccount = $this->input->post('updateAccount');
      }else{
        $updateAccount =null;
      }
      $updateBreakdown = $this->input->post('updateBreakdown');
      $updateBalance = $this->input->post('updateBalance');

      // $this->load->Model('STC_Fundreporting');
      $data = array(
        'type' => $updateType,
        'bank' => $updateBank,
        'banktype' => $updateBankType,
        'account' => $updateAccount,
        'breakdown' => $updateBreakdown,
        'balance' =>$updateBalance,
        'company' => $company,
        'modifydate' => date("Y-m-d H:i:s"),
        'id' => $this->id
      );
    $result = $this->STC_Fundreporting->updatebankbook($data,$updateIdx);
    echo json_encode($result);
    }

    function deletebankbook(){
        $delBank = $this->input->post('delIdx');
        // $this->load->Model('STC_Fundreporting');

        $data = array(
          'idx' => $delBank
        );
        $result = $this->STC_Fundreporting->deletebankbook($data);
        echo json_encode($result);
      }

    function deluser(){
      $deluser = $this->input->post('delId');
      $delidx = $this->input->post('delIdx');
      // $this->load->Model('STC_Fundreporting');

      $data = array(
        'new_id' => $deluser
      );
      $result = $this->STC_Fundreporting->deluser($data,$delidx);
      // $result = $this->STC_Fundreporting->deluser($data);
      echo json_encode($result);
    }


      function search(){
        // $this->output->enable_profiler(TRUE);
        if( $this->id === null ) {
          redirect( 'account' );
        }
        $pGroupName =  $this->pGroupName;
        $group = $this->group;
        //패치 전 수정
        if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
          if ($pGroupName != '기술연구소' && $group != '기술2팀'){
            echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
          }
        }
        $data['pGroupName'] = $this->pGroupName;
        $get = $this->input->get('company');
        if($get){
          $company = $get;
        } else {
          $company = 'DUIT';
        }

        if(isset($_GET['old_new']) && $_GET['old_new'] != '') {
          $old_new = $_GET['old_new'];
        } else {
          $old_new = 'old';
        }
        if ($pGroupName == '영업본부') {
          $old_new = 'old';
        }
        $data['old_new'] = $old_new;

        if(isset($_POST['searchday'])){
          $searchday = $_POST['searchday'];
          $data['day'] = $_POST['searchday'];
          $searchday_url = "&searchday=".$searchday;
        } else if (isset($_GET['searchday'])){
          $searchday = $_GET['searchday'];
          $data['day'] = $_GET['searchday'];
          $searchday_url = "&searchday=".$searchday;
        } else {
          $searchday = "";
          $searchday_url = '';
        }

        $get2 = $this->input->get('sort');
        if($get2){
          $sort = $get2;
        } else {
          $sort = 'dueDate';
        }

        // $this->load->Model('STC_Fundreporting');
        $this->load->library('pagination');


        //검색 키워드
        if($this->input->post('submit')){
          $data['selectDate'] = $this->input->post('selectDate');
          $data['fromDate'] = $this->input->post('fromDate');
          $data['toDate'] = $this->input->post('toDate');
          $data['search1'] = $this->input->post('search1');
          $data['keyword1'] = $this->input->post('keyword1');
          $data['search2'] = $this->input->post('search2');
          $data['keyword2'] = $this->input->post('keyword2');
          $data['search3'] = $this->input->post('search3');
          $data['keyword3'] = $this->input->post('keyword3');
        //페이징시 submit 입력 값 유지위해 세션처리
          $sessionData = array(
            'selectDate' => $data['selectDate'],
            'fromDate' => $data['fromDate'],
            'toDate' => $data['toDate'],
            'search1' => $data['search1'],
            'keyword1' => $data['keyword1'],
            'search2' => $data['search2'],
            'keyword2' => $data['keyword2'],
            'search3' => $data['search3'],
            'keyword3' => $data['keyword3']
          );
          $this->session->set_userdata($sessionData);
          }
          else{
            $data['selectDate'] =  $this->session->userdata['selectDate'];
            $data['fromDate'] =  $this->session->userdata['fromDate'];
            $data['toDate'] =  $this->session->userdata['toDate'];
            $data['search1'] =  $this->session->userdata['search1'];
            $data['keyword1'] =  $this->session->userdata['keyword1'];
            $data['search2'] =  $this->session->userdata['search2'];
            $data['keyword2'] =  $this->session->userdata['keyword2'];
            $data['search3'] =  $this->session->userdata['search3'];
            $data['keyword3'] =  $this->session->userdata['keyword3'];
          };
        $list = $this->STC_Fundreporting->seachlist($data['selectDate'], $data['fromDate'], $data['toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2'], $data['search3'], $data['keyword3'], $company, $old_new, $sort);

        $data['fromDate'] = $list['fromDate'];
        $data['toDate'] = $list['toDate'];
//페이징
        //패치 전 수정
        $config['base_url'] = site_url().'/sales/fundreporting/search/page/';
        $config['total_rows'] = $list['num_rows'];
        // echo "수는".$config['total_rows'];
        $data['total_rows'] = $config['total_rows'];
        $config['per_page'] = 100;
        $config['uri_segment'] = 5;
        $config['num_links'] = 9;
        // $config['use_page_numbers'] = TRUE;
        $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
        $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
        $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
        $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
        $getUrl = '?company='.$company.'&old_new='.$old_new.'&sort='.$sort.$searchday_url;
        $config['suffix'] = $getUrl;
        $config['first_url'] = '1'.$getUrl;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(5,1);
          if($page > 1){
                $start = (($page / $config['per_page'])) * $config['per_page'];
          } else {
                $start = ($page - 1) * $config['per_page'];
          };
          $lastPage = ceil($config['total_rows'] / $config['per_page']);
        $limit = $config['per_page'];

        $data['company'] = $company;
        $data['pagination'] = $this->pagination->create_links();
        // $lists = $this->STC_Fundreporting->seachlist($data['selectDate'], $data['fromDate'], $data['toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2'], $start, $limit);
        // $list = $this->STC_Fundreporting->seachlist($data['selectDate'], $data['fromDate'], $data['toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);
        $data['list'] = $this->STC_Fundreporting->searchpaging($data['selectDate'], $data['fromDate'], $data['toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2'], $data['search3'], $data['keyword3'], $start, $limit,$company,$old_new,$sort);
        if($config['total_rows']<100){
          $data['pagingBalance'] = 0;
        } else if($page == ($lastPage-1)*100){
          $data['pagingBalance'] = 0;
        } else if($page==1){
          $limit = $config['total_rows'] - $config['per_page'];
          $data['pagingBalance'] = $this->STC_Fundreporting->pagingbalance($limit,$company,$old_new);
        } else {
          $limit = $config['total_rows'] - ($page + $config['per_page']);
          $data['pagingBalance'] = $this->STC_Fundreporting->pagingbalance($limit,$company,$old_new);
        }
        $data['set_balance'] = $this->STC_Fundreporting->set_balance($company, $old_new);
        // $data['row'] = $lists['row'];
        // echo "검색건수는 ".$data['row'];
        $data['bankList'] = $this->STC_Fundreporting->bankList($company);
        $data['selectBanklist'] = $this->STC_Fundreporting->selectbankbook($company);
        $data['selectBankTypeList'] = $this->STC_Fundreporting->selectbanktypelist($company);
        // $data['selectLoanBanklist']= $this->STC_Fundreporting->selectLoanAccount($company);
        // $data['selectSaveBanklist']= $this->STC_Fundreporting->selectSaveAccount($company);
        // $data['selectDepositBanklist']= $this->STC_Fundreporting->selectDepositAccount($company);
        $data['bankBook'] = $this->STC_Fundreporting->bankbook($company, $searchday);
        $data['bond'] = $this->STC_Fundreporting->bond($company, $searchday);
        $data['debt'] = $this->STC_Fundreporting->debt($company, $searchday);
        $data['bond_adjust'] = $this->STC_Fundreporting->bond_adjust($company, $searchday);
        $data['debt_adjust'] = $this->STC_Fundreporting->debt_adjust($company, $searchday);
        // $data['bond_adjust_minus'] = $this->STC_Fundreporting->bond_adjust_minus($company, $searchday);
        // $data['debt_adjust_minus'] = $this->STC_Fundreporting->debt_adjust_minus($company, $searchday);
        $data['sum_botong'] = $this->STC_Fundreporting->sum_botong($company, $searchday);
        $data['sum_not_botong'] = $this->STC_Fundreporting->sum_not_botong($company, $searchday);
        $data['sum_list_banktype'] = $this->STC_Fundreporting->sum_list_banktype($company, $searchday);

        $data['sumDeposit'] = $list['sumDeposit'];
        $data['sumWithdraw'] = $list['sumWithdraw'];
        $data['nsDeposit'] = $list['nsDeposit'];
        $data['nsWithdraw'] = $list['nsWithdraw'];

        $data['sumDeposit_adjust'] = $list['sumDeposit_adjust'];
        $data['sumWithdraw_adjust'] = $list['sumWithdraw_adjust'];
        $data['nsDeposit_adjust'] = $list['nsDeposit_adjust'];
        $data['nsWithdraw_adjust'] = $list['nsWithdraw_adjust'];
        $this->load->view( 'sales/fundreporting_list', $data);

      }

      // 일괄 수정
      // function search_modify() {
      //   $get = $this->input->get('company');
      //   if($get){
      //     $company = $get;
      //   } else {
      //     $company = 'DUIT';
      //   }
      //
      //   // $this->load->Model('STC_Fundreporting');
      //
      //   $data['selectDate'] = $this->input->post('selectDate');
      //   $data['search_fromDate'] = $this->input->post('search_fromDate');
      //   $data['search_toDate'] = $this->input->post('search_toDate');
      //   $data['search1'] = $this->input->post('search1');
      //   $data['keyword1'] = $this->input->post('keyword1');
      //   $data['search2'] = $this->input->post('search2');
      //   $data['keyword2'] = $this->input->post('keyword2');
      //   $data['modify_col'] = $this->input->post('modify_col');
      //   $data['modify_before'] = $this->input->post('modify_before');
      //   $data['modify_after'] = $this->input->post('modify_after');
      //
      //   $result = $this->STC_Fundreporting->search_modify($data['selectDate'], $data['search_fromDate'], $data['search_toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2'], $data['modify_col'], $data['modify_before'], $data['modify_after'], $company);
      //
      // }

      // 선택 바꾸기
      function search_modify() {
        $get = $this->input->get('company');

        // $this->load->Model('STC_Fundreporting');

        $idx = $this->input->post('idx');
        $modify_col = $this->input->post('modify_col');
        $modify_before = $this->input->post('modify_before');
        $modify_after = $this->input->post('modify_after');

        $result = $this->STC_Fundreporting->search_modify($idx, $modify_col, $modify_before, $modify_after);
      }



      function fundreporting_history_list(){
        // $this->output->enable_profiler(TRUE);
        $pGroupName =  $this->pGroupName;
        $group = $this->group;
        //패치 전 수정
        if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
          if ($pGroupName != '기술연구소' && $group != '기술2팀'){
            echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
          }
        }
        $data['pGroupName'] = $this->pGroupName;
        // $this->load->Model('STC_Fundreporting');
        $this->load->library('pagination');
        // 패치 전 수정
        $config['base_url'] = site_url().'/sales/fundreporting/fundreporting_history_list/page/';
        $config['total_rows'] = $this->STC_Fundreporting->history('count', '', '');
        $config['per_page'] = 100;
        $config['uri_segment'] = 5;
        $config['num_links'] = 9;
        $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
        $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
        $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
        $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
        $company = 'HIS_LIST';
        $getUrl = '?company='.$company;
        $config['suffix'] = $getUrl;
        $config['first_url'] = '1'.$getUrl;

        $this->pagination->initialize($config);
        $page = $this->uri->segment(5,1);
          if($page > 1){
                $start = (($page / $config['per_page'])) * $config['per_page'];
          } else {
                $start = ($page - 1) * $config['per_page'];
          }
        $lastPage = ceil($config['total_rows'] / $config['per_page']);
        $limit = $config['per_page'];

        $data['pagination'] = $this->pagination->create_links();
        $data['list'] = $this->STC_Fundreporting->history('', $start, $limit);


        $this->load->view( 'sales/fundreporting_history_list', $data);
      }

    function fundreporting_history_bank(){
        $pGroupName =  $this->pGroupName;
        $group = $this->group;
        //패치 전 수정
        if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
          if ($pGroupName != '기술연구소' && $group != '기술2팀'){
            echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
          }
        }
        $data['pGroupName'] = $this->pGroupName;
        // $this->load->Model('STC_Fundreporting');
        $this->load->library('pagination');
        // 패치 전 수정
        $config['base_url'] = site_url().'/sales/fundreporting/fundreporting_history_bank/page/';
        $config['total_rows'] = $this->STC_Fundreporting->hisbankbook('count', '', '');
        $config['per_page'] = 100;
        $config['uri_segment'] = 5;
        $config['num_links'] = 9;
        $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
        $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
        $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
        $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
        $company = 'HIS_BANK';
        $getUrl = '?company='.$company;
        $config['suffix'] = $getUrl;
        $config['first_url'] = '1'.$getUrl;
        // $getUrl = '?company='.$company;
        // $config['suffix'] = $getUrl;
        // $config['first_url'] = '1'.$getUrl;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(5,1);
          if($page > 1){
                $start = (($page / $config['per_page'])) * $config['per_page'];
          } else {
                $start = ($page - 1) * $config['per_page'];
          }
        $lastPage = ceil($config['total_rows'] / $config['per_page']);
        $limit = $config['per_page'];

        $data['pagination'] = $this->pagination->create_links();
        $data['hisbankbook'] = $this->STC_Fundreporting->hisbankbook('',$start, $limit);

        $this->load->view( 'sales/fundreporting_history_bank',$data);
      }


    function historysearch(){
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정
      if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
        if ($pGroupName != '기술연구소' && $group != '기술2팀'){
          echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
        }
      }
      $data['pGroupName'] = $this->pGroupName;
      //검색 키워드
      if($this->input->post('submit')){
        $data['modifyType'] = $this->input->post('modifyType');
        $data['company'] = $this->input->post('company');
        $data['fromModify'] = $this->input->post('fromModify');
        $data['toModify'] = $this->input->post('toModify');
        $data['selectDate'] = $this->input->post('selectDate');
        $data['fromDate'] = $this->input->post('fromDate');
        $data['toDate'] = $this->input->post('toDate');
        $data['search1'] = $this->input->post('search1');
        $data['keyword1'] = $this->input->post('keyword1');
        $data['search2'] = $this->input->post('search2');
        $data['keyword2'] = $this->input->post('keyword2');

        $sessionData = array(
          'modifyType' => $data['modifyType'],
          'company' => $data['company'],
          'fromModify' => $data['fromModify'],
          'toModify' => $data['toModify'],
          'selectDate' => $data['selectDate'],
          'fromDate' => $data['fromDate'],
          'toDate' => $data['toDate'],
          'search1' => $data['search1'],
          'keyword1' => $data['keyword1'],
          'search2' => $data['search2'],
          'keyword2' => $data['keyword2']
        );
        $this->session->set_userdata($sessionData);
        }
        else{
          $data['modifyType'] =  $this->session->userdata['modifyType'];
          $data['company'] =  $this->session->userdata['company'];
          $data['fromModify'] =  $this->session->userdata['fromModify'];
          $data['toModify'] =  $this->session->userdata['toModify'];
          $data['selectDate'] =  $this->session->userdata['selectDate'];
          $data['fromDate'] =  $this->session->userdata['fromDate'];
          $data['toDate'] =  $this->session->userdata['toDate'];
          $data['search1'] =  $this->session->userdata['search1'];
          $data['keyword1'] =  $this->session->userdata['keyword1'];
          $data['search2'] =  $this->session->userdata['search2'];
          $data['keyword2'] =  $this->session->userdata['keyword2'];
        };



      // $this->load->Model('STC_Fundreporting');
      $this->load->library('pagination');
      // 패치 전 수정
      $config['base_url'] = site_url().'/sales/fundreporting/historysearch/page/';
      $config['total_rows'] = $this->STC_Fundreporting->history_searchlist('count', '', '', $data['modifyType'], $data['company'], $data['fromModify'], $data['toModify'], $data['selectDate'], $data['fromDate'], $data['toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);
      $config['per_page'] = 100;
      $config['uri_segment'] = 5;
      $config['num_links'] = 9;
      $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
      $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
      $company = 'HIS_LIST';
      $getUrl = '?company='.$company;
      $config['suffix'] = $getUrl;
      $config['first_url'] = '1'.$getUrl;

      $this->pagination->initialize($config);
      $page = $this->uri->segment(5,1);
        if($page > 1){
              $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
              $start = ($page - 1) * $config['per_page'];
        }
      $lastPage = ceil($config['total_rows'] / $config['per_page']);
      $limit = $config['per_page'];

      $data['pagination'] = $this->pagination->create_links();
      $data['list'] = $this->STC_Fundreporting->history_searchlist('', $start, $limit, $data['modifyType'], $data['company'], $data['fromModify'], $data['toModify'], $data['selectDate'], $data['fromDate'], $data['toDate'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);


      $this->load->view( 'sales/fundreporting_history_list', $data);
    }

    function banksearch(){
      $pGroupName =  $this->pGroupName;
      $group = $this->group;
      //패치 전 수정
      if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
        if ($pGroupName != '기술연구소' && $group != '기술2팀'){
          echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
        }
      }
  //검색 키워드
  if($this->input->post('submit')){
    $data['cud'] = $this->input->post('cud');
    $data['old_company'] = $this->input->post('old_company');
    $data['fromModify'] = $this->input->post('fromModify');
    $data['toModify'] = $this->input->post('toModify');
    $data['search1'] = $this->input->post('search1');
    $data['keyword1'] = $this->input->post('keyword1');
    $data['search2'] = $this->input->post('search2');
    $data['keyword2'] = $this->input->post('keyword2');

    $sessionData = array(
      'cud' => $data['cud'],
      'old_company' => $data['old_company'],
      'fromModify' => $data['fromModify'],
      'toModify' => $data['toModify'],
      'search1' => $data['search1'],
      'keyword1' => $data['keyword1'],
      'search2' => $data['search2'],
      'keyword2' => $data['keyword2']
    );
    $this->session->set_userdata($sessionData);
    }
    else{
      $data['cud'] =  $this->session->userdata['cud'];
      $data['old_company'] =  $this->session->userdata['old_company'];
      $data['fromModify'] =  $this->session->userdata['fromModify'];
      $data['toModify'] =  $this->session->userdata['toModify'];
      $data['search1'] =  $this->session->userdata['search1'];
      $data['keyword1'] =  $this->session->userdata['keyword1'];
      $data['search2'] =  $this->session->userdata['search2'];
      $data['keyword2'] =  $this->session->userdata['keyword2'];
    };

    // $this->load->Model('STC_Fundreporting');
    $this->load->library('pagination');
    // 패치 전 수정
    $config['base_url'] = site_url().'/sales/fundreporting/banksearch/page/';
    $config['total_rows'] = $this->STC_Fundreporting->banksearch('count', '', '', $data['cud'], $data['old_company'], $data['fromModify'], $data['toModify'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);
    $config['per_page'] = 100;
    $config['uri_segment'] = 5;
    $config['num_links'] = 9;
    $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
    $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
    $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
    $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
    $company = 'HIS_BANK';
    $getUrl = '?company='.$company;
    $config['suffix'] = $getUrl;
    $config['first_url'] = '1'.$getUrl;

    $this->pagination->initialize($config);
    $page = $this->uri->segment(5,1);
      if($page > 1){
            $start = (($page / $config['per_page'])) * $config['per_page'];
      } else {
            $start = ($page - 1) * $config['per_page'];
      }
    $lastPage = ceil($config['total_rows'] / $config['per_page']);
    $limit = $config['per_page'];

    $data['pagination'] = $this->pagination->create_links();
    $data['hisbankbook'] = $this->STC_Fundreporting->banksearch('', $start, $limit, $data['cud'], $data['old_company'], $data['fromModify'], $data['toModify'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);


    $this->load->view( 'sales/fundreporting_history_bank', $data);
  }

  function fundreporting_page_log(){
     $pGroupName =  $this->pGroupName;
       $group = $this->group;
       //패치 전 수정
       if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
         if ($pGroupName != '기술연구소' && $group != '기술2팀'){
           echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
         }
       }

       //o
       $data['pGroupName'] = $this->pGroupName;
       // $this->load->Model('STC_Fundreporting');
       $this->load->library('pagination');
       // 패치 전 수정
       $config['base_url'] = site_url().'/sales/fundreporting/fundreporting_page_log/page/';
       $config['total_rows'] = $this->STC_Fundreporting->pagelog('count', '', '');
       $config['per_page'] = 100;
       $config['uri_segment'] = 5;
       $config['num_links'] = 9;
       $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
       $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
       $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
       $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
       $company = 'HIS_USER';
       $getUrl = '?company='.$company;
       $config['suffix'] = $getUrl;
       $config['first_url'] = '1'.$getUrl;

       // $getUrl = '?company='.$company;
       // $config['suffix'] = $getUrl;
       // $config['first_url'] = '1'.$getUrl;

       //o
       $this->pagination->initialize($config);
       $page = $this->uri->segment(5,1);
         if($page > 1){
               $start = (($page / $config['per_page'])) * $config['per_page'];
         } else {
               $start = ($page - 1) * $config['per_page'];
         }
       $lastPage = ceil($config['total_rows'] / $config['per_page']);
       $limit = $config['per_page'];

       $data['pagination'] = $this->pagination->create_links();
       $data['pagelog'] = $this->STC_Fundreporting->pagelog('',$start, $limit);
       $data['user'] = $this->STC_Fundreporting->user();

       $this->load->view( 'sales/fundreporting_page_log',$data);
}


function logsearch(){
  $pGroupName =  $this->pGroupName;
  $group = $this->group;
  //패치 전 수정
  if($pGroupName != '경영지원실' && $pGroupName != 'CEO' && $pGroupName != '영업본부'){
    if ($pGroupName != '기술연구소' && $group != '기술2팀'){
      echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
    }
  }
  //검색 키워드
  if($this->input->post('submit')){
  $data['fromModify'] = $this->input->post('fromModify');
  $data['toModify'] = $this->input->post('toModify');
  if( $this->input->post('search1') == '접속자'){
   $data['search1'] = 'id';
  };
  $data['keyword1'] = $this->input->post('keyword1');
  if( $this->input->post('search2') == '접속페이지'){
   $data['search2'] = 'page';
  };
  $data['keyword2'] = $this->input->post('keyword2');

  $sessionData = array(
   'fromModify' => $data['fromModify'],
   'toModify' => $data['toModify'],
   'search1' => $data['search1'],
   'keyword1' => $data['keyword1'],
   'search2' => $data['search2'],
   'keyword2' => $data['keyword2']
  );
  $this->session->set_userdata($sessionData);
  }
  else{
   $data['fromModify'] =  $this->session->userdata['fromModify'];
   $data['toModify'] =  $this->session->userdata['toModify'];
   $data['search1'] =  $this->session->userdata['search1'];
   $data['keyword1'] =  $this->session->userdata['keyword1'];
   $data['search2'] =  $this->session->userdata['search2'];
   $data['keyword2'] =  $this->session->userdata['keyword2'];
  };

  // $this->load->Model('STC_Fundreporting');
  $this->load->library('pagination');
  // 패치 전 수정
  $config['base_url'] = site_url().'/sales/fundreporting/logsearch/page/';
  $config['total_rows'] = $this->STC_Fundreporting->logsearch('count', '', '', $data['fromModify'], $data['toModify'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);
  $config['per_page'] = 100;
  $config['uri_segment'] = 5;
  $config['num_links'] = 9;
  $config['first_link'] = '<img src="/misc/img/dashboard/btn/btn_last_left.svg") width=20; height=20; style="vertical-align: top; "/>';
  $config['prev_link'] = '<img src="/misc/img/dashboard/btn/btn_left.svg") width=20; height=20; style="vertical-align: top;"/>';
  $config['next_link'] = '<img src="/misc/img/dashboard/btn/btn_right.svg") width=20; height=20; style="vertical-align: top; "/>';
  $config['last_link']='<img src="/misc/img/dashboard/btn/btn_last_right.svg") width=20; height=20; style="vertical-align: top; "/>';
  $company = 'HIS_USER';
  $getUrl = '?company='.$company;
  $config['suffix'] = $getUrl;
  $config['first_url'] = '1'.$getUrl;

  $this->pagination->initialize($config);
  $page = $this->uri->segment(5,1);
   if($page > 1){
         $start = (($page / $config['per_page'])) * $config['per_page'];
   } else {
         $start = ($page - 1) * $config['per_page'];
   }
  $lastPage = ceil($config['total_rows'] / $config['per_page']);
  $limit = $config['per_page'];

  $data['pagination'] = $this->pagination->create_links();
  $data['pagelog'] = $this->STC_Fundreporting->logsearch('', $start, $limit, $data['fromModify'], $data['toModify'], $data['search1'], $data['keyword1'], $data['search2'], $data['keyword2']);
  $data['user'] = $this->STC_Fundreporting->user();


  $this->load->view( 'sales/fundreporting_page_log', $data);
  }

  function login(){
    // $this->load->Model('STC_Fundreporting');
    $data['id'] = $this->id;
    $data['page'] = $this->input->get('company');
    $data['login_time'] = $this->input->post('login_time');
    $data['logout_time'] = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    $data['con'] = '비정상 로그아웃';
    $result = $this->STC_Fundreporting->login($data);
  }

  function logout(){
    // $this->load->Model('STC_Fundreporting');
    // $id = $this->id;
    // $userIdx = $this->STC_Fundreporting->userIdx($id);
    $data['id'] = $this->id;
    // $userIdx = $userIdx[0]->idx;
    $data['logout_time'] = date("Y-m-d H:i:s");
    $data['con'] = $this->input->post('con');
    $data['login_time'] = $this->input->post('login_time');
    $result = $this->STC_Fundreporting->logout($data);
  }

  function logout_close(){
    // $this->load->Model('STC_Fundreporting');
    // $id = $this->id;
    // $userIdx = $this->STC_Fundreporting->userIdx($id);
    $id = $this->id;
    $data['logout_time'] = $this->input->get('logout_time');
    $login_time = $this->input->get('login_time');
    $data['con'] = $this->input->get('con');
    $result = $this->STC_Fundreporting->logout_close($data,$login_time,$id);
  }

  function noreq(){
    // $this->load->Model('STC_Fundreporting');
    $data['id'] = $this->id;
    $data['login_time'] = $this->input->post('login_time');
    $data['logout_time'] = $this->input->post('logout_time');
    if($data['logout_time'] == ''){
      $data['logout_time'] = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    }
    $data['con'] = $this->input->post('con');

    $result = $this->STC_Fundreporting->noreq($data);
  }

  // 엑셀 다운로드
  function excel_download() {
    $get = $this->input->get('company');
    if($get){
      $company = $get;
    } else {
      $company = 'DUIT';
    }
    $page = $_GET['page'];
    if ($page=='search'){
      $get2 = $this->input->get('sort');
      if($get2){
        $sort = $get2;
      } else {
        $sort = 'dueDate';
      }

      $selectDate = $this->input->post('selectDate');
      $fromDate = $this->input->post('fromDate');
      $toDate = $this->input->post('toDate');
      $search1 = $this->input->post('search1');
      $keyword1 = $this->input->post('keyword1');
      $search2 = $this->input->post('search2');
      $keyword2 = $this->input->post('keyword2');
      $search3 = $this->input->post('search3');
      $keyword3 = $this->input->post('keyword3');

      $result = $this->STC_Fundreporting->excel_list_search($selectDate,$fromDate,$toDate,$search1,$keyword1,$search2,$keyword2,$search3,$keyword3,$company,$sort);
    } else {
      if ($page == 'fundreporting_list'){
        $result = $this->STC_Fundreporting->excel_list($company,'fundreporting_list');
      }
      if ($page == 'sort') {
        $result = $this->STC_Fundreporting->excel_list($company,'sort');
      }
      if ($page == 'enduser') {
        $result = $this->STC_Fundreporting->excel_list($company,'enduser');
      }
    }
    $result = array_reverse($result);

    echo json_encode($result);
  }

  function find_bill_target() {
    $bill_seq = $this->input->post('bill_seq');

    $result = $this->STC_Fundreporting->find_bill_target($bill_seq);

    echo json_encode($result);
  }

}
 ?>

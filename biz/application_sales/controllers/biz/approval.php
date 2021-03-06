<?php
header("Content-type: text/html; charset=utf-8");
class Approval extends CI_Controller {

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

        $this->load->model('biz/STC_Approval' );
        $this->load->model('biz/STC_Official_doc' );
        $this->load->model('tech/STC_Tech_doc' );
        $this->load->model('tech/STC_request_tech_support' );
        $this->load->model('sales/STC_Forcasting');
        $this->load->model('sales/STC_Maintain');
        $this->load->model('STC_Common' );
        $this->load->library('user_agent');
    }

    //양식관리 뷰
	function electronic_approval_form() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model('STC_Approval' );
		$data['group_data'] = $this->STC_Approval->parentGroup();
        $data['category'] = $this->STC_Approval->select_format_category();
        if($_GET['mode']=="modify"){
            $seq = $_GET['seq'];
            $data['view_val'] = $this->STC_Approval->approval_form_view($seq);
        }
        $data['approver_line'] = $this->STC_Approval->user_approval_line_select('admin');
        $data['form_management'] = $this->STC_Approval->form_management_select();
		$this->load->view( 'biz/electronic_approval_form',$data);
    }

    //양식관리 미리보기 팝업
	function electronic_approval_form_preview() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $data['preview_html_val'] = $this->input->post( 'preview_html_val' );
		$data['group_data'] = $this->STC_Approval->parentGroup();
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['approver_line'] = $this->STC_Approval->user_approval_line_select('admin');
		$this->load->view( 'biz/electronic_approval_form_preview',$data);
    }

    function electronic_approval_form_popup() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model( 'STC_Approval' );
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['td_id'] = $_POST['popup_id'];
        $data['multi'] = $_POST['popup_multi'];
        $data['template'] = $_POST['popup_template'];
		$this->load->view( 'biz/electronic_approval_form_popup',$data);
    }

    function electronic_approval_form_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval' );

        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else {
            $cur_page = 1;
        }

        $no_page_list = 10; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;

        $filter = '';
        if(isset($_GET['filter'])){
            $filter = $_GET['filter'];
        }
        $data['filter'] = $filter;
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_form_list($filter,$_GET['mode']);

        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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

        $data['mode'] = $_GET['mode'];

        if ($this->agent->is_mobile() && $_GET['mode'] != 'admin') {
          $data['title'] = '전자결재';
          $this->load->view( 'biz/electronic_approval_form_list_mobile', $data );
        } else {
          $this->load->view( 'biz/electronic_approval_form_list',$data);
        }
    }

    //기안문작성 뷰
    function electronic_approval_doc_input() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval' );

        $seq = $_GET['seq'];
        if($seq != "annual" && $seq != "attendance"){
            $data['view_val'] = $this->STC_Approval->approval_form_view($seq);
        }
        if(isset($_GET['sales_seq'])){
            $sales_seq = $_GET['sales_seq'];
            $data['sales_val'] = $this->STC_Forcasting->forcasting_view($sales_seq);		//기본
            $data['sales_val2'] = $this->STC_Forcasting->forcasting_view2($sales_seq);		//주사업자
            $data['sales_val3'] = $this->STC_Forcasting->forcasting_view3($sales_seq);		//제품명
            $data['sales_val4'] = $this->STC_Forcasting->forcasting_view4($sales_seq);   //제품 group by제품명,매입처
            $data['sales_val5'] = $this->STC_Forcasting->forcasting_view5($sales_seq);
        }else if(isset($_GET['maintain_seq'])){
            $maintain_seq=$_GET['maintain_seq'];
            $data['sales_val'] = $this->STC_Maintain->maintain_view($maintain_seq);		//기본
            $data['sales_val2'] = $this->STC_Maintain->maintain_view2($maintain_seq);	//주사업자
            $data['sales_val3'] = $this->STC_Maintain->maintain_view3($maintain_seq);	//유지보수 제품명
            $data['sales_val5'] = $this->STC_Maintain->maintain_view5($maintain_seq);	//통합유지보수 제품명
            $data['sales_val4'] = $this->STC_Maintain->maintain_view6($maintain_seq);   //제품 group by제품명,매입처
            $data['sales_bill'] = $this->STC_Maintain->maintain_sales_bill_view($maintain_seq); //매출 세금계산서
            $data['purchase_bill'] = $this->STC_Maintain->maintain_purchase_bill_groupby_view($maintain_seq);//매입 세금계산서
        } else if(isset($_GET['official_doc'])){
          $official_doc_seq = str_replace("_", ",", $_GET['official_doc']);
          $data['official_doc_seq'] = $official_doc_seq;
          $data['official_doc'] = $this->STC_Official_doc->official_doc_data($official_doc_seq);
        }

        $data['seq']= $seq;
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['user_approval_line'] = $this->STC_Approval->user_approval_line_select($this->id);
        $data['annual'] = $this->STC_Approval->annual($this->id,date("Y"));
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['user_info'] = $this->STC_Common->groupView("all");
        $data['user_group'] = $this->STC_Approval->user_group_mobile();
        $data['user_parents_group'] = $this->STC_Approval->user_parents_group_mobile();
        $data['depth1_user'] = $this->STC_Approval->depth1_user_mobile();
        $data['depth2_user'] = $this->STC_Approval->depth2_user_mobile();
        $data['corporation_card_num'] = $this->STC_Approval->corporation_card_num($this->id);

        //기지보 <-> 전자결재
        if(isset($_GET['tech_seq'])) {
          $tech_seq = $_GET['tech_seq'];
          $data['tech_data_val'] = $this->STC_Approval->tech_data($tech_seq);
        }

        if ($this->agent->is_mobile()) {
          $data['title'] = '전자결재';
          $this->load->view( 'biz/electronic_approval_doc_input_mobile',$data);
        } else {
          $this->load->view( 'biz/electronic_approval_doc_input',$data);
        }

    }

    //기안문 저장
    function electronic_approval_doc_input_action(){

        $this->load->helper('download');
        $type = $this->input->post( 'type' );
        $approval_form_seq = $this->input->post('approval_form_seq' );
        $write_date = date("Y-m-d H:i:s");
		    $writer_name = $this->input->post( 'writer_name' );
		    $writer_group = $this->input->post( 'writer_group' );
        $referrer = $this->input->post( 'referrer' );
        $approval_attach = $this->input->post( 'approval_attach' );
        $approval_tech_doc_attach = $this->input->post('approval_tech_doc_attach');
		    $approval_doc_name = $this->input->post( 'approval_doc_name' );
        $contents_html = $this->input->post( 'contents_html' );
        $editor_contents = $this->input->post( 'editor_contents' );
        $approval_doc_status = $this->input->post( 'approval_doc_status' );
        $person = $this->name.' '.$this->duty.' '.$this->group;
        $sales_seq = $this->input->post( 'sales_seq' );
        $req_support_seq = $this->input->post( 'req_support_seq' );
        $req_support_data = $this->input->post( 'req_support_data' );
        $req_file_real_name = $this->input->post( 'req_file_real_name' );
        $req_file_change_name = $this->input->post( 'req_file_change_name' );
        $official_doc_attach = $this->input->post( 'official_doc_attach' );
        $schedule_seq = $this->input->post( 'schedule_seq' ); //기술부일정 <-> 전자결재

        if($approval_tech_doc_attach != '') {
          $tech_arr = explode('::', $approval_tech_doc_attach);
          $tech_seq = $tech_arr[0];
        } else {
          $tech_seq = null;
        }

        $file_count = $_POST['file_length'];
        if($type == 1){
            $file_realname='';
            $file_changename='';
        }else{
            $file_realname = $_POST['file_realname'];
            $file_changename = $_POST['file_changename'];
        }

        if($file_count > 0){
            for($i=0; $i<$file_count; $i++){
                // $csize = $_FILES["files".$i]["size"];
                $f = "files".$i;
                $cname = $_FILES[$f]["name"];
                $ext = substr(strrchr($cname,"."),1);
                $ext = strtolower($ext);
                // if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp" && $ext != "xlsm") {
                //     echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
                //     exit;
                // }
                $upload_dir = "/var/www/html/stc/misc/upload/sales/electronic_approval";
                $conf_file['upload_path'] = $upload_dir;
                $conf_file['allowed_types'] = '*';
                $conf_file['overwrite']  = false;
                $conf_file['encrypt_name']  = true;
                $conf_file['remove_spaces']  = true;

                $this->load->library('upload', $conf_file );
                $result = $this->upload->do_upload($f);
                if($result) {
                  $file_data = array('upload_data' => $this->upload->data());
                  $file_realname .= '*/*'.$file_data['upload_data']['orig_name'];
                  $file_changename .= '*/*'.$file_data['upload_data']['file_name'];
                } else {
                  // alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
                  echo json_encode(false);
                  exit;
                }
            }

            $file_realname = trim($file_realname,'*/*');
            $file_changename = trim($file_changename,'*/*');
        }

        if ($req_file_real_name != '') {
          if ($file_realname == '') {
            $file_realname = $req_file_real_name;
          } else {
            $file_realname .= '*/*'.$req_file_real_name;
          }
        }
        if ($req_file_change_name != '') {
          $req_file_path = "/var/www/html/stc/misc/upload/tech/request_tech_support/";
          $upload_dir = "/var/www/html/stc/misc/upload/sales/electronic_approval/";
          $req_file_arr = explode('*/*', $req_file_change_name);
          for ($i=0; $i<count($req_file_arr); $i++) {
            // echo $req_file_path.$req_file_arr[$i]."<br>";
            if (file_exists($req_file_path.$req_file_arr[$i])) {
              // echo "복사파일 존재";
              copy($req_file_path.$req_file_arr[$i], $upload_dir.$req_file_arr[$i]);
            } else {
              // echo '복사파일 못찾음';
            }
          }
          if ($file_changename == '') {
            $file_changename = $req_file_change_name;
          } else {
            $file_changename .= '*/*'.$req_file_change_name;
          }
        }

        $doc_seq ='';

        if($type == 1){ //기안문작성 or 재기안
            $data = array(
                'approval_form_seq' =>$approval_form_seq,
                'write_date' => $write_date,
                'writer_name' => $writer_name,
                'writer_group' => $writer_group,
                'referrer' => $referrer,
                'approval_doc_name' =>$approval_doc_name,
                'contents_html' => $contents_html,
                'editor_contents' => $editor_contents,
                'file_realname' => $file_realname,
                'file_changename' => $file_changename,
                'approval_attach' => $approval_attach,
                'approval_tech_doc_attach' => $approval_tech_doc_attach,
                'official_doc_attach' => $official_doc_attach,
                'approval_doc_status' => $approval_doc_status,
                'writer_id' => $this->id,
                'insert_date' => date("Y-m-d H:i:s"),
                'sales_seq' => $sales_seq, //수주완료,유지보수에서 품의서 진행할때
                'req_support_seq' => $req_support_seq, //기술지원요청에서 품의서 진행할때
                'req_support_data' => $req_support_data, //기술지원요청에서 품의서 진행할때
                'schedule_seq' => $schedule_seq, //기술부일정 <-> 전자결재
                'tech_seq' => $tech_seq //기지보 <-> 전자결재
             );

            $doc_seq = $this->STC_Approval->electronic_approval_doc_insert( $data, $mode = 1);

            if ($req_support_seq != '') {
              $req_seq_arr = explode('_',$req_support_seq);
              for ($i=0; $i<count($req_seq_arr); $i++) {
                $this->STC_request_tech_support->req_support_approval_complete($doc_seq,$req_seq_arr[$i]);
              }
            }

            if ($official_doc_attach != '') {
              $oda_arr = explode('*/*', $official_doc_attach);
              for ($i=0; $i<count($oda_arr); $i++) {
                $oda_seq = explode('--', $oda_arr[$i]);
                $oda_seq = $oda_seq[0];
                $this->STC_Official_doc->official_doc_attach_approval($doc_seq, $oda_seq);
              }
            }

            // 던킨, 지출결의서 지출내역 저장
            if($approval_form_seq == 63 || $approval_form_seq == 6) {

              $expense_list_length = $this->input->post('expense_list_length');
              $expense_t_date = $this->input->post('expense_t_date');
              $expense_details = $this->input->post('expense_details');
              $expense_company = $this->input->post('expense_company');
              $expense_use_area = $this->input->post('expense_use_area');
              $expense_history_user = $this->input->post('expense_history_user');
              $expense_use_where = $this->input->post('expense_use_where');
              $expense_corporation_card = $this->input->post('expense_corporation_card');
              $expense_personal_card = $this->input->post('expense_personal_card');
              $expense_simple_receipt = $this->input->post('expense_simple_receipt');

              if($approval_form_seq == 63) {
                $expense_type = 'dunkin';
              } else {
                $expense_type = 'expense';
              }

              for($i = 0; $i < $expense_list_length; $i ++) {
                $data = array(
                  'approval_seq'     => $doc_seq,
                  't_date'           => $expense_t_date[$i],
                  'details'          => $expense_details[$i],
                  'company'          => $expense_company[$i],
                  'use_area'         => $expense_use_area[$i],
                  'history_user'     => $expense_history_user[$i],
                  'use_where'        => $expense_use_where[$i],
                  'corporation_card' => $expense_corporation_card[$i],
                  'personal_card'    => $expense_personal_card[$i],
                  'simple_receipt'   => $expense_simple_receipt[$i],
                  'user_id'          => $this->id,
                  'type'             => $expense_type
                );
                $this->STC_Approval->save_expense_list($data);
              }
            }

            if($approval_form_seq == 17 || $approval_form_seq == 74) {
              $expense_list_length = $this->input->post('expense_list_length');
              $expense_t_date = $this->input->post('expense_t_date');
              $expense_details = $this->input->post('expense_details');
              $expense_company = $this->input->post('expense_company');
              $expense_history_user = $this->input->post('expense_history_user');
              $expense_corporation_card = $this->input->post('expense_corporation_card');
              $expense_personal_card = $this->input->post('expense_personal_card');
              $expense_simple_receipt = $this->input->post('expense_simple_receipt');

              for($i = 0; $i < $expense_list_length; $i++) {
                $data = array(
                  'approval_seq'     => $doc_seq,
                  't_date'           => $expense_t_date[$i],
                  'details'          => $expense_details[$i],
                  'company'          => $expense_company[$i],
                  'history_user'     => $expense_history_user[$i],
                  'corporation_card' => $expense_corporation_card[$i],
                  'personal_card'    => $expense_personal_card[$i],
                  'simple_receipt'   => $expense_simple_receipt[$i],
                  'user_id'          => $this->id
                );
                $this->STC_Approval->save_expense_list_tech($data);
              }
            }

            // 연봉계약서
            if($approval_form_seq == 71) {
              $contract_year = $this->input->post('contract_year');
              $contracting_party = $this->input->post('contracting_party');
              $salary = $this->input->post('salary');

              $contracting_party_seq = $this->STC_Approval->find_user_seq($contracting_party);

              $data = array(
                'approval_seq'          => $doc_seq,
                'contracting_party_seq' => $contracting_party_seq['seq'],
                'contract_year'         => $contract_year,
                'salary'                => $salary,
              );
              $this->STC_Approval->save_salary_contract($data);
            }

            if($approval_form_seq == 75) {
              $purpose_of_use = $this->input->post('purpose_of_use');
              $required_date = $this->input->post('required_date');
              $doc_num1 = $this->input->post('doc_num1');

              $data = array(
                'approval_seq'   => $doc_seq,
                'doc_num1'       => $doc_num1,
                'purpose_of_use' => $purpose_of_use,
                'user_duty'      => $this->duty
              );

              $this->STC_Approval->save_employment_doc($data);
            }

            //연차신청서일 경우
            if($approval_form_seq == "annual"){
                $data = array(
                    'approval_doc_seq' => $doc_seq,
                    'annual_application_date' => $this->input->post( 'annual_application_date' ),
                    'annual_type' => $this->input->post( 'annual_type' ),
                    'annual_type2' => $this->input->post( 'annual_type2' ),
                    'annual_start_date' => $this->input->post( 'annual_start_date' ),
                    'annual_end_date' => $this->input->post( 'annual_end_date' ),
                    'annual_cnt' => $this->input->post( 'annual_cnt' ),
                    'annual_reason' => $this->input->post( 'annual_reason' ),
                    'user_id' => $this->id,
                    'auto_deligation' => $this->input->post( 'auto_deligation' ),
                    'insert_date' => date("Y-m-d H:i:s")
                );

                $functional_agent = $this->input->post('functional_agent');
                if($functional_agent != '') {
                  $functional_agent_seq = $this->STC_Approval->find_user_seq($functional_agent);
                }

                $data['functional_agent_seq'] = $functional_agent_seq['seq'];
                $data['functional_agent'] = $functional_agent;
                $data['annual_group'] = $this->group;

                $result = $this->STC_Approval->electronic_approval_annual_insert( $data, $mode = 1);

            }else if($approval_form_seq == "attendance"){//근태조정계
                $date = $this->input->post('attendance_date');
                $date = str_replace("-","",$date);
                $wstime = $this->input->post('ws_time');
                $wctime = $this->input->post('wc_time');
                if($wstime != ""){
                    $wstime = explode(':',$wstime);
                    $wstime = $date.(str_pad($wstime[0],2,"0",STR_PAD_LEFT)).$wstime[1]."00";
                }else{
                    $wstime = null;
                }

                if($wctime != ""){
                        $wctime = explode(':',$wctime);
                        $wctime = $date.(str_pad($wctime[0],2,"0",STR_PAD_LEFT)).$wctime[1]."00";
                }else{
                    $wctime = null;
                }

                $data = array(
                    'approval_doc_seq' => $doc_seq,
                    'attendance_seq' => $this->input->post( 'attendance_seq' ),
                    'cur_status' =>$this->input->post( 'attendance_cur_status' ),
                    'change_status' => $this->input->post( 'attendance_change_status' ),
                    'ws_time' => $wstime,
                    'wc_time' => $wctime,
                    'reason' => $this->input->post( 'attendance_reason' ),
                    'user_id' => $this->id,
                    'insert_date' => date("Y-m-d H:i:s")
                );
                $result = $this->STC_Approval->electronic_approval_attendance_insert( $data, $mode = 1);
            }
        }else{ //수정
            $seq = $this->input->post( 'seq' );
            $data = array(
                'seq' => $seq,
                'approval_form_seq' =>$approval_form_seq,
                'write_date' => $write_date,
                // 'writer_name' => $writer_name,
                // 'writer_group' => $writer_group,
                'referrer' => $referrer,
                'approval_doc_name' =>$approval_doc_name,
                'contents_html' => $contents_html,
                'editor_contents' => $editor_contents,
                'file_realname' => $file_realname,
                'file_changename' => $file_changename,
                'approval_attach' => $approval_attach,
                'approval_tech_doc_attach' => $approval_tech_doc_attach,
                'official_doc_attach' => $official_doc_attach,
                'approval_doc_status' => $approval_doc_status,
                'writer_id' => $this->id,
                'insert_date' => date("Y-m-d H:i:s")
             );
             $result = $this->STC_Approval->electronic_approval_doc_insert($data, $mode = 0);
             if($result){
                $doc_seq = $seq;
             }

             // 던킨, 지출결의서 지출내역 저장
             if($approval_form_seq == 63 || $approval_form_seq == 6) {

               $this->STC_Approval->delete_expense_list($doc_seq);

               $expense_list_length = $this->input->post('expense_list_length');
               $expense_t_date = $this->input->post('expense_t_date');
               $expense_details = $this->input->post('expense_details');
               $expense_company = $this->input->post('expense_company');
               $expense_use_area = $this->input->post('expense_use_area');
               $expense_history_user = $this->input->post('expense_history_user');
               $expense_use_where = $this->input->post('expense_use_where');
               $expense_corporation_card = $this->input->post('expense_corporation_card');
               $expense_personal_card = $this->input->post('expense_personal_card');
               $expense_simple_receipt = $this->input->post('expense_simple_receipt');

               if($approval_form_seq == 63) {
                 $expense_type = 'dunkin';
               } else {
                 $expense_type = 'expense';
               }

               for($i = 0; $i < $expense_list_length; $i ++) {
                 $data = array(
                   'approval_seq'     => $doc_seq,
                   't_date'           => $expense_t_date[$i],
                   'details'          => $expense_details[$i],
                   'company'          => $expense_company[$i],
                   'use_area'         => $expense_use_area[$i],
                   'history_user'     => $expense_history_user[$i],
                   'use_where'        => $expense_use_where[$i],
                   'corporation_card' => $expense_corporation_card[$i],
                   'personal_card'    => $expense_personal_card[$i],
                   'simple_receipt'   => $expense_simple_receipt[$i],
                   'user_id'          => $this->id,
                   'type'             => $expense_type
                 );
                 $this->STC_Approval->save_expense_list($data);
               }
             }

            if($approval_form_seq == 17 || $approval_form_seq == 74) {
              $this->STC_Approval->delete_expense_list_tech($doc_seq);

              $expense_list_length = $this->input->post('expense_list_length');
              $expense_t_date = $this->input->post('expense_t_date');
              $expense_details = $this->input->post('expense_details');
              $expense_company = $this->input->post('expense_company');
              $expense_history_user = $this->input->post('expense_history_user');
              $expense_corporation_card = $this->input->post('expense_corporation_card');
              $expense_personal_card = $this->input->post('expense_personal_card');
              $expense_simple_receipt = $this->input->post('expense_simple_receipt');

              for($i = 0; $i < $expense_list_length; $i++) {
                $data = array(
                  'approval_seq'     => $doc_seq,
                  't_date'           => $expense_t_date[$i],
                  'details'          => $expense_details[$i],
                  'company'          => $expense_company[$i],
                  'history_user'     => $expense_history_user[$i],
                  'corporation_card' => $expense_corporation_card[$i],
                  'personal_card'    => $expense_personal_card[$i],
                  'simple_receipt'   => $expense_simple_receipt[$i],
                  'user_id'          => $this->id
                );
                $this->STC_Approval->save_expense_list_tech($data);
              }
            }

            // 연봉계약서
            if($approval_form_seq == 71) {
              $contract_year = $this->input->post('contract_year');
              $contracting_party = $this->input->post('contracting_party');
              $salary = $this->input->post('salary');

              $contracting_party_seq = $this->STC_Approval->find_user_seq($contracting_party);

              $data = array(
                'approval_seq'          => $doc_seq,
                'contracting_party_seq' => $contracting_party_seq['seq'],
                'contract_year'         => $contract_year,
                'salary'                => $salary,
              );
              $this->STC_Approval->save_salary_contract($data);
            }

            if($approval_form_seq == 75) {
              $purpose_of_use = $this->input->post('purpose_of_use');
              $required_date = $this->input->post('required_date');
              $doc_num1 = $this->input->post('doc_num1');

              $data = array(
                'doc_num1'       => $doc_num1,
                'purpose_of_use' => $purpose_of_use,
                'user_duty'      => $this->duty
              );

              $this->STC_Approval->update_employment_doc($data, $doc_seq);
            }

            //연차신청서일 경우
            if($approval_form_seq == "annual"){
                $data = array(
                    'approval_doc_seq' => $doc_seq,
                    'annual_application_date' => $this->input->post( 'annual_application_date' ),
                    'annual_type' => $this->input->post( 'annual_type' ),
                    'annual_type2' => $this->input->post( 'annual_type2' ),
                    'annual_start_date' => $this->input->post( 'annual_start_date' ),
                    'annual_end_date' => $this->input->post( 'annual_end_date' ),
                    'annual_cnt' => $this->input->post( 'annual_cnt' ),
                    'annual_reason' => $this->input->post( 'annual_reason' ),
                    'user_id' => $this->id,
                    'auto_deligation' => $this->input->post('auto_deligation'),
                    'update_date' => date("Y-m-d H:i:s")
                );
                $result = $this->STC_Approval->electronic_approval_annual_insert( $data, $mode = 2);
            }else if($approval_form_seq == "attendance"){//근태조정계
                $date = $this->input->post('attendance_date');
                $date = str_replace("-","",$date);
                $wstime = $this->input->post('ws_time');
                $wctime = $this->input->post('wc_time');
                if($wstime != ""){
                    $wstime = explode(':',$wstime);
                    $wstime = $date.(str_pad($wstime[0],2,"0",STR_PAD_LEFT)).$wstime[1]."00";
                }else{
                    $wstime = null;
                }

                if($wctime != ""){
                        $wctime = explode(':',$wctime);
                        $wctime = $date.(str_pad($wctime[0],2,"0",STR_PAD_LEFT)).$wctime[1]."00";
                }else{
                    $wctime = null;
                }

                $data = array(
                    'approval_doc_seq' => $doc_seq,
                    'attendance_seq' => $this->input->post( 'attendance_seq' ),
                    'cur_status' =>$this->input->post( 'attendance_cur_status' ),
                    'change_status' => $this->input->post( 'attendance_change_status' ),
                    'ws_time' => $wstime,
                    'wc_time' => $wctime,
                    'reason' => $this->input->post( 'attendance_reason' ),
                    'user_id' => $this->id,
                    'update_date' => date("Y-m-d H:i:s")
                );
                $result = $this->STC_Approval->electronic_approval_attendance_insert( $data, $mode = 2);
            }
        }

        if($doc_seq){
            $result = true;
        }

        if(isset($_POST['test1']) && isset($_POST['test2'])){
            $approval_line_seq = explode(',',$_POST['test1']);
            $approval_line_type = explode(',',$_POST['test2']);

            for($i=0; $i<count($approval_line_seq); $i++){
                $result = $this->STC_Approval->electronic_approval_line_insert($doc_seq,$approval_line_seq[$i],$i,$approval_line_type[$i]);
            }
            if($approval_doc_status != "005"){//임시저장아닐때
                //첫번째 결재라인한테 승인요청 메일 보내줘야해
                if($result){
                    $mail_data = $this->STC_Approval->approval_line($doc_seq);
                    $mail_address = $mail_data[0]['user_email'];
                    $delegation_data = $this->STC_Approval->select_mandatary($mail_data[0]['user_id'],$write_date);
                    if( $delegation_data <> false ){
                      for($j = 0; $j<count($delegation_data); $j++){
                        $mail_address .= ";".$delegation_data[$j]['user_email'];
                      }
                    }
                    $mail_address = trim($mail_address,";");

                    if(trim($mail_address) != ""){

                        //메일 제목 작성
                        $subject = "[전자결재]결재문서 승인(참조)요청";
                        $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


                        //메일 본문 작성
                        $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                        <html xmlns='http://www.w3.org/1999/xhtml'>
                        <head>
                            <title>두리안정보기술센터-sales Center</title>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                        </head>
                        <body>";

                        $html_code .= "<h3>* [전자결재]결재문서 승인(참조)요청 알림 </h3>";

                        $html_code .=
                            "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
                                <tr>
                                    <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
                                    <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>전자결재</td>
                                </tr>
                                <tr>
                                    <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>제목</td>
                                    <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$approval_doc_name}</td>
                                </tr>";

                        $html_code .= "
                            <tr>
                                <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>기안일</td>
                                <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$write_date}</td>
                            </tr>
                            <tr>
                                <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>기안자</td>
                                <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$person}</td>
                            </tr>";


                        $html_code .= "</table>
                        <br><br><br>
                        <div style='width:100%;text-align:center;'>
                            <a href='http://sales.durianit.co.kr/index.php/biz/approval/electronic_approval_list?type=standby' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재대기함 바로가기</a>
                        </div>
                        </body>
                        </html>";

                        $body = str_replace("send_address",$mail_address,$html_code);

                        $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                        // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .= "Content-Transfer-Encoding: base64\r\n";

                        //메일 보내기
                        $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
                    }
                }
            }
        }

        echo json_encode($result);
    }

    //작성된 기안문 보기!
    function electronic_approval_doc_view() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $seq = $_GET['seq'];
        if(isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        }else{
            $data['type'] ="";
        }
        $data['seq']= $seq;
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_doc_view($seq);
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['cur_approval_line'] = $this->STC_Approval->cur_approval_line($seq);
        if(!empty($data['cur_approval_line'])){
            $data['next_approval_line'] = $this->STC_Approval->next_approval_line($seq,$data['cur_approval_line']['seq']);
        }
        $data['approval_line'] = $this->STC_Approval->approval_line($seq);
        $data['hold'] = $this->STC_Approval->approval_hold_select($seq);
        if(!empty($data['cur_approval_line'])){
            $data['mandatary'] = $this->STC_Approval->mandatary_whether($data['cur_approval_line']['user_id']);
        }
        $data['comment'] = $this->STC_Approval->approval_comment_select($seq);
        $data['delegation_info'] = $this->STC_Approval->delegation_info($this->seq);

        if($data['view_val']['approval_form_seq'] == 71) {
          $data['contract_party'] = $this->STC_Approval->contract_party_val($seq);
        }

        if(isset($data['contract_party']) && $data['contract_party']['contracting_party_seq'] == $this->seq) {
          $data['sign_confirm'] = 'Y';
        } else {
          $data['sign_confirm'] = 'N';
        }

        if($data['view_val']['approval_form_seq'] == 75) {
          $data['employment_doc'] = $this->STC_Approval->employment_doc_val($seq);
        }

        if ($this->agent->is_mobile()) {
          $data['title'] = '전자결재';
          $this->load->view( 'biz/electronic_approval_doc_view_mobile', $data );
        } else {
          $this->load->view( 'biz/electronic_approval_doc_view',$data);
        }
    }

    //기안문 미리보기!
    function electronic_approval_doc_preview() {
        // if( $this->id === null ) {
        //     redirect( 'account' );
        // }
        // $this->load->Model('STC_Approval' );
        $seq = $_GET['seq'];
        if(isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        }else{
            $data['type'] ="";
        }
        if(isset($_GET['mode'])) {
          $data['mode'] = $_GET['mode'];
        } else {
          $data['mode'] = 'attach';
        }
        $data['seq']= $seq;
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_doc_view($seq);
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['cur_approval_line'] = $this->STC_Approval->cur_approval_line($seq);
        if(!empty($data['cur_approval_line'])){
            $data['next_approval_line'] = $this->STC_Approval->next_approval_line($seq,$data['cur_approval_line']['seq']);
        }
        $data['approval_line'] = $this->STC_Approval->approval_line($seq);
        $data['hold'] =$this->STC_Approval->approval_hold_select($seq);
        if(!empty($data['cur_approval_line'])){
            $data['mandatary'] = $this->STC_Approval->mandatary_whether($data['cur_approval_line']['user_id']);
        }
        $data['comment'] = $this->STC_Approval->approval_comment_select($seq);
        $this->load->view( 'biz/electronic_approval_doc_preview',$data);
    }

    //재기안 수정 !
    function electronic_approval_doc_modify() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $seq = $_GET['seq'];
        if(isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        }else{
            $data['type'] ="";
        }
        $data['seq']= $seq;
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_doc_view($seq);
        $form_seq = $data['view_val']['approval_form_seq'];
        if($form_seq != 'annual') {
          $data['official_doc_yn'] = $this->STC_Official_doc->official_doc_yn($form_seq);
        } else {
          $data['official_doc_yn']['official_doc'] = 'N';
        }
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['cur_approval_line'] = $this->STC_Approval->cur_approval_line($seq);
        if(!empty($data['cur_approval_line'])){
            $data['next_approval_line'] = $this->STC_Approval->next_approval_line($seq,$data['cur_approval_line']['seq']);
        }
        $data['approval_line'] = $this->STC_Approval->approval_line($seq);
        $data['hold'] =$this->STC_Approval->approval_hold_select($seq);
        if(!empty($data['cur_approval_line'])){
            $data['mandatary'] = $this->STC_Approval->mandatary_whether($data['cur_approval_line']['user_id']);
        }
        $data['user_approval_line'] = $this->STC_Approval->user_approval_line_select($this->id);
        $data['user_info'] = $this->STC_Common->groupView("all");
        $data['corporation_card_num'] = $this->STC_Approval->corporation_card_num($this->id);

        $this->load->view( 'biz/electronic_approval_doc_modify',$data);
    }

    function electronic_approval_doc_list() {
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

        // $no_page_list = 15; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;

        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_doc_list_request($_GET['type'],$search_keyword);//진행중인고
        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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
        $data['type'] = $_GET['type'];
		$this->load->view( 'biz/electronic_approval_doc_list',$data);
    }

    //기결재 첨부 페이지 뷰
    function approval_attachment(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else {
            $cur_page = 1;
        }

        //check
        //필터
        if(isset($_GET['check'])) {
            $check = $_GET['check'];
        }
        else {
            $check = "";
        }
        $data['check']=$check;


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

        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_doc_list('attachment',$search_keyword);//완료된고
        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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

		$this->load->view( 'biz/approval_attachment',$data);
    }

    //결재 문서함
    function electronic_approval_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval' );
        $type= $_GET['type'];

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

        // $no_page_list = 15; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;

        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_list($type,$search_keyword,$this->seq,'list');//진행중인고
        $data['no_read_cnt_s'] = $this->STC_Approval->approval_list('standby',$search_keyword,$this->seq,'no_read_cnt');//진행중인고
        $data['no_read_cnt_p'] = $this->STC_Approval->approval_list('progress',$search_keyword,$this->seq,'no_read_cnt');//진행중인고
        $data['no_read_cnt_c'] = $this->STC_Approval->approval_list('completion',$search_keyword,$this->seq,'no_read_cnt');//진행중인고
        $data['no_read_cnt_b'] = $this->STC_Approval->approval_list('back',$search_keyword,$this->seq,'no_read_cnt');//진행중인고
        $data['no_read_cnt_r'] = $this->STC_Approval->approval_list('reference',$search_keyword,$this->seq,'no_read_cnt');//진행중인고
        $data['no_read_cnt_w'] = $this->STC_Approval->approval_list('wage',$search_keyword,$this->seq,'no_read_cnt');//진행중인고

        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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

        $data['type'] = $type;
        $data['user_seq'] = $this->seq;

        if($type == "standby"){
            $data['delegation'] = $this->STC_Approval->delegation_list();
          }

      if ($this->agent->is_mobile()) {
        $data['title'] = '전자결재';
        $this->load->view( 'biz/electronic_approval_list_mobile',$data);
      } else {
        $this->load->view( 'biz/electronic_approval_list',$data);
      }
    }

    //결재승인/반려 저장
    function approval_save(){
        $seq = $this->input->post('seq');
        $approval_form_seq = $this->input->post('approval_form_seq');
        $next_seq = $this->input->post('next_seq');
        $approval_status = $this->input->post('approval_status'); // N 이면 반려~
        $approval_opinion = $this->input->post('approval_opinion');
        $details = $this->input->post('details');
        $approval_doc_seq = $this->input->post('approval_doc_seq');
        $final_approval = $this->input->post('final_approval');
        $delegation_seq = $this->input->post('delegation_seq');
        $doc_subject = $this->input->post('doc_subject');
        $writer_id = $this->input->post('writer_id');
        $req_support_seq = $this->input->post('req_support_seq');
        $approval_seq = $this->input->post('approval_seq');
        $person = $this->name.' '.$this->duty.' '.$this->group;
        $approval_date = date("Y-m-d H:i:s");

        if($approval_status != ""){
            $data = array(
                'seq' => $seq,
                'approval_status' => $approval_status,
                'approval_opinion' => $approval_opinion,
                'details' => $details,
                'approval_date' => $approval_date ,
                'delegation_seq' => $delegation_seq

            );

            $result = $this->STC_Approval->approval_save($data,$next_seq);
        }else{ //결재취소할때임
            $approval_line = $this->STC_Approval->approval_line($approval_doc_seq);

            if($writer_id == $this->id){
                $next_step = 0;
            }else{
                foreach($approval_line as $ap){
                    if($ap['user_id'] == $this->id){
                       $next_step = (int)$ap['step']+1; //내 다음 결재라인
                    }
                }
            }

            if(isset($approval_line[$next_step])){
                if($approval_line[$next_step]['approval_status'] == ""){
                    $data = array(
                        'seq' => $seq,
                        'approval_doc_seq' => $approval_doc_seq,
                        'approval_status' => $approval_status,
                        'approval_opinion' => $approval_opinion,
                        'details' => $details,
                        'approval_date' => null,
                        'delegation_seq' => $delegation_seq
                    );
                    $result = $this->STC_Approval->approval_save($data,$next_seq);
                }else{
                    $result = false;
                }
            }
        }

        if($result){
            if($approval_status == "Y"){ //승인됐을때~
                $mail_data = $this->STC_Approval->approval_line($approval_doc_seq);
                $doc_data = $this->STC_Approval->approval_doc_view($approval_doc_seq);

                $mail_address = "";
                for($i=0; $i<count($mail_data); $i++){
                    if($mail_data[$i]['seq'] == $next_seq){
                        $mail_address .= ";".$mail_data[$i]['user_email'];
                        $delegation_data = $this->STC_Approval->select_mandatary($mail_data[$i]['user_id'],$approval_date);
                        if( $delegation_data <> false ){
                          for($j = 0; $j<count($delegation_data); $j++){
                            $mail_address .= ";".$delegation_data[$j]['user_email'];
                          }
                        }
                    }
                }
                $mail_address = trim($mail_address,";");
                if(trim($mail_address) != ""){
                    //메일 제목 작성
                    $subject = "[전자결재]결재문서 승인(참조)요청";
                    $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


                    //메일 본문 작성
                    $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                    <html xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                        <title>두리안정보기술센터-sales Center</title>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    </head>
                    <body>";

                    $html_code .= "<h3>* [전자결재]결재문서 승인(참조)요청 알림 </h3>";

                    $html_code .=
                        "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
                            <tr>
                                <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
                                <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>전자결재</td>
                            </tr>
                            <tr>
                                <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>제목</td>
                                <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_subject}</td>
                            </tr>";

                    $html_code .= "
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>기안일</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_data['write_date']}</td>
                        </tr>
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>기안자</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_data['writer_name']} {$doc_data['writer_group']}</td>
                        </tr>";

                    $html_code .= "</table>
                    <br><br><br>
                    <div style='width:100%;text-align:center;'>
                        <a href='http://sales.durianit.co.kr/index.php/biz/approval/electronic_approval_list?type=standby' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재대기함 바로가기</a>
                    </div>
                    </body>
                    </html>";

                    $body = str_replace("send_address",$mail_address,$html_code);

                    $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                    // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= "Content-Transfer-Encoding: base64\r\n";

                    //메일 보내기
                    $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
                }
            }
        }

        if($approval_status == "N" && $result){
            $data2 = array(
                'seq' => $approval_doc_seq,
                'completion_date' => $approval_date ,
                'approval_doc_status' => "003", //반려
                'update_id' => $this->id,
                'update_date' => $approval_date
            );
            $result = $this->STC_Approval->electronic_approval_doc_update($data2);

            if($approval_form_seq == "annual"){
                $data = array(
                    'approval_doc_seq' => $approval_doc_seq,
                    'annual_status' => "N" ,
                    'update_date' => $approval_date
                );
                $result = $this->STC_Approval->electronic_approval_annual_insert($data,2);
            }else if($approval_form_seq == "attendance"){
                $data = array(
                    'approval_doc_seq' => $approval_doc_seq,
                    'result' => "N" ,
                    'update_date' => $approval_date
                );
                $result = $this->STC_Approval->electronic_approval_attendance_insert($data,2);
            }

            //반려 되었을 때 메일 전송
            if($result){
                $mail_address = $writer_id."@durianit.co.kr";

                //메일 제목 작성
                $subject = "[전자결재]결재문서 반려";
                $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


                //메일 본문 작성
                $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                <html xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <title>두리안정보기술센터-sales Center</title>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                </head>
                <body>";

                $html_code .= "<h3>* [전자결재]결재문서 반려 알림 </h3>";

                $html_code .=
                    "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
                        <tr>
                            <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
                            <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>전자결재</td>
                        </tr>
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>제목</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_subject}</td>
                        </tr>";

                $html_code .= "
                    <tr>
                        <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>반려일</td>
                        <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$approval_date }</td>
                    </tr>
                    <tr>
                        <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>반려자</td>
                        <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$person}</td>
                    </tr>
                    <tr>
                        <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>반려의견</td>
                        <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$approval_opinion}</td>
                    </tr>";


                $html_code .= "</table>
                <br><br><br>
                <div style='width:100%;text-align:center;'>
                    <a href='http://sales.durianit.co.kr/index.php/biz/approval/electronic_approval_list?type=back' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>반려문서함 바로가기</a>
                </div>
                </body>
                </html>";

                $body = str_replace("send_address",$mail_address,$html_code);

                $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= "Content-Transfer-Encoding: base64\r\n";

                //메일 보내기
                $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
            }
        }

        //최종승인완료
        if($approval_status != "N" && $final_approval == "Y" && $result){
            $data2 = array(
                'seq' => $approval_doc_seq,
                'completion_date' => $approval_date ,
                'approval_doc_status' => "002", //완료
                'update_id' => $this->id,
                'update_date' => $approval_date
            );
            $result = $this->STC_Approval->electronic_approval_doc_update($data2);

            if($approval_form_seq == "annual"){
                $data = array(
                    'approval_doc_seq' => $approval_doc_seq,
                    'annual_status' => "Y" ,
                    'update_date' => $approval_date
                );
                $result = $this->STC_Approval->electronic_approval_annual_insert($data,2);

                $annual_data = $this->STC_Approval->electronic_approval_annual_select($approval_doc_seq);

                if($annual_data['annual_status'] == "Y" && $annual_data['annual_type'] == '003'){
                    $year = substr($annual_data['annual_start_date'], 0, 4);
                    $result =$this->STC_Approval->user_annual_update($annual_data['annual_cnt'],$annual_data['user_id'],$year);
                }

                //일정에 넣어주기
                $start_time = "09:00:00";
                $end_time = "18:00:00";
                if($annual_data['annual_type2'] == "001"){
                    $start_time = $annual_data['ws_time'];
                    $end_time =  $annual_data['wc_time'];
                }else if($annual_data['annual_type2'] == "002"){//오전반차
                    $start_time = $annual_data['ws_time'];
                    $end_time = strtotime($start_time."+4 hour");
                    $end_time = date('H:i:s',$end_time);
                }else if($annual_data['annual_type2'] == "003"){//오후반차
                    $start_time = strtotime($annual_data['wc_time']."-4 hour");
                    $start_time =date('H:i:s',$start_time);
                    $end_time = $annual_data['wc_time'];
                }
                // echo  $start_time;
                // echo  $end_time;
                // exit;
                $user_seq = $this->STC_Approval->user_seq($annual_data['user_id']);

                $schedule_data = array(
                    'start_day' => $annual_data['annual_start_date'],
                    'start_time' => $start_time,
                    'end_day' => $annual_data['annual_end_date'],
                    'end_time' => $end_time,
                    'work_name' => "휴가" ,
                    'work_type' => "general" ,
                    'participant' => $annual_data['user_name'],
                    'participant_seq' => $user_seq['seq'],
                    'user_id' => $annual_data['user_id'] ,
                    'user_name' => $annual_data['user_name'],
                    'group' => $annual_data['user_group'],
                    'p_group' => $annual_data['parentGroupName'],
                    'weekly_report' => "N",
                    'title' => "휴가/연차",
                    'insert_date' => $approval_date
                );

                $result = $this->STC_Approval->insert_schedule($schedule_data);

                // 자동 위임
                $auto_deligation = $annual_data['auto_deligation'];

                if($auto_deligation == 'Y') {
                  $functional_agent_seq = $annual_data['functional_agent'];
                  $delegation_data = array(
                    'delegate_group'  => $annual_data['annual_group'],
                    'start_date'        => $annual_data['annual_start_date'],
                    'end_date'          => $annual_data['annual_end_date'],
                    'mandatary'         => $annual_data['functional_agent'],
                    'mandatary_seq'     => $annual_data['functional_agent_seq'],
                    'delegation_reason' => '연차사용으로 인한 자동 등록',
                    'status'            => 'Y',
                    'write_id'          => $annual_data['user_id'],
                    'insert_date'       => date('Y-m-d H:i:s')
                  );

                  $result = $this->STC_Approval->delegation_save($delegation_data,1);
                }

            }else if ($approval_form_seq == "attendance"){
                $data = array(
                    'approval_doc_seq' => $approval_doc_seq,
                    'result' => "Y" ,
                    'update_date' => $approval_date
                );
                $result = $this->STC_Approval->electronic_approval_attendance_insert($data,2);
                $attendance_data = $this->STC_Approval->electronic_approval_attendance_select($approval_doc_seq);
                if($attendance_data['result'] == "Y"){
                    $data = array(
                        'seq' => $attendance_data['attendance_seq'],
                        'status' => $attendance_data['change_status'],
                        'ws_time' => $attendance_data['ws_time'],
                        'wc_time' => $attendance_data['wc_time'],
                        'update_time' => $approval_date,
                        'write_id' => "admin"
                    );
                    $result =$this->STC_Approval->user_attandance_update($data);
                }
            }


            // 기술지원 요청에서 작성된 기안문
            if ($req_support_seq != '') {
              $req_seq_arr = explode('_',$req_support_seq);
              for ($i=0; $i<count($req_seq_arr); $i++) {
                $this->STC_request_tech_support->req_support_approval_complete($approval_seq,$req_seq_arr[$i]);
              }
            }

            // 공문 승인 처리
            $official_doc_approval = $this->STC_Official_doc->official_doc_approval($approval_doc_seq);
            if(!empty($official_doc_approval)) {
              foreach($official_doc_approval as $oda) {
                $this->STC_Official_doc->official_doc_approve($oda['seq']);
              }
            }

            // 재직증명서 번호 발급
            if($approval_form_seq == 75) {
              $this->STC_Approval->employment_doc_approve($approval_doc_seq);
            }

            //최종승인 났을 때 메일 결재라인 모두에게 전송해
            if($result){
                $mail_data = $this->STC_Approval->approval_line($approval_doc_seq);
                $mail_address = $writer_id."@durianit.co.kr";
                for($i=0; $i<count($mail_data); $i++){
                    $mail_address .= ";".$mail_data[$i]['user_email'];
                }
                $mail_address = trim($mail_address,";");

                if(trim($mail_address) != ""){

                    //메일 제목 작성
                    $subject = "[전자결재]결재문서 최종 승인";
                    $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


                    //메일 본문 작성
                    $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                    <html xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                        <title>두리안정보기술센터-sales Center</title>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    </head>
                    <body>";

                    $html_code .= "<h3>* [전자결재]결재문서 최종 승인 알림 </h3>";

                    $html_code .=
                        "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
                            <tr>
                                <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
                                <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>전자결재</td>
                            </tr>
                            <tr>
                                <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>제목</td>
                                <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_subject}</td>
                            </tr>";

                    $html_code .= "
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>결재일</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$approval_date }</td>
                        </tr>
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>결재자</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$person}</td>
                        </tr>
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>결재의견</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$approval_opinion}</td>
                        </tr>";


                    $html_code .= "</table>
                    <br><br><br>
                    <div style='width:100%;text-align:center;'>
                        <a href='http://sales.durianit.co.kr/index.php/biz/approval/electronic_approval_list?type=completion' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재완료함 바로가기</a>
                    </div>
                    </body>
                    </html>";

                    $body = str_replace("send_address",$mail_address,$html_code);

                    $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                    // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= "Content-Transfer-Encoding: base64\r\n";

                    //메일 보내기
                    $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
                }
            }
        }
        echo json_encode($result);
    }

    //결재회수
    function approval_withdraw(){
        $seq = $this->input->post('seq');
        $writer_id = $this->input->post('writer_id');
        $approval_line = $this->STC_Approval->approval_line($seq);

        if($writer_id == $this->id){
            $next_step = 0;
        }else{
            foreach($approval_line as $ap){
                if($ap['user_id'] == $this->id){
                   $next_step = (int)$ap['step']+1; //내 다음 결재라인
                }
            }
        }

        if(isset($approval_line[$next_step])){
            if($approval_line[$next_step]['approval_status'] == ""){
                $approval_form_seq = $this->input->post('approval_form_seq');
                $approval_doc_status = $this->input->post('approval_doc_status');
                $doc_subject = $this->input->post('doc_subject');
                $person = $this->name.' '.$this->duty.' '.$this->group;
                $approval_date = date("Y-m-d H:i:s");

                $data = array(
                    'seq' => $seq,
                    'approval_doc_status' => $approval_doc_status, //회수
                    'update_id' => $this->id,
                    'update_date' => $approval_date
                );


                $mail_data = $this->STC_Approval->approval_line($seq);
                $mail_address = $writer_id."@durianit.co.kr";
                for($i=0; $i<count($mail_data); $i++){
                    if($mail_data[$i]['assignment_date'] != ""){
                        $mail_address .= ";".$mail_data[$i]['user_email'];
                    }
                }
                $mail_address = trim($mail_address,";");

                //메일 제목 작성
                $subject = "[전자결재]결재문서 회수";
                $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


                //메일 본문 작성
                $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                <html xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <title>두리안정보기술센터-sales Center</title>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                </head>
                <body>";

                $html_code .= "<h3>* [전자결재]결재문서 회수 알림 </h3>";

                $html_code .=
                    "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
                        <tr>
                            <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
                            <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>전자결재</td>
                        </tr>
                        <tr>
                            <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>제목</td>
                            <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_subject}</td>
                        </tr>";

                $html_code .= "
                    <tr>
                        <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>회수일</td>
                        <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$approval_date }</td>
                    </tr>
                    <tr>
                        <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>회수자</td>
                        <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$person}</td>
                    </tr>";


                $html_code .= "</table>
                </body>
                </html>";

                $body = str_replace("send_address",$mail_address,$html_code);

                $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= "Content-Transfer-Encoding: base64\r\n";

                //메일 보내기
                $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
                if($result){
                    $result = $this->STC_Approval->electronic_approval_doc_update($data);
                    if($approval_form_seq == "annual"){//연차신청서
                        $data = array(
                            'approval_doc_seq' => $seq,
                            'annual_status'=>"N",
                            'update_date' => date("Y-m-d H:i:s")
                        );
                        $result = $this->STC_Approval->electronic_approval_annual_insert( $data, $mode = 2);
                    }else if($approval_form_seq == "attendance"){//근태조정계
                        $data = array(
                            'approval_doc_seq' => $seq,
                            'result' => "N",
                            'update_date' => date("Y-m-d H:i:s")
                        );
                        $result = $this->STC_Approval->electronic_approval_attendance_insert( $data, $mode = 2);
                    }
                }

            }else{
                $result = false;
            }
        }
        echo json_encode($result);
    }

    //결재 보류 처리
    function approval_hold(){
        $seq = $this->input->post('seq');
        $approval_doc_hold = $this->input->post('approval_doc_hold');
        $hold_opinion = $this->input->post('hold_opinion');
        $doc_subject = $this->input->post('doc_subject');
        $writer_id = $this->input->post('writer_id');
        $processing_date = date("Y-m-d H:i:s");
        $person = $this->name.' '.$this->duty.' '.$this->group;

        $data = array(
            'seq' => $seq,
            'approval_doc_hold' => $approval_doc_hold, //보류 여부
            'update_id' => $this->id,
            'update_date' => date("Y-m-d H:i:s")
        );

        $result = $this->STC_Approval->electronic_approval_doc_update($data);

        if($result && $approval_doc_hold == "Y"){
            $data2 = array(
                'approval_doc_seq' => $seq,
                'hold_status' => $approval_doc_hold, //보류 여부
                'holder' => $this->name, //보류자
                'user_group' => $this->group , //보류자
                'processing_date' => $processing_date,
                'hold_opinion' => $hold_opinion
            );
            $result = $this->STC_Approval->electronic_approval_hold_insert($data2,1);
        }else if($result && $approval_doc_hold == "N"){
            $data2 = array(
                'approval_doc_seq' => $seq,
                'hold_status' => $approval_doc_hold, //보류 여부
                'processing_date' => $processing_date
            );
            $result = $this->STC_Approval->electronic_approval_hold_insert($data2,0);
        }

        if($result){
            $mail_address = $writer_id."@durianit.co.kr";

            //메일 제목 작성
            if($approval_doc_hold == "Y"){
                $subject = "[전자결재]결재문서 보류";
            }else{
                $subject = "[전자결재]결재문서 보류해제";
            }
            $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";


            //메일 본문 작성
            $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            <head>
                <title>두리안정보기술센터-sales Center</title>
                <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            </head>
            <body>";
            if($approval_doc_hold == "Y"){
                $html_code .= "<h3>* [전자결재]결재문서 보류</h3>";
            }else{
                $html_code .= "<h3>* [전자결재]결재문서 보류해제</h3>";
            }
            $html_code .=
                "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
                    <tr>
                        <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
                        <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>전자결재</td>
                    </tr>
                    <tr>
                        <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>제목</td>
                        <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$doc_subject}</td>
                    </tr>";
            if($approval_doc_hold == "Y"){
                $html_code .= "
                <tr>
                    <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>보류일</td>
                    <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$processing_date}</td>
                </tr>
                <tr>
                    <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>보류자</td>
                    <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$person}</td>
                </tr>
                <tr>
                    <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>보류의견</td>
                    <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$hold_opinion}</td>
                </tr>";
            }else{
                $html_code .= "
                <tr>
                    <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>보류해제일</td>
                    <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$processing_date}</td>
                </tr>
                <tr>
                    <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>보류해제자</td>
                    <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$person}</td>
                </tr>";
            }

            $html_code .= "</table>
            <br><br><br>
            <div style='width:100%;text-align:center;'>
                <a href='http://sales.durianit.co.kr/index.php/biz/approval/electronic_approval_list?type=progress' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재진행함 바로가기</a>
            </div>
            </body>
            </html>";

            $body = str_replace("send_address",$mail_address,$html_code);

            $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
            // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= "Content-Transfer-Encoding: base64\r\n";

            //메일 보내기
            $result2 = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
            echo json_encode($result2);

        }

    }

    // 결재라인 문서확인시간 저장
    function approval_check_date_update(){
        // $this->load->Model('STC_Approval');
        $seq = $this->input->post('seq');
        $data = array(
            'seq' => $seq,
            'check_date' => date("Y-m-d H:i:s")
        );
        $result = $this->STC_Approval->electronic_approval_line_update($data);
        echo json_encode($result);
    }

    //사용자 결재선 저장
    function user_approval_line_save(){
        // $this->load->Model('STC_Approval');
        // $approval_line_name = $this->input->post('approval_line_name');
        // $approver_seq = $this->input->post('approver_seq');
        // $approval_type = $this->input->post('approval_type');
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        if($type == 1){
            $data = array(
                'approval_line_name' => $this->input->post('approval_line_name'),
                'approver_seq' => $this->input->post('approver_seq'),
                'approval_type' => $this->input->post('approval_type'),
                'user_id' => $user_id,
                'insert_date' => date("Y-m-d H:i:s")
            );
        }else if ($type == 2){
            $data = array(
                'seq' => $this->input->post('seq'),
                'approval_line_name' => $this->input->post('approval_line_name'),
                'approver_seq' => $this->input->post('approver_seq'),
                'approval_type' => $this->input->post('approval_type'),
                'user_id' => $user_id,
                'update_date' => date("Y-m-d H:i:s")
            );
        }else if($type == 3){
            $data =  $this->input->post('seq');
        }

        $result = $this->STC_Approval->user_approval_line_save($data,$type);
        echo json_encode($result);
    }

    //사용자 결재선의 결재자 가져오기
    function user_approval_line_approver(){
        // $this->load->Model('STC_Approval');
        $user_seq = $this->input->post('user_seq');
        $result = $this->STC_Approval->select_user($user_seq);
        echo json_encode($result);
    }

    //위임 관리 뷰
    function electronic_approval_delegation_management(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval' );
        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else {
            $cur_page = 1;
        }

        $no_page_list = 10; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;
        $data['group_data'] = $this->STC_Approval->parentGroup();
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->electronic_approval_delegation_list();


        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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


        if ($this->agent->is_mobile()) {
          $data['title'] = '전자결재';
          // 참석자
          $data['depth1_user'] = $this->STC_Approval->depth1_user_mobile();
          $data['depth2_user'] = $this->STC_Approval->depth2_user_mobile();
          $data['user_parents_group'] = $this->STC_Approval->user_parents_group_mobile();
          $data['user_group'] = $this->STC_Approval->user_group_mobile();

          $this->load->view( 'biz/electronic_approval_delegation_management_mobile',$data);
        } else {
          $this->load->view( 'biz/electronic_approval_delegation_management',$data);
        }
    }

    //위임등록
    function delegation_save(){
        // $this->load->Model('STC_Approval' );
        $delegate_group = $this->input->post('delegate_group');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $mandatary = $this->input->post('mandatary');
        $mandatary_seq = $this->input->post('mandatary_seq');
        $delegation_reason = $this->input->post('delegation_reason');

        $data = array(
            'delegate_group' => $delegate_group,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'mandatary' => $mandatary,
            'mandatary_seq' => $mandatary_seq,
            'delegation_reason' => $delegation_reason,
            'write_id' => $this->id,
            'insert_date' => date("Y-m-d H:i:s")
        );

        $result = $this->STC_Approval->delegation_save($data,1); // insert
        echo json_encode($result);
    }

    //위임설정해제
    function delegation_unset(){
        // $this->load->Model('STC_Approval' );
        $check_seq = $this->input->post('check_seq');
        $result = $this->STC_Approval->delegation_save($check_seq,2); // 설정해제
        echo json_encode($result);
    }

    //위임 상세보기
    function delegation_detail_view(){
        // $this->load->Model('STC_Approval');
        $seq = $this->input->post('seq');
        $result = $this->STC_Approval->delegation_detail_view($seq); // 설정해제
        echo json_encode($result);
    }

    //개인보관함 관리 뷰
    function electronic_approval_personal_storage(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval');
        $data['view_val'] = $this->STC_Approval->electronic_approval_personal_storage_select('all');
        if($this->agent->is_mobile()) {
          $data['title'] = '전자결재';
          $this->load->view( 'biz/electronic_approval_personal_storage_mobile',$data);
        } else {
          $this->load->view( 'biz/electronic_approval_personal_storage',$data);
        }
    }

    //개인보관함 팝업 뷰
    function electronic_approval_personal_storage_popup(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval');
        $data['view_val'] = $this->STC_Approval->electronic_approval_personal_storage_select('all');
        $this->load->view( 'biz/electronic_approval_personal_storage_popup',$data);
    }

    //개인보관함 리스트 뷰
    function electronic_approval_personal_storage_list(){
        $seq = $_GET['seq'];
        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else {
            $cur_page = 1;
        }

        $no_page_list = 10; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;

        $data['view_val'] = $this->STC_Approval->electronic_approval_personal_storage_select('all');
        $data['view_val2'] = $this->STC_Approval->electronic_approval_personal_storage_list($seq);
        $data['category'] = $this->STC_Approval->select_format_category();

        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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

        $data['seq'] = $seq;

        $this->load->view( 'biz/electronic_approval_personal_storage_list',$data);
    }

    //개인보관함 저장
    function storageSave(){
        // $this->load->Model('STC_Approval' );
        $type = $this->input->post('type');

        if($type == 1){ //추가
            $data = array(
                'user_id' => $this->id,
                'storage_name' => $this->input->post('storage_name'),
                'parent_id' => $this->input->post('parent_id'),
                'insert_date' => date("Y-m-d H:i:s")
            );
            $result = $this->STC_Approval->storageSave($data,$type); // 개인보관함 추가
        }else if($type == 2){ //수정
            $data = array(
                'seq'=> $this->input->post('seq'),
                'storage_name' => $this->input->post('storage_name'),
                'update_date' => date("Y-m-d H:i:s")
            );
            $result = $this->STC_Approval->storageSave($data,$type); // 개인보관함 수정
        }else if($type == 3){ //삭제
            $seq = $this->input->post('seq');
            $result = $this->STC_Approval->storageSave($seq,$type); // 개인보관함 수정
        }

        echo json_encode($result);
    }

    //개인보관함 세부 목록
    function storageView(){
        // $this->load->Model('STC_Approval' );
        $seq = $this->input->post('seq');
        $result = $this->STC_Approval->electronic_approval_personal_storage_select($seq); //개인보관함 폴더 하위목록
        echo json_encode($result);
    }

    //완료문서 개인보관함 저장
    function saveToPersonalStorage(){
        // $this->load->Model('STC_Approval' );
        $seq = $this->input->post('seq');
        $save_doc_seq = $this->input->post('save_doc_seq');
        $data = array(
            'seq'=> $seq,
            'save_doc_seq' => $save_doc_seq,
            'update_date' => date("Y-m-d H:i:s")
        );
        $result = $this->STC_Approval->storageSave($data,4);
        echo json_encode($result);
    }

    //개인보관함 저장 문서 삭제
    function storage_doc_delete(){
        // $this->load->Model('STC_Approval');
        $seq = $this->input->post('storage_seq');
        $delete_doc_seq = $this->input->post('delete_doc_seq');
        $result = $this->STC_Approval->storage_doc_delete($seq,$delete_doc_seq);
        echo json_encode($result);
    }

    //댓글 저장
    function commentSave(){
        // $this->load->Model('STC_Approval');
        $type = $this->input->post('type');
        if($type == 0){
            $approval_doc_seq = $this->input->post('approval_doc_seq');
            $contents = $this->input->post('contents');
            $data = array(
                'approval_doc_seq'=> $approval_doc_seq,
                'contents' => $contents,
                'user_id' => $this->id,
                'user_name' => $this->name,
                'insert_date' => date("Y-m-d H:i:s"),
                'update_date' => date("Y-m-d H:i:s")
            );
            $result = $this->STC_Approval->commentSave($data,$type);
        }else if($type == 1){
            $contents = $this->input->post('contents');
            $comment_seq = $this->input->post('comment_seq');
            $data = array(
                'seq'=> $comment_seq,
                'contents' => $contents,
                'user_id' => $this->id,
                'user_name' => $this->name,
                'update_date' => date("Y-m-d H:i:s")
            );
            $result = $this->STC_Approval->commentSave($data,$type);
        }else{
            $data = $this->input->post('comment_seq');
            $result = $this->STC_Approval->commentSave($data,$type);
        }

        echo json_encode($result);
    }

    //form 즐겨찾기
    function form_bookmark(){
        // $this->load->Model('STC_Approval');
        $seq = $this->input->post('seq');
        $id = $this->id;
        $type = $this->input->post('type');
        $result = $this->STC_Approval->form_bookmark($seq,$id,$type);
        echo json_encode($result);
    }

    //서식함관리 뷰
    function electronic_approval_format_category() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval' );
		$data['group_data'] = $this->STC_Approval->parentGroup();
        $data['category'] = $this->STC_Approval->select_format_category();

        if($this->agent->is_mobile()) {
          $data['title'] = '전자결재';
          $this->load->view( 'biz/electronic_approval_format_category_mobile',$data);
        } else {
          $this->load->view( 'biz/electronic_approval_format_category',$data);
        }
    }

    //서식함 수정,삭제
    function format_category_modify(){
        // $this->load->Model('STC_Approval');
        $type = $this->input->post('type');
        if($type == 0){//추가
            $data = array(
                'category_name' => $this->input->post('category_name')
            );
        }else if($type == 1){//수정
            $data = array(
                'seq'=> $this->input->post('seq'),
                'category_name' => $this->input->post('category_name')
            );
        }else if($type == 2){//삭제
            $data = array(
                'seq'=> $this->input->post('seq')
            );
        }else{//idx 순서바꿈
            $data = array(
                'seq'=> $this->input->post('seq'),
                'idx'=> $this->input->post('idx')
            );
        }

        $result = $this->STC_Approval->format_category_modify($type,$data);
        echo json_encode($result);
    }

    //기안문 수정
    function electronic_approval_doc_modify_action(){
        // $this->load->Model('STC_Approval');
        $type = $this->input->post('type');
        if($type == 1){
            $data = array(
                'seq'=> $this->input->post('seq'),
                'referrer' => $this->input->post('referrer')
            );
        }
        $result = $this->STC_Approval->electronic_approval_doc_update($data);
        echo json_encode($result);
    }

    //결재선 관리 뷰
    function electronic_approver_line_management() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval' );
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['view_val'] = $this->STC_Approval->user_approval_line_select("admin");
		$this->load->view( 'biz/electronic_approver_line_management',$data);
    }

    //결재선 관리 리스트 뷰
    function electronic_approver_line_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_Approval');
        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        } else {
            $cur_page = 1;
        }

        $no_page_list = 10; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;

        $data['category'] = $this->STC_Approval->select_format_category();
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['view_val'] = $this->STC_Approval->user_approval_line_select("admin");

        if(!empty($data['view_val'])){
            $data['count'] = count($data['view_val']);
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

        // if($this->agent->is_mobile()) {
        //   $this->load->view( 'biz/electronic_approver_line_list_mobile',$data);
        // } else {
          $this->load->view( 'biz/electronic_approver_line_list',$data);
        // }
    }

    //결재복원
    function restore_approval(){
        // $this->load->Model('STC_Approval');
        $approval_doc_seq = $this->input->post('seq');
        $step =  $this->input->post('step');
        $step = explode(',',$step);
        $result = false;
        for($i=0; $i<count($step); $i++){
            $result = $this->STC_Approval->restore_approval($approval_doc_seq,$step[$i],$i);
        }
        echo json_encode($result);
    }

    //결재선 변경(관리자)
    function changeApproverLine(){
        // $this->load->Model('STC_Approval');
        $seq =  $this->input->post('seq');
        $delete_row_num =  $this->input->post('delete_row_num');
        $approval_line_seq = $this->input->post('approval_line_seq');
        $approval_line_type = $this->input->post('approval_line_type');

        $approval_line_seq = explode(',',$approval_line_seq);
        $approval_line_type = explode(',',$approval_line_type);

        $result = $this->STC_Approval->electronic_approval_line_delete($seq,$delete_row_num);

        for($i=0; $i<count($approval_line_seq); $i++){
            $result = $this->STC_Approval->electronic_approval_line_insert($seq,$approval_line_seq[$i],($i+$delete_row_num),$approval_line_type[$i]);
        }
        echo json_encode($result);
    }

    //보안설정 보안해제
    function security_setting(){
        // $this->load->Model('STC_Approval');
        $seq =  $this->input->post('seq');
        $approval_doc_security =  $this->input->post('approval_doc_security');
        $data = array(
            'seq'=> $seq,
            'approval_doc_security' => $approval_doc_security
        );
        $result = $this->STC_Approval->electronic_approval_doc_update($data);
        echo json_encode($result);
    }

    //기안문 삭제
    function electronic_approval_doc_delete(){
        // $this->load->Model('STC_Approval');
        $seq =  $this->input->post('seq');
        $result = $this->STC_Approval->electronic_approval_doc_delete($seq);
        echo json_encode($result);
    }

    //연차신청서 중복 체크
    function electronic_approal_annual_duplication_check(){
        // $this->load->Model('STC_Approval');
        $doc_seq = $this->input->post('doc_seq');
        $annual_start_date = $this->input->post('annual_start_date');
        $annual_end_date = $this->input->post('annual_start_date');
        $result = $this->STC_Approval->electronic_approal_annual_duplication_check($doc_seq,$annual_start_date,$annual_end_date,$this->id);
        echo json_encode($result);
    }

    //전자결재 프린트
    function electronic_approval_doc_print(){
        // $this->load->Model('STC_Approval');
        $data['seq'] = $_GET['seq'];
        $data['view_val'] = $this->STC_Approval->approval_doc_view($_GET['seq']);
        $this->load->view( 'biz/electronic_approval_doc_print',$data);
    }

    // 전자결재 양식 작성 결재정보 저장
	function approval_info_save(){
		// $this->load->Model(array('STC_Approval'));

		$seq = $this->input->post('seq');
		$template_name = $this->input->post('template_name');
		$template_category = $this->input->post('template_category');
		$template_type = $this->input->post('template_type');
		$official_doc = $this->input->post('official_doc');
		$template_use = $this->input->post('template_use');
        $template_sort_seq = $this->input->post('template_sort_seq');
		$template_explanation = $this->input->post('template_explanation');
		$default_approval_line = $this->input->post('default_approval_line');
		$default_referrer = $this->input->post('default_referrer');

		if($seq == ""){
			$data = array(
				'template_name' => $template_name,
				'template_category' => $template_category,
				'template_type' => $template_type,
				'official_doc' => $official_doc,
                'template_use' => $template_use,
				'template_sort_seq' => $template_sort_seq,
				'template_explanation' => $template_explanation,
				'default_approval_line' => $default_approval_line,
				'default_referrer' => $default_referrer,
                'insert_id' => $this->id,
				'write_id' => $this->id,
				'insert_date' =>date("Y-m-d H:i:s")
			);
			$result = $this->STC_Approval->approval_info_save($data,'insert');
		}else{
			$data = array(
				'seq' => $seq,
				'template_name' => $template_name,
				'template_category' => $template_category,
				'template_type' => $template_type,
				'official_doc' => $official_doc,
                'template_use' => $template_use,
				'template_sort_seq' => $template_sort_seq,
				'template_explanation' => $template_explanation,
				'default_approval_line' => $default_approval_line,
				'default_referrer' => $default_referrer,
				'write_id' => $this->id,
				'update_date' =>date("Y-m-d H:i:s")
			);
			$result = $this->STC_Approval->approval_info_save($data,'update');
		}
		echo json_encode($result);
	}

	//양식내용 저장
	function template_info_save(){
		// $this->load->Model(array('STC_Approval'));
		$seq = $this->input->post('seq');
		$editor_use = $this->input->post('editor_use');
		$writing_guide = $this->input->post('writing_guide');
		$form_table_html = $this->input->post('form_table_html');
		$preview_html = $this->input->post('preview_html');
        $template_use = $this->input->post('template_use');

		$data = array(
			'editor_use' => $editor_use,
			'writing_guide' => $writing_guide,
			'form_table_html' => $form_table_html,
			'preview_html' => $preview_html,
			'write_id' => $this->id,
			'update_date' =>date("Y-m-d H:i:s"),
            'template_use' => $template_use
		);

		$result = $this->STC_Approval->template_info_save($data,$seq);
		echo json_encode($result);
	}

    //기안문 양식 삭제
    function template_delete(){
        $seq = $this->input->post('seq');
        $result = $this->STC_Approval->template_delete($seq);
		echo json_encode($result);
    }

    //양식작성기 서식
    function form_management_save(){
        $type = $this->input->post('type');
        if($type == 0){ //insert
            $form_name = $this->input->post('form_name');
            $form_table_html = $this->input->post('form_table_html');
            $data = array(
                'form_name' => $form_name,
                'form_table_html' => $form_table_html,
                'write_id' => $this->id,
                'insert_date' => date("Y-m-d H:i:s")
            );
            $result = $this->STC_Approval->form_management_save($type,$data);
        }else if($type == 1){//update
            $seq = $this->input->post('seq');
            $form_name = $this->input->post('form_name');
            $form_table_html = $this->input->post('form_table_html');
            $data = array(
                'seq' => $seq,
                'form_name' => $form_name,
                'form_table_html' => $form_table_html,
                'write_id' => $this->id,
                'update_date' => date("Y-m-d H:i:s")
            );
            $result = $this->STC_Approval->form_management_save($type,$data);
        }else if ($type==2){//delete
            $seq = $this->input->post('seq');
            $result = $this->STC_Approval->form_management_save($type,$seq);
        }
        echo json_encode($result);
    }

    //결재선 seq로 불러와
    function approval_line_select(){
        $seq = $this->input->post('seq');
        $result = $this->STC_Approval->approval_line_select($seq);
        echo json_encode($result);
    }

    // 읽음 처리
    function read_doc() {
      $seq = $this->input->post('seq');
      $type = $this->input->post('type');
      $user_seq = $this->seq;

      $this->STC_Approval->read_doc($seq,$type,$user_seq);
    }

    // 전체 읽음 처리
    function all_read() {
      $type = $this->input->post('type');
      $user_seq = $this->seq;

      $result = $this->STC_Approval->all_read($type, $user_seq);

      echo json_encode($result);
    }

    // 검색어 수정
    function keyword_replace() {
      $keyword = $this->input->post('keyword');
      $category = $this->input->post('category');
      $page = $this->input->post('page');

      $result = $this->STC_Common->keyword_replace($keyword, $category, $page);

      echo json_encode($result);
    }

    // 엑셀 다운로드
    function electronic_approval_list_excel() {
      $type = $this->input->post('type');
      $search_keyword = $this->input->post('search_keyword');

      $data = $this->STC_Approval->approval_list($type,$search_keyword,$this->seq,'list');

      echo json_encode($data);
    }

    function expense_list_tech() {
      $attach_seq = $this->input->post('attach_seq');

      $data = $this->STC_Approval->expense_list_tech($attach_seq);

      echo json_encode($data);
    }

    function tech_doc_attachment() {
      if( $this->id === null ) {
          redirect( 'account' );
      }

      $type = 'Y';

      if(isset($_GET['cur_page'])) {
          $cur_page = $_GET['cur_page'];
      }
      else {
          $cur_page = 0;
              }                                                                                                               //      현재 페이지

      $no_page_list = 10;                                                                             //      한페이지에 나타나는 목록 개수

      //체크한 seq,mailaddr
      if(isset($_GET['mail_send'])) {
          $mail_send = $_GET['mail_send'];
      }
      else {
          $mail_send = "";
      }

      //체크한 고객사 가져올려고
      if(isset($_GET['seq'])) {
          $seq = $_GET['seq'];
      }
      else {
          $seq = "";
      }

    if($this->agent->is_mobile()) {
      if(isset($_GET['searchkeyword'])) {
          $search_keyword = $_GET['searchkeyword'];
      }
      else {
          $search_keyword = "";
      }
      if(isset($_GET['searchkeyword2'])) {
          $search_keyword2 = $_GET['searchkeyword2'];
      }
      else {
          $search_keyword2 = "";
      }

      if(isset($_GET['search1'])) {
          $search1 = $_GET['search1'];
      }
      else {
          $search1 = "";
      }

      $data['search_keyword'] = $search_keyword;
      $data['search_keyword2'] = $search_keyword2;
      $data['search1'] = $search1;
    } else {
      //검색내역들 form전송 받은거 searchkeyword로 받았다
      if(isset($_GET['searchkeyword'])) {
        $searchkeyword = $_GET['searchkeyword'];
      } else {
        $searchkeyword= '';
      }
      // $data['search_keyword'] = $search_keyword; //hidden으로 숨겨놓음
      // $data['search_keyword2'] = $search_keyword2; //hidden으로 숨겨놓음
      $data['searchkeyword'] = $searchkeyword;// 받아온 데이터
      // $data['search1'] = $search1;

      if(isset($_GET['excellent_report_yn'])) {
          $excellent_report_yn = $_GET['excellent_report_yn'];
      }
      else {
          $excellent_report_yn = "";
      }

      $data['excellent_report_yn'] = $excellent_report_yn;
    }

      $data['mail_send']=$mail_send;
      $data['seq']=$seq;
      if  ( $cur_page <= 0 )
          $cur_page = 1;
      $data['cur_page'] = $cur_page;

      if(isset($_GET['hashtag'])) { //해시태그 눌렀을때
        $hashtag = $_GET['hashtag'];
      } else {
        $hashtag = '';
      }

      $data['hashtag'] = $hashtag;

      // 빋아온 데이터($searchkeyword 모델로 넘김)
      // 페이징처리때문에 tech_doc_count모델에도 넘겨줘야(검색시 페이징 변화있으니)
      if($this->agent->is_mobile()) {
        $user_list_data = $this->STC_Tech_doc->tech_doc_list_mobile($type, $search_keyword,$search_keyword2, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_Tech_doc->tech_doc_list_count_mobile($type, $search_keyword, $search_keyword2, $search1)->ucount;
      } else {
        $user_list_data = $this->STC_Tech_doc->tech_doc_list($type, $searchkeyword, $hashtag, $excellent_report_yn, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_Tech_doc->tech_doc_list_count($type, $searchkeyword, $hashtag, $excellent_report_yn)->ucount;
      }
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
      $data['schedule_list'] = $this->STC_Tech_doc->schedule_list($this->seq);
      $data['type'] = $type;
      $data['product_company'] = $this->STC_Tech_doc->product_company();

      $this->load->view('biz/approval_tech_doc_attachment', $data);
    }

    function tech_doc_data() {
      $attach_seq = $this->input->post('attach_seq');

      $data = $this->STC_Tech_doc->tech_doc_view($attach_seq, 'Y');

      echo json_encode($data);
    }

    function salary_contract_print() {
      $seq = $this->input->get('seq');
      $data['approval_doc_seq'] = $seq;

      $this->load->view('biz/salary_contract_print', $data);
    }

    function salary_contract_pdf() {
      $seq = $this->input->get('seq');
      $salary_contract_data = $this->STC_Approval->salary_contract_data($seq);
      $data['approval_doc_seq'] = $seq;
      $data['salary_contract_data'] = $salary_contract_data;
      $data['contract_user_data'] = $this->STC_Approval->contract_user_data($salary_contract_data['contracting_party_seq']);
      $data['view_val'] = $this->STC_Approval->approval_doc_view($seq);

      $this->load->view('biz/salary_contract_pdf', $data);
    }

    function pwcheck() {
      $result = $this->STC_Approval->pwcheck($this->seq);

      echo json_encode($result);
    }

    function employment_doc_print() {
      $seq = $this->input->get('seq');
      $data['approval_doc_seq'] = $seq;

      $this->load->view('biz/employment_doc_print', $data);
    }

    function employment_doc_pdf() {
      $seq = $this->input->get('seq');
      $employment_doc_data = $this->STC_Approval->employment_doc_val($seq);
      $data['approval_doc_seq'] = $seq;
      $data['employment_doc_data'] = $employment_doc_data;
      $data['user_data'] = $this->STC_Approval->employment_doc_user_data($seq);
      $data['view_val'] = $this->STC_Approval->approval_doc_view($seq);

      $this->load->view('biz/employment_doc_pdf', $data);
    }
}
?>

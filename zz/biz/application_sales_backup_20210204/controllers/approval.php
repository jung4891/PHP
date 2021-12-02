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
        $this->at = $this->phpsession->get( 'at', 'stc' );
        $this->duty = $this->phpsession->get( 'duty', 'stc' );
        $this->company = $this->phpsession->get( 'company', 'stc' );
        $this->email = $this->phpsession->get('email','stc'); //김수성추가
        $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
        $this->group = $this->phpsession->get( 'group', 'stc' );
        $this->load->helper('form');
        $this->load->helper('url');
    }

    //양식관리 뷰
	function electronic_approval_form() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->model('STC_Approval' );
		$data['group_data'] = $this->STC_Approval->parentGroup();
        $data['category'] = $this->STC_Approval->select_format_category();
        if($_GET['mode']=="modify"){
            $seq = $_GET['seq'];
            $data['view_val'] = $this->STC_Approval->approval_form_view($seq);
        }
        $data['approver_line'] = $this->STC_Approval->user_approval_line_select('admin');
		$this->load->view( 'electronic_approval_form',$data);
    }
    
    function electronic_approval_form_popup() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model( 'STC_Approval' );
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['td_id'] = $_POST['popup_id'];
        $data['multi'] = $_POST['popup_multi'];
        $data['template'] = $_POST['popup_template'];
		$this->load->view( 'electronic_approval_form_popup',$data);
    }

    function electronic_approval_form_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );

        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else { 
            $cur_page = 1; 
        }
                                                                
        $no_page_list = 10; //10개씩 보여준다는고지
    
        $data['cur_page'] = $cur_page;

        $category = '';
        if(isset($_GET['category'])){
            $category = $_GET['category'];
        }
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_form_list($category);

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
		$this->load->view( 'electronic_approval_form_list',$data);
    }

    //기안문작성 뷰
    function electronic_approval_doc_input() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );
        
        $seq = $_GET['seq'];
        if($seq != "annual"){
            $data['view_val'] = $this->STC_Approval->approval_form_view($seq);
        }
        $data['seq']= $seq;
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['user_approval_line'] = $this->STC_Approval->user_approval_line_select($this->id);
        $data['annual'] = $this->STC_Approval->annual($this->id,date("Y"));
        $data['group_val'] = $this->STC_Approval->parentGroup();
		$this->load->view('electronic_approval_doc_input',$data);
    }

    //기안문 저장
    function electronic_approval_doc_input_action(){
        $this->load->model( 'STC_Approval' );
        $this->load->helper('download');
        $type = $this->input->post( 'type' );
        $approval_form_seq = $this->input->post('approval_form_seq' );
        $write_date = date("Y-m-d H:i:s");
		$writer_name = $this->input->post( 'writer_name' );
		$writer_group = $this->input->post( 'writer_group' );
        $referrer = $this->input->post( 'referrer' );
        $approval_attach = $this->input->post( 'approval_attach' );
		$approval_doc_name = $this->input->post( 'approval_doc_name' );
        $contents_html = $this->input->post( 'contents_html' );
        $editor_contents = $this->input->post( 'editor_contents' );
        $approval_doc_status = $this->input->post( 'approval_doc_status' );
        $person = $this->name.' '.$this->duty.' '.$this->group;

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
                if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
                    echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
                    exit;
                }
                $upload_dir = "/var/www/html/stc/misc/upload/sales/electronic_approval";
                $conf_file['upload_path'] = $upload_dir;
                $conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
                $conf_file['overwrite']  = false;
                $conf_file['encrypt_name']  = true;
                $conf_file['remove_spaces']  = true;
    
                $this->load->library('upload', $conf_file );
                $result = $this->upload->do_upload($f); 
                if($result) {
                    $file_data = array('upload_data' => $this->upload->data());
                    $file_realname .= ','.$file_data['upload_data']['orig_name'];
                    $file_changename .= ','.$file_data['upload_data']['file_name'];
                } else {
                    alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
                    exit;
                }
            }

            $file_realname = trim($file_realname,',');
            $file_changename = trim($file_changename,',');
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
                'approval_doc_status' => $approval_doc_status,
                'writer_id' => $this->id,
                'insert_date' => date("Y-m-d H:i:s")
             );

            $doc_seq = $this->STC_Approval->electronic_approval_doc_insert( $data, $mode = 1);
            
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
                    'insert_date' => date("Y-m-d H:i:s")
                );

                $result = $this->STC_Approval->electronic_approval_annual_insert( $data, $mode = 1);
            }
        }else{ //수정 
            $seq = $this->input->post( 'seq' );
            $data = array(
                'seq' => $seq,
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
                'approval_doc_status' => $approval_doc_status,
                'writer_id' => $this->id,
                'insert_date' => date("Y-m-d H:i:s")
             );
             $result = $this->STC_Approval->electronic_approval_doc_insert($data, $mode = 0);
             if($result){
                $doc_seq = $seq;
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
                    'update_date' => date("Y-m-d H:i:s")
                );
                $result = $this->STC_Approval->electronic_approval_annual_insert( $data, $mode = 2);
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

            //첫번째 결재라인한테 승인요청 메일 보내줘야해
            if($result){
                $mail_data = $this->STC_Approval->approval_line($doc_seq);
                $mail_address = $mail_data[0]['user_email'];
                $delegation_data = $this->STC_Approval->select_mandatary($mail_data[0]['user_id'],$write_date);
                for($j = 0; $j<count($delegation_data); $j++){
                    $mail_address .= ";".$delegation_data[$j]['user_email'];
                }
                $mail_address = trim($mail_address,";");
    
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
                    <a href='http://sales.durianit.co.kr/index.php/approval/electronic_approval_list?type=standby' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재대기함 바로가기</a>
                </div>
                </body>
                </html>";
    
                $body = str_replace("send_address",$mail_address,$html_code);
            
                $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n"; 
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= "Content-Transfer-Encoding: base64\r\n";
    
                //메일 보내기
                $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
            }
        }
        echo json_encode($result);
    }

    //작성된 기안문 보기!
    function electronic_approval_doc_view() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );

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
		$this->load->view( 'electronic_approval_doc_view',$data);
    }

    //기안문 미리보기!
    function electronic_approval_doc_preview() {
        // if( $this->id === null ) {
        //     redirect( 'account' );
        // }
        $this->load->model('STC_Approval' );
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
        $data['hold'] =$this->STC_Approval->approval_hold_select($seq);
        if(!empty($data['cur_approval_line'])){
            $data['mandatary'] = $this->STC_Approval->mandatary_whether($data['cur_approval_line']['user_id']);
        }
        $this->load->view( 'electronic_approval_doc_preview',$data);
    }

    //재기안 수정 !
    function electronic_approval_doc_modify() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );
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
        $this->load->view( 'electronic_approval_doc_modify',$data);
    }

    function electronic_approval_doc_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );

        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
			$cur_page = $_GET['cur_page'];
		}else { 
			$cur_page = 1; 
        }
        														
        $no_page_list = 10; //10개씩 보여준다는고지
    
        $data['cur_page'] = $cur_page;
	
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_doc_list($_GET['type']);//진행중인고
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
		$this->load->view( 'electronic_approval_doc_list',$data);
    }

    //기결재 첨부 페이지 뷰
    function approval_attachment(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );
        $data['view_val'] = $this->STC_Approval->approval_doc_list('002');//완료된고
        $data['category'] = $this->STC_Approval->select_format_category();
		$this->load->view( 'approval_attachment',$data);
    }

    //결재 문서함
    function electronic_approval_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );
        $type= $_GET['type'];

        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else { 
            $cur_page = 1; 
        }
                                                                
        $no_page_list = 10; //10개씩 보여준다는고지
    
        $data['cur_page'] = $cur_page;

        $data['category'] = $this->STC_Approval->select_format_category();
        $data['view_val'] = $this->STC_Approval->approval_list($type);//진행중인고

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

        if($type == "standby"){
            $data['delegation'] = $this->STC_Approval->delegation_list();  
          }
        $this->load->view('electronic_approval_list',$data);
    }

    //결재승인/반려 저장
    function approval_save(){
        $this->load->model('STC_Approval' );
        $seq = $this->input->post('seq');
        $approval_form_seq = $this->input->post('approval_form_seq');
        $next_seq = $this->input->post('next_seq');
        $approval_status = $this->input->post('approval_status'); //N 이면 반려~
        $approval_opinion = $this->input->post('approval_opinion');
        $approval_doc_seq = $this->input->post('approval_doc_seq');
        $final_approval = $this->input->post('final_approval');
        $delegation_seq = $this->input->post('delegation_seq');
        $doc_subject = $this->input->post('doc_subject');
        $writer_id = $this->input->post('writer_id');
        $person = $this->name.' '.$this->duty.' '.$this->group;
        $approval_date = date("Y-m-d H:i:s");

        if($approval_status != ""){
            $data = array(
                'seq' => $seq,
                'approval_status' => $approval_status,
                'approval_opinion' => $approval_opinion,
                'approval_date' => $approval_date ,
                'delegation_seq' => $delegation_seq

            );
        }else{ //결재취소할때임
            $data = array(
                'seq' => $seq,
                'approval_status' => $approval_status,
                'approval_opinion' => $approval_opinion,
                'approval_date' => null,
                'delegation_seq' => $delegation_seq
            );
        }

        $result = $this->STC_Approval->approval_save($data,$next_seq);

        if($result){
            if($approval_status == "Y"){ //승인됐을때~
                $mail_data = $this->STC_Approval->approval_line($approval_doc_seq);
                $doc_data = $this->STC_Approval->approval_doc_view($approval_doc_seq);
                
                $mail_address = "";
                for($i=0; $i<count($mail_data); $i++){
                    if($mail_data[$i]['seq'] == $next_seq){
                        $mail_address .= ";".$mail_data[$i]['user_email'];
                        $delegation_data = $this->STC_Approval->select_mandatary($mail_data[$i]['user_id'],$approval_date);
                        for($j = 0; $j<count($delegation_data); $j++){
                            $mail_address .= ";".$delegation_data[$j]['user_email'];
                        }
                    }
                }
                $mail_address = trim($mail_address,";");

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
                    <a href='http://sales.durianit.co.kr/index.php/approval/electronic_approval_list?type=standby' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재대기함 바로가기</a>
                </div>
                </body>
                </html>";

                $body = str_replace("send_address",$mail_address,$html_code);
            
                $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n"; 
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= "Content-Transfer-Encoding: base64\r\n";

                //메일 보내기
                $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
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
                    <a href='http://sales.durianit.co.kr/index.php/approval/electronic_approval_list?type=back' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>반려문서함 바로가기</a>
                </div>
                </body>
                </html>";
    
                $body = str_replace("send_address",$mail_address,$html_code);
            
                $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
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

                if($annual_data['annual_status'] == "Y"){
                    $year = substr($annual_data['annual_start_date'], 0, 4);  
                    $result =$this->STC_Approval->user_annual_update($annual_data['annual_cnt'],$annual_data['user_id'],$year);
                }


            }
            //최종승인 났을 때 메일 결재라인 모두에게 전송해
            if($result){
                $mail_data = $this->STC_Approval->approval_line($approval_doc_seq);
                $mail_address = $writer_id."@durianit.co.kr";
                for($i=0; $i<count($mail_data); $i++){
                    $mail_address .= ";".$mail_data[$i]['user_email']; 
                }
                $mail_address = trim($mail_address,";");
    
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
                    <a href='http://sales.durianit.co.kr/index.php/approval/electronic_approval_list?type=completion' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재완료함 바로가기</a>
                </div>
                </body>
                </html>";
    
                $body = str_replace("send_address",$mail_address,$html_code);
            
                $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
                $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n"; 
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= "Content-Transfer-Encoding: base64\r\n";
    
                //메일 보내기
                $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
            }
        }
        echo json_encode($result);
    }

    //결재회수 
    function approval_withdraw(){
        $this->load->model('STC_Approval' );
        $seq = $this->input->post('seq');
        $approval_doc_status = $this->input->post('approval_doc_status');
        $doc_subject = $this->input->post('doc_subject');
        $writer_id = $this->input->post('writer_id');
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
        $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "Content-Transfer-Encoding: base64\r\n";

        //메일 보내기
        $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);

        if($result){
            $result = $this->STC_Approval->electronic_approval_doc_update($data);
        }

        echo json_encode($result);
    }

    //결재 보류 처리
    function approval_hold(){
        $this->load->model('STC_Approval' );
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
                <a href='http://sales.durianit.co.kr/index.php/approval/electronic_approval_list?type=progress' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>결재진행함 바로가기</a>
            </div>
            </body>
            </html>";

            $body = str_replace("send_address",$mail_address,$html_code);
        
            $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
            $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
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
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
        $user_seq = $this->input->post('user_seq');
        $result = $this->STC_Approval->select_user($user_seq);
        echo json_encode($result);
    }

    //위임 관리 뷰
    function electronic_approval_delegation_management(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval' );
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

        $this->load->view('electronic_approval_delegation_management',$data);
    }
    
    //위임등록 
    function delegation_save(){
        $this->load->model('STC_Approval' );
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
        $this->load->model('STC_Approval' );
        $check_seq = $this->input->post('check_seq');
        $result = $this->STC_Approval->delegation_save($check_seq,2); // 설정해제
        echo json_encode($result);
    }

    //위임 상세보기
    function delegation_detail_view(){
        $this->load->model('STC_Approval');
        $seq = $this->input->post('seq');
        $result = $this->STC_Approval->delegation_detail_view($seq); // 설정해제
        echo json_encode($result);
    }

    //개인보관함 관리 뷰
    function electronic_approval_personal_storage(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval');
        $data['view_val'] = $this->STC_Approval->electronic_approval_personal_storage_select('all');
        $this->load->view('electronic_approval_personal_storage',$data);
    }

    //개인보관함 팝업 뷰
    function electronic_approval_personal_storage_popup(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval');
        $data['view_val'] = $this->STC_Approval->electronic_approval_personal_storage_select('all');
        $this->load->view('electronic_approval_personal_storage_popup',$data);
    }

    //개인보관함 리스트 뷰
    function electronic_approval_personal_storage_list(){
        $this->load->model('STC_Approval');
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

        $this->load->view('electronic_approval_personal_storage_list',$data);
    }

    //개인보관함 저장
    function storageSave(){
        $this->load->model('STC_Approval' );
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
        $this->load->model('STC_Approval' );
        $seq = $this->input->post('seq');
        $result = $this->STC_Approval->electronic_approval_personal_storage_select($seq); //개인보관함 폴더 하위목록
        echo json_encode($result);
    }

    //완료문서 개인보관함 저장 
    function saveToPersonalStorage(){
        $this->load->model('STC_Approval' );
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
        $this->load->model('STC_Approval');
        $seq = $this->input->post('storage_seq');
        $delete_doc_seq = $this->input->post('delete_doc_seq');
        $result = $this->STC_Approval->storage_doc_delete($seq,$delete_doc_seq);
        echo json_encode($result);
    }

    //댓글 저장
    function commentSave(){
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval' );
		$data['group_data'] = $this->STC_Approval->parentGroup();
        $data['category'] = $this->STC_Approval->select_format_category();
		$this->load->view( 'electronic_approval_format_category',$data);
    }

    //서식함 수정,삭제
    function format_category_modify(){
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval' );
        $data['category'] = $this->STC_Approval->select_format_category();
        $data['group_val'] = $this->STC_Approval->parentGroup();
        $data['view_val'] = $this->STC_Approval->user_approval_line_select("admin");
		$this->load->view('electronic_approver_line_management',$data);
    }

    //결재선 관리 리스트 뷰
    function electronic_approver_line_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model('STC_Approval');
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

        $this->load->view('electronic_approver_line_list',$data);
    }

    //결재복원
    function restore_approval(){
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
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
        $this->load->model('STC_Approval');
        $seq =  $this->input->post('seq');
        $result = $this->STC_Approval->electronic_approval_doc_delete($seq);
        echo json_encode($result);
    }
    
    //연차신청서 중복 체크
    function electronic_approal_annual_duplication_check(){
        $this->load->model('STC_Approval');
        $doc_seq = $this->input->post('doc_seq');
        $annual_start_date = $this->input->post('annual_start_date');
        $annual_end_date = $this->input->post('annual_start_date');
        $result = $this->STC_Approval->electronic_approal_annual_duplication_check($doc_seq,$annual_start_date,$annual_end_date,$this->id);
        echo json_encode($result);
    }

    //전자결재 프린트
    function electronic_approval_doc_print(){
        $this->load->model('STC_Approval');
        $data['seq'] = $_GET['seq'];
        $data['view_val'] = $this->STC_Approval->approval_doc_view($_GET['seq']);
        $this->load->view('electronic_approval_doc_print',$data);
    }
}
?>
<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Tech_board extends CI_Controller {
    var $id = '';

    function __construct() {
        parent::__construct();
        $this->id = $this->phpsession->get( 'id', 'stc' );
        $this->group = $this->phpsession->get( 'group', 'stc' );
        $this->customerid = $this->phpsession->get( 'customerid', 'stc' );
        $this->cooperative_id = $this->phpsession->get( 'cooperative_id', 'stc' );
        $this->name = $this->phpsession->get( 'name', 'stc' );
        $this->lv = $this->phpsession->get( 'lv', 'stc' );
        $this->at = $this->phpsession->get( 'at', 'stc' );
        $this->company = $this->phpsession->get( 'company', 'stc' );
        $this->email = $this->phpsession->get('email','stc'); //김수성추가
        $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
        $this->load->helper('form');
        $this->load->helper('url');
    }

    // 기술지원보고서 용
    function tech_report_csv(){
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model('STC_tech_doc');

        $seq = $this->input->get( 'seq' );
        $send_ck = $this->input->get( 'send_ck' );
        if($send_ck=='Y'){
                $mail_send = $this->input->get( 'mail_send' );
                $this->STC_tech_doc->tech_mail_send($mail_send,$seq);
        }else{
                $send_ck = "";
                $manager_mail = "";
        }
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
	    $this->load->view('tech_report_csv',$data);
    }

    //다중 전송할 때(정기점검2)
    function tech_report2_csv(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->Model('STC_tech_doc');

        $mailInfo = $this->input->get( 'mail_send' );
        $mailInfo = base64_decode($mailInfo);
        $mailInfo = explode('/',$mailInfo);
        $seq = $_GET['seq'];
        // for($i=0; $i<count($mailInfo); $i++){
        //     $eachMail= explode('-',$mailInfo[$i]);
        //     $seq = $seq.','.$eachMail[0];
        // }
        // $seq = substr($seq,1);

        $mail_send = 'Y';
        $this->STC_tech_doc->tech_mail_send($mail_send,$seq);

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        $this->load->view('tech_report2_csv',$data);
    }

    function custom_view(){

	    $this->load->view('custom_view');

    }

    function tech_doc_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model(array('STC_tech_doc'));
        if(isset($_GET['cur_page'])) {
            $cur_page = $_GET['cur_page'];
        }
        else {
            $cur_page = 0;
                }                                                                                                               //      현재 페이지

        $no_page_list = 10;                                                                             //      한페이지에 나타나는 목록 개수

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

        $data['search_keyword'] = $search_keyword;
        $data['search_keyword2'] = $search_keyword2;
        $data['search1'] = $search1;
        $data['mail_send']=$mail_send;
        $data['seq']=$seq;
        if  ( $cur_page <= 0 )
            $cur_page = 1;
        $data['cur_page'] = $cur_page;

        $user_list_data = $this->STC_tech_doc->tech_doc_list($search_keyword,$search_keyword2, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_tech_doc->tech_doc_list_count($search_keyword, $search_keyword2, $search1)->ucount;
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
        $this->load->view( 'tech_doc_list', $data );

    }

    function tech_doc_list_test() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model(array('STC_tech_doc'));
        if(isset($_GET['cur_page'])) {
            $cur_page = $_GET['cur_page'];
        }
        else {
            $cur_page = 0;
                }                                                                                                               //      현재 페이지

        $no_page_list = 10;                                                                             //      한페이지에 나타나는 목록 개수

        if(isset($_GET['searchkeyword'])) {
            $search_keyword = $_GET['searchkeyword'];
        }
        else {
            $search_keyword = "";
        }

        if(isset($_GET['searchkeyword2'])) {
            $search_keyword = $_GET['searchkeyword2'];
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
        if  ( $cur_page <= 0 )
            $cur_page = 1;
        $data['cur_page'] = $cur_page;

        $user_list_data = $this->STC_tech_doc->tech_doc_list($search_keyword,$search_keyword2 , $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_tech_doc->tech_doc_list_count($search_keyword, $search_keyword2, $search1)->ucount;
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
        $this->load->view( 'tech_doc_list_test', $data );

    }

    // 기술지원보고서 첨부파일 다운로드처리
    function tech_doc_download($seq, $filelcname) {
      $this->load->helper('alert');
      $this->load->helper('download');
      $this->load->Model(array('STC_tech_doc'));

      ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04

      $fdata = $this->STC_tech_doc->tech_doc_file($seq, $filelcname);


      if (!isset($fdata['file_changename'])) {
        alert("파일 정보가 존재하지 않습니다.");
      }

      $data = file_get_contents("/var/www/html/stc/misc/upload/tech/tech/".$fdata['file_changename']);

      if (!force_download(urlencode($fdata['file_realname']), $data)) {
        alert('파일을 찾을 수 없습니다.');
      }
    }

    // 기술지원 보고서 첨부파일 삭제처리
    function tech_doc_filedel($seq, $filelcname) {
      $this->load->helper('alert');
      $this->load->helper('download');
      $this->load->Model('STC_tech_doc');

      $fdata = $this->STC_tech_doc->tech_doc_file($seq, $filelcname);

      if (!isset($fdata['file_changename'])) {
        alert("파일 정보가 존재하지 않습니다.");
      } else {
        $fdata2 = $this->STC_tech_doc->tech_doc_filedel($seq);
        if($fdata2) {
          unlink("/var/www/html/stc/misc/upload/tech/tech/".$fdata['file_changename']);
        }
        alert('파일이 정상적으로 삭제되었습니다.', site_url().'/tech_board/tech_doc_view?seq='.$seq.'&mode=modify');
      }
    }


    function tech_doc_input() {
      // $this->output->enable_profiler(TRUE);
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model(array('STC_tech_doc'));
        $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer2'] = $this->STC_tech_doc->get_customer2();

        //로고파일 읽어오기
        $dir2= $this->input->server('DOCUMENT_ROOT')."/misc/img/logo";
        $cnt2 = 0;
        $dir_handle2 = opendir($dir2);
        $logoFile = array();
        //디렉토리의 파일을 읽어 들임
        while(($file2=readdir($dir_handle2)) !== false) {
            $fname2 = $file2; //파일명을 출력해보면 .과 ..도 출력이 된다. //(상위 폴더로 가기도 출력이 된다) //따라서 다음과 같이 .과 ..을 만나면 continue하도록 한다.
            if($fname2 == "." || $fname2 == "..") {
              continue;
            }
            $cnt2++; //반복해서 카운터를 증가시킴
            array_push($logoFile,$fname2);
        }
        closedir($dir_handle2);


        // $data['cover'] = $coverFile;
        $data['cover'] = $this->STC_tech_doc->cover_select();
        $data['logo'] = $logoFile;
        //표지파일 읽어오기 끝

        //KI
        if($this->input->get('techReportSubmit')){
          $data['schedule'] = 'ture';
          $data['schedule_seq'] = $this->input->get('seq');
          $data['startDay'] = $this->input->get('startDay');
          $data['startTime'] = $this->input->get('startTime');
          $data['endDay'] = $this->input->get('endDay');
          $data['endTime'] = $this->input->get('endTime');
          $data['workname'] = $this->input->get('workname');
          $data['supportMethod'] = $this->input->get('supportMethod');
          $data['contents'] = $this->input->get('contents');

          // $data['participant'] = $this->input->post('participant');

          $participantList = $this->input->get('participant');
          $participantList = str_replace(" ", "",$participantList);
          $participantArr = explode( ',', $participantList );
          $data['participant'] = $this->STC_tech_doc->user_name_duty($participantArr);
          // $data['customer_sch'] = $this->input->post('customer');

          //KI1 20210125  일정에서 고객사와 프로젝트, forcasting_seq를 받아온다.
          $data['customerName'] = $this->input->get('customerName');
          $data['customer'] = $this->input->get('customer');
          $data['project'] = $this->input->get('project');
          $data['customer_manager'] = $this->input->get('customer_manager');
          $data['maintain_end'] = $this->input->get('maintain_end');
          $data['maintain_seq'] = $this->input->get('maintain_seq');
          $data['forcasting_seq'] = $this->input->get('forcasting_seq');
          //KI2 20210125

          $data['modifyDay'] = date("Y-m-d H:i:s");

          $data['user_id'] = $this->id;
          $data['user_name'] = $this->name;

        }
        //KI

     //  var_dump($data['customer'][0]['customer']);

        $this->load->view( 'tech_doc_input', $data );
    }


    function tech_doc_input_action() {
     if( $this->id === null ) {
        redirect( 'account' );
     }
     $this->load->helper('alert');
     $this->load->model(array( 'STC_tech_doc' ));
     $seq = $this->input->post('seq');
     if($this->input->post('forcasting_seq') != ""){
        $forcasting_seq = $this->input->post('forcasting_seq');
     }else{
        $forcasting_seq = null;
     }

     if($this->input->post('maintain_seq') != ""){
        $maintain_seq = $this->input->post('maintain_seq');
     }else{
        $maintain_seq = null;
     }
     if($this->input->post('some_inspection') == ''){
        $some_inspection ='N';
     }else{
        $some_inspection = $this->input->post('some_inspection');
     }
     if($this->input->post('schedule_seq') != ""){
       $schedule_seq = $this->input->post('schedule_seq');
     }else{
       $schedule_seq = null;
     }

     $produce_seq = $this->input->post('produce_seq');

     $filename = NULL;
     $lcfilename = NULL;

     $csize = $_FILES["cfile"]["size"];
     $cname = $_FILES["cfile"]["name"];
     $ext = substr(strrchr($cname,"."),1);
     $ext = strtolower($ext);

    // 문서번호 생성 함수
     $work_date = $this->input->post('income_time');
     $today_month = date("n",strtotime($work_date) );
     $today_year = date("Y",strtotime($work_date) );
     $doc_final = "DUIT-TECH-08-".date("y-m",strtotime($work_date) )."-";
     $doc_last = $this->STC_tech_doc->tech_doc_num_count($today_year,$today_month,$seq);
     $doc_last += 1;
     $doc_final .= sprintf("%03d",$doc_last);

    // work 부분 합 치기
     $work_time_s = $this->input->post('work_time_s');
     $work_time_e = $this->input->post('work_time_e');
     $work_text = $this->input->post('work_text');

     $work_process_time="";
     $work_process="";

     for($i=0;$i<count($work_time_s);$i++){
        $work_process_time .=$work_time_s[$i];
        $work_process_time .="-";
        $work_process_time .= $work_time_e[$i];
        $work_process .=$work_text[$i];

        if($i>=0 and $i<count($work_time_s)){
            $work_process_time .=";;";
            $work_process .=";;";
        }
    }
        // insert / modify 기본 내용

    $s = $this->input->post('start_time');
    $e = $this->input->post('end_time');

    $ss = explode(":", $s);
    $ee = explode(":", $e);

    if($ee[1]<$ss[1]){

        $ee[0]--;
        $ee[1]+=60;

    }

    $results = mktime($ee[0]-$ss[0],$ee[1]-$ss[1],0,0,0,0);

    $total_time = date("H:i",$results);

    if ($csize > 0 && $cname) {
        if ($csize > 104857600) {
            echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
            exit;
        }
        if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
            echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
            exit;
        }

        $upload_dir = "/var/www/html/stc/misc/upload/tech/tech";

        $conf_file['upload_path'] = $upload_dir;
        $conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
        $conf_file['overwrite']  = false;
        $conf_file['encrypt_name']  = true;
        $conf_file['remove_spaces']  = true;

        $this->load->library( 'upload', $conf_file );

        if( $this->upload->do_upload('cfile') ) {
            $data = array('upload_data' => $this->upload->data());
            $filename = $data['upload_data']['orig_name'];
            $lcfilename = $data['upload_data']['file_name'];
        } else {
            alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
            exit;
        }

        $data1 = array(
            'forcasting_seq'		        => $forcasting_seq,
            'maintain_seq'                  => $maintain_seq,
            'customer'                      => $this->input->post('customerName'),
            'customer_manager'              => $this->input->post('customer_manager'),
            'project_name'                  => $this->input->post('project_name'),
            'manager_mail'            	    => $this->input->post('manager_mail'),
            'produce_seq'                   => $this->input->post('produce_seq'),
            'produce'                       => $this->input->post('produce'),
            'host'                          => $this->input->post('host'),
            'hardware'                      => $this->input->post('hardware'),
            'sn'                            => $this->input->post('serial'),
            'version'                       => $this->input->post('version'),
            'license'                       => $this->input->post('license'),
            'work_name'                     => $this->input->post('work_name'),
            'doc_num'                       => $doc_final,
            'total_time'                    => $total_time,
            'income_time'                   => $this->input->post('income_time'),
            'start_time'                    => $this->input->post('start_time'),
            'end_time'                      => $this->input->post('end_time'),
            'engineer'                      => $this->input->post('engineer'),
            'handle'                        => $this->input->post('handle'),
            'subject'                       => $this->input->post('subject'),
            'work_process_time'             => $work_process_time,
            'work_process'                  => $work_process,
            'err_type'                      => $this->input->post('err_type'),
            'warn_level'                    => $this->input->post('warn_level'),
            'warn_type'                     => $this->input->post('warn_type'),
            'work_action'                   => $this->input->post('work_action'),
            'file_changename'               => $lcfilename,
            'file_realname'                 => $filename,
            'comment'			            => $this->input->post('comment'),
            'result'                        => $this->input->post('result'),
            'update_date'                   => date("Y-m-d H:i:s"),
            'sign_consent'                  => $this->input->post('sign_consent'),
            'cover'                         => $this->input->post('cover'),
            'logo'                          => $this->input->post('logo'),
            'some_inspection'               => $some_inspection,
            //KI1
            'schedule_seq'                  => $schedule_seq
            // 'schedule_seq'                  => $sch_seq
            //KI2

        );
    }else{
        $data1 = array(
            'forcasting_seq'		        => $forcasting_seq,
            'maintain_seq'                  => $maintain_seq,
            'customer'                      => $this->input->post('customerName'),
            'customer_manager'              => $this->input->post('customer_manager'),
            'project_name'                  => $this->input->post('project_name'),
            'manager_mail'       		    => $this->input->post('manager_mail'),
            'produce_seq'                   => $this->input->post('produce_seq'),
            'produce'                       => $this->input->post('produce'),
            'host'                          => $this->input->post('host'),
            'hardware'                      => $this->input->post('hardware'),
            'sn'                            => $this->input->post('serial'),
            'version'                       => $this->input->post('version'),
            'license'                       => $this->input->post('license'),
            'work_name'                     => $this->input->post('work_name'),
            'doc_num'                       => $doc_final,
            'total_time'                    => $total_time,
            'income_time'                   => $this->input->post('income_time'),
            'start_time'                    => $this->input->post('start_time'),
            'end_time'                      => $this->input->post('end_time'),
            'engineer'                      => $this->input->post('engineer'),
            'handle'                        => $this->input->post('handle'),
            'subject'                       => $this->input->post('subject'),
            'work_process_time'             => $work_process_time,
            'work_process'                  => $work_process,
            'err_type'                      => $this->input->post('err_type'),
            'warn_level'                    => $this->input->post('warn_level'),
            'warn_type'                     => $this->input->post('warn_type'),
            'work_action'                   => $this->input->post('work_action'),
            'comment'			            => $this->input->post('comment'),
            'result'                        => $this->input->post('result'),
            'update_date'                   => date("Y-m-d H:i:s"),
            'sign_consent'                  => $this->input->post('sign_consent'),
            'cover'                         => $this->input->post('cover'),
            'logo'                          => $this->input->post('logo'),
            'some_inspection'               => $some_inspection,
            //KI1
            'schedule_seq'                  => $schedule_seq
            // 'schedule_seq'                  => $sch_seq
            //KI2
        );
    }


        if ($seq == null) {                     // insert 모드
            $data2 = array(
                'writer'                        => $this->name,
                'insert_date'                   => date("Y-m-d H:i:s")
                );
            $data = array_merge($data1, $data2);

            // KI1 20210125 기지보 작성이 일정에서 건너오지 않고, 기지보 작성 내용이 등록된 일정과 동일한 내용일 때 일치하는 일정의 seq 받아오기
            $data_match = array(
              'writer'          => $this->name,
              'income_time'     => $this->input->post('income_time'),
              'work_name'       => $this->input->post('work_name'),
              'handle'          => $this->input->post('handle'),
              'forcasting_seq'	=> $this->input->post('forcasting_seq'),
              'maintain_seq'  	=> $this->input->post('maintain_seq'),
              'customer'        => $this->input->post('customerName'),
              'project_name'    => $this->input->post('project_name'),
            );
            $unthrough_schedule_seq = $this->STC_tech_doc->unthrough_schedule($data_match);

            if($data['schedule_seq'] == null){
              $data['schedule_seq'] = $unthrough_schedule_seq;
            }
            // KI2 20210125


            $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0);
            if ($result && (($this->input->post('work_name')=='정기점검' || $this->input->post('work_name')=='정기점검2') && $this->group != '기술연구소')){
            // if ($result && (($this->input->post('work_name') == '정기점검' || $this->input->post('work_name')=='정기점검2'))){

                // $result = $this->STC_tech_doc->maintain_result($some_inspection,$data,1);
                $result = $this->STC_tech_doc->maintain_result($some_inspection,$data);
            }

            //KI1 기지보에서 넘어오거나 기지보 작성 내용이 일정과 동일한 내용일 때 해당 일정 등록 완료로 업데이트
            if($data['schedule_seq'] != null){
            // if($data['schedule_seq'] != 'normal'){
              $this->STC_tech_doc->schedule_update($data['schedule_seq']);
            }
            // KI2

        } else {                                        // modify 모드
            $data2 = array(
                'writer'            => $this->input->post('writer')
                );
            $data = array_merge($data1, $data2);

            // KI1 20210125 기지보 작성이 일정에서 건너오지 않고, 기지보 작성 내용이 등록된 일정과 동일한 내용일 때 일치하는 일정의 seq 받아오기
            $data_match = array(
              'writer'          => $this->name,
              'income_time'     => $this->input->post('income_time'),
              'work_name'       => $this->input->post('work_name'),
              'handle'          => $this->input->post('handle'),
              'forcasting_seq'	=> $this->input->post('forcasting_seq'),
              'maintain_seq'	  => $this->input->post('maintain_seq'),
              'customer'        => $this->input->post('customerName'),
              'project_name'    => $this->input->post('project_name'),
            );
            $unthrough_schedule_seq = $this->STC_tech_doc->unthrough_schedule($data_match);

            if($data['schedule_seq'] == null){
              $data['schedule_seq'] = $unthrough_schedule_seq;
              //KI1 기지보에서 넘어오거나 기지보 작성 내용이 일정과 동일한 내용일 때 해당 일정 등록 완료로 업데이트
              // $this->STC_tech_doc->schedule_update($data['schedule_seq']);
              // KI2
            }
            // echo '<script>alert('.$unthrough_schedule_seq.');</script>';
            // KI2 20210125

            $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 1, $seq);
            if ($result && (($this->input->post('work_name')=='정기점검' || $this->input->post('work_name')=='정기점검2') && $this->group != '기술연구소')){
                // if ($result && (($this->input->post('work_name')=='정기점검' || $this->input->post('work_name')=='정기점검2'))){
                // if(str_replace(",","",$produce_seq) ==''){
                //     $result = $this->STC_tech_doc->maintain_result($some_inspection,$data,0);
                // }else{
                //     $result = $this->STC_tech_doc->maintain_result($some_inspection,$data,1);
                // }
                $result = $this->STC_tech_doc->maintain_result($some_inspection,$data);
            }

          //KI1 기지보에서 넘어오거나 기지보 작성 내용이 일정과 동일한 내용일 때 해당 일정 등록 완료로 업데이트
          if($data['schedule_seq'] != null){
          // if($data['schedule_seq'] != 'normal'){
            // echo '<script>alert("ssssss");</script>';
            $this->STC_tech_doc->schedule_update($data['schedule_seq']);
          }
          // KI2
        }

        if ($result) {
            echo "<script>alert('정상적으로 처리 되었습니다.');location.href='".site_url()."/tech_board/tech_doc_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }
    }

    function tech_doc_view() {

        if( $this->id === null) {
            redirect( 'account' );
        }

        $this->load->Model('STC_tech_doc');
        $this->load->Model('STC_User');
        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer2'] = $this->STC_tech_doc->get_customer2();
        $data['seq'] = $seq;
        $data['group_member'] = $this->STC_User ->same_group_member($this->group);
        if($mode == "view") {
            $data['cover'] = $this->STC_tech_doc->cover_select( $data['view_val']['cover'] );
            $this->load->view( 'tech_doc_view', $data );
        } else {
            //로고파일 읽어오기
            $dir2= $this->input->server('DOCUMENT_ROOT')."/misc/img/logo";
            $cnt2 = 0;
            $dir_handle2 = opendir($dir2);
            $logoFile = array();
            //디렉토리의 파일을 읽어 들임
            while(($file2=readdir($dir_handle2)) !== false) {
                $fname2 = $file2; //파일명을 출력해보면 .과 ..도 출력이 된다. //(상위 폴더로 가기도 출력이 된다) //따라서 다음과 같이 .과 ..을 만나면 continue하도록 한다.
                if($fname2 == "." || $fname2 == "..") {
                continue;
                }
                $cnt2++; //반복해서 카운터를 증가시킴
                array_push($logoFile,$fname2);
            }
            closedir($dir_handle2);

            $data['cover'] = $this->STC_tech_doc->cover_select();
            $data['logo'] = $logoFile;
            //표지파일 읽어오기 끝
            $this->load->view( 'tech_doc_modify', $data );
        }
    }

    function tech_doc_view_test() {

        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model('STC_tech_doc');
        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['seq'] = $seq;
        if($mode == "view") {
            $this->load->view( 'tech_doc_view_test', $data );
        } else {
            $this->load->view( 'tech_doc_modify_test', $data );
        }
    }

    function tech_doc_print_action() {
        $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }else{//고객사는 seq 암호화해서 들어와서
            if(strpos($_SERVER['REQUEST_URI'], '?') !== false) {
                $seq = explode('?',$_SERVER['REQUEST_URI']); //?$viewSeq."&login=".$loginName.
                $seq = explode('&',$seq[1]);
                $seq = base64_decode($seq[0]);
                if(strpos($seq,'seq')!== false){
                    $seq = explode('=',$seq);
                    $seq = $seq[1];
                }else{
                    $seq="";
                }
            }else{
                $seq="";
            }
        }

        if( $this->id === null) {
            if($this->customerid <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/customer_login?".base64_encode("seq=".$seq)."'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        $this->load->view( 'tech_doc_print', $data );
    }

    function tech_doc_print_page() {
        $this->load->Model('STC_tech_doc');

        if(isset($_GET['seq'])){
            $seq = base64_decode($_GET['seq']);
        }

        if( $this->id === null) {
            if($this->customerid <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/customer_login?".base64_encode("seq=".$seq)."'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        $data['cover'] = $this->STC_tech_doc->cover_select($data['view_val']['cover']);
        $this->load->view( 'tech_doc_print_page', $data );
    }

    function tech_doc_pdf() {
        $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        $data['cover'] = $this->STC_tech_doc->cover_select($data['view_val']['cover']);
        $this->load->view( 'tech_doc_pdf', $data );
    }

    function tech_doc_pdf_logo() {
        $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
        // $data['cover'] = $this->STC_tech_doc->cover_select($data['view_val']['cover']);
        $this->load->view( 'tech_doc_pdf_logo', $data );
    }

    //기술지원보고서 고객사 서명 후 pdf mail로 전송
    function tech_doc_pdf_send_mail(){
        $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }
        exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -L 19mm -B 10mm  --footer-html http://tech.durianit.co.kr/index.php/tech_board/tech_doc_pdf_logo?seq={$seq} http://tech.durianit.co.kr/index.php/tech_board/tech_doc_pdf?seq={$seq} /var/www/html/stc/misc/upload/tech/tech/techpdf.pdf");

        $view_val = $this->STC_tech_doc->tech_doc_view($seq);
        $csvLoad = $view_val['manager_mail'];
        $csvArray = explode(";",$csvLoad);

        $arr_manager = explode(';',$view_val['customer_manager']);

        //메일 제목 작성
        $subject = "[".$view_val['customer']."]고객님 두리안정보기술에서 보내어드리는 ".substr($view_val['income_time'], 0, 10)." 기술지원보고서PDF 입니다.";
        $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

        //첨부 파일을 가져오자
            $boundary = "----" . uniqid("part");
            $attachment = "/var/www/html/stc/misc/upload/tech/tech/techpdf.pdf";
            $filename = "{$view_val['subject']}_".substr($view_val['income_time'], 0, 10).".pdf";
            $content = file_get_contents($attachment);
            $content = chunk_split(base64_encode($content));


        //메일 본문 작성
        $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml'>
        <head>
            <title>두리안정보기술센터-Tech Center</title>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        </head>
        <body>
                두리안정보기술의 고객지원사업부 입니다.<br>
                ".substr($view_val['income_time'], 0, 10)." 고객님의 사이트에 아래와 같은 기술지원이 이루어졌습니다.<br>
                첨부파일을 확인하시고 실제와 다르거나 만족스럽지 못한 부분이 있으시면 메일을 회신하여 주십시요.<br>
                고객님의 의견을 최대한 적극 반영하도록 노력 하겠습니다.<br>
                고객을 최선으로 모시는 기업 두리안정보기술이 되겠습니다.<br><br><br>
            </body>
        </html>";

        for($i=0;$i<count($csvArray);$i++){

            $real_mail_address_array = explode(",",$csvArray[$i]);
            $to = trim($real_mail_address_array[0]);
            $news_letter = str_replace("send_address",$to,$html_code);
            $message = $news_letter;
        }

        $headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
        $headers .= 'Cc: tech@durianit.co.kr' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-Type: Multipart/mixed; boundary=\"$boundary\"";
        $body = "This is a multi-part message in MIME format.\r\n\r\n"."--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($message))."\r\n"."--$boundary\r\n";
        $body .="Content-Type: application/octet-stream; charset=UTF-8\r\n name=\"".$filename."\"\r\n"."Content-Transfer-Encoding: base64\r\n"."Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n".$content."\r\n\r\n"."--$boundary--"; //3


        $strto = explode("@", $to);

        //메일 보내기
        $result = mail($csvLoad, $subject, $body, $headers);

        unlink("/var/www/html/stc/misc/upload/tech/tech/techpdf.pdf"); //파일삭제

        if($result){
            echo "<script>alert('메일로 기술지원보고서 PDF가 전송되었습니다.');self.close();</script>";
        } else {
            echo "<script>alert('기술지원보고서 PDF 메일 전송 실패');history.go(-1);</script>";
        }
        $headers = "";
    }

    function tech_doc_delete_action() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->helper('alert');
        $this->load->model(array( 'STC_tech_doc' ));
        $seq = $this->input->get( 'seq' );
        $seq2 = $this->input->get( 'seq' );
        if ($seq != null) {
            //KI1
            $this->STC_tech_doc->schedule_delete($seq2);
            //KI2
            $tdata = $this->STC_tech_doc->tech_doc_delete($seq);
        }
        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech_board/tech_doc_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
        }
    }
            // 장비등록 관련 페이지
            // 작성자 : 김수성
            // View에서 쓸 변수 : SQL정보를 배열로 받을 변수 view_val
            // 여기서는
            // $data['view_val'] = $this->STC_tech_doc->tech_device_view($seq);
            // 으로 정의
            //
    function tech_device_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model(array('STC_tech_doc'));
        if(isset($_GET['cur_page'])) {
            $cur_page = $_GET['cur_page'];
        }
        else {
            $cur_page = 0;
        }                                        //      현재 페이지
        $no_page_list = 10;                     //      한페이지에 나타나는 목록 개수

        if(isset($_GET['searchkeyword'])) {
            $search_keyword = $_GET['searchkeyword'];
        }else {
            $search_keyword = "";
        }
        if(isset($_GET['search1'])) {
            $search1 = $_GET['search1'];
        }else {
            $search1 = "";
        }

        $data['search_keyword'] = $search_keyword;
        $data['search1'] = $search1;
        if  ( $cur_page <= 0 )
            $cur_page = 1;
        $data['cur_page'] = $cur_page;

        $user_list_data = $this->STC_tech_doc->tech_device_list($search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_tech_doc->tech_device_list_count($search_keyword, $search1)->ucount;
        $data['check_list'] =$this->STC_tech_doc->check_list_template('all');
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
            $this->load->view( 'tech_device_list', $data );
    }


    // 장비등록  보기/수정 뷰
    function tech_device_view() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->Model(array('STC_tech_doc'));
        $mode = $this->input->get( 'mode' );
        $data['customer'] = $this->STC_tech_doc->get_customer();
        // $product_serial = $this->input->get( 'product_serial' );
        $seq = $this->input->get( 'seq' );

        $data['view_val'] = $this->STC_tech_doc->tech_device_view($seq);
        $data['check_list'] =$this->STC_tech_doc->check_list_template('all');
//	print_r($data['view_val']);
        $data['seq'] = $seq;
        if($mode == "view") {
            $this->load->view( 'tech_device_view', $data );
        } else {
            $this->load->view( 'tech_device_modify', $data );
        }
    }


    function tech_device_input(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->Model(array('STC_tech_doc'));

        $data['customer'] = $this->STC_tech_doc->get_customer();
        $this->load->view( 'tech_device_input', $data );
    }

    function tech_device_input_action() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $seq = $this->input->post('seq');

         $custom_title = $this->input->post('custom_title');
         $custom_detail = $this->input->post('custom_detail');

        $data = array(
            'product_version'              => $this->input->post('product_version'),
            'product_state'                => $this->input->post('product_state'),
            'product_host'                 => $this->input->post('product_host'),
            'product_licence'              => $this->input->post('product_licence'),
            'product_purpose'              => $this->input->post('product_purpose'),
            'product_check_list'           => $this->input->post('product_check_list'),
            'custom_title'                 => $custom_title[0],
            'custom_detail'                => $custom_detail[0],
            'update_date'                  => date("Y-m-d H:i:s")
            );
        if ($seq == null) {
            $result = $this->STC_tech_doc->tech_device_insert($data, $mode = 0,$seq=0);
        } else {
            $result = $this->STC_tech_doc->tech_device_insert($data, $mode = 1, $seq);
        }
        if($result) {
            echo "<script>alert('정상적으로 처리되었습니다.');history.go(-3);</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }
    }


    function tech_device_delete_action() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->helper('alert');
        $this->load->model(array( 'STC_tech_doc' ));
        $seq = $this->input->get( 'seq' );
        if ($seq != null) {
            $tdata = $this->STC_tech_doc->tech_device_delete($seq);
        }
        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech_board/tech_device_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
        }
    }


    function search_device(){
      $seq = $_GET['name'];
      $mode = $_GET['mode'];
    //   $data = $this->db->query("select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t1.seq='".$tmp."'")->result();
    //   $data = $this->db->query("select * ,t2.seq AS product_seq from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq = t2.forcasting_seq and t2.product_code = t3.seq WHERE (((SELECT sub_project_add FROM sales_forcasting where seq='".$tmp."') is null and t1.seq='".$tmp."') OR ((SELECT sub_project_add FROM sales_forcasting where seq='".$tmp."')IS not NULL AND t1.sub_project_add=(SELECT sub_project_add FROM sales_forcasting where seq='".$tmp."'))) AND (t2.maintain_target IS null OR t2.maintain_target ='Y')")->result();
    //   $data = $this->db->query("select * ,t2.seq AS product_seq from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq = t2.forcasting_seq and t2.product_code = t3.seq WHERE (((SELECT sub_project_add FROM sales_forcasting where seq='".$tmp."') is null and t1.seq='".$tmp."') OR ((SELECT sub_project_add FROM sales_forcasting where seq='".$tmp."') IS not NULL AND t1.sub_project_add=(SELECT sub_project_add FROM sales_forcasting where seq='".$tmp."')))")->result();
      if($mode == "maintain"){
        $data = $this->db->query("select * ,t2.seq AS product_seq FROM sales_maintain as t1 join sales_maintain_product as t2 join product as t3 on t1.seq = t2.maintain_seq and t2.product_code = t3.seq WHERE t1.seq = {$seq}")->result();
      }else{
        $data = $this->db->query("select *,t2.seq AS product_seq from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t1.seq= {$seq}")->result();
      }
      $this->load->view('search_device',array('input'=>$data));
    }

    function search_se(){
      $data = $this->db->query("select * from user where company_name like '%두리안정보%';")->result();
      $this->load->view('search_se',array('input'=>$data));
    }

    function search_manager(){
      $tmp = $_GET['name'];
      $mode= $_GET['mode'];
    //   $data = $this->db->query("select * from sales_forcasting where seq='".$tmp."'")->result();
      if($mode == "maintain"){
        $data = $this->db->query("select * from sales_maintain where seq='{$tmp}'")->result();
      }else{
        $data = $this->db->query("select * from sales_forcasting where seq='{$tmp}'")->result();
      }

      $this->load->view('search_manager',array('input'=>$data));
    }

    function tech_doc_signature(){
        // $tmp = $_GET['name'];
        // $data = $this->db->query("select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t1.seq='".$tmp."'")->result();
        // $this->load->view('search_device',array('input'=>$data));
        $data = $this->db->query("select * from sales_forcasting ")->result();
        $this->load->view('tech_doc_signature',array('input'=>$data));
    }

    //제품별 템플릿 생성 페이지
    function product_check_list_input(){
      //   $data = $this->db->query("select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t1.seq='".$tmp."'")->result();
        $data = $this->db->query("select * from product_check_list_template ORDER BY seq asc")->result();
        $this->load->view('product_check_list_input',array('input'=>$data));
    }

    //제품별 템플릿 생성
    function product_check_list_input_action(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $data['product_name'] = $this->input->post('product_name');
        $data['check_list'] = $this->input->post('work_text');

        $duplicateCheck = $this->db->query("select * from product_check_list_template where product_name = '{$data['product_name']}'")->result();

        if(count($duplicateCheck) >= 1){
            echo "<script>alert('제품명이 이미 존재합니다. 제품명을 다시 입력해 주세요.');opener.focus();self.close();</script>";
        }else{
            $result = $this->STC_tech_doc->product_check_list_input($data);

            if($result) {
                echo "<script>opener.opener.location.reload();opener.parent.close();alert('정상적으로 처리되었습니다.');self.close();</script>";
            } else {
                echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
            }
        }
    }

    //제품별 템플릿 뷰
    function product_check_list_view(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $seq = $this->input->get('seq');
        $data['check_item']= $this->STC_tech_doc->check_list_template($seq);

        $this->load->view('product_check_list_view',$data);
    }

    //제품별 템플릿 리스트
    function product_check_list(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('product_check_list',$data);
    }

    //제품별 템플릿 커스텀
    function product_check_list_custom(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $seq = $this->input->get('seq');
        $data['view_val']= $this->STC_tech_doc->check_list_template($seq);
        $this->load->view('product_check_list_custom',$data);

    }

    //제품별 템플릿 삭제
    function product_check_list_delete(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $seq =  $this->input->get('seq');
        $result = $this->STC_tech_doc->product_check_list_delete($seq);
        if($result) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech_board/product_check_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }
    }

    //제품별 템플릿 수정
    function product_check_list_modify(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $seq = $this->input->get('seq');
        $data['view_val']= $this->STC_tech_doc->check_list_template($seq);
        $this->load->view('product_check_list_modify',$data);
    }

    //제품별 템플릿 수정
    function product_check_list_update_action(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $data['seq'] = $this->input->post('seq');
        $data['product_name'] = $this->input->post('product_name');
        $data['check_list'] = $this->input->post('work_text');

        $result = $this->STC_tech_doc->product_check_list_update($data);
        if($result) {
            echo "<script>alert('정상적으로 처리되었습니다.');opener.opener.location.reload();self.close();</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }

    }

    //표지 등록
    function cover_upload(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $data['cover'] = $this->STC_tech_doc->cover_select();
        $this->load->view('cover_upload',$data);
    }

    //표지 등록 ok
    function cover_upload_ok(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        // $this->load->view('cover_upload_ok');
        // 설정
        $uploads_dir =  $this->input->server('DOCUMENT_ROOT')."/misc/img/cover";
        $allowed_ext = array('jpg','jpeg','png','gif','PNG');

        // 변수 정리
        $error = $_FILES['myfile']['error'];
        $name = $_FILES['myfile']['name'];
        $ext = array_pop(explode('.', $name));

        // 오류 확인
        if( $error != UPLOAD_ERR_OK ) {
            switch( $error ) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<script>alert('파일이 너무 큽니다. {$error}');location.href='".site_url()."/tech_board/cover_upload'</script>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<script>alert('파일이 첨부되지 않았습니다. {$error}');location.href='".site_url()."/tech_board/cover_upload'</script>";
                    break;
                default:
                    echo "<script>alert('파일이 제대로 업로드되지 않았습니다.{$error}');location.href='".site_url()."/tech_board/cover_upload'</script>";
            }
            exit;
        }

        // 확장자 확인
        if( !in_array($ext, $allowed_ext) ) {
            echo "<script>alert('허용되지 않는 확장자입니다.');location.href='".site_url()."/tech_board/cover_upload'</script>";
            exit;
        }

        // 파일 이동
        move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$name");

        $result = $this->STC_tech_doc->cover_insert($name);

        if($result){
            echo "<script>alert('표지가 등록되었습니다.');location.href='".site_url()."/tech_board/cover_upload';</script>";
        }else{
            echo "<script>alert('표지가 등록 실패.');location.href='".site_url()."/tech_board/cover_upload';</script>";
        }
    }

    //표지 삭제
    function cover_delete() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        $this->load->model(array( 'STC_tech_doc' ));
        unlink($this->input->server('DOCUMENT_ROOT')."/misc/img/cover/".$_GET['filename']);

        $result = $this->STC_tech_doc->cover_delete($_GET['seq']);

        if($result){
            echo "<script>alert('표지가 삭제되었습니다.');location.href='".site_url()."/tech_board/cover_upload';</script>";
        }else{
            echo "<script>alert('표지가 삭제 실패.');location.href='".site_url()."/tech_board/cover_upload';</script>";
        }

    }

    //표지 좌표찍기
    function cover_coordinate_update(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));

        $seq = $this->input->post('seq');

        $data = array(
           'durian_sign'                    => $this->input->post('durian_sign'),
           'customer_sign'                  => $this->input->post('customer_sign'),
           'subject'                        => $this->input->post('subject'),
           'income_time'                    => $this->input->post('income_time'),
           'customer_company'               => $this->input->post('customer_company'),
           'writer'                         => $this->input->post('writer'),
           'durian_engineer'                => $this->input->post('durian_engineer'),
           'customer_manager'               => $this->input->post('customer_manager'),
           );
        $result = $this->STC_tech_doc->cover_coordinate_update($data,$seq);

        if($result){
            echo "<script>alert('표지 좌표가 등록 되었습니다.');location.href='".site_url()."/tech_board/cover_upload';</script>";
        }else{
            echo "<script>alert('표지 좌표가 등록 실패.');history.go(-1);</script>";
        }

    }

    //로고 등록
    function logo_upload(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));

        //표지파일 읽어오기
        $dir = $this->input->server('DOCUMENT_ROOT')."/misc/img/logo";
        $cnt = 0;
        $dir_handle = opendir($dir); // 디렉토리 열기
        $coverFile = array();
        //디렉토리의 파일을 읽어 들임
        while(($file=readdir($dir_handle)) !== false) {
            $fname = $file; //파일명을 출력해보면 .과 ..도 출력이 된다. //(상위 폴더로 가기도 출력이 된다) //따라서 다음과 같이 .과 ..을 만나면 continue하도록 한다.
            if($fname == "." || $fname == "..") {
            continue;
            }
            $cnt++; //반복해서 카운터를 증가시킴
            array_push($coverFile,$fname);
        }
        closedir($dir_handle); // 마지막으로 디렉토리를 닫기

        $data['cover'] = $coverFile;
        //표지파일 읽어오기 끝
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('logo_upload',$data);
    }

    //로고 등록 ok
    function logo_upload_ok(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('logo_upload_ok');
    }

    //표지 삭제
    function logo_delete() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('logo_delete');

    }

    //커버 위치(좌표) 찍기
    function cover_coordinate() {
        if( $this->id === null) {
            redirect( 'account' );
        }
        $this->load->model(array( 'STC_tech_doc' ));
        $data['cover']= $this->STC_tech_doc->cover_select($_GET['seq']);

        $this->load->view('cover_coordinate',$data);
    }

    //기술 지원 요청 페이지
    function request_tech_support_list() {
        if( $this->id === null) {
            if($this->cooperative_id <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/cooperative_login_view'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

        $this->load->Model(array('STC_tech_doc','STC_request_tech_support'));
        if(isset($_GET['cur_page'])) {
            $cur_page = $_GET['cur_page'];
        }
        else {
            $cur_page = 0;
                }                                                                                                               //      현재 페이지

        $no_page_list = 10;                                                                             //      한페이지에 나타나는 목록 개수

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
        // $data['mail_send']=$mail_send;
        // $data['seq']=$seq;
        if  ( $cur_page <= 0 ){
            $cur_page = 1;
        }
        $data['cur_page'] = $cur_page;

        $user_list_data = $this->STC_request_tech_support->request_tech_support_list($search_keyword,$search_keyword2, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_request_tech_support->request_tech_support_list_count($search_keyword, $search_keyword2, $search1)->ucount;
        $data['list_val'] = $user_list_data['data'];
        $data['list_val_count'] = $user_list_data['count'];
        $total_page = 1;
        if  ( $data['count'] % $no_page_list == 0 ){
            $total_page = floor( ( $data['count'] / $no_page_list ) );
        }else{
            $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );                  //      전체 페이지 개수
        }
        $start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
        $end_page = 0;
        if( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
            $end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
        }else{
            $end_page = $total_page;
        }
        $data['no_page_list'] = $no_page_list;
        $data['total_page'] = $total_page;
        $data['start_page'] = $start_page;
        $data['end_page'] = $end_page;
        $this->load->view( 'request_tech_support_list', $data );


    }

    //기술 지원 요청 등록 페이지
    function request_tech_support_input() {
        if( $this->id === null) {
            if($this->cooperative_id <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/cooperative_login_view'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

        $this->load->model(array( 'STC_request_tech_support' ));
        $data['cooperative_company'] = $this->STC_request_tech_support->cooperative_company();
        $this->load->view('request_tech_support_input',$data);
    }

    function request_tech_support_input_action(){
        if( $this->id === null) {
            if($this->cooperative_id <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/cooperative_login_view'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

         $this->load->model(array( 'STC_request_tech_support' ));
         $seq = $this->input->post('seq');
         $recovery_status='';
         if($this->input->post('recovery_status') == ''){
            $recovery_status ='N';
         }else{
            $recovery_status = $this->input->post('recovery_status');
         }

         $filename = NULL;
         $lcfilename = NULL;

         $csize = $_FILES["cfile"]["size"];
         $cname = $_FILES["cfile"]["name"];
         $newFilePath = $_FILES["cfile"]["tmp_name"];
         $ext = substr(strrchr($cname,"."),1);
         $ext = strtolower($ext);



        if ($csize > 0 && $cname) {
            if ($csize > 104857600) {
                echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
                exit;
            }
            if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
                echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
                exit;
            }

            $filename = $cname;

            //파일이름랜덤으로 만들어주는고임
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $lcfilename = '';
            for ($i = 0; $i < 30; $i++) {
                $lcfilename .= $characters[rand(0, $charactersLength - 1)];
            }
            $lcfilename = $lcfilename.".".$ext;

            $connection = ssh2_connect('192.168.0.101', 22);
            ssh2_auth_password($connection, 'root', 'durian0529');

            $file_upload=ssh2_scp_send($connection, $newFilePath, "/var/www/html/stc/misc/upload/tech/request_tech_support/".$lcfilename, 0644);

            if(!$file_upload){
                echo "<script>alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.')</script>";
                exit;
            }

            ssh2_exec($connection, 'exit');


            $data1 = array(
                'sortation'		                => $this->input->post('sortation'),
                'support_type'                  => $this->input->post('support_type'),
                'customer_company'              => $this->input->post('customer_company'),
                'writer'                        => $this->input->post('writer'),
                'cooperative_company'           => $this->input->post('cooperative_company'),
                'cooperative_manager'           => $this->input->post('cooperative_manager'),
                'cooperative_tel'               => $this->input->post('cooperative_tel'),
                'cooperative_email'             => $this->input->post('cooperative_email'),
                'engineer_name'                 => $this->input->post('engineer_name'),
                'engineer_branch'               => $this->input->post('engineer_branch'),
                'engineer_tel'                  => $this->input->post('engineer_tel'),
                'engineer_email'                => $this->input->post('engineer_email'),
                'workplace_name'                => $this->input->post('workplace_name'),
                'workplace_address'             => $this->input->post('workplace_address'),
                'workplace_manager'             => $this->input->post('workplace_manager'),
                'workplace_tel'                 => $this->input->post('workplace_tel'),
                'produce'                       => $this->input->post('produce'),
                'serial'                        => $this->input->post('serial'),
                'version'                       => $this->input->post('version'),
                'host'                          => $this->input->post('host'),
                'internal_ip'                   => $this->input->post('internal_ip'),
                'external_ip'                   => $this->input->post('external_ip'),
                'installation_request_date'     => $this->input->post('installation_request_date'),
                'reception_date'                => $this->input->post('reception_date'),
                'installation_date'             => $this->input->post('installation_date'),
                'delivery_date'                 => $this->input->post('delivery_date'),
                'etc'			                => $this->input->post('etc'),
                'result'                        => $this->input->post('result'),
                'final_approval'                => $this->input->post('final_approval'),
                'file_change_name'              => $lcfilename,
                'file_real_name'                => $filename,
                'tax'                           => $this->input->post('tax'),
                'update_date'                   => date("Y-m-d H:i:s"),
                'manager_mail_send'             => $this->input->post('manager_mail_send'),
                'engineer_mail_send'             => $this->input->post('engineer_mail_send')

            );
        }else{
            $data1 = array(
                'sortation'		                => $this->input->post('sortation'),
                'support_type'                  => $this->input->post('support_type'),
                'customer_company'              => $this->input->post('customer_company'),
                'writer'                        => $this->input->post('writer'),
                'cooperative_company'           => $this->input->post('cooperative_company'),
                'cooperative_manager'           => $this->input->post('cooperative_manager'),
                'cooperative_tel'               => $this->input->post('cooperative_tel'),
                'cooperative_email'             => $this->input->post('cooperative_email'),
                'engineer_name'                 => $this->input->post('engineer_name'),
                'engineer_branch'               => $this->input->post('engineer_branch'),
                'engineer_tel'                  => $this->input->post('engineer_tel'),
                'engineer_email'                => $this->input->post('engineer_email'),
                'workplace_name'                => $this->input->post('workplace_name'),
                'workplace_address'             => $this->input->post('workplace_address'),
                'workplace_manager'             => $this->input->post('workplace_manager'),
                'workplace_tel'                 => $this->input->post('workplace_tel'),
                'produce'                       => $this->input->post('produce'),
                'serial'                        => $this->input->post('serial'),
                'version'                       => $this->input->post('version'),
                'host'                          => $this->input->post('host'),
                'internal_ip'                   => $this->input->post('internal_ip'),
                'external_ip'                   => $this->input->post('external_ip'),
                'installation_request_date'     => $this->input->post('installation_request_date'),
                'reception_date'                => $this->input->post('reception_date'),
                'installation_date'             => $this->input->post('installation_date'),
                'delivery_date'                 => $this->input->post('delivery_date'),
                'etc'			                => $this->input->post('etc'),
                'result'                        => $this->input->post('result'),
                'final_approval'                => $this->input->post('final_approval'),
                'tax'                           => $this->input->post('tax'),
                'update_date'                   => date("Y-m-d H:i:s"),
                'manager_mail_send'             => $this->input->post('manager_mail_send'),
                'engineer_mail_send'            => $this->input->post('engineer_mail_send')
            );
        }

            if ($seq == null) {                     // insert 모드
                $data2 = array(
                    'writer'                        => $this->name,
                    'insert_date'                   => date("Y-m-d H:i:s")
                    );
                $data = array_merge($data1, $data2);
                $result = $this->STC_request_tech_support->request_tech_support_insert($data, $mode = 0);
            } else {                                       // modify 모드
                $data2 = array(
                    'writer'            => $this->input->post('writer'),
                    'old_produce'       => $this->input->post('old_produce'),
                    'old_serial'        => $this->input->post('old_serial'),
                    'recovery_status'   => $recovery_status
                    );
                $data = array_merge($data1, $data2);
                $result = $this->STC_request_tech_support->request_tech_support_insert($data, $mode = 1, $seq);
            }

            if ($result) {
                echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/tech_board/request_tech_support_mail?seq={$result}';</script>";
            } else {
                echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
            }

    }

    function request_tech_support_view(){
        if( $this->id === null) {
            if($this->cooperative_id <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/cooperative_login_view'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

        $this->load->Model('STC_request_tech_support');
        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );
        $data['cooperative_company'] = $this->STC_request_tech_support->cooperative_company();
        $data['view_val'] = $this->STC_request_tech_support->request_tech_support_view($seq);
        $data['seq'] = $seq;
        if($mode == "view") {
            $this->load->view( 'request_tech_support_view', $data );
        } else {
            $this->load->view( 'request_tech_support_modify', $data );
        }
    }

    //기술지원요청 메일보내기
    function request_tech_support_mail(){
        if( $this->id === null) {
            if($this->cooperative_id <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/cooperative_login_view'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

        $this->load->Model('STC_request_tech_support');
        $seq = $this->input->get( 'seq' );
        // $mode = $this->input->get( 'mode' );
        $data['view_val'] = $this->STC_request_tech_support->request_tech_support_view($seq);
        $data['seq'] = $seq;

        $this->load->view( 'request_tech_support_mail', $data );
    }

    function request_tech_support_delete_action(){
        if( $this->id === null) {
            redirect( 'account' );
        }
        $this->load->helper('alert');
        $this->load->model(array( 'STC_request_tech_support' ));
        $seq = $this->input->get( 'seq' );
        $filelcname = $this->input->get( 'file_change_name' );
        if ($seq != null) {
            if(strpos($seq,",")!==false){ //,포함되어있을때 삭제할 게시물 여러 개 일때
                $eachSeq = explode(",",$seq);
                $eachFilelcname = explode(",",$filelcname);
                for($i=0; $i<count($eachSeq); $i++){
                    $fdata = $this->STC_request_tech_support->request_tech_support_file($eachSeq[$i], $eachFilelcname[$i]);
                    if (isset($fdata['file_change_name'])) {
                        $connection = ssh2_connect('192.168.0.101', 22);
                        ssh2_auth_password($connection, 'root', 'durian0529');
                        $sftp = ssh2_sftp($connection);
                        $del=ssh2_sftp_unlink($sftp,"/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
                    }
                    $tdata = $this->STC_request_tech_support->request_tech_support_delete($eachSeq[$i]);
                }
            }else{
                $fdata = $this->STC_request_tech_support->request_tech_support_file($seq, $filelcname);
                if (isset($fdata['file_change_name'])) {
                    $connection = ssh2_connect('192.168.0.101', 22);
                    ssh2_auth_password($connection, 'root', 'durian0529');
                    $sftp = ssh2_sftp($connection);
                    $del=ssh2_sftp_unlink($sftp,"/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
                }
                $tdata = $this->STC_request_tech_support->request_tech_support_delete($seq);
            }

        }

        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech_board/request_tech_support_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
        }
    }

    // 기술지원요청 첨부파일 다운로드처리
    function request_tech_support_download($seq, $filelcname) {
        $this->load->helper('alert');
        $this->load->helper('download');
        $this->load->Model(array('STC_request_tech_support'));

        ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04

        $fdata = $this->STC_request_tech_support->request_tech_support_file($seq, $filelcname);


        if (!isset($fdata['file_change_name'])) {
            alert("파일 정보가 존재하지 않습니다.");
        }

        $connection = ssh2_connect('192.168.0.101', 22);
        ssh2_auth_password($connection, 'root', 'durian0529');
        $sftp = ssh2_sftp($connection);

        $data = file_get_contents('ssh2.sftp://' . intval($sftp) . "/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name'], 'r');

        if (!force_download(urlencode($fdata['file_real_name']), $data)) {
            alert('파일을 찾을 수 없습니다.');
        }
    }

    // 기술지원요청 첨부파일 삭제처리
    function request_tech_support_del($seq, $filelcname) {
        $this->load->helper('alert');
        $this->load->helper('download');
        $this->load->Model('STC_request_tech_support');

        $fdata = $this->STC_request_tech_support->request_tech_support_file($seq, $filelcname);

        if (!isset($fdata['file_change_name'])) {
            alert("파일 정보가 존재하지 않습니다.");
        } else {
            $fdata2 = $this->STC_request_tech_support->request_tech_support_del($seq);
            if($fdata2) {
                // unlink("/var/www/html/stc/misc/upload/tech/tech/".$fdata['file_change_name']);
                $connection = ssh2_connect('192.168.0.101', 22);
                ssh2_auth_password($connection, 'root', 'durian0529');
                $sftp = ssh2_sftp($connection);

                ssh2_sftp_unlink($sftp,"/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
            }
            alert('파일이 정상적으로 삭제되었습니다.', site_url().'/tech_board/request_tech_support_view?seq='.$seq );
        }
    }

    //기술지원요청 최종승인 메일
    function request_tech_support_final_approval_mail(){
        if( $this->id === null) {
            if($this->cooperative_id <> null ){
                if ($_SESSION['timeout'] + 10*60 < time()) {
                    session_unset();
                    session_destroy();
                    echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); location.href='".site_url()."/account/cooperative_login_view'</script>";
                }
            }else{
                redirect( 'account' );
            }
        }

        $this->load->Model('STC_request_tech_support');
        $seq = $this->input->get( 'seq' );
        $data['view_val'] = $this->STC_request_tech_support->request_tech_support_view($seq);
        if(strpos($seq,',') !== false){
            $data['manager'] = $this->STC_request_tech_support->cooperative_sales_manager($data['view_val'][0]['cooperative_company']);
        }else{
            $data['manager'] = $this->STC_request_tech_support->cooperative_sales_manager($data['view_val']['cooperative_company']);
        }
        $data['seq'] = $seq;

        $this->load->view( 'request_tech_support_final_approval_mail', $data );
    }

}

?>

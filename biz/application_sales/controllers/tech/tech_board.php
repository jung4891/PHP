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
        $this->duty = $this->phpsession->get( 'duty', 'stc' );
        $this->seq = $this->phpsession->get('seq', 'stc');
        $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );
        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->library('user_agent');

        $this->load->Model(array('tech/STC_tech_doc','tech/STC_request_tech_support', 'tech/STC_User'));
    }

    // 기술지원보고서 용
    function tech_report_csv(){
        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model('STC_tech_doc');

        $seq = $this->input->get( 'seq' );
        $send_ck = $this->input->get( 'send_ck' );
        if($send_ck=='Y'){
                $mail_send = $this->input->get( 'mail_send' );
                $this->STC_tech_doc->tech_mail_send($mail_send,$seq);
        }else{
                $send_ck = "";
                $manager_mail = "";
        }
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
	    $this->load->view('tech/tech_report_csv',$data);
    }

    //다중 전송할 때(정기점검2)
    function tech_report2_csv(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model('STC_tech_doc');

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

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
        $this->load->view('tech/tech_report2_csv',$data);
    }

    function custom_view(){

	    $this->load->view('tech/custom_view');

    }

    function tech_doc_list() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model(array('STC_tech_doc'));
        $type = $_GET['type'];

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
          $user_list_data = $this->STC_tech_doc->tech_doc_list_mobile($type, $search_keyword,$search_keyword2, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
          $data['count'] = $this->STC_tech_doc->tech_doc_list_count_mobile($type, $search_keyword, $search_keyword2, $search1)->ucount;
        } else {
          $user_list_data = $this->STC_tech_doc->tech_doc_list($type, $searchkeyword, $hashtag, $excellent_report_yn, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
          $data['count'] = $this->STC_tech_doc->tech_doc_list_count($type, $searchkeyword, $hashtag, $excellent_report_yn)->ucount;
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
        $data['schedule_list'] = $this->STC_tech_doc->schedule_list($this->seq);
        $data['type'] = $type;
        $data['product_company'] = $this->STC_tech_doc->product_company();

        if($this->agent->is_mobile()) {
          $data['title'] = '기술지원보고서';
          $this->load->view('tech/tech_doc_list_mobile', $data);
        } else {
          $this->load->view('tech/tech_doc_list', $data );
        }

    }

    function tech_doc_list_test() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model(array('STC_tech_doc'));
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
        $this->load->view('tech/tech_doc_list_test', $data );

    }

    // 기술지원보고서 첨부파일 다운로드처리
    function tech_doc_download($seq, $filelcname) {
      $this->load->helper('alert');
      $this->load->helper('download');
      // $this->load->Model(array('STC_tech_doc'));

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
      // $this->load->Model('STC_tech_doc');

      $fdata = $this->STC_tech_doc->tech_doc_file($seq, $filelcname);

      if (!isset($fdata['file_changename'])) {
        alert("파일 정보가 존재하지 않습니다.");
      } else {
        $fdata2 = $this->STC_tech_doc->tech_doc_filedel($seq);
        if($fdata2) {
          unlink("/var/www/html/stc/misc/upload/tech/tech/".$fdata['file_changename']);
        }
        alert('파일이 정상적으로 삭제되었습니다.', site_url().'/tech/tech_board/tech_doc_view?seq='.$seq.'&mode=modify');
      }
    }


    function tech_doc_input() {
      // $this->output->enable_profiler(TRUE);
        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model(array('STC_tech_doc'));
        //포캐스팅+유지보수
        // $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer'] = $this->STC_tech_doc->get_customer3();
        $data['customer2'] = $this->STC_tech_doc->get_customer2();

        $data['product_company'] = $this->STC_tech_doc->product_company();

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
        if($this->input->get('schedule_seq')!='N'){
          $schedule_seq = $this->input->get('schedule_seq');

          $schedule = $this->STC_tech_doc->details($schedule_seq);

          $data['schedule'] = $schedule;

          // $data['participant'] = $this->input->post('participant');
          $income_day = $this->input->get('income_day');
          $end_work_day = $this->input->get('end_work_day');
          if($income_day != ''){
            $data['income_day'] = $income_day;
          } else {
            $data['income_day'] = $schedule->start_day;
          }
          if($end_work_day != ''){
            $data['end_work_day'] = $end_work_day;
          } else {
            $data['end_work_day'] = $schedule->end_day;
          }


          $participantList = $schedule->participant;
          $participantList = str_replace(" ", "",$participantList);
          $participantArr = explode( ',', $participantList );
          $data['participant'] = $this->STC_tech_doc->user_name_duty($participantArr);

          $data['modifyDay'] = date("Y-m-d H:i:s");

          $data['user_id'] = $this->id;
          $data['user_name'] = $this->name;

        }
        //KI

     //  var_dump($data['customer'][0]['customer']);

        $this->load->view('tech/tech_doc_input', $data );
    }


    function tech_doc_input_action() {
     if( $this->id === null ) {
        redirect( 'account' );
     }
     $this->load->helper('alert');
     // $this->load->Model(array( 'STC_tech_doc' ));
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
     if($this->input->post('end_work_day') != ""){
       $end_work_day = $this->input->post('end_work_day');
     }else{
       $end_work_day = null;
     }
     // var_dump($this->input->post('customer_manager'));
     // echo '<br>';
     // var_dump($this->input->post('manager_mail'));
     $customer_manager = implode('; ', $this->input->post('customer_manager'));
     $manager_mail = implode(';', $this->input->post('manager_mail'));
     // echo '<br>';
     // echo $customer_manager;
     // echo '<br>';
     // echo $manager_mail;

     //임시저장 여부
     $type = $this->input->post('type');
     if(!empty($_GET['type'])){
       $before_type = $_GET['type'];
     }
     //임시저장 여부

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
     $work_day_s = $this->input->post('work_day_s');
     $work_day_e = $this->input->post('work_day_e');
     $work_time_s = $this->input->post('work_time_s');
     $work_time_e = $this->input->post('work_time_e');
     $work_text = $this->input->post('work_text');

     $work_process_time="";
     $work_process="";

     for($i=0;$i<count($work_day_s);$i++){
     // for($i=0;$i<count($work_time_s);$i++){
        $work_process_time .= $work_day_s[$i];
        $work_process_time .= "~";
        $work_process_time .= $work_day_e[$i];
        $work_process_time .= "/";
        $work_process_time .= $work_time_s[$i];
        $work_process_time .= "-";
        $work_process_time .= $work_time_e[$i];
        $work_process .= $work_text[$i];

        if($i>=0 and $i<count($work_day_s)){
        // if($i>=0 and $i<count($work_time_s)){
            $work_process_time .= ";;";
            $work_process .= ";;";
        }
    }

    if($this->input->post('work_name') == '장애지원') {
      $failure_data = '';

      $failure_title = $this->input->post('failure_title');
      $failure_content = $this->input->post('failure_content');

      for($i = 0; $i < count($failure_title); $i++) {
        if($i > 0) {
          $failure_data .= '*/*';
        }
        $failure_data .= $failure_title[$i].':::'.$failure_content[$i];
      }
    } else {
      $failure_data = null;
    }
        // insert / modify 기본 내용

    $s = $this->input->post('start_time');
    $e = $this->input->post('end_time');

    if($s == ''){
      $s = '00:00';
    }
    if($e == ''){
      $e = '00:00';
    }

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
            'forcasting_seq'		            => $forcasting_seq,
            'maintain_seq'                  => $maintain_seq,
            'customer'                      => $this->input->post('customerName'),
            'customer_manager'              => $customer_manager,
            'project_name'                  => $this->input->post('project_name'),
            'manager_mail'            	    => $manager_mail,
            'produce_seq'                   => $this->input->post('produce_seq'),
            'produce'                       => $this->input->post('produce'),
            'host'                          => $this->input->post('host'),
            'hardware'                      => $this->input->post('hardware'),
            'sn'                            => $this->input->post('serial'),
            'version'                       => $this->input->post('version'),
            'license'                       => $this->input->post('license'),
            'manufacturer'                  => $this->input->post('manufacturer'),
            'duplication_yn'                => $this->input->post('duplication_yn'),
            'work_name'                     => $this->input->post('work_name'),
            'doc_num'                       => $doc_final,
            'total_time'                    => $total_time,
            'income_time'                   => (!empty($this->input->post('income_time'))) ? $this->input->post('income_time') : NULL,
            'start_time'                    => (!empty($this->input->post('start_time'))) ? $this->input->post('start_time') : NULL,
            'end_time'                      => (!empty($this->input->post('end_time'))) ? $this->input->post('end_time') : NULL,
            // 'income_time'                   => $this->input->post('income_time'),
            // 'start_time'                    => $this->input->post('start_time'),
            // 'end_time'                      => $this->input->post('end_time'),
            'engineer'                      => $this->input->post('engineer'),
            'engineer_seq'                  => $this->input->post('engineer_seq'),
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
            'comment'			                  => $this->input->post('comment'),
            'result'                        => $this->input->post('result'),
            'update_date'                   => date("Y-m-d H:i:s"),
            'sign_consent'                  => $this->input->post('sign_consent'),
            'cover'                         => $this->input->post('cover'),
            'logo'                          => $this->input->post('logo'),
            'some_inspection'               => $some_inspection,
            //KI1
            'schedule_seq'                  => $schedule_seq,
            'end_work_day'                  => $end_work_day,
            'failure_contents'              => $failure_data
            // 'schedule_seq'                  => $sch_seq
            //KI2

        );
    }else{
        $data1 = array(
            'forcasting_seq'		            => $forcasting_seq,
            'maintain_seq'                  => $maintain_seq,
            'customer'                      => $this->input->post('customerName'),
            'customer_manager'              => $customer_manager,
            'project_name'                  => $this->input->post('project_name'),
            'manager_mail'       		        => $manager_mail,
            'produce_seq'                   => $this->input->post('produce_seq'),
            'produce'                       => $this->input->post('produce'),
            'host'                          => $this->input->post('host'),
            'hardware'                      => $this->input->post('hardware'),
            'sn'                            => $this->input->post('serial'),
            'version'                       => $this->input->post('version'),
            'license'                       => $this->input->post('license'),
            'manufacturer'                  => $this->input->post('manufacturer'),
            'duplication_yn'                => $this->input->post('duplication_yn'),
            'work_name'                     => $this->input->post('work_name'),
            'doc_num'                       => $doc_final,
            'total_time'                    => $total_time,
            // 'income_time'                   => $this->input->post('income_time'),
            // 'start_time'                    => $this->input->post('start_time'),
            // 'end_time'                      => $this->input->post('end_time'),
            'income_time'                   => (!empty($this->input->post('income_time'))) ? $this->input->post('income_time') : NULL,
            'start_time'                    => (!empty($this->input->post('start_time'))) ? $this->input->post('start_time') : NULL,
            'end_time'                      => (!empty($this->input->post('end_time'))) ? $this->input->post('end_time') : NULL,
            'engineer'                      => $this->input->post('engineer'),
            'engineer_seq'                  => $this->input->post('engineer_seq'),
            'handle'                        => $this->input->post('handle'),
            'subject'                       => $this->input->post('subject'),
            'work_process_time'             => $work_process_time,
            'work_process'                  => $work_process,
            'err_type'                      => $this->input->post('err_type'),
            'warn_level'                    => $this->input->post('warn_level'),
            'warn_type'                     => $this->input->post('warn_type'),
            'work_action'                   => $this->input->post('work_action'),
            'comment'			                  => $this->input->post('comment'),
            'result'                        => $this->input->post('result'),
            'update_date'                   => date("Y-m-d H:i:s"),
            'sign_consent'                  => $this->input->post('sign_consent'),
            'cover'                         => $this->input->post('cover'),
            'logo'                          => $this->input->post('logo'),
            'some_inspection'               => $some_inspection,
            //KI1
            'schedule_seq'                  => $schedule_seq,
            'end_work_day'                  => $end_work_day,
            'failure_contents'              => $failure_data
            // 'schedule_seq'                  => $sch_seq
            //KI2
        );
    }


        if ($seq == null) {                     // insert 모드
            $data2 = array(
                'writer'                    => $this->name,
                'writer_seq'                => $this->seq,
                'insert_date'               => date("Y-m-d H:i:s")
                );

            $data = array_merge($data1, $data2);

            //임시저장 여부
            if(empty($before_type)){

              if($type == 'N'){ //임시저장tbl
                $data['db_name'] = 'N';
                $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0);
                // $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0);
                $insert_seq = $result;
                // return true;

              }else{ //기존 등록tbl
                $data['db_name'] = 'Y';
                $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0);

                //정기점검보고서 썼을때 유지보수에서 점검여부 완료로 수정 하는고
                $insert_seq = $result;
                if ($result && (($this->input->post('work_name')=='정기점검' || $this->input->post('work_name')=='정기점검2') && $this->group != '기술연구소')){
                    $result = $this->STC_tech_doc->maintain_result($some_inspection,$data);
                }

                //KI1 기지보 혹은 일정에서 작성 완료했을때 해당 일정 +1해줌
                if($data['schedule_seq'] != null){
                  $income_time = $this->input->post('income_time');
                  $end_work_day = $this->input->post('end_work_day');
                  if($end_work_day!=''){
                    $count = (abs(strtotime($end_work_day) - strtotime($income_time))/60/60/24)+1;
                    $this->STC_tech_doc->schedule_update($data['schedule_seq'], $count);
                  } else {
                    $this->STC_tech_doc->schedule_update($data['schedule_seq']);
                  }
                }
                // KI2
              }
            }
            // KI2

        } else {                                        // modify 모드
            $data2 = array(
                'writer'                    => $this->input->post('writer'),
                'writer_seq'                => $this->seq,
            );

            $data = array_merge($data1, $data2);

            //임시저장 여부
            if(!empty($before_type)){

              if($before_type == 'N'){ //이전 등록페이지가 임시저장이었다.
                if($type == 'N'){ //임시저장 페이지에서 다시 임시저장을 한다.(수정)
                  $data['db_name'] = 'N';
                  $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 1, $seq);

                }else{ //임시저장 페이지에서 등록을 한다.
                  $data['db_name'] = 'Y';
                  $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0, $seq);
                  $insert_seq = $result;

                  if ($result && (($this->input->post('work_name')=='정기점검' || $this->input->post('work_name')=='정기점검2') && $this->group != '기술연구소')){
                    $result = $this->STC_tech_doc->maintain_result($some_inspection,$data);
                  }

                  //KI1 기지보 혹은 일정에서 작성 완료했을때 해당 일정 +1해줌
                  if($data['schedule_seq'] != null){
                    // $income_time = $this->input->post('income_time');
                    // $end_work_day = $this->input->post('end_work_day');
                    $this->STC_tech_doc->schedule_update($data['schedule_seq']);
                    // if($end_work_day!=''){
                    //   $count = (abs(strtotime($end_work_day) - strtotime($income_time))/60/60/24)+1;
                    //   $this->STC_tech_doc->schedule_update($data['schedule_seq'], $count);
                    // } else {
                    //   $this->STC_tech_doc->schedule_update($data['schedule_seq']);
                    // }
                  }
                  // KI2

                }
              }else if($before_type == "Y"){ //이전 등록페이지가 등록페이지였다.
                if($type == 'N'){ //등록 페이지에서 임시저장을 한다.
                  $data['db_name'] = 'N';
                  $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 0, $seq);
                  $insert_seq = $result;

                  //KI1 기지보 혹은 일정에서 작성 완료했을때 해당 일정 +1해줌
                  if($data['schedule_seq'] != null){
                    $income_time = $this->input->post('income_time');
                    $end_work_day = $this->input->post('end_work_day');
                    if($end_work_day!=''){
                      $count = (abs(strtotime($end_work_day) - strtotime($income_time))/60/60/24)+1;
                      $this->STC_tech_doc->schedule_delete($data['schedule_seq'], $count);
                      // $this->STC_tech_doc->schedule_update($data['schedule_seq'], $count);
                    } else {
                      $this->STC_tech_doc->schedule_delete($data['schedule_seq']);
                      // $this->STC_tech_doc->schedule_update($data['schedule_seq']);
                    }
                  }
                  // KI2


                }else{ //등록 페이지에서 다시 등록을 한다(수정)
                  $data['db_name'] = 'Y';
                  $result = $this->STC_tech_doc->tech_doc_insert($data, $mode = 1, $seq);

                }
              }
            }

        }

        // 요청사항 && 이슈 && 버그추가
        $request = trim($this->input->post('request'));
        $issue = trim($this->input->post('issue'));
        $bug = trim($this->input->post('bug'));
        if(!isset($insert_seq)){
            $insert_seq = $seq;
        }
        $req = $this->STC_tech_doc->request_insert(3,$insert_seq);
        if(empty($req) && $request != ""){
            $request_data = array(
                'tech_doc_seq' => $insert_seq,
                'customer_companyname' =>$data['customer'],
                'contents' => $request,
                'insert_date' => date("Y-m-d H:i:s"),
                'writer_id' => $this->id
            );
            $result = $this->STC_tech_doc->request_insert(0,$request_data);
        }else if(!empty($req)){
            $request_data = array(
                'seq' => $req['seq'],
                'contents' => $request,
                'update_date' => date("Y-m-d H:i:s"),
                'writer_id' => $this->id
            );
            $result = $this->STC_tech_doc->request_insert(1,$request_data);
        }

        $iss = $this->STC_tech_doc->issue_insert(3,$insert_seq);
        if(empty($iss) && $issue != ""){
            $issue_data = array(
                'tech_doc_seq' => $insert_seq,
                'customer_companyname' =>$data['customer'],
                'contents' => $issue,
                'insert_date' => date("Y-m-d H:i:s"),
                'writer_id' => $this->id
            );
            $result = $this->STC_tech_doc->issue_insert(0,$issue_data);
        }else if(!empty($iss)){
            $issue_data = array(
                'seq' => $iss['seq'],
                'contents' => $issue,
                'update_date' => date("Y-m-d H:i:s"),
                'writer_id' => $this->id
            );
            $result = $this->STC_tech_doc->issue_insert(1,$issue_data);
        }

        $bugging = $this->STC_tech_doc->bug_insert(3,$insert_seq);
        if(empty($bugging) && $bug != ""){
            $bug_data = array(
                'tech_doc_seq' => $insert_seq,
                'customer_companyname' =>$data['customer'],
                'contents' => $bug,
                'insert_date' => date("Y-m-d H:i:s"),
                'writer_id' => $this->id
            );
            $result = $this->STC_tech_doc->bug_insert(0,$bug_data);
        }else if(!empty($bugging)){
            $bug_data = array(
                'seq' => $bugging['seq'],
                'contents' => $bug,
                'update_date' => date("Y-m-d H:i:s"),
                'writer_id' => $this->id
            );
            $result = $this->STC_tech_doc->bug_insert(1,$bug_data);
        }

        // // 요청사항, 이슈, 버그에 내용이 있으면 메일전송
        // if($request_data || $issue_data || $bug_data){
        //   $mail_data = $this->STC_tech_doc->send_mail($tech_doc_seq); // 근데 request_data엔 tech_doc_seq가 없다..
        //   $mail_address = $writer_id."@durianit.co.kr";
        //   // for($i=0; $i<count($mail_data); $i++){
        //   //     $mail_address .= ";".$mail_data[$i]['user_email'];
        //   // }
        //   if(trim($mail_address) != ""){
        //
        //       //메일 제목 작성
        //       $subject = "[기술지원보고서]요청사항/이슈/버그사항";
        //       $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";
        //
        //
        //       //메일 본문 작성
        //       $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        //       <html xmlns='http://www.w3.org/1999/xhtml'>
        //       <head>
        //           <title>두리안정보기술센터-sales Center</title>
        //           <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        //       </head>
        //       <body>";
        //
        //       $html_code .= "<h3>* [기술지원보고서]요청사항/이슈/버그사항 알림 </h3>";
        //
        //       $html_code .=
        //           "<table style='width:1000px;border-collapse:collapse;border:1px solid;border-color:#d7d7d7'>
        //               <tr>
        //                   <td width='200px' bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>해당서비스</td>
        //                   <td width='500px' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>기술지원보고서</td>
        //               </tr>
        //               <tr>
        //                   <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>요청사항</td>
        //                   <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$request}</td>
        //               </tr>";
        //
        //       $html_code .= "
        //           <tr>
        //               <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>이슈</td>
        //               <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$issue }</td>
        //           </tr>
        //           <tr>
        //               <td bgcolor='f8f8f9' style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>버그</td>
        //               <td style='padding:0px 10px 0px 10px;border:1px solid;border-color:#d7d7d7;'>{$bug}</td>
        //           </tr>";
        //
        //
        //       $html_code .= "</table>
        //       <br><br><br>
        //       <div style='width:100%;text-align:center;'>
        //           <a href='http://sales.durianit.co.kr/index.php/tech/tech_board/tech_issue' style='margin:auto;display:inline-block;padding:10px 10px 10px 10px;color:#fff;font-weight:bold;text-align:center;text-decoration:none;border-radius:2px;font-size:1em;background:#cc282b;'>요청/이슈/버그 바로가기</a>
        //       </div>
        //       </body>
        //       </html>";
        //
        //       $body = str_replace("send_address",$mail_address,$html_code);
        //
        //       $headers = "From: =?utf-8?B?".base64_encode("sale@durianit.co.kr")."?= <sale@durianit.co.kr> \n";
        //       // $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
        //       $headers .= 'MIME-Version: 1.0' . "\r\n";
        //       $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        //       $headers .= "Content-Transfer-Encoding: base64\r\n";
        //
        //       //메일 보내기
        //       $result = mail($mail_address, $subject, chunk_split(base64_encode($body)), $headers);
        //   }
        // }

        // #해시태그 추가
        $hashtag = $this->input->post('hashtag');
        $hashtag = preg_replace('/[," "]+/', '', $hashtag);  //',', 모든공백 제거
        $hashtag_arr = explode('#', $hashtag);

        if($insert_seq != null) {
          $insert_seq = $insert_seq;
        } else {
          $insert_seq = $seq;
        }

        $this->STC_tech_doc->hashtag_reset($insert_seq); //초기화

        if(!empty($hashtag_arr)) {
          for($i = 0; $i < count($hashtag_arr); $i++) {
            $hashtag = $hashtag_arr[$i];
            if ($hashtag != '') {
              $hashtag_cnt = $this->STC_tech_doc->hashtag_cnt($hashtag);
              if ($hashtag_cnt['cnt'] == 0) {
                $hashtag_data['hashtag_name'] = $hashtag;
                $hashtag_seq = $this->STC_tech_doc->hashtag_insert($hashtag_data);
              } else {
                $hashtag_seq = $this->STC_tech_doc->hashtag_select($hashtag);
                $hashtag_seq = $hashtag_seq['seq'];
              }

                if($type == 'N'){  //임시저장
                  $hashtag_info = array(
                   'hashtag_seq' => $hashtag_seq,
                   'tb_name' => 'tech_doc_basic_temporary_save',
                   'tb_seq' => $insert_seq
                  );

                } else {
                  $hashtag_info = array(
                   'hashtag_seq' => $hashtag_seq,
                   'tb_name' => 'tech_doc_basic',
                   'tb_seq' => $insert_seq
                  );

                }

              $result = $this->STC_tech_doc->hashtag_link_insert($hashtag_info);
            }
          }
        }

        if ($result) {
            echo "<script>alert('정상적으로 처리 되었습니다.');location.href='".site_url()."/tech/tech_board/tech_doc_list?type={$type}';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }
    }

    function tech_doc_view() {

        if( $this->id === null) {
            redirect( 'account' );
        }

        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );
        // $type = $this->input->get( 'type' );
        if(!empty($this->input->get( 'type' ))){
          $type = $this->input->get( 'type' );
        }else{
          $type = $_GET['type'];
        }
        // if(!empty($_GET['type'])){
        //   $type = $_GET['type'];
        // }else{
        //   $type = $this->input->get( 'type' );
        // }

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, $type);
        $data['hashtag'] = $this->STC_tech_doc->hashtag_view($seq, $type); //해시태그 뷰
        $data['bug_val'] = $this->STC_tech_doc->bug_view($seq);// 기지보 뷰 버그
        $data['product_company'] = $this->STC_tech_doc->product_company();

        $data['sign_img'] = $this->STC_tech_doc->find_sign_img($data['view_val']['writer']);

        if( $data['view_val']['schedule_seq'] != '' ){
          $data['schedule'] = $this->STC_tech_doc->schedule_file_info($data['view_val']['schedule_seq']);
        };
        //포캐스팅+유지보수
        // $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer'] = $this->STC_tech_doc->get_customer3();
        $data['customer2'] = $this->STC_tech_doc->get_customer2();
        $data['seq'] = $seq;
        $data['group_member'] = $this->STC_User ->same_group_member($this->group);
        $data['request'] = $this->STC_tech_doc ->request_insert(3,$seq);//요청사항
        $data['issue'] = $this->STC_tech_doc -> issue_insert(3,$seq);//이슈사항
        $data['excellent_check'] = $this->STC_tech_doc->excellent_check_list($seq);
        if($mode == "view") {
            $data['cover'] = $this->STC_tech_doc->cover_select( $data['view_val']['cover'] );
            // $data['night'] = $this->STC_tech_doc->night_document($seq); //야간근무결과보고서
            // $data['weekend'] = $this->STC_tech_doc->weekend_document($seq); //주말근무결과보고서
            // $data['trip'] = $this->STC_tech_doc->trip_document($seq); //출장보고서
            $data['approval_document'] = $this->STC_tech_doc->approval_document($seq); // 근무결과보고서
            $this->load->view('tech/tech_doc_view', $data );
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
            $this->load->view('tech/tech_doc_modify', $data );
        }
    }

    function tech_doc_view_test() {

        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model('STC_tech_doc');
        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
        //포캐스팅+유지보수
        // $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer'] = $this->STC_tech_doc->get_customer3();
        $data['seq'] = $seq;
        if($mode == "view") {
            $this->load->view('tech/tech_doc_view_test', $data );
        } else {
            $this->load->view('tech/tech_doc_modify_test', $data );
        }
    }

    function tech_doc_print_action() {
        // $this->load->Model('STC_tech_doc');
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
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
        $sign = $this->STC_tech_doc->find_sign_img($data['view_val']['writer']);
        if($sign['sign_changename'] != '') {
          $data['sign_path'] = "/misc/upload/user_sign/{$sign['sign_changename']}";
        } else {
          $data['sign_path'] = "/misc/img/{$data['view_val']['writer']}.png";
        }
        $this->load->view('tech/tech_doc_print', $data );
    }

    function tech_doc_print_page() {
        // $this->load->Model('STC_tech_doc');


        if(isset($_GET['seq'])){
            $seq = base64_decode($_GET['seq']);
        }
        // echo "<script>alert('{$seq}');</script>";

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
        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
        $data['cover'] = $this->STC_tech_doc->cover_select($data['view_val']['cover']);
        $data['seq'] = $seq;
        $this->load->view('tech/tech_doc_print_page', $data );
    }

    function tech_doc_pdf() {
        // $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
        $data['cover'] = $this->STC_tech_doc->cover_select($data['view_val']['cover']);
        $sign = $this->STC_tech_doc->find_sign_img($data['view_val']['writer']);
        if($sign['sign_changename'] != '') {
          $data['sign_path'] = "/misc/upload/user_sign/{$sign['sign_changename']}";
        } else {
          $data['sign_path'] = "/misc/img/{$data['view_val']['writer']}.png";
        }
        $this->load->view('tech/tech_doc_pdf', $data );
    }

    function tech_doc_pdf_logo() {
        // $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }

        $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
        // $data['cover'] = $this->STC_tech_doc->cover_select($data['view_val']['cover']);
        $this->load->view('tech/tech_doc_pdf_logo', $data );
    }

    //기술지원보고서 고객사 서명 후 pdf mail로 전송
    function tech_doc_pdf_send_mail(){
        // $this->load->Model('STC_tech_doc');
        if(isset($_GET['seq'])){
            $seq = $this->input->get( 'seq' );
        }
        exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -L 19mm -B 10mm  --footer-html http://sales.durianit.co.kr/index.php/tech/tech_board/tech_doc_pdf_logo?seq={$seq} http://sales.durianit.co.kr/index.php/tech/tech_board/tech_doc_pdf?seq={$seq} /var/www/html/stc/misc/upload/tech/tech/techpdf.pdf");

        $view_val = $this->STC_tech_doc->tech_doc_view($seq, 'Y');
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
        // $this->load->Model(array( 'STC_tech_doc' ));
        //임시저장 여부
        $type = $this->input->get( 'type' );
        // 임시저장 여부
        $seq = $this->input->get( 'seq' );
        $schedule_seq = $this->input->get( 'schedule_seq' );
        if ($seq != null) {
            //KI1
            //KI1 기지보 혹은 일정에서 작성삭제 했을때 해당 일정 -1해줌
            if ($schedule_seq != '' && $type != 'N'){
              // $result = $this->STC_tech_doc->same_schedule_delete($schedule_seq);
              // if($result){
              //   foreach ($result as $seq_val) {
              //     $this->STC_tech_doc->schedule_delete($seq_val->seq);
              //   }
              // }else{
              $doc = $this->STC_tech_doc->find_end_work_day($seq);
              if ($doc['end_work_day']!=''){
                $income_time = $doc['income_time'];
                $end_work_day = $doc['end_work_day'];

                $count = (abs(strtotime($end_work_day) - strtotime($income_time))/60/60/24)+1;
                // echo $count;
                $this->STC_tech_doc->schedule_delete($schedule_seq, $count);
              } else {
                $this->STC_tech_doc->schedule_delete($schedule_seq);
              }
              // }
            }
            //KI2
            $tdata = $this->STC_tech_doc->tech_doc_delete($seq, $type);
            $this->STC_tech_doc->hashtag_reset($seq); //해시태그링크도 삭제
        }
        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech/tech_board/tech_doc_list?type={$type}';</script>";
            // echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech/tech_board/tech_doc_list';</script>";
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model(array('STC_tech_doc'));
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

      if($this->agent->is_mobile) {
        $data['title'] = '장비/시스템';
        $this->load->view('tech/tech_device_list_mobile', $data);
      } else {
        $this->load->view('tech/tech_device_list', $data);
      }
    }


    // 장비등록  보기/수정 뷰
    function tech_device_view() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model(array('STC_tech_doc'));
        $mode = $this->input->get( 'mode' );
        //포캐스팅+유지보수
        // $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer'] = $this->STC_tech_doc->get_customer3();
        // $product_serial = $this->input->get( 'product_serial' );
        $seq = $this->input->get( 'seq' );

        $data['view_val'] = $this->STC_tech_doc->tech_device_view($seq);
        $data['check_list'] =$this->STC_tech_doc->check_list_template('all');
//	print_r($data['view_val']);
        $data['seq'] = $seq;
        if($mode == "view") {
          if($this->agent->is_mobile()){
            $data['title'] = '장비/시스템';
            $this->load->view('tech/tech_device_view_mobile', $data );
          } else {
            $this->load->view('tech/tech_device_view', $data );
          }
        } else {
            $this->load->view('tech/tech_device_modify', $data );
        }
    }


    function tech_device_input(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array('STC_tech_doc'));

        //포캐스팅+유지보수
        // $data['customer'] = $this->STC_tech_doc->get_customer();
        $data['customer'] = $this->STC_tech_doc->get_customer3();
        $this->load->view('tech/tech_device_input', $data );
    }

    function tech_device_input_action() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        $this->load->helper('alert');
        // $this->load->Model(array( 'STC_tech_doc' ));
        $seq = $this->input->get( 'seq' );
        if ($seq != null) {
            $tdata = $this->STC_tech_doc->tech_device_delete($seq);
        }
        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech/tech_board/tech_device_list';</script>";
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
        $sql = "(SELECT sp.seq AS product_seq,sp.integration_maintain_seq, sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, p.product_company, p.product_type, p.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,p.product_item, sp.fortigate_licence, sp.duplicate_yn FROM sales_maintain_product sp, product p where sp.product_code = p.seq and sp.maintain_seq = {$seq} ORDER BY sp.seq asc, p.product_company DESC)
        UNION
        (SELECT sp.seq AS product_seq,sp.integration_maintain_seq, sp.product_code, sp.product_supplier, sp.product_licence, sp.product_serial, sp.product_state, ip.product_company, ip.product_type, ip.product_name, sp.maintain_begin,sp.maintain_expire,sp.product_version,sp.custom_title,sp.custom_detail,sp.maintain_yn,sp.maintain_target,sp.product_check_list,sp.product_host,sp.product_sales,sp.product_purchase,sp.product_profit,ip.product_item AS product_item, sp.fortigate_licence, duplicate_yn FROM sales_maintain_product sp, sales_integration_maintain_product ip where ip.seq = sp.integration_maintain_product_seq and sp.maintain_seq = {$seq} ORDER BY sp.seq asc, ip.product_company DESC)";

        $data['input'] = $this->db->query($sql)->result_array();
      }else{
        $data['input'] = $this->db->query("SELECT *,t2.seq AS product_seq FROM sales_forcasting AS t1 join sales_forcasting_product AS t2 JOIN product AS t3 ON t1.seq=t2.forcasting_seq AND t2.product_code=t3.seq WHERE t1.seq= {$seq}")->result_array();
      }

      $data['product_company'] = $this->STC_tech_doc->product_company();

      $this->load->view( 'tech/search_device',$data );
    }

    function search_se(){
      if($this->cooperation_yn == 'N') {
        $data = $this->db->query("SELECT * FROM user WHERE company_name LIKE '%두리안정보%' and quit_date is null and cooperation_yn = 'N';")->result();
      } else {
        $data = $this->db->query("SELECT * FROM user WHERE cooperation_yn = 'Y'")->result();
      }
      $this->load->view('tech/search_se',array('input'=>$data));
    }

    function search_manager(){
      $tmp = $_GET['name'];
      $mode= $_GET['mode'];
    //   $data = $this->db->query("select * from sales_forcasting where seq='".$tmp."'")->result();
      if($mode == "maintain"){
        $data = $this->db->query("SELECT * FROM sales_maintain WHERE seq='{$tmp}'")->result();
      }else{
        $data = $this->db->query("SELECT * FROM sales_forcasting WHERE seq='{$tmp}'")->result();
      }

      $this->load->view('tech/search_manager',array('input'=>$data));
    }

    function tech_doc_signature(){
        // $tmp = $_GET['name'];
        // $data = $this->db->query("select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t1.seq='".$tmp."'")->result();
        // $this->load->view('tech/search_device',array('input'=>$data));
        $data = $this->db->query("SELECT * FROM sales_forcasting ")->result();
        $this->load->view('tech/tech_doc_signature',array('input'=>$data));
    }

    //제품별 템플릿 생성 페이지
    function product_check_list_input(){
      //   $data = $this->db->query("select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t1.seq='".$tmp."'")->result();
        $data = $this->db->query("select * from product_check_list_template ORDER BY seq asc")->result();
        $this->load->view('tech/product_check_list_input',array('input'=>$data));
    }

    //제품별 템플릿 생성
    function product_check_list_input_action(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        // $this->load->Model(array( 'STC_tech_doc' ));
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $seq = $this->input->get('seq');
        $data['check_item']= $this->STC_tech_doc->check_list_template($seq);

        $this->load->view('tech/product_check_list_view',$data);
    }

    //제품별 템플릿 리스트
    function product_check_list(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('tech/product_check_list',$data);
    }

    //제품별 템플릿 커스텀
    function product_check_list_custom(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $seq = $this->input->get('seq');
        $data['view_val']= $this->STC_tech_doc->check_list_template($seq);
        $this->load->view('tech/product_check_list_custom',$data);

    }

    //제품별 템플릿 삭제
    function product_check_list_delete(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $seq =  $this->input->get('seq');
        $result = $this->STC_tech_doc->product_check_list_delete($seq);
        if($result) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech/tech_board/product_check_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
        }
    }

    //제품별 템플릿 수정
    function product_check_list_modify(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $seq = $this->input->get('seq');
        $data['view_val']= $this->STC_tech_doc->check_list_template($seq);
        $this->load->view('tech/product_check_list_modify',$data);
    }

    //제품별 템플릿 수정
    function product_check_list_update_action(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $data['cover'] = $this->STC_tech_doc->cover_select();
        $this->load->view('tech/cover_upload',$data);
    }

    //표지 등록 ok
    function cover_upload_ok(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        // $this->load->view('tech/cover_upload_ok');
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
                    echo "<script>alert('파일이 너무 큽니다. {$error}');location.href='".site_url()."/tech/tech_board/cover_upload'</script>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<script>alert('파일이 첨부되지 않았습니다. {$error}');location.href='".site_url()."/tech/tech_board/cover_upload'</script>";
                    break;
                default:
                    echo "<script>alert('파일이 제대로 업로드되지 않았습니다.{$error}');location.href='".site_url()."/tech/tech_board/cover_upload'</script>";
            }
            exit;
        }

        // 확장자 확인
        if( !in_array($ext, $allowed_ext) ) {
            echo "<script>alert('허용되지 않는 확장자입니다.');location.href='".site_url()."/tech/tech_board/cover_upload'</script>";
            exit;
        }

        // 파일 이동
        move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$name");

        $result = $this->STC_tech_doc->cover_insert($name);

        if($result){
            echo "<script>alert('표지가 등록되었습니다.');location.href='".site_url()."/tech/tech_board/cover_upload';</script>";
        }else{
            echo "<script>alert('표지가 등록 실패.');location.href='".site_url()."/tech/tech_board/cover_upload';</script>";
        }
    }

    //표지 삭제
    function cover_delete() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model(array( 'STC_tech_doc' ));
        unlink($this->input->server('DOCUMENT_ROOT')."/misc/img/cover/".$_GET['filename']);

        $result = $this->STC_tech_doc->cover_delete($_GET['seq']);

        if($result){
            echo "<script>alert('표지가 삭제되었습니다.');location.href='".site_url()."/tech/tech_board/cover_upload';</script>";
        }else{
            echo "<script>alert('표지가 삭제 실패.');location.href='".site_url()."/tech/tech_board/cover_upload';</script>";
        }

    }

    //표지 좌표찍기
    function cover_coordinate_update(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));

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
            echo "<script>alert('표지 좌표가 등록 되었습니다.');location.href='".site_url()."/tech/tech_board/cover_upload';</script>";
        }else{
            echo "<script>alert('표지 좌표가 등록 실패.');history.go(-1);</script>";
        }

    }

    //로고 등록
    function logo_upload(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));

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

        $this->load->view('tech/logo_upload',$data);
    }

    //로고 등록 ok
    function logo_upload_ok(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('tech/logo_upload_ok');
    }

    //표지 삭제
    function logo_delete() {
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        // $data['check_item']= $this->STC_tech_doc->check_list_template("all");

        $this->load->view('tech/logo_delete');

    }

    //커버 위치(좌표) 찍기
    function cover_coordinate() {
        if( $this->id === null) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        // $this->load->Model(array( 'STC_tech_doc' ));
        $data['cover']= $this->STC_tech_doc->cover_select($_GET['seq']);

        $this->load->view('tech/cover_coordinate',$data);
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model(array('STC_tech_doc','STC_request_tech_support'));
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
        $data['responsibility'] = $this->STC_request_tech_support->responsibility();
        $data['durian_engineer'] = $this->STC_request_tech_support->durian_engineer('all');

        if($this->agent->is_mobile()) {
          $data['title'] = '기술지원요청';
          $this->load->view('tech/request_tech_support_list_mobile', $data);
        } else {
          $this->load->view('tech/request_tech_support_list', $data );
        }


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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model(array( 'STC_request_tech_support' ));
        $data['cooperative_company'] = $this->STC_request_tech_support->cooperative_company();
        $person = $this->STC_request_tech_support->responsibility();
        $person1 = $person->person1;
        $person2 = $person->person2;
        $per_seq = "^{$person1}$|^{$person2}$";
        $data['durian_engineer'] = $this->STC_request_tech_support->durian_engineer($per_seq);

        $this->load->view('tech/request_tech_support_input',$data);
    }

// 담당자 변경
    function change_function(){
      $seq = $this->input->post('seq');
      $person1 = $this->input->post('person1');
      $person2 = $this->input->post('person2');

      $update_data = array(
        'person1' => $person1,
        'person2' => $person2
      );

      $data = $this->STC_request_tech_support->change_person($seq, $update_data);

      echo json_encode($data);
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

         // $this->load->Model(array( 'STC_request_tech_support' ));
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

         if ($seq == null) {
           $durian_manager = $this->input->post('durian_manager');
           $manager_seq = $durian_manager[0].",".$durian_manager[1];
         }

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

            $connection = ssh2_connect('192.168.0.80', 22);
            ssh2_auth_password($connection, 'root', 'durian12#');

            $file_upload=ssh2_scp_send($connection, $newFilePath, "/var/www/html/stc/misc/upload/tech/request_tech_support/".$lcfilename, 0644);

            if(!$file_upload){
                echo "<script>alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.')</script>";
                exit;
            }

            ssh2_exec($connection, 'exit');


            $data1 = array(
                'sortation'		                 => $this->input->post('sortation'),
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
                'etc'			                      => $this->input->post('etc'),
                'result'                        => $this->input->post('result'),
                'final_approval'                => $this->input->post('final_approval'),
                'file_change_name'              => $lcfilename,
                'file_real_name'                => $filename,
                'tax'                           => $this->input->post('tax'),
                'update_date'                   => date("Y-m-d H:i:s"),
                'manager_mail_send'             => $this->input->post('manager_mail_send'),
                'engineer_mail_send'            => $this->input->post('engineer_mail_send'),
                'visit_count'                    => $this->input->post('visit_count'),
                'visit_date'                    => $this->input->post('visit_date'),
                'visit_remark'                  => $this->input->post('visit_remark'),

            );
        }else{
            $data1 = array(
                'sortation'		                  => $this->input->post('sortation'),
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
                'etc'			                      => $this->input->post('etc'),
                'result'                        => $this->input->post('result'),
                'final_approval'                => $this->input->post('final_approval'),
                'tax'                           => $this->input->post('tax'),
                'update_date'                   => date("Y-m-d H:i:s"),
                'manager_mail_send'             => $this->input->post('manager_mail_send'),
                'engineer_mail_send'            => $this->input->post('engineer_mail_send'),
                'visit_count'                   => $this->input->post('visit_count'),
                'visit_date'                    => $this->input->post('visit_date'),
                'visit_remark'                  => $this->input->post('visit_remark'),
            );
        }

            if ($seq == null) {                     // insert 모드
                $data2 = array(
                    'durian_manager'=>$manager_seq,
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

                echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/tech/tech_board/request_tech_support_mail?seq={$result}';</script>";
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model('STC_request_tech_support');
        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );
        $data['cooperative_company'] = $this->STC_request_tech_support->cooperative_company();
        $data['view_val'] = $this->STC_request_tech_support->request_tech_support_view($seq);
        $durian_manager = $data['view_val']['durian_manager'];
        $manager_seq = explode(",",$durian_manager);
        $person1 = $manager_seq[0];
        $person2 = $manager_seq[1];
        $per_seq = "^{$person1}$|^{$person2}$";
        $data['durian_engineer'] = $this->STC_request_tech_support->durian_engineer($per_seq);

        $data['seq'] = $seq;
        if($mode == "view") {
            $this->load->view('tech/request_tech_support_view', $data );
        } else {
            $this->load->view('tech/request_tech_support_modify', $data );
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model('STC_request_tech_support');
        $seq = $this->input->get( 'seq' );
        // $mode = $this->input->get( 'mode' );
        $data['view_val'] = $this->STC_request_tech_support->request_tech_support_view($seq);
        $data['seq'] = $seq;

        $this->load->view('tech/request_tech_support_mail', $data );
    }

    function request_tech_support_delete_action(){
        if( $this->id === null) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}
        $this->load->helper('alert');
        // $this->load->Model(array( 'STC_request_tech_support' ));
        $seq = $this->input->get( 'seq' );
        $filelcname = $this->input->get( 'file_change_name' );
        if ($seq != null) {
            if(strpos($seq,",")!==false){ //,포함되어있을때 삭제할 게시물 여러 개 일때
                $eachSeq = explode(",",$seq);
                $eachFilelcname = explode(",",$filelcname);
                for($i=0; $i<count($eachSeq); $i++){
                    $fdata = $this->STC_request_tech_support->request_tech_support_file($eachSeq[$i], $eachFilelcname[$i]);
                    if (isset($fdata['file_change_name'])) {
                        $connection = ssh2_connect('192.168.0.80', 22);
                        ssh2_auth_password($connection, 'root', 'durian12#');
                        $sftp = ssh2_sftp($connection);
                        $del=ssh2_sftp_unlink($sftp,"/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
                    }
                    $tdata = $this->STC_request_tech_support->request_tech_support_delete($eachSeq[$i]);
                }
            }else{
                $fdata = $this->STC_request_tech_support->request_tech_support_file($seq, $filelcname);
                if (isset($fdata['file_change_name'])) {
                    $connection = ssh2_connect('192.168.0.80', 22);
                    ssh2_auth_password($connection, 'root', 'durian12#');
                    $sftp = ssh2_sftp($connection);
                    $del=ssh2_sftp_unlink($sftp,"/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
                }
                $tdata = $this->STC_request_tech_support->request_tech_support_delete($seq);
            }

        }

        if ($tdata) {
            echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/tech/tech_board/request_tech_support_list';</script>";
        } else {
            echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
        }
    }

    // 기술지원요청 첨부파일 다운로드처리
    function request_tech_support_download($seq, $filelcname) {
        $this->load->helper('alert');
        $this->load->helper('download');
        // $this->load->Model(array('STC_request_tech_support'));

        ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04

        $fdata = $this->STC_request_tech_support->request_tech_support_file($seq, $filelcname);


        if (!isset($fdata['file_change_name'])) {
            alert("파일 정보가 존재하지 않습니다.");
        }

        $connection = ssh2_connect('192.168.0.80', 22);
        ssh2_auth_password($connection, 'root', 'durian12#');
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
        // $this->load->Model('STC_request_tech_support');

        $fdata = $this->STC_request_tech_support->request_tech_support_file($seq, $filelcname);

        if (!isset($fdata['file_change_name'])) {
            alert("파일 정보가 존재하지 않습니다.");
        } else {
            $fdata2 = $this->STC_request_tech_support->request_tech_support_del($seq);
            if($fdata2) {
                unlink("/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
                // $connection = ssh2_connect('192.168.0.80', 22);
                // ssh2_auth_password($connection, 'root', 'durian12#');
                // $sftp = ssh2_sftp($connection);
                //
                // ssh2_sftp_unlink($sftp,"/var/www/html/stc/misc/upload/tech/request_tech_support/".$fdata['file_change_name']);
            }
            alert('파일이 정상적으로 삭제되었습니다.', site_url().'/tech/tech_board/request_tech_support_view?seq='.$seq );
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
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        // $this->load->Model('STC_request_tech_support');
        $seq = $this->input->get( 'seq' );
        $data['view_val'] = $this->STC_request_tech_support->request_tech_support_view($seq);
        if(strpos($seq,',') !== false){
            $data['manager'] = $this->STC_request_tech_support->cooperative_sales_manager($data['view_val'][0]['cooperative_company']);
        }else{
            $data['manager'] = $this->STC_request_tech_support->cooperative_sales_manager($data['view_val']['cooperative_company']);
        }
        $data['seq'] = $seq;

        $this->load->view('tech/request_tech_support_final_approval_mail', $data );
    }

    // 서명동의
	function signConsentUpdate(){
		$seq = $this->input->post( 'seq' );

		if( $seq == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->signConsentUpdate($seq);
			echo json_encode($result);
		}

	}

	// 서명동의취소
	function signConsentCancle(){
		$seq = $this->input->post( 'seq' );

		if( $seq == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->signConsentCancle($seq);
			echo json_encode($result);
		}

	}
	// 고객사서명동의
	function customerSignConsentUpdate(){
		$seq = $this->input->post( 'seq' );

		if( $seq == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->customerSignConsentUpdate($seq);
			echo json_encode($result);
		}

	}

	// 고객사서명동의취소
	function customerSignConsentCancle(){
		$seq = $this->input->post( 'seq' );

		if( $seq == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->customerSignConsentCancle($seq);
			echo json_encode($result);
		}
	}

	// 고객사 서명 src저장
	function customerSignSrc(){
		//imagesrc 암호화 복호화
		$g_bszUser_key = null;
		if(isset($_POST['KEY']))
			$g_bszUser_key = $_POST['KEY'];
		if($g_bszUser_key == null)
		{
			$g_bszUser_key = "88,E3,4F,8F,08,17,79,F1,E9,F3,94,37,0A,D4,05,89";
		}

		$g_bszIV = null;
		if(isset($_POST['IV']))
			$g_bszIV = $_POST['IV'];
		if($g_bszIV == null)
		{
			$g_bszIV = "26,8D,66,A7,35,A8,1A,81,6F,BA,D9,FA,36,16,25,01";
		}

		function encrypt($bszIV, $bszUser_key, $str) {
			$planBytes = explode(",",$str);
			$keyBytes = explode(",",$bszUser_key);
			$IVBytes = explode(",",$bszIV);

			for($i = 0; $i < 16; $i++)
			{
				$keyBytes[$i] = hexdec($keyBytes[$i]);
				$IVBytes[$i] = hexdec($IVBytes[$i]);
			}
			for ($i = 0; $i < count($planBytes); $i++) {
				$planBytes[$i] = hexdec($planBytes[$i]);
			}

			if (count($planBytes) == 0) {
				return $str;
			}
			$ret = null;
			$bszChiperText = null;
			$pdwRoundKey = array_pad(array(),32,0);

			//방법 1
			$bszChiperText = KISA_SEED_CBC::SEED_CBC_Encrypt($keyBytes, $IVBytes, $planBytes, 0, count($planBytes));

			$r = count($bszChiperText);

			for($i=0;$i< $r;$i++) {
				$ret .=  sprintf("%02X", $bszChiperText[$i]).",";
			}
			return substr($ret,0,strlen($ret)-1);
		}

		function strToHex($string){
			$hex='';
			for ($i=0; $i < strlen($string); $i++){
				$hex .= "," . dechex(ord($string[$i]));
			}
			return $hex;
		}

		$seq = $this->input->post( 'seq' );
		$src = $this->input->post( 'src' );
		$signer = $this->input->post( 'signer' );

		$srcData = str_split($src, 128);
		$imageSrc = '';
		for($i =0; $i <count($srcData); $i++){
			$result = $srcData[$i];
			$result = strToHex($result);
			$result = substr( $result , 1, strlen($result));
			$result = encrypt($g_bszIV, $g_bszUser_key, $result);
			$imageSrc .= $result.'@';
		  }
		$src = $imageSrc;

		if( $seq == null ) {
			redirect('');
		} else {
			// $this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->customerSignSrc($seq,$src,$signer);
			echo json_encode($result);
		}
	}

	// //점검항목 가져오기
	// function checkListSelect(){
	// 	// $this->load->Model(array('STC_tech_doc', 'STC_Common'));
	// 	$productName = $this->input->post( 'productName' );
	// 	$result = $this->STC_tech_doc->check_list_template($productName);
	// 	echo json_encode($result);
	// }

    // 우수보고서 선택
  function excellentReportInsert(){
    $seq = $this->input->post( 'seq' );
    $selector_seq = $this->seq;

    $data = array(
        'basic_seq' => $seq,
        'selector_seq' =>$selector_seq
    );

    $result = $this->STC_tech_doc->excellentReportInsert($data);
    echo json_encode($result);
  }

  // 우수보고서 취소
  function excellentReportCancle(){
    $seq = $this->input->post( 'seq' );

    if( $seq == null ) {
      redirect('');
    } else {
      $result = $this->STC_tech_doc->excellentReportCancle($seq);
      echo json_encode($result);
    }

  }

	//템플릿 가져오깅
	function template(){
		// $this->load->Model(array('STC_tech_doc', 'STC_Common'));
		$product = $this->input->post( 'product' );
		$result = $this->STC_tech_doc->template($product);
		echo json_encode($result);
    }

    //협력사에 메일 보냈는지 체크
	function mailSendCheck(){
		// $this->load->Model('STC_request_tech_support');
		$seq = $this->input->post( 'seq' );
		$check = $this->input->post( 'check' );
		$check_value = $this->input->post( 'check_value' );
		$result= $this->STC_request_tech_support->mailSendCheck($seq,$check,$check_value);
		echo json_encode($result);
	}

	//기술지원요청 최종승인
	function finalApproval(){
		$seq = $this->input->post( 'seq' );
		$result= $this->STC_request_tech_support->finalApproval($seq);
		echo json_encode($result);
	}

	//세금계산서 승인번호 저장
	function taxNumber(){
		$seq = $this->input->post( 'seq' );
		$tax = $this->input->post( 'tax' );
		$result= $this->STC_request_tech_support->taxNumber($seq,$tax);
		echo json_encode($result);
	}

    //요청사항 /이슈 보는 페이지
    function tech_issue(){
        if( $this->id === null ) {
            redirect( 'account' );
        }
        if($this->cooperation_yn == 'Y') {
    			echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
    		}

        $type = "request";
        if(isset($_GET['type'])){
            $type = $_GET['type'];
        }
        $data['type'] = $type;
        //filter
        if(isset($_GET['searchkeyword'])) {
            $search_keyword = $_GET['searchkeyword'];
        }
        else {
            $search_keyword = "";
        }

        if(isset($_GET['search1'])) {
            $search1 = $_GET['search1'];
        }
        else {
            $search1 = "";
        }

        if(isset($_GET['search2'])) {
            $search2 = $_GET['search2'];
        }
        else {
            $search2 = "";
        }

        $data['search_keyword'] = $search_keyword;
        $data['search1'] = $search1;
        $data['search2'] = $search2;

        $search = "";
        if($search_keyword!=""){
            if ($type != "incompletion") {
                if($search1 == "001"){
                    $search = "customer_companyname";
                }else if ($search1 == "002"){
                    $search = "contents";
                }else if ($search1 == "003"){
                    $search = "user_name";
                }
                $search = " and ".$search." like '%".$search_keyword."%'";
            }else{
                if($search1 == "001"){
                    $search = "customer";
                }else if ($search1 == "002"){
                    $search = "subject";
                }else if ($search1 == "003"){
                    $search = "writer";
                }else if ($search1 == "004"){
                    $search = "insert_date";
                }else if ($search1 == "005"){
                    $search = "result";
                }else if ($search1 == "006"){
                    $search = "produce";
                }
                $search = " and ".$search." like '%".$search_keyword."%'";

            }
        }


        //paging
        if(isset($_GET['cur_page'])) { //	현재 페이지
            $cur_page = $_GET['cur_page'];
        }else {
            $cur_page = 1;
        }

        $no_page_list = 10; //10개씩 보여준다는고지

        $data['cur_page'] = $cur_page;

        if($type == "request"){
            $data['view_val'] = $this->STC_tech_doc->request_insert(4,$search);
        }else if ($type == "issue"){
            $data['view_val'] = $this->STC_tech_doc->issue_insert(4,$search);
        }else if($type == "bug"){
            $data['view_val'] = $this->STC_tech_doc->bug_insert(4,$search);
        }else if ($type == "incompletion"){
            $data['view_val'] = $this->STC_tech_doc->tech_doc_basic_incompletion($search);
        }

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

        //포캐스팅+유지보수
        // $data['customer'] = $this->STC_tech_doc->get_customer();//고객사 불러오는고
        $data['customer'] = $this->STC_tech_doc->get_customer3();//고객사 불러오는고

      if($this->agent->is_mobile()) {
        $data['title'] = '요청/이슈';
        $this->load->view('tech/tech_issue_mobile',$data);
      } else {
        $this->load->view('tech/tech_issue',$data);
      }

    }

    function select_tech_issue(){
        $seq = $this->input->post( 'seq' );
		$type = $this->input->post( 'type' );
        if($type == "request"){
            $result = $this->STC_tech_doc->request_insert(5,$seq);
        }else if($type == "issue"){
            $result = $this->STC_tech_doc->issue_insert(5,$seq);
        }else if($type == "bug"){
            $result = $this->STC_tech_doc->bug_insert(5,$seq);
        }

		echo json_encode($result);
    }

    //요청/이슈 수저어엉엉
    function modify_tech_issue(){
        $type = $this->input->post( 'type' );
        $seq = $this->input->post( 'seq' );
        $customer_companyname = $this->input->post( 'customer_companyname' );
        $contents = $this->input->post( 'contents' );
        $result = $this->input->post( 'result' );
        $comment = $this->input->post( 'comment' );


        $data = array(
            'seq' => $seq,
            'customer_companyname' =>$customer_companyname,
            'contents' => $contents,
            'result' => $result,
            'comment' => $comment,
            'update_date' => date("Y-m-d H:i:s")
        );
        if($type == "request"){
            $res = $this->STC_tech_doc->request_insert(1,$data);
        }else if($type == "issue"){
            $res = $this->STC_tech_doc->issue_insert(1,$data);
        }else if($type == "bug"){
            $res = $this->STC_tech_doc->bug_insert(1,$data);
        }

        echo json_encode($res);
    }

    //요청/이슈 수저어엉엉
    function insert_tech_issue(){
        $type = $this->input->post( 'type' );
        $customer_companyname = $this->input->post( 'customer_companyname' );
        $contents = $this->input->post( 'contents' );
        $comment = $this->input->post( 'comment' );

        $data = array(
            'customer_companyname' =>$customer_companyname,
            'contents' => $contents,
            'comment' => $comment,
            'insert_date' => date("Y-m-d H:i:s"),
            'writer_id' => $this->id
        );

        if($type == "request"){
            $res = $this->STC_tech_doc->request_insert(0,$data);
        }else if($type == "issue"){
            $res = $this->STC_tech_doc->issue_insert(0,$data);
        }else if($type == "bug"){
            $res = $this->STC_tech_doc->bug_insert(0,$data);
        }

        echo json_encode($res);

    }

    // 시리얼 번호로 프로젝트 검색
      function search_serial(){
        $type = $this->input->get('type');
        $keyword = $this->input->get('keyword');

        $result = $this->STC_tech_doc->search_serial($type, $keyword);

        echo json_encode($result);
      }

    // 용역하도급 품의서에서 내용 불러올 때
    function req_support_info() {
      $seq = $this->input->post('seq');

      $result = $this->STC_request_tech_support->req_support_info($seq);

      echo json_encode($result);
    }

    function annual_bill_data() {
      $annual_seq = $this->input->post('seq');

      $result = $this->STC_request_tech_support->annual_bill_data($annual_seq);

      echo json_encode($result);
    }

    function save_request_support_bill() {
      $bill_seq = $this->input->post('bill_seq');
      $annual_doc_seq = $this->input->post('annual_doc_seq');
      $issuance_status = $this->input->post('issuance_status');
      $deposit_status = $this->input->post('deposit_status');
      $issue_schedule_date = $this->input->post('issue_schedule_date');
      $issuance_amount = $this->input->post('issuance_amount');
      $tax_amount = $this->input->post('tax_amount');
      $total_amount = $this->input->post('total_amount');
      $tax_approval_number = $this->input->post('tax_approval_number');
      $issuance_month = $this->input->post('issuance_month');
      $issuance_date = $this->input->post('issuance_date');
      $deposit_date = $this->input->post('deposit_date');

      if($issue_schedule_date == '') {
        $issue_schedule_date = null;
      }
      if($issuance_date == '') {
        $issuance_date = null;
      }
      if($deposit_date == '') {
        $deposit_date = null;
      }

      $data = array(
        'annual_doc_seq'      => $annual_doc_seq,
        'issuance_status'     => $issuance_status,
        'deposit_status'      => $deposit_status,
        'issue_schedule_date' => $issue_schedule_date,
        'issuance_amount'     => str_replace(',','',$issuance_amount),
        'tax_amount'          => str_replace(',','',$tax_amount),
        'total_amount'        => str_replace(',','',$total_amount),
        'tax_approval_number' => $tax_approval_number,
        'issuance_month'      => $issuance_month,
        'issuance_date'       => $issuance_date,
        'deposit_date'        => $deposit_date,
        'write_id'            => $this->id
      );

      if ($bill_seq == "") {
        $data['insert_date'] = date("Y-m-d H:i:s");
        $result = $this->STC_request_tech_support->save_request_support_bill($data, 'insert', 0);
      } else {
        $data['update_date'] = date("Y-m-d H:i:s");
        $result = $this->STC_request_tech_support->save_request_support_bill($data, 'update', $bill_seq);
      }
      echo json_encode($result);
    }

    // 제품 정보 저장
    function save_product_info() {
      $mode            = $this->input->post('mode');
      $product_seq     = $this->input->post('product_seq');
      $fortigate_licence = $this->input->post('fortigate_licence');

      if($fortigate_licence == '') {
        $fortigate_licence = null;
      }

      $data = array (
        'product_version'   => $this->input->post('product_version'),
        'product_serial'    => $this->input->post('product_serial'),
        'fortigate_licence' => $fortigate_licence,
        'duplicate_yn'      => $this->input->post('duplicate_yn'),
        'modify_id'         => $this->id
      );

      $result = $this->STC_tech_doc->save_product_info($mode, $product_seq, $data);

      echo json_encode($result);
    }

}

?>

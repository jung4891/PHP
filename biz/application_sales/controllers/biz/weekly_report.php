<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Weekly_report extends CI_Controller {
    var $id = '';

    function __construct() {
        parent::__construct();
        $this->id = $this->phpsession->get( 'id', 'stc' );
        $this->name = $this->phpsession->get( 'name', 'stc' );
        $this->lv = $this->phpsession->get( 'lv', 'stc' );
        $this->company = $this->phpsession->get( 'company', 'stc' );
        $this->email = $this->phpsession->get('email','stc'); //김수성추가
        $this->seq = $this->phpsession->get( 'seq', 'stc' );
        $this->group = $this->phpsession->get( 'group', 'stc' );
        $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
        $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

        if($this->cooperation_yn == 'Y') {
          echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
        }

        $this->load->library('user_agent');

        $this->load->Model('biz/STC_weekly_report');
    }

	function weekly_report_list(){

        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model(array('STC_weekly_report'));
        if(isset($_GET['cur_page'])) {
            $cur_page = $_GET['cur_page'];
        }
        else {
            $cur_page = 0;
                }                                                                                                               //      현재 페이지

        $no_page_list = 10;                                                                             //      한페>이지에 나타나는 목록 개수

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
        if  ( $cur_page <= 0 )
            $cur_page = 1;
        $data['cur_page'] = $cur_page;

        $user_list_data = $this->STC_weekly_report->weekly_report_list($search_keyword,$search_keyword2,$search1,( $cur_page - 1 ) * $no_page_list, $no_page_list);
        $data['count'] = $this->STC_weekly_report->weekly_report_list_count($search_keyword,$search_keyword2,$search1)->ucount;
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
        $data['tech_group'] = $this->STC_weekly_report->techGroup();

        if($this->agent->is_mobile()) {
          $data['title'] = '주간보고';
          $this->load->view('biz/weekly_report_list_mobile', $data);
        } else {
          $this->load->view('biz/weekly_report_list', $data );
        }
    }

    function weekly_report_view() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

        // $this->load->Model('STC_weekly_report');

        $seq = $this->input->get( 'seq' );
        $mode = $this->input->get( 'mode' );

        $data['customer'] = $this->STC_weekly_report->get_customer();
        $data['maintain_customer'] = $this->STC_weekly_report->maintain_customer();
        $data['view_val'] = $this->STC_weekly_report->weekly_report_view($seq);
        $data['work_name'] = $this->STC_weekly_report->work_name_config();
        // if($data['view_val']['group_name'] !='기술본부'){

        $data['current_doc'] = $this->STC_weekly_report->weekly_report_doc_view($seq);
        $data['current_total'] = $this->STC_weekly_report->weekly_report_doc_total($seq);
        $data['current_cnt'] = $this->STC_weekly_report->weekly_report_doc_count($seq,$data['view_val']['year'],$data['view_val']['month'],$data['view_val']['group_name']);

        $data['next_doc'] = $this->STC_weekly_report->next_weekly_report_doc_view($seq);
        $data['next_total'] = $this->STC_weekly_report->next_weekly_report_doc_total($seq);
        $data['next_cnt'] = $this->STC_weekly_report->next_weekly_report_doc_count($seq,$data['view_val']['group_name']);

        $data['seq'] = $seq;

        $read_count = $this->STC_weekly_report->weekly_report_read_count($seq, $this->seq);
      	if ($read_count['cnt'] == 0) {
      		$read = array(
      			'notice_seq' => $seq,
      			'user_seq'   => $this->seq
      		);
      		$this->STC_weekly_report->weekly_report_read_insert($seq, $this->seq, $read);
      	}

        if($mode == "view") {
            $this->load->view('biz/weekly_report_view', $data );
        } else {
            $this->load->view('biz/weekly_report_modify', $data );
        }
    }


  // 주간업무 등록전 중복 체크
    function weekly_report_duplcheck(){
      $group_name = $this->input->post('group_name');
      $year = $this->input->post('year');
      $month = $this->input->post('month');
      $week = $this->input->post('week');
      $data = array(
        'group_name'=>$group_name,
        'year'=>$year,
        'month'=>$month,
        'week'=>$week
      );
      $result = $this->STC_weekly_report->weekly_report_duplcheck($data);
      echo json_encode($result);

    }


    function weekly_report_input_action(){
        // $this->load->Model(array('STC_weekly_report'));
        $group = $this->input->post('group');

        $s_date =explode("-",$this->input->post('s_date'));
        $e_date = $this->input->post('e_date');

        $tmp_date = date("Y-m-d",strtotime("+2 day",mktime(0,0,0,$s_date[1],$s_date[2],$s_date[0])));
        $tmp_d_array = explode("-",$tmp_date);

        $tmp_month="";
        $tmp_year="";

        if($s_date[1]==$tmp_d_array[1]){
            $tmp_month=$s_date[1];
            $tmp_year=$s_date[0];
        }else{
            if($s_date[0]==$tmp_d_array[0]){
                $tmp_year=$s_date[0];
            }else{
                $tmp_year=$s_date[0]+1;
            }
            $tmp_month=$s_date[1]+1;
        }

        $data = array(
            'group_name'  => $group,
            'year'		    => $tmp_year,
            'month'		    => $tmp_month,
            's_date'	    => $this->input->post('s_date'),
            'e_date'	    => $this->input->post('e_date'),
            'week'		    => $this->input->post('week'),
            'writer'	    => $this->name,
            'insert_time'	=> date("Y-m-d H:i:s"),
            'update_time'	=> date("Y-m-d H:i:s")
        );

        $result = $this->STC_weekly_report->weekly_report_insert($data);

        if($result){
          $doc_result = $this->STC_weekly_report->weekly_report_doc_insert($group,$tmp_year,$data['month'],$data['week'],$data['s_date'],$data['e_date']);

          $this->STC_weekly_report->schedule_list_insert($group,$tmp_year,$data['month'],$data['week'],$data['s_date'],$data['e_date']);

          if($doc_result) {
                 echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/biz/weekly_report/weekly_report_list';</script>";
          } else {
                 echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
          }
        }
	  }

	  function weekly_report_modify_action(){
		// $this->load->Model(array('STC_weekly_report'));

		// 금주 지원 Parsing 및 업데이트
        $tmp_current_doc = $this->input->post('current_doc_total');
        $tmp_next_doc = $this->input->post('next_doc_total');
        $tmp_insert_next_doc = $this->input->post('insert_next_doc_total');
        $tmp_insert_current_doc = $this->input->post('insert_current_doc_total');
        $next_delete_seq = $this->input->post('next_del_seq');
        $delete_seq = $this->input->post('del_seq');
        $current_doc = json_decode($tmp_current_doc, true);
        $next_doc = json_decode($tmp_next_doc, true);
        $insert_next_doc = json_decode($tmp_insert_next_doc, true);
        $insert_current_doc = json_decode($tmp_insert_current_doc, true);

        $doc_result = 1;
        $next_result = 1;

        $report_seq = $this->input->post('seq');
        $group_name = $this->input->post('group_name');
        $comment = $this->input->post('comment');

    		$time = array(
    			'year'	=>	$this->input->post('year'),
    			'month' =>	$this->input->post('month'),
    			'week'	=>	$this->input->post('week')
        );

        //comment update
        $this->STC_weekly_report->weekly_report_comment_modify($report_seq,$comment);


        //금주 delete
        if($delete_seq != ""){
            $delete_seq = explode(",",$delete_seq);
            for($i=0; $i<count($delete_seq); $i++){
                $this->STC_weekly_report->weekly_report_doc_delete($delete_seq[$i],"current",$group_name);
            }
        }

        //금주 update
        if(is_array($current_doc)){
            if($group_name == "기술연구소"){
                for($i=0; $i<count($current_doc['value']);$i++){
                    $values = explode(";;;",$current_doc['value'][$i]);
                    $tmp = array(
                        'seq'              => $values[0],
                        'work_name'        => $values[1],
                        'customer'         => $values[2],
                        'income_time'      => $values[3],
                        'subject'	         => $values[4],
                        'result'	         => $values[5],
                        'hide'	           => $values[6],
                        'writer'	         => $values[7],
                        'produce'	         => $values[8],
                        'completion_time'	 => $values[9],
                        'type'	           => $values[10],
                        'update_time'	     => date("Y-m-d H:i:s")
                    );
                    $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,1,$group_name);
                }
            }else if(($group_name == "기술본부") || ($group_name == "기술1팀") || ($group_name == "기술2팀") || ($group_name == "기술1팀-2")){
                // echo "<script>alert('들어오지마')</script>";
                for($i=0; $i<count($current_doc['value']);$i++){
                    $values=explode(";;;",$current_doc['value'][$i]);
                    $tmp=array(
                        'seq'           => $values[0],
                        'work_name'     => $values[1],
                        'income_time'   => $values[2],
                        'produce'	      => $values[3],
                        'subject'	      => $values[4],
                        'result'	      => $values[5],
                        'hide'          => $values[6],
                        'update_time'	  => date("Y-m-d H:i:s")
                    );
                    $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,1,$group_name);
                }
            }else if(($group_name == "영업본부") || ($group_name == "사업1부") || ($group_name == "사업2부")){

                for($i=0; $i<count($current_doc['value']);$i++){
                  $values=explode(";;;",$current_doc['value'][$i]);
                  $tmp=array(
                    'seq'           => $values[0],
                    'income_time'   => $values[1],
                    'customer'      => $values[2],
                    'visit_company' => $values[3],
                    'subject'	      => $values[4],
                    'hide'          => $values[5],
                    'writer'	      => $values[6],
                    'update_time'	  => date("Y-m-d H:i:s")
                  );
                  $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,1,$group_name);
                }
            }else if (($group_name == "경영지원실")) {

              for($i=0; $i<count($current_doc['value']);$i++){
                $values=explode(";;;",$current_doc['value'][$i]);
                $tmp=array(
                  'seq'           => $values[0],
                  'income_time'   => $values[1],
                  'customer'      => $values[2],
                  'subject'	      => $values[3],
                  'hide'          => $values[4],
                  'writer'	      => $values[5],
                  'update_time'	  => date("Y-m-d H:i:s")
                );
                $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,1,$group_name);
              }
            }
        }


        //금주 insert
        if(is_array($insert_current_doc)){
            if($group_name == "기술연구소"){
                for($i=0; $i<count($insert_current_doc['value']);$i++){
                    $values=explode(";;;",$insert_current_doc['value'][$i]);
                    // echo "<script>alert({$values[1]});</script>";
                    $tmp=array(
                        'report_seq'      => $report_seq,
                        'group_name'      => $group_name,
                        'work_name'       => $values[1],
                        'income_time'     => $values[2],
                        'customer'        => $values[3],
                        'produce'	        => $values[4],
                        'subject'	        => $values[5],
                        'result'	        => $values[6],
                        'hide'	          => $values[7],
                        'writer'          => $values[8],
                        'completion_time' => $values[9],
                        'type'            => $values[10],
                        'year'            => $time['year'],
                        'month'           => $time['month'],
                        'week'            => $time['week'],
                        'insert_time'	    => date("Y-m-d H:i:s")
                    );
                    $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,0,$group_name);
                }
            }else if(($group_name == "기술본부") || ($group_name == "기술1팀") || ($group_name == "기술2팀") || ($group_name == "기술1팀-2")){
                for($i=0; $i<count($insert_current_doc['value']);$i++){
                    $values=explode(";;;",$insert_current_doc['value'][$i]);
                    // echo "<script>alert({$values[1]});</script>";
                    $tmp=array(
                        'report_seq'      => $report_seq,
                        'group_name'      => $group_name,
                        'work_name'       => $values[1],
                        'income_time'     => $values[2],
                        'customer'        => $values[3],
                        'produce'	        => $values[4],
                        'subject'	        => $values[5],
                        'result'	        => $values[6],
                        'hide'	          => $values[7],
                        'writer'          => $values[8],
                        'year'            => $time['year'],
                        'month'           => $time['month'],
                        'week'            => $time['week'],
                        'insert_time'	    => date("Y-m-d H:i:s")
                    );
                    $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,0,$group_name);
                  }
            }else if(($group_name == "영업본부") || ($group_name == "사업1부") || ($group_name == "사업2부")){

                for($i=0; $i<count($insert_current_doc['value']);$i++){
                  $values=explode(";;;",$insert_current_doc['value'][$i]);
                  $tmp=array(
                    'report_seq'      => $report_seq,
                    'group_name'      => $group_name,
                    'income_time'     => $values[1],
                    'customer'        => $values[2],
                    'visit_company'   => $values[3],
                    'subject'	        => $values[4],
                    'hide'            => $values[5],
                    'writer'	        => $values[6],
                    'year'            => $time['year'],
                    'month'           => $time['month'],
                    'week'            => $time['week'],
                    'insert_time'	    => date("Y-m-d H:i:s")
                  );
                  $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,0,$group_name);
                }
            }else if (($group_name == "경영지원실")) {
              for($i=0; $i<count($insert_current_doc['value']);$i++){
                $values=explode(";;;",$insert_current_doc['value'][$i]);
                $tmp=array(
                  'report_seq'      => $report_seq,
                  'group_name'      => $group_name,
                  'income_time'     => $values[1],
                  'customer'        => $values[2],
                  'subject'	        => $values[3],
                  'hide'            => $values[4],
                  'writer'	        => $values[5],
                  'year'            => $time['year'],
                  'month'           => $time['month'],
                  'week'            => $time['week'],
                  'insert_time'	    => date("Y-m-d H:i:s")
                );
                $doc_result = $this->STC_weekly_report->weekly_report_doc_modify($tmp,0,$group_name);
              }
            }
        }


        //차주 delete
        if($next_delete_seq != ""){
            $next_delete_seq = explode(",",$next_delete_seq);
            for($i=0; $i<count($next_delete_seq); $i++){
                $this->STC_weekly_report->weekly_report_doc_delete($next_delete_seq[$i],"next",$group_name);
            }
        }


        //차주 update
        if(is_array($next_doc)){
          if($group_name == "기술연구소"){
            for($i=0; $i<count($next_doc['value']);$i++){
              $values=explode(";;;",$next_doc['value'][$i]);
              $tmp=array(
                'seq'             => $values[0],
                'work_name'       => $values[1],
                'income_time'     => $values[2],
                'customer'        => $values[3],
                'produce'	        => $values[4],
                'subject'	        => $values[5],
                'hide'	          => $values[6],
                'completion_time'	=> $values[7],
                'writer'          => $values[8],
                'type'            => $values[9],
                'update_time'	    => date("Y-m-d H:i:s")
              );
              $next_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,1,$group_name);
            }
          }else if(($group_name == "기술본부") || ($group_name == "기술1팀") || ($group_name == "기술2팀") || ($group_name == "기술1팀-2")){
            for($i=0; $i<count($next_doc['value']);$i++){
              $values=explode(";;;",$next_doc['value'][$i]);
              $tmp=array(
                'seq'           => $values[0],
                'work_name'     => $values[1],
                'income_time'   => $values[2],
                'customer'      => $values[3],
                'produce'	      => $values[4],
                'subject'	      => $values[5],
                'preparations'	=> $values[6],
                'hide'	        => $values[7],
                'writer'        => $values[8],
                'update_time'	  => date("Y-m-d H:i:s")
              );
              $next_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,1,$group_name);
            }
          }else if(($group_name == "영업본부") || ($group_name == "사업1부") || ($group_name == "사업2부")){

              for($i=0; $i<count($next_doc['value']);$i++){
                $values=explode(";;;",$next_doc['value'][$i]);
                $tmp=array(
                  'seq'           => $values[0],
                  'income_time'   => $values[1],
                  'customer'      => $values[2],
                  'visit_company'      => $values[3],
                  'subject'	      => $values[4],
                  'hide'          => $values[5],
                  'writer'	      => $values[6],
                  'update_time'	  => date("Y-m-d H:i:s")
                );
                $doc_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,1,$group_name);
              }
          }else if (($group_name == "경영지원실")) {
            for($i=0; $i<count($next_doc['value']);$i++){
              $values=explode(";;;",$next_doc['value'][$i]);
              $tmp=array(
                'seq'           => $values[0],
                'income_time'   => $values[1],
                'customer'      => $values[2],
                'subject'	      => $values[3],
                'hide'          => $values[4],
                'writer'	      => $values[5],
                'update_time'	  => date("Y-m-d H:i:s")
              );
              $doc_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,1,$group_name);
            }
          }
        }

        //차주 insert
        if(is_array($insert_next_doc)){
          if($group_name == "기술연구소"){
            for($i=0; $i<count($insert_next_doc['value']);$i++){
                $values=explode(";;;",$insert_next_doc['value'][$i]);
                $tmp=array(
                    'report_seq'      => $report_seq,
                    'group_name'      => $group_name,
                    'work_name'       => $values[1],
                    'income_time'     => $values[2],
                    'customer'        => $values[3],
                    'produce'	        => $values[4],
                    'subject'	        => $values[5],
                    'hide'	          => $values[6],
                    'writer'          => $values[7],
                    'completion_time' => $values[8],
                    'type'            => $values[9],
                    'year'            => $time['year'],
                    'month'           => $time['month'],
                    'week'            => $time['week'],
                    'insert_time'	    => date("Y-m-d H:i:s")
                );
                $next_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,0,$group_name);
            }
          }else if(($group_name == "기술본부") || ($group_name == "기술1팀") || ($group_name == "기술2팀") || ($group_name == "기술1팀-2")){
            for($i=0; $i<count($insert_next_doc['value']);$i++){
                $values=explode(";;;",$insert_next_doc['value'][$i]);
                $tmp=array(
                    'report_seq'      => $report_seq,
                    'group_name'      => $group_name,
                    'work_name'       => $values[1],
                    'income_time'     => $values[2],
                    'customer'        => $values[3],
                    'produce'	        => $values[4],
                    'subject'	        => $values[5],
                    'preparations'	  => $values[6],
                    'hide'	          => $values[7],
                    'writer'          => $values[8],
                    'year'            => $time['year'],
                    'month'           => $time['month'],
                    'week'            => $time['week'],
                    'insert_time'	    => date("Y-m-d H:i:s")
                );
                $next_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,0,$group_name);
            }
          }else if(($group_name == "영업본부") || ($group_name == "사업1부") || ($group_name == "사업2부")){

              for($i=0; $i<count($insert_next_doc['value']);$i++){
                $values=explode(";;;",$insert_next_doc['value'][$i]);
                $tmp=array(
                  'report_seq'      => $report_seq,
                  'group_name'      => $group_name,
                  'income_time'     => $values[1],
                  'customer'        => $values[2],
                  'visit_company'        => $values[3],
                  'subject'	        => $values[4],
                  'hide'            => $values[5],
                  'writer'	        => $values[6],
                  'year'            => $time['year'],
                  'month'           => $time['month'],
                  'week'            => $time['week'],
                  'insert_time'	    => date("Y-m-d H:i:s")
                );
                $doc_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,0,$group_name);
              }
          } else if (($group_name == "경영지원실")) {
            for($i=0; $i<count($insert_next_doc['value']);$i++){
              $values=explode(";;;",$insert_next_doc['value'][$i]);
              $tmp=array(
                'report_seq'      => $report_seq,
                'group_name'      => $group_name,
                'income_time'     => $values[1],
                'customer'        => $values[2],
                'subject'	        => $values[3],
                'hide'            => $values[4],
                'writer'	        => $values[5],
                'year'            => $time['year'],
                'month'           => $time['month'],
                'week'            => $time['week'],
                'insert_time'	    => date("Y-m-d H:i:s")
              );
              $doc_result = $this->STC_weekly_report->next_weekly_report_doc_modify($tmp,0,$group_name);
            }
          }
        }

        $file_count = $_POST['file_length'];
        $file_realname = $_POST['file_realname'];
				$file_changename = $_POST['file_changename'];

        if($file_count > 0){
    			for($i=0; $i<$file_count; $i++){
    				// $csize = $_FILES["files".$i]["size"];
    				$f = "files".$i;
    				$cname = $_FILES[$f]["name"];
    				$ext = substr(strrchr($cname,"."),1);
    				$ext = strtolower($ext);

    				$upload_dir = "/var/www/html/stc/misc/upload/biz/weekly_report";
    				// $upload_dir = "c:/xampp/htdocs/biz/misc/upload/biz/weekly_report";
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

        $attach_data = array(
          'seq' => $report_seq,
          'file_realname' => $file_realname,
          'file_changename' => $file_changename
        );

        $file_attach = $this->STC_weekly_report->report_file_attach($attach_data);


         if($doc_result && $next_result) {
            echo json_encode(true);
         } else {
           echo json_encode(false);
         }

	  }



    function weekly_report_delete_action() {
      if( $this->id === null ) {
          redirect( 'account' );
      }

      // $this->load->Model(array( 'STC_weekly_report' ));
      if($this->input->get( 'seq' )){
        $seq = $this->input->get( 'seq' );
      }else if($this->input->post( 'seq' )){
        $seq = $this->input->post( 'seq' );
      }
      if ($seq != null) {
          $tdata = $this->STC_weekly_report->weekly_report_delete($seq);
      }
      if ($tdata) {
          echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/biz/weekly_report/weekly_report_list';</script>";
      } else {
          echo "<script>alert('정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.');</script>";
      }
    }

    function report_approval(){
      $seq =$this->input->post('seq');
      $val =$this->input->post('val');
      $data = array(
          'seq'=>$seq,
          'approval_yn'=>$val
      );
      $result = $this->STC_weekly_report->report_approval($data);
      echo json_encode($result);
    }


}
?>

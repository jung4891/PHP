<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Meeting_minutes extends CI_Controller {
    var $id = '';

    function __construct() {
        parent::__construct();
        $this->id = $this->phpsession->get( 'id', 'stc' );
        $this->name = $this->phpsession->get( 'name', 'stc' );
        $this->lv = $this->phpsession->get( 'lv', 'stc' );
        $this->company = $this->phpsession->get( 'company', 'stc' );
        $this->email = $this->phpsession->get('email','stc');
        $this->pGroupName = $this->phpsession->get('pGroupName','stc');
        $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

        if($this->cooperation_yn == 'Y') {
          echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
        }

        $this->load->library('user_agent');

        $this->load->Model(array('tech/STC_User', 'biz/STC_mom', 'STC_Common'));
    }

// 회의록 리스트
function mom_list(){
  if( $this->id === null ) {
      redirect( 'account' );
  }
  $type= $_GET['type'];

  if(isset($_GET['cur_page'])) {
    $cur_page = $_GET['cur_page'];
  }
  else {
    $cur_page = 0;
  }														//	현재 페이지
  $no_page_list = 10;										//	한페이지에 나타나는 목록 개수

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

  $data['search_keyword'] = $search_keyword;
  $data['search1'] = $search1;
  if  ( $cur_page <= 0 )
    $cur_page = 1;

  $data['cur_page'] = $cur_page;

  $user_list_data = $this->STC_mom->mom_list($type, $search_keyword, $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
  $data['count'] = $this->STC_mom->mom_list_count($type, $search_keyword, $search1)->ucount;

  $data['list_val'] = $user_list_data['data'];
  $data['list_val_count'] = $user_list_data['count'];

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

  $data['category'] = $this->STC_Common->get_category();

  $data['no_page_list'] = $no_page_list;
  $data['total_page'] = $total_page;
  $data['start_page'] = $start_page;
  $data['end_page'] = $end_page;
  $data['type'] = $type;

  if($this->agent->is_mobile()) {
    $data['title'] = '회의록';
    $this->load->view( 'biz/mom_list_mobile', $data);
  } else {
    $this->load->view( 'biz/mom_list', $data);
  }
}


// 회의록 작성 뷰
	function mom_input() {
        if( $this->id === null ) {
            redirect( 'account' );
        }

    $data = $this->STC_mom->get_base(); //유저, 그룹 등 기본정보 가져오기
		$this->load->view( 'biz/mom_input', $data);

    }

function mom_input_action(){
  $register = $this->input->post('register');
  $doc_title = $this->input->post('doc_title');
  if($register == 'n' && $doc_title == ""){
    $doc_title = "{$this->name}님의 임시 회의록";
  }
  $start_day = $this->input->post('start_day');
  $start_day = $start_day =="" ? null:$start_day;
  $stime = $this->input->post('stime');
  $stime = $stime =="" ? null:$stime;
  $etime = $this->input->post('etime');
  $etime = $etime =="" ? null:$etime;
  $place = $this->input->post('place');
  $user_group = $this->input->post('user_group');
  $user_group = $user_group =="" ? null:$user_group;
  $participant = $this->input->post('participant');
  if($participant == ""){
    $participant = null;
  }else{
    $participant = implode(',', $participant);

  }

  $day_type = 'insert_day';

  $seq = $this->input->post('seq');
  $mode= $this->input->post('mode');
  $type = $this->input->post('type');

  $file_count = $_POST['file_length'];
  if($type == 1) {
    $file_realname = '';
    $file_changename = '';
  } else {
    $file_realname = $_POST['file_realname'];
    $file_changename = $_POST['file_changename'];
  }

  if($file_count > 0) {
    for($i=0; $i<$file_count; $i++) {
      $f = 'files'.$i;
      $cname = $_FILES[$f]['name'];
      $ext = substr(strrchr($cname, '.'),1);
      $ext = strtolower($ext);

      // $upload_dir = "C:/xampp/htdocs/biz/misc/upload/biz/mom";
      $upload_dir = "/var/www/html/stc/misc/upload/biz/mom";
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


  if($mode=="modify"){
    $day_type = "update_day";
  }
  $insert_day = date("Y-m-d H:i:s");
  $insert_data = array(
    'title'           => $doc_title,
    'day'             => $start_day,
    'start_time'      => $stime,
    'end_time'        => $etime,
    'user_group'      => $user_group,
    'place'           => $place,
    'participant'     => $participant,
    'register'        => $register,
     $day_type        => $insert_day,
    'writer_id'       => $this->id,
    'file_realname'   => $file_realname,
    'file_changename' => $file_changename
  );

  // 수정 요청시
  if($mode == "modify"){
    $result = $this->STC_mom->mom_modify_action($insert_data, $seq);
    if($result){
      // 기존꺼 수정
      $con_seq = $this->input->post('contents_seq');
      $row = $this->input->post('tr_num');
      $sub_title = $this->input->post('subtitle');
      $contents = $this->input->post('contents');
      // $sub_title=str_replace("\r\n","<br />",$sub_title);
      // $contents=str_replace("\r\n","<br />",$contents);
      // var_dump($con_seq[2]);
      // var_dump($sub_title);
      // var_dump($contents);
      if(!empty($contents)){
      for ($i=0; $i<count($contents); $i++) {
        $update_arr = array(
          'tr_index'=> $row[$i],
          'sub_title'=> $sub_title[$i],
          'contents'=> $contents[$i]
        );
        $contents_seq = $con_seq[$i];

        $result1 = $this->STC_mom->mom_content_update($update_arr, $contents_seq);
        if(!$result1){
          echo json_encode(false);
        }

      }
    }
      // 새로운거 추가
      $mom_seq = $seq;
      $new_row = $this->input->post('new_tr_num');
      $new_subtitle = $this->input->post('new_subtitle');
      $new_contents = $this->input->post('new_contents');
      if(!empty($new_contents)){
        // $new_subtitle=str_replace("\r\n","<br />",$new_subtitle);
        // $new_contents=str_replace("\r\n","<br />",$new_contents);
        $new_data = array();
        for ($i=0; $i < count($new_contents); $i++) {
          $arr = array('mom_seq'=>$mom_seq, 'tr_index'=>$new_row[$i], 'sub_title'=>$new_subtitle[$i], 'contents'=>$new_contents[$i]);
          array_push($new_data, $arr);
        }
        $result2 = $this->STC_mom->mom_input_contents($new_data);
        if(!$result2){
          echo json_encode(false);
        }

      }

      // 없어진거는 삭제
      $del_seq = $this->input->post('del_row_seq');
      if($del_seq != ""){
         $del_arr = explode("," , $del_seq);
         for ($i=0; $i < count($del_arr) -1; $i++) {
           $content_seq = $del_arr[$i];
           $result3 = $this->STC_mom->mom_content_del($content_seq, $mom_seq);
           if(!$result3){
             echo json_encode(false);
           }
         }
      }

      echo json_encode(true);


    }
  }else{

    // var_dump($insert_data);
    $result = $this->STC_mom->mom_input_action($insert_data);
    if($result != false){
      $mom_seq = $result;
      $row = $this->input->post('tr_num');
      $sub_title = $this->input->post('subtitle');
      // $sub_title=str_replace("\r\n","<br />",$sub_title);
      $contents = $this->input->post('contents');
      // $contents=str_replace("\r\n","<br />",$contents);
      $content_data = array();
      for ($i=0; $i < count($contents); $i++) {
        $arr = array('mom_seq'=>$mom_seq, 'tr_index'=>$row[$i], 'sub_title'=>$sub_title[$i], 'contents'=>$contents[$i]);
        array_push($content_data, $arr);
      }
      $result = $this->STC_mom->mom_input_contents($content_data);
      if($result){
        echo json_encode(true);

      }else{
        echo json_encode(false);
      }
    }else{
      echo json_encode(false);
    }

  }

}


// 공지사항 보기/수정 뷰
function mom_view() {
  if( $this->id === null ) {
    redirect( 'account' );
  }

  $seq = $this->input->get( 'seq' );
  $mode = $this->input->get( 'mode' );
  if($mode != "view"){
    $seq = $this->input->post( 'seq' );
    $mode = $this->input->post( 'mode' );
  }
  $data['title_val'] = $this->STC_mom->mom_view($seq);

  if (strpos($data['title_val']['participant'].','.$data['title_val']['writer_id'], $this->id) === false) {
    echo '<script>alert("권한이 없습니다.");history.back();</script>';
  }

  $participant_id = $data['title_val']['participant'];
  if($participant_id != ""){

  $id_arr = explode(',', $participant_id);
  $name_arr = array();
for ($i=0; $i < count($id_arr) ; $i++) {
  $user_info = $this->STC_mom->get_username($id_arr[$i]);
  $name = $user_info->user_name." ".$user_info->user_duty;
  array_push($name_arr, $name);
}

  $data['participant_name'] = implode(', ', $name_arr);
}
  $data['contents_val'] = $this->STC_mom->mom_view_contents($seq);
  $data['base'] = $this->STC_mom->get_base();
  // if($mode == "view") {
  $data['mode'] = $mode;

  if($this->agent->is_mobile()) {
    if($mode == 'view') {
      $data['title'] = '회의록';
      $this->load->view('biz/mom_view_mobile', $data);
    } else {
      $this->load->view( 'biz/mom_view', $data );
    }
  } else {
    $this->load->view( 'biz/mom_view', $data );
  }
  // }

}

function mom_del_action(){
  $seq = $this->input->post('seq');
  $result = $this->STC_mom->mom_del_action($seq);
  if($result){
    echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/biz/meeting_minutes/mom_list?type=y'</script>";

  }else{
    echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
  }
}

}

?>

<?php

class STC_Schedule extends CI_Model{
  function __construct(){
    parent::__construct();

    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->name = $this->phpsession->get( 'name', 'stc' );
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->cnum = $this->phpsession->get( 'cnum', 'stc' );
    $this->group = $this->phpsession->get( 'group', 'stc' );
    $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
    $this->load->database();
    ob_start();
    // $this->load->library('session');
    $config['url_suffix'] = 'html';


  }

// BH 업무 숫자, 목록 가져오기
function group_list(){
  $sql = "SELECT work_name FROM tech_schedule_work";
  $query = $this->db->query($sql);
  // $result["len"] = $query->num_rows();
  $result = $query->result();
  return $result;
}

// BH 업무별 리스트 가져오기
function schedule_list($participant){

  $company_schedule_chk = " WHERE a.work_type != 'company'";
  // $company_schedule_chk = "";
  $sql = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list WHERE participant regexp '{$participant}' or user_name regexp '{$participant}') a left join tech_schedule_work b on a.work_name = b.work_name".$company_schedule_chk;
  // $sql = "SELECT a.*, b.work_name, b.color, b.textColor from (SELECT * FROM tech_schedule_list WHERE participant regexp '{$participant}' or user_name regexp '{$participant}') a left join tech_schedule_work b on a.work_name = b.work_name";
  $query = $this->db->query($sql);
  return $query->result();

}

// BH 주간업무보고 리스트 가져오기
function weekly_report_list(){
  $query = $this ->db->get('weekly_report_doc');
  return $query->result();
}



// BH 일정 추가
function schedule_insert($data, $contents_arr){
  // if(is_array($data['recurring_date']) || is_object($data['recurring_date'])){
  //   $recurring_date_length = sizeof($data['recurring_date']);
  // }else{
  //   $recurring_date_length = 0;
  // }
  // $recurring_date = $data['recurring_date'];
  // if( 0 < $recurring_date_length ){
  // // if($data['recurring_seq'] == null && 0 < count($data['recurring_date'])){
  // // if($data['recurring_seq'] == null && $data['recurring_rrule'] != null){
  //   $recurring_seq = null;
  //   //시작 날짜와 끝나는 날짜 차이값 구하기
  //   $date_diff_num = 0;
  //   // $date_diff_num = intval($date_diff->days);
  //
  //   for($i = 0; $i < $recurring_date_length; $i++){
  //     $data['recurring_count'] = $i;
  //     $data['start_day'] = $recurring_date[$i];
  //
  //     if($i == 0){
  //       $start = new DateTime($data['start_day']);
  //       $end = new DateTime($data['end_day']);
  //       $date_diff = date_diff($start, $end);
  //       $date_diff_num = (int)$date_diff->days;
  //       if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
  //         $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
  //         // $data['end_day'] = date("Y-m-d",strtotime("+{$date_diff_num} day", time($data['start_day'])));
  //       }else{ //일정이 하루일 때
  //         $data['end_day'] = $data['start_day'];
  //       }
  //
  //       // //recurring_seq의 값은 일정seq와 같게할 것이기 때문에 일정이 등록되기 전에 미리
  //       $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
  //       $query = $this->db->query($sql)->row();
  //       $recurring_seq = $query->AUTO_INCREMENT;
  //       $data['recurring_seq'] = $recurring_seq;
  //
  //       unset($data['recurring_date']); //data에서 recurring_seq 값 제외
  //       array_values($data);
  //
  //     }else{
  //       if( 0 < $date_diff_num){ //일정이 이틀 이상일 때
  //         $data['end_day'] = date("Y-m-d",strtotime("{$data['start_day']} +{$date_diff_num} day"));
  //         // $data['end_day'] = date("Y-m-d",strtotime("+{$date_diff_num} day", time($data['start_day'])));
  //       }else{ //일정이 하루일 때
  //         $data['end_day'] = $data['start_day'];
  //       }
  //
  //       $data['recurring_seq'] = $recurring_seq;
  //
  //       unset($data['recurring_date']); //data에서 recurring_seq 값 제외
  //       array_values($data);
  //     }
  //
  //     $result = $this->db->insert('tech_schedule_list', $data);
  //
  //     //분리 내용 저장
  //     $sql_contents = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
  //     $query_contents = $this->db->query($sql_contents)->row();
  //     $schedule_seq = $query_contents->AUTO_INCREMENT-1;
  //
  //     foreach ($contents_arr as $arr) {
  //       $data_contents = array(
  //         'schedule_seq' => $schedule_seq,
  //         'contents' => $arr['contents'],
  //         'contents_num' =>  $arr['contents_num'],
  //         'weekly_report' => $arr['weekly_report']
  //       );
  //       $this->db->insert('tech_schedule_contents', $data_contents);
  //       // $contents_num++;
  //     }
  //   }
  //   // //recurring_seq의 값은 일정seq와 같게할 것이기 때문에 일정이 등록되기 전에 미리
  //   // $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
  //   // $query = $this->db->query($sql)->row();
  //   // $recurring_seq = $query->AUTO_INCREMENT;
  //   // $data['recurring_seq'] = $recurring_seq;
  // }else if( $recurring_date_length == 0 ){
  // // }else if($data['recurring_seq'] == null ){
  //   $data['start_day'] = $data['recurring_date'];
  //   // unset($data['recurring_seq']); //data에서 recurring_seq 값 제외
  //   unset($data['recurring_date']); //data에서 recurring_seq 값 제외
  //   array_values($data); //unset으로 빵꾸난 $data의 index 재정렬
  //   $result = $this->db->insert('tech_schedule_list', $data);
  //
  //   $sql_contents = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
  //   $query_contents = $this->db->query($sql_contents)->row();
  //   $schedule_seq = $query_contents->AUTO_INCREMENT-1;
  //
  //   foreach ($contents_arr as $arr) {
  //     $data_contents = array(
  //       'schedule_seq' => $schedule_seq,
  //       'contents' => $arr['contents'],
  //       'contents_num' =>  $arr['contents_num'],
  //       'weekly_report' => $arr['weekly_report']
  //     );
  //     $this->db->insert('tech_schedule_contents', $data_contents);
  //     // $contents_num++;
  //   }
  // }
  // // if($data['recurring_rrule'] == null){
  // //   unset($data['recurring_rrule']); //data에서 recurring_seq 값 제외
  // //   array_values($data); //unset으로 빵꾸난 $data의 index 재정렬
  // // }


  // $result = $this->db->insert('tech_schedule_list', $data);
  $result = $this->db->insert('tech_schedule_list', $data);

  //분리 내용 저장
  $sql_contents = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
  $query_contents = $this->db->query($sql_contents)->row();
  $schedule_seq = $query_contents->AUTO_INCREMENT-1;

  foreach ($contents_arr as $arr) {
    $data_contents = array(
      'schedule_seq' => $schedule_seq,
      'contents' => $arr['contents'],
      'contents_num' =>  $arr['contents_num'],
      'weekly_report' => $arr['weekly_report']
    );
    $this->db->insert('tech_schedule_contents', $data_contents);
    // $contents_num++;
  }
  if($result){
    return "true";
  }else{
    return "false";
  }

}

//내용분할1
//분할된 내용 배열을 tech_schedule_contents에 foreach문으로 insert하기
 // function schedule_contents_insert($arr){
 //   $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
 //   $query = $this->db->query($sql)->row();
 //   $schedule_seq = $query->AUTO_INCREMENT-1;
 //   // $contents_num = 0;
 //
 //   foreach ($arr as $arr1) {
 //     $data = array(
 //       'schedule_seq' => $schedule_seq,
 //       'contents' => $arr1['contents'],
 //       'contents_num' =>  $arr1['contents_num'],
 //       'weekly_report' => $arr1['weekly_report']
 //     );
 //     $this->db->insert('tech_schedule_contents', $data);
 //     // $contents_num++;
 //   }
 // }
 //내용분할2

// BH 상세페이지 보기
function details($seq){
  // $query = $this->db->get_where('tech_schedule_list', array('seq' => $seq));
  // $result = $query->row();
  // return $result;
  $where = "WHERE seq={$seq}";
  // if($seq ==''){
  //   $where = '';
  // }
  $sql = "SELECT * FROM tech_schedule_list {$where}";
  // $sql = "SELECT A.*, B.user_duty FROM tech_schedule_list A LEFT OUTER JOIN user B ON A.user_name = B.user_name {$where}";
  $query = $this->db->query($sql);
  $result = $query->row();
  return $result;
}

//내용분할1
//일정 seq로 해당 내용 분할 전체 불러오기
function details_contents($seq){
  $where = array(
    'schedule_seq' => $seq
  );
  $query = $this->db->get_where('tech_schedule_contents',$where);
  $result = $query->result_array();
  return $result;
}
//내용분할2

// //출장품의서 작성여부 확인
// function trip_document($seq) {
//   $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE schedule_seq = {$seq} AND approval_form_seq = 16";
//   $query = $this->db->query($sql);
//   $result = $query->row_array();
//   return $result;
// }
//
// //야간품의서 작성여부 확인
// function night_document($seq) {
//   $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE schedule_seq = {$seq} AND approval_form_seq = 55";
//   $query = $this->db->query($sql);
//   $result = $query->row_array();
//   return $result;
// }

//근무품의서 작성여부 확인
function weekend_document($seq) {
  $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE schedule_seq = {$seq} AND approval_form_seq = 19";
  $query = $this->db->query($sql);
  $result = $query->row_array();
  return $result;
}

//직접입력인지 확인
function direct_check($customer){
  $sql="SELECT customer_companyname as customer FROM sales_forcasting WHERE customer_companyname = '{$customer}' GROUP BY customer";
  $query = $this->db->query($sql);
  if($query->num_rows() > 0){
    return 'y';
  }else{
    return 'n';
  }
}

// BH 일정 수정
function schedule_update($mode, $data = null, $where = null, $where2 = null, $contents_arr = null){
  if($data != null){
    // $seq = $data['seq'];
    unset($data['seq']); //data에서 seq 값 제외
    array_values($data); //unset으로 빵꾸난 $data의 index 재정렬
  }

  if($mode == 'update' || $mode == 'drop'){

    $this->db->where($where);
    $result = $this->db->update('tech_schedule_list', $data);
    // echo $this->db->last_query();

  }else if($mode == 'delete'){

    $this->db->where($where);
    $result = $this->db->delete('tech_schedule_list');
    $this->db->where($where2);
    $result = $this->db->delete('tech_schedule_contents');

  }else if($mode == 'insert'){

    $result = $this->db->insert('tech_schedule_list', $data);
    //분리 내용 저장
    $sql_contents = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
    $query_contents = $this->db->query($sql_contents)->row();
    $schedule_seq = $query_contents->AUTO_INCREMENT-1;

    foreach ($contents_arr as $arr) {
      $data_contents = array(
        'schedule_seq' => $schedule_seq,
        'contents' => $arr['contents'],
        'contents_num' =>  $arr['contents_num'],
        'weekly_report' => $arr['weekly_report']
      );
      $this->db->insert('tech_schedule_contents', $data_contents);
      // $contents_num++;
    }
  }
  // echo $this->db->last_query();

  if($result){
    return 'true';
  } else {
    return 'false';
  }
}

function schedule_contents_update($arr,$seq){

    //php버전 5대에서 array_column 사용 가능하도록 하는 함수
    if (! function_exists('array_column')) {
      function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
          if ( !array_key_exists($columnKey, $value)) {
            trigger_error("Key \"$columnKey\" does not exist in array");
            return false;
          }
          if (is_null($indexKey)) {
            $array[] = $value->$columnKey;
          }
          else {
            if ( !array_key_exists($indexKey, $value)) {
              trigger_error("Key \"$indexKey\" does not exist in array");
              return false;
            }
            if ( ! is_scalar($value[$indexKey])) {
              trigger_error("Key \"$indexKey\" does not contain scalar value");
              return false;
            }
            $array[$value[$indexKey]] = $value[$columnKey];
          }
        }
        return $array;
      }
    }

  $contents_num_arr = array();
  foreach ($arr as $arr1) {
    //해당 내용이 원래 있던 내용의 update인지 먼저 select를 해보고 있으면 update, 없으면 insert로 분기한다.
    $where = array(
      'schedule_seq' => $seq,
      'contents_num' => $arr1['contents_num'],
    );
    $num = $this->db->get_where('tech_schedule_contents',$where)->num_rows();
    if($num > 0){
      $data = array(
        'contents' => $arr1['contents'],
        'weekly_report' => $arr1['weekly_report']
      );
      $this->db->where($where);
      $this->db->update('tech_schedule_contents', $data);
    }else{
      $data2 = array(
        'schedule_seq' => $seq,
        'contents_num' => $arr1['contents_num'],
        'contents' => $arr1['contents'],
        'weekly_report' => $arr1['weekly_report']
      );
      $this->db->insert('tech_schedule_contents', $data2);
    }
    array_push($contents_num_arr,$arr1['contents_num']); //현재 contents_num 값을 배열로 만든다.
  }

  $this->db->select('contents_num');
  $result_array = $this->db->get_where('tech_schedule_contents', array('schedule_seq' => $seq))->result();
  $result_array = array_column($result_array, 'contents_num'); //key값을 제거한 배열로 만든다
  $del_contents_num = array_diff($result_array,$contents_num_arr); //현재 contents_num 배열과 db저장되어 있는 contents_num 배열을 비교해 db에만 있는 값을 배열로 뺀다.
  if(!empty($del_contents_num)){
    foreach($del_contents_num as $del_num){
      // $this->db->where('contents_num', $del_num);
      $del_where = array(
        'contents_num'=> $del_num,
        'schedule_seq'=> $seq
      );
      $this->db->where($del_where);
      $this->db->delete('tech_schedule_contents');
    }
  }
}

//BH 일정 삭제
function schedule_delete($seq, $recurring_seq = null){

  //내용분할1 삭제
  $this->db->where('schedule_seq', $seq);
  $this->db->delete('tech_schedule_contents');
  //내용분할2

  $this->db->where('seq', $seq);
  $result = $this->db->delete('tech_schedule_list');

  if($result){
    return 'true';
  } else {
    return 'false';
  }
}


// 고객사 리스트 가져오기
function customer_list(){
  $sql = "SELECT customer_companyname as customer FROM sales_forcasting GROUP BY customer";
  $query = $this->db->query($sql);
  $result = $query->result();
  return $result;
}

  function select_user(){
    $sql = "SELECT user_name FROM user";
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
  }

  function parentGroup() {
    $sql = "SELECT * from user_group order by seq";
    return $this->db->query($sql)->result();
  }

  function userInfo() {
    $sql = "SELECT * from user WHERE quit_date is null order by seq";
    return $this->db->query($sql)->result();
  }

  function user_group() {
    $sql = "SELECT * from user_group order by seq";
    return $this->db->query($sql)->result();
  }

  function userDepth() {
      // $sql = "SELECT a.*, b.user_name, b.user_id, b.user_duty from (select * from user_group where childGroupNum>1 and depth = 1) a join (select * from user) b on a.groupName = b.user_group";
      $sql = "SELECT b.seq, a.groupName, a.parentGroupName, a.childGroupNum, a.depth, b.user_name, b.user_id, b.user_duty from (select * from user_group where childGroupNum>1 and depth = 1) a join (select * from user WHERE quit_date IS null) b on a.groupName = b.user_group;";
      return $this->db->query($sql)->result();
    }

  function work_color_list(){
    $sql = "SELECT seq, work_name, color, textColor, work_type FROM tech_schedule_work ORDER BY work_name";
    return $this->db->query($sql)->result();
  }

  function updateWorkColor($data, $seq){
    $where = "seq = '{$seq}'";
    $result = $this->db->update('tech_schedule_work',$data,$where);

    if($result){
      return 'true';
    } else {
      return 'false';
    }
  }


  function schedule_list_user($group_list, $start, $end){

    // if(is_array($group_list['participant'])){
    //   $participant = implode( '|', $group_list['participant'] );
    // }else{
    //   $participant = "nonononononono";
    // }
    if(is_array($group_list['participant'])){
      $participant_name = implode( '|', $group_list['participant'] );
      $participant = " WHERE (participant regexp '{$participant_name}' or user_name regexp '{$participant_name}') AND start_day >= '{$start}' AND end_day < '{$end}'";
    }else{
      $participant_name = "no_one";
      $participant = " WHERE (participant regexp '{$participant_name}' or user_name regexp '{$participant_name}') AND start_day >= '{$start}' AND end_day < '{$end}'";
    }
    $company_schedule_chk = " WHERE a.work_type != 'company'";
    $except_nondisclosure_sch = " AND (nondisclosure IS NULL || nondisclosure <> 'Y')";
    $my_nondisclosure_list = " UNION DISTINCT SELECT a.*, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list WHERE participant regexp '{$this->name}' or user_name = '{$this->name}') a left join tech_schedule_work b on a.work_name = b.work_name WHERE nondisclosure = 'Y'";
    // $my_nondisclosure_list = " UNION DISTINCT SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name WHERE participant regexp '{$this->name}' AND nondisclosure = 'Y'";
    // $my_nondisclosure_list = " UNION DISTINCT SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name WHERE user_id = '{$this->id}' AND nondisclosure = 'Y'";

    // $recurring_rrule = " WHERE recurring_rrule IS NULL OR recurring_rrule = ''";
    // $recurring_seq = "AND (recurring_seq IS NULL OR recurring_seq = '')";
    // $recurring_seq = " WHERE recurring_seq IS NULL OR recurring_seq = ''";

    $sql = "SELECT * FROM (SELECT a.*, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name{$company_schedule_chk}{$except_nondisclosure_sch}{$my_nondisclosure_list}) c";
    // $sql = "SELECT * FROM (SELECT a.*, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name".$company_schedule_chk.$except_nondisclosure_sch.$my_nondisclosure_list.") c";
    // $sql = "SELECT * FROM (SELECT a.*, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name".$company_schedule_chk.$except_nondisclosure_sch.$my_nondisclosure_list.") c".$recurring_rrule;
    // $sql = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name".$company_schedule_chk.$except_nondisclosure_sch.$my_nondisclosure_list.$recurring_seq;


    $query = $this->db->query($sql);
    return $query->result();
  }

  function company_schedule($bool){

    if($bool['csc'] === 'false'){
      $notice = 'no_one';
    }else{
      $notice = '공지사항';
    }
    $sql = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq AS work_color_seq FROM (SELECT * FROM tech_schedule_list WHERE work_name = '{$notice}') a LEFT JOIN tech_schedule_work b on a.work_name = b.work_name";
    $query = $this->db->query($sql);
    return $query->result();
  }


  // function recurring_schedule($group_list){
  //   // $sql = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq AS work_color_seq from (SELECT * FROM tech_schedule_list WHERE recurring_seq IS NOT NULL AND recurring_seq != '') a LEFT JOIN tech_schedule_work b on a.work_name = b.work_name";
  //
  //   if(is_array($group_list['participant'])){
  //     $participant_name = implode( '|', $group_list['participant'] );
  //     $participant = " WHERE participant regexp '{$participant_name}' or user_name regexp '{$participant_name}'";
  //   }else{
  //     $participant_name = "no_one";
  //     $participant = " WHERE participant regexp '{$participant_name}' or user_name regexp '{$participant_name}'";
  //   }
  //   $company_schedule_chk = " WHERE a.work_type != 'company'";
  //   $except_nondisclosure_sch = " AND (nondisclosure IS NULL || nondisclosure <> 'Y')";
  //   $my_nondisclosure_list = " UNION DISTINCT SELECT a.*, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b on a.work_name = b.work_name WHERE nondisclosure = 'Y'";
  //   // $recurring_rrule = " WHERE recurring_rrule IS NOT NULL OR recurring_rrule != ''";
  //
  //   $sql = "SELECT * FROM (SELECT a.*, b.color, b.textColor, b.seq AS work_color_seq FROM (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b ON a.work_name = b.work_name".$company_schedule_chk.$except_nondisclosure_sch.$my_nondisclosure_list.") c";
  //   // $sql = "SELECT * FROM (SELECT a.*, b.color, b.textColor, b.seq AS work_color_seq FROM (SELECT * FROM tech_schedule_list {$participant}) a left join tech_schedule_work b ON a.work_name = b.work_name".$company_schedule_chk.$except_nondisclosure_sch.$my_nondisclosure_list.") c".$recurring_rrule;
  //   $query = $this->db->query($sql);
  //   return $query->result();
  // }

  function my_group($id) {
    $sql = "SELECT user_group FROM user WHERE user_id = '{$id}'";
    return $this->db->query($sql)->row();
  }

  function login_user_duty($id) {
    $sql = "SELECT user_duty FROM user WHERE user_id = '{$id}'";
    return $this->db->query($sql)->row();
  }


  function search($data){

    // if(is_array($data['participant'])){
    //   // echo implode( ' | ', $group_list['participant']);
    //   $participant = implode( '|', $data['participant'] );
    // }else{
    //   // $participant = $group_list['participant'];
    //   $participant = "nononononono";
    //   // echo $partcipant;
    // }

     $seaechTarget = $data['searchTarget'];
     $except_nondisclosure_sch = " WHERE nondisclosure IS NULL || nondisclosure <> 'Y'";

     if($seaechTarget == 'participant'){
       if(is_array($data['searchKeyword'])){
         // $searchKeyword = implode( ',', $data['searchKeyword'] );
         $searchKeyword = $data['searchKeyword'];
         $word='';
         for($i=0;$i<count($searchKeyword);$i++){
           if($word ==''){
             // $word = "AND {$seaechTarget} LIKE '%{$searchKeyword[$i]}%'";
             $word = "{$seaechTarget} LIKE '%{$searchKeyword[$i]}%'";
           }else{
             $word = $word." AND {$seaechTarget} LIKE '%{$searchKeyword[$i]}%'";
           }
         }
         $sql_base = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list WHERE {$word}) a left join tech_schedule_work b on a.work_name = b.work_name";
         $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE (participant regexp '{$this->name}' OR user_name = '{$this->name}') AND nondisclosure = 'Y'";
         // $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE user_id = '{$this->id}' AND nondisclosure = 'Y'";
       }else{
         $searchKeyword = $data['searchKeyword'];
         $sql_base = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list WHERE {$seaechTarget} in ({$searchKeyword})) a left join tech_schedule_work b on a.work_name = b.work_name";
         $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE (participant regexp '{$this->name}' OR user_name = '{$this->name}') AND nondisclosure = 'Y'";
         // $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE user_id = '{$this->id}' AND nondisclosure = 'Y'";
       }
       // $sql = "SELECT * FROM tech_schedule_list WHERE {$seaechTarget} regexp '{$searchKeyword}'";
       $query = $this->db->query($sql);
       return $query->result();
     } else if ($seaechTarget == 'contents') {
       if(is_array($data['searchKeyword'])){
         $searchKeyword = implode( '|', $data['searchKeyword'] );
       }else{
         $searchKeyword = $data['searchKeyword'];
       }

       $sql_base = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT *
                    FROM tech_schedule_list
                    WHERE (CONTENTS regexp '{$searchKeyword}' || seq IN (
                    SELECT schedule_seq
                    FROM tech_schedule_contents
                    WHERE CONTENTS regexp '{$searchKeyword}'))) a left join tech_schedule_work b on a.work_name = b.work_name";

       $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE (participant regexp '{$this->name}' OR user_name = '{$this->name}') AND nondisclosure = 'Y'";

       $query = $this->db->query($sql);
       return $query->result();

     }else{

       if(is_array($data['searchKeyword'])){
         $searchKeyword = implode( '|', $data['searchKeyword'] );
       }else{
         $searchKeyword = $data['searchKeyword'];
       }
       // $searchKeyword = $data['searchKeyword'];
       $sql_base = "SELECT a.*, b.work_name, b.color, b.textColor, b.seq as work_color_seq from (SELECT * FROM tech_schedule_list as t WHERE t.{$seaechTarget} regexp '{$searchKeyword}') a left join tech_schedule_work b on a.work_name = b.work_name";
       $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE (participant regexp '{$this->name}' OR user_name = '{$this->name}') AND nondisclosure = 'Y'";
       // $sql =  $sql_base.$except_nondisclosure_sch." UNION DISTINCT ".$sql_base." WHERE user_id = '{$this->id}' AND nondisclosure = 'Y'";
       // $sql = "SELECT * FROM tech_schedule_list WHERE {$seaechTarget} regexp '{$searchKeyword}'";
       $query = $this->db->query($sql);
       return $query->result();

     }
   }


 function rooms(){
   $sql = "SELECT * FROM meeting_room";
   $query = $this->db->query($sql);
   $result = $query->result();
   return $result;
 }

 function cars(){
   $sql = "SELECT * FROM admin_car WHERE user_name = '공용'";
   $query = $this->db->query($sql);
   $result = $query->result();
   return $result;
 }

function search_conference_room($search_day){
  $sql = "SELECT seq, work_name, start_time, end_time, room_name, title, participant, user_name, insert_date FROM tech_schedule_list WHERE start_day = '{$search_day}' AND room_name is not null";
  $query = $this->db->query($sql);
  if ($query->num_rows() > 0){
    return $query->result();
  }else{
    return 'false';
  }
}

// function duplicate_checkroom($seq, $day, $start, $end, $room){
//   if($seq =='nan'){
//     $and_seq = '';
//   }else{
//     $and_seq = " AND seq != '{$seq}'";
//   }
//
//   if($room ==''){
//     return 'ok';
//   }else{
//     $sql = "SELECT start_time, end_time, room_name FROM tech_schedule_list WHERE start_day = '{$day}' AND START_time < '{$end}' AND end_time > '{$start}' AND room_name = '{$room}'{$and_seq}";
//
//     $query = $this->db->query($sql);
//     if ($query->num_rows() > 0){
//       return 'dupl';
//     }else{
//       return 'ok';
//     }
//   }
// }

function search_car($search_car_day){
  $sql = "SELECT seq, start_time, end_time, car_name, work_name, title, participant, user_name, insert_date FROM tech_schedule_list WHERE start_day = '{$search_car_day}' AND car_name is not null";
  $query = $this->db->query($sql);
  if ($query->num_rows() > 0){
    return $query->result();
  }else{
    return 'false';
  }
}

// function duplicate_checkcar($seq, $day, $start, $end, $car){
//   if($seq =='nan'){
//     $and_seq = '';
//   }else{
//     $and_seq = " AND seq != '{$seq}'";
//   }
//
//   if($car ==''){
//     return 'ok';
//   }else{
//     $sql = "SELECT start_time, end_time, car_name FROM tech_schedule_list WHERE start_day = '{$day}' AND start_time < '{$end}' AND end_time > '{$start}' AND car_name = '{$car}'{$and_seq}";
//
//     $query = $this->db->query($sql);
//     if ($query->num_rows() > 0){
//       return 'dupl';
//     }else{
//       return 'ok';
//     }
//   }
// }

function duplicate_check($seq, $day, $start, $end, $check_place, $check_place_name){
  if($seq =='nan'){
    $and_seq = '';
  }else{
    $and_seq = " AND seq != '{$seq}'";
  }

  if($check_place ==''){
    return 'ok';
  }else{
    // $sql = "SELECT start_time, end_time, car_name FROM tech_schedule_list WHERE start_day = '{$day}' AND start_time < '{$end}' AND end_time > '{$start}' AND {$check_place_name} = '{$check_place}'{$and_seq}";
        $sql = "SELECT start_time, end_time, car_name FROM tech_schedule_list WHERE start_day = '{$day}' AND start_time < '{$end}' AND end_time > '{$start}' AND {$check_place_name} regexp '{$check_place}'{$and_seq}";

    $query = $this->db->query($sql);
    if ($query->num_rows() > 0){
      return 'dupl';
    }else{
      return 'ok';
    }
  }
}

// tech일 때 기술연구소 그룹을 제외한 참석자의 그룹가져오기
// 참석자의 그룹 가져오기
  function linker_group($name){
    $sql = "SELECT a.user_group, b.parentGroupName FROM user a JOIN user_group b ON a.user_group = b.groupName WHERE a.user_name = '{$name}'";
    // $sql = "SELECT user_group, user_id FROM user WHERE user_name = '{$name}' AND user_group !='기술연구소'";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0){
      return $query->row();
    }else{
      return 'false';
    }
  }


  // 이미 작성된 주간업무보고서가 있는지 확인 + 결제 미완상태인 주간업무보고서
    function check_report($income_time, $linker_group){
      $sql = "SELECT * FROM weekly_report WHERE s_date <= '{$income_time}' AND e_date >= '{$income_time}' AND group_name = '{$linker_group}' AND approval_yn = 'N'";
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0){
        return $query->row();
      }else{
        return 'false';
      }
    }

    function check_tech_seq(){ //금주
      $sql2 = "SELECT MIN(tech_seq)-1 as m1 from weekly_report_doc";
      $query = $this->db->query($sql2);
      // $tech_seq = $query->m1;
      return $query->row();
    }

    function check_tech_seq2(){ //차주
      $sql2 = "SELECT MIN(tech_seq)-1 as m1 from next_weekly_report_doc";
      $query = $this->db->query($sql2);
      // $tech_seq = $query->m1;
      return $query->row();
    }

 //  // 차주 주간업무 insert
   function insert_next_week_doc($data){

     //다음에 들어올 auto_increment값 구하는 sql문
     $sql1 = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
     $query = $this->db->query($sql1)->row();
     if(empty($data['schedule_seq'])){
       //현재의 schedule_seq의 값 구하기?->중간에 삭제된 sch_seq이 있으면 -1이 반드시 마지막 seq값이라고 할 수 없지 않나? oderby seq desc limit 1하는게 낫지않나?
       //일단은 두고 본다.
       $data['schedule_seq'] = $query->AUTO_INCREMENT-1;
     }
     $this->db->insert('next_weekly_report_doc',$data);
      // echo $this->db->last_query();

     if($data['group_name'] == '기술1팀' || $data['group_name'] == '기술2팀'){
       //기술본부 주간업무보고가 있는지 확인
       $before_day =  date("Y-m-d", strtotime($data['income_time']." -7day"));
       $sql = "SELECT seq FROM weekly_report WHERE s_date <= '{$before_day}' AND e_date >= '{$before_day}' AND group_name = '기술본부'";
       $query = $this->db->query($sql);

       //기술본부 주간업무보고가 있을 경우 report_seq와 group_name만 맞춰준 후 insert진행
       if ($query->num_rows() > 0 ){
         $data['report_seq'] = $query->row()->seq;
         $data['group_name'] = '기술본부';
         $data2 = $data;

         $key = array_search( 'tech_seq', $data2 );
         array_splice( $data2, $key, 1 );
         // var_dump($data2);
         //tech_seq를 빼고 나머지가 동일한 기술본부 주간보고 내용 입력값이 있는지 확인
         //(사전에 같은 일정이 다른 그룹명으로 등록될 때 기술본부도 같이 등록되어 있을 수 있다.)
         $this->db->select('seq');
         $query2 = $this->db->get_where('next_weekly_report_doc',$data2);
         // $this->db->where($data2);
         // $query2 = $this->db->get('next_weekly_report_doc');
         //등록된 기술본부 내용이 없으면 insert진행
         if ($query2->num_rows() <= 0 ){
           $this->db->insert('next_weekly_report_doc',$data);
         }
       }
     }
   }

   function update_next_week_doc($data){
     // $seq = $data['schedule_seq'];
     $where = array(
       'schedule_seq' => $data['schedule_seq'],
       'contents_num' => $data['contents_num'],
       'group_name' => $data['group_name']
     );
     $this->db->where($where);
     // $this->db->where('schedule_seq', $seq);
     $this->db->update('next_weekly_report_doc', $data);
     // echo $this->db->last_query();


     if($data['group_name'] == '기술1팀' || $data['group_name'] == '기술2팀'){
       $where = array(
         'schedule_seq' => $data['schedule_seq'],
         'contents_num' => $data['contents_num'],
         'group_name' => '기술본부'
       );
       $this->db->select('seq');
       $query2 = $this->db->get_where('next_weekly_report_doc',$where);

       if ($query2->num_rows() > 0 ){
         $data['group_name'] = '기술본부';
         $seq = $query2->row()->seq;
         $this->db->where('seq',$seq);
         $this->db->update('next_weekly_report_doc',$data);
       }
     }

   }

   function delete_next_week_doc($group_name,$seq,$contents_num){
     if($group_name != 'false' && $seq != 'false' && $contents_num == 'false'){
       //($group_name,$seq,'false')

       $where = array(
         'schedule_seq' => $seq,
         'group_name' => $group_name
       );
       $this->db->select('seq');
       $query = $this->db->get_where('next_weekly_report_doc',$where);
       if($query->num_rows() > 0){
         $result = $query->row();
         $seq2 = $result->seq;
         $this->db->where('seq', $seq2);
         $this->db->delete('next_weekly_report_doc');
         // echo $this->db->last_query();
       }else{
         return false;
       }

     }else if($group_name == 'false' && $seq != 'false' && $contents_num != 'false'){
       //('false',$seq,$contents_num)

       $where_arr = array(
         'schedule_seq' => $seq,
         'contents_num' => $contents_num
       );
       $this->db->where($where_arr);
       $this->db->delete('next_weekly_report_doc');

     }else if($group_name == 'false' && $seq != 'false' && $contents_num == 'false'){
       //('false',$seq,'false')

       $this->db->where('schedule_seq',$seq);
       $this->db->delete('next_weekly_report_doc');

     }
   }

   //  // 금주 주간업무 insert(영업,경영)
   function insert_current_week_doc($data){
     $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
     $query = $this->db->query($sql)->row();
     if(empty($data['schedule_seq'])){
       $data['schedule_seq'] = $query->AUTO_INCREMENT-1;
     }
     $query = $this->db->insert('weekly_report_doc',$data);
   }


   function update_current_week_doc($data){
     $where = array(
       'schedule_seq' => $data['schedule_seq'],
       'contents_num' => $data['contents_num'],
       'group_name' => $data['group_name']
     );
     $this->db->where($where);
     $this->db->update('weekly_report_doc', $data);
   }

   function delete_current_week_doc($group_name,$seq,$contents_num){
     if($group_name != 'false' && $seq != 'false' && $contents_num == 'false'){

       $where = array(
         'schedule_seq' => $seq,
         'group_name' => $group_name
       );
       $this->db->select('seq');

       $query = $this->db->get_where('weekly_report_doc',$where);
       if($query->num_rows() > 0){
         $result = $query->row();
         $seq2 = $result->seq;
         $this->db->where('seq', $seq2);
         $this->db->delete('weekly_report_doc');
       }else{
         return false;
       }

     }else if($group_name == 'false' && $seq != 'false' && $contents_num != 'false'){

       $where_arr = array(
         'schedule_seq' => $seq,
         'contents_num' => $contents_num
       );
       $this->db->where($where_arr);
       $this->db->delete('weekly_report_doc');

     }else if($group_name == 'false' && $seq != 'false' && $contents_num == 'false'){

       $this->db->where('schedule_seq',$seq);
       $this->db->delete('weekly_report_doc');

     }
   }

   function check_current_week_doc($seq,$contents_num = 0){
     $sql = "SELECT group_name FROM weekly_report_doc WHERE schedule_seq = '{$seq}' AND contents_num = '{$contents_num}'";
     // $sql = "SELECT seq FROM weekly_report_doc WHERE schedule_seq = {$seq}";
     $query = $this->db->query($sql);
     if($query->num_rows() <= 0){
       return 'false';
     }else{
       return $query->result();
     }
     // if($contents_num <> null || $contents_num <> ''){
     //   $and = " AND contents_num = '{$contents_num}'";
     // }else{
     //   $and = '';
     // }
     // $sql = "SELECT group_name FROM weekly_report_doc WHERE schedule_seq = '{$seq}'".$and;
     // // $sql = "SELECT seq FROM weekly_report_doc WHERE schedule_seq = {$seq}";
     // $query = $this->db->query($sql);
     // if($query->num_rows() <= 0){
     //   return 'false';
     // }else{
     //   return $query->result();
     //   // return $query->result_array();
     //   // return 'true';
     // }
   }

   function check_next_week_doc($seq,$contents_num = 0){
     $sql = "SELECT group_name FROM next_weekly_report_doc WHERE schedule_seq = '{$seq}' AND contents_num = '{$contents_num}'";
     $query = $this->db->query($sql);

     if($query->num_rows() <= 0){
       return 'false';
     }else{
       return $query->result();
     }
   }

   function date_delete_next_week_doc($seq,$group_name){
     // $this->db->where('schedule_seq',$seq);
     $where = array(
       'schedule_seq' => $seq,
       'group_name' => $group_name
     );
     $this->db->where($where);
     $this->db->delete('next_weekly_report_doc');
     // echo $this->db->last_query();
   }
   function date_delete_current_week_doc($seq,$group_name){
     // $this->db->where('schedule_seq',$seq);
     $where = array(
       'schedule_seq' => $seq,
       'group_name' => $group_name
     );
     $this->db->where($where);
     $this->db->delete('weekly_report_doc');
     // echo $this->db->last_query();
   }

//날짜이동
   function date_insert_next_week_doc($data){
     $seq = $data['seq'];
     $group_name = $data['group_name'];

     $sql = "SELECT tsl.*, tsc.contents_num, tsc.contents AS contents2, tsc.weekly_report AS weekly_report2 FROM tech_schedule_list tsl LEFT JOIN tech_schedule_contents tsc ON tsc.schedule_seq = tsl.seq WHERE tsl.seq = {$seq} AND tsc.weekly_report = 'Y'";
     $query = $this->db->query($sql);
     foreach ($query->result_array() as $row){
       $insert_data = array(
         'report_seq' => $data['report_seq'],
         'tech_seq' => $data['tech_seq'],
         'schedule_seq' => $data['seq'],
         'contents_num' => $row['contents_num'],
         'group_name' => $data['group_name'],
         'year' => $data['year'],
         'month' => $data['month'],
         'week' => $data['week'],
         'writer' => $row['participant'],
         'hide' => 'N',
         'income_time' => $data['income_time'],
         'insert_time' => date("Y-m-d H:i:s")
       );

       if($row['work_type'] != 'tech' && $row['work_type'] != 'lab'){ //general
         $insert_data2 = array(
           'work_name' => $row['work_name'],
           'customer' => $row['customer'],
           'visit_company' => $row['visit_company'],
           'subject' => $row['contents2']
         );
         $final_data = array_merge($insert_data, $insert_data2);
         $this->db->insert('next_weekly_report_doc',$final_data);

          if(strpos($group_name,"기술") === true && $group_name != '기술본부'){
            $sql4 = "SELECT seq FROM weekly_report WHERE year =".$data['year']." AND month =".$data['month']." AND week =".$data['year']." AND group_name = '기술본부'";
            $sql4_seq = $this->db->query($report)->row()->seq;
            // $tech_seq = $tech_seq-1;
            $insert_data2['report_seq'] = $sql4_seq;
            $insert_data2['group_name'] = '기술본부';

            $final_data = array_merge($insert_data, $insert_data2);
            $this->db->insert('next_weekly_report_doc',$final_data);
          };
       }else if($row['work_type'] == 'tech' && $row['work_type'] <> 'lab'){ //tech
         $update_data2 = array(
           'work_name' => $row['work_name'],
           'customer' => $row['customer'],
           'subject' => $row['title']
         );
         $final_data = array_merge($insert_data, $insert_data2);
         $this->db->insert('next_weekly_report_doc',$final_data);
         // echo $this->db->last_query();

         if(strpos($group_name,"기술") === true && $group_name != '기술본부'){
           $sql4 = "SELECT seq FROM weekly_report WHERE year =".$data['year']." AND month =".$data['month']." AND week =".$data['year']." AND group_name = '기술본부'";
           $sql4_seq = $this->db->query($report)->row()->seq;
           // $tech_seq = $tech_seq-1;
           $insert_data2['report_seq'] = $sql4_seq;
           $insert_data2['group_name'] = '기술본부';

           $final_data = array_merge($insert_data, $insert_data2);
           $this->db->insert('next_weekly_report_doc',$final_data);
         }
       }else{ //lab
         $val_arr = explode(',,,', $row['contents2']);
         $val_arr_length = count($val_arr);
         for($p = 0; $p < $val_arr_length; $p++){

             $val_arr2 = explode(':::', $val_arr[$p]);
             $val_arr_key = $val_arr2[0];
             $val_arr_value = $val_arr2[1];

             if($val_arr_key == 'dev_type'){
               $lab_work_name = $val_arr_value;
             }else if($val_arr_key == 'dev_page'){
               $lab_customer = $val_arr_value;
             }else if($val_arr_key == 'dev_requester'){
               $lab_type = $val_arr_value;
             }else if($val_arr_key == 'dev_develop'){
               $lab_subject = $val_arr_value;
             }else if($val_arr_key == 'dev_complete'){
               if($val_arr_value == 'Y'){
                 $lab_result = '완료';
                 $lab_completion_time = $row['end_day'];
               }else{
                 $lab_result = '미완료';
                 $lab_completion_time = null;
               };
             };
         };
         $insert_data2 = array(
           'type' => $lab_type, //요청자
           'work_name' => $lab_work_name, //작업구분
           'produce' => $row['title'], //요청사항
           'customer' => $lab_customer, //페이지
           'subject' => $lab_subject, //개발사항
           'completion_time' => $lab_completion_time //예정일자
         );
         $final_data = array_merge($insert_data, $insert_data2);
         $this->db->insert('next_weekly_report_doc',$final_data);
       }
     }
   }

   //날짜이동
   function date_insert_current_week_doc($data){
     $seq = $data['seq'];

     $sql = "SELECT tsl.*, tsc.contents_num, tsc.contents AS contents2, tsc.weekly_report AS weekly_report2 FROM tech_schedule_list tsl LEFT JOIN tech_schedule_contents tsc ON tsc.schedule_seq = tsl.seq WHERE tsl.seq = {$seq} AND tsc.weekly_report = 'Y'";
     $query = $this->db->query($sql);
     foreach ($query->result_array() as $row){
       $insert_data = array(
         'report_seq' => $data['report_seq'],
         'tech_seq' => $data['tech_seq'],
         'schedule_seq' => $data['seq'],
         'contents_num' => $row['contents_num'],
         'group_name' => $data['group_name'],
         'year' => $data['year'],
         'month' => $data['month'],
         'week' => $data['week'],
         'writer' => $row['participant'],
         'hide' => 'N',
         'income_time' => $data['income_time'],
         'insert_time' => date("Y-m-d H:i:s")
       );

       if($row['work_type'] != 'tech' && $row['work_type'] != 'lab'){ //genenal

         $insert_data2 = array(
           'work_name' => $row['work_name'],
           'customer' => $row['customer'],
           'visit_company' => $row['visit_company'],
           'subject' => $row['contents2']
         );
         $final_data = array_merge($insert_data, $insert_data2);
         $this->db->insert('weekly_report_doc',$final_data);

       }else if($row['work_type'] != 'tech' && $row['work_type'] == 'lab'){ //lab
         $val_arr = explode(',,,', $row['contents2']);
         $val_arr_length = count($val_arr);
         for($p = 0; $p < $val_arr_length; $p++){

             $val_arr2 = explode(':::', $val_arr[$p]);
             $val_arr_key = $val_arr2[0];
             $val_arr_value = $val_arr2[1];

             if($val_arr_key == 'dev_type'){
               $lab_work_name = $val_arr_value;
             }else if($val_arr_key == 'dev_page'){
               $lab_customer = $val_arr_value;
             }else if($val_arr_key == 'dev_requester'){
               $lab_type = $val_arr_value;
             }else if($val_arr_key == 'dev_develop'){
               $lab_subject = $val_arr_value;
             }else if($val_arr_key == 'dev_complete'){
               if($val_arr_value == 'Y'){
                 $lab_result = '완료';
                 $lab_completion_time = $row['end_day'];
               }else{
                 $lab_result = '미완료';
                 $lab_completion_time = null;
               }
             }
         }
         $insert_data2 = array(
           'type' => $lab_type, //요청자
           'work_name' => $lab_work_name, //작업구분
           'produce' => $row['title'], //요청사항
           'customer' => $lab_customer, //페이지
           'subject' => $lab_subject, //개발사항
           'result' => $lab_result, //결과
           'completion_time' => $lab_completion_time //예정일자
         );
         $final_data = array_merge($insert_data, $insert_data2);
         $this->db->insert('weekly_report_doc',$final_data);
       }
     }
   }

     // }

   //날짜이동
   function date_update_current_week_doc($data){
     $seq = $data['seq'];
     unset($data['seq']);
     array_values($data); //unset으로 빵꾸난 $data의 index 재정렬

     $this->db->where('schedule_seq', $seq);
     $result = $this->db->update('weekly_report_doc', $data);

     if($result){
       return 'true';
     } else {
       return 'false';
     }
   }

   //날짜이동
   function date_update_next_week_doc($data){
     $seq = $data['seq'];
     $group_name = $data['group_name'];
     unset($data['seq']);
     unset($data['group_name']);
     array_values($data); //unset으로 빵꾸난 $data의 index 재정렬

     $sql = "SELECT seq FROM next_weekly_report_doc WHERE group_name = '{$group_name}' AND schedule_seq = {$seq}";
     $query = $this->db->query($sql);
     $next_weekly_report_doc_seq= $query->result();
     $next_weekly_report_doc_seq = $next_weekly_report_doc_seq[0]->seq;

     $where = array(
       // 'schedule_seq' => $seq,
       'seq'          => $next_weekly_report_doc_seq
     );
     $this->db->where($where);
     $result = $this->db->update('next_weekly_report_doc', $data);
     // echo $this->db->last_query();

     if($result){
       return 'true';
     } else {
       return 'false';
     }
   }

/////////////////기지보 관련
function search_tech_report($reportData){
  $today = $reportData['today'];
  $sessionName = $reportData['sessionName'];

  $sql = "SELECT * FROM tech_schedule_list  WHERE work_type = 'tech' AND tech_report > 0 AND start_day < '{$today}' AND (participant LIKE '%{$sessionName}%') AND DATEDIFF(end_day, start_day) < 2 order by start_day;";

  $query = $this->db->query($sql);
  return $query->result();
}

function no_written_report() {
  $today = date('Y-m-d');

  $sql = "SELECT * FROM tech_schedule_list  WHERE work_type = 'tech' AND tech_report > 0 AND start_day < '{$today}' AND DATEDIFF(end_day, start_day) < 2 order by start_day desc;";

  $query = $this->db->query($sql);
  return $query->result_array();
}

function tech_seq_find($data){
  $schedule_seq = $data['schedule_seq'];
  // $where = "WHERE schedule_seq={$schedule_seq}";
  // $sql = "SELECT seq FROM tech_doc_basic {$where}";
  // $query = $this->db->query($sql);

  if($data['type'] == 'N'){
    $db_name = 'tech_doc_basic_temporary_save';
  }else{
    $db_name = 'tech_doc_basic';
  }
  $where = array(
    'schedule_seq' => $schedule_seq
  );
  $this->db->select('seq');
  $query = $this->db->get_where($db_name, $where);
  // echo $this->db->last_query();

  if($query->num_rows() <= 0){
    return 'false';
  }else{
    return $query->result();
  }
}

//@@@
//같은 날짜와 고객사를 가진 기지보 작성내용이 있는지 확인
function same_report_schedule($data){
  $start_day = $data['start_day'];
  $customer = $data['customer'];
  // $participant = $data['participant'];

  $sql = "SELECT seq FROM tech_doc_basic WHERE income_time = '{$start_day}' AND customer ='{$customer}' AND schedule_seq IS NOT null";
  // $sql = "SELECT seq FROM tech_doc_basic WHERE income_time = '{$start_day}' AND work_name = '{$work_name}' AND customer ='{$customer}' AND engineer regexp '{$participant}' AND schedule_seq IS NOT null";
  $query = $this->db->query($sql);

  if($query->num_rows() <= 0){
    return false;
  }else{
    return $query->result();
  }
}

//KI1 20210125 고객사 포캐스팅형으로 변경하여 고객사 리스트 불러오기
// 고객사 정보 가저오기
//카테고리 알아오기
function get_customer() { //유지보수
  // $sql = "select seq as forcasting_seq, customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_forcasting WHERE (sub_project_add IS NULL) or (sub_project_add IS not NULL AND sub_project_add not like CONCAT('%',seq,'%')) order by binary(customer)";
	$sql = "select seq as maintain_seq, forcasting_seq , customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3 order by binary(customer_companyname)";

//	$sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
  $query = $this->db->query($sql);
  return $query->result_array();
}

function ser_customer(){
  	$sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
    $query = $this->db->query($sql);
    return $query->result_array();
}

function get_customer2() { //포캐스팅
  $sql = "select t1.seq as forcasting_seq,t1.customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_forcasting AS t1 order by binary(customer_companyname)";
  $query = $this->db->query($sql);
  return $query->result_array();
}

function get_customer3() { //수주완료에서 무상보증 기간 이내이고, 유지보수와 겹치지 않는 고객사

  $sql = "(SELECT null AS maintain_seq, sf.forcasting_seq, sf.customer,sf.customer_username, sf.maintain_start, sf.maintain_end, sf.project_name
  FROM (SELECT null AS maintain_seq, sf2.seq as forcasting_seq, sf2.customer_companyname as customer, sf2.customer_username, sf2.exception_saledate2 as maintain_start, sf2.exception_saledate3 as maintain_end , sf2.project_name from sales_forcasting sf2
  WHERE sf2.progress_step >= 015 AND warranty_end_date >= CURDATE()
  ORDER BY BINARY(customer_companyname)) sf
  left JOIN
  (SELECT sm2.seq AS maintain_seq2, sm2.forcasting_seq AS forcasting_seq2, sm2.customer_companyname AS customer2, sm2.customer_username AS customer_username2, sm2.exception_saledate2 AS maintain_start2, sm2.exception_saledate3 AS maintain_end2, sm2.project_name AS project_name2
  FROM sales_maintain sm2 WHERE CURDATE() BETWEEN sm2.exception_saledate2 AND sm2.exception_saledate3 order by binary(customer_companyname)) sm
  ON sf.forcasting_seq = sm.forcasting_seq2
  WHERE sm.maintain_seq2 IS NULL)
  UNION ALL
  (SELECT seq AS maintain_seq, forcasting_seq, customer_companyname AS customer, customer_username, exception_saledate2 AS maintain_start, exception_saledate3 AS maintain_end, project_name
  FROM sales_maintain
  WHERE CURDATE() BETWEEN exception_saledate2 AND exception_saledate3
  ORDER BY BINARY(customer_companyname))";
  $query = $this->db->query($sql);
  // echo $this->db->last_query();
  return $query->result_array();
}
//KI2 20210125


function search_manager($seq, $mode){
  if($mode == 'maintain'){
    $sql = "select * from sales_maintain where seq='{$seq}'";
  }else{
    $sql = "select * from sales_forcasting where seq='{$seq}'";
  }
  $query = $this->db->query($sql);
  return $query->result();
}

// 수정 (기지보 일괄작성)
function select_report_day($seq){
  $sql = "SELECT seq, date_format(income_time, '%Y-%m-%d') as income_time, date_format(end_work_day, '%Y-%m-%d') as end_work_day FROM tech_doc_basic where schedule_seq = {$seq}";
  $query = $this->db->query($sql);
  $result = $query->result();
  return $result;
}

function written_rep_cnt($seq){
  $sql = "SELECT count(*) as cnt from tech_doc_basic where schedule_seq = {$seq}";
  $query = $this->db->query($sql);
  $result = $query->row();
  return $result;
}

function search_entered_participant($val){
  $sql = "SELECT * from user WHERE user_name regexp '{$val}'";
  $query = $this->db->query($sql);
  // if($query->num_rows() == 1){
  //   return $query->result();
  // }else{
  //   return 'false';
  // }
  if($query->num_rows() > 1){

    return $query->result_array();
    // return 'too many participant';
  }else if($query->num_rows() == 1){

    return $query->result();
  }else{

    return 'false';
  }
}

//20210326
  function sch_duplicate_check($data){
    $start_day = $data['start_day'];
    $customer = $data['customer'];
    $sql = "SELECT * FROM tech_schedule_list WHERE work_type = 'tech' AND start_day = '{$start_day}' AND customer = '{$customer}'";
    $query = $this->db->query($sql);

    if($query->num_rows() <= 0){
      return false;
    }else{
      return $query->result_array();
      // return $query->result();
    }
  }


  function sch_report_approval($seq){
    $arr = array();
    $sql2 = "SELECT DISTINCT report_seq FROM weekly_report_doc WHERE schedule_seq = {$seq}";
    $query2 = $this->db->query($sql2)->result_array();
    $num = $this->db->query($sql2)->num_rows();
    if($num > 0){
      foreach ($query2 as $query2_seq) {
        $report_seq = $query2_seq['report_seq'];
        $sql = "SELECT approval_yn FROM weekly_report WHERE seq = {$report_seq}";
        $query = $this->db->query($sql);
        $result = $query->row()->approval_yn;
        array_push($arr,$result);
      }
    }
    // foreach ($query2 as $query2_seq) {
    //   $report_seq = $query2_seq['report_seq'];
    //   if($report_seq != null){
    //     $sql = "SELECT approval_yn FROM weekly_report WHERE seq = {$report_seq}";
    //     $query = $this->db->query($sql);
    //     $result = $query->row()->approval_yn;
    //     array_push($arr,$result);
    //   }else{
    //     continue;
    //   }
    // }
    // if(count($arr) < 0){
    if(count($arr) <= 0){
      return false;
    }else if(count($arr) > 0 && is_int(array_search('Y', $arr)) != 1){
      return "N";
    }else if(count($arr) > 0 && is_int(array_search('Y', $arr)) == 1){
      return "Y";
    }
  }

  function sch_report_approval2($income_time){
    $sql = "SELECT approval_yn FROM weekly_report WHERE s_date <= '{$income_time}' AND e_date >= '{$income_time}' AND group_name = '{$linker_group}' ";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $result = $query->row();
      return $result->approval_yn;
    }else{
      return false;
    }
  }


  function find_participant_seq($name){
    $sql = "SELECT seq FROM user WHERE user_name = '{$name}'";
    $query = $this->db->query($sql);
    // echo $this->db->last_query();
    if($query->num_rows() > 0){
      $result = $query->row();
      return $result->seq;
    }else{
      return false;
    }
  }

  function find_recurring_original_sch($recurring_seq, $seq){
    if($seq == null ){
      $sql = "SELECT seq, start_day, end_day FROM tech_schedule_list WHERE recurring_seq = {$recurring_seq} ORDER by seq ASC LIMIT 1";
    }else{
      $sql = "SELECT seq, start_day, end_day FROM tech_schedule_list WHERE seq >= {$seq} AND recurring_seq = {$recurring_seq} ORDER BY seq ASC LIMIT 1";
    }
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $result = $query->row();
      return $result;
    }else{
      return false;
    }
  }
  // function find_recurring_after_this_sch($recurring_seq, $seq){
  //   $sql = "SELECT seq, start_day, end_day FROM tech_schedule_list WHERE seq >= {$seq} AND recurring_seq = {$recurring_seq} ORDER BY seq ASC LIMIT 1";
  //   $query = $this->db->query($sql);
  //   if($query->num_rows() > 0){
  //     $result = $query->row();
  //     return $result;
  //   }else{
  //     return false;
  //   }
  // }

  function recurring_drop_seq($seq){
    $sql = "SELECT seq, start_day, end_day FROM tech_schedule_list WHERE recurring_seq = (SELECT recurring_seq from tech_schedule_list where seq = {$seq}) AND seq >= {$seq}";
    $query = $this->db->query($sql);
    $result = $query->result_array();
    if($query->num_rows() <= 0){
      return false;
    }else{
      return $query->result_array();
    }
  }



  function find_seq_in_tech_doc_basic_temporary_save($seq, $income_time){
    $sql = "SELECT seq FROM tech_doc_basic_temporary_save WHERE schedule_seq = {$seq} AND income_time = '{$income_time}'";
    $query = $this->db->query($sql);
    $result = $query->row();
    if($result){
      return $result->seq;
    }else{
      return false;
    }
  }


  function tech_doc_basic_temporary_save_delete($sch_seq){
    $where = array(
      'schedule_seq' => $sch_seq
    );
    $result = $this->db->delete('tech_doc_basic_temporary_save', $where);
    if($result){
      return 'true';
    }else{
      return 'false';
    }
  }

  function user_count() {
    $sql = "SELECT COUNT(*) AS cnt FROM user WHERE quit_date IS null and cooperation_yn = 'N'";
    $query = $this->db->query($sql);
    $result = $query->result_array();

    return $result;
  }

  function user_group_count() {
    $sql = "SELECT a.groupName, b.cnt FROM user_group a LEFT JOIN (SELECT user_group, COUNT(user_group) AS cnt FROM user WHERE quit_date IS null GROUP BY user_group) b ON a.groupName = b.user_group WHERE a.depth > 1;";
    $query = $this->db->query($sql);
    $result = $query->result_array();

    return $result;
  }

  function parent_group_count() {
    $sql = "SELECT a.parentGroupName, sum(ifnull(b.cnt,0)) AS cnt
FROM user_group a
LEFT JOIN (
SELECT user_group, COUNT(user_group) AS cnt
FROM user
WHERE quit_date IS NULL
GROUP BY user_group) b ON a.groupName = b.user_group GROUP BY a.parentGroupName;";
    $query = $this->db->query($sql);
    $result = $query->result_array();

    return $result;
  }

  function update_img($seq, $data) {
    $this->db->where('seq', $seq);
    $result = $this->db->update('tech_schedule_list', $data);
  }

  function img_file($seq, $type, $change_filename) {
    $sql = "select seq, {$type}_file_realname, {$type}_file_changename from tech_schedule_list where seq = {$seq} and {$type}_file_changename = '{$change_filename}'";

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function img_filedel($seq, $type) {
    $sql = "update tech_schedule_list set {$type}_file_changename = NULL, {$type}_file_realname = NULL where seq = {$seq}";
    $result = $this->db->query($sql);
    return $result;
  }

  function schedule_mobile($selUser){
    if ($selUser == '') {
      $selUser = $this->seq;
    }
    $selUser = explode(',', $selUser);

    if (in_array($this->seq, $selUser)) {
      $my_schedule = true;
    } else {
      $my_schedule = false;
    }

    $selUser = join("','", $selUser);

    $sql = "SELECT GROUP_CONCAT(user_name SEPARATOR '|') AS user_name FROM user WHERE seq IN ('{$selUser}');";

    $query = $this->db->query($sql);

    $result = $query->row_array();
    $user = $result['user_name'];

    $sql = "SELECT * FROM tech_schedule_list WHERE (participant regexp '{$user}' or user_name regexp '{$user}') and nondisclosure = 'N'";

    if ($my_schedule) {
      $sql .= " UNION ALL SELECT * FROM tech_schedule_list WHERE (participant regexp '{$this->name}' or user_name regexp '{$this->name}') and nondisclosure = 'Y' order by start_day, start_time";
    }

		$query = $this->db->query($sql);

		return $query->result_array();
	}

  function schedule_list_mobile($selUser, $date, $mode = 'day') {
    if ($selUser == '') {
      $selUser = $this->seq;
    }
    $selUser = explode(',', $selUser);

    if (in_array($this->seq, $selUser)) {
      $my_schedule = true;
    } else {
      $my_schedule = false;
    }

    $selUser = join("','", $selUser);

    $sql = "SELECT GROUP_CONCAT(user_name SEPARATOR '|') AS user_name FROM user WHERE seq IN ('{$selUser}');";
// echo $sql;
    $query = $this->db->query($sql);

    $result = $query->row_array();
    $user = $result['user_name'];

    if ($mode == 'day') {
      $t_date = "AND '{$date}' BETWEEN start_day AND end_day";
    } else if ($mode == 'month') {
      $t_date = "AND (start_day LIKE '{$date}%' OR end_day LIKE '{$date}%')";
    }


    $sql = "SELECT * FROM tech_schedule_list WHERE (participant regexp '{$user}' or user_name regexp '{$user}') {$t_date} and nondisclosure = 'N'";

    if ($my_schedule) {
      $sql .= " UNION ALL SELECT * FROM tech_schedule_list WHERE (participant regexp '{$this->name}' or user_name regexp '{$this->name}') and nondisclosure = 'Y' {$t_date} order by start_day, start_time";
    } else {
      $sql .= " order by start_day, start_time";
    }
// echo $sql;
    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function user_parents_group_mobile() {
    $sql = "SELECT DISTINCT(ug.parentGroupName) FROM user_group ug JOIN user u ON ug.groupName = u.user_group ORDER BY ug.seq";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function user_group_mobile() {
    $sql = "SELECT * FROM user_group";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function depth1_user_mobile() {
    $sql = "SELECT DISTINCT(ug.parentGroupName)
            FROM user_group ug
            JOIN (
            SELECT u.user_name, u.user_duty, u.user_group, ug.parentgroupname
            FROM user u
            JOIN user_group ug ON u.user_group = ug.groupName
            WHERE u.user_group = ug.parentGroupName) u ON ug.parentGroupName = u.user_group";

    $query = $this->db->query($sql);
    $d1_pgn = $query->result_array();

    $result = array();

    foreach($d1_pgn as $r) {
      $t = $r['parentGroupName'];

      $sql2 = "SELECT u.seq, u.user_name, u.user_duty, u.user_group, ug.parentgroupname
              FROM user u
              JOIN user_group ug ON u.user_group = ug.groupName
              WHERE u.user_group = ug.parentGroupName AND user_group = '{$t}' and quit_date is null
              ORDER BY FIELD(user_duty, '대표', '상무이사', '이사', '부장', '차장', '과장', '팀장', '대리', '주임', '사원');";
      $query = $this->db->query($sql2);
      $result[$t] = $query->result_array();
    }

    return $result;
  }

  function depth2_user_mobile() {
    $sql = "SELECT DISTINCT(ug.groupName)
            FROM user_group ug
            JOIN (
            SELECT u.user_name, u.user_duty, u.user_group, ug.parentgroupname
            FROM user u
            JOIN user_group ug ON u.user_group = ug.groupName
            WHERE u.user_group != ug.parentGroupName) u ON ug.groupName = u.user_group";

    $query = $this->db->query($sql);
    $d1_pgn = $query->result_array();

    $result = array();

    foreach($d1_pgn as $r) {
      $t = $r['groupName'];

      $sql2 = "SELECT u.seq, u.user_name, u.user_duty, u.user_group, ug.parentgroupname
              FROM user u
              JOIN user_group ug ON u.user_group = ug.groupName
              WHERE u.user_group = ug.groupName AND user_group = '{$t}' and quit_date is null
              ORDER BY FIELD(user_duty, '대표', '상무이사', '이사', '부장', '차장', '과장', '팀장', '대리', '주임', '사원');";
      $query = $this->db->query($sql2);
      $result[$t] = $query->result_array();
    }

    return $result;
  }

  function holiday_list() {
    $sql = "SELECT * FROM holiday";

    $query = $this->db->query($sql);

    return $query->result();
  }

}


 ?>

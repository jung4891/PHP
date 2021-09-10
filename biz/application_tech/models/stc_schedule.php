<?php

class Stc_schedule extends CI_Model{
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
  $sql = "SELECT work_name FROM work_name_config ORDER BY work_name";
  $query = $this->db->query($sql);
  // $result["len"] = $query->num_rows();
  $result = $query->result();
  return $result;
}

// BH 업무별 리스트 가져오기
function schedule_list($participant){

  $sql = "SELECT a.*, b.work_name, b.color, b.textColor from (SELECT * FROM tech_schedule_list WHERE participant regexp '{$participant}' or user_name regexp '{$participant}') a left join work_name_config b on a.work_name = b.work_name";
  $query = $this->db->query($sql);
  return $query->result();
}

// BH 주간업무보고 리스트 가져오기
function weekly_report_list(){
  $query = $this ->db->get('weekly_report_doc');
  return $query->result();
}



// BH 일정 추가
function schedule_insert($data){
    // var_dump($data);
  $result = $this->db->insert('tech_schedule_list', $data);
  if($result){
    return "true";
  }else{
    return "false";
  }

}

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
function schedule_update($data){
  $seq = $data['seq'];
  $this->db->where('seq', $seq);
  $this->db->update('tech_schedule_list', $data);
}

//BH 일정 삭제
function schedule_delete($seq){
  $this->db->where('seq', $seq);
  $this->db->delete('tech_schedule_list');
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
    $sql = "SELECT * from user order by seq";
    return $this->db->query($sql)->result();
  }

  function user_group() {
    $sql = "SELECT * from user_group order by seq";
    return $this->db->query($sql)->result();
  }

  function userDepth() {
    $sql = "SELECT a.*, b.user_name, b.user_id, b.user_duty from (select * from user_group where childGroupNum>1 and depth = 1) a join (select * from user) b on a.groupName = b.user_group";
    return $this->db->query($sql)->result();
  }

  function work_color_list(){
    $sql = "SELECT seq, work_name, color, textColor FROM work_name_config ORDER BY work_name";
    return $this->db->query($sql)->result();
  }

  function updateWorkColor($data, $seq){
    $where = "seq = '{$seq}'";
    $result = $this->db->update('work_name_config',$data,$where);

    if($result){
      return 'true';
    } else {
      return 'false';
    }
  }


  function schedule_list_user($group_list){
    if(is_array($group_list['participant'])){
      // echo implode( ' | ', $group_list['participant']);
      $participant = implode( '|', $group_list['participant'] );
    }else{
      $participant = $group_list['participant'];
    }
    $sql = "SELECT a.*, b.work_name, b.color, b.textColor from (SELECT * FROM tech_schedule_list WHERE participant regexp '{$participant}' or user_name regexp '{$participant}') a left join work_name_config b on a.work_name = b.work_name";
    $query = $this->db->query($sql);
    return $query->result();
  }

  function my_group($id) {
    $sql = "SELECT user_group from user where user_id = '{$id}'";
    return $this->db->query($sql)->row();
  }

  function login_user_duty($id) {
    $sql = "SELECT user_duty from user where user_id = '{$id}'";
    return $this->db->query($sql)->row();
  }


  function search($data){
     $seaechTarget = $data['searchTarget'];

     if($seaechTarget == 'participant'){
       if(is_array($data['searchKeyword'])){
         // $searchKeyword = implode( ',', $data['searchKeyword'] );
         $searchKeyword = $data['searchKeyword'];
         $word='';
         for($i=0;$i<count($searchKeyword);$i++){
           if($word ==''){
             $word = "{$seaechTarget} LIKE '%{$searchKeyword[$i]}%'";
           }else{
             $word = $word." AND {$seaechTarget} LIKE '%{$searchKeyword[$i]}%'";
           }
         }
         $sql = "SELECT a.*, b.work_name, b.color, b.textColor from (SELECT * FROM tech_schedule_list WHERE $word) a left join work_name_config b on a.work_name = b.work_name";
       }else{
         $searchKeyword = $data['searchKeyword'];
         $sql = "SELECT a.*, b.work_name, b.color, b.textColor from (SELECT * FROM tech_schedule_list WHERE {$seaechTarget} in ({$searchKeyword})) a left join work_name_config b on a.work_name = b.work_name";
       }
       // $sql = "SELECT * FROM tech_schedule_list WHERE {$seaechTarget} regexp '{$searchKeyword}'";
       $query = $this->db->query($sql);
       return $query->result();
     }else{

       if(is_array($data['searchKeyword'])){
         $searchKeyword = implode( '|', $data['searchKeyword'] );
       }else{
         $searchKeyword = $data['searchKeyword'];
       }
       // $searchKeyword = $data['searchKeyword'];
       $sql = "SELECT a.*, b.work_name, b.color, b.textColor from (SELECT * FROM tech_schedule_list WHERE {$seaechTarget} regexp '{$searchKeyword}') a left join work_name_config b on a.work_name = b.work_name";
       // $sql = "SELECT * FROM tech_schedule_list WHERE {$seaechTarget} regexp '{$searchKeyword}'";
       $query = $this->db->query($sql);
       return $query->result();

     }
   }
/////////////////주간 업무 연동
  function linker_group($name){
    $sql = "SELECT user_group FROM user WHERE user_name = '{$name}'";
    return $this->db->query($sql)->row();
  }
  function linker_id($name){
    $sql = "SELECT user_id FROM user WHERE user_name = '{$name}'";
    return $this->db->query($sql)->row();
  }

  function check_report($income_time, $linker_group, $linker){
    $sql = "SELECT * FROM weekly_report WHERE s_date <= '{$income_time}' AND e_date >= '{$income_time}' AND group_name = '{$linker_group}' AND writer ='{$linker}'";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0){
      return $query->row();
    }
  }
   function insert_next_week_doc($work_name, $customer, $group_name, $writer, $income_time, $linker, $linker_id, $user_id, $report_seq, $year, $month, $week){
     $sql1 = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'tech_schedule_list' AND table_schema = DATABASE( )";
     $query = $this->db->query($sql1)->row();
     $schedule_seq = $query->AUTO_INCREMENT-1;
     if ($linker_id != $user_id) {
       $schedule_seq = $schedule_seq * -1;
     }
     // return $schedule_seq;
     $sql2 = "SELECT MIN(tech_seq)-1 as m1 from next_weekly_report_doc";
     $query = $this->db->query($sql2)->row();
     $tech_seq = $query->m1;

     $sql3 = "INSERT INTO next_weekly_report_doc (tech_seq, schedule_seq, group_name, work_name, customer, writer, income_time, linker, report_seq, year, month, week) VALUES ($tech_seq, $schedule_seq, '{$group_name}', '{$work_name}', '{$customer}', '{$writer}', '{$income_time}', '{$linker}', $report_seq, $year, $month, $week );";
     $query = $this->db->query($sql3);


     $before_day =  date("Y-m-d", strtotime($income_time." -7day"));
     $sql = "SELECT seq FROM weekly_report WHERE s_date <= '{$before_day}' AND e_date >= '{$before_day}' AND group_name = '기술본부'";
     $query = $this->db->query($sql);
     if ($query->num_rows() > 0 && $group_name !="기술본부" && $schedule_seq >0){
       $rep_seq = $query->row()->seq;
       $sql4 = "INSERT INTO next_weekly_report_doc (tech_seq, schedule_seq, group_name, work_name, customer, writer, income_time, linker, report_seq, year, month, week) VALUES ($tech_seq, $schedule_seq, '기술본부', '{$work_name}', '{$customer}', '{$writer}', '{$income_time}', '{$linker}', $rep_seq, $year, $month, $week );";
       $query = $this->db->query($sql4);
     }

   }

   function update_next_week_doc($data){
     $seq = $data['schedule_seq'];
     $income_time = $data['income_time'];
     $update_data = array(
               'income_time' => $income_time
            );
     $this->db->where('schedule_seq', $seq);
     $this->db->or_where('schedule_seq', $seq*-1);
     $this->db->update('next_weekly_report_doc', $update_data);
   }

   function delete_next_week_doc($seq){
     $this->db->where('schedule_seq', $seq);
     $this->db->or_where('schedule_seq', $seq*-1);
     $this->db->delete('next_weekly_report_doc');
   }




/////////////////기지보 관련
function search_tech_report($reportData){
  $today = $reportData['today'];
  $sessionName = $reportData['sessionName'];
  // $sql = "SELECT * FROM tech_schedule_list  WHERE tech_report = 'N' AND start_day < '{$today}' AND end_day < '{$today}';";
  $sql = "SELECT * FROM tech_schedule_list  WHERE tech_report = 'N' AND start_day < '{$today}' AND end_day < '{$today}' AND (participant LIKE '%{$sessionName}%');";

  // $sql = "SELECT * FROM tech_schedule_list  WHERE tech_report = 'N' AND start_day < '{$today}' AND end_day < '{$today}' AND participant = (SELECT distinct user_name FROM tech_schedule_list WHERE user_id = '{$$sessionId}');";
  $query = $this->db->query($sql);
  return $query->result();
}

function tech_seq_find($data){
  $schedule_seq = $data['schedule_seq'];
  $where = "WHERE schedule_seq={$schedule_seq}";
  $sql = "SELECT seq FROM tech_doc_basic {$where}";
  $query = $this->db->query($sql);
  return $query->result();
}

//KI1 20210125 고객사 포캐스팅형으로 변경하여 고객사 리스트 불러오기
// 고객사 정보 가저오기
//카테고리 알아오기
function get_customer() {
  // $sql = "select seq as forcasting_seq, customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_forcasting WHERE (sub_project_add IS NULL) or (sub_project_add IS not NULL AND sub_project_add not like CONCAT('%',seq,'%')) order by binary(customer)";
	$sql = "select seq as maintain_seq, forcasting_seq , customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3 order by binary(customer_companyname)";

//	$sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
  $query = $this->db->query($sql);
  return $query->result_array();
}
function get_customer2() {
  $sql = "select t1.seq as forcasting_seq,t1.customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_forcasting AS t1 order by binary(customer_companyname)";
  $query = $this->db->query($sql);
  return $query->result_array();
}
//KI2 20210125

}


 ?>

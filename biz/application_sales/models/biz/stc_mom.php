<?php
header("Content-type: text/html; charset=utf-8");

class STC_mom extends CI_Model {

   function __construct() {

      parent::__construct();
      $this->lv = $this->phpsession->get( 'lv', 'stc' );
      $this->name= $this->phpsession->get( 'name', 'stc' );
      $this->pGroupName= $this->phpsession->get( 'pGroupName', 'stc' );
   }

//  기본 정보 가져오기
function get_base(){
  $sql = "SELECT * FROM user_group WHERE groupName !='CEO' AND groupName !='홍보전략실'";
  $data['user_group'] = $this->db->query($sql)->result();

  $sql = "SELECT seq, user_id, user_name, user_duty, user_group FROM user WHERE quit_date is null ORDER BY seq ASC";
  $data['user'] = $this->db->query($sql)->result();

  $sql = "SELECT seq, room_name FROM meeting_room ORDER BY seq DESC";
  $data['place'] = $this->db->query($sql)->result();

  return $data;
}

// 회의록 테이블 인서트 후에 시퀀스 값 가져오기
function mom_input_action($data){
  $result = $this->db->insert('biz_mom', $data);
  if($result){
    $sql ="SELECT AUTO_INCREMENT as mom_seq FROM information_schema.tables WHERE table_name = 'biz_mom' AND table_schema = DATABASE()";
    $query = $this->db->query($sql)->row();
    $mom_seq = $query->mom_seq-1;
    return $mom_seq;
  }else{
    return false;
  }
}
// 회의록 내용 테이블에다가 인서트
function mom_input_contents($data){
  $result = $this->db->insert_batch('biz_mom_contents', $data);
  return $result;
}


function mom_list( $type, $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
  $keyword = "%".$searchkeyword."%";

  $biz_lv = substr($this->lv,0,1);

  $my_list =  " AND (writer_id = '{$this->id}' OR participant LIKE '%{$this->id}%')";

  if($searchkeyword != "") {
    if($search1 == "001") {
      $searchstring = " and title like ? ";
    }else if($search1 == "002"){
      $searchstring = " and a.user_group like ? ";
    }

  } else {
    $searchstring = "";

  }

  $sql = "SELECT a.*, b.user_name, IFNULL(a.update_day, a.insert_day) AS add_date FROM biz_mom AS a LEFT JOIN user AS b ON a.writer_id = b.user_id WHERE register ='{$type}'{$my_list}".$searchstring." ORDER BY day DESC, start_time DESC, add_date DESC";
  if  ( $offset <> 0 )
    $sql = $sql." limit ?, ?";

  if  ( $searchkeyword != "" )
    $query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
  else
    $query = $this->db->query( $sql, array( $start_limit, $offset ) );

  return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
}

//회의록 리스트개수
function mom_list_count($type, $searchkeyword, $search1) {
  $keyword = "%".$searchkeyword."%";

  $my_list =  " AND (writer_id = '{$this->id}' OR participant LIKE '%{$this->id}%')";

  if($searchkeyword != "") {
    if($search1 == "001") {
      $searchstring = " and title like ? ";
    }else if($search1 == "002"){
      $searchstring = " and user_group like ? ";
    }

  } else {
    $searchstring = "";

  }

  $sql = "select count(seq) as ucount from biz_mom WHERE register ='{$type}'{$my_list}".$searchstring." ORDER BY day DESC";

  if  ( $searchkeyword != "" )
    $query = $this->db->query( $sql, $keyword  );
  else
    $query = $this->db->query( $sql );
  return $query->row();
}


//	뷰내용 가져오기
function mom_view( $seq = 0 ) {
  $sql = "select * from biz_mom where seq = ?";
  $query = $this->db->query( $sql, $seq );

  if ($query->num_rows() <= 0) {
    return false;
  } else {
    return $query->row_array() ;
  }
}

function mom_view_contents( $seq = 0 ) {
  $sql = "select * from biz_mom_contents where mom_seq = ? order by tr_index";
  $query = $this->db->query( $sql, $seq );

  if ($query->num_rows() <= 0) {
    // return false;
    return array();
  } else {
    return $query->result() ;
  }
}

function get_username($id){
  $sql = "SELECT user_name, user_duty FROM user WHERE user_id = '{$id}'";
  $query = $this->db->query( $sql );

  if ($query->num_rows() <= 0) {
    return false;
  } else {
    return $query->row();
  }
}

function mom_modify_action($data, $seq){

  $this->db->where('seq', $seq);
  $result = $this->db->update('biz_mom', $data);
  return $result;
}
function mom_content_update($data, $seq){
  $this->db->where('seq', $seq);
  $result = $this->db->update('biz_mom_contents', $data);
  return $result;
}

function mom_content_del($seq, $mom_seq){
  $sql = "DELETE FROM biz_mom_contents WHERE mom_seq = '{$mom_seq}' AND seq ='{$seq}'";
  $query = $this->db->query( $sql );
  return $query;
}


function mom_del_action($seq){
  $sql = "DELETE FROM biz_mom_contents WHERE mom_seq = {$seq}";
  $query = $this->db->query( $sql );
  $sql = "DELETE FROM biz_mom WHERE seq = {$seq}";
  $query = $this->db->query( $sql );
  return $query;
}

 }


 ?>

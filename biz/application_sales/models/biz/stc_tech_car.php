<?php
header("Content-type: text/html; charset=utf-8");

class STC_tech_car extends CI_Model {



function __construct() {

  parent::__construct();
//              $this->user_id = $this->phpsession->get( 'id', 'stc' );
}


  function tech_car_insert( $data, $mode =0 , $seq =0) {

    if( $mode == 0 ) {
			return $this->db->insert('car_drive', $data );
    }else {
      return $this->db->update('car_drive', $data, array('seq' => $seq));
    }
  }

  function tech_car_list( $id, $biz_lv, $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
    $keyword = "%".$searchkeyword."%";

    if($searchkeyword != "") {
      if($search1 == "001") {
          $searchstring = " and carnum like ? "; //  수정포인트 -작업명
      } else if($search1 == "002" ) {
          $searchstring = " and d_point like ? "; //  수정포인트 - 고객사
      } else if($search1 == "003" ) {
          $searchstring = " and a_point like ? "; //  수정포인트 - 작성자
      } else if($search1 == "004" ) {
          $searchstring = " and driver like ? "; //  수정포인트 - 작업일
      } else if($search1 == "005" ) {
          $searchstring = " and drive_date like ? "; //  수정포인트 - 작업일
      }
    } else {
        $searchstring = "";
    }

    if($biz_lv == 3){
      $sql = "select * from car_drive where 1=1".$searchstring." order by seq desc"; //  수정포인트
    }else{
      $sql1 = "SELECT seq FROM user WHERE user_id = '{$id}'";
      $query = $this->db->query($sql1)->row();
      $user_seq = $query->seq;
      $sql = "select number from admin_car where user_name = '공용' || user_seq = {$user_seq} order by seq";
      $car_list = $this->db->query($sql)->result();
      // var_dump($car_list);
      $car_arr = array();
      foreach ($car_list as $car) {
        array_push($car_arr, $car->number);
      }
      $car_str = implode( '|', $car_arr );

      $sql = "select * from car_drive where 1=1 and carnum regexp '{$car_str}'".$searchstring." order by seq desc";
    }

    if  ( $offset <> 0 )
            $sql = $sql." limit ?, ?";

    if  ( $searchkeyword != "" )
            $query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
    else
            $query = $this->db->query( $sql, array( $start_limit, $offset ) );

    return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
  }

  function tech_car_list_count( $id, $biz_lv, $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
    $keyword = "%".$searchkeyword."%";

    if($searchkeyword != "") {
      if($search1 == "001") {
          $searchstring = " and carnum like ? "; //  수정포인트 -작업명
      } else if($search1 == "002" ) {
          $searchstring = " and d_point like ? "; //  수정포인트 - 고객사
      } else if($search1 == "003" ) {
          $searchstring = " and a_point like ? "; //  수정포인트 - 작성자
      } else if($search1 == "004" ) {
          $searchstring = " and driver like ? "; //  수정포인트 - 작업일
      } else if($search1 == "005" ) {
          $searchstring = " and drive_date like ? "; //  수정포인트 - 작업일
      }
    } else {
        $searchstring = "";
    }

    if($biz_lv == 3){
      $sql = "select count(seq) as ucount from car_drive where 1=1".$searchstring." order by seq desc"; //  수정포인트
    }else{
      $sql1 = "SELECT seq FROM user WHERE user_id = '{$id}'";
      $query = $this->db->query($sql1)->row();
      $user_seq = $query->seq;
      $sql = "select number from admin_car where user_name = '공용' || user_seq = {$user_seq} order by seq";
      $car_list = $this->db->query($sql)->result();
      // var_dump($car_list);
      $car_arr = array();
      foreach ($car_list as $car) {
        array_push($car_arr, $car->number);
      }
      $car_str = implode( '|', $car_arr );

      $sql = "select count(seq) as ucount from car_drive where 1=1 and carnum regexp '{$car_str}'".$searchstring." order by seq desc";
    }

    if  ( $searchkeyword != "" )
            $query = $this->db->query( $sql, $keyword  );
    else
            $query = $this->db->query( $sql );
    return $query->row();
  }

  function car_drive_view( $seq  ) {
    $sql = "select * from car_drive where seq = ?";
    $query = $this->db->query( $sql, $seq );

    if ($query->num_rows() <= 0) {
            return false;
    } else {
            return $query->row_array() ;
    }
  }

  function tech_car_delete( $seq ) {
    // $sql = "delete from car_drive where seq = ?";
    // $query = $this->db->query( $sql, $seq );
    // return  $query;

    $this->db->where('seq',$seq);
    $this->db->delete('car_drive');
  }

	function car_max_km( $carnum ) {

		$sql = "select a_km as max_km from car_drive where carnum='{$carnum}' order by seq desc limit 1";

    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return $query->row_array();
    }else{
      $max_km = array('max_km'=>0);
      return $max_km;
    }
	}

  function car_list($id, $biz_lv){
    if($biz_lv == 3){
      $sql = "select * from admin_car order by seq";

    }else{
      $sql1 = "SELECT seq FROM user WHERE user_id = '{$id}'";
      $query = $this->db->query($sql1)->row();
      $user_seq = $query->seq;
      $sql = "select * from admin_car where user_name = '공용' || user_seq = {$user_seq} order by seq";

    }
    $query = $this->db->query($sql);

    return $query->result();
  }

  function find_modify_seq($seq){
    $sql = "SELECT * FROM car_drive WHERE seq = {$seq}";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
  }

  function find_last_a_km($carname, $carnum){
    // $sql = "SELECT a_km FROM car_drive WHERE carname = '{$carname}' AND carnum = '{$carnum}' ORDER BY seq DESC LIMIT 1";
    $sql = "SELECT MAX(CAST(a_km AS SIGNED integer)) as max_a_km FROM car_drive WHERE carname = '{$carname}' AND carnum = '{$carnum}'";
    $query = $this->db->query($sql);
    $result = $query->row();
    if($result <> false){
      $result = $result->max_a_km;
      return $result;
    }else{
      return 'false';
    }
  }
  function find_before_a_km($data){
    $seq = $data['seq'];
    $carname = $data['carname'];
    $carnum = $data['carnum'];
    $sql = "SELECT a_km FROM car_drive WHERE carname = '{$carname}' AND carnum = '{$carnum}' AND seq < {$seq} ORDER BY seq DESC LIMIT 1";
    $query = $this->db->query($sql);
    // echo $this->db->last_query();
    $result = $query->row();
    if($result <> false){
      $result = $result->a_km;
      return $result;
    }else{
      return 'false';
    }
  }

  function change_km($data){
    $seq = $data['seq'];
    $carname = $data['carname'];
    $carnum = $data['carnum'];
    $sql = "SELECT seq,a_km FROM car_drive WHERE carname = '{$carname}' AND carnum = '{$carnum}' AND seq > {$seq} ORDER BY seq ASC LIMIT 1";
    $query = $this->db->query($sql);
    // echo $this->db->last_query();
    $result = $query->row();
    if($result <> false){
      // $result = $result->seq;
      return $result;
    }else{
      return 'false';
    }
  }

  function find_before_seq($data){
    $seq = $data['seq'];
    $carname = $data['carname'];
    $carnum = $data['carnum'];
    $sql = "SELECT seq FROM car_drive WHERE carname = '{$carname}' AND carnum = '{$carnum}' AND seq < {$seq} ORDER BY seq DESC LIMIT 1";
    $query = $this->db->query($sql);
    // echo $this->db->last_query();
    $result = $query->row();
    if($result <> false){
      $result = $result->seq;
      return $result;
    }else{
      return 'false';
    }
  }

  // 엑셀다운 (ajax)
  function excelDownload(){
    $sql = "SELECT * FROM car_drive order BY seq DESC";
    $query = $this->db->query($sql);

    if ($query->num_rows() <= 0) {
      return false;
    } else {
      return $query->result_array();
    }
  }


}
?>

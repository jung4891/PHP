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
                }
                else {
                        return $this->db->update('car_drive', $data, array('seq' => $seq));
                }


        }
	
        function tech_car_list( $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
                $keyword = "%".$searchkeyword."%";

                if($searchkeyword != "") {
                        if($search1 == "001") {
                                $searchstring = " where carnum like ? "; //  수정포인트 -작업명
                        } else if($search1 == "002" ) {
                                $searchstring = " where d_point like ? "; //  수정포인트 - 고객사
                        } else if($search1 == "003" ) {
                                $searchstring = " where a_point like ? "; //  수정포인트 - 작성자
                        } else if($search1 == "004" ) {
                                $searchstring = " where driver like ? "; //  수정포인트 - 작업일
                        } else if($search1 == "005" ) {
                                $searchstring = " where drive_date like ? "; //  수정포인트 - 작업일
                        }

                } else {
                        $searchstring = "";
                }

                $sql = "select * from car_drive".$searchstring." order by seq desc"; //  수정포인트

                if  ( $offset <> 0 )
                        $sql = $sql." limit ?, ?";

                if  ( $searchkeyword != "" )
                        $query = $this->db->query( $sql, array( $keyword, $start_limit, $offset ) );
                else
                        $query = $this->db->query( $sql, array( $start_limit, $offset ) );

                return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
        }

        function tech_car_list_count( $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
                $keyword = "%".$searchkeyword."%";

                if($searchkeyword != "") {
                        if($search1 == "001") {
                                $searchstring = " where carnum like ? "; //  수정포인트 -작업명
                        } else if($search1 == "002" ) {
                                $searchstring = " where d_point like ? "; //  수정포인트 - 고객사
                        } else if($search1 == "003" ) {
                                $searchstring = " where a_point like ? "; //  수정포인트 - 작성자
                        } else if($search1 == "004" ) {
                                $searchstring = " where driver like ? "; //  수정포인트 - 작업일
                        } else if($search1 == "005" ) {
                                $searchstring = " where drive_date like ? "; //  수정포인트 - 작업일
                        }

                } else {
                        $searchstring = "";
                }

                $sql = "select count(seq) as ucount from car_drive".$searchstring." order by seq desc"; //  수정포인트

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
                $sql = "delete from car_drive where seq = ?";
                $query = $this->db->query( $sql, $seq );

                return  $query;
        }

	function car_max_km( $carnum ) {

		$sql = "select a_km as max_km from car_drive where carnum=? order by seq desc limit 1";
		$query = $this->db->query($sql,$carnum);

		return $query->row_array();

	}

}
?>

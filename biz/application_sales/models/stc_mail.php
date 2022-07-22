<?php
header("Content-type: text/html; charset=utf-8");

class STC_mail extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}


  function aes_key($uid, $password, $mode=0){

   $sql = "SELECT COUNT(*) AS ucount FROM aes_key WHERE uid = '{$uid}'";
   $query = $this->db->query($sql);
   $num_rows = $query->row();
	 if($mode == 0){
		 if($num_rows->ucount > 0){
			 return true;
		} else {
			$sql = "INSERT INTO aes_key (uid, pkey) VALUES ('{$uid}','{$password}')";
		}
	 } else {
		 if($num_rows->ucount > 0){
			 $sql = "UPDATE aes_key SET pkey = '{$password}' WHERE uid = '${uid}'";
		 } else {
			 $sql = "INSERT INTO aes_key (uid, pkey) VALUES ('{$uid}','{$password}')";
		 }
	 }
	 $query = $this->db->query($sql);
	 if($query){
		 return true;
	 }
}

function mbox_conf($uid){
  $sql = "SELECT uid, pkey FROM aes_key WHERE uid = '{$uid}'";

  $query = $this->db->query($sql);
  if($query->num_rows() > 0){
    return $query->row();
  }else{
    return false;
  }
}


function mailhead_insert($insert_data){

	$sql = "INSERT INTO biz_mail (address, mbox, mail_id, from_name, from_mail, subject, udate, size, seen)
SELECT '{$insert_data['address']}', '{$insert_data['mbox']}', '{$insert_data['uid']}', '{$insert_data['from_name']}', '{$insert_data['from_mail']}', '{$insert_data['subject']}', '{$insert_data['udate']}','{$insert_data['size']}', '{$insert_data['read']}'
FROM dual
WHERE NOT EXISTS
(SELECT * FROM biz_mail WHERE address = '{$insert_data['address']}' AND mbox='{$insert_data['mbox']}' AND subject = '{$insert_data['subject']}' AND udate = '{$insert_data['udate']}' )";

$query = $this->db->query($sql);


}

function get_dbmail($mail){
	$sql = "SELECT * FROM biz_mail
WHERE address = '{$mail}'
ORDER BY seq DESC LIMIT 7";

	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
		return $query->result();
	}else{
		return false;
	}

}

function mail_seen($seq){
	$sql = "UPDATE biz_mail SET seen = 1 WHERE seq = '{$seq}'";
	$query = $this->db->query($sql);
}









}
?>

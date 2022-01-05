<?php
header("Content-type: text/html; charset=utf-8");

class M_dbmail extends CI_Model {

	function __construct() {

		parent::__construct();

	}


	function mailhead_insert($insert_data){

		$sql = "INSERT INTO biz_mail (address, mbox, mail_id, from_name, from_mail, subject, udate, size, seen)
	SELECT '{$insert_data['address']}', '{$insert_data['mbox']}', '{$insert_data['uid']}', '{$insert_data['from_name']}', '{$insert_data['from_mail']}', '{$insert_data['subject']}', '{$insert_data['udate']}','{$insert_data['size']}', '{$insert_data['read']}'
	FROM dual
	WHERE NOT EXISTS
	(SELECT * FROM biz_mail WHERE address = '{$insert_data['address']}' AND mbox='{$insert_data['mbox']}' AND subject = '{$insert_data['subject']}' AND udate = '{$insert_data['udate']}' )";

	$query = $this->db->query($sql);


	}

	function get_country($ip){
				$sql = "SELECT country
		FROM ip2nation
		WHERE ip < INET_ATON('{$ip}')
		ORDER BY ip DESC
		LIMIT 0,1";

			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->row();
			}else{
				return false;
			}

	}

}

?>

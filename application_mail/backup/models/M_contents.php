<?php
header("Content-type: text/html; charset=utf-8");
class M_contents extends CI_Model {

	function __construct() {

		parent::__construct();

	}

	function count_mails($user_id) {
		$sql = " SELECT count(mail_id) FROM contents WHERE user_id = '$user_id' ";
		$res = $this->db->query($sql)->result_array();
		return $res[0]['count(mail_id)'];
	}

	function insert_mail_all($sql) {
		$this->db->query($sql);
	}

	function get_mailID_arr($user_id, $mbox) {
	$sql = " SELECT mail_id FROM contents WHERE user_id = '$user_id' AND mbox = '$mbox' ";
	$result = $this->db->query($sql)->result_array();
	return $result;
	}

	function insert_mail($user_id, $mbox, $mail_id, $contents) {
	$sql = " INSERT IGNORE INTO contents (user_id, mbox, mail_id, contents) VALUES
	('{$user_id}', '{$mbox}', '{$mail_id}', '{$contents}') ";
	$this->db->query($sql);
	}

	function delete_mail($user_id, $mbox, $mail_id) {
    $sql = " DELETE FROM contents where user_id = '$user_id' AND mbox = '$mbox' AND mail_id = '$mail_id' ";
    $this->db->query("$sql");
  }

	function get_mailID_arr_search($user_id, $mbox, $search_word) {
	$sql = " SELECT mail_id FROM contents WHERE user_id = '$user_id' AND mbox = '$mbox' AND contents LIKE '%$search_word%' ";
	$result = $this->db->query($sql)->result_array();
	return $result;
}













}








 ?>

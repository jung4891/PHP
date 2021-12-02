<?php
header("Content-type: text/html; charset=utf-8");

class M_mailbox extends CI_Model {

	function __construct() {

		parent::__construct();

	}


  function domain_list(){
    $sql = "SELECT distinct domain FROM mailbox
ORDER BY FIELD(domain, 'durianit.com', 'durianit.co.kr') DESC";
    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
        return false;
    } else {
        return $query->result();
    }

  }

	function mailbox_list($searchdomain, $searchkeyword, $start_limit = 0, $offset = 0){
	if($searchdomain == ""){
		$searchdomain = "";
	}else{
		$searchdomain = " AND a.domain = '{$searchdomain}'";
	}

	if($searchkeyword == ""){
		$searchkeyword = "";
	}else{
		$ptn = '/^[a-zA-Z0-9]+$/';
		// $chk_char = $this->is_hangul_char($searchkeyword);
		$chk_char = preg_match($ptn, $searchkeyword);

		if($chk_char){
			$searchkeyword = " AND a.username LIKE '%{$searchkeyword}%'";
		}else{
			$searchkeyword = " AND a.name LIKE '%{$searchkeyword}%'";
		}
	}

		$sql = "SELECT a.username, b.goto, IF(a.username = b.`goto`, 'Mailbox', b.goto) AS target,
a.name, a.maildir, a.local_part, a.domain, a.modified, a.active,
a.quota, c.bytes, c.messages
FROM mailbox a
JOIN alias b
ON a.username = b.address
LEFT JOIN quota2 c
ON a.username = c.username
WHERE 1=1 {$searchdomain}{$searchkeyword}";


		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}

		$query = $this->db->query($sql);
	
		$result = $query->result();
		return $result;

	}

	function mailbox_list_count($searchdomain, $searchkeyword){
	if($searchdomain == ""){
		$searchdomain = "";
	}else{
		$searchdomain = " AND a.domain = '{$searchdomain}'";
	}

	if($searchkeyword == ""){
		$searchkeyword = "";
	}else{
		$ptn = '/^[a-zA-Z0-9]+$/';
		// $chk_char = $this->is_hangul_char($searchkeyword);
		$chk_char = preg_match($ptn, $searchkeyword);

		if($chk_char){
			$searchkeyword = " AND a.username LIKE '%{$searchkeyword}%'";
		}else{
			$searchkeyword = " AND a.name LIKE '%{$searchkeyword}%'";
		}
	}

		$sql = "SELECT COUNT(*) as ucount
FROM mailbox a
JOIN alias b
ON a.username = b.address
LEFT JOIN quota2 c
ON a.username = c.username
WHERE 1=1 {$searchdomain}{$searchkeyword}";


		$query = $this->db->query($sql);
 		return $query->row();
			return $result;
		}


	function dupl_mailbox($id){
		$sql = "SELECT username FROM mailbox WHERE username ='{$id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return "dupl";
		}else{
			return "ok";
		}
	}
// 50 test
	// function insert_mailbox($user, $aliases){
  //   $admin_add = $this->db->insert('virtual_users', $user);
  //   $domain_add = $this->db->insert('virtual_aliases', $aliases);
  //   if($admin_add && $domain_add){
  //     return true;
  //   }
  // }

	function insert_mailbox($user, $aliases, $quota, $log){

	  $admin_add = $this->db->insert('mailbox', $user);
	  $domain_add = $this->db->insert('alias', $aliases);
		$quota_add = $this->db->insert('quota2', $quota);
		$log_add = $this->db->insert('log', $log);
	  if($admin_add && $domain_add && $quota_add && $log_add){
	    return true;
	  }
	}

	function del_mailbox($id, $log){
		$admin_del = $this->db->delete('mailbox', array('username' => $id));
		$domain_del = $this->db->delete('alias', array('address' => $id));
		$quota_del = $this->db->delete('quota2', array('username' => $id));
		$log_add = $this->db->insert('log', $log);
		if($admin_del && $domain_del && $quota_del){
			return true;
		}
	}

	function mailbox_info($id){
		$sql = "SELECT * FROM mailbox WHERE username = '{$id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return false;
		}
	}

	function update_mailbox($mailbox, $id, $log){
    // $this->db->where('username', $id);
    // $admin_update = $this->db->update('admin', $admin);
    // $admin_update = $this->db->update('domain_admins', $domain);


    $mailbox_update = $this->db->update('mailbox', $mailbox, array('username' => $id));
		$log_add = $this->db->insert('log', $log);
    if($mailbox_update){
      return true;
    }
  }


}
?>

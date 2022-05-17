<?php
header("Content-type: text/html; charset=utf-8");

class M_domain extends CI_Model {

	function __construct() {

		parent::__construct();

	}


  function domain_list($start_limit = 0, $offset = 0){
    $sql = "SELECT d.*,ac.alias_count, bc.box_count FROM domain d
LEFT JOIN
(SELECT COUNT(*) alias_count ,alias.domain
    FROM alias LEFT JOIN mailbox ON alias.address=mailbox.username
    WHERE mailbox.maildir IS NULL
    GROUP BY alias.domain) ac
ON d.domain = ac.domain
LEFT JOIN
(SELECT COUNT(*) box_count, domain FROM mailbox GROUP BY domain) AS bc
ON d.domain = bc.domain
WHERE d.domain != 'ALL'
ORDER BY FIELD(d.domain, 'durianit.com', 'durianit.co.kr') DESC";

if  ( $offset <> 0 ) {
  $sql = $sql." LIMIT {$start_limit}, {$offset}";
}


    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
        return false;
    } else {
        return $query->result();
    }

  }


	function domain_list_count(){

		$sql = "SELECT COUNT(*) as ucount
FROM domain WHERE domain !='ALL'";


		$query = $this->db->query($sql);
 		return $query->row();
			return $result;
		}


	function dupl_domain($id){
		$sql = "SELECT domain FROM domain WHERE domain ='{$id}'";
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

	function insert_domain($domain){

	  $domain_add = $this->db->insert('domain', $domain);
	  if($domain_add){
	    return true;
	  }
	}

	function del_domain($id){
		// $admin_del = $this->db->delete('mailbox', array('username' => $id));
		$domain_del = $this->db->delete('domain', array('domain' => $id));
		// $quota_del = $this->db->delete('quota2', array('username' => $id));
		// $log_add = $this->db->insert('log', $log);
		if($domain_del){
			return true;
		}
	}

	function domain_info($id){
		$sql = "SELECT * FROM domain WHERE domain = '{$id}'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return false;
		}
	}

	function update_domain($modify_array, $id){
    // $this->db->where('username', $id);
    // $admin_update = $this->db->update('admin', $admin);
    // $admin_update = $this->db->update('domain_admins', $domain);


    $mailbox_update = $this->db->update('domain', $modify_array, array('domain' => $id));
		// if($log != "password"){
		//
		// 	$log_add = $this->db->insert('log', $log);
		// }
    if($mailbox_update){
      return true;
    }
  }


}
?>

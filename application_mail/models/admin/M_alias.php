<?php
header("Content-type: text/html; charset=utf-8");

class M_alias extends CI_Model {

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

	function alias_list($searchdomain, $search_keyword, $start_limit = 0, $offset = 0){
	if($searchdomain == ""){
		$searchdomain = "";
	}else{
		$searchdomain = " AND alias.domain = '{$searchdomain}'";
	}

	if($search_keyword == ""){
		$search_keyword = "";
	}else{
		$search_keyword = " AND (alias.address LIKE '%{$search_keyword}%' OR alias.goto LIKE '%{$search_keyword}%')";
	}


		$sql = "SELECT alias.address,
    alias.goto,
    alias.domain,
    alias.modified,
    alias.active
    FROM alias LEFT JOIN mailbox ON alias.address=mailbox.username
    WHERE mailbox.maildir IS NULL {$searchdomain}{$search_keyword}";


		// $sql = "SELECT * FROM virtual_users WHERE 1=1 {$searchdomain}";

		$rows = $this->db->query($sql)->num_rows();

		if  ( $offset <> 0 ) {
			$sql = $sql." LIMIT {$start_limit}, {$offset}";
		}

		$query = $this->db->query($sql);
		if ($query->num_rows() <= 0) {
			$result['rows'] = 0;
			$result['list'] = false;
			return $result;

		} else {
			$result['rows'] = $rows;
			$result['list'] = $query->result();
			return $result;
		}
	}

  function goto_list($keyword = ""){
		if($keyword == ""){
			$search_keyword = "";
		}else{
			// $search_keyword = " AND (alias.address LIKE '%김보%' OR mailbox.name LIKE '%김보%')";
			$ptn = '/^[a-zA-Z0-9]+$/';
			$chk_char = preg_match($ptn, $keyword);
			if($chk_char){
				$search_keyword = " AND alias.address LIKE '%{$keyword}%'";
			}else{
				$search_keyword = " AND mailbox.name LIKE '%{$keyword}%'";
			}
		}
    $sql = "SELECT alias.address,
    alias.goto,
    alias.domain,
    alias.modified,
    alias.active,
    mailbox.name
    FROM alias LEFT JOIN mailbox ON alias.address=mailbox.username
    WHERE mailbox.maildir IS NOT NULL
    AND alias.active = 1{$search_keyword}";

    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return $query->result();
    }
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

	function insert_alias($aliases){
	  $alias_add = $this->db->insert('alias', $aliases);

	  if($alias_add){
	    return true;
	  }
	}

	function alias_info($id){
		$sql = 	"SELECT address, goto, active FROM alias WHERE address ='{$id}'";
		$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return $query->row();
			}else{
				return false;
			}
	}

	function del_alias($id, $log){
		$alias_del = $this->db->delete('alias', array('address' => $id));
		$log_add = $this->db->insert('log', $log);
		if($alias_del){
			return true;
		}
	}

	// function mailbox_info($id){
	// 	$sql = "SELECT * FROM mailbox WHERE username = '{$id}'";
	// 	$query = $this->db->query($sql);
	// 	if ($query->num_rows() > 0) {
	// 		return $query->row();

	// 	}else{
	// 		return false;
	// 	}
	// }

	function update_mailbox($goto, $id){
    // $this->db->where('username', $id);
    // $admin_update = $this->db->update('admin', $admin);
    // $admin_update = $this->db->update('domain_admins', $domain);
    $alias_update = $this->db->update('alias', $goto, array('address' => $id));
    if($alias_update){
      return true;
    }
  }


}
?>

<?php
header("Content-type: text/html; charset=utf-8");

class M_manager extends CI_Model {

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


  function admin_list(){
    $sql = "SELECT a.username, a.created, a.modified, a.active, b.domain
FROM admin a
JOIN domain_admins b
ON a.username = b.username";
    $query = $this->db->query($sql);
    if ($query->num_rows() <= 0) {
        return false;
    } else {
        $result['rows'] = $query->num_rows();
        $result['lists'] = $query->result();
        return $result;
    }

  }

  function insert_admin($admin, $domain){
    $admin_add = $this->db->insert('admin', $admin);
    $domain_add = $this->db->insert('domain_admins', $domain);
    if($admin_add && $domain_add){
      return true;
    }
  }

  function del_admin($id){
    $admin_del = $this->db->delete('admin', array('username' => $id));
    $domain_del = $this->db->delete('domain_admins', array('username' => $id));
    if($admin_del && $domain_del){
      return true;
    }

  }

	function admin_info($id){
		$sql = "SELECT a.username, a.created, a.modified, a.active, b.domain
FROM admin a
JOIN domain_admins b
ON a.username = b.username
WHERE a.username = '{$id}'";
  $query = $this->db->query($sql);
	return $query->row();
	}

  function update_admin($admin, $domain, $id){
    // $this->db->where('username', $id);
    // $admin_update = $this->db->update('admin', $admin);
    // $admin_update = $this->db->update('domain_admins', $domain);

    $admin_update = $this->db->update('admin', $admin, array('username' => $id));
    $domain_update = $this->db->update('domain_admins', $domain, array('username' => $id));
    if($admin_update && $admin_update){
      return true;
    }
  }

  function dupl_chkid($id){
    $sql = "SELECT username FROM admin WHERE username ='{$id}'";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      return "dupl";
    }else{
      return "ok";
    }
  }


}
?>

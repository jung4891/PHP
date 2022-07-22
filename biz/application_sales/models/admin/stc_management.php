<?php
header("Content-type: text/html; charset=utf-8");

class STC_Management extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->seq = $this->phpsession->get( 'seq', 'stc' );
	}

  function site_management_list($search_group, $search_company, $searchkeyword, $start_limit = 0, $offset = 0) {
    $sql = "SELECT * FROM admin_site_management t WHERE t.group = '{$search_group}'";

		$sql .= " AND company = '{$search_company}'";

		if($searchkeyword != '') {
			$sql .= " AND (site_name like '%{$searchkeyword}%' || site_url like '%{$searchkeyword}%' || note1 like '%{$searchkeyword}%' || note2 like '%{$searchkeyword}%')";
		}

		$sql .= " ORDER BY site_name";

		if($offset <> 0) {
			$sql .= " limit ?, ?";
		}
		// echo $sql;
    $query = $this->db->query( $sql, array( $start_limit, $offset ) );

    return $query->result_array();
  }

	function insert($data) {
		$result = $this->db->insert('admin_site_management',$data);

		if($result){
			return "true";
		}else{
			return "false";
		}
	}

	function update($data, $seq) {
		$result = $this->db->update('admin_site_management', $data, array('seq' => $seq));

		if($result) {
			return 'true';
		} else {
			return 'false';
		}
	}

	function delete($seq) {
		$sql = "delete from admin_site_management where seq = {$seq}";

		$query = $this->db->query($sql);

		return $query;
	}

}
?>

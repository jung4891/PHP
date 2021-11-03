<?php
header("Content-type: text/html; charset=utf-8");

class M_main extends CI_Model {

	function __construct() {

		parent::__construct();

	}


function domain_box(){
  $sql = "SELECT domain, sum(quota)/1024 AS quota FROM mailbox GROUP BY domain";

  $query = $this->db->query($sql);
  return  $query->result();
}



function admin_log($searchdomain, $searchkeyword, $start_limit = 0, $offset = 0){
	if($searchdomain == ""){
		$searchdomain = "";
	}else{
		$searchdomain = " AND domain = '{$searchdomain}'";
	}

	if($searchkeyword == ""){
		$searchkeyword = "";
	}else{
		$searchkeyword = " AND username LIKE '%{$searchkeyword}%'";
	}

	$sql = "SELECT * FROM log
WHERE 1=1 {$searchdomain}{$searchkeyword} ORDER BY `timestamp` desc";
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


}
?>

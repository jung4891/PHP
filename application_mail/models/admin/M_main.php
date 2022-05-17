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

function total_quota($domain){
	$sql = "SELECT (SELECT TRUNCATE(SUM(quota) / (1024*1024),0) FROM mailbox WHERE domain = '{$domain}') AS maxquota, TRUNCATE(SUM(bytes) / (1024*1024),0) AS bytes, SUM(messages) AS messages
FROM quota2
WHERE SUBSTRING_INDEX(username, '@', -1) = '{$domain}'";
$query = $this->db->query($sql);
return  $query->result();
}

function top_five($domain){
	$sql = "SELECT a.username, a.NAME as uname, TRUNCATE(b.bytes / (1024*1024),0) AS bytes, b.messages FROM mailbox a
JOIN quota2 b
ON a.username = b.username
WHERE a.domain = '{$domain}'
ORDER BY bytes DESC
LIMIT 5";
$query = $this->db->query($sql);
return  $query->result();
}

function mailbox_list($searchdomain, $start_limit = 0, $offset = 0){
if($searchdomain == ""){
	$searchdomain = "";
}else{
	$searchdomain = " AND a.domain = '{$searchdomain}'";
}


	$sql = "SELECT a.username, b.goto, IF(a.username = b.`goto`, 'Mailbox', b.goto) AS target,
a.name, a.maildir, a.local_part, a.domain, a.modified, a.active,
a.quota, c.bytes, c.messages
FROM mailbox a
JOIN alias b
ON a.username = b.address
LEFT JOIN quota2 c
ON a.username = c.username
WHERE 1=1 {$searchdomain} ORDER BY a.username";


	if  ( $offset <> 0 ) {
		$sql = $sql." LIMIT {$start_limit}, {$offset}";
	}

	$query = $this->db->query($sql);

	$result = $query->result();
	return $result;

}

function mailbox_list_count($searchdomain){
if($searchdomain == ""){
	$searchdomain = "";
}else{
	$searchdomain = " AND a.domain = '{$searchdomain}'";
}


	$sql = "SELECT COUNT(*) as ucount
FROM mailbox a
JOIN alias b
ON a.username = b.address
LEFT JOIN quota2 c
ON a.username = c.username
WHERE 1=1 {$searchdomain}";


	$query = $this->db->query($sql);
	return $query->row();
		return $result;
	}


function cnt_domain($domain){
	$sql = "SELECT COUNT(*) cntbox, (SELECT COUNT(*)
    FROM alias LEFT JOIN mailbox ON alias.address=mailbox.username
    WHERE mailbox.maildir IS NULL AND alias.domain = '{$domain}') cntalias
FROM mailbox
WHERE domain = '{$domain}'";
$query = $this->db->query($sql);
return $query->row();
	return $result;
}

function avg_domain($domain){
	$sql = "SELECT TRUNCATE(avg(b.bytes) / (1024*1024),0) AS avgbytes, TRUNCATE(avg(b.messages),0) avgmsg FROM mailbox a
JOIN quota2 b
ON a.username = b.username
WHERE a.domain = '{$domain}'";
$query = $this->db->query($sql);
return $query->row();
	return $result;
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
		$searchkeyword = " AND (username LIKE '%{$searchkeyword}%' OR action LIKE '%{$searchkeyword}%')";
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

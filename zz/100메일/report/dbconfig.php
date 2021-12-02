<?php
 header('Content-Type: text/html; charset=utf-8');

$db = new mysqli("localhost", "root", "durian0529", "tech_report");
if ($db->connect_errno){ die("Connect failed: ".$db->connect_error);
}

$db->set_charset('utf-8');

?>

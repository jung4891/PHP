<?php

class STC_ttest extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function user_list($sn) {
    if($sn != '') {
      $where = " AND user_name like '%{$sn}%'";
    }else {
      $where = '';
    }

    $sql = "SELECT * FROM user WHERE quit_date is null {$where} ORDER BY seq";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

}

 ?>

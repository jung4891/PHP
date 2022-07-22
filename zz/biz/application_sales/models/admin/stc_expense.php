<?php
header("Content-type: text/html; charset=utf-8");

class STC_Expense extends CI_Model {

	function __construct() {

		parent::__construct();
//		$this->user_id = $this->phpsession->get( 'id', 'stc' );
	}


	function expense_list($mode, $checked_user, $checked_detail, $search, $s_date, $e_date, $start_limit = 0, $offset = 0) {
    if($mode == 'list') {
      $sql = "SELECT el.*, u.user_name, ead.write_date, ead.completion_date, ead.approval_doc_status";
    } else if ($mode == 'count') {
      $sql = "SELECT sum(el.corporation_card) as corporation_card, sum(el.personal_card) as personal_card, sum(el.simple_receipt) as simple_receipt";
    }
    $sql .= " FROM expense_list el
            LEFT JOIN user u ON el.user_id = u.user_id
            LEFT JOIN electronic_approval_doc ead ON el.approval_seq = ead.seq
            WHERE ead.approval_doc_status = '002'";

    if($checked_user != '') {
      $checked_user = explode(',', $checked_user);
      $checked_user = join("','", $checked_user);
      $sql .= " AND el.user_id in ('{$checked_user}')";
    }
    if($checked_detail != '') {
      $checked_detail = explode(',', $checked_detail);
      $checked_detail = join("','", $checked_detail);
      if(strpos($checked_detail, '던킨') !== false) {
        $sql .= " AND (el.type = 'dunkin' OR el.details in ('{$checked_detail}'))";
      } else {
        $sql .= " AND el.details in ('{$checked_detail}')";
      }
    }

    if($s_date != '') {
      $sql .= " AND DATE({$search}) >= '{$s_date}'";
    }
    if($e_date != '') {
      $sql .= " AND DATE({$search}) <= '{$e_date}'";
    }

    $sql .= " ORDER BY t_date";
// echo $sql.'<br>';
// if($mode =='count'){echo $sql;}
    if($offset <> 0) {
      $sql .= " limit ?, ?";
    }

    $query = $this->db->query($sql, array($start_limit, $offset));

    return $query->result_array();
  }


}
?>

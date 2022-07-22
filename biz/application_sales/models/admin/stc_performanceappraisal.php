<?php
header("Content-type: text/html; charset=utf-8");

class STC_Performanceappraisal extends CI_Model {

	function __construct() {

		parent::__construct();
		// $this->user_id = $this->phpsession->get( 'id', 'stc' );
    $this->id = $this->phpsession->get( 'id', 'stc' );
    $this->duty = $this->phpsession->get( 'duty', 'stc' );
		$this->group = $this->phpsession->get( 'group', 'stc' );
	}

  function performance_appraisal($year) {
    $department_header_arr = ['이사', '상무이사', '팀장', '과장', '차장'];
    $department_header = false;

    if(in_array($this->duty, $department_header_arr)) {
      $department_header = true;
    }

    if($this->group == 'CEO' || $this->group == '기술연구소') {
      $target = "";
    } else if ($department_header) {
      $target = " AND user_group in ('{$this->group}')";
    } else {
      $target = " AND u.user_id = '{$this->id}'";
    }

    if ($department_header && $this->group == '기술본부') {
      $target = " AND user_group in ('기술본부', '기술1팀', '기술1팀-2', '기술2팀')";
    }

    $sql = "SELECT u.*, c.companion_cnt FROM user u LEFT JOIN (SELECT t.user_id, SUM(companion_cnt) AS companion_cnt
            FROM (
            SELECT u.user_id, t.companion_cnt
            FROM
            (
            SELECT eal.user_seq, COUNT(*) AS companion_cnt
            FROM electronic_approval_doc ead
            LEFT JOIN electronic_approval_line eal ON ead.seq = eal.approval_doc_seq
            WHERE ead.approval_doc_status = '003' AND eal.approval_status = 'Y' AND approval_date like '{$year}%'
            GROUP BY eal.user_seq) t
            LEFT JOIN user u ON t.user_seq = u.seq UNION ALL
            SELECT ead.writer_id, COUNT(*) AS companion_cnt
            FROM electronic_approval_doc ead
            WHERE ead.approval_doc_status = '003' AND write_date like '{$year}%'
            GROUP BY writer_id) t
            GROUP BY user_id
            ORDER BY companion_cnt) c ON u.user_id = c.user_id
            WHERE quit_date IS NULL {$target}";
// echo $sql;
      $query = $this->db->query($sql);

      if ($query->num_rows() <= 0) {
  			return false;
  		} else {
  			return $query->result_array();
  		}
  }

  function return_approval_list($user_seq, $user_id, $year,$searchkeyword=""){
		$searchstring='';

		if ($searchkeyword != "") {
			$searchkeyword = explode(',',$searchkeyword);
			if(trim($searchkeyword[0])!=''){ //양식명
				$searchstring .= " AND template_name LIKE '%{$searchkeyword[0]}%'";
			}
			if(trim($searchkeyword[1])!=''){ //문서제목
				$searchstring .= " AND approval_doc_name LIKE '%{$searchkeyword[1]}%'";
			}
			if(trim($searchkeyword[2])!=''){
				$searchstring .= " AND writer_name = '{$searchkeyword[2]}'";
			}
			if(trim($searchkeyword[3])!=''){//문서내용
				$searchstring .= " AND contents_html LIKE '%{$searchkeyword[3]}%'";
			}
			if(trim($searchkeyword[4])!=''){ //기안일
				$searchstring .= " AND write_date >= '{$searchkeyword[4]}'";
			}
			if(trim($searchkeyword[5])!=''){//기안일
				$searchstring .= " AND write_date <= '{$searchkeyword[5]}'";
			}
			if(trim($searchkeyword[6])!=''){ //완료일
				$searchstring .= " AND completion_date >= '{$searchkeyword[6]}'";
			}
			if(trim($searchkeyword[7])!=''){//완료일
				$searchstring .= " AND completion_date <= '{$searchkeyword[7]}'";
			}
		}

    $sql = "SELECT t.* FROM (SELECT ead.*, eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
FROM electronic_approval_doc ead
LEFT JOIN electronic_approval_line eal ON ead.seq = eal.approval_doc_seq
left JOIN electronic_approval_form eaf ON eaf.seq = ead.approval_form_seq
WHERE ead.approval_doc_status = '003' AND eal.approval_status = 'Y' AND approval_date like '{$year}%' AND eal.user_seq = {$user_seq}
UNION
SELECT ead.*, eaf.template_category, CASE WHEN ead.approval_form_seq = 'annual' THEN '연차신청서' WHEN ead.approval_form_seq = 'attendance' THEN '근태조정계' ELSE eaf.template_name END AS template_name
FROM electronic_approval_doc ead
left JOIN electronic_approval_form eaf ON eaf.seq = ead.approval_form_seq
WHERE ead.approval_doc_status = '003' AND write_date like '{$year}%' and writer_id = '{$user_id}') t WHERE 1=1 {$searchstring}
ORDER BY completion_date DESC";

		$query = $this->db->query( $sql );
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->result_array();
		}
	}
}
?>

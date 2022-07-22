<?php
header("Content-type: text/html; charset=utf-8");

class STC_diquitaca extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->lv = $this->phpsession->get( 'lv', 'stc' );
    $this->name= $this->phpsession->get( 'name', 'stc' );
    $this->pGroupName= $this->phpsession->get( 'pGroupName', 'stc' );
  }

  function qna_list($mode, $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
    $keyword = "%".$searchkeyword."%";
    $user_seq = $this->seq;

    if($searchkeyword != '') {
      if($search1 == '001') {
        $searchstring = " AND title LIKE '{$keyword}'";
      } else if($search1 == '002') {
        $searchstring = " AND user_name LIKE '{$keyword}'";
      } else if($search1 == '003') {
        $searchstring = " AND category_name LIKE '{$keyword}'";
      } else if($search1 == 'mobile') {
        $searchstring = " AND (title like '{$keyword}' || user_name LIKE '{$keyword}')";
      }
    } else {
      $searchstring = "";
    }

    if($mode == "list") {
      $sql = "SELECT dq.*, u.user_name, dqc.comment_cnt, (SELECT COUNT(*) FROM diquitaca_vote_list WHERE content_seq IN (SELECT seq from diquitaca_vote_contents WHERE vote_seq = (SELECT seq FROM diquitaca_vote WHERE qna_seq = dq.seq))) AS vote_cnt, dqr.user_seq, dc.category_name, dc.color, dc.bgColor, dc.borderColor ";
    } else if ($mode == "count") {
      $sql = "SELECT COUNT(*) as ucount ";
    }

    $sql .= "FROM diquitaca_qna dq LEFT JOIN user u ON dq.insert_id = u.user_id LEFT JOIN (SELECT qna_seq, COUNT(*) AS comment_cnt FROM diquitaca_qna_comment GROUP BY qna_seq) dqc ON dq.seq = dqc.qna_seq LEFT JOIN (SELECT user_seq, notice_seq FROM diquitaca_qna_read GROUP BY notice_seq, user_seq HAVING user_seq = {$user_seq}) AS dqr ON dq.seq = dqr.notice_seq LEFT JOIN diquitaca_category dc ON dq.category = dc.seq WHERE 1=1 {$searchstring} order by dq.seq desc";

    if($mode == "list") {
      $sql .= " LIMIT {$start_limit}, {$offset}";
    }
    $query = $this->db->query($sql);

    if($mode == 'list') {
      return $query->result_array();
    } else if($mode == 'count') {
      return $query->row();
    }
  }

  function qna_read_count($notice_seq, $user_seq) {
    $sql = "SELECT count(*) AS cnt FROM diquitaca_qna_read WHERE notice_seq = {$notice_seq} AND user_seq = {$user_seq}";
    $query = $this->db->query($sql);
    return $query->row_array();
  }

  function qna_read_insert($notice_seq, $user_seq, $data) {
    $this->db->insert('diquitaca_qna_read', $data );
  }

  function qna_insert( $data, $mode = 0, $seq = 0 ) {
    if($mode == 0) {
      $this->db->insert('diquitaca_qna', $data);
      return $this->db->insert_id();
    } else {
      $this->db->update('diquitaca_qna', $data, array('seq' => $seq));
      return $seq;
    }
  }

  function qna_delete($seq) {
    return $this->db->where('seq', $seq)->delete('diquitaca_qna');
  }

  function vote_insert($data, $mode = 0) {
    if($mode == 0) {
      $this->db->insert('diquitaca_vote', $data);
      return $this->db->insert_id();
    } else {
      $this->db->where('qna_seq', $data['qna_seq'])->delete('diquitaca_vote');
      $this->db->insert('diquitaca_vote', $data);
      return $this->db->insert_id();
    }
  }

  function delete_vote($seq) {
    return $this->db->where('qna_seq', $seq)->delete('diquitaca_vote');
  }

  function vote_content_insert($data) {
    $this->db->insert('diquitaca_vote_contents', $data);
    return $this->db->insert_id();
  }

  function qna_val($seq) {
    // $sql = "SELECT dq.*, u.user_name, dc.category_name FROM diquitaca_qna dq JOIN user u ON dq.insert_id = u.user_id LEFT JOIN diquitaca_category dc ON dq.category = dc.seq WHERE dq.seq = {$seq}";
    $sql = "SELECT dq.*, u.user_name, dc.category_name, dqr.read_cnt
            FROM diquitaca_qna dq
            JOIN user u ON dq.insert_id = u.user_id
            LEFT JOIN diquitaca_category dc ON dq.category = dc.seq
            LEFT JOIN (
              SELECT notice_seq, COUNT(user_seq) AS read_cnt
              FROM diquitaca_qna_read
              GROUP BY notice_seq ) AS dqr ON dq.seq = dqr.notice_seq
              WHERE dq.seq = {$seq}";

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function vote_val($seq) {
    $sql = "SELECT * FROM diquitaca_vote WHERE qna_seq = {$seq}";

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function vote_content($seq) {
    $sql = "SELECT * FROM diquitaca_vote_contents WHERE vote_seq = (SELECT seq FROM diquitaca_vote WHERE qna_seq = {$seq})";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function vote_list($seq) {
    $sql = "SELECT * from diquitaca_vote_list where content_seq IN (SELECT seq FROM diquitaca_vote_contents WHERE vote_seq = (SELECT seq FROM diquitaca_vote WHERE qna_seq = {$seq}))";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function my_vote_list($seq, $useq) {
    $sql = "SELECT GROUP_CONCAT(content_seq SEPARATOR ',') AS my_vote_seq
            FROM diquitaca_vote_list
            WHERE content_seq IN (
            SELECT seq
            FROM diquitaca_vote_contents
            WHERE vote_seq = (
            SELECT seq
            FROM diquitaca_vote
            WHERE qna_seq = {$seq})) AND user_seq = {$useq}";

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function qna_comment($seq) {
    $sql = "SELECT dqc.*, u.user_name FROM diquitaca_qna_comment dqc JOIN user u on dqc.user_id = u.user_id WHERE qna_seq = {$seq} order by seq";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function insert_qna_comment($data) {
    return $this->db->insert('diquitaca_qna_comment', $data);
  }

  function delete_qna_comment($seq) {
    return $this->db->where('seq', $seq)->delete('diquitaca_qna_comment');
  }

  function chk_vote_content($vseq) {
    $sql = "SELECT count(*) as cnt FROM diquitaca_vote_contents WHERE seq = {$vseq}";

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function select_vote($data) {
    return $this->db->insert('diquitaca_vote_list', $data);
  }

  function cancel_vote($vseq, $useq) {
    $sql = "DELETE FROM diquitaca_vote_list WHERE content_seq = {$vseq} AND user_seq = '{$useq}'";

    return $this->db->query($sql);
  }

  function vote_progress($seq) {
    $sql = "SELECT dvc.*, dvl.vote_cnt
            FROM diquitaca_vote_contents dvc
            LEFT JOIN (
            SELECT content_seq, COUNT(*) AS vote_cnt
            FROM diquitaca_vote_list
            GROUP BY content_seq) dvl
            ON dvc.seq = dvl.content_seq
            WHERE vote_seq = (
            SELECT seq
            FROM diquitaca_vote
            WHERE qna_seq = {$seq})";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function user_count() {
    $sql = "SELECT COUNT(*) AS cnt FROM user WHERE quit_date IS NULL";

    $query = $this->db->query($sql);

    return $query->row_array();
  }

  function voter_list($seq) {
    $sql = "SELECT dvl.*, u.user_name, u.user_duty FROM diquitaca_vote_list dvl JOIN user u ON dvl.user_seq = u.seq WHERE content_seq = {$seq} ORDER BY insert_time desc";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function qna_category() {
    $sql = "SELECT * FROM diquitaca_category ORDER BY seq";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

}
?>

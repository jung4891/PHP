<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo_m extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  // todo 목록 가져오기
  function get_list() {
    // $sql = 'SELECT * FROM items';
    // $result = $this->db->query($sql)->result();
    $result = $this->db->get('items')->result();
    return $result;
  }

  // todo 항목 한개 조회
  function get_row($id) {
    $result = $this->db->get_where('items', array('id'=>$id))->row();
    return $result;
  }

  // todo 입력
  function insert_todo($content, $created_on, $due_date) {
    $sql = "INSERT INTO items (content, created_on, due_date) VALUES
            ('{$content}', '{$created_on}', '{$due_date}')";
    $this->db->query($sql);
  }



  function get_mailID_arr($mbox) {
    $sql = " SELECT mail_id FROM test2 WHERE mbox = '$mbox' ";
    $result = $this->db->query($sql)->result_array();
    return $result;
  }

  function get_mailID_arr_search($mbox, $search_word) {
    $sql = " SELECT mail_id FROM test2 WHERE mbox = '$mbox' AND contents LIKE '%$search_word%' ";
    $result = $this->db->query($sql)->result_array();
    return $result;
  }

  function insert_mail($mbox, $mail_id, $contents) {
    $sql = " INSERT IGNORE INTO test2 (mbox, mail_id, contents) VALUES
    ('{$mbox}', '{$mail_id}', '{$contents}') ";
    $this->db->query($sql);
  }

  function delete_mail($mbox, $mail_id) {
    // $mail_id = htmlspecialchars_decode($mail_id);
    $sql = " DELETE FROM test2 where mbox = '$mbox' AND mail_id = '$mail_id' ";
    // echo $sql;
    // exit;
    $this->db->query("$sql");
  }




  // todo 수정
  function update_todo($id, $content, $created_on, $due_date) {
    $sql = "UPDATE items SET content='{$content}', created_on='{$created_on}', due_date='{$due_date}'
            WHERE id={$id}";
    $this->db->query($sql);
  }

  // todo 삭제
  function delete_todo($id) {
    $sql = "DELETE FROM items where id={$id}";
    $this->db->query($sql);
  }


}

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
  function get_row($id)   {
    $result = $this->db->get_where('items', array('id'=>$id))->row();
    return $result;
  }



}

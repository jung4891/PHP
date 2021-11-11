<?php

  // 연습용 1 (post로 받은값 그대로 보내기)
  // echo $_POST['name'];

  // 연습용 1_1 (받은 값 체크해서 보내기)
  // $name = $_POST['name'];
  // if ($name == 'song') echo true; else echo false;

  // 연습용 2 (post로 받은값 배열에 넣어 보내기)
  // json으로 보내야함. 그냥 arr을 print_r로 출력한걸 보내면 그냥 싹다 문자열처리되서 감
  $arr = array();
  $arr["name"] = $_POST['name'];
  $arr[1] = $_POST['age'];
  $arr['res'] = ($arr['name']=='song')? true : false;

  $arr["city"] = $_POST['city'];
  $arr["music"] = $_POST['music'];
  $json_str = json_encode($arr);
  echo $json_str;


  // echo json_encode($_POST);  // array -> json 문자열
  // echo json_encode(array('test' => '123'));
 ?>

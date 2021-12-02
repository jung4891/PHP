<?php
  include "./connectDB.php";

  // myMemberID 가져오기
  $user_id = $_POST['user_id'];
  echo $user_id.'<br>';
  $query = "select myMemberID from mymember where userid = '{$user_id}'";
  $my_member_id = $mysqli->query($query)->fetch_array(MYSQLI_NUM)[0];

  // prodReview테이블에 textarea데이터 입력
  $text = addslashes($_POST['textarea']);   // 따옴표 앞에 \추가되어 문자열로 인식함
  $query = "insert into prodreview(myMemberID, content, regtime) values
            ({$my_member_id},'{$text}',NOW())";
  $res = $mysqli->query($query);
  // echo $query.'<br>';
  if ($res) {
    echo "[textarea insert 성공] <br>";
  } else {
    echo "[textarea insert 실패] <br>";
    echo mysqli_error($mysqli);
  }
  echo '<br>';

  // 방금 입력한 데이터 출력
  $query = "select * from prodreview ORDER BY prodReviewID DESC LIMIT 1"; // 마지막 입력된 내용
  $res = $mysqli->query($query);
  $review = $res->fetch_array(MYSQLI_ASSOC);
  echo '<방금 입력한 내용> <br>';
  echo nl2br($review['content']).'<br>';    // 엔터 친곳에 \n이 있는데 이를 <br>태그로 변경

  // 방금 입력한 데이터를 파일로 저장
 ?>

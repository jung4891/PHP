<?php
$conn = mysqli_connect(
    '192.168.0.100',
    'durianit',
    'durian0529',
    'KIC_USER');
	  
    $conn->query("SET NAMES 'UTF8'");

    $sql ="select USERID from USERS;";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)){
        $sql2 = "select max(log_time) from LOG where USERID = '{$row['USERID']}'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $today = date("Y-m-d"); //오늘
		$lastday = date("Y-m-d",strtotime("$row2[0] +90 days")); //90일후 사용 중지
        $alertday = date("Y-m-d",strtotime("$row2[0] +85 days")); //85일부터 비밀번호 변경 경고
        if(strtotime($today) >= strtotime($alertday)){
			if(strtotime($today) >= strtotime($lastday)){
				$sql3 = "update USERS set status ='stop' where USERID = '{$row['USERID']}'"; //사용자 비밀번호 변경 90일 넘었을때 사용 중지
                $result3 = mysqli_query($conn, $sql3);
                

                ///문자 발송 코드 입력

			}else{
                ///문자 발송 코드 입력
			}
		}
    }

?>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/session.php';
header('Content-Type: text/html; charset=UTF-8');
$SHA_PASSWD = base64_encode(hash('sha512', $_POST['USERNEWPW'], true));
$change = iconv('utf8', 'euckr', '수정');
$pw_change = iconv('utf8', 'euckr', '비밀번호 변경');
$sessionID = iconv('utf8', 'euckr', $_SESSION['USERID']);
$sessionName = iconv('utf8', 'euckr', $_SESSION['USERNAME']);
$use = iconv('utf8', 'euckr', 'use');
$stop =iconv('utf8', 'euckr', 'stop');

$conn = mysqli_connect(
    '192.168.0.100',
    'durianit',
    'durian0529',
    'KIC_USER');

$conn->query("SET NAMES 'euckr'");

$pw_check_sql = "select * from dictionary where '{$_POST['USERNEWPW']}' like concat('%',word,'%')"; 
$pw_check_result = mysqli_query($conn, $pw_check_sql);
$pwRow = mysqli_fetch_array($pw_check_result);

if(count($pwRow) >= 1){
    echo "<script>alert('일반 사전에 등록 되어있는 단어는 비밀번호로 사용 하실 수 없습니다.');history.go(-1);</script>";
}else{
    if(isset($_SESSION['USERID'])){
        $data = array(
            $USERID=iconv('utf8', 'euckr', $_POST['USERID']),
            $PASSWD=iconv('utf8', 'euckr', $SHA_PASSWD)
        );

        if($_SESSION['USERLEVEL'] != 1){
            $CURRENTPW = base64_encode(hash('sha512', $_POST['CURRENTPW'], true));
            if($CURRENTPW == $_SESSION['USERPW']){
                if($CURRENTPW == $SHA_PASSWD){
                    echo "<script>alert('사용된 비밀번호는 재사용 할 수 없습니다.');history.go(-1);</script>";
                }else{
                    $sql = "update USERS set PASSWD='{$PASSWD}',status ='{$use}' where USERID = '{$_SESSION['USERID']}'";
                }
            }else{
                echo "<script>alert('현재 비밀번호가 틀렸습니다.');history.go(-1);</script>";
            }
        }else{
            $sql = "update USERS set PASSWD='{$PASSWD}',status ='{$use}' where USERID = '{$USERID}'";
        }

        $result=mysqli_query($conn, $sql);



        if($result){
            if($_SESSION['USERLEVEL'] != 1){
                $sql2 ="insert into LOG (USERID,USERNAME,WORKERNAME,STATUS,work_contents) values ('{$sessionID}','{$sessionName}','{$sessionName}','{$change}','{$pw_change}')";
            }else{
                $sql2 ="insert into LOG (USERID,USERNAME,WORKERNAME,STATUS,work_contents) values ('{$USERID}',(select USERNAME from USERS where USERID = '{$USERID}'),'{$sessionName}','{$change}','{$pw_change}')";
            }
            $result2 = mysqli_query($conn, $sql2);
            if($result2){
                echo "<script>alert('비밀번호가 변경되었습니다.');location.href='{$_SERVER['DOCUMENT-ROOT']}home.php';</script>";
            }else{
                echo "로그 에러";
            }
        }else{
            echo "<script>alert('비밀번호 변경 실패');history.go(-1);</script>";
        }
    }else{
        $data = array(
            $USERID=iconv('utf8', 'euckr', $_POST['USERID']),
            $PASSWD=iconv('utf8', 'euckr', $SHA_PASSWD),
            $USERNAME =iconv('utf8', 'euckr', $_POST['USERNAME']),
        );
        $CURRENTPW = base64_encode(hash('sha512', $_POST['CURRENTPW'], true));
        $sql = "select PASSWD from USERS where USERID='{$USERID}' and USERNAME='{$USERNAME}'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        
        if($row == ''){
            echo "<script>alert('사용자 아이디 또는 사용자 이름의 입력정보가 틀렸습니다.');history.go(-1);</script>";
        }else{
            if($row[0] == $CURRENTPW){
                if($CURRENTPW == $SHA_PASSWD){
                    echo "<script>alert('사용된 비밀번호는 재사용 할 수 없습니다.');history.go(-1);</script>";
                }else{
                    $sql2 = "update USERS set PASSWD='{$PASSWD}',status ='{$use}'  where USERID = '{$USERID}' and USERNAME='{$USERNAME}'";
                    $result2 = mysqli_query($conn, $sql2);

                    if($result2){
                        $sql3 ="insert into LOG (USERID,USERNAME,WORKERNAME,STATUS,work_contents) values ('{$USERID}','{$USERNAME}','{$USERNAME}','{$change}','{$pw_change}')";
                        $result3 = mysqli_query($conn, $sql3);
                        if($result3){
                            echo "<script>alert('비밀번호가 변경되었습니다.');location.href='{$_SERVER['DOCUMENT-ROOT']}/index.php';</script>";
                        }else{
                            echo "로그 에러";
                        }
                    }else{
                        echo "<script>alert('비밀번호 변경 실패');history.go(-1);</script>";
                    }
                }
            }else{
                echo "<script>alert('현재 비밀번호가 틀렸습니다.');history.go(-1);</script>";
            }
        }
    }

    $conn->close();


}

?>
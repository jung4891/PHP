<?php
include $_SERVER['DOCUMENT_ROOT'].'/session.php';
$SHA_PASSWD = base64_encode(hash('sha512', $_POST['PASSWD'], true));
header('Content-Type: text/html; charset=UTF-8');

$data = array(
$USERID=$_POST['USERID'],
$PASSWD=$SHA_PASSWD,
);

$conn = mysqli_connect(
    '192.168.0.100',
    'durianit',
    'durian0529',
    'KIC_USER');

$conn->query("SET NAMES 'UTF8'");
  
$sql = "select * from USERS where USERID = '{$USERID}' and PASSWD='{$PASSWD}'";

$result=mysqli_query($conn, $sql);

$conn->close();


if($result){
    if($result->num_rows == 0){
        echo "<script>alert('로그인에 실패하였습니다');history.go(-1);</script>";
    }else{
        $memberInfo = $result ->fetch_array(MYSQLI_ASSOC);
        if($memberInfo['status']=='use'){
            $_SESSION['USERID'] = $memberInfo['USERID'];
            $_SESSION['USERNAME'] = $memberInfo['USERNAME'];
            $_SESSION['USERLEVEL'] = $memberInfo['USERLEVEL'];
            $_SESSION['USERPW'] = $memberInfo['PASSWD'];
            echo "<script>alert('로그인 성공');location.href='{$_SERVER['DOCUMENT-ROOT']}home.php';</script>";            
        }else{
            echo "<script>alert('비밀번호 변경기간이 만료 되었습니다. 비밀번호를 변경해주세요.');location.href='{$_SERVER['DOCUMENT-ROOT']}/index.php';</script>"; 
        }

    }
}

?>

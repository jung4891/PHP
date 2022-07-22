<?php 
include $_SERVER['DOCUMENT_ROOT'].'/session.php';
include $_SERVER['DOCUMENT_ROOT'].'/checkSignSession.php';
if($_SESSION['USERLEVEL'] < 1){
    Header("Location:./home.php");
    exit;
}
header('Content-Type: text/html; charset=UTF-8');

$conn = mysqli_connect(
    '192.168.0.100',
    'durianit',
    'durian0529',
    'KIC_USER');
  
  $conn->query("SET NAMES 'UTF8'");
  $sql = "select * from LOG order by seq desc";
  $result = mysqli_query($conn, $sql);
  $idx = 0;
?>

<html>

<head>
    <!---뷰포트---->

    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />

    <!----폰트----->
    <link rel="stylesheet" type="text/css" href=".css" />
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        td {
            border: 0.01em #000 solid;
        }

        #font1 {

            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: normal;
            font-size: 0.7em;
            font-size: auto;
            line-height: auto;
            color: rgba(0, 0, 0, 0.8);
            text-decoration: none;
            cursor: pointer;


        }

        #btnblack {
            background-color: white;
            color: black;
            border: 1.5px solid gray;
            border-radius: 0.4em;

            position: relative;
            height: 2.2em;
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.7em;
            line-height: 0.02em;
            text-decoration: none;
            color: gray;
            cursor: pointer;
        }

        input {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.5em;
            color: gray;
            line-height: 0.5em;
            text-decoration: none;
            color: gray;
            cursor: pointer;
            width: 100%;
            padding: 0.5em 1em;
            box-sizing: border-box;
            border: solid 2px gray;
            border-radius: 0.5em;
        }

    </style>
</head>

<table id="font1" style="text-align:center;" width="500">
    <tr style="background-color:#e0e0e0;">
        <td width=5%>
            No.
        </td>
        <td width=5em>
            로그 검출 시간
        </td>
        <td width=5em>
            ID
        </td>
        <td width=5em>
            이름
        </td>
        <td width=5em>
            상태
        </td>
        <td width=5em>
            작업내용
        </td>
    </tr>
    <?php  while ($row = mysqli_fetch_array($result)){
        $idx++;    
?>
    <tr>
        <td>
            <?php echo  $idx ;?>
        </td>
        <td>
            <?php echo  $row['log_time'] ;?>
        </td>
        <td>
            <?php echo  $row['USERID'] ;?>
        </td>
        <td>
            <?php echo  $row['USERNAME'] ;?>
        </td>
        <td>
            <?php echo  $row['STATUS'] ;?>
        </td>
        <td>
            <?php echo  $row['work_contents'] ;?>
        </td>
    </tr>
    <?php } ?>
</table>

<input id="btnblack" type="button" value="뒤로가기" onclick="back();" style="margin-top:100px;">
</input>
<script>
    function back() {
        history.go(-1);
    }

</script>

</html>

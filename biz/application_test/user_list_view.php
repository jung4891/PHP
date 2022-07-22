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
  $sql = "select * from USERS order by seq desc";
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
            border: 1px #000 solid;
        }


        #font1 {

            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: normal;
            font-size: 0.7em;
            line-height: auto;
            color: rgba(0, 0, 0, 0.8);
            text-decoration: none;
            cursor: pointer;
            overflow-x: auto;


        }

        #btnblack {
            background-color: white;
            color: black;
            border: 1.5px solid #000000;
            border-radius: 0.4em;
            opacity: 20%;

            position: relative;
            height: 2.2em;
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.02em;
            text-decoration: none;
            color: rgba(0, 0, 0, 0.8);
            cursor: pointer;
        }

        input {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.7em;
            color: dimgray;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
            width: 100%;
            padding: 0.5em 1em;
            box-sizing: border-box;
            border: solid 2px dimgray;
            border-radius: 0.5em;
        }

    </style>
</head>
<table id="font1" style="text-align:center;" width="1000">
    <tr style="background-color:e0e0e0">
        <td>
            No.
        </td>
        <td>
            사용자ID
        </td>
        <td>
            사용자이름
        </td>
        <td>
            보안동의
        </td>
        <td>
            가입시간
        </td>
        <td>
            사용자권한
        </td>
        <td>
            MAC 주소
        </td>
        <td>
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
            <?php echo  $row['USERID'] ;?>
        </td>
        <td>
            <?php echo  $row['USERNAME'] ;?>
        </td>
        <td>
            <?php if($row['AGREE_CHECK'] == 1){?>
            동의
            <?php }else{ ?>
            비동의
            <?php } ?>

        </td>
        <td>
            <?php echo  $row['MODTIME'] ;?>
        </td>
        <td>
            <?php if($row['USERLEVEL'] == 1){?>
            관리자
            <?php }else{ ?>
            일반
            <?php } ?>
        </td>
        <td>
            <?php echo  $row['MAC_ADDR'] ;?>
        </td>
        <td>
            <input type='button' value="mac주소 수정" onclick="macChange(<?php echo  $row['SEQ'] ;?>);" />
        </td>
    </tr>
    <?php } ?>
</table>
<input id="btnblack" type="button" value="뒤로가기" onclick="back();" style="margin-top:10em;"></input>
<script>
    function back() {
        history.go(-1);
    }

    function macChange(seq) {
        window.open("<?php echo $_SERVER['DOCUMENT-ROOT']; ?>mac_addr_change.php?seq=" + seq, "_blank", "width=1500,height=300");
    }

</script>

</html>

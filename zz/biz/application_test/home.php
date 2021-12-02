<?php
    include $_SERVER['DOCUMENT_ROOT'].'/session.php';
    include $_SERVER['DOCUMENT_ROOT'].'/checkSignSession.php';
	header('Content-Type: text/html; charset=UTF-8');
	
	$conn = mysqli_connect(
		'192.168.0.100',
		'durianit',
		'durian0529',
        'KIC_USER');
	  
	$conn->query("SET NAMES euckr");

	$USERID = iconv('utf8', 'euckr', $_SESSION['USERID']);
	if($_SESSION['USERLEVEL'] != 1){ //관리자 제외
		$sql = "select max(log_time) from LOG where USERID = '{$USERID}'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);
		$today = date("Y-m-d"); //오늘
		$lastday = date("Y-m-d",strtotime("$row[0] +90 days")); //90일후 사용 중지
		$alertday = date("Y-m-d",strtotime("$row[0] +85 days")); //85일부터 비밀번호 변경 경고
		if(strtotime($today) >= strtotime($alertday)){
			if(strtotime($today) >= strtotime($lastday)){
				$sql = "update USERS set status ='stop' where USERID = '{$USERID}'";
				$result = mysqli_query($conn, $sql);
				echo '<script>alert("비밀번호 변경 기간이 만료되어 이용하실 수 없습니다. 비밀번호를 변경해주세요.")</script>';
			}else{
				echo '<script>alert("'.$lastday.'까지 비밀번호를 변경해 주세요.")</script>';
			}
		}
	}
?>
<html>

<head>
    <!---뷰포트---->

    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />

    <!----폰트----->
    <link rel="stylesheet" type="text/css" href=".css" />
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        #font1 {
            position: relative;
            left: 0.1%;
            top: 11%;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.5em;
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;

        }

        #font2 {
            position: relative;
            top: 11%;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
        }

        #box1 {

            position: absolute;
            width: 76%;
            height: 4.5%;
            left: 13%;
            top: 47%;
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
            text-decoration: none;

        }

        #box2 {

            position: absolute;
            width: 76%;
            height: 4.5%;
            left: 13%;
            top: 40%;
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
            text-decoration: none;

        }

        #box3 {

            position: absolute;
            width: 35%;
            height: 4.5%;
            left: 7%;
            top: 57%;
            text-align: center;
            text-decoration: none;

        }

        #box4 {

            position: absolute;
            width: 35%;
            height: 4.5%;
            left: 63%;
            top: 57%;
            text-align: center;
            text-decoration: none;

        }

        #img {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url("logo.png");
            background-repeat: no-repeat;
            background-position: 50% 5%;
        }

    </style>
</head>

<form action='user_process.php' method='post'>

    <body>
        <div id="img">
        </div>

        <div>
            <a id="box3" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>pw_change.php">
                <p id="font2">비밀번호 변경</p>
            </a>
        </div>
        <?php if($_SESSION['USERLEVEL'] == 1) {?>

        <div>
            <a id="box1" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>user_list_view.php">
                <P id="font1">사용자 리스트 보기</P>
            </a>
        </div>

        <div>
            <a id="box2" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>log_view.php">
                <p id="font1">로그 보기</p>
            </a>
        </div>

        <?php } ?>

        <div>
            <a id="box4" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>logout.php">
                <p id="font2">로그아웃</p>
            </a>
        </div>
    </body>
</form>
<script>
</script>

</html>

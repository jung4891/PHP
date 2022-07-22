<?php
	header('Content-Type: text/html; charset=UTF-8');
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
            top: 10%;

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
            width: 30%;
            height: 4.5%;
            left: 62%;
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
            <a href="index.php"></a>
        </div>

        <div>
            <div>
                <a id="box2" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>sign_in.php">
                    <p id="font1">로그인</p>
                </a>
            </div>
        </div>
        <div>
            <div>
                <a id="box1" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>sign_up.php">
                    <p id="font1">등록</p>
                </a>
            </div>
        </div>
        <div>
            <div>
                <a id="box3" href="<?php echo $_SERVER['DOCUMENT-ROOT'];?>pw_change.php">
                    <p id="font2">비밀번호 변경</p>
                </a>
            </div>
        </div>
    </body>
</form>

</html>

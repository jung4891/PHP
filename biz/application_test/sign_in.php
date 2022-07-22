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
    <!---스타일---->
    <style>
        input[type=text]:focus {
            border: 0.2em solid #555;
            padding: 12px 20px 12px 40px;
        }

        #box2 {

            position: absolute;
            width: 76%;
            height: 4.5%;
            left: 13%;
            top: 40%;
            background: #ffffff;
            text-align: center;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 1.5em;
            color: rgba 0, 0, 0, 0.8;
            text-decoration: none;
            cursor: pointer;

        }

        #box1 {

            position: absolute;
            width: 76%;
            height: 4.5%;
            left: 13%;
            top: 47%;
            background: #ffffff;
            text-align: center;


            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 1.5em;
            color: rgba 0, 0, 0, 0.8;
            text-decoration: none;
            cursor: pointer;
        }

        #box3 {

            position: absolute;
            width: 76%;
            height: 4.5%;
            left: 13%;
            top: 58%;
            border: none;
            background: #6c898c;
            text-align: center;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 1.5em;
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;

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
<form action='user_login.php' method='post'>


    <body>

        <div id="img">
            <a href="index.php"></a>
        </div>

        <div>
            <div>
                <input id="box2" type='text' id='USERID' name='USERID' placeholder="사용자 ID">
            </div>
        </div>

        <div>
            <div>
                <input id="box1" type='password' id='PASSWD' name='PASSWD' placeholder="비밀번호">
            </div>
        </div>
        <div>
            <div>
                <button id="box3">로그인</button>
            </div>
        </div>
    </body>
</form>

</html>

<?php
    include $_SERVER['DOCUMENT_ROOT'].'/session.php';
    header('Content-Type: text/html; charset=UTF-8');

if(isset($_SESSION['USERID'])){
?>
<html>

<head>
    <!---뷰포트---->

    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />


    <!----폰트----->
    <link rel="stylesheet" type="text/css" href=".css" />
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!----스타일시트----->
    <style>
        #font1 {
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
            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box1_1 {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box2 {
            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 1.5em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box2_1 {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 1.5em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box3 {
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: auto;
            text-decoration: none;
            color: #000000;
            cursor: pointer;

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 1.5em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }


        input {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.7em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
            width: 100%;
            padding: 1em 2em;
            margin: 1.2em 0 2.5em 0;
            box-sizing: border-box;

            border: solid 2px gray;
            border-radius: 0.8em;
        }

        #btnblack {
            background-color: white;
            color: black;
            border: 1.5px solid rgba(0, 0, 0, 0.8);
            border-radius: 0.4em;

            position: relative;
            height: 2.2em;
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.02em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
        }

    </style>
</head>

<form name="cform" action='user_pw_change.php' method='post' onSubmit='javascript:chkForm();return false;'>

    <body>
        <div id="box1_1">
            <h2>비밀번호 변경</h2>
        </div>
        <?php if($_SESSION['USERLEVEL'] == 1){ ?>
        <div>
            <div id="font1">
                사용자 아이디
            </div>
            <div id="font1">
                <input type='text' id='USERID' name='USERID'>
            </div>
        </div>

        <?php }else{ ?>

        <div>
            <div id="font1">
                현재 비밀번호
            </div>

            <div id="font1">
                <input type='hidden' id='USERID' name='USERID' value='<?php echo $_SESSION['USERID'] ?>'>
                <input type='password' id='CURRENTPW' name='CURRENTPW'>
            </div>
        </div>

        <?php } ?>

        <div>
            <div id="font1">
                변경 비밀번호
            </div>

            <div id="font1">
                <input type='password' id='USERNEWPW' name='USERNEWPW' onkeyup="pwCheck();">
            </div>

        </div>

        <div>
            <div id="font1">
                변경 비밀번호 확인
            </div>

            <div id="font1">
                <input type='password' id='USERPW_Check' name='USERPW_Check' onkeyup="pwCheck();">
                <input type='text' id='USERPW_CONFIRM' value="변경 비밀번호가 일치하지 않습니다." style="color:red;width:500px;border:none">
            </div>

        </div>

        <div>
            <div>
                <button id="btnblack">비밀번호 변경</button>
            </div>
        </div>
        <div id="box2_1">
            <h2>무선랜 보안서약서</h2>
        </div>
        <div>
            <div id="box3">
                <div style="font-weight:bold;">■ 보안서약 및 주의사항</div>
                <div style="margin-left:0.5em;"><br>본인은 한국형사정책연구원의 무선랜 시스템(이하 “무선랜”)을 사용하면서 다음의 내용을 준수할 것을 약속하고 동의 의사를 제출합니다.<br>
                    - 신청 후 <span style="color:blue;font-weight:bold;">90일마다 비밀번호 변경</span>, 비밀번호 변경 시 <span style="color:blue;font-weight:bold;">사용신청서 재작성</span>하겠습니다.<br>
                    - 무선랜 사용에 관한 무선장비 관리지침(암호변경 주기, 사용 절차) 등을 준수합니다.<br>
                    - 무선랜 단말의 불필요한 네트워크 인터페이스 (유선, Zigbee, 블루투스, USB, NFC 등)를 비활성화하겠습니다.<br>
                    - 비인가자(외부인 등)에게 무선랜 관련 사항(SSID, 계정, 패스워드 등)을 유출하지 않겠습니다.<br>
                    - 무선랜 관련 유·무형 자산에 대한 분실·탈취·훼손·도난 등을 하지 않으며, 기술적·관리적·물리적 보안대책을 준수하겠습니다.<br>
                    - 그 밖에 한국형사정책연구원의 무선랜 운용에 관한 기밀성·무결성·가용성을 저해하는 행위를 하지 않겠습니다.
                </div>
                <div style="margin-left:0.5em;margin-top:2em;"> 상기 사항을 숙지하고 이를 성실히 준수할 것이며 본 서약서의 내용을 위반하였을 경우,<br>
                    연구원 보안업무규정 등 관련 규정에 따른 징계 조치 등 어떠한 불이익도 감수할 것이며<br>
                    연구원에 끼친 손해에 대해 지체없이 변상, 복구할 것을 서약합니다.<br>
                </div>
                <div style="margin-left:0.5em;margin-top:2em;">위 보안 서약에 <span style="color:red;font-weight:bold;">동의 하지 않는 경우 무선랜(와이파이) 사용이 불가</span>합니다.</div>
                <div style="margin-left:0.5em;margin-top:2em;">위 무선랜 사용 신청 및 보안 서약에 관한 내용과 책임에 동의하십니까?</div>
                <div style="margin-top:2em;">동의함</div><input type='checkbox' id='AGREE_CHECK' name='AGREE_CHECK'>
            </div>
        </div>
    </body>
</form>

</html>

<?php }else{?>

<html>

<head>
    <!---뷰포트---->

    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />


    <!----폰트----->
    <link rel="stylesheet" type="text/css" href=".css" />
    <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!----스타일시트----->
    <style>
        #font1 {
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
            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box1_1 {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box2 {
            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 1.5em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box2_1 {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 1.5em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box3 {
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 2em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 1.5em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }


        input {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.7em;
            line-height: 0.5em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
            width: 100%;
            padding: 1em 2em;
            margin: 1.2em 0 2.5em 0;
            box-sizing: border-box;

            border: solid 2px gray;
            border-radius: 0.8em;
        }

        #btnblack {
            background-color: white;
            color: black;
            border: 1.5px solid rgba(0, 0, 0, 0.8);
            border-radius: 0.4em;

            position: relative;
            height: 2.2em;
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.8em;
            line-height: 0.02em;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
        }

    </style>
</head>

<form name="cform" action='user_pw_change.php' method='post' onSubmit='javascript:chkForm();return false;'>

    <body>
        <div id="box1_1">
            <h2>
                비밀번호 변경
            </h2>
        </div>
        <div>
            <div id="font1">
                사용자 아이디
            </div>
            <div id="font1">
                <input type='text' id='USERID' name='USERID'>
            </div>
        </div>
        <div>
            <div id="font1">
                사용자 이름
            </div>
            <div id="font1">
                <input type='text' id='USERNAME' name='USERNAME'>
            </div>
        </div>
        <div>
            <div id="font1">
                현재 비밀번호
            </div>
            <div id="font1">
                <input type='password' id='CURRENTPW' name='CURRENTPW'>
            </div>
        </div>
        <div>
            <div id="font1">
                변경 비밀번호
            </div>
            <div id="font1">
                <input type='password' id='USERNEWPW' name='USERNEWPW' onkeyup="pwCheck();" onclick="pwGuide();">
                <input type='text' value="비밀번호는 9자리 이상, 특수문자를 포함하여야 합니다." style="color:red;width:500px;border:none">
            </div>
        </div>
        <div>
            <div id="font1">
                변경 비밀번호 확인
            </div>
            <div id="font1">
                <input type='password' id='USERPW_Check' name='USERPW_Check' onkeyup="pwCheck();">
                <input type='text' id='USERPW_CONFIRM' value="변경 비밀번호가 일치하지 않습니다." style="color:red;width:500px;border:none">
            </div>
        </div>
        <div>
            <div id="box3">
                * 비밀번호 사용 규칙* <br>
                1. 사용자 계정(아이디)과 동일 하지 않은것 <br>
                2. 개인 신상 및 부서 명칭 등과 관계가 없는 것<br>
                3. 일반 사전에 등록된 단어의 사용을 피할 것<br>
                4. 동일한 단어 또는 숫자를 반복하여 사용하지 말것<br>
                5. 사용된 비밀번호는 재사용하지 말것<br>
            </div>
        </div>
        <div id="box2_1">
            <div colspan=2>
                <h2>무선랜 보안서약서</h2>
            </div>
        </div>
        <div>
            <div id="box3">
                <div style="font-weight:bold;">■ 보안서약 및 주의사항</div>
                <div style="margin-left:0.5em;"><br>본인은 한국형사정책연구원의 무선랜 시스템(이하 “무선랜”)을 사용하면서 다음의 내용을 준수할 것을 약속하고 동의 의사를 제출합니다.<br>
                    - 신청 후 <span style="color:blue;font-weight:bold;">90일마다 비밀번호 변경</span>, 비밀번호 변경 시 <span style="color:blue;font-weight:bold;">사용신청서 재작성</span>하겠습니다.<br>
                    - 무선랜 사용에 관한 무선장비 관리지침(암호변경 주기, 사용 절차) 등을 준수합니다.<br>
                    - 무선랜 단말의 불필요한 네트워크 인터페이스 (유선, Zigbee, 블루투스, USB, NFC 등)를 비활성화하겠습니다.<br>
                    - 비인가자(외부인 등)에게 무선랜 관련 사항(SSID, 계정, 패스워드 등)을 유출하지 않겠습니다.<br>
                    - 무선랜 관련 유·무형 자산에 대한 분실·탈취·훼손·도난 등을 하지 않으며, 기술적·관리적·물리적 보안대책을 준수하겠습니다.<br>
                    - 그 밖에 한국형사정책연구원의 무선랜 운용에 관한 기밀성·무결성·가용성을 저해하는 행위를 하지 않겠습니다.
                </div>
                <div style="margin-left:0.5em;margin-top:2em;"> 상기 사항을 숙지하고 이를 성실히 준수할 것이며 본 서약서의 내용을 위반하였을 경우,<br>
                    연구원 보안업무규정 등 관련 규정에 따른 징계 조치 등 어떠한 불이익도 감수할 것이며<br>
                    연구원에 끼친 손해에 대해 지체없이 변상, 복구할 것을 서약합니다.<br>
                </div>
                <div style="margin-left:0.5em;margin-top:2em;">위 보안 서약에 <span style="color:red;font-weight:bold;">동의 하지 않는 경우 무선랜(와이파이) 사용이 불가</span>합니다.</div>
                <div style="margin-left:0.5em;margin-top:2em;">위 무선랜 사용 신청 및 보안 서약에 관한 내용과 책임에 동의하십니까?</div>

                <div style="margin-top:2em;">동의함</div><input type='checkbox' id='AGREE_CHECK' name='AGREE_CHECK'>
            </div>
        </div>
        <div>
            <div>
                <button id="btnblack">비밀번호 변경</button>
            </div>
        </div>
    </body>
</form>
<?php } ?>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    function pwCheck() {
        if ($("#USERNEWPW").val() != $("#USERPW_Check").val()) {
            $("#USERPW_CONFIRM").val("변경 비밀번호가 일치하지 않습니다.")
            $("#USERPW_CONFIRM").css("color", "red");
        } else {
            $("#USERPW_CONFIRM").val("변경 비밀번호 일치.")
            $("#USERPW_CONFIRM").css("color", "green");
        }
    }

    function chkForm() {
        if ($("#USERNEWPW").val() == $("#USERPW_Check").val()) {
            if (checkPasswordPattern($("#USERNEWPW").val()) == false) {
                return false
            } else {
                if ($("#PASSWD").val() == $("#USERID").val()) {
                    alert("사용자 계정(아이디)와 비밀번호는 동일할 수 없습니다.")
                    return false;
                } else {
                    if ($("input:checkbox[name=AGREE_CHECK]").is(":checked") == false) {
                        alert("무선랜 보안서약서에 동의하지 않으면 비밀번호를 변경하실 수 없습니다.")
                        return false;
                    } else {
                        document.cform.submit();
                    }
                }
            }
        } else {
            alert("변경 비밀번호가 서로 일치하지 않습니다.")
            return false;
        }
    }

    // 비밀번호 패턴 체크 (8자 이상, 문자, 숫자, 특수문자 포함여부 체크) 
    function checkPasswordPattern(str) {
        for (i = 0; i < str.length; i++) {
            if (str.substring(i, i + 1) == str.substring(i + 1, i + 2)) {
                if (str.substring(i, i + 1) == str.substring(i + 2, i + 3)) {
                    alert('동일한 단어는 3번 이상 반복할 수 없습니다.');
                    return false;
                }
            }
        }
        var korean = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/; //한글
        var pattern1 = /[~!@#$%^&*()_+|<>?:{}]/; // 특수문자 
        if (!pattern1.test(str) || str.length < 9 || korean.test(str) == true || str.indexOf($("#USERNAME").val()) != -1) {
            alert("비밀번호는 한글 제외, 성명 포함 제외, 9자리 이상, 특수문자를 포함하여야 합니다.");
            return false;
        } else {
            return true;
        }
    }

</script>

</html>

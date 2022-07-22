<?php
	header('Content-Type: text/html; charset=UTF-8');
	$today = date("Y년m월d일");
	$lastday = date("Y년m월d일",strtotime(strtotime($today).'+90 days'));
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
            line-height: auto;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
        }

        #font2 {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: normal;
            font-size: 0.8em;
            line-height: auto;
            text-decoration: none;
            color: #000000;
            cursor: pointer;
        }

        #box1 {
            border-style: solid;
            border-width: 0.2em;
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
            border-width: 0.5em 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 0;
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
            margin-bottom: 1em;
            margin-top: 1em;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box4 {
            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 0;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2);


        }

        #box4-1 {

            border-style: solid;
            border-width: 0 0.5em 0 0.5em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 0;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;

        }

        #box4-2 {

            border-style: solid;
            border-width: 0.2em;
            padding: 0.5em;
            margin-bottom: 1.5em;
            margin-top: 0;
            word-break: break-all;
            text-align: center;

            border-color: LightGray;
            background-color: rgba(211, 211, 211, 0.2)
        }

        input {
            position: relative;

            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 0.6em;
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
            color: gray;
            border: 1.5px solid dimgray;
            border-radius: 0.4em;
            padding-top: 0.5em;

            position: relative;
            width: 5em;
            height: 2.2em;
            font-family: Gothic A1;
            font-style: normal;
            font-weight: bold;
            font-size: 1em;
            line-height: 0;
            text-decoration: none;
            color: dimgray;
            cursor: pointer;
        }

    </style>
</head>

<form name="cform" action='user_process.php' method='post' onSubmit='javascript:chkForm();return false;'>

    <body>
        <div>
            <div id="font1">
                <div>
                    <h1 id="box1">무선랜 사용 신청서</h1>
                </div>
            </div>
        </div>
        <div id="box4-2">
            <div id="font1" style="margin-bottom:1em;">
                <h3>
                    『국가정보보안 기본지침』 제43조 및 『무선랜 구축 및 RFID 보안 가이드라인』에 근거하여 다음과 같이 무선랜 신청 및 사용에 관한 내용을 안내하오니, 잘 읽고 검토하시어 신청서를 작성해 주시기 바랍니다.
                </h3>
                <div>
                    1. 신청목적
                </div>
            </div>

            <div id="font2">
                <div style="margin-bottom:1em;">
                    한국형사정책연구원 직원복지용 무선랜 사용을 위한 사용자 식별 및 본인인증
                </div>
            </div>

            <div id="font1">
                <div style="margin-bottom:1em;">
                    2. 신청항목
                </div>
            </div>

            <div>
                <div id="font2">
                    단말기
                    <input type="radio" value="스마트폰" checked="checked" disable>스마트폰
                </div>
            </div>
            <div></div>
        </div>

        <div id="font1">
            <div id="box1">
                <h3>MAC 주소 확인법</h3>
            </div>
            <div>
                <input type='button' value="안드로이드" onclick="android();" />
                <input type='button' value="아이폰" onclick="iPhone();">

                <input type='text' value="MAC 주소는 소문자로 입력하세요." style="color:red;width:500px;border:none">
            </div>
        </div>

        <div>
            <div id="box1">
                <h3>MAC 주소</h3>
            </div>
            <div>
                <input type='text' class="mac" id='MAC1' name='MAC1' onkeyup="MACPattern(this.id)">
                <input type='text' class="mac" id='MAC2' name='MAC2' onkeyup="MACPattern(this.id)">
                <input type='text' class="mac" id='MAC3' name='MAC3' onkeyup="MACPattern(this.id)">
                <input type='text' class="mac" id='MAC4' name='MAC4' onkeyup="MACPattern(this.id)">
                <input type='text' class="mac" id='MAC5' name='MAC5' onkeyup="MACPattern(this.id)">
                <input type='text' class="mac" id='MAC6' name='MAC6' onkeyup="MACPattern(this.id)">
            </div>
        </div>

        <div id="font1">
            <div id="box1">
                성 명
            </div>

            <div>
                <input type='text' id='USERNAME' name='USERNAME'>
            </div>
        </div>

        <div id="font1">
            <div id="box1">
                아이디
            </div>
            <div>
                <input type='text' id='USERID' name='USERID'>
            </div>
        </div>

        <div id="font1">
            <div id="box1">
                비밀번호
            </div>
            <div>
                <input type='password' id='PASSWD' name='PASSWD' onkeyup="pwCheck();">
                <input type='text' value="비밀번호는 9자리 이상, 특수문자를 포함하여야 합니다." style="color:red;width:500px;border:none">
            </div>
        </div>
        <div id="font1">
            <div id="box1">
                비밀번호 확인
            </div>
            <div>
                <input type='password' id='PASSWD2' name='PASSWD2' onkeyup="pwCheck();">
                <input type='text' id='USERPW_CONFIRM' value="변경 비밀번호가 일치하지 않습니다." style="color:red;width:500px;border:none">
            </div>
        </div>
        <div id="font1">
            <div id="box1">
                핸드폰번호
            </div>
            <div>
                <input type='text' id='PHONENUMBER' name='PHONENUMBER' />
                <input type='text' id='USERPN_CONFIRM' value="-없이 숫자만 입력해주세요" style="color:red;width:500px;border:none">
            </div>
        </div>
        <div id="font2">
            <div id="box1">
                * 비밀번호 사용 규칙* <br>
                1. 사용자 계정(아이디)과 동일 하지 않은것 <br>
                2. 개인 신상 및 부서 명칭 등과 관계가 없는 것<br>
                3. 일반 사전에 등록된 단어의 사용을 피할 것<br>
                4. 동일한 단어 또는 숫자를 반복하여 사용하지 말것<br>
                5. 사용된 비밀번호는 재사용하지 말것<br>
            </div>
        </div>

        <div id="box1">
            <div>
                <div id=font1>
                    3. 사용기간 :
                    <sapn id="today"><?php echo $today; ?></sapn> ~ <sapn id="lastday"><?php echo $lastday; ?></sapn>
                </div>
            </div>
            <div>
                <div id="font1">
                    <span style="font-weight: bold;">한국형사정책연구원 <span style="color:blue;font-weight:bold;">퇴사</span> 또는 <span style="color:blue;font-weight:bold;">사용 의사 철회</span> 시 또는 <span style="color:blue;font-weight:bold;">신청 후 3개월</span></span>
                </div>
            </div>
        </div>
        <div id="box3">
            <div style="text-align:center;">
                <h2>무선랜 보안서약서</h2>
            </div>
            <div>
                <div colspan=2>
                    <div style="font-weight:bold;">■ 보안서약 및 주의사항</div>
                    <div style="margin-left:0.5em;"><br>본인은 한국형사정책연구원의 무선랜 시스템(이하 “무선랜”)을 사용하면서 다음의 내용을 준수할 것을 약속하고 동의 의사를 제출합니다.<br>
                        - 신청 후 <span style="color:blue;font-weight:bold;">90일마다 비밀번호 변경</span>, 비밀번호 변경 시 <span style="color:blue;font-weight:bold;">사용신청서 재작성</span>하겠습니다.<br>
                        - 무선랜 사용에 관한 무선장비 관리지침(암호변경 주기, 사용 절차) 등을 준수합니다.<br>
                        - 무선랜 단말의 불필요한 네트워크 인터페이스 (유선, Zigbee, 블루투스, USB, NFC 등)를 비활성화하겠습니다.<br>
                        - 비인가자(외부인 등)에게 무선랜 관련 사항(SSID, 계정, 패스워드 등)을 유출하지 않겠습니다.<br>
                        - 무선랜 관련 유·무형 자산에 대한 분실·탈취·훼손·도난 등을 하지 않으며, 기술적·관리적·물리적 보안대책을 준수하겠습니다.<br>
                        - 그 밖에 한국형사정책연구원의 무선랜 운용에 관한 기밀성·무결성·가용성을 저해하는 행위를 하지 않겠습니다.
                    </div>
                    <div style="margin-left:0.5;margin-top:2em;"> 상기 사항을 숙지하고 이를 성실히 준수할 것이며 본 서약서의 내용을 위반하였을 경우,<br>
                        연구원 보안업무규정 등 관련 규정에 따른 징계 조치 등 어떠한 불이익도 감수할 것이며<br>
                        연구원에 끼친 손해에 대해 지체없이 변상, 복구할 것을 서약합니다.<br>
                    </div>
                    <div style="margin-left:0.5;margin-top:2em;">위 보안 서약에 <span style="color:red;font-weight:bold;">동의 하지 않는 경우 무선랜(와이파이) 사용이 불가</span>합니다.</div>
                    <div style="margin-left:0.5;margin-top:2em;">위 무선랜 사용 신청 및 보안 서약에 관한 내용과 책임에 동의하십니까?</div>

                    <div style="margin-top:1em;">동의함
                        <input type='checkbox' id='AGREE_CHECK' name='AGREE_CHECK'>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <button id="btnblack">등록</button>
                </div>
            </div>
        </div>
    </body>
</form>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    function android() {
        window.open("<?php echo $_SERVER['DOCUMENT-ROOT']; ?>android.php", "_blank");
    }

    function iPhone() {
        window.open("<?php echo $_SERVER['DOCUMENT-ROOT']; ?>iPhone.php", "_blank");
    }

    function chkForm() {
        for (var i = 1; i < 6; i++) {
            if ($("#MAC" + i).val() == '') {
                alert("MAC 주소 " + i + "번째 칸이 비어있습니다.")
                return false;
            }
        }
        if ($("#PASSWD").val() != $("#PASSWD2").val()) {
            alert("변경 비밀번호가 서로 일치하지 않습니다.")
            return false;
        } else {
            if (checkPasswordPattern($("#PASSWD").val()) == false) {
                return false;
            } else {
                if ($("#PASSWD").val() == $("#USERID").val()) {
                    alert("사용자 계정(아이디)와 비밀번호는 동일할 수 없습니다.")
                    return false;
                } else {
                    if ($("input:checkbox[name=AGREE_CHECK]").is(":checked") == false) {
                        alert("무선랜 보안서약서에 동의하지 않으면 신청하실 수 없습니다.")
                        return false;
                    } else {
                        var regex = /[^0-9]/g;
                        if (regex.test($("#PHONENUMBER").val()) == true) {
                            alert('핸드폰 번호는 숫자만 입력해주세요.');
                            $("#PHONENUMBER").focus();
                        } else {
                            document.cform.submit();
                        }
                    }

                }
            }
        }
    }

    function pwCheck() {
        if ($("#PASSWD").val() != $("#PASSWD2").val()) {
            $("#USERPW_CONFIRM").val("변경 비밀번호가 일치하지 않습니다.")
            $("#USERPW_CONFIRM").css("color", "red");
        } else {
            $("#USERPW_CONFIRM").val("변경 비밀번호 일치.")
            $("#USERPW_CONFIRM").css("color", "green");
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

    // mac 패턴 체크 (소문자,숫자만) 
    function MACPattern(id) {
        var regType1 = /^[a-z0-9+]{0,2}$/;
        if ($("#" + id).val().length == 2) {
            if (regType1.test($("#" + id).val()) == false) {
                $("#" + id).val('');
                alert('MAC 주소는 숫자,소문자(영문) 2글자를 입력해주세요.');
            } else {
                $("#" + id).next('.mac').focus();
            }
        }
    }

</script>

</html>

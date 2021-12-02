<body>
<form name="cform" method="get">

             </td>
             <td width="923" align="center" valign="top">

                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>

                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">커스터마이징 제목</td>
                    <td width="85%" height="40" class="t_border" align="center" colspan="3" >GATEONE-Z 이지모아 패스워드 연동</td>
                  </tr>
               <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
                  <tr>
                    <td width="100%" height="20" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;" colspan="4">상세내역</td>
                  </tr>
               <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
                  <tr>
                    <td width="100%" height="40" class="t_border" colspan="4">
1. 연동 파일 
<br>경로 : /opt/gate1/www/interlock/kbl/
<br> 파일명 : eai_process_new.php
<br><br>연동로직:
<br>>ㄴ)이지모아에서 사용자 패스워드 변경시 GATEONE 으로 URL 호출 진행(ex . http://10.29.2.3/interlock/kbl/eai_process_new.php?gubun=U&sha512_str=31b19514b5c8ddcd83f17fd43f1fb0856bffgce831d1cf0b71c18992b693ecad0441bc7b8e5998373f50b0b288a95a23b67f64f8b3a38208fa1c97de00dc98c8b1&userid=09927800
<br>ㄷ)eai_process_new 페이지에서 gubun 이하의 URL 정보를 잘라 DB MODOOS > EAI_TEST 테이블에 Insert진행
<br>ㄹ)EAI_TEST 테이블에 Insert 되면 내부 로직에 의해 패스워드 변경진행
<br><br>2.추가 설정
<br>경로:/opt/gate1/www/ONE_conf/ 
<br>파일명 : siteCommon.inc
<br>설정 내용 : 141 번째 라인 $exception_page 값에 /interlock/kbl/eai_process_new.php 내용 추가</td>
                  </tr>


                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
</form>
</table>
</body>
</html>

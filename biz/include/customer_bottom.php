<script>
    $(function(){
      // bind change event to select
      $('#dynamic_select').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
	<td width="72%">경기도 성남시 분당구 판교로 255번길 9-22(삼평동 618번지) 판교우림더블유시티 603호 <br />
	  Phone. 02-542-4987 | Fax. 02-6455-3987</td>
	<td width="28%" align="right"><table width="60%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td><select name="dynamic_select" id="dynamic_select" class="com">
			<option>벤더사</option>
			<option value="http://www.modoosone.com"/>모두스원</option>
			<option value="http://www.monitorapp.com/kr">모니터랩</option>
			<option value="http://www.skinfosec.com/">SK 인포섹</option>
			<option value="https://www.secui.com">시큐아이</option>
			<option value="http://www.ebailey.co.kr">베일리테크</option>
			<option value="http://www.secuwiz.co.kr">시큐위즈</option>
			<option value="http://www.seculayer.co.kr">시큐레이어</option>
			<option value="http://www.secuever.com">시큐에버</option>
		  </select></td>
		  <!-- <td><img src="/misc/img/btn_go.png" width="34" height="21" /></td> -->
		</tr>
	  </table></td>
  </tr>
</table>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
.basic_td{
	border:1px solid;
	border-color:#d7d7d7;
	padding:0px 10px 0px 10px;
}
.basic_table{
	border-collapse:collapse;
	border:1px solid;
	border-color:#d7d7d7;
}
</style>
<script language="javascript">
// function GoSearch(){
// 	var searchkeyword = '';
//   for (i = 1; i <= $(".filtercolumn").length; i++) {
//     if (i == 1) {
//       searchkeyword += $("#filter" + i).val();
//     } else {
//       searchkeyword += ',' + $("#filter" + i).val();
//     }
//   }

//   $("#searchkeyword").val(searchkeyword)

//   if (searchkeyword.replace(/,/g, "") == "") {
//     alert("검색어가 없습니다.");
// 	location.href="<?php echo site_url();?>/maintain/maintain_list";
// 	return false;
//   }

//   document.mform.action = "<?php echo site_url();?>/maintain/maintain_list";
//   document.mform.cur_page.value = "";
//   document.mform.submit();
// }
</script>
<body>
    <table width="90%" height="100%" cellspacing="0" cellpadding="0" style="padding-left:30px;" >
        <tr>
            <td width="100%" align="center" valign="top">
            <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">통합 유지보수</td>
              </tr>
              <!--타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td id="tablePlus">
				<table class="basic_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                    <col width="20%" /> <!-- 번호-->
                    <col width="80%" /> <!-- 종류-->
                  </colgroup>
                  <tr>
                    <td colspan="16" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr class="t_top">
                    <td height="40" align="center" class="basic_td">번호</td>
                    <td align="center" class="basic_td">프로젝트</td>
                  </tr>
				  <?php
				  if(!empty($list_val)){
				  $idx = 1;  
				  foreach($list_val as $list){?>
					<tr>
						<td height="40" align="center" class="basic_td"><?php echo $idx; ?></td>
						<td align="center" class="basic_td" style="cursor:pointer;" onclick="integration_view(<?php echo $list['seq']; ?>);"><?php echo $list['project_name']; ?></td>
                  	</tr>
				  <?php $idx++; } 
				  }else{
					  echo "<tr><td height=40 colspan=2 class='basic_td' align='center'>게시글이 없습니다.</td></tr>";
				  }?>
            </table>
            <!--내용-->
            </td>
        </tr>
		<tr>
			<td align="right"><img src="<?php echo $misc;?>img/btn_make.jpg" width="64" height="31" style="margin-top:30px;cursor:pointer;" onclick="location.href='<?php echo site_url();?>/sales/maintain/integration_maintain_input'"/></td>
		</tr>
     </table>
<script>
//통합유지보수 뷰로 이동
function integration_view(seq){
	location.href = "<?php echo site_url();?>/sales/maintain/integration_maintain_view?seq="+seq;
}


</script>
</body>
</html>

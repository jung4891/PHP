<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">     
<body>
<table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
	<tr>
		<td width="100%" align="center" valign="top">
			<!--내용-->
			<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
				<!--타이틀-->
				<tr>
					<td class="title3">완료/참조문서함</td>
				</tr>
				<!--//타이틀-->
				<tr>
					<td>&nbsp;</td>
				</tr>

				<!--작성-->
				<tr>
					<td>
                  <table class="basic_table" width="100%">
                     <tr bgcolor="f8f8f9">
                        <th height=40 class="basic_td"><input type="checkbox" name="attachment_check" value="all" onclick="allCheck(this);"></th>
                        <th class="basic_td">서식함</th>
                        <th class="basic_td">문서번호</th>
                        <th class="basic_td">문서제목</th>
                        <th class="basic_td">기안자</th>
                        <th class="basic_td">완료일</th>
                     </tr>
                     <?php foreach($view_val as $val){
                        echo "<tr>";
                        echo "<th height=40 class='basic_td'><input type='checkbox' name='attachment_check' value='{$val['seq']}--{$val['approval_doc_name']}'></th>";
                        echo "<th height=40 class='basic_td'>";
                        foreach($category as $format_categroy){
                           if($val['template_category'] == $format_categroy['seq']){
                              echo $format_categroy['category_name'];
                           }
                        }
                        echo "</th>";
                        echo "<th height=40 class='basic_td'></th>";
                        echo "<th height=40 class='basic_td'>{$val['approval_doc_name']}</th>";
                        echo "<th height=40 class='basic_td'>{$val['writer_name']}</th>";
                        echo "<th height=40 class='basic_td'>{$val['completion_date']}</th>";
                        echo "</tr>";
                     }?>
                  </table>
               </td>
			</table>
		</td>
		<td height="10"></td>
	</tr>
	<!--버튼-->
	<tr>
		<td align="right">
         <input type="image" src="<?php echo $misc; ?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="attachment_ok();return false;" />
         <input type="image" src="<?php echo $misc; ?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onclick="cancel();return false;" />
		</td>
	</tr>
</table>
</body>
<script>
   function allCheck(obj){
      if($(obj).is(":checked") == true){
         $("input[name=attachment_check]").prop("checked", true);
      }else{
         $("input[name=attachment_check]").prop("checked", false);
      }
   }

   function attachment_ok(){
      var text1 ='';
      var text2 = '';
      $("input[name=attachment_check]:checked").each(function () {
         if($(this).val() != "all"){
            var attachement_seq = $(this).val().split('--')[0];
            var attachement_doc_name = $(this).val().split('--')[1];
            if($("#attach_"+attachement_seq,opener.document).length == 0){
               text1 += ","+attachement_seq;
               text2 += "<div id='attach_"+attachement_seq+"'><span name='attach_name'>"+attachement_doc_name+"</span><img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='attachRemove("+attachement_seq+")'/></div>";
            }
         }
      });
      text1 = text1.replace(',','');
      
      $("#approval_attach",opener.document).val($("#approval_attach",opener.document).val()+','+text1);
      $("#approval_attach_list",opener.document).html($("#approval_attach_list",opener.document).html()+text2);
      self.close();
   }
   
</script>
</html>

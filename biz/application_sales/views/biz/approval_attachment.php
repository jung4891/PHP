<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
    $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
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
<link rel="stylesheet" href="/misc/css/dashboard.css">
<body>
<form name="cform" action="<?php echo site_url();?>/biz/approval/approval_attachment" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
   <input type="hidden" id="check" name="check" value="<?php echo str_replace('"', '&uml;',$check); ?>" />
</form>
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

            <!-- 검색 부분 시작 -->
            <tr id="search_tr">
               <td align="left" valign="top">
                  <table width="80%" id="filter_table" style="margin:30px 0px 30px 20px;">
                     <tr align="left">
                        <td width="6%">양식명</td>
                        <td width="16%"><input type="text" id="filter1" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[0];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();"  /></td>
                        <td width="6%">문서제목</td>
                        <td width="16%"><input type="text" id="filter2" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[1];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" /></td>
                        <td width="6%">문서상태</td>
                        <td width="16%">
                           <select id="filter3" class="input3 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" >
                              <option value="" <?php if(isset($filter)){if($filter[2] == ""){echo "selected";}} ?>>문서상태선택</option>
                              <option value="001" <?php if(isset($filter)){if($filter[2] == "001"){echo "selected";}} ?>>진행중</option>
                              <option value="002" <?php if(isset($filter)){if($filter[2] == "002"){echo "selected";}} ?>>완료</option>
                              <option value="003" <?php if(isset($filter)){if($filter[2] == "003"){echo "selected";}} ?>>반려</option>
                              <option value="004" <?php if(isset($filter)){if($filter[2] == "004"){echo "selected";}} ?>>회수</option>
                              <option value="006" <?php if(isset($filter)){if($filter[2] == "006"){echo "selected";}} ?>>보류</option>
                           </select>
                        </td>
                        <td width="6%">문서내용</td>
                        <td width="16%">
                           <input type="text" id="filter4" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[3];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                        </td>
                        <td width="5%"><input type="image" style='cursor:hand;' onclick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" align="left" valign="top" border="0" width="28" /></td>
                     </tr>
                     <tr align="left">
                        <td>기안일</td>
                        <td colspan=3>
                           <input type="date" id="filter5" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[4];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                           &ensp; ~ &ensp;
                           <input type="date" id="filter6" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[5];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                        </td>
                        <td>완료일</td>
                        <td colspan=3>
                           <input type="date" id="filter7" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[6];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                           &ensp; ~ &ensp;
                           <input type="date" id="filter8" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[7];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                        </td>
                     </tr>
                  </table>
            </tr>
            <!-- 검색 부분 끝 -->

				<!--작성-->
				<tr>
					<td>
                  <table class="basic_table" width="100%">
                     <tr bgcolor="f8f8f9">
                        <th height=40 class="basic_td"><input type="checkbox" name="attachment_check" value="all" onclick="allCheck(this);"></th>
                        <th class="basic_td">서식함</th>
                        <th class="basic_td">양식명</th>
                        <th class="basic_td">문서번호</th>
                        <th class="basic_td">문서제목</th>
                        <th class="basic_td">기안자</th>
                        <th class="basic_td">완료일</th>
                     </tr>
                     <?php
                     if(!empty($view_val)){
                        $idx = $count-$start_row;
                        for($i = $start_row; $i<$start_row+$end_row; $i++){
                           if(!empty( $view_val[$i])){
                              $val = $view_val[$i];
                        echo "<tr>";
                        echo "<th height=40 class='basic_td'><input type='checkbox' name='attachment_check' value='{$val['seq']}--{$val['approval_doc_name']}' onchange='check_change();'></th>";
                        echo "<th height=40 class='basic_td'>";
                        foreach($category as $format_categroy){
                           if($val['template_category'] == $format_categroy['seq']){
                              echo $format_categroy['category_name'];
                           }
                        }
                        echo "</th>";
                        echo "<th height=40 class='basic_td'>{$val['template_name']}</th>";
                        echo "<th height=40 class='basic_td'>{$val['writer_group']}-{$val['doc_num']}</th>";
                        echo "<th height=40 class='basic_td'>{$val['approval_doc_name']}</th>";
                        echo "<th height=40 class='basic_td'>{$val['writer_name']}</th>";
                        echo "<th height=40 class='basic_td'>{$val['completion_date']}</th>";
                        echo "</tr>";
                        }
                       }
                     }else{
                        echo "<tr align='center'>
                           <td></td>
                           <td height='40' colspan=6 >검색 결과가 존재하지 않습니다.</td>
                           <td></td>
                        </tr>";
                     }
                     ?>
                  </table>
               </td>
			</table>
		</td>
		<td height="10"></td>
	</tr>
    <!-- 페이징 부분 시작 -->
    <tr height="20%">
          <td align="center" valign="top">
            <table width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="19%">
                  <tr height="20%">
                    <td align="center" valign="top">
<?php
 if ($count > 0) {
?>
                       <table width="400" border="0" cellspacing="0" cellpadding="0" >
                         <tr>
<?php
   if ($cur_page > 10){
?>
                           <td width="19">
                             <a href="JavaScript:GoFirstPage()">
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" />
                             </a>
                           </td>
                           <td width="2"></td>
                           <td width="19">
                             <a href="JavaScript:GoPrevPage()">
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" />
                             </a>
                           </td>
<?php
   } else {
?>
                           <td width="19"></td>
                           <td width="2"></td>
                           <td width="19"></td>
<?php
   }
?>
                           <td align="center">
<?php
    for  ( $i = $start_page; $i <= $end_page ; $i++ ){
       if( $i == $end_page ) {
          $strSection = "";
       } else {
          $strSection = "&nbsp;<span class=\"section\">&nbsp;&nbsp;</span>&nbsp;";
       }

       if  ( $i == $cur_page ) {
          echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
       } else {
          echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
       }
    }
?>
                           </td>
<?php
   if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
                           <td width="19">
                             <a href="JavaScript:GoNextPage()">
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width=20/>
                             </a>
                           </td>
                           <td width="2"></td>
                           <td width="19">
                             <a href="JavaScript:GoLastPage()">
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width=20 />
                             </a>
                           </td>
<?php
   } else {
?>
                           <td width="19"></td>
                           <td width="2"></td>
                           <td width="19"></td>
<?php
   }
?>
                         </tr>
                        </table>
<?php
 }
?>
                      </td>
                    </tr>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- 페이징처리끝 -->
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
      // $("input[name=attachment_check]:checked").each(function () {
      //    if($(this).val() != "all"){
      //       var attachement_seq = $(this).val().split('--')[0];
      //       var attachement_doc_name = $(this).val().split('--')[1];
      //       if($("#attach_"+attachement_seq,opener.document).length == 0){
      //          text1 += ","+attachement_seq;
      //          text2 += "<div id='attach_"+attachement_seq+"'><span name='attach_name'>"+attachement_doc_name+"</span><img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='attachRemove("+attachement_seq+")'/></div>";
      //       }
      //    }
      // });
      var total = $("#check").val().replace('||','');
      total = total.split("||");
      const set = new Set(total);
      total = [...set];
      for(var i=0; i<total.length; i++){
            var attachement_seq = total[i].split('--')[0];
            var attachement_doc_name = total[i].split('--')[1];
            if($("#attach_"+attachement_seq,opener.document).length == 0){
               text1 += ","+attachement_seq;
               text2 += "<div id='attach_"+attachement_seq+"'><span name='attach_name'>"+attachement_doc_name+"</span><img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='attachRemove("+attachement_seq+")'/></div>";
            }

      }
      text1 = text1.replace(',','');
      if(text1 != ""){
         $("#approval_attach",opener.document).val($("#approval_attach",opener.document).val()+','+text1);
         $("#approval_attach_list",opener.document).html($("#approval_attach_list",opener.document).html()+text2);
      }
      self.close();
   }

   //취소버튼
   function cancel(){
      if(confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")){
         window.self.close();
         // location.href='<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_modify'
      }else{
         return false;
      }
   }

   function GoFirstPage (){
      document.cform.cur_page.value = 1;
      document.cform.submit();
   }

   function GoPrevPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
      document.cform.submit( );
   }

   function GoPage(nPage){
      document.cform.cur_page.value = nPage;
      document.cform.submit();
   }

   function GoNextPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
      document.cform.submit();
   }

   function GoLastPage (){
      var	total_page = <?php echo $total_page;?>;
   //	alert(total_page);

      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

  //거엄색!
  function GoSearch() {
    var searchkeyword = '';
    for (i = 1; i <= $(".filtercolumn").length; i++) {
      if (i == 1) {
        searchkeyword += $("#filter" + i).val().trim();
      } else {
        var filter_val = $("#filter" + i).val().trim();
        if (i == 13 || i == 14) {
          filter_val = String(filter_val).replace(/,/g, "");
        }
        searchkeyword += ',' + filter_val;
      }
    }
    $("#searchkeyword").val(searchkeyword)

    if (searchkeyword.replace(/,/g, "") == "") {
      alert("검색어가 없습니다.");
      location.href = "<?php echo site_url();?>/biz/approval/approval_attachment";
      return false;
    }

    document.cform.action = "<?php echo site_url();?>/biz/approval/approval_attachment";
    document.cform.cur_page.value = "1";
    document.cform.submit();
  }

  //체크 달라질때마다
  function check_change(){
   $("input[name=attachment_check]:checked").each(function () {
         if($(this).val() != "all"){
            $("#check").val($("#check").val()+"||"+$(this).val());
            console.log($("#check").val())
         }
      });
  }

   //페이지 옮겨가도 기억해
   var total = $("#check").val().replace('||','');
   total = total.split("||");
   const set = new Set(total);
   total = [...set];
   for(var i=0; i<total.length; i++){
      $("input[name=attachment_check][value='"+total[i]+"']").prop("checked",true);
   }
</script>
</html>

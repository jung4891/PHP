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
   .input-common {
     width: 156px !important;
     box-sizing: border-box;
   }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<body>
<form name="cform" action="<?php echo site_url();?>/biz/official_doc/official_doc_attachment" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
   <input type="hidden" id="check" name="check" value="" />
</form>
<table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
	<tr>
		<td width="100%" align="center" valign="top">
			<!--내용-->
			<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
				<!--타이틀-->
				<tr>
					<td class="title3">공문함</td>
				</tr>
				<!--//타이틀-->
				<tr>
					<td>&nbsp;</td>
				</tr>

            <!-- 검색 부분 시작 -->
            <tr id="search_tr">
               <td align="left" valign="top">
                  <table width="80%" id="filter_table" style="margin:30px 0px 30px 20px;font-weight:bold;vertical-align:middle;">
                     <tr align="left">
                       <td style="font-weight:bold;vertical-align:middle;">
                         결재상태&nbsp;
                         <select id="filter1" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;">
                             <option value="" <?php if(isset($filter)){if($filter[0] == ""){echo "selected";}} ?>>결재상태선택</option>
                             <option value="001" <?php if(isset($filter)){if($filter[0] == "001"){echo "selected";}} ?>>진행중</option>
                             <option value="002" <?php if(isset($filter)){if($filter[0] == "002"){echo "selected";}} ?>>완료</option>
                             <option value="003" <?php if(isset($filter)){if($filter[0] == "003"){echo "selected";}} ?>>반려</option>
                             <option value="004" <?php if(isset($filter)){if($filter[0] == "004"){echo "selected";}} ?>>회수</option>
                         </select>
                         문서양식&nbsp;
                         <select id="filter2" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;">
                           <option value="" <?php if(isset($filter)){if($filter[1] == ""){echo "selected";}} ?>>문서양식선택</option>
                         <?php foreach($doc_form_list as $dfl) { ?>
                           <option value="<?php echo $dfl['doc_name']; ?>" <?php if(isset($filter)){if($filter[1] == $dfl['doc_name']){echo "selected";}} ?>><?php echo $dfl['doc_name']; ?></option>
                         <?php } ?>
                         </select>
                         작성일
                         <input type="date" id="filter3" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[2];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;" />
                         ~
                         <input type="date" id="filter4" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[3];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;margin-right:10px;"/>
                         <select id="filter5" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;">
                             <option value="to" <?php if(isset($filter)){if($filter[4] == "to"){echo "selected";}} ?>>수신</option>
                             <option value="cc" <?php if(isset($filter)){if($filter[4] == "cc"){echo "selected";}} ?>>참조</option>
                             <option value="from" <?php if(isset($filter)){if($filter[4] == "from"){echo "selected";}} ?>>발신</option>
                             <option value="subject" <?php if(isset($filter)){if($filter[4] == "subject"){echo "selected";}} ?>>제목</option>
                         </select>
                         <input type="text" id="filter6" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[5];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" placeholder="검색하세요."  />
                         <input type="button" class="btn-common btn-style1" style="height:27px;cursor:hand;" value="검색" onclick="return GoSearch();">
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
                        <th height=40 class="basic_td">
                          <input type="checkbox" name="attachment_check" value="all" onclick="allCheck(this);">
                        </th>
                        <th class="basic_td">No</th>
                        <th class="basic_td">공문양식</th>
                        <th class="basic_td">수신</th>
                        <th class="basic_td">발신</th>
                        <th class="basic_td">제목</th>
                        <th class="basic_td">결재상태</th>
                        <th class="basic_td">작성일</th>
                     </tr>
                <?php if ($count > 0) {
                        $i = $count - $no_page_list * ($cur_page - 1);
                        $icounter = 0;

                        foreach($view_val as $item) {
                  ?>
                      <tr>
                        <th height=40 class='basic_td'><input type='checkbox' name='attachment_check' value="<?php echo $item['seq']; ?>--<?php echo $item['subject']; ?>" onchange='check_change();'></th>
                        <th height=40 class='basic_td'><?php echo $i; ?></th>
                        <th height=40 class='basic_td'><?php echo $item['doc_name']; ?></th>
                        <th height=40 class='basic_td'><?php echo $item['to']; ?></th>
                        <th height=40 class='basic_td'><?php echo $item['from']; ?></th>
                        <th height=40 class='basic_td'><?php echo $item['subject']; ?></th>
                        <th height=40 class='basic_td'>
                          <?php
                          if($item['approval_doc_status'] == '003') {
                            echo '<span style="color:#DC0A0A">반려</span>';
                          } else if ($item['approval_doc_status'] == '004') {
                            echo '회수';
                          } else if ($item['approval_doc_status'] == '005') {
                            echo '임시저장';
                          }
                          ?>
                        </th>
                        <th height=40 class='basic_td'><?php echo substr($item['write_date'], 0 ,10); ?></th>
                      </tr>
                <?php $i--;
                      }
                    } else { ?>
                      <tr>
                        <th height=40 class='basic_td' colspan="5">등록된 게시물이 없습니다.</th>
                      </tr>
                    <?php } ?>
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
         check_change();
      }else{
         $("input[name=attachment_check]").prop("checked", false);
         check_change();
      }
   }

   function attachment_ok(){
      var text1 ='';
      var text2 = '';
      var total = $("#check").val().replace('||','');
      total = total.split("||");
      const set = new Set(total);
      total = [...set];
      for(var i=0; i<total.length; i++){
            var official_doc_seq = total[i].split('--')[0];
            var official_doc_name = total[i].split('--')[1];
            if($("#officialDoc_"+official_doc_seq,opener.document).length == 0){
               text1 += ","+official_doc_seq;
               text2 += "<div id='officialDoc_"+official_doc_seq+"'><span name='attach_name'>"+official_doc_name+"</span><img src='<?php echo $misc; ?>/img/btn_del2.jpg' style='vertical-align:middle;cursor:pointer;margin-left:5px;' onclick='officialDocRemove("+official_doc_seq+")'/></div>";
            }

      }
      text1 = text1.replace(',','');
      if(text1 != ""){
         $("#official_doc_attach",opener.document).val($("#official_doc_attach",opener.document).val()+','+text1);
         $("#official_doc_attach_list",opener.document).html($("#official_doc_attach_list",opener.document).html()+text2);
      }
      self.close();
   }

   //취소버튼
   function cancel(){
      if(confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")){
         window.self.close();
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
      location.href = "<?php echo site_url();?>/biz/official_doc/official_doc_attachment";
      return false;
    }

    document.cform.action = "<?php echo site_url();?>/biz/official_doc/official_doc_attachment";
    document.cform.cur_page.value = "1";
    document.cform.submit();
  }

  //체크 달라질때마다
  function check_change(){
    $("#check").val('');
   $("input[name=attachment_check]:checked").each(function () {
         if($(this).val() != "all"){
            $("#check").val($("#check").val()+"||"+$(this).val());
            // console.log($("#check").val())
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

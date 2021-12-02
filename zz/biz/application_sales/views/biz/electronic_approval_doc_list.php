<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
    $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6 {
     font-family: "Noto Sans KR";
   }
</style>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <form name="cform" action="<?php echo site_url();?>/biz/approval/electronic_approval_doc_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
         <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
         <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
         <input type="hidden" name="type" value="<?php echo $type; ?>">
         <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
      </form>
      <input type="hidden" id="seq" name="seq" value="">
      <tbody height="100%">
      <!-- 타이틀 부분 시작 -->
        <tr height="5%">
          <td class="dash_title">
<?php
  if($type == "request"){
?>
            결재요청함
<?php
  }else{
?>
            임시저장함
<?php
  }
?>
            <!-- <img src="<?php echo $misc;?>img/dashboard/title_weekly_report_list.png"/> -->
          </td>
        </tr>
        <!-- 타이틀 부분 끝 -->
        <!-- 검색 부분 시작 -->
        <tr id="search_tr">
          <td align="left" valign="top">
              <table width="100%" id="filter_table" style="margin-top:70px;">
                <tr align="left" style="font-weight:bold;font-size:14px;">
                    <!-- <td width="6%">양식명</td> -->
                    <!-- <td width="16%"><input type="text" id="filter1" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[0];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();"  /></td> -->
                    <!-- <td width="6%">문서제목</td> -->
                    <!-- <td width="16%"><input type="text" id="filter2" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[1];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" /></td> -->
                    <td>
                      문서상태&nbsp;
                      <select id="filter1" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;">
                          <option value="" <?php if(isset($filter)){if($filter[0] == ""){echo "selected";}} ?>>문서상태선택</option>
                          <option value="001" <?php if(isset($filter)){if($filter[0] == "001"){echo "selected";}} ?>>진행중</option>
                          <option value="002" <?php if(isset($filter)){if($filter[0] == "002"){echo "selected";}} ?>>완료</option>
                          <option value="003" <?php if(isset($filter)){if($filter[0] == "003"){echo "selected";}} ?>>반려</option>
                          <option value="004" <?php if(isset($filter)){if($filter[0] == "004"){echo "selected";}} ?>>회수</option>
                          <option value="006" <?php if(isset($filter)){if($filter[0] == "006"){echo "selected";}} ?>>보류</option>
                      </select>
                      기안일&nbsp;
                      <input type="date" id="filter2" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[1];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;" />
                      ~
                      <input type="date" id="filter3" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[2];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;margin-right:10px;"/>
                    완료일&nbsp;
                      <input type="date" id="filter4" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[3];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;" />
                      ~
                      <input type="date" id="filter5" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[4];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;margin-right:10px;" />
                    <!-- <td width="6%">문서내용</td> -->
                    <!-- <td width="16%"> -->
                        <!-- <input type="text" id="filter4" class="input3 filtercolumn" value='<?php if(isset($filter)){echo $filter[3];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" /> -->
                    <!-- </td> -->
                    <!-- <input type="image" style='cursor:hand;' onclick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" align="left" valign="top" border="0" width="28" /> -->
                    <input type="text" id="filter6" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[5];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" placeholder="검색하세요."  />
                    <input type="button" class="btn-common btn-style1" style="height:27px;cursor:hand;" value="검색" onclick="return GoSearch();">
                    </td>
                </tr>
                <tr align="left">
                </tr>
              </table>
        </tr>

        <!-- 검색 부분 끝 -->
        <!-- 콘텐트 부분 시작 -->
        <tr height="45%">
          <td colspan="2" valign="top" style="padding:10px 0px;">
            <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top">
                  <tr>
                    <td>
                      <table class="list_tbl" style="margin-top:10px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <colgroup>
                          <col width="10%">
                          <col width="5%">
                          <col width="14%">
                          <col width="15%">
                          <col width="19%">
                          <col width="9%">
                          <col width="9%">
                          <col width="9%">
                          <col width="10%">
                        </colgroup>
                        <tr class="t_top row-color1">
                          <th></th>
                          <th height="40" align="center">No</th>
                          <th align="center">서식함</th>
                          <th align="center">양식명</th>
                          <th align="center">문서제목</th>
                          <th align="center">기안일</th>
                          <th align="center">완료일</th>
                          <th align="center">문서상태</th>
                          <th></th>
                        </tr>
<?php
  if(empty($view_val) != true){
    $idx = $count-$start_row;
    for($i = $start_row; $i<$start_row+$end_row; $i++){
       if(!empty( $view_val[$i])){
          $doc = $view_val[$i];
?>
                        <tr  onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer;" onclick="eletronic_approval_view('<?php echo $doc['seq']; ?>','<?php echo $doc['approval_doc_status']; ?>')">
                          <td></td>
                          <td height='40' align="center">
                            <?php echo $idx; ?>
                          </td>
                          <td align="center">
                          <?php
                          if($doc['template_category'] == ""){
                            echo "연차";
                          }
                          ?>
<?php
         foreach($category as $format_categroy){
           if($doc['template_category'] == $format_categroy['seq']){
             echo $format_categroy['category_name'];
           }
         }
?>
                          </td>
                          <td align="center"><?php echo $doc['template_name'];?></td>
<?php
          if($doc['approval_doc_hold'] == "N"){
?>
                          <td align="center">
                            <?php echo $doc['approval_doc_name']; ?>
                          </td>
<?php
          }else{
?>
                          <td align="center">
                            <?php echo $doc['approval_doc_name']; ?>(보류)
                          </td>
<?php
          }
?>
                          <td align="center">
                            <?php echo $doc['write_date']; ?>
                          </td>
                          <td align="center">
                            <?php echo $doc['completion_date']; ?>
                          </td>
                          <td align="center">
                          <?php
                            if($doc['approval_doc_status'] == "001"){
                               echo "진행중";
                            }else if($doc['approval_doc_status'] == "002"){
                               echo "완료";
                            }else if($doc['approval_doc_status'] == "003"){
                               echo "반려";
                            }else if($doc['approval_doc_status'] == "004"){
                               echo "회수";
                            }else if($doc['approval_doc_status'] == "005"){
                               echo "임시저장";
                            }
                          ?>
                          </td>
                          <td></td>
                        </tr>
<?php
            $idx--;
          }
        }
      }else{
?>
                        <tr align='center'>
                          <td></td>
                          <td height='40' colspan=6 >검색 결과가 존재하지 않습니다.</td>
                          <td></td>
                        </tr>
<?php
      }
?>

                      </table>
                    </td>
                  </tr>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <!-- 콘텐트 부분 끝 -->
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
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" />
                             </a>
                           </td>
                           <td width="2"></td>
                           <td width="19">
                             <a href="JavaScript:GoPrevPage()">
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" />
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
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20"/>
                             </a>
                           </td>
                           <td width="2"></td>
                           <td width="19">
                             <a href="JavaScript:GoLastPage()">
                               <img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" />
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
          <tr>
            <td>
                <!-- 페이징개수 -->
                <div style="width:fit-content;float:right;margin:0px 10px 50px 0px;">
                  <select class="select-common" id="listPerPage" style="height:25px" onchange="change_lpp()">
                      <option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
                      <option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
                      <option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
                      <option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
                      <option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
                      <option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
                  </select>
                  <!-- <input type="button" class="basicBtn" name="button" style="background-color:#E2E2E2; color:black;height:25px" value="검색" onclick="change_lpp();"> -->
                </div>
            </td>
          </tr>
          <!-- 페이징처리끝 -->
        </tbody>
      </table>
    </div>
  </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
   function eletronic_approval_view(seq,status){
        location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $_GET['type']; ?>&type2="+status;
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
    console.log(searchkeyword);
    $("#searchkeyword").val(searchkeyword)

    if (searchkeyword.replace(/,/g, "") == "") {
      alert("검색어가 없습니다.");
      location.href = "<?php echo site_url();?>/biz/approval/electronic_approval_doc_list?type=<?php echo $type;?>";
      return false;
    }

    document.cform.action = "<?php echo site_url();?>/biz/approval/electronic_approval_doc_list";
    document.cform.cur_page.value = "1";
    document.cform.submit();
  }

  function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.cform.lpp.value = lpp;
		document.cform.submit();
	}


</script>
</body>
</html>

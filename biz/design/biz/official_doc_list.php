<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }
   .main_title {
     display:inline-block;
     position: relative;
     height:40px;
   }
   .main_title a {
     height:40px;
     position: static;
   }
   .cnt {position: absolute;top:0;right:0; font-size: 14px;margin-left:2px;}
  body {
    line-height: normal;
  }
  .dash1-1 {
    margin-top: 48px !important;
  }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<form name="cform" action="<?php echo site_url(); ?>/biz/official_doc/official_doc_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
   <input type="hidden" name="mode" value="<?php echo $_GET['mode']; ?>">
   <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
</form>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <input type="hidden" id="seq" name="seq" value="">
      <tbody height="100%">
        <!-- 타이틀 이미지 tr -->
      <tr height="5%">
        <td class="dash_title">
          <?php
          if($_GET['mode']=='user') {
            echo '공문함';
          } else if ($_GET['mode'] == 'admin') {
            echo '공문관리';
          } ?>
        </td>
      </tr>
      <!-- 검색창 -->
      <tr id="search_tr">
         <td align="left" valign="top">
            <table width="100%" id="filter_table" style="margin-top:80px;">
              <tr>
                <td style="font-weight:bold;vertical-align:middle;">
            <?php if($_GET['mode'] == 'user') { ?>
                  결재상태&nbsp;
            <?php } ?>
                  <select id="filter1" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;<?php if($_GET['mode']=='admin'){echo 'display:none;';} ?>">
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
                      <option value="doc_num" <?php if(isset($filter)){if($filter[4] == "doc_num"){echo "selected";}} ?>>문서번호</option>
                      <option value="to" <?php if(isset($filter)){if($filter[4] == "to"){echo "selected";}} ?>>수신</option>
                      <option value="cc" <?php if(isset($filter)){if($filter[4] == "cc"){echo "selected";}} ?>>참조</option>
                      <option value="from" <?php if(isset($filter)){if($filter[4] == "from"){echo "selected";}} ?>>발신</option>
                      <option value="subject" <?php if(isset($filter)){if($filter[4] == "subject"){echo "selected";}} ?>>제목</option>
              <?php if($_GET['mode'] == 'admin') { ?>
                      <option value="writer_name" <?php if(isset($filter)){if($filter[4] == "writer_name"){echo "selected";}} ?>>작성자</option>
                      <option value="writer_group" <?php if(isset($filter)){if($filter[4] == "writer_group"){echo "selected";}} ?>>부서</option>
              <?php } ?>
                  </select>
                  <input type="text" id="filter6" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[5];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" placeholder="검색하세요."  />
                  <input type="button" class="btn-common btn-style1" style="height:27px;cursor:hand;" value="검색" onclick="return GoSearch();">
                </td>
        <?php if($_GET['mode'] == 'user') { ?>
                <td style="float:right;">
                  <div style='margin:20px 0px 0px 20px;text-align:left;'>
                    <input type="button" class="btn-common btn-color1" value="공문 작성" onclick="official_doc_input_view()" style="width:100px;margin-right:10px;"/>
                    <input type="button" class="btn-common btn-color2" value="기안문 작성" onclick="annual_input()" style="width:100px;"/>
                  </div>
                </td>
        <?php } ?>
              </tr>
            </table>
      </tr>
      <tr>
        <td>
           <!-- 페이징개수 -->
           <div style="width:fit-content;margin-top:10px;">
              <select class="select-common" id="listPerPage" style="height:25px;margin-right:10px;" onchange="change_lpp()">
                 <option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
                 <option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
                 <option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
                 <option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
                 <option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
                 <option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
              </select>
              <!-- <input type="button" class="basicBtn" name="button" style="background-color:#E2E2E2; color:black;height:25px" value="검색" onclick="change_lpp();"> -->
              <span>전체</span>
              <span style="color:red;margin-right:10px;"><?php echo $count; ?></span>
           </div>
        </td>
      </tr>

      <!-- <tr height="10%"> -->
        <!-- 검색 끝 -->

        <!-- 본문시작 -->
        <!-- <tr height="45%"> -->
          <?php if(!empty($delegation)){
            echo "<tr height='30%'>";
          }else{

            echo "<tr height='45%'>";
          }

          ?>


        <td valign="top" style="padding:1px 0px 15px 0px">
        	<table class="list_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
            <colgroup>
      <?php if($_GET['mode'] == 'user') { ?>
              <col width="3%">
              <col width="3%">
              <col width="10%">
              <col width="10%">
              <col width="10%">
              <col width="10%">
              <col width="34%">
              <col width="5%">
              <col width="10%">
              <col width="5%">
      <?php } ?>
      <?php if($_GET['mode'] == 'admin') { ?>
              <col width="3%">
              <col width="3%">
              <col width="10%">
              <col width="10%">
              <col width="10%">
              <col width="10%">
              <col width="24%">
              <col width="5%">
              <col width="5%">
              <col width="5%">
              <col width="10%">
              <col width="5%">
      <?php } ?>
            </colgroup>
            <tr class="t_top row-color1">
              <th>
        <?php if($_GET['mode'] == 'user') { ?>
                <input type="checkbox" id="allCheck" onchange="checkAll(this);">
        <?php } ?>
              </th>
              <th align="center">No</th>
              <th align="center">문서번호</th>
              <th align="center">문서양식</th>
              <th align="center">수신</th>
              <th align="center">발신</th>
              <th align="center">제목</th>
              <th align="center">결재</th>
      <?php if($_GET['mode'] == 'admin') { ?>
              <th align="center">작성자</th>
              <th align="center">작성부서</th>
      <?php } ?>
              <th align="center">작성일</th>
              <th></th>
            </tr>
            <tr>
              <?php
              if ($count > 0) {
                $i = $count - $no_page_list * ($cur_page - 1);
                $icounter = 0;

                foreach($view_val as $item) { ?>
                  <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="cursor:pointer;" seq="<?php echo $item['seq']; ?>">
                    <td height="40" align="center">
                <?php if($_GET['mode'] == 'user') { ?>
                <?php if($item['approval_doc_status'] != '001' && $item['approval_doc_status'] != '002') { ?>
                      <input type="checkbox" class="approvalRow" name="approvalRow" seq="<?php echo $item['seq']; ?>" onchange="approvalCheck(this);">
                <?php } ?>
                <?php } ?>
                    </td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $i; ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php if($item['doc_num']==''){echo '미발급';}else{echo $item['doc_num'].substr_replace($item['doc_num2'], '-', 4, 0);} ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $item['doc_type']; ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $item['to']; ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $item['from']; ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $this->common->trim_text(stripslashes($item['subject']),100); ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')">
                      <?php
                      if($item['approval_doc_status'] == '001') {
                        echo "<span style='color:#B0B0B0'>진행중</span>";
                      } else if($item['approval_doc_status'] == '002') {
                        echo "<span>완료</span>";
                      } else if($item['approval_doc_status'] == '003') {
                        echo "<span style='color:#DC0A0A'>반려</span>";
                      } else if($item['approval_doc_status'] == '004') {
                        echo "<span>회수</span>";
                      } else if($item['approval_doc_status'] == '005') {
                        echo "<span>임시저장</span>";
                      }

                      ?>
                    </td>
            <?php if($_GET['mode'] == 'admin') { ?>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $item['writer_name']; ?></td>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo $item['writer_group']; ?></td>
            <?php } ?>
                    <td align="center" onclick="ViewBoard('<?php echo $item['seq']; ?>')"><?php echo substr($item['write_date'], 0 ,10); ?></td>
                    <td></td>
                  </tr>
            <?php
                $i--;
                }
              } else { ?>
                <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                  <td height="40" align="center" colspan="12">등록된 게시물이 없습니다.</td>
                </tr>
        <?php } ?>

            </tr>
          </table>
        </td>
      </tr>

<tr height='40%'>
<td align="left" valign="top">
<table width="100%" cellspacing="0" cellpadding="0">
  <!-- 페이징처리 -->
  <tr>
     <td align="center">
     <?php if ($count > 0) {?>
           <table width="400" border="0" cellspacing="0" cellpadding="0">
                 <tr>
           <?php
              if ($cur_page > 10){
           ?>
                 <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/></a></td>
                 <td width="2"></td>
                 <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/></a></td>
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
                       $strSection = "&nbsp;<span class=\"section\">&nbsp&nbsp</span>&nbsp;";
                    }

                    if  ( $i == $cur_page ) {
                       echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
                    } else {
                       echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
                    }
                 }
              ?></td>
                 <?php
                 if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
              ?>
              <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
                 <td width="2"></td>
                 <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/></a></td>
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
     <?php }?>
           </td>
     </tr>
  <!-- 페이징처리끝 -->
</table>
          </td>
        </tr>

    </tbody>
</table>
</div>
</div>

<div id="approval_form" style="display:none;position: absolute; background-color: white; width: 1000px; height: 470px; border-radius: 5px;">
  <table style="padding:30px; border-collapse: separate; border-spacing: 0;width:100%;">
    <input type="hidden" id="approval_seq" value="">
		<colgroup>
			<col width="15%" />
			<col width="30%" />
			<col width="25%" />
			<col width="30%" />
		</colgroup>
		<tr>
			<td colspan="4" class="modal_title" align="left" style="padding-bottom:40px; font-size:20px; font-weight:bold;">
				기안문작성
			</td>
    </tr>
    <tr class="t_top row-color1">
      <td height="40" align="center">No</td>
      <td align="center">시스템</td>
      <td align="center">서식함</td>
      <td align="center">양식명</td>
    </tr>
<?php
if(!empty($approval_doc_form)) {
$no = count($approval_doc_form);
foreach($approval_doc_form as $adf) { ?>
    <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="cursor:pointer;" onclick="go_approval('<?php echo $adf['seq']; ?>');">
      <td height="40" align="center"><?php echo $no; ?></td>
      <td align="center"><?php echo $adf['template_type']; ?></td>
      <td align="center"><?php echo $adf['category_name']; ?></td>
      <td align="center"><?php echo $adf['template_name']; ?></td>
    </tr>
<?php
$no--;
}
} ?>
		<tr>
			<td colspan="4" align="right" style="padding-top:20px;">
				<!--지원내용 추가 버튼-->
				<input type="button" class="btn-common btn-color1" style="width:70px;" value="취소" onclick="$('#approval_form').bPopup().close()">
			</td>
		</tr>
  </table>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
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
      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

   //거엄색!
   function GoSearch(){
      var searchkeyword = '';
      for ( i = 1; i <= $(".filtercolumn").length; i++) {
         if (i == 1) {
               searchkeyword += $("#filter" + i).val().trim();
         } else {
               var filter_val = $("#filter" + i).val().trim();
               if(i == 13 || i == 14){
                  filter_val = String(filter_val).replace(/,/g, "");
               }
               searchkeyword += ',' + filter_val;
         }
      }
      $("#searchkeyword").val(searchkeyword);

      if (searchkeyword.replace(/,/g, "") == "") {
         alert("검색어가 없습니다.");
         location.href="<?php echo site_url();?>/biz/official_doc/official_doc_list";
         return false;
      }

      document.cform.action = "<?php echo site_url();?>/biz/official_doc/official_doc_list";
      document.cform.cur_page.value = "1";
      document.cform.submit();
    }

    function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.cform.cur_page.value = "1";
		document.cform.lpp.value = lpp;
		document.cform.submit();
	}

  function official_doc_input_view() {
    location.href = "<?php echo site_url(); ?>/biz/official_doc/official_doc_input";
  }

  function ViewBoard(seq) {
    location.href = "<?php echo site_url(); ?>/biz/official_doc/official_doc_view?seq=" + seq;
  }

  var approvalSeq = [];

  function checkAll(el) {
    approvalSeq = [];
    if(el.checked == true) {
      $(".approvalRow").each(function() {
        $(this).attr("checked", "checked");
        $(this).closest('tr').addClass('approval_row');
        approvalCheck(this);
      })
    } else {
      $(".approvalRow").each(function() {
        $(this).removeAttr('checked');
        $(this).closest('tr').removeClass('approval_row');
        approvalCheck(this);
      })
    }
  }

  function approvalCheck(el) {
    var allCnt = $('.approvalRow').length;
    var tr = $(el).closest('tr');
    var seq = tr.attr('seq');

    var checkedCnt = $('.approvalRow').filter(':checked').length;

    if(allCnt == checkedCnt) {
      $('#allCheck').attr('checked', 'checked');
    } else {
      $('#allCheck').removeAttr('checked');
    }

    if(el.checked == true) {
      if(seq != undefined) {
        approvalSeq.push(seq);
      }
      tr.addClass('approval_row');
    } else {
      if(seq != undefined) {
        approvalSeq.splice($.inArray(seq, approvalSeq), 1);
      }
      tr.removeClass('approval_row');
    }
    // console.log(approvalSeq);
  }

  function annual_input() {
    var checkedCnt = $('.approvalRow').filter(':checked').length;
    approvalSeq = [];

    if(checkedCnt == 0) {
      alert('기안문에 첨부할 공문을 선택해주세요.');
      return false;
    } else {
      $('.approvalRow').each(function() {
        if($(this).is(':checked')) {
          approvalSeq.push($(this).attr('seq'));
        }
      });
      $('#approval_seq').val(approvalSeq.join('_'));
      // alert($('#approval_seq').val());
      $('#approval_form').bPopup();
    }
  }

  function go_approval(approval_seq) {
    location.href = "<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq=" + approval_seq + "&official_doc=" + $('#approval_seq').val();
  }

</script>
</body>
</html>

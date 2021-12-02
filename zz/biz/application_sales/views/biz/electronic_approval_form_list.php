<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  $mode = $_GET['mode'];
  $filter_text = $filter;
  $filter = explode(",",$filter);
  if($mode == "user"){
     //즐겨찾기 때문에 배열 순서 앞으로 땡겨
     if(empty($view_val) != true){
       for($i =0; $i<count($view_val); $i++){
          $form = $view_val[$i];
           if(strpos($form['bookmark'],','.$id)!== false){
              array_splice($view_val, $i, 1);
              array_unshift($view_val, $form);
           }
       }
     }
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

<script>
</script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
         <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
         <input type="hidden" name="mode" value="<?php echo $mode; ?>">
         <input type="hidden" name="filter" value="<?php echo str_replace('"', '&uml;',$filter_text); ?>">
      </form>
      <input type="hidden" id="seq" name="seq" value="">
      <!-- <input type="hidden" name="mode" value=""> -->
      <tbody height="100%">
        <!-- 타이틀 부분 시작 -->
        <tr height="5%">
          <td class="dash_title">
<?php
  if($mode == "admin"){
?>
            양식관리
<?php
  }else{
?>
            기안문작성
<?php
  }
?>
            <!-- <img src="<?php echo $misc;?>img/dashboard/title_weekly_report_list.png"/> -->
          </td>
        </tr>
        <!-- 타이틀 부분 끝 -->
        <!-- 검색 부분 시작 -->
        <tr height="7%">
          <td align="left" valign="bottom">
          <!-- <td width="100%" style="align:left; float:left"> -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;font-size:14px;margin-bottom:10px;">
              <tr>
                <td style="padding-top:20px;font-weight:bold">
                  서식명 : <select class="select-common select-style1 filter" onchange="categoryFilter();" style="margin-right:10px;">
                     <option value="">서식함</option>
                     <?php
                     foreach( $category as $ct){
                        echo "<option value='{$ct['seq']}'";
                        if(isset($_GET['filter'])){
                           if($ct['seq'] == $filter[0]){
                              echo "selected";
                           }
                        }
                        echo ">{$ct['category_name']}</option>";
                     }
                     ?>
                  </select>
                  양식명 : <input class="input-common filter" value="<?php if(isset($_GET['filter']) && count($filter) > 1){echo $filter[1];}?>" onKeypress="javascript:if(event.keyCode==13){categoryFilter();}"/>
                    <input type="button" class="btn-common btn-style1" value="검색" onclick="categoryFilter();" style="cursor:pointer;" >
                  <!-- <img src="<?php echo $misc?>img/dashboard/btn/btn_search.png" valign=top border=0 width="28" > -->
                </td>
                <td style="float:right;">
                  <?php
                    if($mode == "admin"){
                  ?>
                          <!-- <input type="button" align="center" value="양식작성" style="float:right;margin:20px 0px 20px 0px;" onclick="approval_form_input();" /> -->
                    <div style='margin-top:20px;'>
                          <!-- <img src="<?php echo $misc; ?>img/dashboard/btn/btn_form_input.png"/> -->
                          <input type="button" class="btn-common btn-color2" value="양식작성" onclick="approval_form_input();" style="cursor:pointer">
                    </div>
                  <?php
                    }else{?>
                      <div style='margin:20px 0px 0px 20px;text-align:left;'>
                        <input type="button" class="btn-common btn-color2" value="연차신청서 작성" onclick="annual_input_view()" style="width:130px;"/>
                      </div>
                  <?php }
                  ?>
                </td>
              </tr>
            </table>
          </td>
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
                      <table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <colgroup>
                        <?php if($mode != 'admin'){ ?>
                          <col width="15%">
                          <col width="5%">
                          <col width="15%">
                          <col width="10%">
                          <col width="20%">
                          <col width="20%">
                          <col width="15%">
                        <?php }else{ ?>
                          <col width="15%">
                          <col width="5%">
                          <col width="5%">
                          <col width="5%">
                          <col width="11%">
                          <col width="5%">
                          <col width="5%">
                          <col width="10%">
                          <col width="12%">
                          <col width="12%">
                          <col width="15%">
                        <?php }?>
                        </colgroup>
                        <tr class="t_top row-color1">
                          <th></th>
                          <th height="40" align="center">No.</th>
                          <th align="center">시스템</th>
                          <th align="center">서식함</th>
<?php
  if($mode != 'admin'){
?>
                          <th align="center">즐겨찾기</th>
<?php
  }
?>
                          <th align="center">양식명</th>
<?php
  if($mode == 'admin'){
?>
                          <th align="center">사용여부</th>
                          <th align="center">양식작성자</th>
                          <th align="center">양식수정자</th>
                          <th align="center">양식작성일</th>
                          <th align="center">양식수정일</th>
<?php
  }
?>

                          <th></th>
                        </tr>
<?php
  if(empty($view_val) != true){
    $idx = $count-$start_row;
    for($i = $start_row; $i<$start_row+$end_row; $i++){
       if(!empty( $view_val[$i])){
          $form = $view_val[$i];
?>
                        <tr  onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer;" onclick="eletronic_approval_view('<?php echo $form['seq']; ?>',event)">
                          <td></td>
                          <td height='40' align="center"><?php echo $idx; ?></td>
                          <td align="center"><?php echo $form['template_type']; ?></td>
                          <td align="center">
<?php
         foreach($category as $format_categroy){
           if($form['template_category'] == $format_categroy['seq']){
             echo $format_categroy['category_name'];
           }
         }
?>
                          </td>
<?php
          if($mode != 'admin'){
?>
                          <td align="center">
<?php
            if(strpos($form['bookmark'],','.$id)!== false){
?>
                            <img class='bookmark' src='<?php echo $misc; ?>img/star2.png' width='20' onclick='bookmark(<?php echo $form['seq']; ?>,1)'>
<?php
            }else{
?>
                            <img class='bookmark' src='<?php echo $misc; ?>img/star.png' width='20' onclick='bookmark(<?php echo $form['seq']; ?>,0)'>
<?php
            }
?>
                          </td>
<?php
          }
?>
                          <td align="center"><?php echo  $form['template_name']; ?></td>

<?php
          if($mode == 'admin'){
?>
                          <td align="center">
                            <?php
                                if($form['template_use'] == "Y"){
                                  echo "사용";
                                }else{
                                  echo "미사용";
                                }
                            ?>
                          </td>
                          <td align="center">
                          <?php echo $form['insert_id'] ;?>
                          </td>
                          <td align="center">
                          <?php echo $form['write_id'] ;?>
                          </td>
                          <td align="center">
                          <?php echo $form['insert_date'] ;?>
                          </td>
                          <td align="center">
                          <?php echo $form['update_date'] ;?>
                          </td>
<?php
          }
?>
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
                          <td height='40' colspan=5 >검색 결과가 존재하지 않습니다.</td>
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
        <tr>
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
                    <img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png"/>
                  </a>
                </td>
                <td width="2"></td>
                <td width="19">
                  <a href="JavaScript:GoLastPage()">
                    <img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" />
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

          </td>
         </tr>
        </td>
       </tr>
      </table>
<?php
  }
?>
        </td>
       </tr>
       <!-- 페이징 부분 끝 -->

      </td>
     </tr>
    </tbody>
   </table>
  </div>
 </div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
   function eletronic_approval_view(seq,e){
      if(!$(e.target).hasClass("bookmark")){
         <?php if($mode == "admin"){ ?>
         location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_form?seq="+seq+"&mode=modify";
         <?php }else{ ?>
         location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq="+seq;
         <?php }?>
      }
   }

   function bookmark(seq,type){
      if(type == 0){
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/form_bookmark",
            dataType: "json",
            async :false,
            data: {
               seq: seq,
               type:type
            },
            success: function (data) {
               alert("즐겨찾기 설정");
               location.reload();
            }
         });
      }else{
         $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/form_bookmark",
            dataType: "json",
            async :false,
            data: {
               seq: seq,
               type:type
            },
            success: function (data) {
               alert("즐겨찾기 설정 해제");
               location.reload();
            }
         });
      }
   }

   function approval_form_input(){
      location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_form?mode=input";
   }

   function categoryFilter(){
      var filter ='';
      for(var i=0; i < $(".filter").length; i++){
        if(i==0){
          filter = $(".filter").eq(i).val().trim();
        }else{
          filter += ","+ $(".filter").eq(i).val().trim();
        }
      }
      location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=<?php echo $mode; ?>&filter="+filter;
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
      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

   //연차신청서 쓰러가깅
   function annual_input_view(){
      location.href='<?php echo site_url();?>/biz/approval/electronic_approval_doc_input?seq=annual';
   }

</script>
</body>
</html>

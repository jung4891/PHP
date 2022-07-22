<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      /* border:1px solid; */
      border-color:#d7d7d7;
      padding:0px 10px 0px 10px;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   /* 모달 css */
   .searchModal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 10; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      z-index: 1002;
   }
      /* Modal Content/Box */
   .search-modal-content {
      background-color: #fefefe;
      margin: 15% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 70%; /* Could be more or less, depending on screen size */
      z-index: 1002;
   }

   ul{
      list-style:none;
      padding-left:0px;
   }

   li{
      list-style:none;
      padding-left:0px;
      margin-top:5px;
   }
   .content_dash_tbl td {
     /* border-bottom: none !important; */
   }
</style>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">

<script>
</script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_personal_storage_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" id="seq" name="seq" value="<?php echo $seq; ?>">
</form>
<div align="center">
  <div class="dash1-1">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <tbody>
        <tr>
          <td class="dash_title">
            <!-- <img src="<?php echo $misc; ?>img/dashboard/title_electronic_approval_personal_storage_list.png"/> -->
            개인보관함
          </td>
        </tr>
        <tr height="4%">
        </tr>
        <tr style="max-height:45%">
          <td colspan="2" valign="top" style="padding:10px 0px;">
            <table class="content_dash_tbl" style="border:none;" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top">
                  <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                    <tr>
                        <!-- 내용 -->
                        <td>
                          <table width="100%" height="100%" style="font-family:Noto Sans KR">
                              <tr>
                                <td width="20%">
                                    <div>
                                      <ul style="font-size:15px;">
                                          <li>
                                            <span style="cursor:pointer;<?php if($_GET['seq']== 'all'){ echo "background-color:#d3d3d3";} ?>" id="category" onclick="storageChange('all')">전체</span>
                                            <ul>
                                                <?php
                                                if(!empty($view_val)){
                                                  foreach($view_val as $val){
                                                    if($val['parent_id'] == 0 && $val['cnt'] == 0){ ?>
                                                      <div id="<?php echo $val['storage_name']; ?>">
                                                        <li>
                                                            <ins>&nbsp;</ins>
                                                            <span style="cursor:pointer;<?php if($val['seq'] == $_GET['seq']){ echo "background-color:#d3d3d3";} ?>" onclick="storageChange(<?php echo $val['seq']; ?>)"><ins>&nbsp;</ins>&nbsp;&nbsp;<?php echo $val['storage_name']; ?></span>
                                                        </li>
                                                      </div>
                                                  <?php
                                                    }else if($val['parent_id'] == 0 && $val['cnt'] > 0){ ?>
                                                      <div id="<?php echo $val['storage_name']; ?>">
                                                        <li style='cursor:pointer;'>
                                                            <img src="<?php echo $misc; ?>img/btn_add.jpg" class="Btn" width="13" style="cursor:pointer;" onclick="viewMore('<?php echo $val['seq']; ?>','<?php echo $val['storage_name']; ?>',this)">
                                                            <span style="cursor:pointer;<?php if($val['seq'] == $_GET['seq']){ echo "background-color:#d3d3d3";} ?>" onclick="storageChange(<?php echo $val['seq']; ?>)"><?php echo $val['storage_name']; ?></span>
                                                        </li>
                                                      </div>
                                                  <?php
                                                    }
                                                  }
                                                }else{
                                                  echo "<br>개인보관함이 없습니다. <br>개인보관함 관리에서 개인보관함을 설정해주세요.";
                                                }
                                                ?>
                                            </ul>
                                          </li>
                                      </ul>
                                    </div>
                                </td>
                                <td>
                                  <table class="list_tbl list" width="100%" style="font-family:Noto Sans KR" border="0" cellspacing="0" cellpadding="0">
                                    <tr class="t_top row-color1" align="center" >
                                      <th height=50 class="basic_td"><input type="checkbox" id="allCheck" /></th>
                                      <th class="basic_td">서식함</th>
                                      <th class="basic_td">문서번호</th>
                                      <th class="basic_td">문서제목</th>
                                      <th class="basic_td">기안자</th>
                                      <th class="basic_td">기안일</th>
                                      <th class="basic_td">완료일</th>
                                    </tr>
                                  <?php
                                  if(empty($view_val2) != true){
                                    $idx = $count-$start_row;
                                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                                      if(!empty( $view_val2[$i])){
                                        $val2 = $view_val2[$i];
                                        echo "<tr align='center'>
                                        <td height=50 class='basic_td'><input type='checkbox' id='doc_seq' name='doc_seq' value='{$val2['seq']}' /></td>
                                        <td height=50 class='basic_td'>";
                                        foreach($category as $format_categroy){
                                          if($val2['template_category'] == $format_categroy['seq']){
                                            echo $format_categroy['category_name'];
                                          }
                                        }
                                        echo "</td>
                                          <td height=50 class='basic_td'>{$val2['writer_group']}-{$val2['doc_num']}</td>
                                          <td height=50 class='basic_td' onclick='approval_view_move({$val2['seq']});' style='cursor:pointer;'>{$val2['approval_doc_name']}</td>
                                          <td height=50 class='basic_td'>{$val2['writer_id']}</td>
                                          <td height=50 class='basic_td'>{$val2['write_date']}</td>
                                          <td height=50 class='basic_td'>{$val2['completion_date']}</td>
                                        </tr>";
                                        $idx --;
                                      }
                                    }
                                  }else{
                                    echo "<tr class='basic_td' align='center'><td colspan='7' height=50 class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
                                  }
                                  ?>
                                  </table>
                                </td>
                              </tr>
                               <!-- 페이징처리 -->
                              <tr>
                                  <td></td>
                                  <td align="center">
                                  <?php if ($count > 0) {?>
                                        <table width="400" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;">
                                              <tr>
                                        <?php
                                          if ($cur_page > 10){
                                        ?>
                                              <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/btn_prev.jpg" /></a></td>
                                              <td width="2"></td>
                                              <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/btn_left.jpg" /></a></td>
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
                                                    $strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
                                          <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/btn_right.jpg"/></a></td>
                                              <td width="2"></td>
                                              <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/btn_next.jpg" /></a></td>
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
                          <?php if($_GET['seq'] != "all"){ ?>
                          <div style="float:right;margin-top:20px;">
                            <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_move.png" style="cursor:pointer;margin-left:5px;" border="0" onclick="moveDoc();"/> -->
                            <!-- <img src="<?php echo $misc;?>img/dashboard/btn/btn_delete.png" style="cursor:pointer;margin-left:5px;" border="0" onclick="deleteDoc();"/> -->
                            <input type="button" class="btn-common btn-color1" value="이동" style="cursor:pointer;margin-left:5px;" border="0" onclick="moveDoc();">
                            <input type="button" class="btn-common btn-color2" value="삭제" style="cursor:pointer;margin-left:5px;" border="0" onclick="deleteDoc();">
                            <!-- <input type="button" class="basicBtn" value="이동" style="width:61px;cursor:pointer;" onclick="moveDoc();"/> -->
                            <!-- <input type="button" class="basicBtn" value="삭제" style="width:61px;cursor:pointer;" onclick="deleteDoc();"/> -->
                          </div>
                          <?php } ?>
                        </td>
                        <!--내용-->
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
   //보관함 전체열어!!!!!!!!
   $(".Btn").trigger("click");

   //개인보관함 열기 +버튼 눌러서 하위 목록 보기
   function viewMore(seq,id,obj){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewHide('"+id+"',this)");
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/biz/approval/storageView",
         dataType: "json",
         async :false,
         data: {
            seq:seq
         },
         success: function (result) {
            var html = "<ul style='margin-left:20px;'>";
            for(i=0; i<result.length; i++){
               if(result[i].cnt > 0){
                  html += "<div id='"+result[i].storage_name+"'>";
                  html += "<li>";
                  html += "<img src='<?php echo $misc; ?>img/btn_add.jpg' class='Btn' width='13' style='cursor:pointer;' onclick='viewMore("+result[i].seq+","+'"'+result[i].storage_name+'"'+",this)'>";
                  html += "<span onclick='storageChange("+result[i].seq+");' style='cursor:pointer;";
                  if(result[i].seq == "<?php echo $_GET['seq']; ?>"){
                    html += "background-color:#d3d3d3;";
                  }
                  html += "'>"+result[i].storage_name+"</span></li>";
                  html += "</div>";
               }else{
                  html += "<div id='"+result[i].storage_name+"'>"
                  html += "<li>";
                  html += "<ins>&nbsp;</ins>";
                  html += "<span onclick='storageChange("+result[i].seq+");' style='cursor:pointer;";
                  if(result[i].seq == "<?php echo $_GET['seq']; ?>"){
                    html += "background-color:#d3d3d3;";
                  }
                  html += "'><ins>&nbsp;</ins>&nbsp;&nbsp;"+result[i].storage_name+"</></li>";
                  html += "</div>";
               }
            }
            html += "</ul>"
            $("#"+id).html($("#"+id).html()+html);
            for(i=0; i<$("#"+id).find($("img")).length; i++){
               if($("#"+id).find($("img")).eq(i).attr('src') == '<?php echo $misc; ?>img/btn_add.jpg'){
                  $("#"+id).find($("img")).eq(i).trigger("click");
               }
            }
         }
      });
   }

   //개인보관함 숨기기
   function viewHide(id,obj){
      var src = "<?php echo $misc; ?>img/btn_add.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewShow('"+id+"',this)");
      $("#"+id).find($("div")).hide();
   }

   //개인보관함 다시열어!
   function viewShow(id,obj){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewHide('"+id+"',this)");
      $("#"+id).find($("div")).show();
   }

   //보관함 클릭
   function storageChange(seq){
     location.href = "<?php site_url(); ?>/index.php/biz/approval/electronic_approval_personal_storage_list?seq="+seq;
   }

   $(function () { //전체선택 체크박스 클릭
     $("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우
       if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
         $("input[name=doc_seq]").prop("checked", true); // 전체선택 체크박스가 해제된 경우
       } else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
         $("input[name=doc_seq]").prop("checked", false);
       }
     })
   })

  //문서 삭제
  function deleteDoc(){
    if($('input:checkbox[name="doc_seq"]:checked').length!=0){
      if (confirm("삭제하시겠습니까?")) {
        $('input:checkbox[name="doc_seq"]').each(function () {
          if (this.checked == true) {
            $.ajax({
              type: "POST",
              cache: false,
              url: "<?php echo site_url(); ?>/biz/approval/storage_doc_delete",
              dataType: "json",
              async: false,
              data: {
                storage_seq : <?php echo $_GET['seq']; ?>,
                delete_doc_seq: "," + this.value
              },
              success: function (result) {
                if(result){
                  alert("삭제 되었습니다.");
                  location.reload();
                }else{
                  alert("삭제 실패");
                }
              }
            });
          }
        });
      } else {
        return false;
      }
    } else {
      alert("문서를 선택해주세요");
      return false;
    }
  }

  //문서 이동
  function moveDoc(){
    if($('input:checkbox[name="doc_seq"]:checked').length!=0){
      var move_seq = "";
      $('input:checkbox[name="doc_seq"]').each(function () {
        if (this.checked == true) {
          $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/biz/approval/storage_doc_delete",
            dataType: "json",
            async: false,
            data: {
              storage_seq : <?php echo $_GET['seq']; ?>,
              delete_doc_seq: "," + this.value
            },
            success: function (result) {
            }
          });
          if(move_seq == ""){
            move_seq += this.value;
          }else{
            move_seq += ','+ this.value;
          }
        }else {
          return false;
        }
      });
      window.open("<?php echo site_url(); ?>/biz/approval/electronic_approval_personal_storage_popup?seq="+move_seq, "popup_window", "width = 500, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
    } else {
      alert("문서를 선택해주세요");
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
      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

   //기안문보러가기
   function approval_view_move(seq){
      location.href="<?php echo site_url();?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=completion";
   }

</script>
</body>
</html>

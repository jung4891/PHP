<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  
  // 체크해놓은 seq 가져오기
  $checkSeq ='';
  if(isset($_GET['check_seq']) && $_GET['check_seq']!=''){
    $checkSeq = explode(',',$_GET['check_seq']);
  }
?>
<script language="javascript">

window.onload=function(){
   change();
}

function change() {
  var search1 = document.getElementById("search1").value;

  if (search1 == '007') {
    $("#searchkeyword").prop("type", "date");
  } else {
    $("#searchkeyword").prop("type", "text");
  }

  if(search1 == '006'){
    $("#searchkeyword").attr("placeholder", "승인: y , 미승인: n");
  }else{
    $("#searchkeyword").attr("placeholder", "검색하세요."); 
  }

  if (search1 == '004') { //장비명
    $("#searchkeyword2").prop("type", "text");
  } else {
    $("#searchkeyword2").prop("type", "hidden");
  }


}

function GoSearch(){
  var searchkeyword = document.mform.searchkeyword.value;
  var searchkeyword = searchkeyword.trim();

  var searchkeyword2 = document.mform.searchkeyword2.value;
  var searchkeyword2 = searchkeyword2.trim();

  if(searchkeyword == ""){
    alert( "검색어를 입력해 주세요." );
    return false;
  }

  document.mform.action = "<?php echo site_url();?>/tech_board/request_tech_support_list";
  document.mform.cur_page.value = "";
  document.mform.submit();
}

</script>
<script language="javascript">
function GoFirstPage (){
  $("input[name=check]").attr("disabled",true);
  document.mform.cur_page.value = 1;
  document.mform.submit();
}

function GoPrevPage (){
  $("input[name=check]").attr("disabled",true);
  var cur_start_page = <?php echo $cur_page;?>;

  document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
  document.mform.submit( );
}

function GoPage(nPage){
  $("input[name=check]").attr("disabled",true);
  document.mform.cur_page.value = nPage;
  document.mform.submit();
}

function GoNextPage (){
  $("input[name=check]").attr("disabled",true);
  var cur_start_page = <?php echo $cur_page;?>;
  document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
  document.mform.submit();
}

function GoLastPage (){
  $("input[name=check]").attr("disabled",true);
  var total_page = <?php echo $total_page;?>;
  document.mform.cur_page.value = total_page;
  document.mform.submit();
}

function ViewBoard(seq){
  $("input[name=cur_page]").attr("disabled",true);
  $("#search1").attr("disabled",true);
  $("input[name=searchkeyword]").attr("disabled",true);
  $("input[name=searchkeyword2]").attr("disabled",true);
  document.mform.action = "<?php echo site_url();?>/tech_board/request_tech_support_view";
  document.mform.seq.value = seq;
  document.mform.mode.value = "view";

  document.mform.submit();
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/tech_board/request_tech_support_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" id ="seq" name="seq" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" id="check_seq" name="check_seq" value="<?php if(isset($_GET['check_seq'])){ echo $_GET['check_seq']; } ?>"/>
<input type="hidden" id="file_change_name" name="file_change_name" value="<?php if(isset($_GET['file_change_name'])){ echo $_GET['file_change_name']; } ?>"/>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
?>
  <tr>
    <td align="center" valign="top">
    
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <tr>
                <td class="title3">기술지원요청</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="48%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                    <select name="search1" id="search1" class="input" onChange="change();">
                    <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
                    <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>협력사</option>
                    <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>사업장명</option>
                    <option value="004" <?php if($search1 == "004"){ echo "selected";}?>>장비명</option>
                    <option value="009" <?php if($search1 == "009"){ echo "selected";}?>>serial</option>
                    <option value="005" <?php if($search1 == "005"){ echo "selected";}?>>진행단계</option>
                    <option value="006" <?php if($search1 == "006"){ echo "selected";}?>>최종승인</option>
                    <option value="007" <?php if($search1 == "007"){ echo "selected";}?>>설치일자</option>
                    <option value="008" <?php if($search1 == "008"){ echo "selected";}?>>세금계산서</option>
                    <!-- <option value="009" <?php if($search1 == "009"){ echo "selected";}?>>serial</option> -->
                  </select>
                    </td>
                    <td><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input  type="text" size="25" class="input2" id="searchkeyword" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/></td>
                        <td><input  type="hidden" size="25" class="input2" name="searchkeyword2" id="searchkeyword2" placeholder="버전명을 입력하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword2 );?>" /></td>
                        <td><input type="image" style='cursor:hand' onClick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                        <!-- <td><input type="hidden" id="mail_send" name="mail_send" value="<?php echo str_replace('"', '&uml;', $mail_send );?>"></td> -->
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="12" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td width="5%" height="40" align="center">No.</td>
                    <td width="10%" align="center" class="t_border">고객사</td>
                    <td width="10%" align="center" class="t_border">협력사</td>
                    <td width="10%" align="center" class="t_border">사업장명</td>
                    <td width="10%" align="center" class="t_border">장비명</td>
                    <td width="10%" align="center" class="t_border">설치요청일</td>
                    <td width="10%" align="center" class="t_border">설치일</td>
                    <td width="10%" align="center" class="t_border">장비배송일</td>
                    <td width="5%" align="center" class="t_border">진행단계</td>
                    <td width="5%" align="center" class="t_border">세금계산서</td>
                    <td width="5%" align="center" class="t_border">최종승인</td>
                    <td width="5%" align="center" class="t_border">첨부</td>
                  </tr>
                  <tr>
                    <td colspan="12" height="1" bgcolor="#797c88"></td>
                  </tr>
                  <?php
                    if ($count > 0) {
                      $i = $count - $no_page_list * ( $cur_page - 1 );
                      $icounter = 0;
                      
                      foreach ( $list_val as $item ) {
              
                      if($item['file_change_name']) {
                        $strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
                      } else {
                        $strFile = "-";
                      }   
                  ?>
                  <tr onMouseOver="this.style.backgroundColor='#EAEAEA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td height="40" align="center">
                      <?php if($lv == 3){ ?>
                        <input type="checkbox" name="check" value="<?php echo $item['seq'];?>" onchange="checkSeq(this,<?php echo $item['seq'];?>,'<?php echo $item['file_change_name'];?>')" <?php if($checkSeq <> ""){if(in_array($item['seq'],$checkSeq)){echo "checked";};} ?> />
                      <?php } ?>
                      <?php echo $i;?>
                    </td>
                   
                    <td align="center" class="t_border">
                      <a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')">
                        <?php echo $item['customer_company'];?> 
                      </a>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['cooperative_company'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['workplace_name'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['produce'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php if($item['installation_request_date'] != "0000-00-00"){echo $item['installation_request_date'];}else{echo "일정협의";}?>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['installation_date'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['delivery_date'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['result'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php echo $item['tax'];?>
                    </td>
                    <td align="center" class="t_border">
                        <?php if($item['final_approval'] =='N'){echo "미승인";}else{echo "승인";} ?>
                    </td>
                    <td align="center" class="t_border">
                      <?php echo $strFile; ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="12" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
      <?php
            $i--;
            $icounter++;
          }
        } else {
      ?>
        <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="6">등록된 게시물이 없습니다.</td>
                  </tr>
                  <tr>
                    <td colspan="12" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
      <?php
        } 
      ?>
                  <tr>
                    <td colspan="12" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr> 

             <!---------------------------------- 글쓰기 버튼넣기------------------------------>
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td align="right">
                  <?php if(substr($at,0,1) == 2 || substr($at,0,1) == 3 || substr($at,0,1) == 6 || substr($at,0,1) == 7 ){ ?>
                  <input type="text" id="tax_num" style="float:left;display:none;">
                  <input type="button" class="basicBtn" value="승인번호 입력" style="float:left;" onclick="changeBtn(this);">
                  <input type="button" id="taxBtn" class="basicBtn" value="승인번호 저장" style="float:left;display:none;margin-left:5px;" onclick="tax();">
                  <input type="button" class="basicBtn" value="최종승인" style="float:left;margin-left:5px;" onclick="finalApproval();" />
                  <img src="<?php echo $misc;?>img/btn_delete.jpg" width="64" height="31" style="float:left;margin-left:5px;" onclick="delete_request_tech_support();"/> 
                  <a href="<?php echo site_url();?>/tech_board/request_tech_support_input">
                    <img src="<?php echo $misc;?>img/btn_write.jpg" width="64" height="31" />
                  </a>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
               <!---------------------------------- 글쓰기 버튼넣기------------------------------>
              <tr>
                <td align="center">
<?php if ($count > 0) {?>
        <table width="400" border="0" cellspacing="0" cellpadding="0">
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
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>            
            </td>
        </tr>
     </table>
</form>
    </td>
  </tr>
  <tr>
    <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >      
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
</table>
<script>
  function checkSeq(obj,seq,filename){
    if($(obj).is(":checked")==true){
      if($("#check_seq").val() == ""){
        $("#check_seq").val($("#check_seq").val()+seq);
        $("#file_change_name").val($("#file_change_name").val()+filename);
      }else{
        $("#check_seq").val($("#check_seq").val()+","+seq);
        $("#file_change_name").val($("#file_change_name").val()+","+filename);
      }
    }else{
      if($("#check_seq").val().indexOf(","+seq) != -1) {
        $("#check_seq").val($("#check_seq").val().replace(","+seq,''));
        $("#file_change_name").val($("#file_change_name").val().replace(","+filename,''));
      }else if($("#check_seq").val().indexOf(seq+",") != -1){
        $("#check_seq").val($("#check_seq").val().replace(seq+",",''));
        $("#file_change_name").val($("#file_change_name").val().replace(filename+",",''));
      }else{
        $("#check_seq").val($("#check_seq").val().replace(seq,''));
        $("#file_change_name").val($("#file_change_name").val().replace(filename,''));
      }
    }
  }

  function finalApproval(){
    var result = confirm("최종승인 하시겠습니까?");
    if(result){
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/ajax/finalApproval",
        dataType: "json",
        async: false,
        data: {
          seq: $("#check_seq").val()
        },
        success: function (data) {
          if(data){
            alert('승인완료');
            location.href = "<?php echo site_url(); ?>/tech_board/request_tech_support_final_approval_mail?seq="+$("#check_seq").val();
          }else{
            alert('승인오류');
          }
        }
      });
    }else{
      location.href = "<?php echo site_url(); ?>/tech_board/request_tech_support_list";
    }
  }

  function tax(){
    if($("#check_seq").val() == ''){
      alert("승인번호를 입력 할 게시물을 선택해주세요.");
    }else{
      var result = confirm("세금계산서 승인번호를 저장하시겠습니까?");
      if(result){
        $.ajax({
          type: "POST",
          cache: false,
          url: "<?php echo site_url(); ?>/ajax/taxNumber",
          dataType: "json",
          async: false,
          data: {
            seq: $("#check_seq").val(),
            tax: $("#tax_num").val()
          },
          success: function (data) {
            if(data){
              alert('세금계산서 승인번호 저장');
              location.href = "<?php echo site_url(); ?>/tech_board/request_tech_support_list";
            }else{
              alert('세금계산서 승인번호 저장오류');
            }
          }
        });
      }else{
        location.href = "<?php echo site_url(); ?>/tech_board/request_tech_support_list";
      }
    }
  }
  
  function changeBtn(obj){
    $(obj).hide();
    $("#tax_num").show();
    $("#taxBtn").show();
  }

  function delete_request_tech_support(){
    if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        location.href = "<?php echo site_url();?>/tech_board/request_tech_support_delete_action?seq="+$("#check_seq").val()+"&file_change_name="+$("#file_change_name").val();
        // mform.submit();      
        // return false;
    }
  }
</script>

</body>
</html>
 

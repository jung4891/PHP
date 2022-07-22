<?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
echo $at;

$g_member = array();
foreach($group_member as $member){
  array_push( $g_member, $member['user_name'] );
}

/////////////////////     읽기 권한    /////////////////////
if(substr($at,0,1) < 4){ //본인 읽기 권한 x
  if ($view_val['writer'] == $name){
    echo "<script>alert('본인 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
    echo exit;
  }else{
    if(substr($at,1,1) < 4){//같은팀 읽기 권한 없음
      if (in_array($view_val['writer'], $g_member)) {//같은팀
        echo "<script>alert('같은 부서 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
        echo exit;
      }else{// 같은팀x
        if(substr($at,2,1) < 4){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }else{
      if(substr($at,2,1) < 4){
        if(!in_array($view_val['writer'], $g_member)){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }
  }
}else{
  if ($view_val['writer'] != $name){
    if(substr($at,1,1) < 4){//같은팀 읽기 권한 없음
      if (in_array($view_val['writer'], $g_member)) {//같은팀
        echo "<script>alert('같은 부서 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
        echo exit;
      }else{// 같은팀x
        if(substr($at,2,1) < 4){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }else{
      if(substr($at,2,1) < 4){
        if(!in_array($view_val['writer'], $g_member)){
          echo "<script>alert('다른 사용자 글에 읽기 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }
  } 
}
/////////////////////     읽기 권한 끝    /////////////////////

?>

<script language="javascript">
  function chkForm( type ) {
    if(type == 1) {
      if (confirm("정말 삭제하시겠습니까?") == true){
        var mform = document.cform;
        mform.action="<?php echo site_url();?>/durian_car/car_drive_delete_action";
        mform.submit();
        return false;
      }
    }
    else if(type == 2) {
      //var mform = document.cform;

      // mform.action="<?php echo site_url();?>/tech_board/tech_doc_print_action";
      window.open("<?php echo site_url();?>/tech_board/tech_doc_print_action?seq=<?php echo $_GET['seq']?>", "cform", 'scrollbars=yes,width=760,height=600'); 
      //mform.submit();
      return false;
    } else {
      var mform = document.cform;
      mform.action="<?php echo site_url();?>/durian_car/car_drive_view";
      mform.submit();
      return false;
    }
  }

</script>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
    <?php
      include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
    ?>
  <tr>
    <td align="center" valign="top">
      <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
     <td width="923" align="center" valign="top">
      <!-- 시작합니다. 여기서 부터  -->
      <form name="cform" method="get">
        <input type="hidden" name="seq" value="<?php echo $seq;?>">
        <input type="hidden" name="mode" value="modify">
        <table width="890" border="0" style="margin-top:20px;">
          <tr>
            <td class="title3">차량운행일지 보기</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="5" height="2" bgcolor="#797c88"></td>
              </tr>
               <tr>
                 <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >차량</td>
                 <td width="35%" style="padding-left:10px;"  class="t_border" ><?php echo $view_val['carname'];?></td>
                 <td idth="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >운행일</td>
                 <td width="35%" align="center"class="t_border"  ><?php echo $view_val['drive_date'];?></td>
               </tr>
               <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>

              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발지</td>
                <td width="35%" style="padding-left:10px;"class="t_border"><?php echo $view_val['d_point'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >목적지</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['a_point'];?></td>
              </tr>
             <tr>
              <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
            </tr>

              <tr>
                <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발시간</td>
                <td width="35%" style="padding:10px;"class="t_border" ><?php echo $view_val['d_time'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"  >도착시간</td>
                <td width="35%" style="padding:10px;" class="t_border" ><?php echo $view_val['a_time'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >출발시km</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['d_km'];?> km</td>
                <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >도착시km</td>
                <td  style="padding:10px;" class="t_border" ><?php echo $view_val['a_km'];?> km</td>
              </tr>
             <tr>
              <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
            </tr>

              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >주행자</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['driver'];?></td>
                <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >등록자</td>
                <td width="35%" style="padding-left:10px;" class="t_border" ><?php echo $view_val['writer'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >주유비</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['oil'];?></td>
                <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >기타</td>
                <td  style="padding-left:10px;" class="t_border" ><?php echo $view_val['etc'];?></td>
              </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
            <tr>
              <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >운행목적</td>
              <td colspan="3"  style="padding-left:10px;" class="t_border" ><?php echo $view_val['drive_purpose'];?>
              </td>
            </tr>
              <tr>
                <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right">

              <img src="<?php echo $misc;?>img/btn_list.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/>
              <img src="<?php echo $misc;?>img/btn_adjust.jpg" id="modifyBtn" style="cursor:pointer" border="0" onClick="javascript:chkForm(0);return false;"/> <img src="<?php echo $misc;?>img/btn_add_column4.jpg" id="deleteBtn" style="cursor:pointer" border="0" onClick="javascript:chkForm(1);return false;"/></td>



              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>


          </td>
          
        </tr>
      </table>

    </td>
  </tr>

	</form>

<!-- 폼 끝 -->

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
    /////////////////////////////////    권한에 따라 수정 삭제 버튼  display:none   //////////////////////////////////////
    <?php
  if(substr($at,0,1) != 1 && substr($at,0,1) != 3 && substr($at,0,1) != 5 && substr($at,0,1) != 7){ //본인 수정 권한 x
      if ($view_val['writer'] == $name){
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php

      }else{
        if(substr($at,1,1) != 1 && substr($at,1,1) != 3 && substr($at,1,1) != 5 && substr($at,1,1) != 7){//같은팀 수정 권한 없음
          if (in_array($view_val['writer'], $g_member)) {//같은팀
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php
          }else{// 같은팀x
            if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php            
            }
          }
        }else{
          if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
            if(!in_array($view_val['writer'], $g_member)){
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php
            }
          }
        }
      }
    }else{
      if ($view_val['writer'] != $name){
        if(substr($at,1,1) != 1 && substr($at,1,1) != 3 && substr($at,1,1) != 5 && substr($at,1,1) != 7){//같은팀 수정 권한 없음
          if (in_array($view_val['writer'], $g_member)) {//같은팀
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php
          }else{// 같은팀x
            if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php
            }
          }
        }else{
          if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
            if(!in_array($view_val['writer'], $g_member)){
  ?>
  $("#modifyBtn").hide();
  $("#deleteBtn").hide();
  <?php
            }
          }
        }
      } 
    }
  ?> 
</script>

</body>
</html>


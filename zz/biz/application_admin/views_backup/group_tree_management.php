<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
  ul{
   list-style:none;
   }
</style>

<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="mform" action="<?php echo site_url();?>/account/user" method="get"
      onkeydown="if(event.keyCode==13) return GoSearch();">
      <tr>
        <td height="203" align="center" background="<?php echo $misc;?>img/customer04_bg.jpg">
          <table width="1130" cellspacing="0" cellpadding="0">
            <tr>
              <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
              <td align="right">
                <table width="15%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right">
                      <?php if( $id != null ) {?>
                      <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a>
                      님 | <a href="<?php echo site_url();?>/account/logout"><img
                          src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
                      <?php } else {?>
                      <a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg"
                          align="absmiddle" /></a>
                      <?php }?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/admin_title.png"
                    width="197" height="173" /></a>
              </td>
              <td align="center" class="title1">고객의 미래를 생각하는 기업
                <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr style="height: 0px;">
        <td width="197" valign="top" style="background-color: #666666">

          <div id='cssmenu'>
            <ul>
              <li style="float: left"><a href='<?php echo site_url();?>/account/user'><span>회원정보</span></a></li>
              <!--<li class='has-sub'><a href='#'><span>자료실</span></a>
                  <ul>
                     <li><a href='#'><span>매뉴얼</span></a>
                     </li>
                     <li><a href='#'><span>교육자료</span></a>
                     </li>
                  </ul>
               </li>-->
              <li style="float: left"><a
                  href='<?php echo site_url();?>/company/companynum_list'><span>사업자등록번호</span></a>
              </li>
              <li style="float: left"><a href='<?php echo site_url();?>/company/product_list'><span>제품명</span></a></li>
              <li style="float: left"><a href='<?php echo site_url();?>/customer/customer_list'><span>거래처</span></a>
              </li>
              <li class="last" style="float: left"><a
                  href='<?php echo site_url();?>/customer/sourcing_list'><span>Sourcing Group</span></a></li>
              <li class="last" style="float: left"><a href='<?php echo site_url();?>/account/group_tree_management'><span class="point">조직도 관리</span></a></li>
            </ul>
          </div>
        </td>
      </tr>

      <!-- 여기서부터 조직도 -->
      <tr height="100"></tr>
      <tr>
        <td>
        <table>
          <tr>
            <td valign="top">
              <div id="groupTree" >
                <ul>
                  <li>
                    <span style="cursor:pointer;" id="all" onclick="groupView(this)">
                      (주)두리안정보기술
                    </span>
                    <ul>
                    <?php
                    foreach ( $view_val as $parentGroup ) {
                      if($parentGroup['childGroupNum'] <= 1){
                    ?>
                      <li id="<?php echo $parentGroup['groupName'];?>">
                        <ins>&nbsp;</ins>
                        <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                          <ins>&nbsp;</ins>
                          <?php echo $parentGroup['groupName'];?>
                        </span>
                      </li>
                    <?php
                    }else{
                    ?>
                      <li id="<?php echo $parentGroup['groupName'];?>">
                        <img src="<?php echo $misc; ?>img/btn_add.jpg" id="<?php echo $parentGroup['groupName'];?>Btn" width="13" style="cursor:pointer;" onclick="viewMore(this)">
                        <span style="cursor:pointer;" id="<?php echo $parentGroup['groupName'];?>" onclick="groupView(this)">
                          <?php echo $parentGroup['groupName'];?>
                        </span>
                      </li>
                    <?php
                    }
                    }
                    ?>
                    </ul>
                  </li>
                </ul>
                <?php if($at == "777") {?>
                  <div style="margin-top:80px;margin-left:40px;"><input type="button" class="input" value="부서관리" onclick="groupManagementBtn();" /></div>
                  <div><input type="button" class="input" value="사이트관리" style="float:right;margin-left:10px;" onclick="pageManagement();"></div>
                <?php } ?>
              </div>
            </td>
            <td width="300">
            </td>
            <td>
              <div>
                <table id="groupMember" >
                </table>
              </div>
              <?php if($at == "777") {?>
                <div style="margin-top:80px"><input type="button" class="input" value="부서이동" onclick="changeGroupBtn();" style="float:right;margin-left:10px;"></input><input type="button" class="input" value="권한관리" style="float:right;margin-left:10px;" onclick="changeLevelBtn();"></input><input type="button" class="input" value="부서별권한관리" style="float:right;margin-left:10px;" onclick="groupChangeLevelBtn();"/></div>
              <?php } ?>  
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr height="50"></tr>
      <!--//하단-->
    </form>
  </table>

</body>
<script>
groupView();

//상위 그룹에서 하위 그룹 보기
function viewMore(button){
  var parentGroup = (button.id).replace('Btn','');
  if($(button).attr("src")==="<?php echo $misc; ?>img/btn_add.jpg"){
    var src = "<?php echo $misc; ?>img/btn_del0.jpg";
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/ajax/childGroup",
      dataType: "json",
      async: false,
      data: {
        parentGroup:parentGroup
      },
      success: function (data) {
        var text = '<ul id="'+parentGroup+'Group" >';
        for(i=0; i<data.length; i++){
            text += '<li><ins>&nbsp;</ins><span style="cursor:pointer;" id="'+data[i].groupName+'" onclick="groupView(this)"><ins>&nbsp;</ins>'+data[i].groupName+'</span></li>';
        }
        text += '</ul>'
        $("#"+parentGroup).html($("#"+parentGroup).html()+text);

      }
    }); 
  }else{
    var src = "<?php echo $misc; ?>img/btn_add.jpg";
    $("#"+parentGroup+"Group").hide();
  }
  $("#"+parentGroup+"Btn").attr('src', src); 
}

//그룹 클릭했을 떄 해당하는 user 보여주기
function groupView(group){
  if(group == undefined){
    var groupName = "all";
  }else{
    var groupName = $(group).attr("id");
  }
  
  $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/ajax/groupView",
      dataType: "json",
      async: false,
      data: {
        group:groupName
      },
      success: function (data) {
        var text = "";
        for(i=0; i<data.length; i++){
          if( i%2 ==0 ){
            text += "<tr><td><input name='checkMember' type='checkbox' value='"+data[i].seq+"'></td><td><img src='<?php echo $misc; ?>img/person.png' width=50 style='margin-right:10px;'></td><td><div>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div><br><div>"+data[i].user_tel+"</div><div>"+data[i].user_email+"</div></td><td width='200'></td>"
          }else{
            text += "<td><input name='checkMember' type='checkbox' value='"+data[i].seq+"'></td><td><img src='<?php echo $misc; ?>img/person.png' width=50 style='margin-right:10px;'></td><td><div>"+data[i].user_name+" "+data[i].user_duty+" "+data[i].user_group+"</div><br><div>"+data[i].user_tel+"</div><div>"+data[i].user_email+"</div></td></tr><tr height='40px'></tr>"
          }
        }
        $("#groupMember").html(text);

      }
  });
}

function changeGroupBtn() {
  var checkMember ="";
  $("input[name=checkMember]:checked").each(function(){
    checkMember += ',' + $(this).val() ;
  });
  if(checkMember == ''){
    alert("수정 할 인원을 체크 하세요")
    return false;
  }
  // checkMember = checkMember.substring(0,checkMember.length-1);
  window.open('<?php echo site_url();?>/account/group_change?seq='+checkMember,'_blank','top=100px, left=100px, height=500px, width=800px');
}

function changeLevelBtn() {
  var checkMember ="";
  $("input[name=checkMember]:checked").each(function(){
    checkMember += ',' + $(this).val() ;
  });

  if(checkMember == ''){
    alert("수정 할 인원을 체크 하세요")
    return false;
  }
  // checkMember = checkMember.substring(0,checkMember.length-1);
  window.open('<?php echo site_url();?>/account/level_change?seq='+checkMember,'_blank','top=100px, left=100px, height=500px, width=800px');
}

function groupChangeLevelBtn(){
  window.open('<?php echo site_url();?>/account/group_level_change?','_blank','top=100px, left=100px, height=500px, width=800px');
}

function groupManagementBtn(){
  window.open('<?php echo site_url();?>/account/group_management','_blank','top=100px, left=100px, height=500px, width=800px');
}

function pageManagement(){
  window.open('<?php echo site_url();?>/account/page_management','_blank','top=100px, left=100px, height=500px, width=800px');
}
</script>

</html>


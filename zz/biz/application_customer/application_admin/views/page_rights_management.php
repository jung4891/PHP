<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<style>
  input {
    border: none;
    border-right: 0px;
    border-top: 0px;
    border-left: 0px;
    border-bottom: 0px;
  }

  #trPlusBtn {
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .adddelbtn {
    border: none;
    border-right: 0px;
    border-top: 0px;
    border-left: 0px;
    border-bottom: 0px;
    margin: 0px;
    padding: 0px;
  }
  .title{
    font-family: 'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif;
    line-height: 150%;
    font-size: 15px;
    margin-right : 10px;
  }
</style>
<body>
  <div style="margin:20px 20px 100px 20px;">
  <?php 
      foreach($pageList as $page){
        if($page['seq'] == $_GET['seq']){
          $group = $page['group_authority'];
          $groupAthority = explode('|',$page['group_authority']);
          $groupCount = count($groupAthority);
          if($page['default_authority'] == ''){
            $defaultAuthority[0] = "000";
            $defaultAuthority[1] = "000";
            $defaultAuthority[2] = "000";
          }else{
            $defaultAuthority = explode(',',$page['default_authority']);
          }
          echo '<input type="hidden" value="'.$page['seq'].'">'.'<span style="font-size:30px;">'.$page['page_address'].'</span>';
        }
      } 
  ?>  
  </div>
  <div style="margin:20px 20px 20px 20px;">
      <select class="input2">
        <option checked>기본권한</option>
      </select>
      <table style="text-align:center;">
        <tr>
          <th height="30" width=200 bgcolor="f8f8f9">대상</th>
          <th height="30" width=200 bgcolor="f8f8f9">일반</th>
          <th height="30" width=200 bgcolor="f8f8f9">팀관리자</th>
          <th height="30" width=200 bgcolor="f8f8f9">관리자</th>
        </tr>
        <tr>
          <td>본인</td>
          <td>읽기<input type="checkbox" name="rwx1" value="4" <?php if((int)substr($defaultAuthority[0],0,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx1" value="2" <?php if((int)substr($defaultAuthority[0],0,1)>=2 && (int)substr($defaultAuthority[0],0,1)!=4  && (int)substr($defaultAuthority[0],0,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx1" value="1" <?php if((int)substr($defaultAuthority[0],0,1)>=1 && (int)substr($defaultAuthority[0],0,1)!=2  && (int)substr($defaultAuthority[0],0,1)!=4 && (int)substr($defaultAuthority[0],0,1)!=6){ echo 'checked';} ?>/></td>
          <td>읽기<input type="checkbox" name="rwx2" value="4" <?php if((int)substr($defaultAuthority[1],0,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx2" value="2" <?php if((int)substr($defaultAuthority[1],0,1)>=2 && (int)substr($defaultAuthority[1],0,1)!=4  && (int)substr($defaultAuthority[1],0,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx2" value="1" <?php if((int)substr($defaultAuthority[1],0,1)>=1 && (int)substr($defaultAuthority[1],0,1)!=2  && (int)substr($defaultAuthority[1],0,1)!=4 && (int)substr($defaultAuthority[1],0,1)!=6){ echo 'checked';} ?>/></td>
          <td>읽기<input type="checkbox" name="rwx3" value="4" <?php if((int)substr($defaultAuthority[2],0,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx3" value="2" <?php if((int)substr($defaultAuthority[2],0,1)>=2 && (int)substr($defaultAuthority[2],0,1)!=4  && (int)substr($defaultAuthority[2],0,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx3" value="1" <?php if((int)substr($defaultAuthority[2],0,1)>=1 && (int)substr($defaultAuthority[2],0,1)!=2  && (int)substr($defaultAuthority[2],0,1)!=4 && (int)substr($defaultAuthority[2],0,1)!=6){ echo 'checked';} ?>/></td>
        </tr>
        <tr>
          <td>같은 팀</td>
          <td>읽기<input type="checkbox" name="rwx1" value="4" <?php if((int)substr($defaultAuthority[0],1,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx1" value="2" <?php if((int)substr($defaultAuthority[0],1,1)>=2 && (int)substr($defaultAuthority[0],1,1)!=4  && (int)substr($defaultAuthority[0],1,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx1" value="1" <?php if((int)substr($defaultAuthority[0],1,1)>=1 && (int)substr($defaultAuthority[0],1,1)!=2  && (int)substr($defaultAuthority[0],1,1)!=4 && (int)substr($defaultAuthority[0],1,1)!=6){ echo 'checked';} ?>/></td>
          <td>읽기<input type="checkbox" name="rwx2" value="4" <?php if((int)substr($defaultAuthority[1],1,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx2" value="2" <?php if((int)substr($defaultAuthority[1],1,1)>=2 && (int)substr($defaultAuthority[1],1,1)!=4  && (int)substr($defaultAuthority[1],1,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx2" value="1" <?php if((int)substr($defaultAuthority[1],1,1)>=1 && (int)substr($defaultAuthority[1],1,1)!=2  && (int)substr($defaultAuthority[1],1,1)!=4 && (int)substr($defaultAuthority[1],1,1)!=6){ echo 'checked';} ?>/></td>
          <td>읽기<input type="checkbox" name="rwx3" value="4" <?php if((int)substr($defaultAuthority[2],1,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx3" value="2" <?php if((int)substr($defaultAuthority[2],1,1)>=2 && (int)substr($defaultAuthority[2],1,1)!=4  && (int)substr($defaultAuthority[2],1,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx3" value="1" <?php if((int)substr($defaultAuthority[2],1,1)>=1 && (int)substr($defaultAuthority[2],1,1)!=2  && (int)substr($defaultAuthority[2],1,1)!=4 && (int)substr($defaultAuthority[2],1,1)!=6){ echo 'checked';} ?>/></td>
        </tr>
        <tr>
          <td>다른사용자</td>
          <td>읽기<input type="checkbox" name="rwx1" value="4" <?php if((int)substr($defaultAuthority[0],2,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx1" value="2" <?php if((int)substr($defaultAuthority[0],2,1)>=2 && (int)substr($defaultAuthority[0],2,1)!=4  && (int)substr($defaultAuthority[0],2,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx1" value="1" <?php if((int)substr($defaultAuthority[0],2,1)>=1 && (int)substr($defaultAuthority[0],2,1)!=2  && (int)substr($defaultAuthority[0],2,1)!=4 && (int)substr($defaultAuthority[0],2,1)!=6){ echo 'checked';} ?>/></td>
          <td>읽기<input type="checkbox" name="rwx2" value="4" <?php if((int)substr($defaultAuthority[1],2,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx2" value="2" <?php if((int)substr($defaultAuthority[1],2,1)>=2 && (int)substr($defaultAuthority[1],2,1)!=4  && (int)substr($defaultAuthority[1],2,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx2" value="1" <?php if((int)substr($defaultAuthority[1],2,1)>=1 && (int)substr($defaultAuthority[1],2,1)!=2  && (int)substr($defaultAuthority[1],2,1)!=4 && (int)substr($defaultAuthority[1],2,1)!=6){ echo 'checked';} ?>/></td>
          <td>읽기<input type="checkbox" name="rwx3" value="4" <?php if((int)substr($defaultAuthority[2],2,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx3" value="2" <?php if((int)substr($defaultAuthority[2],2,1)>=2 && (int)substr($defaultAuthority[2],2,1)!=4  && (int)substr($defaultAuthority[2],2,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx3" value="1" <?php if((int)substr($defaultAuthority[2],2,1)>=1 && (int)substr($defaultAuthority[2],2,1)!=2  && (int)substr($defaultAuthority[2],2,1)!=4 && (int)substr($defaultAuthority[2],2,1)!=6){ echo 'checked';} ?>/></td>
        </tr>
      </table>
  </div>
  <?php
  $rwxCnt = 4;
  if($group!= ''){
    for($i=0; $i<$groupCount; $i++){
      $groupInfo = explode('-',$groupAthority[$i]);
      $level = explode(',',$groupInfo[1]);
      echo "<div id='groupTable{$i}' style='margin:100px 20px 20px 20px;'><select name ='group' class='input2'>";
      foreach($groupList as $group){
        echo "<option value='{$group['groupName']}'";
        if($group['groupName'] == $groupInfo[0]){
          echo "selected='selected'";
        }
        echo ">{$group['groupName']}</option>";
      }
      $rows = array('본인', '같은팀', '다른사용자');
      echo '</select><table style="text-align:center;"><tr><th height="30" width=200 bgcolor="f8f8f9">대상</th><th height="30" width=200 bgcolor="f8f8f9">일반</th><th height="30" width=200 bgcolor="f8f8f9">팀관리자</th><th height="30" width=200 bgcolor="f8f8f9">관리자</th><th colspan=4><img src="'.$misc.'img/btn_del0.jpg" onclick="tableRemove('."groupTable{$i}".');"></th></tr>';
      for($j=0; $j<count($rows); $j++){
        echo '<tr><td>'.$rows[$j].'</td><td>읽기<input type="checkbox" name="rwx'.$rwxCnt.'" value="4"';
        if((int)substr($level[0],$j,1) >= 4){ echo 'checked';}
        echo '/>쓰기<input type="checkbox" name="rwx'.$rwxCnt.'" value="2"';
        if((int)substr($level[0],$j,1) >=2 && (int)substr($level[0],$j,1)!=4  && (int)substr($level[0],$j,1)!=5){ echo 'checked';}
        echo '/>수정<input type="checkbox" name="rwx'.$rwxCnt.'" value="1"';
        if((int)substr($level[0],$j,1)>=1 && (int)substr($level[0],$j,1)!=2  && (int)substr($level[0],$j,1)!=4 && (int)substr($level[0],$j,1)!=6){ echo 'checked';}
        echo '/></td><td>읽기<input type="checkbox" name="rwx'.($rwxCnt+1).'" value="4"';
        if((int)substr($level[1],$j,1) >= 4){ echo 'checked';}
        echo '/>쓰기<input type="checkbox" name="rwx'.($rwxCnt+1).'" value="2"';
        if((int)substr($level[1],$j,1)>=2 && (int)substr($level[1],$j,1)!=4  && (int)substr($level[1],$j,1)!=5){ echo 'checked';}
        echo '/>수정<input type="checkbox" name="rwx'.($rwxCnt+1).'" value="1"'; 
        if((int)substr($level[1],$j,1)>=1 && (int)substr($level[1],$j,1)!=2  && (int)substr($level[1],$j,1)!=4 && (int)substr($level[1],$j,1)!=6){ echo 'checked';}
        echo '/></td><td>읽기<input type="checkbox" name="rwx'.($rwxCnt+2).'" value="4"';
        if((int)substr($level[2],$j,1) >= 4){ echo 'checked';}
        echo '/>쓰기<input type="checkbox" name="rwx'.($rwxCnt+2).'" value="2"';
        if((int)substr($level[2],$j,1)>=2 && (int)substr($level[2],$j,1)!=4  && (int)substr($level[2],$j,1)!=5){ echo 'checked';}
        echo '/>수정<input type="checkbox" name="rwx'.($rwxCnt+2).'" value="1"'; 
        if((int)substr($level[2],$j,1)>=1 && (int)substr($level[2],$j,1)!=2  && (int)substr($level[2],$j,1)!=4 && (int)substr($level[2],$j,1)!=6){ echo 'checked';}
        echo '/></td></tr>';

      }
      echo '</table></div>';
      $rwxCnt = $rwxCnt+3;
    }
  } 
  ?>
  <div id="add_btn_div" style="margin:20px 20px 20px 20px;"><img src="<?php echo $misc; ?>img/btn_add.jpg" width="20" style="cursor:pointer;margin-top:50px;" onclick="groupCustom()"></div> 
  <div style="margin:20px 20px 20px 20px;"><img src="<?php echo $misc; ?>img/btn_adjust.jpg" style="cursor:pointer;margin-top:50px;" onclick="modify();"></div>
</form>
<script>
  var groupCount = <?php echo $groupCount; ?>;
  var rwxCnt = <?php echo $rwxCnt ;?>;
  function groupCustom(){
    groupCount++
    var txt = "<div id='groupTable"+groupCount+"' style='margin:100px 20px 20px 20px;'><select name ='group' class='input2'>";
    <?php foreach($groupList as $group){?>
      txt += "<option value='<?php echo $group['groupName'];?>'><?php echo $group['groupName'];?></option>";
    <?php } ?>
      txt += '</select><table style="text-align:center;"><tr><th height="30" width=200 bgcolor="f8f8f9">대상</th><th height="30" width=200 bgcolor="f8f8f9">일반</th><th height="30" width=200 bgcolor="f8f8f9">팀관리자</th><th height="30" width=200 bgcolor="f8f8f9">관리자</th><th colspan=4><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="tableRemove('+"groupTable"+groupCount+');"></th></tr>';
      txt += '<tr><td>본인</td><td>읽기<input type="checkbox" name="rwx'+rwxCnt+'" value="4" <?php if((int)substr($defaultAuthority[0],0,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+rwxCnt+'" value="2" <?php if((int)substr($defaultAuthority[0],0,1)>=2 && (int)substr($defaultAuthority[0],0,1)!=4  && (int)substr($defaultAuthority[0],0,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+rwxCnt+'" value="1" <?php if((int)substr($defaultAuthority[0],0,1)>=1 && (int)substr($defaultAuthority[0],0,1)!=2  && (int)substr($defaultAuthority[0],0,1)!=4 && (int)substr($defaultAuthority[0],0,1)!=6){ echo 'checked';} ?>/></td><td>읽기<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="4" <?php if((int)substr($defaultAuthority[1],0,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="2" <?php if((int)substr($defaultAuthority[1],0,1)>=2 && (int)substr($defaultAuthority[1],0,1)!=4  && (int)substr($defaultAuthority[1],0,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="1" <?php if((int)substr($defaultAuthority[1],0,1)>=1 && (int)substr($defaultAuthority[1],0,1)!=2  && (int)substr($defaultAuthority[1],0,1)!=4 && (int)substr($defaultAuthority[1],0,1)!=6){ echo 'checked';} ?>/></td><td>읽기<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="4" <?php if((int)substr($defaultAuthority[2],0,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="2" <?php if((int)substr($defaultAuthority[2],0,1)>=2 && (int)substr($defaultAuthority[2],0,1)!=4  && (int)substr($defaultAuthority[2],0,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="1" <?php if((int)substr($defaultAuthority[2],0,1)>=1 && (int)substr($defaultAuthority[2],0,1)!=2  && (int)substr($defaultAuthority[2],0,1)!=4 && (int)substr($defaultAuthority[2],0,1)!=6){ echo 'checked';} ?>/></td></tr>';
      txt += '<tr><td>같은 팀</td><td>읽기<input type="checkbox" name="rwx'+rwxCnt+'" value="4" <?php if((int)substr($defaultAuthority[0],1,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+rwxCnt+'" value="2" <?php if((int)substr($defaultAuthority[0],1,1)>=2 && (int)substr($defaultAuthority[0],1,1)!=4  && (int)substr($defaultAuthority[0],1,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+rwxCnt+'" value="1" <?php if((int)substr($defaultAuthority[0],1,1)>=1 && (int)substr($defaultAuthority[0],1,1)!=2  && (int)substr($defaultAuthority[0],1,1)!=4 && (int)substr($defaultAuthority[0],1,1)!=6){ echo 'checked';} ?>/></td><td>읽기<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="4" <?php if((int)substr($defaultAuthority[1],1,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="2" <?php if((int)substr($defaultAuthority[1],1,1)>=2 && (int)substr($defaultAuthority[1],1,1)!=4  && (int)substr($defaultAuthority[1],1,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="1" <?php if((int)substr($defaultAuthority[1],1,1)>=1 && (int)substr($defaultAuthority[1],1,1)!=2  && (int)substr($defaultAuthority[1],1,1)!=4 && (int)substr($defaultAuthority[1],1,1)!=6){ echo 'checked';} ?>/></td><td>읽기<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="4" <?php if((int)substr($defaultAuthority[2],1,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="2" <?php if((int)substr($defaultAuthority[2],1,1)>=2 && (int)substr($defaultAuthority[2],1,1)!=4  && (int)substr($defaultAuthority[2],1,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="1" <?php if((int)substr($defaultAuthority[2],1,1)>=1 && (int)substr($defaultAuthority[2],1,1)!=2  && (int)substr($defaultAuthority[2],1,1)!=4 && (int)substr($defaultAuthority[2],1,1)!=6){ echo 'checked';} ?>/></td></tr>';
      txt += '<tr><td>다른사용자</td><td>읽기<input type="checkbox" name="rwx'+rwxCnt+'" value="4" <?php if((int)substr($defaultAuthority[0],2,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+rwxCnt+'" value="2" <?php if((int)substr($defaultAuthority[0],2,1)>=2 && (int)substr($defaultAuthority[0],2,1)!=4  && (int)substr($defaultAuthority[0],2,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+rwxCnt+'" value="1" <?php if((int)substr($defaultAuthority[0],2,1)>=1 && (int)substr($defaultAuthority[0],2,1)!=2  && (int)substr($defaultAuthority[0],2,1)!=4 && (int)substr($defaultAuthority[0],2,1)!=6){ echo 'checked';} ?>/></td><td>읽기<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="4" <?php if((int)substr($defaultAuthority[1],2,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="2" <?php if((int)substr($defaultAuthority[1],2,1)>=2 && (int)substr($defaultAuthority[1],2,1)!=4  && (int)substr($defaultAuthority[1],2,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+(rwxCnt+1)+'" value="1" <?php if((int)substr($defaultAuthority[1],2,1)>=1 && (int)substr($defaultAuthority[1],2,1)!=2  && (int)substr($defaultAuthority[1],2,1)!=4 && (int)substr($defaultAuthority[1],2,1)!=6){ echo 'checked';} ?>/></td><td>읽기<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="4" <?php if((int)substr($defaultAuthority[2],2,1) >= 4){ echo 'checked';} ?>/>쓰기<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="2" <?php if((int)substr($defaultAuthority[2],2,1)>=2 && (int)substr($defaultAuthority[2],2,1)!=4  && (int)substr($defaultAuthority[2],2,1)!=5){ echo 'checked';} ?>/>수정<input type="checkbox" name="rwx'+(rwxCnt+2)+'" value="1" <?php if((int)substr($defaultAuthority[2],2,1)>=1 && (int)substr($defaultAuthority[2],2,1)!=2  && (int)substr($defaultAuthority[2],2,1)!=4 && (int)substr($defaultAuthority[2],2,1)!=6){ echo 'checked';} ?>/></td></tr></table>';
      txt += '</div>'
    $("#add_btn_div").before(txt);
    rwxCnt = rwxCnt+2;

  }
  
  function tableRemove(table){
    $("#"+table.id).remove()
  }

  function modify(){
    //default 권한 가져오기
    var authority = '';
    var group_authority = '';
    for(k=1; k <= 3; k++){
      for(i=0; i<document.getElementsByName('rwx'+k).length; i=i+3){
        var rwx = 0;
        for(j=i; j<i+3; j++){
          if(document.getElementsByName('rwx'+k)[j].checked == true){
            rwx += Number(document.getElementsByName('rwx'+k)[j].value);
          }
        }
        authority += rwx + '';
      }
      authority += ',';
    }
    authority = authority.slice(0,-1);

    //그룹별 권한 가져오기
    var cnt = 4;
    for(i=0; i<document.getElementsByName('group').length; i++){
      var groupName = document.getElementsByName('group')[i].value;
      for(a=0; a<document.getElementsByName('group').length; a++){
        if(a != i){
          if(document.getElementsByName('group')[a].value == groupName){
            alert("부서가 중복되었습니다.");
            return false;
          }
        }
      }
      group_authority+="|"+document.getElementsByName('group')[i].value+"-"
      for(j=cnt; j <=cnt+2; j++){
        for(k=0; k<document.getElementsByName('rwx'+j).length; k=k+3){
          var rwx = 0;
          for(l=k; l < k+3; l++){
            if(document.getElementsByName('rwx'+j)[l].checked == true){
              rwx += Number(document.getElementsByName('rwx'+j)[l].value);
            }
          }
          group_authority += rwx +'';
        }
        group_authority  += ',';
      }
      group_authority = group_authority.slice(0,-1);
      cnt=cnt+3;
    }
    group_authority = group_authority.substring(1); 

    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url();?>/ajax/page_rights_update",
      dataType: "json",
      async: false,
      data: {
        seq: <?php echo $_GET['seq'];?>,
        authority:authority,
        group_authority:group_authority
      },
      success: function (data) {
        // console.log(data)
        if(data==true){
          alert("정상적으로 수정되었습니다.")
          location.reload();
        }else{
          alert("정상적으로 수정되지 못했습니다.")
        }
      }
    });

  }
</script>
</body>
</html>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
  ul{
   list-style:none;
   }
  input {
    border: none;
    border-right: 0px;
    border-top: 0px;
    border-left: 0px;
    border-bottom: 0px;
  }
</style>

<body>
<div style="margin:20px 20px 20px 20px;">
  <table>
    <!-- <tr><td style="text-align:center;">부서</td><td style="text-align:center;">권한</td></tr> -->
    <tr>
      <th height="30" bgcolor="f8f8f9"><input value="부서" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30" bgcolor="f8f8f9"><input value="권한" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
    </tr>
    <tr height="20px"></tr>
    <tr>
      <td style="padding-left:10px;text-align: -webkit-center;">
        <select id="group" name="group" class="input" >
        </select>
      </td>
      <td id="userPart" style="text-align: -webkit-center;">
        <div>
          <select name="user_part1" id="user_part1" class="input">
          <?php
					$part = array('비즈', '영업', '기술', '관리');
					for($i=0; $i<count($part); $i++){ ?>
            <option value="<?php echo $i+1;?>"><?php echo $part[$i]; ?></option>
          <?php } ?>
          </select>
          <select name="user_part2" id="user_part2" class="input">
            <option value=0>권한없음</option>
            <option value=1>일반</option>
            <option value=2>팀관리자</option>
            <option value=3>관리자</option>
          </select>
        </div>
      </td>
  </tr>
  <tr height="50px"></tr>
  <tr><td colspan="2" style="text-align: -webkit-center;"><input type="button" value="권한부여" class="input1" onclick="groupLevelChange();"></td></tr>
  </table>
</div>
</body>
<script>
$.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url(); ?>/ajax/group",
    dataType: "json",
    async: false,
    data: {
    },
    success: function (data) {
      var txt;
      for(i=0; i<data.length; i++){
        txt += '<option value="'+data[i].groupName+'">'+data[i].groupName+'</option>'
      }
      $("#group").append(txt);
    }
});

function groupLevelChange(){
  $.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url(); ?>/ajax/groupChangeUserPart",
    dataType: "json",
    async: false,
    data: {
      groupName:$("#group").val(),
      userPart:$("#user_part1").val(),
      userLevel:$("#user_part2").val()
    },
    success: function (data) {
      if(data==true){
        alert("정상적으로 처리 되었습니다.")
      }else{
        alert("정상적으로 처리되지 못했습니다.")
      }
      opener.location.reload();
    }
  });
}

</script>
</html>

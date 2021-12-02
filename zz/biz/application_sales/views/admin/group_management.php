<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
  ul{
   list-style:none;
   }
  input{
    margin-left : 5px;
    width : 100px;
    font-family: 'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif;
    line-height: 150%;
    font-size: 12px;
    color: #333;
    /* border-color:f; */
    /* border :none; */
  }
  /* input:focus {background-color:skyblue;} */
</style>

<body>
  <table>
    <tr>
      <td>
        <div id="groupTree"></div>
        <ul>
          <li id="all" name="depth0">
            <img src="<?php echo $misc; ?>img/btn_add.jpg" id="depth0" width="13" style="cursor:pointer;" onclick="addGroup(this);">
            <span id="all" >
              (주)두리안정보기술
            </span>
            <ul id="allGroup">
            <?php
            $test='';
            foreach ( $view_val as $parentGroup ) {
              if($parentGroup['childGroupNum']>1){
                $test .= ",".$parentGroup['groupName'];
              }
              if($parentGroup['depth'] == 1){
            ?>
              <li id="<?php echo $parentGroup['groupName'];?>" name="depth1">
                <img src="<?php echo $misc; ?>img/btn_add.jpg" width="13" style="cursor:pointer;" onclick="addGroup(this);">
                <img src="<?php echo $misc; ?>img/btn_del0.jpg" width="13" style="cursor:pointer;" onclick="removeGroup(this);">
                <span id="<?php echo $parentGroup['groupName'];?>">
                <input type="text" name="depth1" value="<?php echo $parentGroup['groupName'];?>"> 
                </span>
                <ul id="<?php echo $parentGroup['groupName']."Group" ;?>" >
                </ul>
              </li>
            <?php
            }
            }
            ?>
            </ul>
          </li>
        </ul>
        </ul>
        <div style="margin-top:50px;"><input type="button" value="저장" onclick="updateGroup();" /></div>
      </td>
    </tr>
  </table>
</body>
<script>
var parent = "<?php echo $test; ?>";
parent = parent.substring(1).split(',');
for(i=0; i <parent.length; i++){
  (function(i) {
    var text = "";
    var parentGroup = parent[i];
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
        for(i=0; i<data.length; i++){
            text += '<li id="'+data[i].groupName+'" name="depth'+data[i].depth+'" ><img src="<?php echo $misc; ?>img/btn_add.jpg" width="13" style="cursor:pointer;" onclick="addGroup(this);"><img src="<?php echo $misc; ?>img/btn_del0.jpg" width="13" style="cursor:pointer;" onclick="removeGroup(this);"><span style="cursor:pointer;" id="'+data[i].groupName+'"><input type="text" name="depth'+data[i].depth+'" value="'+data[i].groupName+'"></span><ul id="'+data[i].groupName+'Group"></ul></li>';
        }
        $("#"+parentGroup+"Group").html($("#"+parentGroup+"Group").html()+text);
      }
    });
  })(i);
}

function addGroup(plus){
  var depth = ($(plus).parent().attr('name')).replace('depth', '');
  depth = Number(depth)+1;
  var addTarget = $(plus).parent().children('ul')
  var addText = '<li name="depth'+depth+'"><img src="<?php echo $misc; ?>img/btn_add.jpg" width="13" style="cursor:pointer;" onclick="addGroup(this);"><img src="<?php echo $misc; ?>img/btn_del0.jpg" width="13" style="cursor:pointer;" onclick="removeGroup(this);"><span><input type="text" name="depth'+depth+'"></span><ul></ul></li>'
  addTarget.html(addTarget.html()+addText);
}

function removeGroup(remove){
  var removeTarget = $(remove).parent().remove();
}

function updateGroup(){
  var success_num = 0;
  var groupTotal = 0;
  $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo site_url(); ?>/ajax/groupAllDelete",
      dataType: "json",
      async: false,
      data: {
      },
      success: function (data) {
        if (data == true) {
          var depthCheck = true;
          var depth = 1;
          while (depthCheck == true) {
            if ($('input[name="depth' + depth + '"]').length) {
              depth++;
            } else {
              depthCheck = false;
            }
          }
          for (i = 1; i < depth; i++) {
            var length = $('input[name="depth' + i + '"]').length;
            groupTotal = groupTotal+length;
            for (j = 0; j < length; j++) {
              var depthNum = i;
              var group = $('input[name="depth' + i + '"]').eq(j).val();
              var groupUl = $('input[name="depth' + i + '"]').eq(j).parent().parent().children('ul');
              var childGroupNum = Number(groupUl.children('li').length) + 1;

              if (i == 1) {
                var parentGroup = $('input[name="depth' + i + '"]').eq(j).val();
              } else {
                var parentGroup = $('input[name="depth' + i + '"]').eq(j).parent().parent().parent().attr('id')
                parentGroup = parentGroup.replace("Group", "")
              }

              $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo site_url(); ?>/ajax/groupUpdate",
                dataType: "json",
                async: false,
                data: {
                  groupName: group,
                  parentGroupName: parentGroup,
                  childGroupNum: childGroupNum,
                  depth: depthNum
                },
                success: function (data) {
                  if(data == true){
                    success_num++;
                  }else{
                    alert("정상적으로 처리되지 못했습니다.")
                  }
                }
              });
            }
          }

          if(groupTotal == success_num){
            alert("정상적으로 처리되었습니다.")
          }else{
            alert("정상적으로 처리되지 못했습니다.")
          }
        } else {
          alert("정상적으로 처리되지 못했습니다.")
          
        }
        opener.location.reload();
        location.reload();
      }
    });
}
</script>
</html>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>

<body>
<div style="margin:20px 20px 20px 20px;">
    <table id="checkMember">
    </table>
</div>
</body>
<script>
  var seq = "<?php echo $_GET['seq'] ; ?>";
  $.ajax({
    type: "POST",
    cache: false,
    url: "<?php echo site_url();?>/ajax/groupView",
    dataType: "json",
    async: false,
    data: {
      group: seq
    },
    success: function(data) {
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url();?>/ajax/group",
        dataType: "json",
        async: false,
        data: {
        },
        success: function (result) {
          var text = "";
            for(i=0; i<data.length; i++){
                text += "<tr><td><img src='<?php echo $misc; ?>img/person.png' width=50></td><td><div>"+data[i].user_name+" "+data[i].user_duty+" <select name='"+data[i].seq+"' onchange='changeGroup(this)'>";
                for(j=0; j<result.length; j++){
                  if(result[j].groupName == data[i].user_group){
                    text += "<option value='"+result[j].groupName+"' selected='selected'>"+result[j].groupName+"</option>"
                  }else{
                    text += "<option value='"+result[j].groupName+"'>"+result[j].groupName+"</option>"
                  }
                }
                text += "</select></div><br><div>"+data[i].user_tel+"</div><div>"+data[i].user_email+"</div></td><td width='200'></td><tr height=20>";
            }
          $("#checkMember").html(text);
        }
      });
    }
  });

  function changeGroup(select){
    var changeSeq = select.name;
    var selectGroup = select.value;
    var check = confirm(selectGroup+"으로 부서 이동 하시겠습니까?")

    if(check == true){
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url();?>/ajax/changeGroup",
        dataType: "json",
        async: false,
        data: {
          seq:changeSeq,
          changeGroup:selectGroup
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
    }else{
      location.reload();
    }


  }

</script>
</html>
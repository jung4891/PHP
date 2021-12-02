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
        var text = "";
        $("#checkMember").html("");
        for(i=0; i<data.length; i++){
          var num='';
          text += "<tr><div><td><img src='<?php echo $misc; ?>img/person.png' width=50 style='margin-bottom:10px;'></td><td width=300><div>"+data[i].user_name+" "+data[i].user_duty+"</div><div id='userPart'>";

          <?php
					$part = array('비즈', '영업', '기술', '관리');
					for($i=0; $i<count($part); $i++){ ?>
            text += '<span name="user_part1" id="page<?php echo ($i+1) ;?>" style="display:inline-block;width:80px;text-align:center"><?php echo $part[$i];?></span>';
            text += '<select name="'+data[i].seq+'" id="user_part2" class="input">'
            text += '<option value=0'
            // alert(<?php echo $i; ?>)
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "0"){
              text += " selected";
            }
            text += '>권한없음</option><option value=1'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "1"){
              text += " selected";
            }
            text += '>일반</option><option value=2'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "2"){
              text += " selected";
            }
            text += '>팀관리자</option><option value=3'
            if((data[i].user_part).substr(<?php echo $i; ?>,1) == "3"){
              text += " selected";
            }
            text += '>관리자</option></select><br>'
          <?php } ?>

            text += "</div></td><td><input type='button' value='수정' class='input1' onclick='changeUserPart("+data[i].seq+")'></td><tr height=20></div></tr>";
            $("#checkMember").html(text);
        }

    }
  });

  function changeUserPart(seq){
    var changeUserPart = '';

    for( i=0; i<document.getElementsByName(seq).length; i++){
      changeUserPart = changeUserPart+(document.getElementsByName(seq)[i].value);
    }

    var check = confirm("권한을 수정 하시겠습니까?")

    if(check == true){
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url();?>/ajax/changeUserPart",
        dataType: "json",
        async: false,
        data: {
          seq:seq,
          userPart:changeUserPart
        },
        success: function (data) {
          if(data==true){
            alert("정상적으로 처리 되었습니다.")
          }else{
            alert("정상적으로 처리되지 못했습니다.")
          }
          opener.location.reload();
          location.reload();
        }
      });
    }else{
      location.reload();
    }
  }
</script>
</html>

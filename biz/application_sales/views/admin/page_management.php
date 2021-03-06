<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_list 김수성
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
<div style="margin:20px 20px 20px 20px;text-align:center">
  <table id="pageTable">
    <tr>
      <th height="30" bgcolor="f8f8f9"><input value="번호" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30" bgcolor="f8f8f9"><input value="홈페이지명" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30" bgcolor="f8f8f9"><input value="주소" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30" bgcolor="f8f8f9"><input value="" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
    </tr>

<?php 
    $i = 1;
    foreach($pageList as $page){
      echo '<tr><td style="text-align: -webkit-center;">'.$i.'</td><td style="text-align: -webkit-center;"><input type="hidden" value="'.$page['seq'].'"><input type="text" id="page_name'.$i.'" class="input" value="'.$page['page_name'].'"></td><td style="text-align: -webkit-center;"><input type="text" id="page_address'.$i.'" class="input" value="'.$page['page_address'].'"></td><td style="text-align: -webkit-center;"><img src="'.$misc.'img/btn_adjust.jpg" width="60" height="27" style="cursor:pointer;" onclick="updatePage('.$page['seq'].','.$i.');"><img src="'.$misc.'img/btn_delete.jpg" width="60" height="27" style="cursor:pointer;margin-left:5px;" onclick="deletePage('.$page['seq'].');"><input type="button" value="사이트권한관리" onclick="pageRightsManagement('.$page['seq'].');" /></td</tr>';
      $i++;
    } 
?>  
  </table>
  <img src="<?php echo $misc; ?>img/btn_add.jpg" width="20" style="cursor:pointer;margin-top:50px;" onclick="addPage(this)">
</div> 

<script>
var num = <?php echo $i;?>;
function addPage(btn){
    var txt = '<tr><td style="text-align: -webkit-center;">'+num+'</td><td style="text-align: -webkit-center;"><input type="hidden" value=""><input id="page_name'+num+'" type="text" class="input" value=""></td><td style="text-align: -webkit-center;"><input type="text" id="page_address'+num+'" class="input" value=""></td><td style="text-align: -webkit-center;"><img src="<?php echo $misc ; ?>img/btn_ok.jpg" width="60" height="27" style="cursor:pointer;" onclick="insertPage('+num+');"></td</tr>'
    $("#pageTable").append(txt);
    $(btn).remove();
    num++
}

//등록
function insertPage(n) {
    var pageName = $("#page_name"+n).val();
    var pageAddress = $("#page_address"+n).val();
    $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/ajax/insertPage",
        dataType: "json",
        async: false,
        data: {
            pageName: pageName,
            pageAddress:pageAddress,
        },
        success: function (data) {
            if(data == true){
                alert("등록되었습니다.")
                location.reload();
            }else{
                alert("정상적으로 등록 되지 못했습니다.")
            }
        }
    });
}


//수정
function updatePage(seq,n){
    var pageName = $("#page_name"+n).val();
    var pageAddress = $("#page_address"+n).val();
    var updateConfirm = confirm("수정하시겠습니까?");
    if(updateConfirm == true){
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/updatePage",
            dataType: "json",
            async: false,
            data: {
                seq:seq,
                pageName:pageName,
                pageAddress:pageAddress
            },
            success: function (data) {
                if(data){
                    alert("수정되었습니다.")
                    location.reload();
                }else{
                    alert("정상적으로 수정되지 못했습니다.")
                }
            }
        });
    }else{
        return false;
    }
}

//삭제
function deletePage(seq){
    var deleteConfirm = confirm("삭제하시겠습니까?");
    if(deleteConfirm == true){
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php echo site_url(); ?>/ajax/deletePage",
            dataType: "json",
            async: false,
            data: {
                seq:seq
            },
            success: function (data) {
                if(data == true){
                    alert("삭제되었습니다.")
                    location.reload();
                }else{
                    alert("정상적으로 삭제되지 못했습니다.")
                }
            }
        });
    }else{
        return false;
    }
}

function pageRightsManagement(seq){
    window.open('<?php echo site_url();?>/admin/account/page_rights_management?seq='+seq);
}
</script>
</body>
</html>
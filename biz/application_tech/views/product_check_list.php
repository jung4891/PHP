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
  <table>
    <tr>
      <th height="30" bgcolor="f8f8f9"><input value="번호" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30" bgcolor="f8f8f9"><input value="제품명" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30" bgcolor="f8f8f9"><input value="" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
    </tr>

<?php 
    $i = 1;
    foreach($check_item as $item){
      echo '<tr><td style="text-align: -webkit-center;">'.$i.'</td><td style="text-align: -webkit-center;">'.$item['product_name'].'</td><td style="text-align: -webkit-center;"><input type="button" class="input1" value="수정" onclick="checkListView('.$item['seq'].');"/><input type="button" class="input1" value="삭제" onclick="checkListDelete('.$item['seq'].');" style="margin-left:5px;" /></td></tr>';
      $i++;
    } 
?>


  </table>

<script>
  //템플릿 뷰
  function checkListView(seq){
    
    window.open('/index.php/tech_board/product_check_list_modify?seq='+seq,'_blank','height=600,width=1000');
  }

  //삭제
  function checkListDelete(seq){
    var deleteConfirm = confirm("삭제하시겠습니까?");
    if(deleteConfirm == true){
      window.open('/index.php/tech_board/product_check_list_delete?seq='+seq);
      window.close();
    }
  }
</script>
</body>
</html>

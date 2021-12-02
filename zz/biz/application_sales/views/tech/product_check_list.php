<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>

.product_modify th{
  background: #EFEFEF 0% 0% no-repeat padding-box;
  border: 1px solid #DEDEDE;
  opacity: 1;
}

.product_modify td{
  background: #FFFFFF 0% 0% no-repeat padding-box;
  border: 1px solid #DEDEDE;
  opacity: 1;
}

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
    font-family:"Noto Sans KR", sans-serif !important;
    line-height: 150%;
    font-size: 15px;
    margin-right : 10px;
  }
</style>
<body>
  <h2 align="center">
    제품별 점검항목 보기
  </h2>
  <table class="product_modify" align="center">
    <tr>
      <th height="30"><input value="번호" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30"><input value="제품명" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      <th height="30"><input value="" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
    </tr>

<?php
    $i = 1;
    foreach($check_item as $item){
      echo '<tr><td style="text-align: -webkit-center;">'.$i.'</td><td style="text-align: -webkit-center;">'.$item['product_name'].'</td><td style="text-align: -webkit-center;"><input type="button" class="input1" value="수정" style="background: #B0B0B0; color:#FFFFFF;font:medium; border-radius:19px;" onclick="checkListView('.$item['seq'].');"/><input type="button" class="input1"  value="삭제" style="background: #B0B0B0; color:#FFFFFF;font:medium; border-radius:19px;" onclick="checkListDelete('.$item['seq'].');" style="margin-left:5px;" /></td></tr>';
      $i++;
    }
?>


  </table>

<script>
  //템플릿 뷰
  function checkListView(seq){

    window.open('/index.php/tech/tech_board/product_check_list_modify?seq='+seq,'_blank','height=600,width=1000');
  }

  //삭제
  function checkListDelete(seq){
    var deleteConfirm = confirm("삭제하시겠습니까?");
    if(deleteConfirm == true){
      window.open('/index.php/tech/tech_board/product_check_list_delete?seq='+seq);
      window.close();
    }
  }
</script>
</body>
</html>

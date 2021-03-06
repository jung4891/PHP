<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  $mode = $_GET['mode'];
?>
<body>
<form>
  <table width="890" border="0" style="margin-top:20px;">
    <tr>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="7" height="2" bgcolor="#797c88"></td>
        </tr>
        <tr bgcolor="f8f8f9" class="t_top">
          <td width="5%" height="40" align="center" class="t_border">선택</td>
          <td width="5%" height="40" align="center" class="t_border">SEQ</td>
          <td width="15%" align="center" class="t_border">고객사</td>
          <td width="15%" align="center" class="t_border">담당자</td>
          <td width="15%" align="center" class="t_border">담당자 email</td>
          <td width="15%" align="center" class="t_border">유지보수만료일</td>
        </tr>
        <?php
        foreach($input as $entry){
?>
        <tr bgcolor="f8f8f9" class="t_top">
          <td width="5%" align="center" class="t_border"><input type="checkbox" name="check"></td>
          <?php if($mode == "maintain"){
            echo "<td width='15%' align='center' class='t_border'><input type='hidden' name='maintain_seq' value='{$entry->seq}'>{$entry->seq}</td>";
          }else{
            echo "<td width='15%' align='center' class='t_border'><input type='hidden' name='forcasting_seq' value='{$entry->seq}'>{$entry->seq}</td>";
          }?>
          <td width="15%" align="center" class="t_border"><input type="hidden" name="customer"  value="<?php echo $entry->customer_companyname?>"><?php echo $entry->customer_companyname;?></td>
          <td width="15%" align="center" class="t_border"><input type="hidden" name="customer_username"  value="<?php echo $entry->customer_username?>"><?php echo $entry->customer_username;?></td>
          <td width="15%" align="center" class="t_border"><input type="hidden" name="customer_email"  value="<?php echo $entry->customer_email?>"><?php echo $entry->customer_email;?></td>
          <td width="15%" align="center" class="t_border"><input type="hidden" name="maintain_end"  value="<?php echo $entry->exception_saledate3?>"><?php echo $entry->exception_saledate3;?></td>
        </tr>
<?php
        }
      ?>
        <tr>
          <td colspan="7" height="1" bgcolor="#797c88"></td>
        </tr>
    <tr>
      <td height="10"></td>
    </tr>
    <tr>
      <td align="right"><input type='submit' name="check" value='선택' onclick="submitCharge();"></td>
    </tr>
  </table>
</form>
</body>
</html>

<script>
window.onload = function(){
   submitCharge();
}

function submitCharge(){
  len = document.getElementsByName('check').length;
  total_customer="";
  total_customer_username="";
  total_customer_email="";
  total_maintain_end="";
  <?php if($mode == "maintain"){?>
    total_maintain_seq="";
    total_maintain_seq += document.getElementsByName('maintain_seq')[0].value;
  <?php }else{ ?>
    total_forcasting_seq="";
    total_forcasting_seq += document.getElementsByName('forcasting_seq')[0].value;
  <?php } ?>
  total_customer += document.getElementsByName('customer')[0].value;
  total_customer_username += document.getElementsByName('customer_username')[0].value;
  total_customer_email += document.getElementsByName('customer_email')[0].value;
  total_maintain_end += document.getElementsByName('maintain_end')[0].value;

  var now = new Date();
  var today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

  var tmp_date = total_maintain_end.split("-");
  var maintain_end = new Date(tmp_date[1]+"/"+tmp_date[2]+"/"+tmp_date[0]);
  <?php if($mode == "maintain"){?>
  if(total_maintain_end.length == 0){
    alert("유지보수 만료일이 설정되지 않았습니다. 설정 후 이용해 주세요.");
    opener.document.cform.customer.selectedIndex = 0;

  }else{
    if(today.getTime() > maintain_end.getTime()){
      alert("고객사 유지보수 기간이 "+tmp_date[0]+"년 "+tmp_date[1]+"월 " + tmp_date[2]+"부로 종료 되었습니다. 영업 부서에 확인 후 이용바랍니다.");
      opener.document.cform.customer.selectedIndex = 0;
    }else{
      alert("고객사 유지보수 기간은 "+tmp_date[0]+"년 "+tmp_date[1]+"월 " + tmp_date[2]+"일 까지 입니다.");
    }
  }
  <?php } ?>
  <?php
  if(isset($_GET['page'])){
    if($_GET['page'] == "sch"){ ?>
      // opener.document.de_customer_manager.value=total_customer_username;
      $("#de_customer_manager",parent.opener.document).val(total_customer_username);
  <?php }
  }else{?>
      opener.document.cform.customer_manager.value=total_customer_username;
      opener.document.cform.customer_tmp.value=total_customer;
      opener.document.cform.manager_mail.value=total_customer_email;
  <?php } ?>

  <?php if($mode == "maintain"){?>
    opener.document.cform.maintain_seq.value=total_maintain_seq;
  <?php }else{ ?>
    opener.document.cform.forcasting_seq.value=total_forcasting_seq;
  <?php }?>
  self.close();
}
</script>

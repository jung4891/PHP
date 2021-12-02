<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_list 김수성
?>
<body>
<form name="tb1">
  <table width="890" border="0" style="margin-top:20px;">
    <tr>
      <td class="title3">장비검색</td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="7" height="2" bgcolor="#797c88"></td>
    </tr>
    <tr bgcolor="f8f8f9" class="t_top">
      <td width="5%" height="40" align="center" class="t_border"><input type="checkbox" id="checkAll" name="checkAll"
          onChange="allCheck();"></td>
      <td width="15%" align="center" class="t_border">장비/시스템명</td>
      <td width="15%" align="center" class="t_border">host</td>
      <td width="15%" align="center" class="t_border">하드웨어</td>
      <td width="10%" align="center" class="t_border">Serial</td>
      <td width="20%" align="center" class="t_border">버전</td>
      <td width="10%" align="center" class="t_border">라이선스</td>
    </tr>
<?php
  foreach($input as $entry){
?>
    <tr bgcolor="f8f8f9" class="t_top">

      <td width="5%" align="center" class="t_border"><input type="checkbox" name="check"></td>
      <td width="15%" align="center" class="t_border">
        <input type="hidden" name="product_seq" value="<?php echo $entry->product_seq?>">
        <input type="hidden" name="product_name" value="<?php echo $entry->product_name?>"><?php echo $entry->product_name;?>
      </td>
      <td width="15%" align="center" class="t_border"><input type="hidden" name="product_host"
      value="<?php echo $entry->product_host?>"><?php echo $entry->product_host;?></td>
      <td width="15%" align="center" class="t_border"><input type="hidden" name="product_item"
          value="<?php echo $entry->product_item?>"><?php echo $entry->product_item;?></td>
      <td width="10%" align="center" class="t_border"><input type="hidden" name="product_serial"
          value="<?php echo $entry->product_serial?>"><?php echo $entry->product_serial;?></td>
      <td width="20%" align="center" class="t_border"><input type="hidden" name="product_version"
          value="<?php echo $entry->product_version?>"><?php echo $entry->product_version;?></td>
      <td width="10%" align="center" class="t_border"><input type="hidden" name="product_license"
          value="<?php echo $entry->product_licence?>"><?php echo $entry->product_licence;?></td>
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
      <td colspan="2" align="left"><input type='submit' name="check" value='선택' onclick="submitCharge();">
    </tr>
  </table>
</form>
</body>
</html>
 
<script>
function allCheck() {
  if (document.tb1.checkAll.checked) {
    for (i = 0; i < document.getElementsByName('check').length - 1; i++) {
      if (!document.getElementsByName('check')[i].checked) {
        document.getElementsByName('check')[i].checked = true;
      }
    }
  } else {
    for (i = 0; i < document.getElementsByName('check').length - 1; i++) {
      if (document.getElementsByName('check')[i].checked) {
        document.getElementsByName('check')[i].checked = false;
      }
    }
  }
}

function submitCharge() {
  len = document.getElementsByName('check').length;
  total_dev_id = "";
  id_check = "_";
  total_dev_name = "";
  total_dev_hardware = "";
  total_dev_serial = "";
  total_dev_version = "";
  total_dev_license = "";
  total_dev_host = "";
  total_dev_seq = "";
  name_check = ", ";

<?php if(!isset($_GET['type']) || $_GET['type'] != "add"){ ?>
  $(opener.document).find("#sortable").empty();
  var num = 1;
  for (i = 0; i < len - 1; i++) {
    if (document.getElementsByName('check')[i].checked) {
      total_dev_name += document.getElementsByName('product_name')[i].value + name_check;
      total_dev_hardware += document.getElementsByName('product_item')[i].value + name_check;
      total_dev_serial += document.getElementsByName('product_serial')[i].value + name_check;
      total_dev_version += document.getElementsByName('product_version')[i].value + name_check;
      total_dev_license += document.getElementsByName('product_license')[i].value + name_check;
      total_dev_seq += document.getElementsByName('product_seq')[i].value + name_check;
      total_dev_host += document.getElementsByName('product_host')[i].value + name_check;

      $(opener.document).find("#sortable").append('<li id="li'+ num +'"><span style="cursor:pointer;" id="produce' + num + '" class="click_produce" onclick = "clickProduce(' + num + ',' + document.getElementsByName('product_seq')[i].value + ')"><span class="produce_seq" style="display:none;">'+document.getElementsByName('product_seq')[i].value+'</span><span class="produce">' + document.getElementsByName('product_name')[i].value + '</span> / <span class="host">' + document.getElementsByName('product_host')[i].value + '</span> / <span class="version">'+ document.getElementsByName('product_version')[i].value + '</span> / <span class="hardware">' + document.getElementsByName('product_item')[i].value + '</span> / <span class="license">'+ document.getElementsByName('product_license')[i].value + '</span><span class="serial" style="display:none;">'+document.getElementsByName('product_serial')[i].value+'</span></span>&nbsp;&nbsp;<input type="button" value="x" style="color:red;cursor:pointer;" onclick="produceRemove('+num+')" /></li>');
      num++;
    }
  }
  alert("제품이 " + ((total_dev_name.split(',').length) - 1) + "개 선택 되었습니다.")

  opener.document.cform.productSeq.value = total_dev_seq.substr(0, (total_dev_seq.length - 2));
  opener.document.cform.produce.value = total_dev_name.substr(0, (total_dev_name.length - 2));
  opener.document.cform.hardware.value = total_dev_hardware.substr(0, (total_dev_hardware.length - 2));
  opener.document.cform.serial.value = total_dev_serial.substr(0, (total_dev_serial.length - 2));
  opener.document.cform.version.value = total_dev_version.substr(0, (total_dev_version.length - 2));
  opener.document.cform.license.value = total_dev_license.substr(0, (total_dev_license.length - 2));
  opener.document.cform.host.value = total_dev_host.substr(0, (total_dev_host.length - 2));
  opener.document.cform.currentProduce.value = document.getElementsByName('product_seq')[0].value;
  opener.tableRemove();

  opener.createTable(((total_dev_name.split(',').length) - 1));

  var productSeq = total_dev_seq.substr(0, (total_dev_seq.length - 2)).split(',');
  for (i = 0; i < (total_dev_name.split(',').length) - 1; i++) {
    opener.template(productSeq[i], (i + 1));
  }
  opener.textareaSize();
  opener.serialInput();
  self.close();

<?php }else{ ?>
  var num = 1;
  var max_table = 0;

  if(opener.document.cform.produce.value != ''){
    for(i=0; i<$(".work_text_table",opener.document).length; i++){
      if( max_table < Number($(".work_text_table",opener.document).eq(i).attr('id').replace("work_text_table",""))){
        max_table = Number($(".work_text_table",opener.document).eq(i).attr('id').replace("work_text_table",""));
      }
    }
  }

  var next_table = max_table+1;
  for (i = 0; i < len - 1; i++) {
    if (document.getElementsByName('check')[i].checked) {
      total_dev_name += document.getElementsByName('product_name')[i].value + name_check;
      total_dev_hardware += document.getElementsByName('product_item')[i].value + name_check;
      total_dev_serial += document.getElementsByName('product_serial')[i].value + name_check;
      total_dev_version += document.getElementsByName('product_version')[i].value + name_check;
      total_dev_license += document.getElementsByName('product_license')[i].value + name_check;
      total_dev_seq += document.getElementsByName('product_seq')[i].value + name_check;
      total_dev_host += document.getElementsByName('product_host')[i].value + name_check;

      $(opener.document).find("#sortable").append('<li id="li'+ next_table +'"><span style="cursor:pointer;" id="produce' + next_table + '" class="click_produce" onclick = "clickProduce(' + next_table + ',' + document.getElementsByName('product_seq')[i].value + ')"><span class="produce_seq" style="display:none;">'+document.getElementsByName('product_seq')[i].value+'</span><span class="produce">' + document.getElementsByName('product_name')[i].value + '</span> / <span class="host">' + document.getElementsByName('product_host')[i].value + '</span> / <span class="version">'+ document.getElementsByName('product_version')[i].value + '</span> / <span class="hardware">' + document.getElementsByName('product_item')[i].value + '</span> / <span class="license">'+ document.getElementsByName('product_license')[i].value + '</span><span class="serial" style="display:none;">'+document.getElementsByName('product_serial')[i].value+'</span></span>&nbsp;&nbsp;<input type="button" value="x" style="color:red;cursor:pointer;" onclick="produceRemove('+next_table+')" /></li>');
      next_table++;
    }
  }
 
  alert("제품이 " + ((total_dev_name.split(',').length) - 1) + "개 추가 선택 되었습니다.")

  opener.document.cform.productSeq.value += name_check + total_dev_seq.substr(0, (total_dev_seq.length - 2));
  opener.document.cform.produce.value += name_check + total_dev_name.substr(0, (total_dev_name.length - 2));
  opener.document.cform.hardware.value += name_check + total_dev_hardware.substr(0, (total_dev_hardware.length - 2));
  opener.document.cform.serial.value += name_check + total_dev_serial.substr(0, (total_dev_serial.length - 2));
  opener.document.cform.version.value += name_check + total_dev_version.substr(0, (total_dev_version.length - 2));
  opener.document.cform.license.value += name_check + total_dev_license.substr(0, (total_dev_license.length - 2));
  opener.document.cform.host.value += name_check + total_dev_host.substr(0, (total_dev_host.length - 2));


  opener.createTable(((total_dev_name.split(',').length) - 1),max_table);

  var productSeq = total_dev_seq.substr(0, (total_dev_seq.length - 2)).split(',');
  for (i = 0; i < (total_dev_name.split(',').length) - 1; i++) {
    opener.template(productSeq[i],(max_table+1)+i);
  }
  opener.textareaSize();
  opener.serialInput();
  self.close();

<?php } ?>



  
}
</script>

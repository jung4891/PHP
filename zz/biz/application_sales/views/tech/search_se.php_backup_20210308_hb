<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_list 김수성
?>
<body>
<form>            
            <table width="890" border="0" style="margin-top:20px;">
              <tr>
                <td class="title3">지원 SE 검색</td>
              </tr>
            </table>
            <table width="50%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="5" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td width="5%" height="40" align="center" class="t_border">선택</td>
                    <td width="15%" align="center" class="t_border">이름</td>
                    <td width="15%" align="center" class="t_border">직책</td>
                  </tr>
		 <?php

			foreach($input as $entry){

?>
                 <tr bgcolor="f8f8f9" class="t_top">

                    <td width="5%" align="center" class="t_border"><input type="checkbox" name="check"></td>
                    <td width="15%" align="center" class="t_border"><input type="hidden" name="user_name"  value="<?php echo $entry->user_name?>"><?php echo $entry->user_name;?></td>
                    <td width="25%" align="center" class="t_border"><input type="hidden" name="user_duty"  value="<?php echo $entry->user_duty?>"><?php echo $entry->user_duty;?></td>
                  </tr>
<?php
			}
		?>

                  <tr>
                    <td colspan="5" height="1" bgcolor="#797c88"></td>
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
function submitCharge(){
	len = document.getElementsByName('check').length;
	total_dev_id="";
	id_check="_";
	total_dev_name="";
	total_dev_duty="";
	name_check=", ";
for(i = 0; i<len-1;i++){

        if(document.getElementsByName('check')[i].checked){
        
        total_dev_name += document.getElementsByName('user_name')[i].value+' ';
        total_dev_name += document.getElementsByName('user_duty')[i].value + name_check;
        }

}

//alert(opener.document.cform.hardware.value);

opener.document.cform.engineer.value=total_dev_name.substr(0,(total_dev_name.length-2));
self.close();
}
</script>

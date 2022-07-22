<?php
        include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
        include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_list 김수성
?>
<body>
<form>
            <table width="890" border="0" style="margin-top:20px;">
              <tr>
                <t class="title3">차 검색</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="5" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td width="5%" height="40" align="center" class="t_border">선택</td>
                    <td width="15%" align="center" class="t_border">차</td>
                    <td width="15%" align="center" class="t_border">차</td>
                  </tr>
                 <?php
print_r($input);
                        foreach($input as $entry){

?>
                 <tr bgcolor="f8f8f9" class="t_top">

                    <td width="5%" align="center" class="t_border"><input type="checkbox" name="check" checked></td>
                    <td width="15%" align="center" class="t_border"><input type="text" name="carnum"  value="<?php echo $entry->carnum?>"><?php echo $entry->carnum;?></td>
                    <td width="15%" align="center" class="t_border"><input type="text" name="a_km"  value="<?php echo $entry->a_km?>"><?php echo $entry->a_km;?></td>
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
window.onload = function(){

	submitCharge();

}


function submitCharge(){
	test_km=document.getElementsByName('a_km')[0].value;

opener.document.cform.d_km.value=test_km;

self.close();
}
</script>



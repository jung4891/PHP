<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_view 김수성  170209
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script language="javascript">

  var k =9;

  var chkForm = function () {
    var mform = document.cform;

    if (mform.product_host.value.indexOf(',') != -1){
      alert("host에 , 를 입력하실 수 없습니다.");
      $("#product_host").focus();
      return false;
    }

    if (mform.product_licence.value.indexOf(',') != -1){
      alert("라이선스에 , 를 입력하실 수 없습니다.");
      $("#product_licence").focus();
      return false;
    }

    if (mform.product_version.value.indexOf(',') != -1){
      alert("Version에 , 를 입력하실 수 없습니다.");
      $("#product_version").focus();
      return false;
    }
  
    var tmp = document.getElementsByName('custom_title[]');
    var tmp2 = document.getElementsByName('custom_detail[]');
    var custom_title_tmp =""
    var custom_detail_tmp =""
    for(var i=0; i<tmp.length ; i++){
      custom_title_tmp+=tmp[i].value;
      custom_detail_tmp+=tmp2[i].value;

      if(i>=0 && i<tmp.length){
        custom_title_tmp+=";;";
        custom_detail_tmp+=";;";

      }
    }
  
    document.getElementsByName('custom_title[]')[0].value=custom_title_tmp;
    document.getElementsByName('custom_detail[]')[0].value=custom_detail_tmp;
    mform.submit();
    return false;
  }

function addRow(){

   table = document.getElementById('input_table');

   rowCount = table.rows.length;
   row = table.insertRow(rowCount-1);
   row.innerHTML = table.rows[k-3].innerHTML;

   rowCount = table.rows.length;
   row = table.insertRow(rowCount-1);
   row.innerHTML = table.rows[k-2].innerHTML;

   rowCount = table.rows.length;
   row = table.insertRow(rowCount-1);
   //row.innerHTML = table.rows[k-1].innerHTML;
   //row.innerHTML = table.rows[k].innerHTML;
   //row.innerHTML = table.rows[k+1].innerHTML;
   k++;
	alert(row.innerHTML);
}

function deleteRow(TABLEID){

 alert("test2");

}
</script>


<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="cform" action="<?php echo site_url();?>/tech_board/tech_device_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
      <input type="hidden" name="seq" value="<?php echo $_GET['seq'];?>">
      <input type="hidden" name="mode" value="modify">
      <?php
        include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
      ?>
          <tr>
            <td align="center" valign="top">

              <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
                <tr>
                 
             <td width="923" align="center" valign="top">


              <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
                <tr>
                  <td class="title3">장비/시스템 보기</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td><table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="4" height="2" bgcolor="#797c88"></td>
                    </tr>
                    <tr>
                     <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사</td>
                     <td class="t_border" style="padding-left:10px;"><?php echo $view_val['customer_companyname'];?></td>
                     <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트명</td>
                     <td width="35%" class="t_border" style="padding-left:10px;"><?php echo $view_val['project_name'];?></td>
                   </tr>
                   <tr>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비명</td>
                    <td width="35%" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_name'];?></td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_item'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_company'];?></td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">Serial Number</td>
                    <td width="35%" height="40" class="t_border" style="padding-left:10px;"><?php echo $view_val['product_serial'];?></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">Version</td>
                    <td width="35%" height="40" class="t_border" ><input type="text" name="product_version" id="product_version" class="input2" style="margin: 10px 10px 10px 10px;" value="<?php echo $view_val['product_version'];?>"/></td>
                    <td idth="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">상태</td>
                    <td width="35%" height="40" class="t_border" ><select name="product_state" id="product_state" class="input5" style="margin: 10px 10px 10px 10px;">
										<option value="0">- 제품 상태 -</option>
											<option value="001" <?php if($view_val['product_state'] == "001") { echo "selected"; }?> >입고 전</option>
											<option value="002" <?php if($view_val['product_state'] == "002") { echo "selected"; }?> >창고</option>
											<option value="003" <?php if($view_val['product_state'] == "003") { echo "selected"; }?> >고객사 출고</option>
											<option value="004" <?php if($view_val['product_state'] == "004") { echo "selected"; }?> >장애반납</option>
										</select></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">라이선스</td>
                    <td width="35%" height="40" class="t_border" ><input type="text" name="product_licence" id="product_licence" class="input2" style="margin: 10px 10px 10px 10px;" value="<?php echo $view_val['product_licence'];?>"/></td>
                    <td idth="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">용도</td>
                    <td width="35%" height="40" class="t_border" ><input type="text" name="product_purpose" class="input2" style="margin: 10px 10px 10px 10px;" value="<?php echo $view_val['product_purpose'];?>"/></td>
                  </tr>
                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">host</td>
                    <td width="35%" height="40" class="t_border" align="left" >
                        <input type="text" id="product_host" class="input2" style="margin: 10px 10px 10px 10px;" name="product_host" value="<?php echo $view_val['product_host']; ?>" />
                    </td>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">점검항목 리스트</td>
                    <td width="35%" height="40" class="t_border" align="left" >
                      <div style="margin: 10px 10px 10px 10px;">
                        <select name="product_check_list" id="product_check_list" class="input2 form-control" >
                          <?php 
                            foreach($check_list as $check_item){
                          ?>
                            <option value="<?php echo $check_item['seq'];?>"<?php if($view_val['product_check_list']== $check_item['seq']){echo " selected" ;} ?>><?php echo $check_item['product_name']; ?></option>
                          <?php
                            }
                          ?>
                        </select>
                        <br>
                        <input type="button" class="input1" value="view" style="cursor:pointer" onclick="checkListView();" />
                        <input type="button" class="input1" value="custom" style="cursor:pointer" onclick="checkListCustom();" />
                      </div>
                    </td>
                  </tr>
                    <td width="85%" height="40" class="t_border" align="center" colspan="3" ><input type="hidden" name="custom_title[]" id="custom_title[]"  style="width:95%;" value=""/></td>
                    <td width="85%" height="40" class="t_border" align="center" colspan="3" ><input type="hidden" name="custom_detail[]" id="custom_detail[]"  style="width:95%;" value=""/></td>
                
<!--                  <tr>
                    <td width="15%" height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">커스터마이징 제목</td>
                    <td width="85%" height="40" class="t_border" align="center" colspan="3" ><input type="text" name="custom_title[]" id="custom_title[]"  style="width:95%;" value=""/></td>
                  </tr>
                  <tr>
                    <td width="100%" height="20" class="t_border" bgcolor="f8f8f9"  align="center"  style="font-weight:bold;" colspan="4">상세내역</td>
                  </tr>
                  <tr>
                    <td width="100%" height="40" class="t_border" align="center" colspan="4"><textarea rows="5" style="width:95%;"  name="custom_detail[]" id="custom_detail[]" value=""/></textarea>
		</td>

                  </tr>
-->
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>

                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
              </tr>
              <td align="right"><?php if(/*$name == $view_val['writer'] ||*/ $lv == 2 | $lv == 3) {?>
                <img src="<?php echo $misc;?>img/btn_add_column3.jpg" width="64" height="31" style="cursor:pointer" onclick="addRow();return false;"/>
                <img src="<?php echo $misc;?>img/btn_add_column4.jpg" width="64" height="31" style="cursor:pointer" onclick="deleteRow('input_table');return false;"/>
                <img src="<?php echo $misc;?>img/btn_adjust.jpg" style="cursor:pointer" border="0" onClick="javascript:chkForm();return false;"/> <?php }?> <img src="<?php echo $misc;?>img/btn_cancel.jpg" border="0" style="cursor:pointer" onClick="javascript:history.go(-1);"/></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>

        </td>
        
      </tr>
    </table>
  </form>

</td>
</tr>
<tr>
  <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
    <tr>
      <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
      <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
    </tr>
  </table></td>
</tr>
</table>
<script>
  //템플릿 검색 기능
  $("#product_check_list").select2();

  //템플릿 뷰
  function checkListView(){
    var seq =  $("#product_check_list").val();
    window.open('/index.php/tech_board/product_check_list_view?seq='+seq,'_blank','height=600,width=1000');
  }

  //템플릿 커스텀
  function checkListCustom(){
    var seq =  $("#product_check_list").val();
    window.open('/index.php/tech_board/product_check_list_custom?seq='+seq);
  }

</script>

</body>
</html>

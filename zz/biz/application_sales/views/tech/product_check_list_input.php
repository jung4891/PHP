<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
  .work_text_table textarea {
    font-family:"Noto Sans KR", sans-serif !important;
    line-height: 150%;
    font-size: 12px;
    color: #333;
    border: none;
    border-right: 0px;
    border-top: 0px;
    border-left: 0px;
    border-bottom: 0px;
    width: 80%;
    height: 20px;
    overflow-y: hidden;
    resize: none;

    /* background: #FFFFFF; */
    /* border: 1px solid #DEDEDE;
    opacity: 1; */
  }

  .work_text_table th{
    background: #EFEFEF 0% 0% no-repeat padding-box;
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
    float:right;
  }

  .title{
    font-family:"Noto Sans KR", sans-serif !important;
    line-height: 150%;
    font-size: 15px;
    margin-right : 10px;
  }

  .tdDivisionBtn{
    float:right;
  }
</style>

<body>
<div style="margin: 50px 50px 50px 50px;">
<form name="cform" action="<?php echo site_url(); ?>/tech/tech_board/product_check_list_input" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<!-- <input type="hidden" name="work_text[]" id="work_text" value="" /> -->
<h2 align="center">
제품별 점검항목 추가
</h2>
<input type="hidden" name="work_text" id="work_text" value="" />
<div style="margin:10px 0 10px 0 ;"><span class="title">제품명</span><input type="text" name="product_name" id="product_name" class="input2" style="border: 1px solid #B0B0B0; border-radius: 19px; opacity: 1;outline: none"></div>
<table id="work_text_table1" class="work_text_table" width=100% border=1 style="border-collapse:collapse;border-right:none;border-left:none;">
  <tr>
    <th height="30"><input value="점검항목" readonly onfocus="javascrpt:blur();"
        style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input>
    </th>
    <th colspan="2" height="30"><input value="점검내용" readonly onfocus="javascrpt:blur();"
        style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input>
    </th>
    <th height="30"><input value="점검결과" readonly onfocus="javascrpt:blur();"
        style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input>
    </th>
    <th height="30"><input value="특이사항" readonly onfocus="javascrpt:blur();"
        style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input>
    </th>
  </tr>
  <?php
    $basicFormIdx = 1;
    $check = explode(',',"기타 특이사항,CPU,메모리,디스크,LAN,UPTIME,SW데몬상태");
    for($i=1; $i<count($check); $i++){
      echo '<tr class="check'.$i.'">';
      echo '<td class="tdSolid"><input name="work_text'.$i.'[]" value="'.$check[$i].'" style="width:80%"/><img src="'.$misc.'img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,1);"/></td><td class="tdSolid" colspan="2"><textarea name="work_text'.$i.'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="'.$misc.'img/dashboard/btn/icon_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'.$i.');"/></td>';
      echo '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">';
      echo '<input type="hidden" name="work_text'.$i.'[]" value="normal"><input type="radio" name="produce1_'.$i.'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce1_'.$i.'" value="abnormal" onclick="normalCheck(this);">비정상</div></td>';
      echo '<td class="tdSolid"><textarea name="work_text'.$i.'[]" onkeyup="xSize(this);"></textarea></td>';
      echo '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td>';
      echo '<td align="center" class ="adddelbtn" ><img src="'.$misc.'img/dashboard/btn/icon_plus.svg" onclick ="check_add(this,1)" style="cursor:pointer;" /></td></tr>';
      $basicFormIdx++;
    }
    echo '<tr class="check0" height="80"><td class="tdSolid"><input name="work_text0[]" value= "기타 특이사항" readonly onfocus="javascrpt:blur();"></td><td colspan="4"><textarea name="work_text0[]" rows="5" style="width:95%;height:100%"></textarea></td></tr>';
  ?>
    </table>
<div style="text-align:center;"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_plus.svg" id="trPlusBtn" onclick="trPlus();"/></div><br>
<div align="center"><input type="image" src="<?php echo $misc; ?>img/dashboard/btn/btn_add.png" width="70" height="35" style="cursor:pointer;" onClick="javascript:chkForm();return false;" /></div>
</form>
</div>
<script>
  function trPlus(){
    var tableNum = 1;
    var currentTable;
    while($('#work_text_table'+tableNum).length != 0){
      if($('#work_text_table'+tableNum).is(":visible")){//display none 아님
        currentTable = tableNum
      }
      tableNum++;
    }

    var check = [];
    for(i=0; i<$("[class*='check']").length; i++){
      check[i]=$("[class*='check']").eq(i).attr('class').replace("check","");
    }
    var check_Idx =Number(Math.max.apply(null, check))+1;

    var normalCheck = [];
    for(i=0; i<$("[name*='produce1']").length; i++){
      normalCheck[i]=$("[name*='produce1']").eq(i).attr('name').replace("produce1_","");
    }
    var normalCheck_idx = Number(Math.max.apply(null, normalCheck))+1;

    var lastTr = $("#work_text_table"+currentTable).find("tr:last").prev();
    lastTr.after('<tr class="check'+check_Idx+'"><td class="tdSolid"><input name="work_text'+check_Idx+'[]" style="width:80%"/><img src="<?php echo $misc; ?>img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,'+currentTable+');" /></td><td class="tdSolid" colspan="2"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/btn/icon_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+check_Idx+');"/></td><td class="tdSolid"> <div style ="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'+check_Idx+'[]" value="normal"><input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상</div></td><td class="tdSolid"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);"></textarea></td><td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td><td align="center" class ="adddelbtn"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_plus.svg" onclick ="check_add(this,'+currentTable+')" style="cursor:pointer;" /></td></tr>')
  }

  function trRemove(btn,tableNum){
    var thisTr = $(btn).parent().parent();
    var trClass = thisTr.attr("class");
    $('#work_text_table'+tableNum).find($("."+trClass)).remove();
    // thisTr.remove();
  }

  function check_add(btn,tableNum) {
    var normalCheck = [];
    for(i=0; i<$("[name*='produce1']").length; i++){
      normalCheck[i]=$("[name*='produce1']").eq(i).attr('name').replace("produce1_","");
    }
    var normalCheck_idx = Number(Math.max.apply(null, normalCheck))+1;

    var tr =$(btn).parent().parent();
    var trClass = tr.attr('class');
    var trNum = trClass.substring(5);
    var nextTr = Number(trNum)+1;
    // if($('#work_text_table'+tableNum).find($(".check"+nextTr)).length != 0){
      $('#work_text_table'+tableNum).find($("."+trClass)).last().after('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/btn/icon_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
      <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
      <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
      </div></td>\
      <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
      <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td> \
      <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
    // }else{
    //   $('#work_text_table'+tableNum).find($(".check0")).before('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
    //   <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
    //   <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
    //   <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
    //   <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
    //   </div></td>\
    //   <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
    //   <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td> \
    //   <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
    // }

    var rowspan;
    if(tr.children(":first").attr("rowSpan")==undefined){
      rowspan = 1;
    }else{
      rowspan = Number(tr.children(":first").attr("rowSpan"));
    }
    var rowspanChange =tr.children(":first").attr("rowspan",rowspan+1)
  }

  function check_del(btn) {
      var tr =$(btn).parent().parent();
      var trClass = tr.attr('class')
      var rowspan = Number(tr.parent().children('.'+trClass).eq(0).children(":first").attr("rowSpan"));
      var rowspanChange = (tr.parent().children('.'+trClass).eq(0)).children(":first").attr("rowSpan",rowspan-1)
      tr.remove();
  }

  function tdDivision(btn,num) {
    var td =$(btn).parent();
    btn.remove();
    td.attr("colspan",1);
    var txt = '<td class="tdSolid"><input type="hidden" name="work_text'+num+'[]" value="::">'+td.html()+'<img src="<?php echo $misc;?>img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'+num+');"/></td>';
    $(td).after(txt);
  }

  function tdMerge(btn,num) {
    var td =$(btn).parent();
    btn.remove();
    var txt= $($(td).prev().children('textarea')).val();
    $(td).prev().remove();
    $(td).children('input').remove();
    td.attr("colspan",2);
    $(td).children('textarea').val(txt+$(td).children('textarea').val());
    td.append('<img src="<?php echo $misc;?>img/dashboard/btn/icon_minus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+num+');"/>');
  }

  //textarea 스크롤바없이 높이 조정
  function xSize(e){
    e.style.height = '1px';
    e.style.height = (e.scrollHeight + 12) + 'px';
  }

  function chkForm(){
    var mform = document.cform;
    var maxCheckidx = Number($(".check0").prev().attr("class").replace("check", ""));
    document.getElementsByName('work_text').value = "";
    var num = 1;
    while ($('#work_text_table' + num).length != 0) {
      // while ($('#work_text_table' + num).find('[name="work_text' + i + "[]" + '"]').length != 0) {
      for (i = 0; i <= maxCheckidx; i++) {
        if ($('#work_text_table' + num).find('[name="work_text' + i + "[]" + '"]').length != 0) {
          var j = 0;
          while ($('#work_text_table' + num).find('[name="work_text' + i + "[]" + '"]').eq(j).length != 0) {
            if (j == 0) {
              document.getElementsByName('work_text').value += '@@#*' + $('#work_text_table' + num).find('[name="work_text' + i + "[]" + '"]').eq(j).val().replace(/\n/g, '<br/>');
            } else {
              document.getElementsByName('work_text').value += '#*' + $('#work_text_table' + num).find('[name="work_text' + i + "[]" + '"]').eq(j).val().replace(/\n/g, '<br/>');
            }
            j++;
          }
        }
      }
      num++;
    }

    document.getElementsByName('work_text').value = replaceAll(document.getElementsByName('work_text').value, "#*::#*", "::")
    mform.work_text.value = document.getElementsByName('work_text').value;

    document.forms['cform'].action="<?php echo site_url(); ?>/tech/tech_board/product_check_list_input_action";
    document.forms['cform'].target="_blank";
    document.forms['cform'].submit();
  }

  function replaceAll(str, searchStr, replaceStr) {
    return str.split(searchStr).join(replaceStr);
  }
</script>
</body>
</html>

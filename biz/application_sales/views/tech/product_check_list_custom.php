<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
  .work_text_table textarea {
    font-family: 'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif;
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
    font-family: 'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif;
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
<input type="hidden" name="work_text" id="work_text" value="" />
<div style="margin:10px 0 10px 0 ;"><span class="title">제품명</span><input type="text" name="product_name" id="product_name" class="input2" value="" ></div>
<?php
    function br2nl($string){
      return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }
    $total_process_text = rtrim(str_replace(';','',br2nl($view_val[0]['check_list'])),'|');
    $total_process_text = explode('|||',$total_process_text); // 제품별 나누기
    for($a=0; $a<count($total_process_text); $a++){
  ?>
    <table id="work_text_table<?php echo ($a+1) ;?>" class="work_text_table" width=100% border=1 style="border-collapse:collapse;border-right:none;border-left:none;">
      <tr>
        <th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
        <th colspan="2" height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;" ></input></th>
        <th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
        <th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
      </tr>
      <?php
        $basicFormIdx=0;
        $normalIdx=0;
          $process_text = explode('@@',$total_process_text[$a]);
          for($i=1; $i<count($process_text); $i++){
            $basicFormIdx=$basicFormIdx+1;
            $normalIdx=$normalIdx+1;
            $process_text1 = explode('#*',$process_text[$i]); //점검 내용 별로 나누기
              if($i <> 1){ //기타 특이사항을 제외한 나머지
                  $process_text1 = explode('#*',$process_text[$i]);

                  for($j=1; $j<count($process_text1); $j++){
                    if($j==1){
                        echo '<tr class="check'.($i-1).'"><td class="tdSolid" rowspan="'.floor((count($process_text1)-1)/3).'"><input name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'" style="width:70%"></input><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,'.($a+1).');" /></td>'; //cpu, 메모리

                    }elseif($j<=4){ //점검항목 중 첫번째 점검내용
                        if($j!=4){
                          if($j%3==0){
                              echo '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'">
                                  <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="normal" onclick="normalCheck(this);"'.($process_text1[$j]=="normal"?'checked="checked"':'').'>정상
                                  <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="abnormal" onclick="normalCheck(this);"'.($process_text1[$j]=="abnormal"?'checked="checked"':'').'>비정상</div></td>';
                          }else{
                            if(strpos($process_text1[$j],"::") === false){
                              if($process_text1[$j] == "::"){
                                $text = explode('::',$process_text1[$j]);
                                echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                                echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                              }else{
                                echo '<td class="tdSolid" colspan="2"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea><img src="'.$misc.'img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'.($basicFormIdx-1).');" /></td>';
                              }
                            }else{
                              $text = explode('::',$process_text1[$j]);
                              echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                              echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                            }
                          }
                        }else{
                          echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>';
                          echo '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td><td align="center" class ="adddelbtn" ><img src="'.$misc.'img/btn_add.jpg" onclick ="check_add(this,'.($a+1).')" style="cursor:pointer;" /></td></tr>';
                        }
                    }else{ //점검 항목 중 첫번 째가 아닌 나머지들
                        if($j%3==2){
                          $normalIdx=$normalIdx+1;
                          if(strpos($process_text1[$j],"::") === false){
                            if($process_text1[$j] == "::"){
                              $text = explode('::',$process_text1[$j]);
                              echo '<tr class="check'.($i-1).'"><td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                              echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                            }else{
                              echo '<tr class="check'.($i-1).'"><td class="tdSolid" colspan="2"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea><img src="'.$misc.'img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'.($basicFormIdx-1).');" /></td>';
                            }
                          }else{
                            $text = explode('::',$process_text1[$j]);
                            echo '<tr class="check'.($i-1).'"><td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                            echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                          }
                        }elseif($j%3==0){
                          echo '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'">
                                  <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="normal" onclick="normalCheck(this);"'.($process_text1[$j]=="normal"?'checked="checked"':'').'>정상
                                  <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="abnormal" onclick="normalCheck(this);"'.($process_text1[$j]=="abnormal"?'checked="checked"':'').'>비정상</div></td>';
                        }elseif($j%3==1){
                          echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>
                                  <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td>
                                  <td align="center;" class ="adddelbtn"><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>';
                        }
                    }
                  }
              }
          }

          //기타 특이사항
          for($i=1; $i<count($process_text); $i++){
            if($i == 1){
              $process_text1 = explode('#*',$process_text[1]);
              for($j=1; $j<count($process_text1); $j++){
                if($j+1 <> count($process_text1)){
                    echo '<tr class="check0" class="check'.(count($process_text)-1).'"><td class="tdSolid"><input name="work_text0[]" value="'.$process_text1[$j].'"></input></td>';
                }else{
                    echo '<td class="tdSolid" colspan="4"><textarea name="work_text0[]" onkeyup="xSize(this);" >'.$process_text1[$j].'</textarea></td></tr>';
                }
              }
            }
          }
        ?>
    </table>
    <?php
      }
    ?>
<div style="text-align:center"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="trPlusBtn" onclick="trPlus();"/></div>
<div><input type="image" src="<?php echo $misc; ?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;" /></div>
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
    lastTr.after('<tr class="check'+check_Idx+'"><td class="tdSolid"><input name="work_text'+check_Idx+'[]" style="width:80%"/><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,'+currentTable+');" /></td><td class="tdSolid" colspan="2"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+check_Idx+');"/></td><td class="tdSolid"> <div style ="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'+check_Idx+'[]" value="normal"><input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상</div></td><td class="tdSolid"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);"></textarea></td><td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td><td align="center" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_add.jpg" onclick ="check_add(this,'+currentTable+')" style="cursor:pointer;" /></td></tr>')
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
      $('#work_text_table'+tableNum).find($("."+trClass)).last().after('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
      <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
      <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
      </div></td>\
      <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
      <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td> \
      <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
    // }else{
    //   $('#work_text_table'+tableNum).find($(".check0")).before('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
    //   <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
    //   <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
    //   <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
    //   <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
    //   </div></td>\
    //   <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
    //   <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td> \
    //   <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
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
    var txt = '<td class="tdSolid"><input type="hidden" name="work_text'+num+'[]" value="::">'+td.html()+'<img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'+num+');"/></td>';
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
    td.append('<img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+num+');"/>');
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

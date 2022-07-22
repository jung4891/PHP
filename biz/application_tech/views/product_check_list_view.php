<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  // tech_device_list 김수성
?>
<style>
  #work_text_table textarea {
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
<form name="cform" action="<?php echo site_url(); ?>/tech_board/product_check_list_input" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
<!-- <input type="hidden" name="work_text[]" id="work_text" value="" /> -->
<input type="hidden" name="work_text" id="work_text" value="" />
<div style="margin:10px 0 10px 0 ;"><span class="title">제품명</span><input type="text" name="product_name" id="product_name" class="input2" value="<?php echo $check_item[0]['product_name'] ;?>" ></div>
<table id="work_text_table" width=100% border=1 style="border-collapse:collapse;border-right:none;border-left:none;">
<tr>
    <tr>
        <th height="30" bgcolor="f8f8f9"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
        <th colspan="2" height="30" bgcolor="f8f8f9"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;" ></input></th>
        <th height="30" bgcolor="f8f8f9"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
        <th height="30" bgcolor="f8f8f9"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
    </tr>
    <?php
    $basicFormIdx=0;
        function br2nl($string) {
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string); 
        } 
    
        $process_text = explode('@@',str_replace(';','',br2nl($check_item[0]['check_list'])));

        for($i=1; $i<count($process_text); $i++){
          $basicFormIdx=$basicFormIdx+1;
          $process_text1 = explode('#*',$process_text[$i]); //점검 내용 별로 나누기
            if($i <> 1){ //기타 특이사항을 제외한 나머지
                $process_text1 = explode('#*',$process_text[$i]);

                for($j=1; $j<count($process_text1); $j++){
                  if($j==1){
                      echo '<tr class="check'.($i-1).'"><td rowspan="'.floor((count($process_text1)-1)/3).'"><input name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'" style="width:70%"></input></td>'; //cpu, 메모리 

                  }elseif($j<=4){ //점검항목 중 첫번째 점검내용 
                      if($j!=4){
                        if($j%3==0){
                            echo '<td><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'">
                                <input type="radio" name="normalCheck'.($basicFormIdx-1).'" value="normal" onclick="normalCheck(this);"'.($process_text1[$j]=="normal"?'checked="checked"':'').'>정상
                                <input type="radio" name="normalCheck'.($basicFormIdx-1).'" value="abnormal" onclick="normalCheck(this);"'.($process_text1[$j]=="abnormal"?'checked="checked"':'').'>비정상</div></td>';
                        }else{
                          if(strpos($process_text1[$j],"::") === false){
                            echo '<td colspan="2"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>';
                          }else{
                            $text = explode('::',$process_text1[$j]);
                            echo '<td><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                            echo '<td><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea></td>';
                          }
                        }
                      }else{
                        echo '<td><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>';
                        echo '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td>
                        <td align="center" class ="adddelbtn" ></td></tr>'; 
                      }
                  }else{ //점검 항목 중 첫번 째가 아닌 나머지들 
                      if($j%3==2){
                        $basicFormIdx=$basicFormIdx+1;
                        if(strpos($process_text1[$j],"::") === false){
                          echo '<tr class="check'.($i-1).'"><td colspan="2"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>';
                        }else{
                          $text = explode('::',$process_text1[$j]);
                          echo '<tr class="check'.($i-1).'"><td><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                          echo '<td><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea></td>';
                        }
                      }elseif($j%3==0){
                        echo '<td><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'">
                                <input type="radio" name="normalCheck'.($basicFormIdx-1).'" value="normal" onclick="normalCheck(this);"'.($process_text1[$j]=="normal"?'checked="checked"':'').'>정상
                                <input type="radio" name="normalCheck'.($basicFormIdx-1).'" value="abnormal" onclick="normalCheck(this);"'.($process_text1[$j]=="abnormal"?'checked="checked"':'').'>비정상</div></td>';
                      }elseif($j%3==1){
                        echo '<td><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>
                                <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td>
                                <td align="center;" class ="adddelbtn"></td></tr>';
                      }
                  }          
                }
            }  
        }

        //기타 특이사항
        $process_text1 = explode('#*',$process_text[1]);
        for($j=1; $j<count($process_text1); $j++){
          if($j+1 <> count($process_text1)){
              echo '<tr class="check0" class="check'.(count($process_text)-1).'"><td><input name="work_text0[]" value="'.$process_text1[$j].'"></input></td>';
          }else{
              echo '<td colspan="4"><textarea name="work_text0[]" onkeyup="xSize(this);" >'.$process_text1[$j].'</textarea></td></tr>';
          } 
        }
    ?>
  </td>
</tr>
</table>
</form>
</div>
</body>
</html>

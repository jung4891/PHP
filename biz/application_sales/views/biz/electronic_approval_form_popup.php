<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($template != ''){
    $n = explode('|',$template);
    $template_data = explode('$$',$template);
    if(!empty($template_data[1])){
        ${"parallel".$n[0]} = $template_data[1];
    } 
    ${"template".$n[0]} = explode('|',$template_data[0]);
  }
  function br2nl($string) {
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string); 
  } 
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .tabs {position: relative;margin: 35px auto;width: 600px;}
   .tabs_input {position: absolute;z-index: 1000;width: 120px;height: 35px;left: 0px;top: 0px;opacity: 0;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);}
   .tabs_input:not(:checked) {cursor: pointer;}
   .tabs_input:not(:checked) + label {color:#fff;}
   .tabs_input:not(:checked) + label {background: #f8f8f9;color:#777;z-index: 6;}
   .tabs_input:hover + label {background: #666666;color:#fff;}
   .tabs_input#tab-2{left: 120px;}
   .tabs_input#tab-3{left: 240px;}
   .tabs_input#tab-4{left: 360px;}
   .tabs_input#tab-5{left: 480px;}
   .tabs_input#tab-6{left: 600px;}
   .tabs_input#tab-7{left: 720px;}
   .tabs_input.tab-selector-1:checked ~ .content .content-1,
   .tabs_input.tab-selector-2:checked ~ .content .content-2,
   .tabs_input.tab-selector-3:checked ~ .content .content-3,
   .tabs_input.tab-selector-4:checked ~ .content .content-4,
   .tabs_input.tab-selector-5:checked ~ .content .content-5,
   .tabs_input.tab-selector-6:checked ~ .content .content-6,
   .tabs_input.tab-selector-7:checked ~ .content .content-7
   {z-index: 100;filter: alpha(opacity=100);opacity: 1;}

   .tabs label {background:#666666;color:#fff;font-size: 14px;line-height: 35px;height: 35px;position: relative;padding: 0 20px;float: left;display: block;width: 80px;letter-spacing: 0px;text-align: center;border-radius: 12px 12px 0 0;box-shadow: 2px 0 2px rgba(0,0,0,0.1), -2px 0 2px rgba(0,0,0,0.1);}
   .tabs label:after {content: '';background: #fff;position: absolute;bottom: -2px;left: 0;width: 100%;height: 2px;display: block;}
   .tabs label:first-of-type {z-index: 4;box-shadow: 1px 0 3px rgba(0,0,0,0.1);}

   .tab-label-1 {z-index: 1;}
   .tab-label-2 {z-index: 2;}
   .tab-label-3 {z-index: 3;}
   .tab-label-4 {z-index: 4;}
   .tab-label-5 {z-index: 5;}
   .tab-label-6 {z-index: 6;}
   .tab-label-7 {z-index: 7;}


   .clear-shadow {clear: both;}

   .content {background: #fff;position: relative;width: 100%; height:auto; min-height:400px;overflow: auto;z-index: 999;box-shadow: 0 -2px 3px -2px rgba(0,0,0,0.2), 0 2px 2px rgba(0,0,0,0.1);border-radius: 0 12px 3px 3px;}
   /* .content div {width:100%;position: absolute;top: 0;left: 0;padding: 10px 40px;z-index: 1;opacity: 0;box-sizing: border-box;} */
   /* .content div:not(.summernote) {width:100%;position: absolute;left: 0;padding: 10px 40px;z-index: 1;opacity: 0;box-sizing: border-box;} */
   .content div h3{color: #398080;border-bottom:1px solid rgba(63,148,148, 0.1);}
   .content div h3:before{content: " - ";}
   .content div p {font-size: 14px;line-height: 22px;text-align: left;margin: 0;color: #777;padding-left: 15px;}
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">  
<body>
    <section class="tabs" style="width:90%">
    <input id="tab-1" type="radio" name="radio-set" value="1" class="tab-selector-1 tabs_input" onclick="tab_change(1);" <?php if(isset($template1)){if($template1[0] == 1){echo "checked"; }}else{echo "checked";} ?> />
    <label for="tab-1" class="tab-label-1">?????????</label>
    <input id="tab-2" type="radio" name="radio-set" value="2" class="tab-selector-2 tabs_input" onclick="tab_change(2);" <?php if(isset($template2)){if($template2[0] == 2){echo "checked"; }} ?> <?php if($multi == "Y"){echo "style='display:none'";} ?>/>
    <label for="tab-2" class="tab-label-2" <?php if($multi == "Y"){echo "style='display:none'";} ?>>???????????????</label>
    <input id="tab-3" type="radio" name="radio-set" value="3" class="tab-selector-3 tabs_input" onclick="tab_change(3);" <?php if(isset($template3)){if($template3[0] == 3){echo "checked"; }} ?>  <?php if($multi== "Y"){echo "style='display:none'";} ?> />
    <label for="tab-3" class="tab-label-3" value="1" >?????????</label>
    <input id="tab-4" type="radio" name="radio-set" value="4"  class="tab-selector-4 tabs_input" onclick="tab_change(4);" <?php if(isset($template4)){if($template4[0] == 4){echo "checked"; }} ?> <?php if($multi== "Y"){echo "style='display:none'";} ?> />
    <label for="tab-4" class="tab-label-4" <?php if($multi == "Y"){echo "style='display:none'";} ?>>?????????</label>
    <input id="tab-5" type="radio" name="radio-set" value="5"  class="tab-selector-5 tabs_input" onclick="tab_change(5);" <?php if(isset($template5)){if($template5[0] == 5){echo "checked"; }} ?> <?php if($multi == "Y"){echo "style='display:none'";} ?> />
    <label for="tab-5" class="tab-label-5" <?php if($multi == "Y"){echo "style='display:none'";} ?>>????????????</label>
    <input id="tab-6" type="radio" name="radio-set" value="6"  class="tab-selector-6 tabs_input" onclick="tab_change(6);" <?php if(isset($template6)){if($template6[0] == 6){echo "checked"; }} ?> <?php if($multi == "Y"){echo "style='display:none'";} ?> />
    <label for="tab-6" class="tab-label-6" <?php if($multi == "Y"){echo "style='display:none'";} ?>>?????????</label>
    <input id="tab-7" type="radio" name="radio-set" value="7"  class="tab-selector-7 tabs_input" onclick="tab_change(7);" <?php if(isset($template7)){if($template7[0] == 7){echo "checked"; }} ?> <?php if($multi == "Y"){echo "style='display:none'";} ?> />
    <label for="tab-7" class="tab-label-7" <?php if($multi == "Y"){echo "style='display:none'";} ?>>????????????</label>
    <div class="clear-shadow"></div>
    <div class="content">
        <div class="content-1 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel1" id="parallel1" value="Y" <?php if(isset($parallel1)){if($parallel1 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel1" id="parallel1" value="N" <?php if(isset($parallel1)){if($parallel1 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name1" id="column_name1" class="input2" style="height:85%" value="<?php if(isset($template1)){echo $template1[1];}?>">
                        <input name="column_name_hide1" id="column_name_hide1" type="checkbox" value="Y" <?php if(isset($template1)){if($template1[2] == 'Y'){echo "checked";}} ?> > ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="essential1" id="essential1" value="Y" <?php if(isset($template1)){if($template1[3] == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="essential1" id="essential1" value="N" <?php if(isset($template1)){if($template1[3] == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr> 
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">????????????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                       <?php 
                        if(isset($template1) && strpos($template1[4],"//") !== false){
                            $expression_option = explode("//",$template1[4]);
                            $template1[4] =$expression_option[0];
                            $point = $expression_option[1];
                            $roundup = $expression_option[2];
                        }
                       ?>
                       <select name="input_type1" id="input_type1" class="input2" onchange="inputType(this.value);">
                           <option value="0" <?php if(isset($template1)){if($template1[4] == '0'){echo "selected";}} ?> >??????</option>
                           <option value="1" <?php if(isset($template1)){if($template1[4] == '1'){echo "selected";}} ?>>??????</option>
                           <option value="2" <?php if(isset($template1)){if($template1[4] == '2'){echo "selected";}} ?>>??????(???????????????)</option>
                           <option value="3" <?php if(isset($template1)){if($template1[4] == '3'){echo "selected";}} ?>>??????</option>
                           <option value="4" <?php if(isset($template1)){if($template1[4] == '4'){echo "selected";}} ?>>??????</option>
                           <option value="5" <?php if(isset($template1)){if($template1[4] == '5'){echo "selected";}} ?>>?????????</option>
                           <option value="6" <?php if(isset($template1)){if($template1[4] == '6'){echo "selected";}} ?>>????????????</option>
                           <option value="7" <?php if(isset($template1)){if($template1[4] == '7'){echo "selected";}} ?>>????????????</option>  
                           <option value="8" <?php if(isset($template1)){if($template1[4] == '8'){echo "selected";}} ?>>?????????</option>
                       </select>
                        <span id="expression" <?php if(!isset($point)){echo "style='display:none;'";} ?>>
                            * ???????????? ????????? ??????????????????<br>
                            ?????? ????????? :                        
                            <select name="point1" id="point1" class="input5">
                                <?php for($i=0; $i <10; $i++){
                                    $option = "<option value='{$i}'";
                                    if(isset($point)){
                                        if($i == $point){
                                            $option .= "selected";
                                        }
                                    }
                                    $option .= ">{$i}</option>";
                                    echo $option;
                                }
                                ?>
                            </select><br> 
                            ?????????,??????,?????? ?????? :
                            <select name="roundup1" id="roundup1" class="input5">
                                <option value="round" <?php if(isset($template1) && isset($roundup) && $roundup == "round"){echo "selected";} ?>>?????????</option>
                                <option value="up" <?php if(isset($template1) && isset($roundup) && $roundup == "up"){echo "selected";} ?>>??????</option>
                                <option value="down" <?php if(isset($template1) && isset($roundup) && $roundup == "down"){echo "selected";} ?>>??????</option>
                            </select> 
                        </span>

                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="default1" id="default1" class="input2" value="<?php if(isset($template1)){echo $template1[5];} ?>" style="height:85%">
                        <span id="default1_comment" style='display:none;'>  ex) [tr1_td1]+10 , ex) [tr1_td1]+[tr1_td2] </span>
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="width1" id="width1" class="input2" style="height:85%" value="<?php if(isset($template1)){echo $template1[6];} ?>">
                        <input type="radio" name="width_type1" value="px" <?php if(isset($template1)){if($template1[7] == 'px'){echo "checked";}}else{echo "checked";}?> />pixcel
                        <input type="radio" name="width_type1" value="%" <?php if(isset($template1)){if($template1[7] == '%'){echo "checked";}} ?> />percent
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="maximum1" id="maximum1" class="input2" value="<?php if(isset($template1)){echo $template1[8];} ?>" style="height:85%"> (???)
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment1" id="comment1" class="input7 summernote" style="height:85%"><?php if(isset($template1)){echo br2nl($template1[9]);} ?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="content-2 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel2" id="parallel2" value="Y" <?php if(isset($parallel2)){if($parallel2 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel2" id="parallel2" value="N" <?php if(isset($parallel2)){if($parallel2 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????? </td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name2" id="column_name2" class="input2" style="height:85%" value="<?php if(isset($template2)){echo $template2[1];}?>">
                        <input name="column_name_hide2" id="column_name_hide2" type="checkbox" value="Y" <?php if(isset($template2)){if($template2[2] == 'Y'){echo "checked";}} ?>> ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="essential2" id="essential2" value="Y"  <?php if(isset($template2)){if($template2[3] == 'Y'){echo "checked";}} ?> />???
                        <input type="radio" name="essential2" id="essential2" value="N"  <?php if(isset($template2)){if($template2[3] == 'N'){echo "checked";}}else{ echo "checked";} ?> />?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="width2" id="width2" class="input2" value="<?php if(isset($template2)){echo $template2[4];}?>" style="height:85%">
                        <input type="radio" name="width_type2" value="px"  <?php if(isset($template2)){if($template2[5] == 'px'){echo "checked";}}else{echo "checked";}?> />pixcel
                        <input type="radio" name="width_type2" value="%" <?php if(isset($template2)){if($template2[5] == '%'){echo "checked";}} ?>/>percent
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="height2" id="height2" class="input2" style="height:85%" value="<?php if(isset($template2)){echo $template2[6];}?>">(px)
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">template</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="template2" id="template2" class="input7" style="height:85%"><?php if(isset($template2)){echo $template2[7];}?></textarea> 
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment2" id="comment2" class="input7 summernote" style="height:85%"><?php if(isset($template2)){echo br2nl($template2[8]);}?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="content-3 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel3" id="parallel3" value="Y" <?php if(isset($parallel3)){if($parallel3 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel3" id="parallel3" value="N" <?php if(isset($parallel3)){if($parallel3 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????? </td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name3" id="column_name3" class="input2" style="height:85%" value="<?php if(isset($template3)){echo $template3[1];}?>">
                        <input name="column_name_hide3" id="column_name_hide3" type="checkbox" value="Y" <?php if(isset($template3)){if($template3[2] == 'Y'){echo "checked";}} ?>> ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="essential3" id="essential3" value="Y" <?php if(isset($template3)){if($template3[3] == 'Y'){echo "checked";}} ?> />???
                        <input type="radio" name="essential3" id="essential3" value="N" <?php if(isset($template3)){if($template3[3] == 'N'){echo "checked";}}else{ echo "checked";} ?> />?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="100" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="120" class="basic_td" align="left" style="font-weight:bold;" >
                        ????????? : <input type="radio" disabled="disabled"/>
                        <input name="option_input3" id="option_input3" class="input2" onkeypress="enter();">
                        <input type="button" value="??????" onclick="option_add();">  &nbsp; * ?????? drag&drop ???????????? ??????
                        <input type="hidden" id="check_option3" name="check_option3">
                        <br>
                        <ul id="sortable3" class="sortable" style="overflow-y:scroll;height:120px;">
                        <?php if(isset($template3)){
                            $option = explode('**',$template3[4]);
                            for($i=0; $i<count($option); $i++){
                                $default = explode('//',$option[$i]);
                                $default = $default[0];
                                $input= explode('//',$option[$i]);
                                $input=$input[1];
                        ?>
                            <li id='li<?php echo $i+1; ?>' style='cursor:pointer;' onclick='click_option(this.id);'>
                                <input type='radio' name='default_option<?php echo $template3[0]; ?>' id='li<?php echo $i+1; ?>_selected' <?php if($default == 'true'){echo "checked";} ?>>
                                <input name='option<?php echo $template3[0]; ?>' id='li<?php echo $i+1; ?>_input' class='input2' type='text' value='<?php echo $input; ?>' style='border: none; background: transparent;'>
                            </li>
                        <?php }} ?>
                        </ul>
                        <br>
                        <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer;width:50px;float:right;margin-right:35px;" border="0" onClick="delete_option();"/>
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment3" id="comment3" class="input7 summernote" style="height:85%"><?php if(isset($template3)){echo br2nl($template3[5]);}?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="content-4 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel4" id="parallel4" value="Y" <?php if(isset($parallel4)){if($parallel4 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel4" id="parallel4" value="N" <?php if(isset($parallel4)){if($parallel4 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????? </td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name4" id="column_name4" class="input2" style="height:85%" value="<?php if(isset($template4)){echo $template4[1];}?>">
                        <input name="column_name_hide4" id="column_name_hide4" type="checkbox" value="Y" <?php if(isset($template4)){if($template4[2] == 'Y'){echo "checked";}} ?>> ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="essential4" value="Y" <?php if(isset($template4)){if($template4[3] == 'Y'){echo "checked";}} ?> />???
                        <input type="radio" name="essential4" value="N" <?php if(isset($template4)){if($template4[3] == 'N'){echo "checked";}}else{ echo "checked";} ?> />?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="sort4" value="horizontal" <?php if(isset($template4)){if($template4[4] == 'horizontal'){echo "checked";}}else{ echo "checked";} ?> />??????
                        <input type="radio" name="sort4" value="verticality" <?php if(isset($template4)){if($template4[4] == 'verticality'){echo "checked";}} ?>/>??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="100" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="120" class="basic_td" align="left" style="font-weight:bold;" >
                        ????????? : <input type="radio" disabled="disabled"/>
                        <input name="option_input4" id="option_input4" class="input2" onkeypress="enter();" >
                        <input type="button" value="??????" onclick="option_add();">  &nbsp; * ?????? drag&drop ???????????? ??????
                        <input type="hidden" id="check_option4" name="check_option4">
                        <br>
                        <ul id="sortable4" class="sortable" style="overflow-y:scroll;height:120px;">
                        <?php if(isset($template4)){
                            $option = explode('**',$template4[5]);
                            for($i=0; $i<count($option); $i++){
                                $default = explode('//',$option[$i]);
                                $default=$default[0];
                                $input= explode('//',$option[$i]);
                                $input= $input[1];
                        ?>
                            <li id='li<?php echo $i+1; ?>' style='cursor:pointer;' onclick='click_option(this.id);'>
                                <input type='radio' name='default_option<?php echo $template4[0]; ?>' id='li<?php echo $i+1; ?>_selected' <?php if($default == 'true'){echo "checked";} ?>>
                                <input name='option<?php echo $template4[0]; ?>' id='li<?php echo $i+1; ?>_input' class='input2' type='text' value='<?php echo $input; ?>' style='border: none; background: transparent;'>
                            </li>
                        <?php }} ?>
                        </ul>
                        <br>
                        <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer;width:50px;float:right;margin-right:35px;" border="0" onClick="delete_option();"/>
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment4" id="comment4" class="input7 summernote" style="height:85%"><?php if(isset($template4)){echo br2nl($template4[6]);}?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="content-5 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel5" id="parallel5" value="Y" <?php if(isset($parallel5)){if($parallel5 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel5" id="parallel5" value="N" <?php if(isset($parallel5)){if($parallel5 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????? </td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name5" id="column_name5" class="input2" style="height:85%" value="<?php if(isset($template5)){echo $template5[1];}?>">
                        <input name="column_name_hide5" id="column_name_hide5" type="checkbox" value="Y" <?php if(isset($template5)){if($template5[2] == 'Y'){echo "checked";}} ?>> ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="sort5" value="horizontal" <?php if(isset($template5)){if($template5[3] == 'horizontal'){echo "checked";}}else{ echo "checked";} ?> />??????
                        <input type="radio" name="sort5" value="verticality" <?php if(isset($template5)){if($template5[3] == 'verticality'){echo "checked";}} ?>/>??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="100" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="120" class="basic_td" align="left" style="font-weight:bold;" >
                        ????????? : <input type="radio" disabled="disabled"/>
                        <input name="option_input5" id="option_input5" class="input2" onkeypress="enter();" >
                        <input type="button" value="??????" onclick="option_add();"> &nbsp; * ?????? drag&drop ???????????? ??????
                        <input type="hidden" id="check_option5" name="check_option5">
                        <br>
                        <ul id="sortable5" class="sortable" style="overflow-y:scroll;height:120px;">
                        <?php if(isset($template5)){
                            $option = explode('**',$template5[4]);
                            for($i=0; $i<count($option); $i++){
                                $default = explode('//',$option[$i]);
                                $default= $default[0];
                                $input= explode('//',$option[$i]);
                                $input=$input[1];
                        ?>
                            <li id='li<?php echo $i+1; ?>' style='cursor:pointer;' onclick='click_option(this.id);'>
                                <input type='checkbox' name='default_option<?php echo $template5[0]; ?>' id='li<?php echo $i+1; ?>_selected' <?php if($default == 'true'){echo "checked";} ?>>
                                <input name='option<?php echo $template5[0]; ?>' id='li<?php echo $i+1; ?>_input' class='input2' type='text' value='<?php echo $input; ?>' style='border: none; background: transparent;'>
                            </li>
                        <?php }} ?>
                        </ul>
                        <br>
                        <img src="<?php echo $misc;?>img/btn_delete.jpg" style="cursor:pointer;width:50px;float:right;margin-right:35px;" border="0" onClick="delete_option();"/>
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment5" id="comment5" class="input7 summernote" style="height:85%"><?php if(isset($template5)){echo br2nl($template5[5]);}?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="content-6 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel6" id="parallel6" value="Y" <?php if(isset($parallel6)){if($parallel6 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel6" id="parallel6" value="N" <?php if(isset($parallel6)){if($parallel6 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">???????????? </td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="header6" id="header6" value="Y" <?php if(isset($template6)){if($template6[1] == 'Y'){echo "checked";}}else{ echo "checked";} ?> />???
                        <input type="radio" name="header6" id="header6" value="N" <?php if(isset($template6)){if($template6[1] == 'N'){echo "checked";}}?> />?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????? </td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name6" id="column_name6" class="input2" style="height:85%" value="<?php if(isset($template6)){echo $template6[2];}?>">
                        <input name="column_name_hide6" id="column_name_hide6"  type="checkbox" value="Y" <?php if(isset($template6)){if($template6[3] == 'Y'){echo "checked";}} ?>> ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment6" id="comment6" class="input7 summernote" style="height:85%"><?php if(isset($template6)){echo br2nl($template6[4]);}?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="content-7 contents" style="display:none;">
            <table width="100%" class="basic_table">
                <tr class="parallel">
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="parallel7" id="parallel7" value="Y" <?php if(isset($parallel7)){if($parallel7 == 'Y'){echo "checked";}} ?>/>???
                        <input type="radio" name="parallel7" id="parallel7" value="N" <?php if(isset($parallel7)){if($parallel7 == 'N'){echo "checked";}}else{ echo "checked";} ?>/>?????????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">?????? </td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="column_name7" id="column_name7" class="input2" style="height:85%" value="<?php if(isset($template7)){echo $template7[1];}?>">
                        <input name="column_name_hide7" id="column_name_hide7" type="checkbox" value="Y" <?php if(isset($template7)){if($template7[2] == 'Y'){echo "checked";}} ?>> ??????
                    </td>
                </tr>
                <tr>
                    <td width="15%" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30"  class="basic_td" align="left" style="font-weight:bold;" >
                        <input type="radio" name="essential7" value="Y" <?php if(isset($template7)){if($template7[3] == 'Y'){echo "checked";}} ?> />???
                        <input type="radio" name="essential7" value="N" <?php if(isset($template7)){if($template7[3] == 'N'){echo "checked";}}else{ echo "checked"; } ?> />?????????
                    </td>
                </tr> 
                <tr>
                    <td width="15%" height="30" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <select id="category7" name="category7" class="input2">
                           <option value="" <?php if(isset($template7)){if($template7[4] == ''){echo "selected";}}else{ echo "selected" ;} ?>>??????</option>
                           <option value="user" <?php if(isset($template7)){if($template7[4] == 'user'){echo "selected";}} ?>>?????????</option>
                           <option value="group" <?php if(isset($template7)){if($template7[4] == 'group'){echo "selected";}} ?>>??????</option>
                           <option value="date" <?php if(isset($template7)){if($template7[4] == 'date'){echo "selected";}} ?>>??????</option>
                       </select>
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="30" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="30" class="basic_td" align="left" style="font-weight:bold;" >
                        <input name="maximum7" id="maximum7" class="input2" style="height:85%" value="<?php if(isset($template7)){echo $template7[5];}?>">  
                    </td>
                </tr>
                <tr>
                    <td width="15%" height="60" bgcolor="#f8f8f9" class="basic_td" align="center" style="font-weight:bold;">??????</td>
                    <td width="85%" height="60" class="basic_td" align="left" style="font-weight:bold;" >
                        <textarea name="comment7" id="comment7" class="input7 summernote" style="height:85%"><?php if(isset($template7)){echo br2nl($template7[6]);}?></textarea> 
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <span style="float:right;">
        <img src="<?php echo $misc;?>img/btn_ok.jpg" style="cursor:pointer;" border="0" onClick="ok();"/>
        <img src="<?php echo $misc;?>img/btn_cancel.jpg" style="cursor:pointer;" border="0" onClick="cancel();"/>
    </span>
    <div id="test"></div>
    </section>             
</table>
</body>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet"> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>  
<script>
   var tab_value = $('input[name="radio-set"]:checked').val();    
   tab_change(tab_value);
   $('.summernote').summernote({ placeholder: '????????? ??????????????????', tabsize: 2, height: 180 });
    
    var tr = "<?php echo $td_id;?>".split('_');
    tr = tr[0].replace('tr','');
    var optionLength = 0;

    var first_td_id = $("#tr"+tr,opener.document).find("td").eq(0).attr("id");

    //tr??? ????????? td??? ????????? ????????? ??????
    if(first_td_id == "<?php echo $td_id; ?>"){
        $(".parallel").hide();
        $(".parallel").find($("input[name=parallel"+tab_value+"]:input[value='N']")).attr("checked", true);
    }


    function ok(){
        var content_class = ".content-"+tab_value;
        var name = "<?php echo $td_id; ?>";

        if(tab_value == 1) { //?????????
            var parallel = $('input:radio[name=parallel1]:checked').val();
            var column_name = $('#column_name1').val();
            var column_name_hide = $('#column_name_hide1').is(":checked") == true ? 'Y':'N';
            var essential = $('input:radio[name=essential1]:checked').val();
            var input_type = $('#input_type1').val();
            if(input_type == 8){
                var point = $('#point1').val();
                var roundup = $('#roundup1').val();
                input_type += "//"+point+"//"+ roundup; 
            }
            var default_value = $('#default1').val();
            var width = $('#width1').val();
            var width_type = $('input:radio[name=width_type1]:checked').val();
            var maximum = $('#maximum1').val();
            var comment = nl2br($('#comment1').val());
            var text = tab_value+'|'+column_name+'|'+column_name_hide+'|'+essential+'|'+input_type+'|'+default_value+'|'+width+'|'+width_type+'|'+maximum+"|"+comment+"|"+name+"$$"+parallel;

            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/input.png' width='23' style='vertical-align:middle'>?????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
            
        }else if (tab_value == 2){//???????????????
            var parallel = $('input:radio[name=parallel2]:checked').val();
            var column_name = $('#column_name2').val();
            var column_name_hide = $('#column_name_hide2').is(":checked") == true ? 'Y':'N';
            var essential = $('input:radio[name=essential2]:checked').val();
            var width = $('#width2').val();
            var width_type = $('input:radio[name=width_type2]:checked').val();
            var height = $('#height2').val();
            var template = $('#template2').val();
            var comment = nl2br($('#comment2').val());
            var text = tab_value+'|'+column_name+'|'+column_name_hide+'|'+essential+'|'+ width+'|'+width_type+'|'+height+'|'+template+"|"+comment+"|"+name+"$$"+parallel;

            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/textbox.png' width='23' style='vertical-align:middle'>???????????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
        }else if (tab_value == 3){//?????????
            if($('input[name = option3]').length < 1){
                alert("????????? 1??? ?????? ????????? ?????????.");
                $("#option_input3").focus();
                return false;
            }
            var parallel = $('input:radio[name=parallel3]:checked').val();
            var column_name = $('#column_name3').val();
            var column_name_hide = $('#column_name_hide3').is(":checked") == true ? 'Y':'N';
            var essential = $('input:radio[name=essential3]:checked').val();
            var option = '';
            for(i=0; i<$('input[name = option3]').length; i++){
                if(i == 0){
                    option = $('input[name = default_option3]').eq(i).is(":checked") + "//"+ $('input[name = option3]').eq(i).val();
                }else{
                    option += '**'+$('input[name = default_option3]').eq(i).is(":checked") + "//"+ $('input[name = option3]').eq(i).val(); 
                }
            }
            var comment = nl2br($('#comment3').val());
            var text = tab_value+'|'+column_name+'|'+column_name_hide+'|'+essential+'|'+ option+'|'+comment+"|"+name+"$$"+parallel;
            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/select.png' width='23' style='vertical-align:middle'>?????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
        }else if (tab_value == 4){//?????????
            if($('input[name = option4]').length < 1){
                alert("????????? 1??? ?????? ????????? ?????????.");
                $("#option_input4").focus();
                return false;
            }
            var parallel = $('input:radio[name=parallel4]:checked').val();
            var column_name = $('#column_name4').val();
            var column_name_hide = $('#column_name_hide4').is(":checked") == true ? 'Y':'N';
            var essential = $('input:radio[name=essential4]:checked').val();
            var sort= $('input:radio[name=sort4]:checked').val();
            var option = '';
            for(i=0; i<$('input[name = option4]').length; i++){
                if(i == 0){
                    option = $('input[name = default_option4]').eq(i).is(":checked") + "//"+ $('input[name = option4]').eq(i).val();
                }else{
                    option += '**'+$('input[name = default_option4]').eq(i).is(":checked") + "//"+ $('input[name = option4]').eq(i).val(); 
                }
            }
            var comment = nl2br($('#comment4').val());
            var text = tab_value+'|'+column_name+'|'+column_name_hide+'|'+essential+'|'+sort+'|'+ option+'|'+comment+"|"+name+"$$"+parallel;
            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/radio.png' width='23' style='vertical-align:middle'>?????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
        }else if (tab_value == 5){//????????????
            if($('input[name = option5]').length < 1){
                alert("????????? 1??? ?????? ????????? ?????????.");
                $("#option_input5").focus();
                return false;
            }
            var parallel = $('input:radio[name=parallel5]:checked').val();
            var column_name = $('#column_name5').val();
            var column_name_hide = $('#column_name_hide5').is(":checked") == true ? 'Y':'N';
            var sort= $('input:radio[name=sort5]:checked').val();
            var option = '';
            for(i=0; i<$('input[name = option5]').length; i++){
                if(i == 0){
                    option = $('input[name = default_option5]').eq(i).is(":checked") + "//"+ $('input[name = option5]').eq(i).val();
                }else{
                    option += '**'+$('input[name = default_option5]').eq(i).is(":checked") + "//"+ $('input[name = option5]').eq(i).val(); 
                }
            }
            var comment = nl2br($('#comment5').val());
            var text = tab_value+'|'+column_name+'|'+column_name_hide+'|'+sort+'|'+ option+'|'+comment+"|"+name+"$$"+parallel;
            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/checkbox.png' width='23' style='vertical-align:middle'>????????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
        }else if (tab_value == 6){//?????????
            var parallel = $('input:radio[name=parallel6]:checked').val();
            var header = $('input:radio[name=header6]:checked').val();
            var column_name = $('#column_name6').val();
            var column_name_hide = $('#column_name_hide6').is(":checked") == true ? 'Y':'N';
            var comment = nl2br($('#comment6').val());
            var text = tab_value+'|'+header+'|'+column_name+'|'+column_name_hide+'|'+comment+"|"+name+"$$"+parallel;
            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/writebox.png' width='23' style='vertical-align:middle'>?????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
        }else if (tab_value == 7){//????????????
            if($("#category7").val() == ""){
                alert("????????? ?????? ????????????.");
                $("#category7").focus();
                return false;
            }
            var parallel = $('input:radio[name=parallel7]:checked').val();
            var column_name = $('#column_name7').val();
            var column_name_hide = $('#column_name_hide7').is(":checked") == true ? 'Y':'N';
            var essential = $('input:radio[name=essential7]:checked').val();
            var category = $("#category7").val();
            var maximum = $("#maximum7").val();
            var comment = nl2br($('#comment7').val());
            var text = tab_value+'|'+column_name+'|'+column_name_hide+'|'+essential+'|'+category+'|'+maximum+'|'+comment+"|"+name+"$$"+parallel;
            var span = "<span style='cursor:pointer;' onclick='openPopup(this);' onmousedown='others(event,this);'><img src='<?php echo $misc;?>img/component.png' width='23' style='vertical-align:middle'>????????????("+column_name+")</span>";
            span += "<input type='hidden' name='template' id='template"+tr+"' value='"+text+"'/>";
        }
        $("#<?php echo $td_id; ?>",opener.document).html(span);
        if(opener.parent.open_preview){
            opener.parent.preview(1);
        }
        self.close();
    }

    //?????? ??????
    function cancel(){
        var check = confirm("??? ??????????????? ?????????????????????? ???????????? ????????? ?????? ?????? ????????????.")
        if(check == true){ 
            self.close();
        }else{
            return false;
        }
    }
    
    //select,radio??? ????????????
    function option_add(){
        optionLength++;
        
        var option = $("#option_input"+tab_value).val();
        if(tab_value==5){
            var type = "checkbox";
        }else{
            var type = "radio";
        }
        
        // text="<tr><td>"+$("#option_input3").val()+"</td></tr>";
        var text = "<li id='li"+optionLength+"' style='cursor:pointer;' onclick='click_option(this.id);'>";
        text += "<input type='"+type+"' name='default_option"+tab_value+"' id='li"+optionLength+"_selected' >";
        text += "<input name='option"+tab_value+"' id='li"+optionLength+"_input' class='input2' type='text' value='"+option+"' style='border: none; background: transparent;'>";
        text += "</li>";
        // $(".content-"+tab_value).find($(".option_total")).append(text);
        $("#sortable"+tab_value).append(text);
        $("#sortable"+tab_value).scrollTop($("#sortable"+tab_value)[0].scrollHeight);
        $("#option_input"+tab_value).val('');
    }

    //?????? ???????????????
    function click_option(id){
        $(".content-"+tab_value).find($('li')).css('background-color','')
        $(".content-"+tab_value).find($("#"+id)).css('background-color','#f8f8f9');
        $("#check_option"+tab_value).val(id);
    }

    //?????? ?????????
    function delete_option(){
        if($("#check_option"+tab_value).val() != ''){
            var id = $("#check_option"+tab_value).val();
            $("#"+id).remove();
            $("#check_option"+tab_value).val('');
        }else{
            alert("????????? ????????? ??????????????????.")
        }        
    }

    //sortable
    $(".sortable").sortable({
    });


    //nl2br
    function nl2br(str) {
        return str.replace(/\n/g, "<br />");
    }

    //??????????????? show 
    function inputType(type){
        if(type == 8){
            $("#expression").show();
            $("#default1_comment").show();
        }else{
            $("#expression").hide();
            $("#default1_comment").hide();
        }
    }

    //???????????????
    function enter(){
        if ( window.event.keyCode == 13 ) {
            option_add();
        }
    }

    function tab_change(check){
        tab_value = $('input[name="radio-set"]:checked').val();    
        $(".contents").hide();
        $(".content-"+check).show();

    }

</script>
</html>

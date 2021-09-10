<?php
//즐겨찾기 때문에 배열 순서 앞으로 땡겨
for($i =0; $i<count($approval_form_list); $i++){
   $form = $approval_form_list[$i];
    if(strpos($form['bookmark'],','.$id)!== false){
       array_splice($approval_form_list, $i, 1);
       array_unshift($approval_form_list, $form);
    }
}
 ?>
<div class="dash2">
  <table id="approval" class="dash_tbl2" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="dash_title" align="left"><img src="<?php echo $misc;?>img/dashboard/title_approval_list2.png"/></td>
      <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
    </tr>
    <tr>
      <td height="10"></td>
    </tr>
    <tr height="20">
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_1-1_on.png" id="dash_1-1:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_1-1_off.png" id="dash_1-1:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
      </td>
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_1-2_on.png" id="dash_1-2:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_1-2_off.png" id="dash_1-2:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
      </td>
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_1-3_on.png" id="dash_1-3:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_1-3_off.png" id="dash_1-3:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
      </td>
    </tr>
    <tr>
      <td height="10"></td>
    </tr>


    <!-- dash 1-1 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_1-1" class="dash_1" width="100%">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="10%" />
                  <col width="10%" />
                  <col width="10%" />
                  <col width="10%" />
                  <col width="60%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">시스템</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">즐겨찾기</th>
                  <th height="40" align="center">양식명</th>
                </tr>
                <?php
                  if (empty($approval_form_list) != true) {
                    $idx = $approval_form_list_count-$start_row;
                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $approval_form_list[$i])){
                        $form = $approval_form_list[$i];
                ?>
                <tr>
                 <td height="40" align="center"><?php echo $idx;?></td>
                 <td align="center"><?php echo $form['template_type'];?></td>
                 <td align="center">
                   <?php
                   foreach($category as $format_categroy){
                      if($form['template_category'] == $format_categroy['seq']){
                         echo $format_categroy['category_name'];
                      }
                   }
                   ?>
                 </td>
                 <td align="center">
                   <?php
                   if(strpos($form['bookmark'],','.$id)!== false){
                      echo "<img class='bookmark' src='{$misc}img/star2.png' width='20'>";
                   }else{
                      echo "<img class='bookmark' src='{$misc}img/star.png' width='20'";
                   }
                   ?>
                 </td>
                 <td align="center"><?php echo $form['template_name'];?></td>
               </tr>
                   <?php
                    $idx--;
                  }
                  }
                } else {
              ?>
                <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                  <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
                </tr>
      <?php
      }
      ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- dash 1-2 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_1-2" class="dash_1" width="100%" style="display:none;">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="10%" />
                  <col width="10%" />
                  <col width="40%" />
                  <col width="15%" />
                  <col width="15%" />
                  <col width="10%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">문서제목</th>
                  <th height="40" align="center">기안일</th>
                  <th height="40" align="center">완료일</th>
                  <th height="40" align="center">문서상태</th>
                </tr>
                <?php
                  if (empty($approval_doc_list) != true) {
                    $idx = $approval_doc_list_count-$start_row;
                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $approval_doc_list[$i])){
                        $doc = $approval_doc_list[$i];
                ?>
                <tr>
                 <td height="40" align="center"><?php echo $idx;?></td>
                 <td align="center">
                   <?php
                   if($doc['template_category'] == ""){
                      echo "연차";
                   }else{
                      foreach($category as $format_categroy){
                         if($doc['template_category'] == $format_categroy['seq']){
                            echo $format_categroy['category_name'];
                         }
                      }
                   }
                   ?>
                 </td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_hold'] == "N"){
                     echo $doc['approval_doc_name'];
                   } else {
                     echo $doc['approval_doc_name']." (보류)";
                   }
                    ?>
                 </td>
                 <td align="center"><?php echo $doc['write_date'] ?></td>
                 <td align="center"><?php echo $doc['completion_date'];?></td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_status'] == "001"){
                      echo "진행중";
                   }else if($doc['approval_doc_status'] == "002"){
                      echo "완료";
                   }else if($doc['approval_doc_status'] == "003"){
                      echo "반려";
                   }else if($doc['approval_doc_status'] == "004"){
                      echo "회수";
                   }else if($doc['approval_doc_status'] == "005"){
                      echo "임시저장";
                   }
                   ?>
                 </td>
               </tr>
                   <?php
                    $idx--;
                  }
                  }
                } else {
              ?>
                <tr>
                  <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
                </tr>
      <?php
      }
      ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>


    <!-- dash 1-3 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_1-3" class="dash_1" width="100%" style="display:none;">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="10%" />
                  <col width="10%" />
                  <col width="40%" />
                  <col width="15%" />
                  <col width="15%" />
                  <col width="10%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">문서제목</th>
                  <th height="40" align="center">기안일</th>
                  <th height="40" align="center">완료일</th>
                  <th height="40" align="center">문서상태</th>
                </tr>
                <?php
                  if (empty($temporary_list) != true) {
                    $idx = $temporary_list_count-$start_row;
                    for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $temporary_list[$i])){
                        $doc = $temporary_list[$i];
                ?>
                <tr>
                 <td height="40" align="center"><?php echo $idx;?></td>
                 <td align="center">
                   <?php
                   if($doc['template_category'] == ""){
                      echo "연차";
                   }else{
                      foreach($category as $format_categroy){
                         if($doc['template_category'] == $format_categroy['seq']){
                            echo $format_categroy['category_name'];
                         }
                      }
                   }
                   ?>
                 </td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_hold'] == "N"){
                     echo $doc['approval_doc_name'];
                   } else {
                     echo $doc['approval_doc_name']." (보류)";
                   }
                    ?>
                 </td>
                 <td align="center"><?php echo $doc['write_date'] ?></td>
                 <td align="center"><?php echo $doc['completion_date'];?></td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_status'] == "001"){
                      echo "진행중";
                   }else if($doc['approval_doc_status'] == "002"){
                      echo "완료";
                   }else if($doc['approval_doc_status'] == "003"){
                      echo "반려";
                   }else if($doc['approval_doc_status'] == "004"){
                      echo "회수";
                   }else if($doc['approval_doc_status'] == "005"){
                      echo "임시저장";
                   }
                   ?>
                 </td>
               </tr>
                   <?php
                    $idx--;
                  }
                  }
                } else {
              ?>
                <tr>
                  <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
                </tr>
      <?php
      }
      ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>



  </table>
</div>

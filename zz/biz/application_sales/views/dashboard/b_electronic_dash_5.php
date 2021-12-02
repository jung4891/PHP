<div class="dash1">
  <table id="approval" class="dash_tbl1" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="dash_title" align="left"><img src="<?php echo $misc;?>img/dashboard/title_approval_list.png"/></td>
      <td align="right" style="padding-right:10px;"><img src="<?php echo $misc;?>img/dashboard/dash_detail.png" width="20" onclick="go_detail(this)" style="cursor:pointer;"/></td>
    </tr>
    <tr>
      <td height="10"></td>
    </tr>
    <tr height="20">
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-1_on.png" id="dash_5-1:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-1_off.png" id="dash_5-1:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
      </td>
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-2_on.png" id="dash_5-2:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-2_off.png" id="dash_5-2:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
      </td>
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-3_on.png" id="btn_5-3:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-3_off.png" id="btn_5-3:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
      </td>
      <td style="float:left" style="padding-left:10px;">
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-4_on.png" id="btn_5-4:on" class="btn_on" onclick="change_tbl(this.id);" style="cursor:pointer;display:none;"/>
        <img src="<?php echo $misc;?>img/dashboard/btn/btn_5-4_off.png" id="btn_5-4:off" class="btn_off" onclick="change_tbl(this.id);" style="cursor:pointer;"/>
      </td>
    </tr>
    <tr>
      <td height="10"></td>
    </tr>


    <!-- dash 5-1 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_5-1" class="dash_5" width="100%">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="5%" />
                  <col width="10%" />
                  <col width="5%" />
                  <col width="20%" />
                  <col width="10%" />
                  <col width="15%" />
                  <col width="15%" />
                  <col width="15%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">유형</th>
                  <th height="40" align="center">문서제목</th>
                  <th height="40" align="center">기안자</th>
                  <th height="40" align="center">기안부서</th>
                  <th height="40" align="center">기안일</th>
                  <th height="40" align="center">배정일</th>
                </tr>
                <?php
                if(empty($standby) != true){
                   $idx = $standby_count-$start_row;
                   for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $standby[$i])){
                         $doc = $standby[$i];
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
                 <td align="center"><?php echo $doc['approval_type']; ?></td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_hold'] == "N"){
                      echo $doc['approval_doc_name'];
                   }else{
                      echo $doc['approval_doc_name']." (보류)";
                   }
                   ?>
                 </td>
                 <td height="40" align="center"><?php echo $doc['writer_name'];?></td>
                 <td height="40" align="center"><?php echo $doc['writer_group'];?></td>
                 <td height="40" align="center"><?php echo $doc['write_date'];?></td>
                 <td height="40" align="center"><?php echo $doc['assignment_date'];?></td>
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

    <!-- dash 5-2 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_5-2" class="dash_5" width="100%" style="display:none;">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="5%" />
                  <col width="10%" />
                  <col width="30%" />
                  <col width="10%" />
                  <col width="15%" />
                  <col width="15%" />
                  <col width="15%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">문서제목</th>
                  <th height="40" align="center">기안자</th>
                  <th height="40" align="center">기안부서</th>
                  <th height="40" align="center">기안일</th>
                  <th height="40" align="center">결재일</th>
                </tr>
                <?php
                if(empty($progress) != true){
                   $idx = $progress_count-$start_row;
                   for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $progress[$i])){
                         $doc = $progress[$i];
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
                   }else{
                     echo $doc['approval_doc_name']." (보류)";
                   }
                   ?>
                 </td>
                 <td height="40" align="center"><?php echo $doc['writer_name'];?></td>
                 <td height="40" align="center"><?php echo $doc['writer_group'];?></td>
                 <td height="40" align="center"><?php echo $doc['write_date'];?></td>
                 <td height="40" align="center"><?php echo $doc['assignment_date'];?></td>
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


    <!-- dash 5-3 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_5-3" class="dash_5" width="100%" style="display:none;">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="5%" />
                  <col width="10%" />
                  <col width="5%" />
                  <col width="20%" />
                  <col width="10%" />
                  <col width="15%" />
                  <col width="15%" />
                  <col width="15%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">유형</th>
                  <th height="40" align="center">문서제목</th>
                  <th height="40" align="center">기안자</th>
                  <th height="40" align="center">기안부서</th>
                  <th height="40" align="center">기안일</th>
                  <th height="40" align="center">완료일</th>
                </tr>
                <?php
                if(empty($completion) != true){
                   $idx = $completion_count-$start_row;
                   for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $completion[$i])){
                         $doc = $completion[$i];
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
                 <td align="center"><?php echo $doc['approval_type']; ?></td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_hold'] == "N"){
                      echo $doc['approval_doc_name'];
                   }else{
                      echo $doc['approval_doc_name']." (보류)";
                   }
                   ?>
                 </td>
                 <td height="40" align="center"><?php echo $doc['writer_name'];?></td>
                 <td height="40" align="center"><?php echo $doc['writer_group'];?></td>
                 <td height="40" align="center"><?php echo $doc['write_date'];?></td>
                 <td height="40" align="center"><?php echo $doc['assignment_date'];?></td>
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

    <!-- dash 5-4 -->
    <tr>
      <td colspan="2" valign="top">
        <table id="tbl_dash_5-4" class="dash_5" width="100%" style="display:none;">
          <tr>
            <td colspan="2" valign="top">
              <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                  <col width="5%" />
                  <col width="10%" />
                  <col width="5%" />
                  <col width="20%" />
                  <col width="10%" />
                  <col width="15%" />
                  <col width="15%" />
                  <col width="15%" />
                </colgroup>
                <tr class="t_top">
                  <th height="40" align="center">NO</th>
                  <th height="40" align="center">서식함</th>
                  <th height="40" align="center">유형</th>
                  <th height="40" align="center">문서제목</th>
                  <th height="40" align="center">기안자</th>
                  <th height="40" align="center">기안부서</th>
                  <th height="40" align="center">기안일</th>
                  <th height="40" align="center">완료일</th>
                </tr>
                <?php
                if(empty($back) != true){
                   $idx = $back_count-$start_row;
                   for($i = $start_row; $i<$start_row+$end_row; $i++){
                      if(!empty( $back[$i])){
                         $doc = $back[$i];
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
                 <td align="center"><?php echo $doc['approval_type']; ?></td>
                 <td align="center">
                   <?php
                   if($doc['approval_doc_hold'] == "N"){
                      echo $doc['approval_doc_name'];
                   }else{
                      echo $doc['approval_doc_name']." (보류)";
                   }
                   ?>
                 </td>
                 <td height="40" align="center"><?php echo $doc['writer_name'];?></td>
                 <td height="40" align="center"><?php echo $doc['writer_group'];?></td>
                 <td height="40" align="center"><?php echo $doc['write_date'];?></td>
                 <td height="40" align="center"><?php echo $doc['assignment_date'];?></td>
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

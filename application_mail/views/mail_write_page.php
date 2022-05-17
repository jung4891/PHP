<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>


 <link rel="stylesheet" href="<?php echo $misc; ?>daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>css/jquery.tag-editor.css" type="text/css" charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="https://mail.durianit.co.kr/misc/daumeditor-7.4.9/css/uploadifive.css">
<script src="https://mail.durianit.co.kr/misc/daumeditor-7.4.9/js/jquery.uploadifive.js" type="text/javascript"></script>
 <script src="<?php echo $misc; ?>daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
 <script src="<?php echo $misc; ?>js/jquery.caret.min.js" type="text/javascript" charset="utf-8"></script>
 <script src="<?php echo $misc; ?>js/jquery.tag-editor.js" type="text/javascript" charset="utf-8"></script>


 <!-- 넓이 높이 조절 -->
 <style>

    /* #recipient{
      background-color: pink;
    } */

  #group_table td {
    border-bottom:1px solid #DFDFDF;
    height: 30px;
  }

  #my_grouptbl td{
    border-bottom:1px solid #DFDFDF;
    height: 30px;
    cursor: pointer;
    color: #B0B0B0;
  }

  .select_mygroup td{
    color: black !important;
  }

  #group_table tr:hover {
    background-color: #e4f6f7;
  }

  .user_selected{
      background-color:#c9f2f5;
  }


  #modal_h{
    height:15%;
    width: 100%;
  }

  #modal_b{
    height:75%;
    width: 100%;
    display: flex;

  }

  #modal_f{
    height:10%;
    width: 100%;
  }

  .mb_c{
    border: 1px solid #DFDFDF;
    border-radius: 3px;
    opacity: 1;
  }

  #modal_b table{
    width:100%;
    border-spacing:0px;
  }

  .to_contain{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  /* .to_item{
    display: flex;
    height: 33%;
  } */

  #adress_modal {
    display:none;
    padding: 20px;
    border-radius: 3px;
    background-color: white;
    min-width: 400px;
    min-height: 500px;
    width:50vw;
    height: 70vh;
    max-width: 60vw;
  }

  #adress_modal input {
    appearance:none;
    border:none;
    border: solid 1px;
    height:30px;
    border-radius:3px;
    border-color:#DFDFDF;
    /* background:url(/misc/img/icon/search.png) no-repeat 98% 50% #fff; */
		/* background-size: 20px; */
  }

  #adress_modal input::placeholder {
    color: #B0B0B0;
  }

  #adress_modal .btn {
    height:35px;
    color:#B0B0B0;
    width:auto;
    padding-left:10px;
    padding-right:10px;
    padding-top:7px;
    float:left;
    display:table-cell;
    vertical-align: middle;
    border-right:thin solid #DFDFDF;
    font-weight: 500;
    cursor:pointer;
  }

  #adress_modal .selected {
    color: #1C1C1C;
  }

  #adress_modal .allow {
    background-color: white;
    border:thin solid #C2C2C2;
    border-radius: 2px;
    color:#565656;
    font-weight:500;
  }

  .adress_box {
    width:100%;
    height:calc(90% - 30px);
    border:thin solid #DFDFDF;
    border-radius: 3px;

  }

  .btn-common {
    cursor: pointer;
    border: 1px solid black;
    background-color: white;
    width: 90px;
    height: 30px;
    font-weight: 400;
    border-radius: 3px;
    background: #a9abac;
    border-color: #a9abac;
    color: rgb(255, 255, 255);
    font-size:14px;
    vertical-align: middle;
    font-family: "Noto Sans KR", sans-serif;
    float:right;
  }
  .btn-style3 {
    background: white;
    border-color: #B0B0B0;
    color: #1C1C1C;
  }
  .btn-color2 {
    background: #0575E6;
    border: #0575E6;
    color: #FFFFFF;
  }

  .sender-tr td{
    height: 40px;
    border-top: solid 1px #DFDFDF;
  }


  /* color tags */
.tag-editor .red-tag .tag-editor-tag { color: #c65353; background: #ffd7d7; }
.tag-editor .red-tag .tag-editor-delete { background-color: #ffd7d7; }
.tag-editor .green-tag .tag-editor-tag { color: #45872c; background: #e1f3da; }
.tag-editor .green-tag .tag-editor-delete { background-color: #e1f3da; }

.ui-autocomplete {
  max-height: 200px;
  overflow-y: auto;
  /* prevent horizontal scrollbar */
  overflow-x: hidden;
}
/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
  height: 200px;
}

#my_groupdiv{ -ms-overflow-style: none; }
#my_groupdiv::-webkit-scrollbar{ display:none; }


.uploadifive-button {
	background-image:none !important;
  border:1px solid #B0B0B0 !important;
  background-color: #FFFFFF !important;
  color: #1C1C1C !important;
  border-radius: 5px !important;
  width: 100px !important;
  padding-left: 20px;
  text-shadow: unset !important;
  font: unset !important;
  height: 30px !important;
  line-height: 30px !important;
  cursor: pointer;
  font-size: 16px !important;
  font-family: "Noto Sans KR", sans-serif !important;
  position: relative;
  left:-17px;
}
.uploadifive-button input{
  cursor: pointer;
}

#queue {
	border: 1px solid #B0B0B0;
	height: 177px;
	overflow: auto;
	/* margin-bottom: 10px; */
	/* padding: 0 3px 3px; */
	width: 100%;
}

   </style>
   <?php
   $reply_to = (isset($reply_to))?$reply_to:"";
   $reply_cc = (isset($reply_cc))?str_replace(",", ";", $reply_cc):"";
   $reply_title = (isset($reply_title))?$reply_title:"";
   $reply_content = (isset($reply_content))?$reply_content:"";
    ?>
    <div id="main_contents" align="center">
        <div id="send_top" align="left" style="width:95%;padding-bottom:10px;">
          <button type="button" class="btn_basic btn_blue" name="button" id="submit_button" enctype="multipart/form-data" style="width:80px" onclick="chkForm();return false;">보내기</button>
  <!-- <button type="button" class="btn_basic btn_white" name="" style="width:80px">미리보기</button> -->
    <!-- <button type="button" class="btn_basic btn_white" style="width:80px">임시저장</button> -->
    <textarea name="reply_content" id="reply_content" style="display:none;"><?php echo $reply_content; ?></textarea>
    <input type="hidden" id="re_mode" name="re_mode" value="<?php echo $mode; ?>">
        </div>
        <div class="main_div">
          <form action="<?php echo site_url();?>/mail_write/mail_write_action" method="post" enctype="multipart/form-data" id="tx_editor_form" name="tx_editor_form">
        <!-- <input type="text" id="recipient" name="recipient" value="" placeholder="받는 사람"><br> -->

        <table width="90%" class="" border="0" cellspacing="0" cellpadding="0" style="width:95%;
          height: 100%;">
          <colgroup>
            <col width=10% align="left">
            <col width=85%>
            <col width=5%>
          </colgroup>
          <tr class="mail_write sender-tr">
              <td>받는사람</td>
              <td>
                <input type="text" class="input_basic inputsender" id="recipient" name="recipient" value="<?php echo $reply_to; ?>" placeholder="" style="width:100%">
              </td>
              <td align="right">
                <!-- <button class="btn_basic btn_white" type="button" id="address_button" name="address_button">주소록</button> -->
                <input class="btn_basic btn_white" type="button" id="address_button" name="address_button" value="주소록">
              </td>
          </tr>


          <tr class="mail_cc sender-tr">
              <td>참조
                <!-- <span style="font-size:8px;float:right;padding-right:10px;">아래</span> -->
              </td>
              <td>
                <input type="text" class="input_basic inputsender" id="cc" name="cc" value="<?php echo $reply_cc; ?>" placeholder="참조" style="width:100%">
              </td>
              <td>

              </td>
          </tr>

          <tr class="mail_bcc sender-tr">
              <td>숨은 참조</td>
              <td>
                <input type="text" class="input_basic inputsender" id="bcc" name="bcc" value="" placeholder="숨은 참조" style="width:100%">
              </td>
              <td></td>
          </tr>

          <tr class="mail_title sender-tr">
            <td>제목
              <!-- <span style="font-size:8px;float:right;padding-right:10px;"><input type="checkbox" name="" value="">중요</span> -->
            </td>
            <td>
              <input type="text" class="input_basic" id="title" name="title" value="<?php echo $reply_title; ?>" placeholder="제목" style="width:100%">
            </td>
            <td></td>
          </tr>
          <tr class="attachment sender-tr">
              <td>첨부
<img id="toggle_topimg" style="width: 20px;cursor:pointer;position:relative;top: 5px;" src="<?php echo $misc; ?>/img/toggle_top.svg" alt="" onclick="hide_filediv();">
<img id="toggle_downimg"  style="width: 20px;cursor:pointer;display:none;position:relative;top:5px;" src="<?php echo $misc; ?>/img/toggle_down.svg" alt="" onclick="show_filediv();">
              </td>
              <td style="display: flex;align-items: center;line-height: 30px;">
                <label id="genenal_filebtn" class="btn_basic btn_white" for="file_up" style="cursor:pointer;display:block;width:100px;text-align:center;">
                  <img style="width: 17px;" src="<?php echo $misc; ?>/img/upload_btn.svg" alt="">
                  <span style="color: #1C1C1C; font-size:16px;">일반 첨부</span>
                </label>
							  <input type="file" id="file_up" class="file-input" style="display:none;" multiple>
              </td>
              <td></td>
          </tr>
          <tr>
            <td></td>
            <td>
              <!-- <div id="hiddenFile" style="display:none;">
                대용량 첨부파일
              </div> -->
            </td>
          </tr>
          <tr class="">
            <td valign="bottom">

              <select class="" name="" id="signature_list" style="width:100%" onchange="sign_select(this.value)">
                <option value="no">서명없음</option>
<?php
foreach ($sign_list as $sl) {
  $selected = ($sl->active == "Y")? " selected" : "";
  ?>
                <option value="<?php echo $sl->seq; ?>" <?php echo $selected; ?>><?php echo $sl->sign_name; ?></option>
<?php
}
?>
              </select>
            </td>
            <td colspan="2">
              <div id="file_div" class="">


              <table class="basic_table" width="100%" height="auto" style="min-height: 60px;border:solid 1px #B0B0B0;">
     							 <tbody id="fileTableTbody">
     									<tr>
     										 <td id="dropZone" align="center" style="color:#B0B0B0;border:none;">
                          마우스로 첨부 할 파일을 끌어오세요.
     										 </td>
     									</tr>
     							 </tbody>
     				 </table>
             <?php if (isset($reply_file)) {
            ?>
            <table class="basic_table" id="fw_filetbl" width="100%" height="auto" style="min-height: 30px;border:solid 1px #B0B0B0;">
              <tr>
                <td>

                  <input type="hidden" name="fw_mbox" value="<?php echo $reply_file[0]->mbox; ?>">
                  <input type="hidden" name="fw_msgno" value="<?php echo $reply_file[0]->msgno; ?>">
                </td>
              </tr>
              <?php foreach ($reply_file as $rf) {
                $param = "'{$rf->mbox}','{$rf->msgno}','{$rf->part_num}','{$rf->encoding}','{$rf->filename}'";
                ?>
                <tr>
                  <td>
                    <a href="JavaScript:download(<?php echo $param; ?>);"><?php echo $rf->filename; ?></a><span style='color: silver;margin-left:10px;'><?php echo $rf->size; ?></span>
                    <a href='#' onclick='del_fwfile(this)' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>
                    <input type="hidden" name="fw_part[]" value="<?php echo $rf->part_num.",".$rf->content_type.",".$rf->encoding.",".$rf->subtype.",".$rf->disposition.",".$rf->realname; ?>">
                  </td>
                </tr>
                <?php
              } ?>
            </table>
            <?php
             } ?>
             <table class="" width="100%" height="auto" style="min-height: 30px; margin-top:3px;" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td style="">
                   <!-- <label class="btn_basic btn_white" for="" style="cursor:pointer;display:block;width:100px;text-align:center;">
                     <span style="color: #1C1C1C; font-size:14px; vertical-align:middle;" onclick="bigfileopen();">대용량 첨부</span>
                   </label> -->
                   <div class="" style="display:flex;">
                     <img style="width: 17px;position: relative;z-index:2;left:8px;" src="<?php echo $misc; ?>/img/upload_btn.svg" alt="">
                     <input id="file_upload" name="file_upload" type="file" multiple="true" style="cursor:pointer;">
                   </div>
                 </td>
               </tr>
               <tr>
                 <td>
                   <div id="bigfilediv" style="background-color:white;width:100%;height:auto;margin-top:3px;">
                     <div class="" style="display: flex;
                   justify-content: space-between;align-items: center;">
                       <!-- <p>대용량 파일첨부</p> -->
                     </div>
                     <form>
                       <div class="" style="display:flex;">

                         <div id="queue" style="width:100%;height:auto;min-height:60px;">
                           <p style="color: #B0B0B0;text-align: center;">마우스로 첨부 할 파일을 끌어오세요.</p>
                           <div id="hiddenFile" class="" style="">

                           </div>
                         </div>
                         <div class="" style="display: flex;flex-direction: column;">
                           <!-- <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">&nbsp;&nbsp;&nbsp;파일 업로드</a> -->
                           <span id="bigfile_info" style="color:#B0B0B0;"></span>

                         </div>
                       </div>

                       <!-- <div class="" style="display: flex;justify-content: center;">
                         <input class="btn-common btn-color2" type="button" name="" value="확인" onclick="complete_bigfile();">
                         <input class="btn-common btn-style3" type="button" name="" value="닫기" onclick="$('#bigfilediv').bPopup().close();">
                       </div> -->
                       <?php
                       $expiration = strtotime("+2 months");
                       $expiration_date = date("Y-m-d", $expiration);
                       ?>
                       <span id="expiration_span" style="color: #B0B0B0; font-size:14px; vertical-align:middle; float:right;z-index: 1;">대용량 첨부파일 다운로드 만료기간 : ~<?php echo $expiration_date; ?></span>

                     </form>
                   </div>
                 </td>
               </tr>
               <tr>
                 <td>
                   <!-- <div id="hiddenFile" class="" style="">

                   </div> -->
                 </td>
               </tr>
            </table>
            </div>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <textarea name="content" id="content" style="display:none;"></textarea>
                <input type="hidden" name="contents" id="contents" value="">
                <?php include $this->input->server('DOCUMENT_ROOT')."/misc/daumeditor-7.4.9/editor.php"; ?>
            </td>
          </tr>
        </table>
      </form>
      </div>

    <div id="adress_modal">
      <div style="float:left;width:53%;height:90%;display:flex;flex-direction:column;">
        <div style="width:100%;height:auto;">
          <p style="font-size:20px;font-weight:bold;">주소록</p>
          <p><span style="font-size:14px;font-weight:bold;">주소록검색</span>
            <img id="add_search_btn" style="width: 20px; float:right;position: relative;top: 6px;right: 30px;cursor: pointer;" src="<?php echo $misc; ?>/img/icon/search.png" alt="">
            <input type="text" name="" id="address_search" style="float:right;width:calc(90% - 70px);;" value="" placeholder="이름 또는 이메일 주소로 검색" autocomplete="off">
          </p>
        </div>
        <div style="width:100%;height:auto;border:thin solid #DFDFDF;border-radius:3px;vertical-align:middle;">
          <span type="button" class="btn selected" id="addressspan" onclick="group_button_click('address', this);" name="button">주소록</span>
          <span type="submit" class="btn" id="mboxspan" onclick="group_button_click('mailbox', this);" name="button">메일박스</span>
          <!-- <span type="button" class="btn" onclick="group_button_click('alias');" name="button">그룹메일</span> -->
        </div>

        <!-- <div style="width:calc(100%-1px);height:auto;border:thin solid #DFDFDF;border-radius:3px;vertical-align:middle;">
            <select class="" name="" style="height:100%;width:100%;border:none;">
              <option value="">전체</option>
            </select>
        </div> -->

        <div style="width:100%;height:80%;border:thin solid #DFDFDF;display: flex;
    align-items: flex-start;">
      <div class="" id="my_groupdiv" style="overflow:auto;width:30%;height:100%;border-right:1px solid #DFDFDF;">
        <table id="my_grouptbl" border="0" cellspacing="0" cellpadding="0" style="width:100%;max-height:100%;">
          <colgroup>
            <col width="35%">
          </colgroup>
          <tbody>
            <tr class="select_mygroup" onclick="select_mygroup('all', this);">
              <td>
                <input type="hidden" id="select_group_input" name="" value="">
                전체
              </td>
            </tr>
          <?php
foreach ($mygroup_list as $gl) {
?>
<tr onclick="select_mygroup('<?php echo $gl->seq; ?>', this);">
  <td><?php echo $gl->group_name; ?></td>
</tr>

<?php
}
            ?>
          </tbody>
        </table>
      </div>
      <div class="" id="address_div" style="overflow:auto;width:70%;height:100%;">
        <table id="group_table" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
          <colgroup>
            <col width="35%">
            <col width="65%">
          </colgroup>
          <tbody>
          </tbody>
        </table>
      </div>
        </div>
      </div>
      <div style="float:left;width:7%;height:90%;display:flex;flex-direction:column;">
        <div style="height:13%"></div>
        <div style="height:29%;vertical-align:middle;display:table;text-align:center;">
          <span style="display:table-cell;vertical-align:middle;">
            <button type="button" class="allow" onclick="address_button_click('recipients_tbl');"> > </button><br>
            <button type="button" class="allow" onclick="address_button_click_back('recipients_tbl');"> < </button>
          </span>
        </div>
        <div style="height:29%;vertical-align:middle;display:table;text-align:center;">
          <span style="display:table-cell;vertical-align:middle;">
            <button type="button" class="allow" onclick="address_button_click('cc_tbl');"> > </button><br>
            <button type="button" class="allow" onclick="address_button_click_back('cc_tbl');"> < </button>
          </span>
        </div>
        <div style="height:29%;vertical-align:middle;display:table;text-align:center;">
          <span style="display:table-cell;vertical-align:middle;">
            <button type="button" class="allow" onclick="address_button_click('bcc_tbl');"> > </button><br>
            <button type="button" class="allow" onclick="address_button_click_back('bcc_tbl');"> < </button>
          </span>
        </div>
      </div>
      <div style="float:left;width:40%;height:90%;display:flex;flex-direction:column;">
        <div style="height:13%"></div>
        <div style="height:29%;">
          <p style="font-size:13px;font-weight:bold;padding:0;">
            <span>받는사람</span>
            <span style="margin-left:5px;color:#0575E6"></span>
          </p>
          <div class="adress_box to_item" style="overflow-y:scroll;">
            <table id="recipients_tbl" style="width:100%;">
              <tbody>
              </tbody>
            </table>

          </div>
        </div>
        <div style="height:29%;">
          <p style="font-size:13px;font-weight:bold;">
            <span>참조</span>
            <span style="margin-left:5px;color:#0575E6"></span>
          </p>
          <div class="adress_box to_item" style="overflow-y:scroll;">
          <table id="cc_tbl" style="width:100%;">
            <tbody>
            </tbody>
          </table>
        </div>
        </div>
        <div style="height:29%;">
          <p style="font-size:13px;font-weight:bold;">
            <span>숨은참조</span>
            <span style="margin-left:5px;color:#0575E6"></span>
          </p>
          <div class="adress_box to_item" style="overflow-y:scroll;">
          <table id="bcc_tbl" style="width:100%;">
            <tbody>
            </tbody>
          </table>
        </div>
        </div>
      </div>
      <button type="button" class="btn-common btn-color2" onclick="register_button();" name="button" style="margin-top:20px;">저장</button>
      <button type="button" class="btn-common btn-style3" name="button" onclick="$('#adress_modal').bPopup().close();" style="margin-right:10px;margin-top:20px;">취소</button>
    </div>


    <!-- 모달창 -->
    <!-- <div id="adress_modal2" style="display: none; background-color: white; width: 40vw; height: 70vh;">
      <div id="modal_h">
        <p style="font-size:20px;font-weight:bold;">주소록</p>
        <span style="font-size:14px;font-weight:bold;">주소록검색</span>
        <input type="text" name="" style="margin-left:10px;" value="">

      </div>

      <div id="modal_b">
        <div class="mb_c" style="overflow:auto;" style="width:55%">
          <button type="button" onclick="group_button_click('all');" name="button">전체</button>
          <button type="submit" id="group" onclick="group_button_click('tech');" name="button">그룹</button>
          <button type="button" onclick="group_button_click('salse');" name="button">즐겨찾기</button>

          <table id="group_table">
             <tbody>

              </tbody>
          </table>
        </div>

        <div class="to_contain" style="width:45%">
          <div class="to_item">
            <div style="width:10%">
              <button type="button" onclick="address_button_click('recipients_tbl');"> > </button><br>
              <button type="button" onclick="address_button_click_back('recipients_tbl');"> < </button>
            </div>
            <div class="mb_c" style="width:90%;overflow-y:scroll;">
            <span>받는 사람</span>
              <table id="recipients_tbl">
                <tbody>

                </tbody>
              </table>
            </div>
          </div>

          <div class="to_item">
            <div style="width:10%;">
              <button type="button" onclick="address_button_click('cc_tbl');"> > </button><br>
              <button type="button" onclick="address_button_click_back('cc_tbl');"> < </button>
            </div>
            <div class="mb_c" style="width:90%;overflow-y:scroll;">
            <span>참조</span>
              <table id="cc_tbl">
              <tbody>

              </tbody>
            </table>
          </div>
          </div>

          <div class="to_item">
            <div style="width:10%;">
              <button type="button" onclick="address_button_click('bcc_tbl');"> > </button><br>
              <button type="button" onclick="address_button_click_back('bcc_tbl');"> < </button>
            </div>
            <div class="mb_c" style="width:90%;overflow-y:scroll;">
            <span>숨은참조</span>
              <table id="bcc_tbl">
                <tbody>
                  <tr class="bcc">

                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>

      <div id="modal_f">
        <button type="button" name="button" onclick="$('#adress_modal').bPopup().close();">취소</button>
        <button type="button" onclick="register_button();" name="button">확인</button>
      </div>
    </div> -->
    <!-- <div id="bigfilediv" style="display:none;background-color:white;width:420px;height:300px;padding-left:20px;">
      <div class="" style="display: flex;
    justify-content: space-between;align-items: center;">
        <h3>대용량 파일첨부</h3>
      </div>
    	<form>
        <div class="" style="display:flex;">
          <div id="queue"></div>
          <div class="" style="display: flex;flex-direction: column;">
            <input id="file_upload" name="file_upload" type="file" multiple="true">
            <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">&nbsp;&nbsp;&nbsp;파일 업로드</a>

          </div>
        </div>
        <div class="" style="display: flex;justify-content: center;">
          <input class="btn-common btn-color2" type="button" name="" value="확인" onclick="complete_bigfile();">
          <input class="btn-common btn-style3" type="button" name="" value="닫기" onclick="$('#bigfilediv').bPopup().close();">
        </div>
    	</form>
    </div> -->

    	<script type="text/javascript">

      function hide_filediv(){
        $('#file_div').hide();
        $('#toggle_topimg').hide();
        $('#genenal_filebtn').hide();
        $('#toggle_downimg').show();
      }

      function show_filediv(){
        $('#file_div').show();
        $('#genenal_filebtn').show();
        $('#toggle_topimg').show();
        $('#toggle_downimg').hide();
      }
      // function complete_bigfile(){
      //   var wait_file = $('.wait_file').length;
      //   var complete_file = $('.complete').length;
      //   alert(complete_file);
      //   alert(wait_file);
      //   if (wait_file > 0) {
      //     $('#hiddenFile').show();
      //   }
      //   $('#bigfilediv').bPopup().close();
      // }
    		<?php $timestamp = time();?>
    		$(function() {
          // $('#file_upload').clearQueue();
    			$('#file_upload').uploadifive({
    				'auto'             : true,
            'removeCompleted' : true,
    				// 'checkScript'      : 'check-exists.php',
    				'formData'         : {
    									   'timestamp' : '<?php echo $timestamp;?>',
    									   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
    				                     },
    				'queueID'          : 'queue',
    				'uploadScript' : "https://mail.durianit.co.kr/misc/module/biguploadifive.php",
    				'onUploadComplete' : function(file, data) {
              var filesize = Number(file.size);
              // console.log(filesize);
              // if(file_size < 1024){
              //
              // }
              if (filesize >= 1073741824) {
                var file_size = (Number(filesize) / Number(1073741824));
                file_size = file_size.toFixed(2) + "GB";
              }else if (filesize >= 1048576) {
                var file_size = (Number(filesize) / Number(1048576));
                file_size = file_size.toFixed(2) + "MB";
              }else if (filesize >= 1024) {
                var file_size = (Number(filesize) / Number(1024));
                file_size = file_size.toFixed(2) + "KB";
              } else {
                var file_size = Number(filesize);
                file_size = file_size.toFixed(2) + "Byte";
              }
              var fileData = "<div class='wait_file'>"
                              + "<input type='hidden' name='bigfileName[]' value='" + file.name + "'/>"
                              + "<input type='hidden' name='bigfileUpName[]' value='<?= $timestamp; ?>_" + file.name + "'/>"
                              + "<input type='hidden' name='orgSize[]' value='" +filesize+"'/>"
                              + "<input type='hidden' name='bigfileSize[]' value='" +file_size+"'/>"
                              + "<a href='https://mail.durianit.co.kr/misc/upload/bigfile/<?php echo $timestamp; ?>_"+file.name+"' download='"+file.name+"'>" +file.name+" <img src='https://mail.durianit.co.kr/misc/img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a>"+"<span style='color:#B0B0B0;margin-left:5px;'>"+ file_size+"</span>"
                              +"<img src='<?php echo $misc;?>/img/btn_del2.jpg' style='cursor:pointer;margin-left:5px;vertical-align:middle;' onclick='bigfile_del(this)'>"
                              + "</div>";

              jQuery("#hiddenFile").append(fileData);

            }
            // $("#bigfilediv").bpopup().close();
    			});
    		});
        function bigfile_del(el){
          // console.log(el);
          el.closest(".wait_file").remove();
        }
        // $(document).on("click", "a[class='close']", function(){
        //   alert("123123");
        //   console.log("1243124bb");
        // })
    	</script>
    <div id="loading_div" style="display:none;">
      <img src="<?php echo $misc; ?>/img/loading.gif" alt="" style="width:100px;">
    </div>
<!-- main_contents 끝 -->
 </div>

  <script>

  // $(".inputsender").keyup(function(){
  //   var inputVal = $(this).val();
  //   $(this).val(inputVal.replace(/[,]/gi,';'));
  // })

  $(function (){
    $("#signature_list").change();
  })

function sign_select(seq){
  var load_content = $("#reply_content").text();
  if(seq =="no"){
    var content = "<p><br></p>";
    content += load_content;
    $("#content").text(content).html();
    loadContent();
    return false;
  }
  $.ajax({
    url: "<?php echo site_url(); ?>/option/get_signcontent",
    type: 'POST',
    dataType: 'json',
    data: {seq:seq},
    success: function (result) {
      var content = result.sign_content;
      if(content == null){
        content = "<p><br></p>";
      }
      content += load_content;

      $("#content").text(content).html();
      loadContent();
    }
  });
}


     $('#address_button').bind('click', function(e) {
       $("#address_search").val("");
       $("#addressspan").click();
       $("#recipients_tbl tr").remove();
       $("#cc_tbl tr").remove();
       $("#bcc_tbl tr").remove();
       var select_recipient = $('#recipient').tagEditor('getTags')[0].tags;
       select_recipient.each(function(idx){
         var escape_idx = idx.replace(/>/g,"&gt;").replace(/</g,"&lt;");
         // escape_idx = escape_idx.replace(/</g,"&lt;");
         var add_tr = "<tr><td>"+escape_idx+"</tr><td>";
         $("#recipients_tbl").append(add_tr);
       })

       var select_recipient = $('#cc').tagEditor('getTags')[0].tags;
       select_recipient.each(function(idx){
         var escape_idx = idx.replace(/>/g,"&gt;").replace(/</g,"&lt;");
         var add_tr = "<tr><td>"+escape_idx+"</tr><td>";
         $("#cc_tbl").append(add_tr);
       })

       var select_recipient = $('#bcc').tagEditor('getTags')[0].tags;
       select_recipient.each(function(idx){
         var escape_idx = idx.replace(/>/g,"&gt;").replace(/</g,"&lt;");
         var add_tr = "<tr><td>"+escape_idx+"</tr><td>";
         $("#bcc_tbl").append(add_tr);
       })

       e.preventDefault();
        $('#adress_modal').bPopup({
            modalClose : true
           });
         });



      $("#address_search").keydown(function(e){
        const keyCode = e.keyCode;

        if(keyCode == 13){ // Enter key
          $("#add_search_btn").click();
        }
      })


           $("#add_search_btn").click(function(){
              var el = $("#adress_modal .selected");
              if (el.attr("id") == "addressspan") {
                var mode = "address";
              } else {
                var mode = "mailbox";
              }

              group_button_click(mode, el);

           })

           // $("#adress_modal input").click(function(){
           //   console.log("1234141");
           // })
      function select_mygroup(seq, el){
        $(".select_mygroup").each(function(){
          $(this).removeClass("select_mygroup");
        })
        $(el).addClass("select_mygroup");
        $("#select_group_input").val(seq);
        var type = $("#adress_modal .selected");
        // console.log(type);

        group_button_click("address", type);
      }

      function group_button_click(mode, el){
        if (mode == 'address') {
          $("#my_groupdiv").show();
          $("#address_div").css("width","70%");
        } else {
          $("#my_groupdiv").hide();
          $("#address_div").css("width","100%");
        }
        var search_keyword = $("#address_search").val();
        var my_group = $("#select_group_input").val();
        $("#adress_modal .selected").removeClass("selected");
        $(el).addClass("selected");

        $("#group_table tr").remove(); // 한번 띄워주고 테이블 초기화
        $.ajax({
              url:"<?php echo site_url();?>/group/get_user_address",
              type:"GET",
              dataType : 'json',
              data:{
                mode:mode,
                search_keyword: search_keyword,
                my_group: my_group
              },
              success: function(result){
                // console.log(result.length);
                if(result.length > 0){
                  // $('#group').text(result);

                  for (var i = 0; i < result.length; i++) {
                    // console.log(result[i].user_name);
                  var name=result[i].name;
                  var email=result[i].email;
                  var tag = "<tr><td height='30' name='select_name_td'>"+ name +"</td>";
                  tag += "<td name='select_mail_td'>"+ email +"</td></tr>";
                  // console.log(tag);
                  $("#group_table tbody").append(tag);
                  // append이용해서 table tr태그를 생성해서 갖다붙임, group_table는 테이블id
                  }

                }
                else{
                  console.log("실패");
                }
               }

             });
     }
     // 주소록에서 클래스 선택,삭제
     $(document).on("click", "#group_table tr", function () {
       var selected=$(this).hasClass("user_selected");
       if(selected){
        $(this).removeClass("user_selected");
       }else{
         $(this).addClass("user_selected");
       }
       });

       //받는사람으로 값 보내기
       function address_button_click(table_id){
        $(".user_selected").each(function(index,obj){

          var contents =$(obj).find('td[name=select_mail_td]').html();
          var tag = "<tr><td>"+ contents +"</td></tr>";
          $("#"+table_id).append(tag);
          $(this).removeClass("user_selected");
        })

       }

       //받는사람table  클래스 선택,삭제
       $(document).on("click", ".to_item table tr", function () {
         var selected=$(this).hasClass("user_selected");
         if(selected){
          $(this).removeClass("user_selected");
         }else{
           $(this).addClass("user_selected");
         }
         });

         // 받는사람table 취소
          function address_button_click_back(table_id){
            // console.log(table_id);
           $("#"+ table_id).find(".user_selected").each(function(){
             $(this).remove(); // 현재 선택된 것만 삭제
           })
          }

          // Remove all tags
          function removeAllTag() {
              var tags = $('#recipient').tagEditor('getTags')[0].tags;
              for (i = 0; i < tags.length; i++) { $('#recipient').tagEditor('removeTag', tags[i]); }

              var tags = $('#cc').tagEditor('getTags')[0].tags;
              for (i = 0; i < tags.length; i++) { $('#cc').tagEditor('removeTag', tags[i]); }

              var tags = $('#bcc').tagEditor('getTags')[0].tags;
              for (i = 0; i < tags.length; i++) { $('#bcc').tagEditor('removeTag', tags[i]); }
          }

          function register_button(){
            // var recipients_length=$("#recipients_tbl >tbody tr").length
            // console.log(recipients_length);
            var recipient_mail = [];
            var cc_mail = [];
            var bcc_mail = [];
            removeAllTag();
            $("#recipients_tbl td").each(function(){
              var td_val = $(this).html(); //$(this).text랑 이양, each반복문으로 하나하나 가져옴
              // td_val = td_val.split(" ")[2];
              td_val = td_val.replace(/&gt;/g,">").replace(/&lt;/g,"<");
              // recipient_mail.push(td_val);
              $("#recipient").tagEditor('addTag', td_val);
            })

            $("#cc_tbl td").each(function(){
                var cc_td_val = $(this).html();
                // cc_td_val = cc_td_val.split(" ")[2];
                // console.log(cc_td_val);
                cc_td_val = cc_td_val.replace(/&gt;/g,">").replace(/&lt;/g,"<");
                cc_mail.push(cc_td_val);
                $("#cc").tagEditor('addTag', cc_td_val);
            })

            $("#bcc_tbl td").each(function(){
                var bcc_td_val = $(this).html();
                // bcc_td_val = bcc_td_val.split(" ")[2];
                // console.log(cc_td_val);
                bcc_td_val = bcc_td_val.replace(/&gt;/g,">").replace(/&lt;/g,"<");
                bcc_mail.push(bcc_td_val);
                $("#bcc").tagEditor('addTag', bcc_td_val);
            });
            // recipient_mail = recipient_mail.join("; ");
            // $("#recipient").val(recipient_mail);
            // cc_mail = cc_mail.join("; ");
            // $("#cc").val(cc_mail);
            // bcc_mail = bcc_mail.join("; ");
            // $("#bcc").val(bcc_mail);

            $("#adress_modal").bPopup().close();

          }

         // $("#attachment").change(function(e){
         //   console.log(e);
         // var file = this.files[0].size;
         // // var file = this.files[0].name;
         // console.log(file);
         // })

// 파일 리스트 번호
var fileIndex = 0;
// 등록할 전체 파일 사이즈
var totalFileSize = 0;
// 파일 리스트
var fileList = new Array();
// 파일 사이즈 리스트
var fileSizeList = new Array();
// 등록 가능한 파일 사이즈 MB
var uploadSize = 50;
// 등록 가능한 총 파일 사이즈 MB
var maxUploadSize = 50;

$(function (){
    // 파일 드롭 다운
    fileDropDown();
});

 $("#file_up").change(function(e){
    var file = this.files;

    selectFile(file);

 })
// 파일 드롭 다운
function fileDropDown(){
    var dropZone = $("#dropZone");
    //Drag기능
    dropZone.on('dragenter',function(e){
        e.stopPropagation();
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#E3F2FC');
    });
    dropZone.on('dragleave',function(e){
        e.stopPropagation();
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#FFFFFF');
    });
    dropZone.on('dragover',function(e){
        e.stopPropagation();
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#E3F2FC');
    });
    dropZone.on('drop',function(e){
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#FFFFFF');

        var files = e.originalEvent.dataTransfer.files;
               // console.log(e);
        if(files != null){
            if(files.length < 1){
                alert("폴더 업로드 불가");
                return;
            }
            selectFile(files)
        }else{
            alert("ERROR");
        }
    });
}

// 파일 선택시
function selectFile(files){
    // 다중파일 등록
    if(files != null){

        for(var i = 0; i < files.length; i++){
            // 파일 이름
            var fileName = files[i].name;
            var fileNameArr = fileName.split("\.");
            // 확장자
            var ext = fileNameArr[fileNameArr.length - 1];
            // 파일 사이즈(단위 :MB)
            var fileSize = files[i].size / 1024 / 1024;

            if($.inArray(ext, ['exe', 'bat', 'sh', 'java', 'jsp', 'html', 'js', 'css', 'xml']) >= 0){
                // 확장자 체크
                alert("등록 불가 확장자");
                break;
            }else if(fileSize > uploadSize){
                // 파일 사이즈 체크
                alert("용량 초과\n업로드 가능 용량 : " + uploadSize + " MB");
                break;
            }else{
                // 전체 파일 사이즈
                totalFileSize += fileSize;

                // 파일 배열에 넣기
                fileList[fileIndex] = files[i];

                // 파일 사이즈 배열에 넣기
                fileSizeList[fileIndex] = fileSize;

                // 업로드 파일 목록 생성
                addFileList(fileIndex, fileName, fileSize);

                // 파일 번호 증가
                fileIndex++;
            }
        }

    }else{
        alert("ERROR");
    }
}

// 업로드 파일 목록 생성
function addFileList(fIndex, fileName, fileSize){
    if (fileSize > 1) {
      fileSize = Math.round((fileSize + Number.EPSILON) * 100) / 100 + "MB ";
    } else {
      fileSize = (fileSize*1024);
      fileSize = Math.round((fileSize + Number.EPSILON) * 100) / 100 + "KB ";
    }
    var html = "";
    html += "<tr id='fileTr_" + fIndex + "'>";
    html += "    <td class='left' >";
    html +=         fileName + " <span style='color:silver;padding-left:10px;'> " + fileSize + "</span><a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
    html += "    </td>";
    html += "</tr>";

    $('#fileTableTbody').append(html);
}

// 업로드 파일 삭제
function deleteFile(fIndex){
    // 전체 파일 사이즈 수정
    totalFileSize -= fileSizeList[fIndex];

    // 파일 배열에서 삭제
    delete fileList[fIndex];

    // 파일 사이즈 배열 삭제
    delete fileSizeList[fIndex];

    // 업로드 파일 테이블 목록에서 삭제
    $("#fileTr_" + fIndex).remove();
}


var chkForm = function () {
  var red_length = $(".red-tag").length;
  if(red_length > 0){
    alert("메일 주소를 확인해주세요.");
    return false;
  }
  var recipient_tag = $('#recipient').tagEditor('getTags')[0].tags;
  var cc_tag = $('#cc').tagEditor('getTags')[0].tags;
  var bcc_tag = $('#bcc').tagEditor('getTags')[0].tags;
  $("#recipient").val(recipient_tag);
  $("#cc").val(cc_tag);
  $("#bcc").val(bcc_tag);
  $("#loading_div").bPopup(
    {
      modalClose: false
    }
  )


  var mform = document.tx_editor_form;

  if (mform.recipient.value == "") {
 		mform.recipient.focus();
      $("#loading_div").bPopup().close();
  		alert("받는사람을 입력해 주세요.");
  		return false;
  	}

    $("#contents").val(Editor.getContent());
  	var formData = new FormData(document.getElementById("tx_editor_form"));

    // file_realname = file_realname.filter(Boolean);
    // file_changename = file_changename.filter(Boolean);
    // formData.append('file_realname', file_realname.join('*/*'));
    // formData.append('file_changename', file_changename.join('*/*'));

    // 등록할 파일 리스트
    var uploadFileList = Object.keys(fileList);

    // 파일이 있는지 체크
    formData.append('file_length', uploadFileList.length);
    if(uploadFileList.length > 0){
        // 용량을 500MB를 넘을 경우 업로드 불가
      if (totalFileSize > maxUploadSize) {
        // 파일 사이즈 초과 경고창
        alert("총 용량 초과\n총 업로드 가능 용량 : " + maxUploadSize + " MB");
        return;
      }
      // 등록할 파일 리스트를 formData로 데이터 입력
      for (var i = 0; i < uploadFileList.length; i++) {
        formData.append('files[]', fileList[uploadFileList[i]]);
      }
    }

    $.ajax({
         url: "<?php echo site_url(); ?>/mail_write/mail_write_action",
         data: formData,
         type: 'POST',
         enctype: 'multipart/form-data',
         processData: false,
         contentType: false,
         dataType: 'json',
         cache: false,
         success: function (result) {
           console.log(result);
            if (result == "success") {
              $("#loading_div").bPopup().close();
              alert("전송되었습니다.");
             location.href ="<?php echo site_url();?>/mail_write/page";
            } else {
              console.log(result);
              alert("전송에 실패하였습니다.");
            }
         }
      });

}

function download(box, msg_no, part_no, encoding, f_name) {
  var newForm = $('<form></form>');
  newForm.attr("method","post");
  newForm.attr("action", "<?php echo site_url(); ?>/mailbox/download");
  // site_url() : http://dev.mail.durianit.co.kr/index.php

  newForm.append($('<input>', {type: 'hidden', name: 'box', value: box }));
  newForm.append($('<input>', {type: 'hidden', name: 'msg_no', value: msg_no }));
  newForm.append($('<input>', {type: 'hidden', name: 'part_no', value: part_no }));
  newForm.append($('<input>', {type: 'hidden', name: 'encoding', value: encoding }));
  newForm.append($('<input>', {type: 'hidden', name: 'f_name', value: f_name }));
  newForm.appendTo('body');
  newForm.submit();
}

function del_fwfile(el){
  $(el).closest("tr").remove();
  const fw_lengh = $("input[name='fw_part[]']").length;
  if (fw_lengh <= 0) {
    $("#fw_filetbl").remove();
  }
}


const lmtp_mail = ["durianit.co.kr", "durianit.com", "durianict.co.kr", "the-mango.co.kr", "the-mango.com"];
const mailRegExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
var addtag = $('#recipient, #cc, #bcc').tagEditor({
    autocomplete: {
        delay: 0, // show suggestions immediately
        position: { collision: 'flip' }, // automatic menu position up/down
        // source: ['bhkim@durianit.co.kr', 'test2@durianict.co.kr', 'test3@durianict.co.kr', 'asf', 'test']
        source: <?php echo json_encode($recentmail_list); ?>

    },
    forceLowercase: false,
    removeDuplicates: false,
//     onChange: function(field, editor, tags, val) {
//       console.log(field);
//       console.log(editor);
//       console.log(tags);
//       console.log($(this));
//       // $(editor).find('.tag-editor-tag').addClass('red-tag');
//     //   $(editor).each(function(){
//     //     var li = $(this);
//     //     li.addClass('red-tag');
//     // });
//     // $('#response').prepend(
//     //     'Tags changed to: ' + (tags.length ? tags.join(', ') : '----') + '<hr>'
//     // );
//       alert("zzzz");
// },
    onChange: email_check
    // beforeTagSave: function(field, editor, tags, tag, val) {
    //   if(tag != ""){
    //     $(editor).find('.active').addClass('red-tag');
    //   }
    // }
});

$(".tag-editor").on("focus", "input", function () {
  $(this).closest("li").removeClass('check-y');
});

function email_check(field, editor, tags) {
    const err1 = "메일 형식에 맞지 않습니다.";
    const err2 = "해당 메일박스가 존재하지 않습니다.";
    $(editor).find('li:not(".check-y")').each(function(index){
        if(index == 0){
          return true;
        }
        var li = $(this);
        var li_val = li.find('.tag-editor-tag').text();
        if (li_val.indexOf("<") !== -1){
          li_val = li_val.split("<")[1];
          li_val = li_val.substr(0, li_val.length-1);
        }

        if (li_val.match(mailRegExp) != null) {
          var split = li_val.split("@")[1].trim();
          if (lmtp_mail.indexOf(split) !== -1) {
            $.ajax({
                 url: "<?php echo site_url(); ?>/mail_write/lmtp_valid",
                 type: 'post',
                 dataType: 'json',
                 data: {
                   mail : li_val
                 },
                 async: false,
                 success: function (result) {
                   // console.log(`cnt는 ${result}`);
                    if (result == 1) {
                      li.removeClass('red-tag');
                      li.addClass('check-y');


                    } else {
                      li.removeClass('check-y');
                      li.addClass('red-tag');
                      li.attr('title', err2);
                    }
                 }
              });

          } else {
            li.removeClass('red-tag');
            li.addClass('check-y');
          }
        } else {
          li.removeClass('check-y');
          li.addClass('red-tag');
          li.attr('title', err1);
        }

    });
}

// function lmtp_check(mail){
//   if (mail.match(mailRegExp) != null) {
//     var split = mail.split("@")[1].trim();
//     if (lmtp_mail.indexOf(split) !== -1) {
//       $.ajax({
//            url: "<?php echo site_url(); ?>/mail_write/lmtp_valid",
//            type: 'post',
//            dataType: 'json',
//            data: {
//              mail : mail
//            },
//            async: false,
//            success: function (result) {
//              console.log(`cnt는 ${result}`);
//               if (result == 1) {
//                 alert("val");
//                 console.log(result);
//                 return "valid";
//               } else {
//                 console.log(result);
//                 return "err2";
//               }
//            }
//         });
//
//     } else {
//       return "valid";
//     }
//
//   } else {
//     return "err1";
//   }
// }


//jquery ui type MSIE 에러 잡는 코드
jQuery.browser = {};
  (function () {
      jQuery.browser.msie = false;
      jQuery.browser.version = 0;
      if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
          jQuery.browser.msie = true;
          jQuery.browser.version = RegExp.$1;
      }
  })();
  </script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>

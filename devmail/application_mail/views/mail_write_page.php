<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_side.php";
 ?>


 <link rel="stylesheet" href="<?php echo $misc; ?>/daumeditor-7.4.9/css/editor.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="<?php echo $misc; ?>/css/style.css" type="text/css" charset="utf-8"/>
 <script src="<?php echo $misc; ?>/daumeditor-7.4.9/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
 <!-- <script type="text/javascript" src="/misc/js/board/board_script_daum.js"></script> -->
 <!-- <script src="/misc/js/jquery.bpopup-0.1.1.min.js"></script> -->

 <!-- 넓이 높이 조절 -->
 <style>

    /* #recipient{
      background-color: pink;
    } */

  #group_table td {
    border-bottom:1px solid #DFDFDF;
    height: 30px;
  }

  #group_table td:hover {
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

  .to_item{
    display: flex;
    height: 33%;
  }


   </style>

    <div id="main_contents" align="center">
        <div id="send_top" align="left" style="width:95%;padding-bottom:10px;">
          <button type="button" class="btn_basic btn_blue" name="button" id="submit_button" enctype="multipart/form-data" style="width:80px" onclick="chkForm();return false;">보내기</button>
  <button type="button" class="btn_basic btn_white" name="" style="width:80px">미리보기</button>
    <button type="button" class="btn_basic btn_white" style="width:80px">임시저장</button>
        </div>
        <div class="main_div">
          <form action="<?php echo site_url();?>/mail_write/mail_write_action" method="post" enctype="multipart/form-data" id="tx_editor_form" name="tx_editor_form">
        <!-- <input type="text" id="recipient" name="recipient" value="" placeholder="받는 사람"><br> -->

        <table width="90%" class="contents_tbl" border="0" cellspacing="0" cellpadding="0">
          <colgroup>
            <col width=10% align="left">
            <col width=85%>
            <col width=5%>
          </colgroup>

          <tr class="mail_write">
              <td>받는사람</td>
              <td>
                <input type="text" class="input_basic" id="recipient" name="recipient" value="" placeholder="받는 사람" style="width:100%">
              </td>
              <td align="right"><button class="btn_basic btn_white" type="button" id="address_button" name="address_button">주소록</button></td>
          </tr>


          <tr class="mail_cc">
              <td>참조
                <span style="font-size:8px;float:right;padding-right:10px;">아래</span>
              </td>
              <td>
                <input type="text" class="input_basic" id="cc" name="cc" value="" placeholder="참조" style="width:100%">
              </td>
              <td>

              </td>
          </tr>

          <tr class="mail_bcc">
              <td>숨은 참조</td>
              <td>
                <input type="text" class="input_basic" id="bcc" name="bcc" value="" placeholder="숨은 참조" style="width:100%">
              </td>
              <td></td>
          </tr>

          <tr class="mail_title">
            <td>제목
              <span style="font-size:8px;float:right;padding-right:10px;"><input type="checkbox" name="" value="">중요</span>
            </td>
            <td>
              <input type="text" class="input_basic" id="title" name="title" value="" placeholder="제목" style="width:100%">
            </td>
            <td></td>
          </tr>
          <tr class="attachment">
              <td>첨부파일</td>
              <td>
                <label class="btn_basic btn_white" for="file_up" style="cursor:pointer;display:block;width:100px;text-align:center;">
                  <span style="color: #1C1C1C; font-size:14px;">파일첨부</span>
                </label>
							  <input type="file" id="file_up" class="file-input" style="display:none;" multiple>
              </td>
              <td></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2">
              <table class="basic_table" width="100%" height="auto" style="min-height: 60px;border:solid 1px #B0B0B0;">
     							 <tbody id="fileTableTbody">
     									<tr>
     										 <td id="dropZone" align="center" style="color:#B0B0B0;">
                          마우스로 파일을 끌어오세요.
     										 </td>
     									</tr>
     							 </tbody>
     				 </table>
            </td>
          </tr>

          <tr>
            <td colspan="3">
              <textarea name="content" id="content" style="display:none;"></textarea>
                <input type="hidden" name="contents" id="contents" value="">
                <?php include $this->input->server('DOCUMENT_ROOT')."/devmail/misc/daumeditor-7.4.9/editor.php"; ?>
            </td>
          </tr>
        </table>
      </form>
      </div>


    <!-- 모달창 -->
    <div id="adress_modal" style="display: none; background-color: white; width: 40vw; height: 70vh;">
      <div id="modal_h">
        <p>주소록</p>
        <p>주소록검색<input type="text" name="" value=""></p>
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
    </div>

    <div id="loading_div" style="display:none;">
      <img src="<?php echo $misc; ?>/img/loading.gif" alt="" style="width:100px;">
    </div>
<!-- main_contents 끝 -->
 </div>
  <script>
     $('#address_button').bind('click', function(e) {
       e.preventDefault();
        $('#adress_modal').bPopup({
            modalClose : true
           });
         });

      function group_button_click(group_name){

       $.ajax({
              url:"<?php echo site_url();?>/mail/group_button",
              type:"GET",
              dataType : 'json',
              data:{g_name:group_name},
              success: function(result){
                if(result != ""){
                  // $('#group').text(result);
                  $("#group_table tr").remove(); // 한번 띄워주고 테이블 초기화

                  for (var i = 0; i < result.length; i++) {
                    // console.log(result[i].user_name);
                  var name=result[i].user_name;
                  var groupName=result[i].parentGroupName;
                  var email=result[i].user_email;
                  var tag = "<tr><td>"+ name +" "+ groupName +" "+ email +"</td></tr>";
                  $("#group_table").append(tag);
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
          // console.log(index);
          // console.log(obj);
          var contents =$(obj).children().html();
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

         function register_button(){
           var recipients_length=$("#recipients_tbl >tbody tr").length
           // console.log(recipients_length);
           var recipient_mail = [];
           var cc_mail = [];
           var bcc_mail = [];
           $("#recipients_tbl td").each(function(){
             var td_val = $(this).html(); //$(this).text랑 이양, each반복문으로 하나하나 가져옴
             td_val = td_val.split(" ")[2];

             recipient_mail.push(td_val);

           })

           $("#cc_tbl td").each(function(){
               var cc_td_val = $(this).html();
               cc_td_val = cc_td_val.split(" ")[2];
               // console.log(cc_td_val);
               cc_mail.push(cc_td_val);

           })

           $("#bcc_tbl td").each(function(){
               var bcc_td_val = $(this).html();
               bcc_td_val = bcc_td_val.split(" ")[2];
               // console.log(cc_td_val);
               bcc_mail.push(bcc_td_val);

           });

           $("#recipient").val(recipient_mail); // 모달창 말고 메일쓰기화면에서 받는사람 id값
           $("#cc").val(cc_mail);
           $("#bcc").val(bcc_mail);
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
var maxUploadSize = 500;

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
    var html = "";
    html += "<tr id='fileTr_" + fIndex + "'>";
    html += "    <td class='left' >";
    html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='<?php echo $misc;?>/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
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
  $("#loading_div").bPopup(
    {
      modalClose: false
    }
  )
  var mform = document.tx_editor_form;

  if (mform.recipient.value == "") {
 		mform.recipient.focus();
  		alert("제목을 입력해 주세요.");
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
             //  alert("전송되었습니다.");
             // location.href ="<?php echo site_url();?>/mail_write/page";
            } else {
              console.log(result);
              alert("전송에 실패하였습니다.");
            }
         }
      });

}




  </script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/devmail/include/mail_footer.php";
 ?>

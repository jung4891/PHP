<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
     <!-- 클래식 에디터 -->
     <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
    <script type="text/javascript" src="/misc/js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/misc/js/ckeditor/config.js"></script>
    <!-- Bpopup -->
    <script src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>



     <!-- 넓이 높이 조절 -->
     <style>
     .ck.ck-editor {
         max-width: 1100px;
     }
     .ck-editor__editable {
         min-height: 300px;
     }

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

      <div id="main_contents">
      <h3>메일 쓰기</h3>
      <form action="<?php echo site_url();?>/mail/mail_write_action" method="post">
        <div>
        <!-- <input type="text" id="recipient" name="recipient" value="" placeholder="받는 사람"><br> -->
        <button type="button" id="address_button" name="address_button">주소록</button>


        <table width="100%" class="" border="0" cellspacing="0" cellpadding="0">
          <tr class="mail_write">
              <th>받는사람</th>
              <td><input type="textarea" id="recipient" name="recipient" value="" placeholder="받는 사람" size=150></td>
          </tr><br>

            <tr class="mail_title">
              <th>제목</th>
              <td>
              <input type="textarea" id="title" name="title" value="" placeholder="제목" size=150>
            </td>
          </tr><br>

          <tr class="mail_cc">
              <th>참조</th>
              <td><input type="textarea" id="cc" name="cc" value="" placeholder="참조" size=150></td>
          </tr><br>

          <tr class="mail_bcc">
              <th>숨은 참조</th>
              <td><input type="textarea" id="bcc" name="bcc" value="" placeholder="숨은 참조" size=150></td>
          </tr>
        </table><br>
      </div>


      <div id="classic">

      </div>

      <div class="">
        <button type="submit" name="button">전송</button>
      </div>
    </form>

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
              <table class="to_tbl" name="" id="bcc_tbl">
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>

      <div id="modal_f">
        <button type="button" name="button" onclick="$('#adress_modal').bPopup().close();">취소</button>
        <button type="button" onclick="" name="button">확인</button>
      </div>
    </div>

<!-- main_contents 끝 -->
</div>
  <script>
      ClassicEditor
          .create( document.querySelector( '#classic' ))
          .catch( error => {
              console.error( error );
          } );


        function LoadPage() {
          CKEDITOR.replace('contents');
        }

        function FormSubmit(f) {
           CKEDITOR.instances.contents.updateElement();
           if(f.contents.value == "") {
              alert("내용을 입력해 주세요.");
              return false;
            }
              alert(f.contents.value);
              // 전송은 하지 않습니다.
               return false;
             } //]]>



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
         console.log(table_id);
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
            $("#"+table_id).find(".user_selected").each(function(){
                // obj.remove();
                // or
                $(this).remove();
           })
          }


         //참조table  클래스 선택,삭제
         // $(document).on("click", "#cc_tbl tr", function () {
         //   var cc_selected=$(this).hasClass("user_cc_selected");
         //   if(cc_selected){
         //    $(this).removeClass("user_cc_selected");
         //   }else{
         //     $(this).addClass("user_cc_selected");
         //   }
         //   });



           //숨은참조talbe  클래스 선택,삭제
           // $(document).on("click", "#bcc_tbl tr", function () {
           //   var selected=$(this).hasClass("user_selected");
           //   if(selected){
           //    $(this).removeClass("user_selected");
           //   }else{
           //     $(this).addClass("user_selected");
           //   }
           //   });




  </script>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>

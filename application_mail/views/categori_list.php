<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
  <style>
  #group_view tr:hover {
    background-color: #e7f3ff;
  }

  #group_view td {
    border-top:1px solid #dedede;
  }

  #address_group_tbl tr:not(:first-child):hover{
    background-color: #e7f3ff;
  }

  .select_group{
    color:#0575E6;
    font-weight: bold;
  }

  .td_input{
    align:center;
    }


    .nav_btn{
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      border:1px solid #B0B0B0;
      border-bottom: none;
      height: 30px;
      width: 100px;
      cursor: pointer;
      background-color: #FFFFFF;
      color: #1C1C1C;
      border-radius: 10px 10px 0px 0px;
    }

    .select_btn{
      border:none;
      background-color: #1A8DFF;
      color: #FFFFFF;
    }

    .admin_btn{
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      border:1px solid #B0B0B0;
      height: 30px;
      cursor: pointer;

    }

    .white_btn{
      background-color: white;
      color:#1C1C1C;
    }

    .grey_btn{
      background-color: #F1F3F4;
      color:#6C6C6C;
    }

  </style>

  <script language="javascript">
  // function GoSearch(){
  //    // var searchkeyword = document.mform.searchkeyword.value;
  //    // var searchkeyword = searchkeyword.trim();
  //  // var searchdomain = document.mform.searchdomain.value;
  //  // var searchdomain = searchdomain.trim();
  //    // if (searchkeyword.replace(/,/g, "") == "") {
  //    //     // alert("검색어가 없습니다.");
  //    //     location.href="<?php echo site_url();?>/admin/mailbox/mail_list";
  //    //     return false;
  //    // }
  //
  //    document.mform.action = "<?php echo site_url();?>/group/address_book_view";
  //    document.mform.cur_page.value = "";
  //    document.mform.submit();
  // }

  function GoFirstPage (){
     document.mform.cur_page.value = 1;
     document.mform.submit();
  }

  function GoPrevPage (){
     var   cur_start_page = <?php echo $cur_page;?>;

     document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
     document.mform.submit( );
  }

  function GoPage(nPage){
     document.mform.cur_page.value = nPage;
     document.mform.submit();
  }

  function GoNextPage (){
     var   cur_start_page = <?php echo $cur_page;?>;

     document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
     document.mform.submit();
  }

  function GoLastPage (){
     var   total_page = <?php echo $total_page;?>;
  //   alert(total_page);

     document.mform.cur_page.value = total_page;
     document.mform.submit();
  }

  $(document).on("click", "#address_group_tbl tr", function(){
    var group_seq = $(this).attr("data-groupseq");
    document.mform.group_name.value = group_seq;
    document.mform.cur_page.value = "";
    document.mform.submit();
  })


  </script>


<div id="main_contents" align="center">
    <form name="" action="" method="post">
      <div class="" align="left" width=100% style="border-bottom:1px solid #1A8DFF;margin:-10px 40px 10px 40px;">
        <button type="button" name="button" class="nav_btn" style="margin-left:10px;"onclick="location.href='<?php echo site_url(); ?>/option/user'">계정설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/mailbox'">메일함설정</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/address_book'">주소록관리</button>
        <button type="button" name="button" class="nav_btn" onclick="location.href='<?php echo site_url(); ?>/option/singnature'">서명관리</button>
        <button type="button" name="button" class="nav_btn select_btn" onclick="location.href='<?php echo site_url(); ?>/option/categorize'">메일분류</button>
      </div>
    </form>
<?php
// var_dump($categori_list);

 ?>
            <form name="mform" action="<?php echo site_url(); ?>/option/categorize" method="get" style="width:100%;height:100%;overflow-y:scroll;">
            <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
            <input type="hidden" name="group_name" value="<?php echo $group_name; ?>">
                <table id="" border="0" cellspacing="0" cellpadding="0" style="width:80%">
                  <colgroup>
                    <col width="40%">
                    <col width="40%">
                    <col width="10%">
                    <col width="10%">
                  </colgroup>
                  <tr onclick="detail_address_click();">
                    <th height="40">규칙</th>
                    <th>메일함</th>
                    <th></th>
                    <th></th>
                  </tr>


                   <tbody id="group_view">

                   <?php
                 if ($count > 0) {
                   $i = $count - $no_page_list * ( $cur_page - 1 );
                   $icounter = 0;
                   foreach ($category_list as $cl) {
                     if($cl['sendtype'] == 0){
                       $mail_rule = " 으로부터 받은 메일";

                     } else {
                       $mail_rule = " 으로 보낸 메일";
                     }
                     ?>
                   <tr>
                     <td height="40" align="center">
                       <?php echo $cl['address'].$mail_rule; ?>
                     </td>

                     <td align="center">
                       <?php
                       $mailtext = mb_convert_encoding($cl['mailbox'], 'UTF-8', 'UTF7-IMAP');
                       $mailtext = str_replace("INBOX", "받은 편지함", $mailtext);
                       echo str_replace(".", "/", $mailtext);
                       ?>
                     </td>

                     <td align="center">
                       <input type="button" class="admin_btn white_btn" style="width:80%;" name="button" onclick="classify_modify('<?php echo $cl["seq"]; ?>');" value="수정">
                     </td>
                     <td align="center" style="border-left:unset;">
                       <input type="button" class="admin_btn grey_btn" name="button" style="width:80%;" onclick="classify_del('<?php echo $cl["seq"]; ?>');" value="삭제">
                     </td>

                    </tr>
                 <?php
                 $i--;
                 $icounter++;
               }
             }else{
              ?>
              <tr>
               <td width="100%" height="40" align="center" colspan="6">등록된 규칙이 없습니다.</td>
              </tr>

              <?php
             }
               ?>

                  </tbody>
                </table>

              <div class="paging_div" align="center">
                <?php if ($count > 0) {?>
                  <table width="400" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                  <?php
                  if ($cur_page > 10){
                  ?>
                        <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/icon/처음.svg" width="20" height="20"/></a></td>
                        <td width="2"></td>
                        <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/icon/왼쪽.svg" width="20" height="20"/></a></td>
                  <?php
                  } else {
                  ?>
                  <td width="19"></td>
                        <td width="2"></td>
                        <td width="19"></td>
                  <?php
                  }
                  ?>
                        <td align="center">
                  <?php
                  for  ( $i = $start_page; $i <= $end_page ; $i++ ){
                  if( $i == $end_page ) {
                    $strSection = "";
                  } else {
                    $strSection = "&nbsp;<span class=\"section\">&nbsp&nbsp</span>&nbsp;";
                  }

                  if  ( $i == $cur_page ) {
                    echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
                  } else {
                    echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
                  }
                  }
                  ?></td>
                        <?php
                  if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
                  ?>
                  <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/icon/오른쪽.svg" width="20" height="20"/></a></td>
                        <td width="2"></td>
                        <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/icon/끝.svg" width="20" height="20"/></a></td>
                  <?php
                  } else {
                  ?>
                  <td width="19"></td>
                        <td width="2"></td>
                        <td width="19"></td>
                  <?php
                  }
                  ?>

                      </tr>
                    </table>
                  <?php } ?>
              </div>
              <div class="" style="width:80%;text-align:right;">
                <input type="button" name="" value="등록" onclick="categori_add();"  class="btn_basic btn_blue" style="width:60px;height:30px;">
              </div>

            </form>

  </div>


      <script>

      function categori_add(){
        location.href = "<?php echo site_url(); ?>/option/categorize_add";
      }

      function classify_del(id){

          var con_test = confirm("정말 삭제하시겠습니까?");
          if(con_test == true){
            location.href="<?php echo site_url(); ?>/option/categorize_delete?id="+id;
          }

      }

      function classify_modify(id){

        location.href="<?php echo site_url(); ?>/option/categorize_modify?seq="+id;

      }

      </script>

  </body>
</html>


<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>

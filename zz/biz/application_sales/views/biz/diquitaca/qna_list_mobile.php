<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/misc/css/view_page_common.css">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-bottom:20px;
	}
	.approval_list_tbl {
		padding-top: 20px;
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	/* .approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	} */
	#paging_tbl {
		margin-top:10px;
		width:100%;
	}
	#paging_tbl a {
		font-size: 18px;
	}
	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
  .list_table {border-radius:3px;border:thin solid #D4D4D4;padding:10px;width:100%;margin-top:10px;}
  .list_table td {vertical-align: top;}
  .btn-p {font-size:14px !important; height:auto !important; width:60px; padding-top:2px; padding-bottom:2px;}
	.p_com {background-color: #EAE8E8;color: #767676;}
  .p_ing {background-color: #EBE6FF;color: #5938E4; border:1px solid #BAAAFF;}
  .p_n {background-color: #FFEDED;color: #E53737;}
  .deadline_p_ing, .deadline_p_n {color:#E53737}
  .deadline_p_com {color:#B0B0B0}
  #search_input {width: 75%;border: 1px solid #F4F4F4;border-radius: 3px;padding: 10px 12px;font-size: 14px;box-sizing:border-box;padding-left:35px;background-color:#F4F4F4;}
  #search_input::placeholder{color:color:#B0B0B0}
  #search_img {position:absolute;width:17px;top:10px;left:32px;margin: 0;}
	</style>
  <script language="javascript">
  function GoSearch() {
    var searchkeyword = document.mform.searchkeyword.value;
    var searchkeyword = searchkeyword.trim();

    if(searchkeyword.replace(/,/g, '') == '') {
      alert('검색어가 없습니다.');
      location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";
      return false;
    }

    document.mform.action = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";
    document.mform.cur_page.value = '';
    document.mform.submit();
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
		<form name="mform" action="<?php echo site_url(); ?>/biz/diquitaca/qna_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
      <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
      <input type="hidden" name="lpp" value="<?php echo $lpp; ?>">
      <input type="hidden" name="seq" value="">
      <input type="hidden" name="mode" value="">

      <div class="search_div" style="position:relative;margin-top:20px;padding-left:20px;">
        <img id="search_img" src="/misc/img/mobile/search_gray.svg">
        <input type="hidden" name="search1" value="mobile">
        <input type="text" id="search_input" name="searchkeyword" placeholder="검색어 입력" value="<?php echo str_replace('"', '&uml;', $search_keyword); ?>" autocomplete="off">
        <input type="text" class="btn-common btn-style2" value="검색" style="width:50px;text-align:center;float:right;margin-right:20px;" onclick="return GoSearch();" onclick="return GoSearch();">
      </div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tbody>
<?php foreach ($list_val as $item) {
        if($item['file_changename']) {
          $strFile = "<img src='".$misc."img/attachments_o.svg' width='20' height='20' style='vertical-align:middle' />";
        } else {
          $strFile = "<img src='".$misc."img/attachments_x.svg' width='20' height='20' style='vertical-align:middle' />";
        }
        if($item['vote_yn'] == 'Y') {
          $vote = true;
        } else {
          $vote = false;
        }
        if($vote) {
          $deadline = strtotime($item['vote_deadline']);
          $now = strtotime("Now");
          if($now > $deadline) {
            $vote_progress = 'p_com';
            $vote_progress2 = '투표마감';
          } else if($now < $deadline) {
            $vote_progress = "p_ing";
            $vote_progress2 = "투표중";
          }
          $vote_cnt = $item['vote_cnt'];
        } else {
          $vote_progress = "p_n";
          $vote_progress2 = "미진행";
          $vote_cnt = 0;
        }
        if($item['comment_cnt'] == '') {
          $comment_cnt = '-';
        } else {
          $comment_cnt = $item['comment_cnt'];
        }
        if($item['comment_cnt'] == '') {
          $comment_color = 'color:#B0B0B0;';
          $comment_cnt = '0';
        } else {
          $comment_color = 'color:#0575E6;';
          $comment_cnt = $item['comment_cnt'];
        }
        if($vote_cnt == 0) {
          $vote_color = 'color:#B0B0B0;';
        } else {
          $vote_color = 'color:#0575E6;';
        }
        if($item['user_seq'] == '') {
          $read = "font-weight:bold;";
        } else {
          $read = '';
        }?>
        <tr>
          <td onclick="ViewBoard(<?php echo $item['seq']; ?>)" style="cursor:pointer">
            <table class="list_table" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed;word-break:normal;">
              <tr>
                <td height="20">
					<?php if($item['vote_yn'] == 'Y') { ?>
									<input type="button" class="btn-common btn-color1 btn-p <?php echo $vote_progress; ?>" value="<?php echo $vote_progress2; ?>">
					<?php } else { ?>
									<input type="button" class="btn-common btn-color1 btn-p <?php echo $vote_progress; ?>" value="<?php echo $item['category_name']; ?>" style="border:1px solid <?php echo $item['borderColor']; ?>;background-color:<?php echo $item['bgColor']; ?>;color:<?php echo $item['color']; ?>;">
					<?php } ?>
                </td>
                <td align="right" style="color:#B0B0B0"><?php echo date('Y-m-d', strtotime($item['insert_date'])); ?></td>
              </tr>
              <tr>
                <td height="40" colspan="2" style="padding-top:10px;color:#1C1C1C;font-size:14px;<?php echo $read; ?>"><?php echo stripslashes($item['title']); ?></td>
              </tr>
              <tr>
                <td height="20" colspan="2" style="color:#1C1C1C"><?php echo $item['user_name']; ?></td>
              </tr>
              <tr>
                <td height="20" class="deadline_<?php echo $vote_progress; ?>" style="padding-bottom:5px;"><?php if($vote){echo '투표마감 '.date('Y-m-d H:i', strtotime($item['vote_deadline']));} ?></td>
                <td align="right">
                  <img src='/misc/img/icon_comment.svg' width='20' height='20' style='vertical-align:middle;' />
                  <span style="margin-right:2px;"></span><span style="margin-right:3px;<?php echo $comment_color; ?>"><?php echo $comment_cnt; ?></span>
                  <img src='/misc/img/icon_vote.svg' width='20' height='20' style='vertical-align:middle;margin-left:5px;' />
                  <span style="margin-right:2px;"></span><span style="margin-right:3px;<?php echo $vote_color; ?>"><?php echo $vote_cnt; ?></span>
                  <?php echo $strFile; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
<?php } ?>
<?php if($count == 0) { ?>
				<tr>
					<td colspan="2" align="center" height="40" style="font-weight:bold;">등록된 게시물이 없습니다.</td>
				</tr>
<?php } ?>
			</tbody>
		</table>

		<!-- 페이징 -->
		<table id="paging_tbl" cellspacing="0" cellpadding="0">
		  <!-- 페이징처리 -->
		  <tr>
		     <td align="center">
		     <?php if ($count > 0) {?>
		           <table border="0" cellspacing="0" cellpadding="0">
		                 <tr>
		           <?php
		              if ($cur_page > 10){
		           ?>
		                 <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/></a></td>
		                 <td width="2"></td>
		                 <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/></a></td>
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
		              <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
		                 <td width="2"></td>
		                 <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/></a></td>
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
		     <?php }?>
		           </td>
		     </tr>
		  <!-- 페이징처리끝 -->
		</table>
	</div>
</form>
<div id="icon_inf" style="display: none; position: absolute;background-color: white;border: 2px solid #B0B0B0;
border-radius: 10px; width:90%;">
  <span style="cursor: pointer;float: right;margin-right: 10px;margin-top: 10px;" onclick="$('#icon_inf').bPopup().close();">×</span>
  <div style="padding: 10px 20px 15px 20px;">
    <p class="title" style="color:#1C1C1C">디키타카</p>
    <p class="content" style="color:#B0B0B0">원하는 질문과 답변을 남길 수 있고 투표도 원활하게 진행하고 있습니다.</p>
    <p class="content" style="color:#B0B0B0">재미있는 참여 부탁드리겠습니다.</p>
  </div>
</div>
	<?php // include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script language="javascript">
  function GoFirstPage (){
    document.mform.cur_page.value = 1;
    document.mform.submit();
  }

  function GoPrevPage (){
    var	cur_start_page = <?php echo $cur_page;?>;

    document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
    document.mform.submit( );
  }

  function GoPage(nPage){
    document.mform.cur_page.value = nPage;
    document.mform.submit();
  }

  function GoNextPage (){
    var	cur_start_page = <?php echo $cur_page;?>;

    document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
    document.mform.submit();
  }

  function GoLastPage (){
    var	total_page = <?php echo $total_page;?>;
  //	alert(total_page);

    document.mform.cur_page.value = total_page;
    document.mform.submit();
  }

  function change_lpp() {
    var lpp = $("#listPerPage").val();
    document.mform.lpp.value = lpp;
    document.mform.submit();
  }

  function go_input() {
    location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_input";
  }

  function ViewBoard (seq){
    location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_view?seq=" + seq;
  }

  function open_inf(el) {
    var position = $(el).offset();

    $('#icon_inf').bPopup();
  }
  </script>
</body>

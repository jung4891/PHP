<?php
  include $this->input->server('DOCUMENT_ROOT').'/include/base.php';
  include $this->input->server('DOCUMENT_ROOT').'/include/sales_top.php';
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
  .layerpop {display: none;z-index: 1000;border: 2px solid #ccc;background: #fff;cursor: default;}
  .layerpop_area .modal_title {padding: 30px 10px 0px 20px;font-size: 20px;font-weight: bold;line-height: 24px;text-align: left !important;}
  .layerpop_area .layerpop_close {width: 25px;height: 25px;display: block;position: absolute;top: 10px;right: 10px;background: transparent url('btn_exit_off.png') no-repeat;}
  .layerpop_area .layerpop_close:hover {background: transparent url('btn_exit_on.png') no-repeat;cursor: pointer;}
  .layerpop_area .content {width: 96%;margin: 2%;color: #828282;}
  .list_tbl tr td:not(:first-child){border-left:thin solid #DFDFDF;}
  .list_tbl tr:first-child td{color:#626262}
  .list_tbl tr:not(:first-child) td{color:#1C1C1C}
  #icon_inf .content{color:#626262;line-height: 1}
  .list_table {border-radius:3px;border:thin solid #D4D4D4;padding:10px;width:97%;}
  .list_table td {vertical-align: top;}
  .btn-p {width:auto;font-size:12px;font-weight:bold;padding-left:10px;padding-right:10px;}
  .p_com {background-color: #EAE8E8;color: #767676;}
  .p_ing {background-color: #EBE6FF;color: #5938E4; border:1px solid #BAAAFF;}
  .p_n {background-color: #FFEDED;color: #E53737;}
  .deadline_p_ing, .deadline_p_n {color:#E53737}
  .deadline_p_com {color:#B0B0B0}
  #diquitaca_list tr:not(:first-child) .list_table {margin-top:10px;}
</style>
<script type="text/javascript">
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
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT').'/include/sales_header.php';
?>
<div align="center">
  <div class="dash1-1">
    <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <form name="mform" action="<?php echo site_url(); ?>/biz/diquitaca/qna_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
        <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
        <input type="hidden" name="lpp" value="<?php echo $lpp; ?>">
        <input type="hidden" name="seq" value="">
        <input type="hidden" name="mode" value="">
        <tbody height="100%">
          <tr height="5%">
            <td class="dash_title">
              디키타카
              <img style="cursor:pointer;vertical-align:middle;margin-left:5px;" src="/misc/img/dashboard/btn/btn_info.svg" width="25" onclick="open_inf(this);"/>
            </td>
          </tr>
          <tr>
            <td>
              <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:50px;">
                <tr>
                  <td style="padding-bottom:10px;">전체 <span style="color:#0575E6"><?php echo $count; ?></span>건</td>
                </tr>
                <tr>
                  <td>
                    <select class="select-common select-style1" name="search1" id="search1">
                      <option value="001" <?php if($search1 == "001"){echo "selected";} ?>>제목</option>
                      <option value="002" <?php if($search1 == "002"){echo "selected";} ?>>등록자</option>
                      <option value="003" <?php if($search1 == "003"){echo "selected";} ?>>카테고리</option>
                    </select>
                    <input type="text" name="searchkeyword" size="25" class="input-common" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword); ?>">
                    <input type="button" class="btn-common btn-style2" value="검색" onclick="return GoSearch();">
                    <div style="position:relative;right:0.7%">
                      <input type="button" class="btn-common btn-color2" style="float:right;margin-left:10px;" value="글쓰기" onclick="go_input();">
                      <select class="select-common" id="listPerPage" style="height:25px;float:right;color:#1C1C1C;padding-right:5px;height:30px;" onchange="change_lpp();">
                        <option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건</option>
                        <option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건</option>
                        <option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건</option>
                        <option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건</option>
                        <option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건</option>
                        <option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건</option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr height="45%">
                  <td valign="top" style="padding: 2px 0px 15px 0px;">
                    <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="top">
                          <tr>
                            <td>
                              <table id="diquitaca_list" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
                                <colgroup>
                                  <col width="20%">
                                  <col width="20%">
                                  <col width="20%">
                                  <col width="20%">
                                  <col width="20%">
                                </colgroup>
                      <?php if($count > 0) {
                              $list_array = array_chunk($list_val, 5);
                                foreach($list_array as $list) {
                                  echo "<tr>";
                                  foreach($list as $item) {
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
                                    }
                                    ?>
                                    <td onclick="ViewBoard(<?php echo $item['seq']; ?>)" style="cursor:pointer">
                                      <table class="list_table" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td height="40">
                                    <?php if($item['vote_yn'] == 'Y') { ?>
                                            <input type="button" class="btn-common btn-color1 btn-p <?php echo $vote_progress; ?>" value="<?php echo $vote_progress2; ?>">
                                    <?php } else { ?>
                                            <input type="button" class="btn-common btn-color1 btn-p <?php echo $vote_progress; ?>" value="<?php echo $item['category_name']; ?>" style="border:1px solid <?php echo $item['borderColor']; ?>;background-color:<?php echo $item['bgColor']; ?>;color:<?php echo $item['color']; ?>;">
                                    <?php } ?>
                                          </td>
                                          <td align="right" style="color:#B0B0B0"><?php echo date('Y-m-d', strtotime($item['insert_date'])); ?></td>
                                        </tr>
                                        <tr>
                                          <td height="60" colspan="2" style="color:#1C1C1C;font-size:14px;<?php echo $read; ?>"><?php echo stripslashes($item['title']); ?></td>
                                        </tr>
                                        <tr>
                                          <td height="20" colspan="2" style="color:#1C1C1C"><?php echo $item['user_name']; ?></td>
                                        </tr>
                                        <tr>
                                          <td height="20" colspan="2" class="deadline_<?php echo $vote_progress; ?>" style="padding-bottom:10px;border-bottom:#D4D4D4 solid thin;"><?php if($vote){echo '투표마감 '.date('Y-m-d H:i', strtotime($item['vote_deadline']));} ?></td>
                                        </tr>
                                        <tr>
                                          <td height="40" style="vertical-align:middle;" align="left">
                                            <img src='/misc/img/icon_comment.svg' width='20' height='20' style='vertical-align:middle;' />
                                            <span style="margin-right:5px;">답변</span><span style="<?php echo $comment_color; ?>"><?php echo $comment_cnt; ?></span>
                                    <?php if($item['vote_yn'] == 'Y') { ?>
                                            <img src='/misc/img/icon_vote.svg' width='20' height='20' style='vertical-align:middle;margin-left:5px;' />
                                            <span style="margin-right:5px;">투표</span><span style="<?php echo $vote_color; ?>"><?php echo $vote_cnt; ?></span>
                                    <?php } ?>
                                          </td>
                                          <td align="right" style="vertical-align:middle;">첨부 <?php echo $strFile; ?></td>
                                        </tr>
                                      </table>
                                      </td>
                                    <?php }
                                    echo "</tr>";
                                }
                            } else { ?>
                                <tr>
                                  <td colspan="5" align="center">등록된 게시물이 없습니다.</td>
                                </tr>
                            <?php } ?>
                              </table>
                            </td>
                          </tr>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr height="40%">
            			<td align="left" valign="top">
            				<table width="100%" cellspacing="0" cellpadding="0">
            				<tr>
            					<td width="19%">
            						<tr height="20%">
            							<td align="center" valign="top">
            						<?php if ($count > 0) {?>
      						        <table width="400" border="0" cellspacing="0" cellpadding="0">
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
            						<?php } ?>
            						</td>
            						</tr>
            						<!-- 페이징 끝 -->

            					</td>
            				</tr>

            <!-- 버튼 tr 시작 -->
            			</table>
            		</td>
            		</tr>
              </table>
            </td>
          </tr>
        </tbody>
      </form>
    </table>
  </div>
</div>
<div id="icon_inf" style="display: none; position: absolute;background-color: white;border: 2px solid #B0B0B0;
border-radius: 3px; width:410px;">
  <span style="cursor: pointer;float: right;margin-right: 10px;margin-top: 10px;" onclick="$('#icon_inf').bPopup().close();">×</span>
  <div style="padding: 10px 20px 15px 20px;">
    <p class="content">원하는 질문과 답변을 남길 수 있고 투표도 원활하게 진행하고 있습니다.</p>
    <p class="content">재미있는 참여 부탁드리겠습니다.</p>
  </div>
</div>
</body>
<script type="text/javascript">
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

    $('#icon_inf').bPopup({
      opacity: 0,
      follow: [false, false],
      position: [position.left+25, position.top+25]
    });
  }
</script>

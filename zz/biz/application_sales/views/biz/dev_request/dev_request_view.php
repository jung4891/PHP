<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
</script>
<style media="screen">
.basic_table {border: 1px solid #DEDEDE;}
.list_tbl {border-top: 1px solid #DEDEDE;border-bottom: none;}
.border-l {border-left: 1px solid #DEDEDE;}
.border-r {border-right: 1px solid #DEDEDE;}
.input-common {width:100%;box-sizing: border-box;}
.bardivs { width: 100%; position: relative; }
.progresstext { position: absolute; top: 0; left: 0; width: 98%; padding-top: 5px; text-align: right; font-weight: bold;}
.ui-widget-header{ background-color: #0575E6;}
.ui-corner-all{ background-color: #F8F9FB; border-color: #DEDEDE; border-radius: 3px;}
.num {padding-left:4px;padding-right:4px;width: 30px;height: 25px;margin-left: 3px;text-align: center;font-size: 14px;color: #ccc;vertical-align: middle;}
.item{position: relative;min-height: 25px;border: 1px solid #ebecef;border-radius: 2px;}
.FlexableTextArea {display: inline-block;min-height: 25px;width: calc(100% - 30px);vertical-align: middle;}
.textarea_input{width: 100%;min-height: 25px;border: 0;font-size: 14px;line-height: 19px;letter-spacing: 0;height:25px;font-family: "Noto Sans KR", sans-serif;}
.textarea_input {display: block;width: 100%;min-height: 25px;border: 1px solid #ebecef;box-sizing: border-box;overflow: hidden;resize: none;word-break: break-all;font-size: 15px;letter-spacing: -.23px;line-height: 17px;border: none;}
.layerpop {display: none;z-index: 1000;border: 2px solid #ccc;background: #fff;cursor: default;}
.layerpop_area .modal_title {padding: 30px 10px 0px 20px;font-size: 20px;font-weight: bold;line-height: 24px;text-align: left !important;}
.layerpop_area .layerpop_close {width: 25px;height: 25px;display: block;position: absolute;top: 10px;right: 10px;background: transparent url('btn_exit_off.png') no-repeat;}
.layerpop_area .layerpop_close:hover {background: transparent url('btn_exit_on.png') no-repeat;cursor: pointer;}
.layerpop_area .content {width: 96%;margin: 2%;color: #828282;}
.cnt {position: absolute;top:0;right:0; font-size: 14px;margin-left:2px;padding:2px 6px 2px 6px;color:white;background-color: #0575E6;border-radius:90%;text-align:center;}
.cnt_title {display:inline-block;position: relative;height:100%;width:auto;padding-right:20px;padding-top:10px;}
.dash_title span {position: static;}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
	<div align="center">
		<div class="dash1-1">
			<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
					<form name="rform" method="post">
					<input type="hidden" name="seq" value="<?php echo $view_val['seq']; ?>">
					<input type="hidden" name="cseq" value="">
					<tr>
	  				<td class="dash_title">
							개발 요청 상세사항
						</td>
					</tr>
					<tr>
						<td align="right">
							<input style="margin-top:20px;margin-right:10px;" type="button" class="btn-common btn-color1" value="목록" onClick="javascript:go_list();return false;">
			 <?php if( $id == $view_val['insert_id'] || $this->pGroupName == '기술연구소' ) {

				 ?>
							<input style="margin-top:20px;margin-right:10px;" type="button" class="btn-common btn-color2" value="수정" onClick="javascript:modify_board();return false;">
							<input style="margin-top:20px;" type="button" class="btn-common btn-color2" value="삭제" onClick="javascript:delete_board();return false;">
			<?php } ?>
						</td>
						<tr>
		  				<td align="center" valign="top">
		  					<table width="100%" height="100%" cellspacing="0" cellpadding="0" >
		      				<tr>
		          			<td width="100%" align="center" valign="top">
		          				<table width="100%" border="0" style="margin-top:20px;">
		            				<tr>
		              				<td>
														<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
															<colgroup>
																<col width="15%">
																<col width="35%">
																<col width="15%">
																<col width="35%">
															</colgroup>
															<tr>
																<td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">카테고리</td>
																<td style="padding-left:10px;">
																	<?php echo $view_val['category'] ?>
																</td>
																<td align="center" class="row-color1" style="font-weight:bold;">날짜</td>
						                    <td class="border-r" style="padding-left:10px;"><?php echo $view_val['insert_date'] ?></td>
		                					</tr>
															<tr>
																<td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">제목</td>
																<td style="padding-left:10px;">
																	<?php echo $view_val['subject'] ?>
																</td>
																<td align="center" class="row-color1" style="font-weight:bold;">등록자</td>
						                    <td class="border-r" style="padding-left:10px;">
																<?php echo $view_val['user_name'] ?>
																</td>
															</tr>
															<tr>
																<td align="center" class="row-color1 border-l" style="font-weight:bold;">페이지URL</td>
																<td colspan="3" class="border-r" style="padding-left:10px;">
																	<?php echo $view_val['page_url'] ?>
																</td>
															</tr>
		                          <tr>
		                            <td height="40" align="center" class="row-color1 border-l border-r" colspan="4" style="font-weight:bold;">상세요청사항</td>
		                          </tr>
															<tr>
																<td colspan="4" class="border-l border-r" style="padding:10px 20px 10px 20px;">
																	<?php echo $view_val['contents'] ?>
																</td>
		                					</tr>
															<tr>
																<td align="center" class="row-color1 border-l" style="font-weight:bold;">첨부파일</td>
																<td colspan="3" class="border-r" style="padding-left:10px;">

																	<?php
					 													if ($view_val['file_realname'] != "") {
					 														 $file = explode('*/*',$view_val['file_realname']);
					 														 $file_url = explode('*/*',$view_val['file_changename']);
					 														 for ($i=0; $i<count($file); $i++) {
					 																echo $file[$i];
					 																echo "<a href='{$misc}upload/biz/dev_request/{$file_url[$i]}' download='{$file[$i]}'> <img src='{$misc}img/download.svg' style='width:15px;vertical-align:middle;cursor:pointer;margin:5px 0px 5px 10px;'></a><br>";
					 														 }
					 													}
					 											 ?>
															</td>
															</tr>
														  <tr>
															  <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">개발진행상황</td>
															  <td style="padding-left:10px;">
																	<?php
																	if ($view_val) {
																		echo $view_val['progress_step'];
																	}
																	?>
															  </td>
															  <td align="center" class="row-color1" style="font-weight:bold;">담당자</td>
															  <td class="border-r" style="padding-left:10px;">
																	<?php
																	if ($view_detail_val) {
																		echo $view_detail_val['responsibility'];
																	}
																	?>
															  </td>
														  </tr>
														  <tr>
															  <td align="center" class="row-color1 border-l" style="font-weight:bold;">개발시작일</td>
															  <td style="padding-left:10px;">
																	<?php
																	if ($view_detail_val) {
																		echo $view_detail_val['start_date'];
																	}
																	?>
															  </td>
																<td align="center" class="row-color1" style="font-weight:bold;">완료예정일</td>
															  <td  class="border-r" style="padding-left:10px;">
																	<?php
																	if ($view_detail_val) {
																		echo $view_detail_val['expected_end_date'];
																	}
																	?>
															  </td>
														  <tr>
															  <td height="40" align="center" class="row-color1 border-l border-r" colspan="4" style="font-weight:bold;">개발노트</td>
														  </tr>
														  <tr>
															  <td colspan="4" class="border-l border-r" style="padding:10px 20px 10px 20px;">
																	<?php
																	if ($view_detail_val) {
																		echo $view_detail_val['contents'];
																	}
																	?>
															  </td>
		              						</table>
														</td>
		            					</tr>
												</tr>
												<?php foreach($clist_val as $cv) { ?>
																<tr>
																	<td bgcolor="f8f8f9">
																		<table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:thin solid #DFDFDF">
																			<tr height="30px">
																				<td width="100px" class="tbl-mid" style="border-right:thin solid #DFDFDF;">
																					<?php echo $cv['user_name']; ?>
																				</td>
																				<td width="100px" class="tbl-mid" style="border-right: this solid #DFDFDF;">
																					<?php echo date('Y-m-d', strtotime($cv['insert_date'])); ?>
																				</td>
																				<td align="right">
																					<?php if ($id == $cv['writer']) { ?>
																						<img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer" border="0" onclick="javascript:delete_comment('<?php echo $cv['seq'] ?>');return false;" />
																					<?php } ?>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td style="padding-left:40px;height:30px;border: thin solid #DFDFDF;border-top:none;">
																		<?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($cv['contents']))) ?>
																	</td>
																</tr>
												<?php } ?>
																<tr>
																	<td>
																		<table width="100%" border="0" cellspacing="0" cellpadding="5" style='border: thin solid #DFDFDF;'>
																			<tr height="30px" class="row-color1">
																				<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
																					<?php echo $name;?>
																				</td>
																				<td width="100px" class="tbl-mid" style="border-right: thin solid #DFDFDF;">
																					<?php echo date("Y-m-d");?>
																				</td>
																				<td align="right"></td>
																			</tr>
																			<tr>
																				<td class="answer2" colspan="3" align="center">
																					<textarea name="comment" id="comment" rows="5" class="input_answer1" style="width:100%;border-color:#DFDFDF"></textarea>
																				</td>
																			</tr>
																		</table>
																		<div style="width:100%;">
																			<input type="button" class="btn-common btn-style2" value="답변등록" onclick="javascript:insert_comment();return false;" style="float:right;margin-bottom:50px;width:90px;margin-top:20px;">
																		</div>
																	</td>
																</tr>
		          					</table>
		          				</td>
		      					</tr>
										<tr class="comment_tr">
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:30px;border:none;">
												</table>
											</td>
										</tr>
		   						</table>
		  					</td>
							</tr>
					</tr>
					</form>
				</table>
			</div>
		</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">
	$('input[name=vote_yn]').on('change', function() {
		var val = $('input[name=vote_yn]:checked').val();
		if(val == 'Y') {
			$('.vote_tr').show();
			$(this).closest('td').attr('colspan', '1');
			$(this).closest('td').removeClass('border-r');
		} else {
			$('.vote_tr').hide();
			$(this).closest('td').attr('colspan', '3');
			$(this).closest('td').addClass('border-r');
		}
	})

	$(function() {
		$('input[name=vote_yn]').change();
		numbering();
		progressing();
	})

	function numbering() {
		var num = 1;
		$('.num').each(function() {
			$(this).text(num);
			num ++;
		})
	}

	function delete_board() {
		if(confirm('게시글을 삭제 하시겠습니까?')) {
			var rform = document.rform;
			rform.action = "<?php echo site_url(); ?>/biz/dev_request/dev_delete_action";
			rform.submit();
			return false;
		}
	}

	function modify_board() {
		var rform = document.rform;
		rform.action = "<?php echo site_url(); ?>/biz/dev_request/dev_request_modify?seq=<?php echo $view_val['seq']; ?>";
		rform.submit();
		return false;
	}

	function go_list() {
		var rform = document.rform;
		rform.action = "<?php echo site_url(); ?>/biz/dev_request/dev_request_list";
		rform.submit();
		return false;
	}

	function insert_comment() {
		var rform = document.rform;

		if(rform.comment.value == '') {
			rform.comment.focus();
			alert('답변을 등록해 주세요.');
			return false;
		}

		rform.action = "<?php echo site_url(); ?>/biz/dev_request/insert_comment";
		rform.submit();
		return false;
	}

	function delete_comment(seq) {
		if(confirm('정말 삭제하시겠습니까?') == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/biz/dev_request/delete_comment";
			rform.submit();
			return false;
		}
	}

</script>
</html>

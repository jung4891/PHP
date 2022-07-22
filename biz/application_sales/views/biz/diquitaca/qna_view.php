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
.ui-corner-all{ background-color: #F8F9FB; border:none; border-radius: 3px;}
.num {padding-left:4px;padding-right:4px;width: 30px;height: 25px;margin-left: 3px;text-align: center;font-size: 14px;color: #ccc;vertical-align: middle;}
/* .item{position: relative;min-height: 25px;border: 1px solid #ebecef;border-radius: 2px;} */
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
.tbl_1 {text-align: center;margin-top:20px;border:thin solid #FAFAFA; border-radius: 3px;background-color:#FAFAFA;}
.tbl_1 tr:first-child td {color:#626262;padding-top:20px;}
.tbl_1 tr:last-child td {padding-bottom:10px;padding-top:5px;font-weight: bold;vertical-align: top;font-size: 14px;color:#1C1C1C}
.tbl_1 tr td:not(last-child) {border-right: thin solid #DFDFDF;}
.vote_content_list {border:thin solid #DFDFDF;border-radius:3px;padding:10px;width:97%;margin-top:10px;}
.vote_content_list td {vertical-align: top;}
.num {color:#1C1C1C;background-color: #E5E5E5;border-radius: 5px;width:5px;font-size: 12px;}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
	$my_vote = $my_vote['my_vote_seq'];
	$my_vote_seq_arr = explode(',', $my_vote);
	$my_vote_seq_arr = array_filter($my_vote_seq_arr);
?>
	<div align="center">
		<div class="dash1-1">
			<table width="60%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
					<form name="rform" method="post">
					<input type="hidden" name="seq" value="<?php echo $seq; ?>">
					<input type="hidden" name="cseq" value="">
					<input type="hidden" name="vseq" value="">
					<input type="hidden" id="type" name="type" value="1" />
					<tr>
	  				<td class="dash_title">
							디키타카
							<div style="float:right;">
								<input style="" type="button" class="btn-common btn-color1" value="목록" onClick="go_list();">
								<?php if($id == $qna_val['insert_id']) { ?>
									<input style="margin-right:10px;" type="button" class="btn-common btn-color2" value="수정" onClick="javascript:modify_board('<?php echo $seq; ?>');return false;">
									<input type="button" class="btn-common btn-color2" value="삭제" onClick="javascript:delete_board('<?php echo $seq; ?>');return false;">
								<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<table class="tbl_1" border="0" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed">
								<tr>
									<td>등록자</td>
									<td>등록일</td>
									<?php if ($qna_val['category'] == '1') { ?>
										<td>마감일</td>
										<td>직원수</td>
										<td>현재 투표현황</td>
									<?php } ?>
									<td>현재 답변현황</td>
									<td>조회수</td>
								</tr>
								<tr>
									<td><?php echo $qna_val['user_name']; ?></td>
									<td><?php echo date("Y-m-d", strtotime($qna_val['insert_date']));?></td>
									<?php if ($qna_val['category'] == '1'){ ?>
									<td style="color:#E53737"><?php if($qna_val['vote_deadline'] != '' || $qna_val['vote_yn'] == 'Y'){ echo date('Y-m-d', strtotime($qna_val['vote_deadline'])).'<br>'.date('H:i', strtotime($qna_val['vote_deadline']));}else {echo '-';} ?></td>
									<td><?php echo $user_count['cnt']; ?></td>
									<td style="color:#0575E6"><?php echo count($vote_list); ?></td>
									<?php } ?>
									<td style="color:#0575E6"><?php echo count($clist_val); ?></td>
									<td><?php echo $qna_val['read_cnt'] ?></td>
									<!-- <?php if($item['read_cnt']==''){?>
													<td align="center">0</td>
									<?php } else {?>
													<td align="center" style="cursor:pointer;" onclick="view_reader('<?php echo $item['seq']; ?>');"><?php echo $item['read_cnt']; ?></td>
									<?php } ?> -->
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
								<colgroup>
									<col width="10%">
									<col width="90%">
								</colgroup>
								<tr>
									<td height="50" align="left" style="padding-left:20px;color:#626262;background-color:#FAFAFA;border-right:thin solid #DFDFDF">카테고리</td>
									<td style="padding-left:10px;color:#1C1C1C"><?php echo $qna_val['category_name']; ?></td>
								</tr>
								<tr>
									<td height="50" align="left" style="padding-left:20px;color:#626262;background-color:#FAFAFA;border-right:thin solid #DFDFDF">제목</td>
									<td style="padding-left:10px;color:#1C1C1C"><?php echo stripslashes($qna_val['title']); ?></td>
								</tr>
								<tr>
									<td height="50" align="left" style="padding-left:20px;color:#626262;background-color:#FAFAFA;border-right:thin solid #DFDFDF">내용</td>
									<td style="padding-left:10px;color:#1C1C1C"><?php echo $qna_val['contents']; ?></td>
								</tr>
								<tr>
									<td height="50" align="left" style="padding-left:20px;color:#626262;background-color:#FAFAFA;border-right:thin solid #DFDFDF">파일</td>
									<td style="padding-left:10px;color:#1C1C1C;">
										<?php
											if($qna_val['file_realname'] != ""){
												 $file = explode('*/*',$qna_val['file_realname']);
												 $file_url = explode('*/*',$qna_val['file_changename']);
												 for($i=0; $i<count($file); $i++){
													 echo "<p>";
														echo $file[$i];
														$href = "{$misc}upload/biz/diquitaca/{$file_url[$i]}"; ?>
												<span style="float:right;margin-right:10px;border: 1px solid #D1D1D1;border-radius: 3px;padding:2px;font-weight:bold;" class="down_btn">
													<a href="<?php echo $href; ?>" download="<?php echo $file[$i]; ?>">
														<img src="/misc/img/download_btn.svg" width="12px;" style="margin-right:2px;">
														다운로드
													</a>
												</span></p>
									<?php }
											}
									 ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>


					<tr>
	  				<td align="center" valign="top">
	  					<table width="100%" height="100%" cellspacing="0" cellpadding="0" >
					<?php if($qna_val['vote_yn'] == 'Y') { ?>
									<tr class="vote_tr">
										<td>
											<table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
												<colgroup>
													<col width="40%">
													<col width="60%">
													<col width="10%">
												</colgroup>
												<tr>
													<td colspan="4" class="dash_title" style="padding-top:20px;padding-bottom:5px;border-bottom:none;">
														<div class="cnt_title">
															<span>투표현황</span>
														</div>
													</td>
												</tr>
												<tr class="vote_toggle_tr">
													<td colspan="4" style="font-weight:bold;height:10px;padding-bottom:20px;border:none;color:#3C3C3C">
														<?php echo $vote_val['title']; ?>
													</td>
												</tr>
												<tr style="display:none;">
													<td>
														<input type="radio" name="vote_yn" value="Y" <?php if($qna_val['vote_yn'] == 'Y'){echo 'checked';} else {echo "disabled";} ?>>예
														<input type="radio" name="vote_yn" value="N" <?php if($qna_val['vote_yn'] == 'N'){echo 'checked';} else {echo "disabled";} ?>>아니요
														<select class="select-common" name="result_check" style="width:130px;" disabled>
															<option value="1" <?php if($vote_val['result_check'] == "1") {echo 'selected';} ?>>투표 참여 후 보기</option>
															<option value="2" <?php if($vote_val['result_check'] == "2") {echo 'selected';} ?>>투표 종료 후 보기</option>
															<option value="3" <?php if($vote_val['result_check'] == "3") {echo 'selected';} ?>>항상 보기</option>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="4" style="border-bottom:none;">
														<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:thin solid #DFDFDF;border-bottom:none;">
															<colgroup>
																<col width="35%">
																<col width="55%">
																<col width="30%">
																<col width="40%">
															</colgroup>
											<?php if(!empty($vote_content)) {
															foreach($vote_content as $vcl) { ?>
																<tr>
																	<td style="border-right:thin solid #DFDFDF;">
																		<span class="num" style="background-color:#484848;color:#FFFFFF;">1</span>
																		<span style="font-weight:bold;font-size:14px;margin-left:5px;"><?php echo $vcl['content']; ?></span>
																	</td>
																	<td style="border-right:thin solid #DFDFDF;padding:0px 10px" seq="<?php echo $vcl['seq']; ?>">
																		<div class="bardivs" <?php if($vote_val['anonymous'] == "N") {echo "style='cursor:pointer;' onclick='view_voter(this);'";} ?>>
																			<div class="progressbar"  id="progressbar_<?php echo $vcl['seq']; ?>"></div>
																			<div class="progresstext" id="progresstext_<?php echo $vcl['seq']; ?>"></div>
																		</div>
																	</td>
																	<td align="center" style="border-right:thin solid #DFDFDF;padding:0px 10px'">
																		<span style="font-size:15px;font-weight:bold;" class="vote_cnt_span" id="vote_cnt_<?php echo $vcl['seq']; ?>"></span>
																		<span class="vote_cnt_span2"></span>
																	</td>
																	<!-- 투표현황 -->
																	<td>
																		<td style="border:none;border-bottom:thin solid #DFDFDF">
															<?php if(in_array($vcl['seq'], $my_vote_seq_arr)) {
																			$voted = true;
																		} else {
																			$voted = false;
																		}
																		$my_vote_cnt = count($my_vote_seq_arr);
																		$multi_choice = $vote_val['multi_choice']; ?>
																			<input type="button" class="btn-common btn-color4" style="width: 45px;border:1px solid #B6B6B6;margin:10px;border:none;<?php if(!$voted){echo 'display:none';} ?>" value="취소" onclick="vote('cancel', '<?php echo $vcl['seq']; ?>');">
																			<input type="button" class="btn-common btn-style2 vote_btn" value="선택" onclick="vote('select', '<?php echo $vcl['seq']; ?>');" style=" width: 50px;margin:10px;<?php if(($voted) || ($my_vote_cnt > 0 && $multi_choice=='N')){echo 'display:none';} ?>">
																		</td>
																	</td>
																</tr>
												<?php } ?>
											<?php } ?>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
					<?php } ?>
									<tr class="comment_tr">
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:30px;border:none;">
												<tr>
													<td colspan="2" class="dash_title" style="height:50px;padding-top:20px;padding-bottom:5px;border-bottom:none;">
														<div class="cnt_title">
															<span>답변</span>
														</div>
														<input type="button" class="btn-common btn-color2" value="답변등록" onclick="javascript:insert_comment();return false;" style="float:right;margin-bottom:20px;width:90px;margin-top:20px;">
													</td>
												</tr>
												<tr>
													<td>
														<table width="100%" border="0" cellspacing="0" cellpadding="5" style='border-top: thin solid #DFDFDF;<?php if(count($clist_val)==0){echo "border-bottom: thin solid #DFDFDF;";} ?>'>
															<tr height="30px">
																<td width="10%" align="left" style="padding-left:20px;background-color:#FAFAFA;height:40px;">
																	답변
																</td>
																<td class="answer2" colspan="3" align="center">
																	<textarea name="comment" id="comment" rows="1" class="input_answer1" placeholder="답변내용을 입력하세요." style="width:100%;border-color:#DFDFDF;border-radius:3px;padding-left:10px;box-sizing:border-box;"></textarea>
																</td>
															</tr>
														</table>
													</td>
												</tr>
								<?php foreach($clist_val as $cv) { ?>
												<tr>
													<td bgcolor="f8f8f9">
														<table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-top:thin solid #DFDFDF;">
															<tr height="30px">
																<td width="10%" align="left" style="padding-left:20px;background-color:#FAFAFA;border-bottom: thin solid #DFDFDF;">
																	<?php echo $cv['user_name'].'<br>'.date('Y-m-d', strtotime($cv['insert_date'])); ?>
																</td>
																<td style="padding-left:10px;height:30px;background-color:white;border-bottom: thin solid #DFDFDF;">
																	<?php echo nl2br(str_replace(" ", "&nbsp;", htmlspecialchars($cv['contents']))) ?>
																	<?php if ($id == $cv['user_id']) { ?>
																		<img src="<?php echo $misc; ?>img/btn_del.jpg" width="18" height="17" style="cursor:pointer;float:right;margin-right:10px;" border="0" onclick="javascript:delete_comment('<?php echo $cv['seq'] ?>');return false;" />
																	<?php } ?>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>

												</tr>
								<?php } ?>
											</table>
										</td>
									</tr>
	   						</table>
	  					</td>
						</tr>
					</form>
				</table>
			</div>
		</div>
		<div id="voter_popup" name="duple_sch_popup" class="layerpop" style="display:none; width:450px; height:auto;padding:20px;border-radius:3px;">
		  <article class="layerpop_area" align="center">
		  <div align="left" class="tbl-sub-title">투표자 목록</div>

		  <table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center">
				<colgroup>
					<col width="20%">
					<col width="40%">
					<col width="40%">
				</colgroup>
				<tr class="tbl-tr cell-tr border-t">
					<th style="height:35px;" class="tbl-title">번호</th>
					<th style="height:35px;" class="tbl-title">투표자</th>
					<th style="height:35px;" class="tbl-title">투표시간</th>
				</tr>
				<tbody id="voter_list">

				</tbody>
		  </table>
		  <div align="right" style="margin-top: 10px;">
		    <button type="button" class="basicBtn btn-color4" onclick="$('#voter_popup').bPopup().close();" style="width:65px;">닫기</button>
		  </div>
		  </article>
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
		var num_color = ['#9B97FA', '#FFD056', '#FE8C7D', '#5FE3A1', '#54D8FD'];
		var progress_color2 = ['#ECEBFF', '#FFF6DF', '#FFEBE8', '#E1FFF0', '#D9F7FF'];

		var num = 1;
		var i = 1;
		$('.num').each(function() {
			var tbl = $(this).closest('table');
			if(num < 10) {
				$(this).text('0' + num);
			} else {
				$(this).text(num);
			}

			num ++;
			i++;
		})
	}

	function vote_toggle(mode) {
		if(mode == 'up') {
			$('#vote_btn_up, .vote_toggle_tr').hide();
			$('#vote_btn_down').show();
		} else {
			$('#vote_btn_down').hide();
			$('#vote_btn_up, .vote_toggle_tr').show();
		}
	}

	function insert_comment() {
		var rform = document.rform;

		if(rform.comment.value == '') {
			rform.comment.focus();
			alert('답변을 등록해 주세요.');
			return false;
		}

		rform.action = "<?php echo site_url(); ?>/biz/diquitaca/insert_qna_comment";
		rform.submit();
		return false;
	}

	function delete_comment(seq) {
		if(confirm('정말 삭제하시겠습니까?') == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/biz/diquitaca/delete_qna_comment";
			rform.submit();
			return false;
		}
	}

	function vote(mode, vseq) {
		if(mode == 'select') {
			if(confirm('투표하시겠습니까?')) {
				var rform = document.rform;
				rform.vseq.value = vseq;
				rform.action = "<?php echo site_url(); ?>/biz/diquitaca/select_vote";
				rform.submit();
				return false;
			}
		} else if (mode == 'cancel') {
			if(confirm('투표를 취소하시겠습니까?')) {
				var rform = document.rform;
				rform.vseq.value = vseq;
				rform.action = "<?php echo site_url(); ?>/biz/diquitaca/cancel_vote";
				rform.submit();
				return false;
			}
		}
	}

	function progressing() {
		var val = $('input[name=vote_yn]').val();
		if(val == 'Y') {
			var my_vote_cnt = '<?php if(isset($my_vote_cnt)){echo $my_vote_cnt;}else{echo 0;} ?>';
			var result_check = $('select[name=result_check]').val();
			var deadline = new Date('<?php echo date('Y-m-d H:i', strtotime($qna_val['vote_deadline'])); ?>');
			var now = new Date();

			if(deadline < now) {
				$('.vote_btn').hide();
			}

			if( (result_check == 1 && my_vote_cnt > 0) || (result_check == 2 && deadline < now) || result_check == 3 || deadline < now) {
				var user_cnt = "<?php echo $user_count['cnt']; ?>";

				$.ajax({
					url: "<?php echo site_url(); ?>/biz/diquitaca/vote_progress",
					type: "POST",
					dataType: "json",
					data: {
						seq: '<?php echo $seq; ?>'
					},
					cache: false,
					async: false,
					success: function(data) {
						if(data) {
							var max_vote = 0;
							for(i = 0; i < data.length; i++) {
								if(data[i].vote_cnt > max_vote) {
									max_vote = data[i].vote_cnt;
								}
							}

							for(i = 0; i < data.length; i++) {
								var vote_cnt = data[i].vote_cnt;
								if(vote_cnt == null) {
									vote_cnt = 0;
								}
								var percentage = (vote_cnt/user_cnt) * 100;
								$('#progressbar_'+data[i].seq).progressbar({value: percentage});
								$('#vote_cnt_'+data[i].seq).text(vote_cnt);
								var tr = $('#progressbar_'+data[i].seq).closest('tr');
								if(vote_cnt == max_vote) {
									tr.find('.ui-progressbar-value').css('background-color', '#1A65BA');
								} else {
									tr.find('.ui-progressbar-value').css('background-color', '#B4DAEC');
								}
								var num = Number(tr.find('.num').text()) - 1;
								tr.find('.vote_cnt_span2').text('명').css('color', '#626262');
							}
						}
					}
				});
			}
		}
	}

	function view_voter(el) {
		var content_seq = $(el).closest('td').attr('seq');
		console.log(content_seq);

		$.ajax({
			type: 'POST',
			url: "<?php echo site_url(); ?>/biz/diquitaca/voter_list",
			dataType: "json",
			data: {
				content_seq: content_seq
			},
			success: function(data) {
				var list = '';
				if(data) {
					var j = data.length;
					for(i = 0; i<data.length; i++) {
						list += '<tr class="cell-tr" style="height:40px;">';
						list += '<td>'+j+'</td>';
						list += '<td>'+data[i].user_name + ' ' + data[i].user_duty +'</td>';
						list += '<td>'+data[i].insert_time+'</td>';
						list += '</tr>';
						j --;
					}
				} else {
					list += '<tr class="cell-tr" style="height:40px;">';
					list += '<td colspan="3" align="center">-</td>';
					list += '</tr>';
				}
				$('#voter_list').html(list);
			}
		})
		$('#voter_popup').bPopup();
	}

	function delete_board(seq) {
		if(confirm('게시글을 삭제 하시겠습니까?')) {
			var rform = document.rform;
			rform.action = "<?php echo site_url(); ?>/biz/diquitaca/qna_delete_action";
			rform.submit();
			return false;
		}
	}

	function modify_board(seq) {
		var rform = document.rform;
		rform.action = "<?php echo site_url(); ?>/biz/diquitaca/qna_modify";
		rform.submit();
		return false;
	}

	function go_list() {
		location.href = "<?php echo site_url(); ?>/biz/diquitaca/qna_list";
	}
</script>
</html>

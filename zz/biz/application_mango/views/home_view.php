<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<link rel="stylesheet" href="/misc/css_mango/dashboard_mango.css">
<link rel="stylesheet" href="/misc/css/simple-calendar.css">
<script type="text/javascript" src="/misc/js/jquery.simple-calendar_mango.js"></script>
<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
<style media="screen">
	.calendar .day.has-event:after {
		background: #FA4C06 !important;
	}
	.calendar .day.selected {
		border-color: #FA4C06 !important;
	}
	.calendar .day:hover {
		border: 2px solid #FA4C06 !important;
	}
	.calendar .day.today {
		background-color: #FA4C06 !important;
		border-radius: 8px !important;
	}
</style>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<div align="center" class="dash_container">

  <div class="top_wrap">
    <div class="dash1_wrap">
        <table class="dash_tbl dash_tbl_1" border="0" cellpadding="0" cellspacing="0" style="text-align:center;color:#4B4B4B">
          <colgroup>
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
          </colgroup>
          <tr><td colspan="5" style="height:30px"></td></tr>
          <tr>
            <td>
			<?php if($this->admin == 'Y'){echo '관리자';}else {echo '근무자';} ?>
						</td>
            <td>전체 근무자</td>
            <td>예정 근무 일정</td>
            <td>자동 근무 일정</td>
            <td>확정 근무 일정</td>
          </tr>
					<tr class="dash1_bold">
						<td style="color:#FA4C06;"><?php echo $this->name; ?></td>
						<td><?php echo count($user_data); ?></td>
						<td><?php echo $schedule_count['scheduled_cnt']; ?></td>
						<td><?php echo $schedule_count['actual_cnt']; ?></td>
						<td><?php echo $schedule_count['confirmation_cnt']; ?></td>
					</tr>
          <tr><td colspan="5" style="height:30px"></td></tr>
        </table>
      </div>
    </div>

    <div class="bottom_wrap">
      <div class="dash2_wrap dash2-1_wrap">
        <table class="dash_tbl">
					<tr valign="top">
						<td class="dash_title_td" style="padding-top:1px;height:50px;">
							<div class="dash_title">
								일정
							</div>
						</td>
						<td align="right" style="padding-right:10px; padding-top:15px;height:50px;">
							<input type="button" class="btn-common btn-goBoard" value="→" onclick="go_Board('schedule')">
						</td>
					</tr>
					<tr>
						<td colspan="3" valign="top" style="padding:0 20px;">
							<table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;">
								<tr>
									<td>
										<div id="calendar"></div>
									</td>
								</tr>
								<tr>
									<td>
										<input type="checkbox" name="scheduled" onclick="change_schedule_type();" checked>
										예정
										<input type="checkbox" name="actual" onclick="change_schedule_type();" checked>
										자동
										<input type="checkbox" name="confirmation" onclick="change_schedule_type();" checked>
										확정
									</td>
								</tr>
								<tr>
									<td>
										<div id="date"></div>
									</td>
								</tr>
								<tr>
									<td>
										<div id="schedule_list" style="max-height: 200px;overflow-y: auto"></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
        </table>
      </div>

      <div class="dash2_wrap dash2-2_wrap">
        <div class="dash2-2_top">
					<table class="dash_tbl dash_tbl_s" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td class="dash_title_td" style="padding-top:1px;height:50px;">
                <div class="dash_title">
                  회원관리
                </div>
              </td>
							<td align="right" style="width:40px">
	              <div style="padding-top:6px;padding-right: 5px;">
	                <img style="cursor:pointer;margin-top:10px;" onclick="prev_address();" src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="25" />
	              </div>
	            </td>
	            <td align="right" style="width:40px;">
	              <div style="padding-top:6px;padding-right: 10px;">
	                <img style="cursor:pointer;margin-top:10px;" onclick="next_address();" src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="25"/>
	              </div>
	            </td>
							<td align="right" style="padding-right:10px; padding-top:15px;height:50px;width:30px;">
								<input type="button" class="btn-common btn-goBoard" value="→" onclick="go_Board('user')">
              </td>
            </tr>

					<?php
					$j = 0;
					for($i = 0; $i < count($user_data); $i = $i + 5) { ?>
						<tr>
							<td colspan="4" valign="top" style="padding:0 20px;">
								<table id="user_tbl-<?php echo $j + 1; ?>" class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;<?php if($j>0){echo 'display:none;';} ?>">
                  <colgroup>
										<col width="12%">
										<col width="58%">
										<col width="15%">
										<col width="15%">
                  </colgroup>
									<tr>
										<td class="board_title"></td>
	                  <td class="board_title" align="left" height="30" style="margin-left:10px;">아이디</td>
	                  <td class="board_title" align="" style="" >이름</td>
	                  <td class="board_title" align="">승인여부</td>
                  </tr>
					<?php for($k = 0; $k < 5; $k++) { ?>
									<tr style="height:30px;">
										<td style="border:none;">
							<?php if(isset($user_data[$i+$k])){ ?>
											<img src="/misc/img_mango/user_icon.svg" style="width:30px;">
							<?php } ?>
										</td>
										<td style="border:none;">
											<div class="overflow">
									<?php if(isset($user_data[$i+$k])){echo stripslashes($user_data[$i+$k]['user_id']);} ?>
											</div>
										</td>
										<td style="border:none;">
									<?php if(isset($user_data[$i+$k])){echo stripslashes($user_data[$i+$k]['user_name']);} ?>
										</td>
										<td style="border:none;">
						<?php if(isset($user_data[$i+$k])){
										if($user_data[$i+$k]['confirm_flag'] == 'Y') { ?>
											<span style="color:#0575E6;">승인</span>
							<?php } else { ?>
											<span style="color:#FA4C06;">미승인</span>
							<?php }
									} ?>
										</td>
									</tr>
					<?php } ?>
                </table>
							</td>
						</tr>
		<?php $j++; ?>
		<?php }	?>


          </table>
        </div>
        <div class="dash2-2_bottom">
          <table class="dash_tbl dash_tbl_s" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td class="dash_title_td" style="padding-top:1px;height:50px;">
                <div class="dash_title">
                  건강검진 관리대장
                </div>
              </td>
							<td align="right" style="padding-right:10px; padding-top:15px;height:50px;">
								<input type="button" class="btn-common btn-goBoard" value="→" onclick="go_Board('health_certificate')">
              </td>
            </tr>
            <tr>
              <td colspan="3" valign="top" style="padding:0 20px;">
                <!-- 내용 table -->
                <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;">
                  <colgroup>
                    <col width="70%">
                    <col width="15%">
                    <col width="15%">
                  </colgroup>
                  <tr>
                   <td class="board_title" align="left" height="30" style="margin-left:10px;">제목</td>
                   <td class="board_title" align="" style="" >등록자</td>
                   <td class="board_title" align="">날짜</td>
                  </tr>
                  <?php
                    if(!empty($health_certificate)) {
                      foreach ($health_certificate as $item ) { ?>
                        <tr onclick="JavaScript:viewBoard('health_certificate', '<?php echo $item['seq'];?>')" style="cursor:pointer;height:30px;">
                          <td>
                            <div class="overflow">
                            <?php echo '건강검진(보건증) 관리대장_'.$item['year'].'년 '.$item['month'].'월';?>
                            </div>
                          </td>
                          <td><?php echo $item['user_name']; ?></td>
                          <td style="color:#A6A6A6;"><?php echo substr($item['write_date'], 0, 10);?></td>
                        </tr>
                    <?php }
                  } else { ?>
                       <tr>
                         <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
                       </tr>
               <?php } ?>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="dash2_wrap dash2-2_wrap">
        <div class="dash2-2_top">
          <table class="dash_tbl dash_tbl_s" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td class="dash_title_td" style="padding-top:1px;height:50px;">
                <div class="dash_title">
                  내부서류
                </div>
              </td>
							<td align="right" style="padding-right:10px; padding-top:15px;height:50px;">
								<input type="button" class="btn-common btn-goBoard" value="→" onclick="go_Board('document')">
              </td>
            </tr>
            <tr>
              <td colspan="3" valign="top" style="padding:0 20px;">
                <!-- 내용 table -->
                <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;">
                  <colgroup>
										<col width="70%">
										<col width="15%">
										<col width="15%">
                  </colgroup>
                  <tr>
                   <td class="board_title" align="left" height="30" style="margin-left:10px;">서류명</td>
                   <td class="board_title" align="" style="" >기안자</td>
                   <td class="board_title" align="">기안일</td>
                  </tr>
                  <?php
                    if(!empty($document_basic)) {
                      foreach ($document_basic as $item ) { ?>
                        <tr onclick="JavaScript:viewBoard('document', '<?php echo $item['seq'];?>')" style="cursor:pointer;height:30px;">
                          <td>
                            <div class="overflow">
                            <?php echo stripslashes($item['document_name']); ?>
                            </div>
                          </td>
                          <td><?php echo $item['user_name']; ?></td>
                          <td style="color:#A6A6A6;"><?php echo substr($item['update_date'], 0, 10);?></td>
                        </tr>
                    <?php }
                  } else { ?>
                       <tr>
                         <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
                       </tr>
               <?php } ?>
                </table>
              </td>
            </tr>
          </table>
        </div>
        <div class="dash2-2_bottom">
          <table class="dash_tbl dash_tbl_s" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td class="dash_title_td" style="padding-top:1px;height:50px;">
                <div class="dash_title">
                  공지사항
                </div>
              </td>
							<td align="right" style="padding-right:10px; padding-top:15px;height:50px;">
								<input type="button" class="btn-common btn-goBoard" value="→" onclick="go_Board('notice')">
              </td>
            </tr>
            <tr>
              <td colspan="3" valign="top" style="padding:0 20px;">
                <!-- 내용 table -->
                <table class="content_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;">
                  <colgroup>
										<col width="70%">
										<col width="15%">
										<col width="15%">
                  </colgroup>
                  <tr>
                   <td class="board_title" align="left" height="30" style="margin-left:10px;">제목</td>
                   <td class="board_title" align="" style="" >등록자</td>
                   <td class="board_title" align="">날짜</td>
                  </tr>
                  <?php
                    if(!empty($notice_basic)) {
                      foreach ($notice_basic as $item ) { ?>
                        <tr onclick="JavaScript:viewBoard('notice', '<?php echo $item['seq'];?>')" style="cursor:pointer;height:30px;">
                          <td>
                            <div class="overflow">
                            <?php echo stripslashes($item['subject']); ?>
                            </div>
                          </td>
                          <td><?php echo $item['user_name']; ?></td>
                          <td style="color:#A6A6A6;"><?php echo substr($item['update_date'], 0, 10);?></td>
                        </tr>
                    <?php }
                  } else { ?>
                       <tr>
                         <td width="100%" height="80" align="center" colspan="9" class="no_list">등록된 게시물이 없습니다.</td>
                       </tr>
               <?php } ?>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

  </div>

<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<script type="text/javascript">
	function go_Board(page) {
		if(page == 'document') {
			location.href = "<?php echo site_url(); ?>/document/document_list";
		} else if(page == 'health_certificate') {
			location.href = "<?php echo site_url(); ?>/health_certificate/doc_list";
		} else if(page == 'notice') {
			location.href = "<?php echo site_url(); ?>/board/notice_list";
		} else if(page == 'user') {
			location.href = "<?php echo site_url(); ?>/user/user_list";
		} else if(page == 'schedule') {
			location.href = "<?php echo site_url(); ?>/schedule/schedule_list";
		}
	}

	var first_user_data = 1;
	var last_user_data = "<?php echo ceil(count($user_data) / 5); ?>"

	function prev_address() {
		if(first_user_data != 1) {
			$('#user_tbl-' + (first_user_data) + '').hide();
			$('#user_tbl-' + (first_user_data - 1) + '').show();
			first_user_data--;
		}
	}

	function next_address() {
		if(first_user_data < last_user_data) {
			$('#user_tbl-' + (first_user_data) + '').hide();
			$('#user_tbl-' + (first_user_data + 1) + '').show();
			first_user_data++;
		}
	}

	$(function() {
		$("#calendar").simpleCalendar({
      fixedStartDay: 0, // begin weeks by sunday
      disableEmptyDetails: true,
      events: [
        // generate new event after tomorrow for one hour
        <?php
        foreach ($schedule as $v) {
					if($v['schedule_type'] == 'actual') {
						$type = '자동';
					} else if($v['schedule_type'] == 'scheduled') {
						$type = '예상';
					} else if($v['schedule_type'] == 'confirmation') {
						$type = '확정';
					}

          echo "{startDate:'".$v['start_day']."T".$v['start_time']."',";
          echo "endDate:'".$v['end_day']."T".$v['end_time']."',";
          echo "summary:'(".$type.")".$v['participant']." 근무'";
          echo "},";
        }
        ?>
      ],
      months : ['01','02','03','04','05','06','07','08','09','10','11','12'],
      days: ['일','월','화','수','목','금','토']
    });
	})

	function getParam(sname) {
		var params = location.search.substr(location.search.indexOf('?') + 1);
		var sval = '';
		params = params.split('&');
		for(var i = 0; i < params.length; i++) {
			temp = params[i].split('=');
			if([temp[0]] == sname) {
				sval = temp[1];
			}
		}
		return sval;
	}

	function getFormatDate(date) {
	  var year = date.getFullYear();
	  var month = (1 + date.getMonth());
	  month = month >= 10 ? month : '0' + month;
	  var day = date.getDate();
	  day = day >= 10 ? day : '0' + day;
	  return year + '-' + month + '-' + day;
	}

	function getToday() {
		var date = new Date();
		var year = date.getFullYear();
		var month = ('0' + (1 + date.getMonth())).slice(-2);
		var day = ('0' + date.getDate()).slice(-2);

		return year + '-' + month + '-' + day;
	}

	$(function() {
		refresh_sch(getToday());
	})

	function change_schedule_type() {
		var date = $('#calendar').find('.selected').attr('name');

		if(date == undefined) {
			date = getToday();
		} else {
			date = date.replace(/(\d{4})(\d{2})(\d{2})/g, '$1-$2-$3');
		}

		refresh_sch(date);
	}

	function refresh_sch(date) {
		var schedule_type = [];

		if($('input:checkbox[name="scheduled"]').is(':checked')) {
			schedule_type.push('scheduled');
		}
		if ($('input:checkbox[name="actual"]').is(':checked')) {
			schedule_type.push('actual');
		}
		if ($('input:checkbox[name="confirmation"]').is(':checked')) {
			schedule_type.push('confirmation');
		}

    $.ajax({
      type: "POST",
      dataType: 'json',
      url: '/index.php/account/schedule_list',
      data: {
        date: date,
				schedule_type: schedule_type
      },
      success: function (data) {
				console.log(data);
        date = date.split('-');
        date = date[0] + '년 ' + date[1] + '월 ' + date[2] + '일';
				var text = '';
				if(data) {
					for(i=0; i<data.length; i++) {
						if(data[i].start_time != null && data[i].end_time != null) {
							var participant = data[i].participant;
							var schedule_type = data[i].schedule_type;
							if(schedule_type == 'scheduled') {
								var sType = '(예정)';
								var sColor = 'background-color:#FFF6D5;';
							} else if (schedule_type == 'confirmation') {
								var sType = '(확정)';
								var sColor = 'background-color:#E4DCFF;';
							} else if (schedule_type == 'actual') {
								var sType = '(자동)';
								var sColor = 'background-color:#DCEFFF;';
							} else {
								var sType = '';
								var sColor = '';
							}
							var start_time = data[i].start_time;
							var end_time = data[i].end_time;
							start_time = start_time.substr(0, 5);
							end_time = end_time.substr(0, 5);

							text += '<div style="'+sColor+'" class="sch_list">'+sType+participant+' 근무 ('+start_time+"~"+end_time+')</div>';
						}
					}
				}

				$('#date').html(date);
        $('#schedule_list').html(text);
      }
    })
  }

	function viewBoard(loc, seq) {
		if(loc == 'health_certificate') {
			location.href = "<?php echo site_url(); ?>/health_certificate/doc_view?mode=view&seq=" + seq;
		} else if (loc == 'document') {
			location.href = "<?php echo site_url(); ?>/document/document_view?mode=view&seq=" + seq;
		} else if (loc == 'notice') {
			location.href = "<?php echo site_url(); ?>/board/notice_view?mode=view&seq=" + seq;
		}
	}
</script>
</html>

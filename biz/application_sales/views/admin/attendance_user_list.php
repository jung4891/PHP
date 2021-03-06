<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center">
	<div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%;">
			<tbody>
				<tr height="5%">
          <td class="dash_title">
            근태관리
          </td>
        </tr>
				<tr>
					<td height="70"></td>
				</tr>
				<!-- <tr height="13%">
        </tr> -->
				<tr style="max-height:45%">
					<td colspan="2" valign="top" style="padding:10px 0px;">
						<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<table width="100%" class="month_tbl" height="100%" border="0" cellspacing="0" cellpadding="0">
										<form name="mform" action="<?php echo site_url();?>/admin/attendance_admin/attendance_user_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
										<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
										<input type="hidden" name="seq" value="">
										<input type="hidden" name="mode" value="">
				            <!--내용-->
			             <!--리스트-->
		                  <colgroup>
												<col width="15%" />
						            <col width="12%" />
		                    <col width="12%" />
		                    <col width="22%" />
		                    <col width="12%" />
		                    <col width="12%" />
		                    <col width="15%" />
		                  </colgroup>
		                  <tr class="t_top row-color1">
												<th></th>
						    				<th height="40" align="center">번호</th>
		                    <th align="center">이름</th>
		                    <th align="center">카드 번호</th>
		                    <th align="center">출근시간</th>
		                    <th align="center">퇴근시간</th>
												<th></th>
		                  </tr>
								<?php
									if ($count > 0) {
										$i = $count - $no_page_list * ( $cur_page - 1 );
										$icounter = 0;

										foreach ( $list_val as $item ) {
								?>
		                  <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="input_attendance('<?php echo $item['seq'];?>')">
												<td></td>
		                    <td height="40" align="center"><?php echo $i;?></td>
		                    <td align="center"><?php echo $item['user_name'];?></td>
		                    <td align="center"><?php
                        if ($item['card_num']==''){
                          echo '미지정';
                        } else {
                          echo $item['card_num'];
                        }
                        ?></td>
                        <td align="center"><?php
                        if ($item['ws_time']==''){
                          echo '미지정';
                        } else {
                          echo substr($item['ws_time'], 0, 5);
                        }
                        ?></td>
                        <td align="center"><?php
                        if ($item['wc_time']==''){
                          echo '미지정';
                        } else {
                          echo substr($item['wc_time'], 0, 5);
                        }
                        ?></td>
												<td></td>
		                  </tr>
		            <?php
											$i--;
											$icounter++;
										}
									} else {
								?>
											<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
		                    <td width="100%" height="40" align="center" colspan="7">등록된 게시물이 없습니다.</td>
		                  </tr>
								<?php
									}
								?>
									              <!--//리스트-->
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
    </script>

									            <!--//내용-->
										</form>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!--페이징-->
				<tr>
					<td align="center">
<?php if ($count > 0) {?>
	<table width="400" border="0" cellspacing="0" cellpadding="0">
						<tr>
	<?php
		if ($cur_page > 10){
	?>
							<td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" /></a></td>
							<td width="2"></td>
							<td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" /></a></td>
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
					$strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
		<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg"/></a></td>
							<td width="2"></td>
							<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" /></a></td>
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
				<!--//페이징-->
				<?php if($admin_lv == "3") {?>
									<!-- <tr>
										<td height="10"></td>
									</tr> -->
									<!--버튼-->
									<!-- <tr>
										<td align="center"><img src="<?php echo $misc;?>img/dashboard/btn/btn_add.png" width="64" height="31" style="cursor:pointer"  onClick="$('#car_input').bPopup();" /></td>
									</tr> -->
									<!--//버튼-->
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->

<!-- 입력 모달 -->
<div id="attendance_input" style="display:none; position: absolute; background-color: white; width: 300px; height: 420px; border-radius:5px;">
	<form name="cform" action="<?php echo site_url();?>/admin/attendance_admin/attendance_input_action" method="post" onSubmit="javascript:chkForm();return false;">
		<table style="margin:10px 30px; border-collapse: separate; border-spacing: 0 30px;">
			<colgroup>
				<col width="30%">
				<col width="70%">
			</colgroup>
			<tr>
				<td colspan="2" class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
					근태정보
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">이름</td>
				<td align="left">
					<input type="text" class="input-common" name="type" id="user_name" value="" style="width:95%" readonly>
          <input type="hidden" name="user_seq" id="user_seq" value="">
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">카드번호</td>
				<td align="left">
          <select class="select-common" name="card_num" id="card_num" style="width:97%">
          </select>
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">출근시간</td>
				<td align="left">
					<input type="text" class="input-common" name="ws_time" id="ws_time" value="" style="width:95%" autocomplete="off">
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">퇴근시간</td>
				<td align="left">
					<input type="text" class="input-common" name="wc_time" id="wc_time" value="" style="width:95%" autocomplete="off">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="button" class="btn-common btn-color4" style="width:70px; margin-right:10px;" value="취소" onclick="$('#attendance_input').bPopup().close();">
					<input type="button" class="btn-common btn-color2" style="width:70px;" value="등록" onclick="javascript:chkForm();return false;">
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
<script type="text/javascript">

  $(function(){
    $('#ws_time, #wc_time').timepicker({
        minuteStep: 30,
        // template: 'modal',
        // appendWidgetTo: 'body',
        // showSeconds: true,
        showMeridian: false,
        // defaultTime: false
        // container:'#attendance_input'
    });
  })

  function input_attendance(seq){
    $.ajax({
      type:"POST",
      async:false,
      url:"/index.php/admin/attendance_admin/attendance_user_info",
      dataType:"json",
      data:{
        seq:seq
      },
      success: function(data) {
        var name = data[0].user_name;
        var card_num = data[0].card_num;
        $("#user_seq").val(data[0].seq);
        $("#user_name").val(name);
        $("#card_num").val(card_num);
        var ws_time = data[0].ws_time;
        var wc_time = data[0].wc_time;
        if (ws_time!=null){
          ws_time = ws_time.substring(0,5);
        } else {
          ws_time = "09:00";
        }
        if (wc_time!=null){
          wc_time = wc_time.substring(0,5);
        } else {
          wc_time = "18:00";
        }
        $("#ws_time").val(ws_time);
        $("#wc_time").val(wc_time);

        $.ajax({
          type:"POST",
          async:false,
          url:"/index.php/admin/attendance_admin/attendance_card_info",
          dataType:"json",
          data:{
            name:name
          },
          success: function (data){
            // console.log(data.length);
            var options = "<option selected disabled hidden>선택하세요</option>";
            for(var i=0;i<data.length;i++){
              // console.log(data[i].e_id);
              if (data[i].e_id==card_num){
                options+="<option value='"+data[i].e_id+"' selected>"+data[i].e_id+"</option>";
              } else {
                options+="<option value='"+data[i].e_id+"'>"+data[i].e_id+"</option>";
              }
            }
            // console.log(options);
            $("#card_num").html(options);
          }
        })

      }
    })

    $("#attendance_input").bPopup();
  }

  function chkForm () {
  	var mform = document.cform;

  	if (mform.card_num.value == "") {
  		mform.card_num.focus();
  		alert("카드번호를 입력해 주세요.");
  		return false;
  	}
  	if (mform.ws_time.value == "") {
  		mform.ws_time.focus();
  		alert("출근시간을 입력해 주세요.");
  		return false;
  	}
  	if (mform.wc_time.value == "") {
  		mform.wc_time.focus();
  		alert("퇴근시간을 입력해 주세요.");
  		return false;
  	}

  	mform.submit();
  	return false;
  }
</script>
</html>

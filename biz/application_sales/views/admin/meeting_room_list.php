<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%;">
		<form name="mform" action="<?php echo site_url();?>/admin/equipment/meeting_room_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
		<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
		<input type="hidden" name="seq" value="">
		<input type="hidden" name="mode" value="">
		<!-- 타이틀 부분 시작 -->
			<tr height="5%">
				<td class="dash_title">
					회의실관리
				</td>
			</tr>
			<tr>
				<td height="70"></td>
			</tr>
			<!-- 타이틀 부분 끝 -->
			<tr height="10%">
				<td align="right" valign="bottom">
					<?php
					if($admin_lv == "3") {
						?>
						<input class="btn-common btn-color2" type="button" onclick="$('#meeting_room_input').bPopup();" value="등록" >
						<?php
					}
					?>
				</td>
			</tr>
		  <tr height="45%">
		    <td valign="top" style="padding:15px 0px 15px 0px">
		    	<table class="content_dash_tbl list" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" valign="top">
	             <!--리스트-->
	              <tr>
	                <td>
										<table width="100%" class="month_tbl" border="0" cellspacing="0" cellpadding="0">
	                  <colgroup>
					            <col width="15%" />
					            <col width="10%" />
					            <col width="15%" />
	                    <col width="30%" />
	                    <col width="15%" />
	                    <col width="15%" />
	                  </colgroup>
	                  <tr class="t_top row-color1">
											<th></th>
					    				<th height="40" align="center">번호</th>
	                    <th height="40" align="center">회의실명</th>
	                    <th align="center">위치</th>
	                    <th align="center">등록일</th>
											<th></th>
	                  </tr>
<?php
	if ($count > 0) {
		$i = $count - $no_page_list * ( $cur_page - 1 );
		$icounter = 0;

		foreach ( $list_val as $item ) {
?>
	                  <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
											<td></td>
	                    <td height="40" align="center"><?php echo $i;?></td>
	                    <td align="center"><?php echo $item['room_name'];?></td>
	                    <td align="center"><?php echo $item['location'];?></td>
											<td align="center"><?php echo substr($item['insert_date'], 0, 10);?></td>
											<td></td>
	                  </tr>
 <?php
			$i--;
			$icounter++;
		}
	} else {
?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    	<td width="100%" height="40" align="center" colspan="4">등록된 게시물이 없습니다.</td>
                  	</tr>
                  	<tr>
                    	<td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  	</tr>
<?php
	}
?>
                	</table>
								</td>
            	</tr>
              <!--//리스트-->
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

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/admin/equipment/meeting_room_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
							</td>
						</tr>
					</table>
				</td>
			</tr>
<!-- 컨텐트 테이블 끝 -->
			<tr height="40%">
				<td align="left" valign="top">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="19%">
								<tr height="20%">
									<td align="center" valign="top">
<?php
	if ($count > 0) {
?>
										<table width="400" border="0" cellspacing="0" cellpadding="0">
                  		<tr>
<?php
		if ($cur_page > 10){
?>
		                    <td width="19">
													<a href="JavaScript:GoFirstPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/>
													</a>
												</td>
		                    <td width="2"></td>
		                    <td width="19">
													<a href="JavaScript:GoPrevPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/>
													</a>
												</td>
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
?>
												</td>
<?php
		if ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
												<td width="19">
													<a href="JavaScript:GoNextPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png"/>
													</a>
												</td>
		                    <td width="2"></td>
		                    <td width="19">
													<a href="JavaScript:GoLastPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" />
													</a>
												</td>
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
<?php
	}
?>
									</td>
		            </tr>
		              <!--//페이징-->
		            <!--//내용-->
							</td>
						</tr>


     				</table>
    			</td>
  			</tr>
			</form>
		</table>
	</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->


<!-- 제품 추가 모달 시작 -->
<div id="meeting_room_input" style="display:none; position: absolute; background-color: white; width: 400px; height: 290px; border-radius:5px;">
  <form name="cform" id="cform" action="<?php echo site_url();?>/admin/equipment/meeting_room_input_action" method="post" onSubmit="javascript:chkForm();return false;" enctype="multipart/form-data">
    <table style="margin:10px 30px; border-collapse: separate; border-spacing: 0;">
			<colgroup>
				<col width="30%">
				<col width="70%">
			</colgroup>
			<tr>
				<td height="20"></td>
			</tr>
      <tr>
        <td class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
					회의실
				</td>
      </tr>
			<tr>
				<td height="20"></td>
			</tr>
      <tr class="border-b tbl-tr">
				<td align="left" valign="center" style="font-weight:bold;height:50px;">회의실 명</td>
				<td align="left">
					<input type="text" id="room_name" name="room_name" value="" class="input-common">
				</td>
      </tr>
      <tr class="border-b tbl-tr">
        <td align="left" valign="center" style="font-weight:bold;height:50px;">위치</td>
        <td align="left">
          <input type="text" name="location" id="location" class="input-common">
        </td>
      </tr>
			<tr>
				<td height="20"></td>
			</tr>
      <tr>
				<td></td>
				<td align="right">
					<!--지원내용 추가 버튼-->
					<input type="button" class="btn-common btn-color1" style="width:70px; margin-right:10px;" value="취소" onclick="$('#meeting_room_input').bPopup().close()">
					<input type="button" class="btn-common btn-color2" style="width:70px;" value="등록" onclick="javascript:chkForm();return false;">
        </td>
      </tr>
    </table>
  </form>
</div>
<!-- 제품 추가 모달 끝  -->
</body>
<script type="text/javascript">
function chkForm () {
	var mform = document.cform;

	if (mform.room_name.value == "") {
		mform.room_name.focus();
		alert("회의실 명을 입력해 주세요.");
		return false;
	}
	if (mform.location.value == "") {
		mform.location.focus();
		alert("위치를 입력해 주세요.");
		return false;
	}

	mform.submit();
	return false;
}
</script>
</html>

<?php
   include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

   if($search_keyword != ''){
      $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
   }
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}

   .datepicker{
     z-index:10000 !important;
   }
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
<script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" />
<!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
   // echo $list_val_count."<br><br><br>";
   // var_dump($list_val);
?>

<div align="center">
   <div class="dash1-1">
      <form name="mform" action="<?php echo site_url();?>/admin/attendance_admin/attendance_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
      <input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
         <tbody>
        <tr height="5%">
          <td class="dash_title">
            근태조회
          </td>
        </tr>
        <tr>
           <td height="70"></td>
        </tr>
        <tr height="10%">
          <td align="left" valign="bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                  <!-- <span style="color:red;font-size:15px;margin-left:20px">*</span> -->
                  <span valign="bottom"  style="font-weight:bold; font: Noto sans(Medium); font-size:13px; color: #1c1c1c;">근무일자</span>
                  <select name="search1" id="filter1" class="select-common filtercolumn" style="width:100px;" onchange="search_day_type(this);">
                     <option value="day" <?php if(isset($filter)){if($filter[0]=='day'){echo "selected";}} ?>>일</option>
                     <option value="period" <?php if(isset($filter)){if($filter[0]=='period'){echo "selected";}} ?>>기간</option>
                  </select>
                  <input id="filter2" type="text" class="input-common search_date filtercolumn" value="<?php if(isset($filter)){echo $filter[1];} ?>" style="width:100px" autocomplete="off">
                  <span class="period" style="<?php if(isset($filter)){if($filter[0]=='day'){echo 'display:none;';}} else {echo "display:none;";} ?>">~</span>
                  <input id="filter3" type="text" class="input-common period search_date filtercolumn" value="<?php if(isset($filter)){echo $filter[2];} ?>" style="<?php if(isset($filter)){if($filter[0]=='day'){echo 'display:none;';}} else {echo "display:none;";} ?>width:100px;" autocomplete="off">
            <!--내용-->
                  <select id="filter4" class="select-common filtercolumn" style="margin-left:20px; width:140px;">
                    <option value="user_name" <?php if(isset($filter)){if($filter[3]=='user_name'){echo "selected";}} ?>>성명</option>
                  </select>
                  <span>
                    <input id="filter5" type="text" style="width:240px;" class="input-common filtercolumn" placeholder="검색하세요." autocomplete="off" readonly value="<?php if(isset($filter)){echo $filter[4];} ?>" onclick="$('#searchAddUserpopup').bPopup();" />
                  </span>

<!-- 검색 모달 -->
<div id="searchAddUserpopup" style="display:none; background-color: white; width: auto; height: auto;">
	<span id="searchAddUserpopupCloseBtn" class="btn" onclick="searchCloseBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span>
	<div id="search-modal-body">
		<div id="search-modal-grouptree" style="width:300px">
			<div id="search-usertree">
				<ul>
					<li>(주)두리안정보기술
						<ul>
						<?php
						foreach ($parentGroup as $pg){
						?>

						<?php
						if ($pg->childGroupNum==1 && $pg->depth==1){
						?>
							<li>
								<?php echo $pg->parentGroupName;
									foreach ($userInfo as $ui){
											if ($pg->groupName==$ui->user_group){
								?>
								<ul>
									<li id="<?php echo $ui->user_name; ?>"><?php echo $ui->user_name." ".$ui->user_duty.'<div style="display:none;">'.$ui->seq.'</div>'; ?></li>
								</ul>
								<?php
											}
									}
								?>
							</li>
							<?php
							} else if ($pg->childGroupNum>1 && $pg->depth==1){
							?>
							<li>
							<?php echo $pg->parentGroupName;
							foreach ($user_group as $ug) {
								if ($pg->parentGroupName==$ug->parentGroupName){
							?>
								<ul>
									<?php
									foreach ($userDepth as $ud){
											if ($ug->groupName == $ud->groupName){
												echo '<li id="'.$ud->user_name.'">'.$ud->user_name." ".$ud->user_duty.'<div style="display:none;">'.$ud->seq.'</div></li>';
											}
									}
									if ($ug->groupName != $pg->groupName){
										echo "<li>".$ug->groupName;
									}
									?>
										<ul>
										<?php
											foreach($userInfo as $ui) {
												if ($ug->groupName==$ui->user_group){
													echo '<li id="'.$ui->user_name.'">'.$ui->user_name." ".$ui->user_duty.'<div style="display:none;">'.$ui->seq.'</div></li>';
												}
											}
										?>
										</ul>
									</li>
								</ul>
							<?php
								}
							}
							?>
							</li>
							<?php
							}
							?>
						<?php
						}
						?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div id="search-btnDiv" style="float:right;">
			<input type="button" class="btn-common btn-color2" value="선택" width="54" height="25" onclick="addUser(this.id)" id="searchChosenBtn">
		</div>
	</div>
</div>
	<!-- 검색 모달 끝 -->

                  <span>
                    <input class="btn-common btn-style2" type="button" onclick="GoSearch();" value="검색" >
                  </span>
                </td>
             </tr>
          </table>
       </td>
    </tr>
    <tr style="max-height:45%">
      <td colspan="2" valign="top" style="padding:10px 0px;">
        <table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
              <table width="100%" class="month_tbl" border="0" cellspacing="0" cellpadding="0">
                <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
                <input type="hidden" name="seq" value="">
                <input type="hidden" name="mode" value="">
               <!--내용-->
              <!--리스트-->
                <colgroup>
                  <col width="5%" />
                  <col width="8%" />
                  <col width="5%" />
                  <col width="5%" />
                  <col width="5%" />
                  <col width="5%" />
                  <col width="5%" />
                  <col width="5%" />
                  <col width="8%" />
                  <col width="8%" />
                  <col width="8%" />
                  <!-- <col width="9%" /> -->
                  <!-- <col width="9%" />
                  <col width="9%" /> -->
                  <col width="5%" />
                  <col width="5%" />
                </colgroup>
                <tr class="t_top row-color1">
                  <th></th>
                  <th height="40" align="center">근무일자</th>
                  <th align="center">요일</th>
                  <th align="center">휴일</th>
                  <th align="center">휴가</th>
                  <th align="center">출장</th>
                  <th align="center">성명</th>
                  <th align="center">직급</th>
                  <th align="center">출근시간</th>
                  <th align="center">퇴근시간</th>
                  <!-- <th align="center">상태</th> -->
                  <!-- <th align="center">출근IP</th>
                  <th align="center">퇴근IP</th> -->
                  <th align="center">근무시간</th>
                  <th align="center">직출기록</th>
                  <th></th>
                </tr>
          <?php
             if ($count > 0) {
                $i = $count - $no_page_list * ( $cur_page - 1 );
                $icounter = 0;
                $week = array("일", "월", "화", "수", "목", "금", "토");
								$holiday_arr = array('연차','오전반차','오후반차','보건휴가','출산휴가','특별유급휴가','공가');
                foreach ( $list_val as $item ) {
                   $date = $item['e_date'];
                   $workdate = date("Y-m-d", strtotime($date));
          ?>
                <!-- <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"  onclick="input_attendance('<?php echo $item['seq'];?>')"> -->

                <tr>
                  <td></td>
                  <td height="40" align="center" class="workdate"><?php echo $workdate;?></td>
                  <td align="center"><?php echo $item['dayoftheweek'];?></td>
                  <td align="center">
                  <?php
                     if($item['dayoftheweek']=="토" || $item['dayoftheweek']=="일" || $item['date_name']!=""){
                        echo "<span style='color:red'>O<span>";
                     } else {
                        echo "-";
                     }
                  ?>
                  </td>
                  <td align="center">
                  <?php
                     if(in_array($item['annual_type'],$holiday_arr)){
                        echo "<span style='color:red'>O<span>";
                     } else {
                        echo "-";
                     }
                  ?>
                  </td>
                  <td align="center">
                    <?php if($item['start_day'] != ''){
                      echo "<span style='color:red'>O<span>";
                    } else{
                      echo "-";
                    } ?>
                  </td>
                  <td align="center" class="user_name"><?php echo $item['user_name']; ?></td>
                  <td align="center"><?php echo $item['user_duty']; ?></td>
                  <td align="center">
                  <?php
                     if ($item['go_time']!=""){
                        $ws = new DateTime($item['go_time']);
                        echo $ws->format('H:i:s');
                     } else {
                        echo '미처리';
                     }
                  ?>
                  </td>
                  <td align="center">
                  <?php
                     if ($item['leave_time']!=""){
                        $ws = new DateTime($item['leave_time']);
                        echo $ws->format('H:i:s');
                     } else {
                        echo '미처리';
                     }
                  ?>
                  </td>
                  <!-- <td align="center">
                    <?php echo $item['status']; ?>
                  </td> -->
                  <!-- <td align="center">

                  </td>
                  <td align="center">

                  </td> -->
                  <td align="center">
                    <?php
                    $work_time = explode(':', $item['work_time']);
                    echo $work_time[0]."시간 ".$work_time[1]."분";
                    ?>
                  <!-- <?php
                    if ($item['wstime']!="" && $item['wctime']!=""){
                    $on_time = date($item['wstime']);
                    $off_time = date($item['wctime']);
                    $time_diff = strtotime($off_time) - strtotime($on_time);
                    $days = floor($time_diff/86400);
                    $time = $time_diff - ($days*86400);
                    $hours = floor($time/3600);
                    $time = $time - ($hours*3600);
                    $min = floor($time/60);
                    $sec = $time - ($min*60);
                    echo $hours."시간 ".$min."분 ".$sec."초";
                             }
                  ?> -->
                  </td>
                  <td align="center">
                    <?php if($item['start_day'] != ''){ ?>
                    <img src="/misc/img/mobile/allow_up.svg" class="upBtn" onclick="viewShow(this);" style="cursor:pointer">
                    <img src="/misc/img/mobile/allow_down.svg" class="downBtn" style="cursor:pointer;display:none;">
                  <?php } ?>
                  </td>
                  <td></td>
                </tr>
            <?php
                 $i--;
                 $icounter++;
                }
             } else {
            ?>
                <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                   <td width="100%" height="40" align="center" colspan="20">등록된 게시물이 없습니다.</td>
                </tr>
            <?php
             }
            ?>
          </form>
                                         <!--//리스트-->
    <script type="text/javascript">
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
                     <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/></a></td>
                     <td width="2"></td>
                     <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" height="20"/></a></td>
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
                     <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/></a></td>
                     <td width="2"></td>
                     <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height="20"/></a></td>
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
<?php if(isset($filter) && $filter[0]=='period' && ($filter[1].$filter[2] != '')) { ?>
      <table class="calc_tbl" style="width:70%;margin-top:20px;margin-bottom:20px;" cellpadding="0" cellspacing="0" border="0">
<?php if(!empty($calc_sum)) {
        for($i = 0; $i < count($calc_sum); $i=$i+3) { ?>
        <tr height="30">
          <td style="border-left:1px #9EE7FD solid; text-align:center;font-size:14px;font-weight:bold;background-color:#F2FCFF;"><?php echo $calc_sum[$i]['user_name']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;">휴일 : <?php echo $calc_sum[$i]['holiday_cnt']; ?> </td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;">휴가 : <?php echo $calc_sum[$i]['annual_cnt']; ?></td>
            <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;"> 직출 : <?php echo $calc_sum[$i]['outside_work_cnt']; ?></td>

    <?php if(isset($calc_sum[$i+1])) { ?>
          <td style="border-left:1px #9EE7FD solid; text-align:center;font-size:14px;font-weight:bold;background-color:#F2FCFF;"><?php echo $calc_sum[$i+1]['user_name']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;">휴일 : <?php echo $calc_sum[$i+1]['holiday_cnt']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;">휴가 : <?php echo $calc_sum[$i+1]['annual_cnt']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;"> 직출 : <?php echo $calc_sum[$i+1]['outside_work_cnt']; ?></td>
    <?php } ?>

    <?php if(isset($calc_sum[$i+2])) { ?>
          <td style="border-left:1px #9EE7FD solid; text-align:center;font-size:14px;font-weight:bold;background-color:#F2FCFF;"><?php echo $calc_sum[$i+2]['user_name']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;">휴일 : <?php echo $calc_sum[$i+2]['holiday_cnt']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;">휴가 : <?php echo $calc_sum[$i+2]['annual_cnt']; ?></td>
          <td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2F2F2;"> 직출 : <?php echo $calc_sum[$i+2]['outside_work_cnt']; ?></td>
    <?php } ?>
        </tr>
  <?php }
      } ?>
      </table>
<?php } ?>
   </div>
</div>
<!-- 수정 모달 -->
<div id="attendance_input" style="display:none; position: absolute; background-color: white; width: 540px; height: 350px; border-radius:5px;">
   <!-- <form name="cform" action="<?php echo site_url();?>/admin/attendance_admin/attendance_individual" method="post" onSubmit=""> -->
    <table style="margin:10px 30px; border-collapse: separate; border-spacing: 0 30px;">
      <input type="hidden" name="attendance_seq" id="attendance_seq" value="">
      <input type="hidden" name="date" id="date" value="date">
      <colgroup>
				<col width="15%" />
				<col width="35%" />
				<col width="15%" />
				<col width="35%" />
			</colgroup>
       <tr>
        <td colspan="4" class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
          근태관리수정
        </td>
       </tr>
       <tr>
          <td align="left" valign="center" style="font-weight:bold;">이름</td>
          <td style="padding-right:20px;">
            <input type="text" class="input-common" name="user_name" id="user_name" value="" style="width:145px;" readonly>
          </td>
          <td align="left" valign="center" style="font-weight:bold;">카드번호</td>
          <td align="left">
            <input type="text" class="input-common" name="card_num" id="card_num" value="" style="width:145px;" readonly>
          </td>
       </tr>
       <tr>
          <td align="left" valign="center" style="font-weight:bold;">출근시간</td>
          <td align="left" style="padding-right:20px;">
            <input type="text" class="input-common" name="ws_time" id="ws_time" value="" style="width:145px;" autocomplete="off">
          </td>
          <td align="left" valign="center" style="font-weight:bold;">퇴근시간</td>
          <td align="left">
            <input type="text" class="input-common" name="wc_time" id="wc_time" value="" style="width:145px;" autocomplete="off">
          </td>
       </tr>
       <tr>
          <td align="left" valign="center" style="font-weight:bold;">상태</td>
          <td align="left">
             <select class="select-common" name="status" id="status" style="width:150px;">
                <option value="정상출근">정상출근</option>
                <option value="출근전">출근전</option>
                <option value="미처리">미처리</option>
                <option value="연차">연차</option>
  							<option value="오전반차">오전반차</option>
                <option value="오후반차">오후반차</option>
                <option value="지각">지각</option>
                <option value="휴직">휴직</option>
                <option value="결근">결근</option>
                <option value="조퇴">조퇴</option>
                <!-- <option value="병가">병가</option> -->
                <option value="출산휴가">출산휴가</option>
                <option value="특별유급휴가">특별유급휴가</option>
                <option value="공가">공가</option>
                <option value="외출">외출</option>
                <option value="건강검진">건강검진</option>
             </select>
             <!-- <input type="text" class="input2" name="status" id="status" value="" style="width:95%" autocomplete="off"> -->
          </td>
       </tr>
       <tr>
         <td colspan="4" align="right">
           <!--지원내용 추가 버튼-->
           <input type="button" class="btn-common btn-color1" style="width:70px; margin-right:10px;" value="취소" onclick="$('#attendance_input').bPopup().close()">
           <input type="button" class="btn-common btn-color2" style="width:70px;" value="등록" onclick="attendance_update();">
          </td>
        </tr>
    </table>
   <!-- </form> -->
</div>



<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
<script type="text/javascript">
   $(function(){
      $(".search_date").datepicker();
      $('#ws_time, #wc_time').timepicker({
         showMeridian: false,
      });
   });


   function search_day_type(el) {
      if($(el).val()=="period"){
         $(".period").show();
      } else {
         $("#search_end").val('');
         $(".period").hide();
      }
   }

   function GoSearch() {
		 var startday = $("#filter2").val();
		 var startday_arr = startday.split("-");
		 var endday = $("#filter3").val();
		 var endtday_arr = endday.split("-");

		 var startDateCompare = new Date(startday_arr[0], parseInt(startday_arr[1])-1, startday_arr[2]);
     var endDateCompare = new Date(endtday_arr[0], parseInt(endtday_arr[1])-1, endtday_arr[2]);

		 if(startDateCompare.getTime() > endDateCompare.getTime()) {
			 alert("시작날짜와 종료날짜를 확인해 주세요.");
			 return false;
		 }

     var searchkeyword = '';
     for (i = 1; i <= $(".filtercolumn").length; i++) {
       if (i == 1) {
         searchkeyword += $("#filter" + i).val();
       } else {
         searchkeyword += ',' + $("#filter" + i).val();
       }
     }

     $("#searchkeyword").val(searchkeyword);

     if (searchkeyword.replace(/,/g, "") == "") {
       alert("검색어가 없습니다.");
       location.href="<?php echo site_url();?>/admin/attendance_admin/attendance_list";
       return false;
     }

     document.mform.action = "<?php echo site_url();?>/admin/attendance_admin/attendance_list";
     document.mform.cur_page.value = "";
     document.mform.submit();

   }


   //근태관리 정보 수정
   function input_attendance(seq) {
      $.ajax({
         type: "POST",
         async: false,
         url: "/index.php/admin/attendance_admin/attendance_individual",
         dataType: "json",
         data: {
            type : 0 ,//select
            seq: seq
         },
         success: function (data) {
            $("#user_name").val(data.user_name);
            $("#attendance_seq").val(data.seq);
            $("#card_num").val(data.card_num);
            $("#date").val(data.workdate);
            $("#status").val(data.status);
            var wstime = data.wstime;
            if(wstime != "" && wstime != null){
               wstime = wstime.substring(8);
               wstime = wstime.substring(0,4);
               wstime =wstime.replace(/(.{2})/,"$1:");
            }
            var wctime = data.wctime;
            if(wctime != "" && wctime != null){
               wctime = wctime.substring(8);
               wctime = wctime.substring(0,4);
               wctime =wctime.replace(/(.{2})/,"$1:");
            }

            $("#ws_time").val(wstime);
            $("#wc_time").val(wctime);
            $('#ws_time, #wc_time').timepicker({
               showMeridian: false,
            });
         }
      })
      $("#attendance_input").bPopup();
   }

   //수정!
   function attendance_update(){
      $.ajax({
         type: "POST",
         async: false,
         url: "/index.php/admin/attendance_admin/attendance_individual",
         dataType: "json",
         data: {
            type : 1 ,//update
            seq : $("#attendance_seq").val(),
            wstime : $("#ws_time").val(),
            wctime : $("#wc_time").val(),
            date:$("#date").val(),
            status:$("#status").val()
         },
         success: function (data) {
            if(data){
               alert("수정되었습니다.");
               location.reload();
            }else{
               alert("수정에 실패하였습니다.");
            }
         }
      })

   }

   function viewShow(el){
     // 필요한 데이터 찾으려고 workdate와 user_name 사용 -> controller에 넘김 -> model -> return
     var tr = $(el).closest('tr'); // 직출기록버튼과 가장 가까운 tr 찾는다
     var workdate = tr.find('.workdate').text(); // input타입이 아니라서 val()아니고 text()로 가져와유
     var user_name = tr.find('.user_name').text();
     var result_cnt = 0;

     $.ajax({
        type: "POST",
        async: false,
        url: "/index.php/admin/attendance_admin/outside_schedule_data",
        dataType: "json",
        data: {
          workdate: workdate,
          user_name: user_name
        },
        success: function (result) {
          if(result) {
            var txt = "";
            result_cnt = result.length;
            //직출이 여러개일수도 있어서 반복문을 돌리면서 tr생성
            for(i=0; i<result.length; i++) {
              var place = $.trim(result[i].place);
              var visit_company = $.trim(result[i].visit_company);
              var customer = $.trim(result[i].customer);
              var start_time = result[i].start_time;
              var end_time = result[i].end_time;

              if(place != '') {
                var loc = place;
              } else if (visit_company != '') {
                var loc = visit_company;
              } else if (customer != '') {
                var loc = customer;
              } else {
                var loc = '';
              }

              // 문자열로 tr,td를 하나씩 생성
              txt += '<tr><td align="center" colspan="5"></td>';
              txt += '<td align="center" style="background-color:#F4F4F4">직출장소</td>';
              txt += '<td align="center">' + loc + '</td>';
              txt += '<td align="center" style="background-color:#F4F4F4">시작시간</td>';
              txt += '<td align="center">' + start_time + '</td>';
              txt += '<td align="center" style="background-color:#F4F4F4">종료시간</td>';
              txt += '<td align="center">' + end_time + '</td>';
              txt += '<td colspan="2"></td></tr>';
            }

            tr.after(txt); // 604번째 줄 tr밑에 변수txt 붙이기
          }
        }
     })
     tr.find('.upBtn').hide();
     tr.find('.downBtn').attr('onclick', 'viewHide(this, '+result_cnt+')')
     tr.find('.downBtn').show();
   };

   function viewHide(el, cnt) {
     var tr = $(el).closest('tr');
     for(i=0; i<cnt; i++) {
       $(tr).next().remove(); // tr에서 반복문을 돌린 길이만큼 (직출장소 갯수만큼) remove
     }
     tr.find('.upBtn').show(); // 올라간 화살표 보여줘
     tr.find('.downBtn').hide(); // 내려간 화살표 숨
   }

   function searchAddUserBtn(){
    $('#searchAddUserpopup').bPopup({follow:[false,false]});
    $('#searchAddUserpopup').bPopup();
   }

   // 지정 조직도 트리 생성
   var checked_text_select = [];
   var checked_seq_select = [];
   $(function() {
     $('#search-usertree').jstree({
       "checkbox" : {
         "keep_selected_style" : false
       },
       'plugins': ["wholerow", "checkbox"],
       'core' : {
         'themes' : {
           'name': 'proton',
           'icons' : false
         }
       }
     });
     $("#search-usertree").bind("changed.jstree", function (e, data) {
       var reg = /^[가-힣]*$/;
       checked_text_select.length = 0;
       checked_seq_select.length = 0;
       $.each($("#search-usertree").jstree("get_checked",true),function() {
         if (reg.test(this.id)) {
   				var text = this.text.split('<div style="display:none;">');
   				text2 = text[0];
   				var seq = text[1].replace('</div>','');
           checked_text_select.push(text2);
           checked_seq_select.push(seq);
   				// console.log(checked_text_select);
   				// console.log(checked_seq_select);
         }
       })
     });
   });


   function unique(array) {
     var result = [];
     $.each(array, function(index, element) {
       if ($.inArray(element, result) == -1) {
         result.push(element);
       }
     });
     return result;
   }

   // 사용자 추가
   function addUser(){
       var noneOverlapArr = unique(checked_text_select);

       var searchName ='';
       var searchNameArr = [];
       //직급 제거하기
       $.each(noneOverlapArr,function() {
         searchName = $(this)[0];
         searchName = searchName.split(' ')[0];
         searchNameArr.push(searchName)
         console.log(searchNameArr);
       })
       var searchAdduser = searchNameArr.join(".");
       $('#filter5').val(searchAdduser);
       $('#searchAddUserpopup').bPopup().close(); //모달 닫기
   }


</script>
</html>

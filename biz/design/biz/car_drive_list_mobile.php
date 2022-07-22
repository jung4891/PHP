<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
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
	.approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}
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
    box-sizing : border-box;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	.timeBtn {
		background:url(<?php echo $misc; ?>img/mobile/nav_mobile/attendance.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
  .modal_tbl td {
    height:40px;
  }
  .modal_tbl .input-common, .modal_tbl .select_common {
    width: 100% !important;
  }
  .detail_tbl th {
    font-size: 18px;
    font-weight: bold;
    text-align: left;
    height:40px;
  }
  .detail_tbl td {
    padding-left:10px;
    font-size: 15px;
  }
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
  <script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
  <script language="javascript">
  function GoSearch(){
    $('#searchkeyword').val($.trim($('#searchkeyword_input').val()));
    $('#search1').val($('#search_select1').val());

    var searchkeyword = document.mform.searchkeyword.value;
    var searchkeyword = searchkeyword.trim();

  //  if(searchkeyword == ""){
  //    alert( "검색어를 입력해 주세요." );
  //    return false;
  //  }

    document.mform.action = "<?php echo site_url();?>/biz/durian_car/car_drive_list";
    document.mform.cur_page.value = "";
  //  document.mform.search_keyword.value = searchkeyword;
    document.mform.submit();
  }

  $(function(){
    find_add_car_a_km();
  });

  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
  <form name="mform" action="<?php echo site_url();?>/biz/durian_car/car_drive_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  <input type="hidden" name="seq" value="">
  <input type="hidden" name="mode" value="">
  <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
   <input type="hidden" name="search1" id="search1" value="<?php echo $search1; ?>" />

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="50%">
				<col width="50%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr seq="<?php echo $item['seq'];?>" onclick="detail(this);">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['drive_purpose'];?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $item['writer']; ?></td>
				</tr>
				<tr seq="<?php echo $item['seq'];?>" onclick="detail(this);">
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['carname'].'/'.$item['carnum']; ?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;"><?php echo substr($item['d_time'],0,5).'/'.substr($item['a_time'],0,5);?></td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
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

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td align="left" height="40">
						<select class="select-common" name="search1" id="search_select1" style="margin-right:10px;color:black;width:92%;">
              <option value="001" <?php if($search1 == "001"){ echo "selected";}?>>차번</option>
              <option value="002" <?php if($search1 == "002"){ echo "selected";}?>>출발지</option>
              <option value="003" <?php if($search1 == "003"){ echo "selected";}?>>목적지</option>
              <option value="004" <?php if($search1 == "004"){ echo "selected";}?>>운행자</option>
              <option value="005" <?php if($search1 == "005"){ echo "selected";}?>>운행일</option>
						</select>
					</td>
      	</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="searchkeyword_input" class="input-common" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style=";width:95%;" />
					</td>
				</tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#search_div').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="검색" onclick="return GoSearch();">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 검색 모달 끝 -->
</form>
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
		<input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기" onclick="input_popup();">
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>


  <!-- 추가 모달 시작 -->
  <div id="input_modal" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0" class="modal_tbl">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td>차종</td>
          <td>운행일</td>
      	</tr>
				<tr>
					<td>
            <select class="select-common" id="add_carname" name="add_carname" onchange="find_add_car_a_km();">
            <?php foreach($car_list as $cl){ ?>
              <option value="<?php echo $cl->type."-".$cl->number; ?>"><?php echo $cl->type." / ".$cl->number; ?></option>
            <?php } ?>
              </select>
          </td>
          <td>
          <input type="date" class="input-common dayBtn" id="add_drive_date" name="add_drive_date" value="">
          </td>
				</tr>
				<tr>
      		<td>출발지</td>
          <td>목적지</td>
      	</tr>
				<tr>
					<td>
            <input type="text" class="input-common" id="add_d_point" name="add_d_point" value="">
          </td>
          <td>
            <input type="text" class="input-common" id="add_a_point" name="add_a_point" value="">
          </td>
				</tr>
				<tr>
      		<td>출발km</td>
          <td>도착시km</td>
      	</tr>
				<tr>
					<td>
            <input type="number" class="input-common" id="add_d_km" name="add_d_km" value="" readonly>
          </td>
          <td>
            <input type="number" class="input-common" id="add_a_km" name="add_a_km" value="" onkeyup="input_a_km();">
          </td>
				</tr>
				<tr>
      		<td>주행거리</td>
          <td>운행자</td>
      	</tr>
				<tr>
					<td>
            <input type="number" class="input-common" id="add_total_km" name="add_total_km" value="" readonly>
          </td>
          <td>
            <input type="text" class="input-common" id="add_driver" name="add_driver" value="">
          </td>
				</tr>
				<tr>
      		<td>출발시</td>
          <td>도착시</td>
      	</tr>
				<tr>
					<td>
            <input type="time" class="input-common timeBtn" id="add_d_time" name="add_d_time" value="">
          </td>
          <td>
            <input type="time" class="input-common timeBtn" id="add_a_time" name="add_a_time" value="">
          </td>
				</tr>
				<tr>
      		<td>주유비</td>
          <td>운행목적</td>
      	</tr>
				<tr>
					<td>
            <input type="number" class="input-common" id="add_oil" name="add_oil" value="">
          </td>
          <td>
            <input type="text" class="input-common" id="add_drive_purpose" name="add_drive_purpose" value="">
          </td>
				</tr>
				<tr>
      		<td>기타</td>
      	</tr>
				<tr>
					<td colspan="2">
            <input type="text" class="input-common" id="add_etc" name="add_etc" value="">
          </td>
				</tr>


				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#input_modal').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="등록" onclick="save_action();">
					</td>
				</tr>
      </table>
    </div>
  </div>

  <!-- 상세 모달 시작 -->
  <div id="detail_modal" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="color:#1C1C1C;">
      <table style="width:100%;padding:5%;" cellspacing="0" class="detail_tbl">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<th>차종</th>
          <th>운행일</th>
      	</tr>
				<tr>
					<td id="de_carname"></td>
          <td id="de_drive_date"></td>
				</tr>
				<tr>
      		<th>출발지</th>
          <th>목적지</th>
      	</tr>
				<tr>
					<td id="de_d_point"></td>
          <td id="de_a_point"></td>
				</tr>
				<tr>
      		<th>출발km</th>
          <th>도착시km</th>
      	</tr>
				<tr>
					<td id="de_d_km"></td>
          <td id="de_a_km"></td>
				</tr>
				<tr>
      		<th>운행자</th>
          <th>등록자</th>
      	</tr>
				<tr>
					<td id="de_driver"></td>
          <td id="de_writer"></td>
				</tr>
				<tr>
      		<th>출발시</th>
          <th>도착시</th>
      	</tr>
				<tr>
					<td id="de_d_time"></td>
          <td id="de_a_time"></td>
				</tr>
				<tr>
      		<th>주유비</th>
          <th>운행목적</th>
      	</tr>
				<tr>
					<td id="de_oil"></td>
          <td id="de_drive_purpose"></td>
				</tr>
				<tr>
      		<th>기타</th>
      	</tr>
				<tr>
					<td colspan="2" id="de_etc"></td>
				</tr>


				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td colspan="2">
						<input type="button" class="btn-common btn-color1" style="width:100%" value="취소" onclick="$('#detail_modal').bPopup().close();">
					</td>
				</tr>
      </table>
    </div>
  </div>


	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
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
  	document.mform.action = "<?php echo site_url();?>/tech/board/network_map_view";
  	document.mform.seq.value = seq;
  	document.mform.mode.value = "view";

  	document.mform.submit();
  }

  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });

  function input_a_km(){
    var d_km = $('#add_d_km').val();
    var a_km = $('#add_a_km').val();
    $('#add_total_km').val(a_km - d_km);
  }

  //해당 차종의 마지막 도착km 기록가져오기
  function find_add_car_a_km(){
    var add_carname = $('#add_carname').val();
    var split_carname = add_carname.split('-');
    var carname = split_carname[0];
    var carnum = split_carname[1];
    $.ajax({
      type: 'POST',
      dataType : "json",
      url: "<?php echo site_url(); ?>/biz/durian_car/find_last_a_km",
      data:{
        carname: carname,
        carnum: carnum
      },
      // cache:false,
      // async:false,
      success: function(data) {
        console.log(data);
        if(data != 'false' && data != null){
          $('#add_d_km').val(data);
          $('#add_d_km').attr('readonly',true);
        }else{
          $('#add_d_km').val('');
          $('#add_d_km').attr('readonly',false);
        }
      }
    });
  }

  var modify_list_arr = [];
  function save_action(){
    // modify_close(e);
    // var seq = $(e).attr('seq');
    // console.log(wrong_total_km_arr);

    var table_tr_length = $('#car_list_table').find('tr').length;
    for(var i = 1; i< table_tr_length; i++){
      var table_tr = $('#car_list_table').find('tr').eq(i);
      var table_carname = table_tr.find('#carname').val();
      var table_d_point = table_tr.find('#d_point').val();
      var table_a_point = table_tr.find('#a_point').val();
      var table_d_km = table_tr.find('#d_km').val();
      var table_a_km = table_tr.find('#a_km').val();
      var table_total_km = table_tr.find('#total_km').val();
      var table_driver = table_tr.find('#driver').val();
      var table_writer = table_tr.find('#writer').val();
      var table_drive_date = table_tr.find('#drive_date').val();
      var table_d_time = table_tr.find('#d_time').val();
      var table_a_time = table_tr.find('#a_time').val();
      // console.log(table_d_km);

      if(table_carname == '' || table_d_point == '' || table_a_point == '' || table_d_km == '' || table_a_km == '' || table_total_km == '' || table_driver == '' || table_drive_date == '' || table_d_time == '' || table_a_time == ''){
        alert('입력되지 않은 공란이 있습니다. 확인 후 저장해주세요.');
        return false;
        break;
      }
    }

    if($('#add_total_km').val() <= 0 && $('#add_total_km').val() != ''){
      alert('주행거리가 올바르지 않은 입력값이 있습니다. 다시 확인해주세요.')
      $('#add_a_km').focus();
      return false;
    } else{
    //내용 수정
      var val_arr = [];
      for(var i=0; i<modify_list_arr.length; i++){


        var tr = $('#tr_'+modify_list_arr[i]);
        var seq = modify_list_arr[i];
        var carname = tr.find('#carname').val();
        var d_point = tr.find('#d_point').val();
        var a_point = tr.find('#a_point').val();
        var d_time = tr.find('#d_time').val();
        var a_time = tr.find('#a_time').val();
        var d_km = tr.find('#d_km').val();
        var a_km = tr.find('#a_km').val();
        // var d_km = tr.find('#d_km').val().replace(' km','');
        // var a_km = tr.find('#a_km').val().replace(' km','');
        var driver = tr.find('#driver').val();
        var drive_date = tr.find('#drive_date').val();
        var drive_purpose = tr.find('#drive_purpose').val();
        var oil = tr.find('#oil').val();
        var etc = tr.find('#etc').val();

        if(carname == null){
          var seq = modify_list_arr[i];
          $.ajax({
            url : "<?php echo site_url(); ?>/biz/durian_car/find_modify_seq",
            type : "POST",
            dataType : "json",
            data : {
              seq: seq
            },
            success : function(data) {
              var prev_seq = '';
              $.ajax({
                url : "<?php echo site_url(); ?>/biz/durian_car/find_before_seq",
                type : "POST",
                dataType : "json",
                data : {
                  seq: seq,
                  carname: data.carname,
                  carnum: data.carnum
                },
                async:false, // 동기 방식으로 변경하면 ajax 결과값을 전역변수에 담으로 수 있다.(지금은 prev_seq에 data2를 담으려고 한다.)
                success : function(data2) {
                  prev_seq = data2;
                }
              });

              var carname = data.carname+'-'+data.carnum;
              var d_point = data.d_point;
              var a_point = data.a_point;
              var d_time = data.d_time;
              var a_time = data.a_time;
              var d_km = $('#tr_'+prev_seq).find('#a_km').val();
              var a_km = data.a_km;
              var driver = data.driver;
              var drive_date = data.drive_date;
              var drive_purpose = data.drive_purpose;
              var oil = data.oil;
              var etc = data.etc;
              alert(a_km - d_km);

              val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
            }
          });

        }else{

          val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
        }

        // val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
        // // val_arr.push({'seq':seq, 'carname':carname, 'd_point':d_point, 'a_point':a_point, 'd_time':d_time, 'a_time':a_time, 'd_km':d_km, 'a_km':a_km, 'driver':driver, 'drive_date':drive_date, 'drive_purpose':drive_purpose, 'oil':oil, 'etc':etc});
      }

      //내용 입력
        var add_carname = $('#add_carname').val();
        var add_d_point = $('#add_d_point').val();
        var add_a_point = $('#add_a_point').val();
        var add_d_time = $('#add_d_time').val();
        var add_a_time = $('#add_a_time').val();
        var add_d_km = $('#add_d_km').val();
        var add_a_km = $('#add_a_km').val();
        var add_driver = $('#add_driver').val();
        var add_drive_date = $('#add_drive_date').val();
        var add_drive_purpose = $('#add_drive_purpose').val();
        var add_oil = $('#add_oil').val();
        var add_etc = $('#add_etc').val();
        if((add_carname != '') && (add_d_point != '') && (add_a_point != '') && (add_d_time != '') && (add_a_time != '') && (add_d_km != '') && (add_a_km != '') && (add_driver != '') && (add_drive_date != '')){
          val_arr.push({'carname':add_carname, 'd_point':add_d_point, 'a_point':add_a_point, 'd_time':add_d_time, 'a_time':add_a_time, 'd_km':add_d_km, 'a_km':add_a_km, 'driver':add_driver, 'drive_date':add_drive_date, 'drive_purpose':add_drive_purpose, 'oil':add_oil, 'etc':add_etc});
        }
      // console.log(val_arr);
      if(val_arr.length <= 0){
        alert('저장 혹은 수정할 내용이 없습니다.');
        return false;
      }else{
        // console.log(val_arr);

        $.ajax({
          url : "<?php echo site_url(); ?>/biz/durian_car/car_drive_input_action",
          type : "POST",
          dataType : "json",
          data : {
            val_arr: val_arr
          },
          success : function(data) {
            // console.log('?'+data.max_km);
            // $('#d_km').val(data.max_km);
            // modify_close(e);
            alert('정상적으로 처리되었습니다.');
            // var link = document.location.href;
            // console.log(String(link));
            // console.log('<?php echo site_url(); ?>/biz/durian_car/car_drive_list');
            // if(String(link) = '<?php echo site_url(); ?>/biz/durian_car/car_drive_list'){
            //   alert(1);
              location.href='<?php echo site_url(); ?>/biz/durian_car/car_drive_list';
            // }else{
            //   alert(2);
            //   history.go(-1);
            // }

          }
        });
      }
    }
  }

  function input_popup() {
    $('#input_modal').bPopup();
  }

  function detail(el){
    var seq = $(el).attr('seq');

    $.ajax({
      url: '<?php echo site_url(); ?>/biz/durian_car/find_modify_seq',
      type : "POST",
      dataType : "json",
      data: {
        seq:seq
      },
      success: function(data){
        $("#de_carname").html(data.carname+'('+data.carnum+')');
        $("#de_drive_date").html(data.drive_date);
        $("#de_d_point").html(data.d_point);
        $("#de_a_point").html(data.a_point);
        $("#de_d_time").html(data.d_time);
        $("#de_a_time").html(data.a_time);
        $("#de_d_km").html(data.d_km);
        $("#de_a_km").html(data.a_km);
        $("#de_drive_purpose").html(data.drive_purpose);
        $("#de_driver").html(data.driver);
        $("#de_writer").html(data.writer);
        $("#de_oil").html(data.oil);
        $("#de_etc").html(data.etc);
      }
    })

    $('#detail_modal').bPopup();

  }
  </script>
</body>

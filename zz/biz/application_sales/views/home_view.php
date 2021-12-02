<?php
   include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
   include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link href='<?php echo $misc;?>css/tech_schedule/main.css' rel='stylesheet' />
<script src='<?php echo $misc;?>js/tech_schedule/main.js'></script>
<script src='<?php echo $misc;?>js/tech_schedule/ko.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>
<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
<style>
div.scheduleHint {
  font-size:12px; position:absolute; width:380px; line-height:1.5em; padding:5px 8px 7px; border: 1px solid #cccccc;  border-radius: 4px; background:#fff;  /* z-index:10001; */
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}

h3 {
  padding:0;
  margin: 0;
  font-weight: bold;
  line-height: 1.1;
  display: block;
  font-size: 1.17em;
  margin-block-start:1em;
  margin-block-end:1em;
  margin-inline-start:0px;
  margin-inline-end:0px;
}

.event_color_button {
  display: inline-block;
  vertical-align: middle;
  width: 15px;
  height: 15px;
}

<?php foreach($work_color as $wc){ ?>
<?php echo '.event_class_type'.$wc->seq; ?> { border: 1px solid #474889; border-radius: 50%; background: <?php echo $wc->color; ?> !important; color: #fff !important;
   -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
   -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
   box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}
<?php } ?>

  .text-point { color:#d3292c !important; }
  .text-normal { color:black !important; }
</style>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div style="width:40%;height:50px;font-family:'Noto Sans KR';color: #666;font-size:14px;float:left;">
   <div style="padding: 100px 10% 0 10% ">● 일정</div>
</div>
<div style="width:60%;height:50px;font-family:'Noto Sans KR';color: #666;font-size:14px;float:left;">
   <div style="padding: 100px 10% 0 10% ">● 결재대기함</div>
</div>
<div style="width:40%;font-family:'Noto Sans KR';color: #666;font-size:10px;float:left">
   <div id='calendar' style="padding:10%"></div>
</div>
<div style="width:60%;font-family:'Noto Sans KR';color: #666;font-size:12px;float:left;">
   <div id="approval" style="padding:10%">
	<table class="basic_table" width="100%" style="font-family:Noto Sans KR">
		<tr class="t_top" align="center" bgcolor="f8f8f9" >
		<td height=50 class="basic_td">NO</td>
		<td class="basic_td">서식함</td>
		<td class="basic_td">문서번호</td>
		<td class="basic_td">유형</td>
		<td class="basic_td">문서제목</td>
		<td class="basic_td">기안자</td>
		<td class="basic_td">기안부서</td>
		<td class="basic_td">기안일</td>
		<td class="basic_td">배정일</td>
		<td class="basic_td">문서상태</td>
		</tr>
		<?php
		if(empty($standby_approval) != true){
			$idx = 1;
		for($i =0; $i<count($standby_approval); $i++){
			if(!empty( $standby_approval[$i])){
				$doc = $standby_approval[$i];
				echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$doc['seq']},".'"'.$doc['approval_doc_status'].'"'.")'>";
				echo "<td height='40' class='basic_td'>{$idx}</td>";
				echo "<td class='basic_td'>";
				if($doc['template_category'] == ""){
					echo "연차";
				}else{
					foreach($category as $format_categroy){
					if($doc['template_category'] == $format_categroy['seq']){
						echo $format_categroy['category_name'];
					}
					}
				}
				echo "</td>";
				echo "<td class='basic_td'>문서번호아직없음</td>";
				echo "<td class='basic_td'>{$doc['approval_type']}</td>";
				if($doc['approval_doc_hold'] == "N"){
					echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']}</td>";
				}else{
					echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']} (보류)</td>";
				}

				echo "<td class='basic_td'>{$doc['writer_name']}</td>";
				echo "<td class='basic_td'>{$doc['writer_group']}</td>";
				echo "<td class='basic_td'>{$doc['write_date']}</td>";
				echo "<td class='basic_td'>{$doc['assignment_date']}</td>";

				echo "<td class='basic_td'>";
				if($doc['approval_doc_status'] == "001"){
					echo "진행중";
				}else if($doc['approval_doc_status'] == "002"){
					echo "완료";
				}else if($doc['approval_doc_status'] == "003"){
					echo "반려";
				}else if($doc['approval_doc_status'] == "004"){
					echo "회수";
				}else if($doc['approval_doc_status'] == "005"){
					echo "임시저장";
				}else if($doc['approval_doc_status'] == "006"){
					echo "보류";
				}else{
					echo "";
				}
				echo "</td>";
				echo "</tr>";
				$idx ++;
			}
		}
		}else{
		echo "<tr><td align='center' colspan=10 height='40' class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
		}
		?>
	</table>
	<?php if(!empty($delegation)){ ?>
	<br>
	<h3> 위임 </h3>
	<!-- 위임문서 -->
	<table class="basic_table" width="100%" style="font-family:Noto Sans KR">
		<tr class="t_top" align="center" bgcolor="f8f8f9" >
		<td height=50 class="basic_td">NO</td>
		<td class="basic_td">서식함</td>
		<td class="basic_td">문서번호</td>
		<td class="basic_td">유형</td>
		<td class="basic_td">문서제목</td>
		<td class="basic_td">기안자</td>
		<td class="basic_td">기안부서</td>
		<td class="basic_td">기안일</td>
		<td class="basic_td">배정일</td>
		<td class="basic_td">문서상태</td>
		</tr>
		<?php
		$idx = 1;
		foreach($delegation as $doc){
			echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$doc['seq']})'>";
			echo "<td height='40' class='basic_td'>{$idx}</td>";
			echo "<td class='basic_td'>";
			foreach($category as $format_categroy){
				if($doc['template_category'] == $format_categroy['seq']){
					echo $format_categroy['category_name'];
				}
			}
			echo"</td>";
			echo "<td class='basic_td'>문서번호아직없음</td>";
			echo "<td class='basic_td'>{$doc['approval_type']}</td>";
			if($doc['approval_doc_hold'] == "N"){
				echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']}(위임)</td>";
			}else{
				echo "<td width='15%' class='basic_td'>{$doc['approval_doc_name']} (보류)</td>";
			}

			echo "<td class='basic_td'>{$doc['writer_name']}</td>";
			echo "<td class='basic_td'>{$doc['writer_group']}</td>";
			echo "<td class='basic_td'>{$doc['write_date']}</td>";

			echo "<td class='basic_td'>{$doc['assignment_date']}</td>";

			echo "<td class='basic_td'>";
			if($doc['approval_doc_status'] == "001"){
				echo "진행중";
			}else if($doc['approval_doc_status'] == "002"){
				echo "완료";
			}else if($doc['approval_doc_status'] == "003"){
				echo "반려";
			}else if($doc['approval_doc_status'] == "004"){
				echo "회수";
			}else if($doc['approval_doc_status'] == "005"){
				echo "임시저장";
			}else if($doc['approval_doc_status'] == "006"){
				echo "보류";
			}else{
				echo "";
			}
			echo "</td>";
			echo "</tr>";
			$idx ++;
		}
	echo "</table>";
	}
	?>
   </div>
</div>
<?php if($parent_group == "기술본부"){ ?>
<div id="modal" class="searchModal">
  <div class="search-modal-content">
    <!-- <button onClick="closeModal();" style="float:right;">닫기</button> -->
    <div class="page-header">
      <h1>MODAL</h1>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-12">
            <h2>정기점검 미완료</h2>
          </div>
          <div>
            <table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
                <tr width="100%" height=30>
                    <td align="center" width="10%" bgcolor="f8f8f9" >idx</td>
                    <td align="center" width="20%" bgcolor="f8f8f9" >고객사</td>
                    <td align="center" width="20%" bgcolor="f8f8f9" >프로젝트명</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >점검주기</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >마지막점검일</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >관리팀</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >점검자</td>
                    <td align="center" width="10%" bgcolor="f8f8f9" >코멘트</td>
                </tr>

                <?php
                $idx=1;
                foreach($periodic_inspection as $val){
                  $font_color='';
                  if($val['maintain_result']==9){
                    $font_color="style='color:red'";
                  }
                    echo "<tr height=30 align='center'><td>{$idx}</td>";
                    echo "<td>{$val['customer_companyname']}</td>";
                    echo "<td>{$val['project_name']}</td>";
                    echo "<td>";
                    if ($val['maintain_cycle'] == "1") {
                        echo "월점검";
                    }else if ($val['maintain_cycle'] == "3") {
                        echo "분기점검";
                    }else if ($val['maintain_cycle'] == "6") {
                        echo "반기점검";
                    }else if ($val['maintain_cycle'] == "0") {
                        echo "장애시";
                    }else if ($val['maintain_cycle'] == "7") {
                        echo "미점검";
                    }else{
                        echo "";
                    }
                    echo "</td>";
                    echo "<td {$font_color}>{$val['maintain_date']}</td>";
                    echo "<td>";
                    if ($val['manage_team'] == "1") {
                      echo "기술 1팀";
                    }else if ($val['manage_team'] == "2") {
                        echo "기술 2팀";
                    }else if ($val['manage_team'] == "3") {
                        echo "기술 3팀";
                    }else{
                        echo "";
                    }
                    echo "</td>";
                    echo "<td>{$val['maintain_user']}</td>";
                    echo "<td>{$val['maintain_comment']}</td></tr>";

                    $idx=$idx+1;
                }
                ?>
            </table>
          </div>
        </div>
      </div>
    </div>
      <div style="cursor:pointer;background-color:#DDDDDD;text-align: center;padding-bottom: 10px;padding-top: 10px;margin-top:20px;" onClick="closeModal();">
        <span class="pop_bt modalCloseBtn" style="font-size: 13pt;">닫기</span>
      </div>
  </div>
</div>
<?php } ?>
<script>
<?php if(isset($_GET['login'])){?>
  jQuery(document).ready(function () {
    $("#modal").show();
  });

  function closeModal() {
    $("#modal").hide();
  };
<?php } ?>
var events = new Array();
$(document).ready(function(){
// var user_id = "<?php echo $id?>";
$.ajax({
   type: "POST",
   dataType:'json',
   url:"<?php echo site_url();?>/biz/schedule/user_null",
   // data:{
   //    user_id: user_id
   // },
   success: function(data, textStatus) {
     // console.log(data);
   },
   error :function(jqXHR, textStatus, errorThrown) {
       alert("실패");
   }
}).done(function(data){
   var eventObj = new Object();
   for (var j = 0; j<data.length; j++){
      eventObj = new Object();
      extendObj = new Object();
      if(data[j].start_time=="00:00:00"&&data[j].end_time=="00:00:00"){
         eventObj.start = data[j].start_day;
         eventObj.end = data[j].end_day;
      } else {
         eventObj.start = data[j].start_day+"T"+data[j].start_time;
         eventObj.end = data[j].end_day+"T"+data[j].end_time;
      }
      var participant = data[j].participant;
      participant = participant.split(",");
      len_participant = participant.length - 1;
      if (len_participant == 0){
         participant = participant[0];
      } else {
         participant = participant[0]+" 외 "+len_participant+"명";
      }
      if (data[j].customer == ""){
         var customer = "";
      } else {
         var customer = data[j].customer + "/";
      }
      if (data[j].work_name == ""){
         var work_name = "";
      } else {
         var work_name = data[j].work_name + "/";
      }
      if (data[j].support_method == ""){
         var support_method = "";
      } else {
         var support_method = data[j].support_method + "/";
      }
      var room_name = data[j].room_name;
      var car_name = data[j].car_name;
      if(room_name != ""){
        room_name = "["+ room_name +"]";
      }
      if(car_name != ""){
        car_name = "["+ car_name +"]";
      }
      // if (data[j].title == ""){
      if(data[j].work_type == "tech"){
         eventObj.title = "["+participant+"]" + customer + work_name + support_method;
      } else {
         eventObj.title = "["+participant+"]" + data[j].title;
      }
      eventObj.id = data[j].seq;
      extendObj.project = data[j].project;
      extendObj.title = data[j].title;
      extendObj.customer = data[j].customer;
      extendObj.work_name = data[j].work_name;
      extendObj.support_method = data[j].support_method;
      extendObj.work_color_seq = data[j].work_color_seq;
      extendObj.participant = data[j].participant;
      extendObj.user_name = data[j].user_name;
      extendObj.user_id = data[j].user_id;
      extendObj.group = data[j].group;
      extendObj.p_group = data[j].p_group;
      extendObj.insert_date = data[j].insert_date;
      eventObj.extendedProps = extendObj;
      eventObj.color = data[j].color;
      eventObj.textColor = data[j].textColor;
      eventObj.display = "block";

      extendObj.room_name = data[j].room_name;
      extendObj.car_name = data[j].car_name;
      extendObj.work_type = data[j].work_type;
      events.push(eventObj);
   }
   // console.log(events);
   calendarmaker();
})
});


function calendarmaker(){

   var calendarEl = document.getElementById('calendar');
   var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'listWeek',
      locale: 'ko',
      eventOverlap: true, //동일 날짜 시간 중복등록 가능
    scrollTime: '08:00', // 포커스 되는 시간
    dayMaxEventRows: true,
    displayEventTime: false,
      headerToolbar: {
         left: '', //왼쪽버튼
         center: 'title', //중앙 버튼
         right: 'goSchedule'

    },
      customButtons: {
         //일정 추가 버튼
         goSchedule: {
            text: 'more',
            click: function() {
               location.href ="<?php echo site_url()?>/biz/schedule/tech_schedule";
            }
         }

      },
     eventSources: [
         {events:events}
     ],
     eventDidMount: function(info) {       //일정 마우스 오버시 툴팁 창
       var elClass = $(info.el).attr("class");
       if (elClass.indexOf('koHolidays')==-1){
         var startDay = moment(info.event.start).format('YY-MM-DD');
         var endDay = moment(info.event.end).format('YY-MM-DD');
         var startTime =moment(info.event.start).format('HH:mm');
         var endTime = moment(info.event.end).format('HH:mm');
         var tilde = " ~ ";
         var allDay = "";
         if(endDay == "0000:00:00" || endDay == "Invalid date"){
           endDay = "";
         }
         if(startTime == "Invalid date"){
           startTime = "";
         }
         if(endTime == "Invalid date"){
           endTime = "";
         }
         var icon = 'event_class_type';
         var term = allDay+startDay+" "+startTime+tilde+ endDay+" "+endTime;
         var participant = info.event.extendedProps.participant;
         var title_participant = info.event.extendedProps.participant;
         var work_type = info.event.extendedProps.work_type;
         var sch_title = info.event.extendedProps.title;
         var customer = info.event.extendedProps.customer;
         var work_name = info.event.extendedProps.work_name;
         var support_method = info.event.extendedProps.support_method;
         var userName = info.event.extendedProps.user_name+" ("+info.event.extendedProps.insert_date+")";

         title_participant = participant.split(',');

         if (work_type == "tech"){
           if (participant.indexOf(",")!=-1 ){
             var title = "["+title_participant[0]+" 외 "+(title_participant.length-1)+"명"+"] ";
           } else {
             var title = "["+participant+"] ";
           }

           title += customer + '/' + work_name + '/' + support_method;

           var tooltipTitle = '<h3><span class="event_color_button '+icon+info.event.extendedProps.work_color_seq+'"></span>&nbsp;'+title+'</h3><div>'+term+'</div>';
         } else {
           var tooltipTitle = '<h3><span class="event_color_button '+icon+info.event.extendedProps.work_color_seq+'"></span>&nbsp;'+sch_title+'</h3><div>'+term+'</div>';
         }

         if (info.event.extendedProps.customer!=''){
           tooltipTitle += '<div><span class="text-point">[고객사]<span>&nbsp;<span class="text-normal">'+info.event.extendedProps.customer+'</span></div>';
         }
         tooltipTitle += '<div><span class="text-point">[구&nbsp;&nbsp;&nbsp;&nbsp;분]<span>&nbsp;<span class="text-normal">'+info.event.extendedProps.work_name+'</span></div>';

         if((info.event.extendedProps.room_name != null) && (info.event.extendedProps.room_name != '')){
           tooltipTitle += '<div><span class="text-point">[회의실]<span>&nbsp;<span class="text-normal">'+info.event.extendedProps.room_name+'</span></div>';
         }

         if((info.event.extendedProps.car_name != null) && (info.event.extendedProps.car_name != '')){
           tooltipTitle += '<div><span class="text-point">[차량]<span>&nbsp;<span class="text-normal">'+info.event.extendedProps.car_name+'</span></div>';
         }

         if (info.event.extendedProps.support_method!=''){
           tooltipTitle += '<div><span class="text-point">[지원방법]<span>&nbsp;<span class="text-normal">'+info.event.extendedProps.support_method+'</span></div>';
         }

         tooltipTitle += '<div><span class="text-point">[참석자]<span>&nbsp;<span class="text-normal">'+participant+'</span></div>';
         tooltipTitle += '<div><span class="text-point">[등록자]<span>&nbsp;<span class="text-normal">'+userName+'</span></div>';

         var tooltip = new Tooltip(info.el, {
           title :tooltipTitle,
           placement: 'bottom',
           trigger: 'hover',
           delay: {show:800},
           html:true,
           template: '<div class="tooltip tooltip-inner scheduleHint" role="tooltip"></div>',
         });
       }
     }


   });
   calendar.render();
}

function eletronic_approval_view(seq,status){
	location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=standby";
}


</script>
<!-- footer -->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!-- footer 끝 -->
</body>
</html>

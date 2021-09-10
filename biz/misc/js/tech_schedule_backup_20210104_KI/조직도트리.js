
//일정 등록
function scheduleAdd(){

  var startDay = $('#startDay').val();
  var startTime = $('#startTime').val();
  var endDay = $('#endDay').val();
  var endTime = $('#endTime').val();
  var workname = $('#workname').val();
  var customer = $('#customer').val();
  var supportMethod = $('#supportMethod').val();
  var participant = $('#participant').val();
  var contents = $('#contents').val();

  $.ajax({
    type: "POST",
    url:"/index.php/schedule/add_schedule",
    dataType:"json",
    data:{
      startDay:startDay,
      startTime:startTime,
      endDay:endDay,
      endTime:endTime,
      workname:workname,
      customer:customer,
      supportMethod:supportMethod,
      participant:participant,
      contents:contents
    },
    success: function(data) {
      alert("등록되었습니다.");
      if (data == 'false') {
        result = 'false';
      }
    }
});
    window.location.reload();
};


//날짜선택 달력으로 표시
$(function(){
  $("#startDay, #endDay").datepicker();

});
$(function(){
  $('#startTime, #endTime').timepicker({
                minuteStep: 10,
                // template: 'modal',
                // appendWidgetTo: 'body',
                // showSeconds: true,
                showMeridian: false
                // defaultTime: false
            });
})
function openStartDate(){
  $("#startDay").focus();
}

function openEndDate(){

  $("#endDay").focus();
}
///////


// 종일 버튼 누를시 시간선택 숨기기
function hideTime(){
if($("input:checkbox[name='alldayCheck']").is(":checked") == true){
  $("#startTime, #startTimeBtn, #endTime, #endTimeBtn").hide();
  $("#startTime, #endTime").val("");

}else{
  $("#startTime, #startTimeBtn, #endTime, #endTimeBtn").show();
}

}

$(function() {
    $('#tree').jstree({
      "checkbox" : {
    "keep_selected_style" : false
  },
        'plugins': ["checkbox"],

        'themes' : {
          'name': 'proton',
          'responsive' : true
        }
    });
});

//
// /////////////규인쓰 다되면 필요없는거 정리해줘
// groupView();
//
// //상위 그룹에서 하위 그룹 보기
// function viewMore(button){
//   // alert(1);
//   var parentGroup = (button.id).replace('Btn','');
//   // console.log($("#"+parentGroup+"Group"));
//   if($(button).attr("src")==="http://dev_tech.durianit.co.kr/misc/img/btn_add.jpg"){
//     // alert(2);
//     var src = "http://dev_tech.durianit.co.kr/misc/img/btn_del0.jpg";
//     $("#"+parentGroup+"Group").show();
//   }else{
//     // alert(3);
//     var src = "http://dev_tech.durianit.co.kr/misc/img/btn_add.jpg";
//      // $("#"+parentGroup+"Group").remove();
//      $("#"+parentGroup+"Group").hide();
//   }
//   $("#"+parentGroup+"Btn").attr('src', src);
// }

// //그룹 클릭했을 떄 해당하는 user 보여주기
// function groupView(group){
//   var hisInput = $(group).siblings('input')[0];
//   if(group == undefined){
//     var userGroup = "all";
//   }else{
//     if((hisInput.id).substr(-1,1) == 2){
//       var userGroup = (hisInput.id).replace('Fold2','');
//     }else{
//       var userGroup = (hisInput.id).replace('Fold','');
//     }
//   }
//   // alert(userGroup+"-------"+hisInput.value);
//   if(hisInput.value == 'false'){
//     $("#"+userGroup+"Group2").show();
//      hisInput.value = 'true';
//   }else{
//     $("#"+userGroup+"Group2").hide();
//     hisInput.value = 'false';
//   }
// }

// function clickFunc(check){
//   // var checkLi = check.closest('li').id.replace('GroupList','');
//   // var checkUl = $(check).siblings('ul');
//   // var imsi = $(check.closest('li')).siblings('ul').find('li').find('input').prop('checked',true);
//   // // alert(JSON.stringify(data ));
//   // console.log(imsi);
//
//   // if($(check.closest('li')).siblings('ul').find('li').find('input').is(":checked")){
//   //   $(check.closest('li')).siblings('ul').find('li').find('input').prop('checked',false);
//   // }else{
//   //   $(check.closest('li')).siblings('ul').find('li').find('input').prop('checked',true);
//   // }
//
//   if($(check).val() == 'true'){
//     $(check.closest('li')).siblings('ul').find('li').find('input').prop('checked',false);
//     $(check).val('false');
//   }else{
//     $(check.closest('li')).siblings('ul').find('li').find('input').prop('checked',true);
//     $(check).val('true');
//   }
//
// }
//
// function clickUser(check){
//   var checkId = (check.id).replace('PCheck','');
//   var checkUl = $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input');
//
//
//   if(($(check).val() == 'true') && (checkId != 'all')){
//     if($(check).parent('li').siblings('ul[id='+checkId+'Group]') != undefined){
//       $(check).parent('li').siblings('ul[id='+checkId+'Group]').find('li').find('input:checkbox').prop('checked',false);
//       $(check).parent('li').siblings('ul[id='+checkId+'Group]').find('li').find('input:checkbox').val('false');
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').prop('checked',false);
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').val('false');
//     }else{
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').prop('checked',false);
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').val('true');
//     }
//     $(check).val('false');
//
//   }else if(($(check).val() == 'true') && (checkId == 'all')){
//     $(check).siblings().children().find('input:checkbox').prop('checked',false);
//     $(check).siblings().children().find('input:checkbox').val('false');
//     $(check).val('false');
//
//   }else if(($(check).val() == 'false') && (checkId == 'all')){
//     $(check).siblings().children().find('input:checkbox').prop('checked',true);
//     $(check).siblings().children().find('input:checkbox').val('true');
//     $(check).val('true');
//
//   }else{
//     if($(check).parent('li').siblings('ul[id='+checkId+'Group]') != undefined){
//       $(check).parent('li').siblings('ul[id='+checkId+'Group]').find('li').find('input:checkbox').prop('checked',true);
//       $(check).parent('li').siblings('ul[id='+checkId+'Group]').find('li').find('input:checkbox').val('true');
//
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').prop('checked',true);
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').val('true');
//
//     }else{
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').prop('checked',true);
//       $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox').val('true');
//       userInput = $(check).parent('li').siblings('ul[id='+checkId+'Group2]').find('li').find('input:checkbox');
//     }
//     $(check).val('true');
//   }
// }
/////////////////규인쓰 까지

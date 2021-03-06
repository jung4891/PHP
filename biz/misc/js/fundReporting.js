// 스크롤 위치 세션
var page_scroll = sessionStorage.getItem('page_scroll');
var table_scroll = sessionStorage.getItem('table_scroll');
var bank_modify = sessionStorage.getItem('bank_modify');
// 로그 세션
var beforeCom = sessionStorage.getItem('page');
var login_time = sessionStorage.getItem('login_time');
var eq = 0;

// get 값 가져오는 함수
function getParam(sname) {
  var params = location.search.substr(location.search.indexOf("?") + 1);
  var sval = "";
  params = params.split("&");
  for (var i = 0; i < params.length; i++) {
    temp = params[i].split("=");
    if ([temp[0]] == sname) {
      sval = temp[1];
    }
  }
  return sval;
}

$(window).load(function(){
  // 세션 값 활용 페이지 스크롤 자동 이동
  if (page_scroll == null) {
    page_scroll = $(document).scrollTop() + $(window).height();
    // $(document).scrollTop(page_scroll);
  }
  if (table_scroll == null) {
    var row_height = $(".row_accountlist").height();
    $(".accountlist tr").each(function(){
      // console.log(1);
      if($(this).find("#bankType").val()!=''){

        table_scroll = $(this).attr('name')*row_height-7*row_height;
        // $('.table-box').scrollTop(table_scroll);
      }
    })
  }

  $(document).scrollTop(page_scroll);
  $('.table-box').scrollTop(table_scroll);

  if (bank_modify != null) {
    $('#bankModal').bPopup({follow:[false,false]});
    $('#'+bank_modify+'Btn').trigger('click');
  }
  // 세션 삭제
  sessionStorage.removeItem('bank_modify');
  sessionStorage.removeItem('page_scroll');
  sessionStorage.removeItem('table_scroll');

  // 접속 로그 생성
  var page = getParam("company");

  if (page != beforeCom) {
    if (beforeCom != null) {
      var con = '정상 로그아웃';
      var login_time = sessionStorage.getItem('login_time');

      $.ajax({
        type: 'POST',
        url: '/index.php/sales/fundreporting/logout?company=' + getParam("company"),
        datatype: 'json',
        data: {
          con: con,
          login_time: login_time
        },
        success: function(data) {
          //// console.log(data);
        }
      });
    }

    var login_time = getTimeStamp();

    $.ajax({
      type: "POST",
      url: "/index.php/sales/fundreporting/login?company=" + getParam("company"),
      dataType: "json",
      async: false,
      data: {
        login_time: login_time
      },
      success: function(data) {}
    });
    var page = getParam("company");
    sessionStorage.setItem("page", page);
    sessionStorage.setItem("login_time", login_time);
  }
})

$(document).ready(function() {
  start_timer();
});

$(window).mousemove(function() {
  clearTimeout(auto_logout);
  start_timer();
});

$(window).keypress(function() {
  clearTimeout(auto_logout);
  start_timer();
});

//일정 시간 마다 로그아웃 타임 업데이트
function update_logout_time() {
  var login_time = sessionStorage.getItem('login_time');
  var logout_time = "";
  var con = "비정상 로그아웃";
  $.ajax({
    type: "POST",
    url: "/index.php/sales/fundreporting/noreq",
    dataType: "json",
    async: false,
    data: {
      login_time: login_time,
      logout_time: logout_time,
      con: con
    },
    success: function(data) {}
  });
};
var logout_timer = setInterval(update_logout_time, 1000 * 60 * 5);


//일정 시간 응답 없을 시 처리
auto_logout = null;

function start_timer() {

  var login_time = sessionStorage.getItem('login_time');
  auto_logout = window.setTimeout(function() {
    var logout_time = getTimeStamp();
    var con = "비정상 로그아웃";
    clearInterval(logout_timer);
    $.ajax({
      type: "POST",
      url: "/index.php/sales/fundreporting/noreq",
      dataType: "json",
      async: false,
      data: {
        login_time: login_time,
        logout_time: logout_time,
        con: con
      },
      success: function(data) {}
    });
    var timeover = confirm("일정 시간 입력이 없습니다. 로그아웃 하시겠습니까?");
    if (timeover) {
      //확인
      var logout_time = getTimeStamp();
      var con = "정상 로그아웃";
      $.ajax({
        type: "POST",
        url: "/index.php/sales/fundreporting/noreq",
        dataType: "json",
        async: false,
        data: {
          login_time: login_time,
          logout_time: logout_time,
          con: con
        },
        success: function(data) {}
      });
      window.location.href = "/index.php/account/logout";
    } else {
      //취소
      var logout_time = "";
      var con = "비정상 로그아웃";
      $.ajax({
        type: "POST",
        url: "/index.php/sales/fundreporting/noreq",
        dataType: "json",
        async: false,
        data: {
          login_time: login_time,
          logout_time: logout_time,
          con: con
        },
        success: function(data) {}
      });
      var logout_timer = setInterval(update_logout_time, 1000 * 60 * 5);
    };

  }, 1000 * 60 * 5);
}

// 저장 버튼 단축키
Mousetrap.bind('f9', function(e) {
  $("#update").click();
});

// datepicker 생성
function genDatepicker(el) {
  $(el).datepicker();
}

// 달력 버튼 클릭 시 동작
function dateBtn(id) {
  $("#fromDate").datepicker();
  $("#toDate").datepicker();
  $("#"+id).focus();
}


function side_size(){
  // var height = $("#main_contents").outerHeight(true);
  // console.log(h +"/"+ h2);
  $("#sidebar_left").height($("#main_contents").height());
  $(".sidebar_sub_on").height($("#main_contents").height());
}
// 은행 정보 접기, 펼치기
function fold_bankbook(el) {
  if($(el).val() == "잔고현황 ▼") {
    $("#fold_bankbook").show(300);
    $(el).val('잔고현황 ▲');
  } else {
    $("#fold_bankbook").hide(300);
    $(el).val('잔고현황 ▼');
  }
  setTimeout(side_size, 300);

}


// 모달 창 은행 별 접기, 펼치기
function fold_modal(el) {
  var type = el.text.substring(0,el.text.length-1);
  var status = el.text.substring(el.text.length-1);

  if (type=="보통예금") {
    var selector = $(".modal_select_div");
  } else if (type=="예적금") {
    var selector = $(".modal_select_Save_div");
  } else if (type=="보증금") {
    var selector = $(".modal_select_Deposit_div");
  } else if (type=="대출금") {
    var selector = $(".modal_select_Loan_div");
  } else if (type=="투자금") {
    var selector = $(".modal_select_invest_div");
  } else if (type == "자산(건물)") {
    var selector = $(".modal_select_building_div");
  }

  if (status=="▼") {
    selector.show();
    el.text = type+"▲";

  } else if (status=="▲"){
    selector.hide();
    el.text = type+"▼";
  }
}

// 모달 창 켜기
function modalOpen() {
  $('#bankModal').bPopup({follow:[false,false],opacity:[0.4],modalColor:'gray'});
  $('#bankModal').draggable();
}

// 모달 창 끄기
function modalClose() {
  $('#bankModal').bPopup().close();
}

// 리스트 하단으로 이동
function scrollDown() {
  $('.table-box').scrollTop($('.table-box')[0].scrollHeight);
}

// 리스트 상단으로 이동
function scrollUp() {
  $('.table-box').scrollTop($('.table-box')[0]);
}

// 오늘 날짜 구하는 함수
function getToday() {
  var d = new Date();
  var s = leadingZeros(d.getFullYear(), 4) + '-' + leadingZeros(d.getMonth() + 1, 2) + '-' + leadingZeros(d.getDate(), 2);
  return s;
}

// 오늘 날짜, 시간 구하는 함수
function getTimeStamp() {
  var d = new Date();
  var s =
    leadingZeros(d.getFullYear(), 4) + '-' +
    leadingZeros(d.getMonth() + 1, 2) + '-' +
    leadingZeros(d.getDate(), 2) + ' ' +

    leadingZeros(d.getHours(), 2) + ':' +
    leadingZeros(d.getMinutes(), 2) + ':' +
    leadingZeros(d.getSeconds(), 2);

  return s;
}

// 오늘 날짜 구하는 함수
function leadingZeros(n, digits) {
  var zero = '';
  n = n.toString();

  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++)
      zero += '0';
  }
  return zero + n;
}

// 날짜 입력 오류 검사 (연)
function validateYear(date) {
  var result = false;
  var val = date.split('-')[0];

  if (val.indexOf('_') > -1) {
    result = false;
  } else if (val.length < 4) {
    reslut = false;
  } else if (Number(val) < 2000) {
    result = false;
  } else {
    result = true;
  }

  return result;
}

// 날짜 입력 오류 검사 (월)
function validateMonth(date) {
  var result = false;
  var val = date.split('-')[1];

  if (val.indexOf('_') > -1) {
    result = false;
  } else if (Number(val) > 12 || Number(val) < 1) {
    result = false;
  } else {
    result = true;
  }

  return result;
}

// 날짜 입력 오류 검사 (일)
function validateDay(date) {
  var result = false;
  var y = date.split('-')[0];
  var m = date.split('-')[1];
  var d = date.split('-')[2];
  var lastDay = (new Date(y, m, 0)).getDate();

  if (d.indexOf('_') > -1) {
    result = false;
  } else if (Number(d) > Number(lastDay) || Number(d) < 1) {
    result = false;
  } else {
    result = true;
  }

  return result;
}

// 숫자만 입력 함수
function onlyNumber(obj) {
  var val = obj.value;
  var re = /[^0-9]/gi;
  obj.value = val.replace(re, "");
}

// 숫자와 '-' 입력 함수
function onlyNumHipen(obj) {
  var val = obj.value;
  var re = /[^0-9-]/gi;
  obj.value = val.replace(re, "");
}

// 금액 부분 콤마 추가
function commaStr(n) {
  var reg = /(^[+-]?\d+)(\d{3})/;
  n += "";

  while (reg.test(n))
    n = n.replace(reg, "$1" + "," + "$2");
  return n;
}

// 금액 부분 콤마 제거
function deCommaStr(obj) {
  num = obj.value + "";
  if (obj.value != "") {
    obj.value = obj.value.replace(/,/g, "");
  }
  if (typeof obj.selectionStart == "number") {
    obj.selectionStart = obj.selectionEnd = obj.value.length;
  } else if (typeof obj.createTextRange != "undefined") {
    obj.focus();
    var range = obj.createTextRange();
    range.collapse(false);
    range.select();
  }
}

function unique(array) {
    var result = [];
    $.each(array, function(index, element) {
        if ($.inArray(element, result) == -1) {
            result.push(element);
        }
    });
    return result;
}

// 은행 구분 select2
function select2Mouseover(obj){
  $(obj).select2();
}



// 입금, 출금 수정시 잔액 변경
function calcBalance() {
  var totalLen = $('.accountlist tbody > tr').length;
  var balance = $('#saveBalance').val();

  $(".accountlist tbody > tr").each(function(){
    var tr = $(this);
    var deposit = tr.find("#deposit").val();
    var withdraw = tr.find("#withdraw").val();

    if (deposit == '') {
      var deposit = 0;
    } else {
      var deposit = deposit.replace(/,/g, '')
    }
    if (withdraw == '') {
      var withdraw = 0;
    } else {
      var withdraw = withdraw.replace(/,/g, '')
    }

    balance = Number(balance) + Number(deposit) - Number(withdraw);

    tr.find("#balance").val(commaStr(balance));
    tr.find("#balance2").val(commaStr(balance));
  })
}

// 모달 창 직접입력 선택 시 인풋 창 생성
function selboxDirect(el) {
  if (el.value == "직접입력") {
    $(el).siblings('.selboxDirect').show();
  } else {
    $(el).siblings('.selboxDirect').hide();
  }

  // 은행 선택 시 은행구분 자동 입력
  if (el.value.indexOf('은행')!=-1){
    var str = el.value;
    var str2 = str.split('은행')[0];

    $(el).closest('tr').find('#insertBankType').val(str2+'-');
  } else {
    $(el).closest('tr').find('#insertBankType').val();
  }
}

// 모달 창 직접입력 은행구분 자동 입력
function insBankDirect(el) {
  if (el.value.indexOf('은행')!=-1){
    var str = el.value;
    var str2 = str.split('은행')[0];

    $(el).closest('tr').find('#insertBankType').val(str2+'-');
  } else {
    $(el).closest('tr').find('#insertBankType').val();
  }
}

// 모달 창 은행구분 보통예금일 때 금액 수정 X
function insertType(el) {
  if (el.value == '보통예금'){
    $('#insertBalance').hide();
  } else {
    $('#insertBalance').show();
  }
}

function allCheck(el) {
  if (el.checked==true){
    $(".delRow").each(function(){
      $(this).attr("checked", "checked");
      delRowCheck(this);
    })
  } else {
    $(".delRow").each(function(){
      $(this).removeAttr("checked");
      delRowCheck(this);
    })
  }
}

// 거래 내역 리스트 체크 박스 클릭 시 동작
// 선택 행 색상 변경 및 입출금 합계 구하기
var checkLen = 0;
var delList = [];
var allCnt = $(".delRow").length;

function delRowCheck(el) {
  var tr = $(el).closest('tr');
  var deposit = tr.find('#deposit').val().replace(/,/g, "");
  var withdraw = tr.find('#withdraw').val().replace(/,/g, "");
  var idx = tr.find('#idx').val();
  var checkedCnt = $(".delRow").filter(":checked").length;

  if (allCnt == checkedCnt) {
    $("#allCheck").attr("checked", "checked");
  } else {
    $("#allCheck").removeAttr("checked");
  }

  if ($(el).attr('id')!='allCheck' && el.checked==true){
    delList.push(idx);

    tr.css('background-color', 'orange');
    tr.find('input').css({'background-color':'orange','border-color':'orange'});
    tr.find('select').css({'background-color':'orange','border-color':'orange'});
  } else if (el.checked==false){
    delList.splice($.inArray(idx, delList),1);

    tr.css('background-color', 'white');
    tr.find('input').css({'background-color':'white','border-color':'white'});
    tr.find('select').css({'background-color':'white','border-color':'white'});
  }

  var cnt = 0;
  var depositSum = 0;
  var withdrawSum = 0;

  $(".delRow").each(function(){
    if($(this).is(':checked')==true){
      var tr = $(this).closest('tr');
      var deposit = tr.find('#deposit').val().replace(/,/g, "");
      var withdraw = tr.find('#withdraw').val().replace(/,/g, "");
      depositSum = Number(depositSum) + Number(deposit);
      withdrawSum = Number(withdrawSum) + Number(withdraw);
      cnt++;

      if(tr.find('input[name=bill_seq]').val() != '') {
        var requisition = tr.find('#requisition').val().replace(/,/g, "");
        if(tr.find('#type').val() == '매출채권') {
          depositSum = Number(depositSum) + Number(requisition);
        }
        if(tr.find('#type').val() == '매입채무' || tr.find('#type').val() == '운영비용') {
          withdrawSum = Number(withdrawSum) + Number(requisition);
        }
      }
    }
  })
  var deSum = commaStr(depositSum);
  var withSum = commaStr(withdrawSum);

  $('#sumSpan').html("개수 : "+cnt+" 합계(입금) : "+deSum+" 합계(출금) : "+withSum);

  if(cnt <= 0){
    $('#sumSpan').html("");
  }
  delList = unique(delList);
}

// 날짜 입력 자동 포맷
function auto_datetime_format(e, oThis) {
  var num_arr = [
    97, 98, 99, 100, 101, 102, 103, 104, 105, 96,
    48, 49, 50, 51, 52, 53, 54, 55, 56, 57
  ]
  var key_code = (e.which) ? e.which : e.keyCode;
  if (num_arr.indexOf(Number(key_code)) != -1) {
    var len = oThis.value.length;
    if (len == 4) oThis.value += "-";
    if (len == 7) oThis.value += "-";
    if (len == 10) oThis.value += " ";
    if (len == 13) oThis.value += ":";
    if (len == 16) oThis.value += ":";
  }
}

// 날짜 30일 뒤 함수
function dateAdd(beforeDate) {
  var yy = parseInt(beforeDate.substr(0, 4), 10);
  var mm = parseInt(beforeDate.substr(5, 2), 10);
  var dd = parseInt(beforeDate.substr(8), 10);

  d = new Date(yy, mm - 1, dd + 30);

  yy = d.getFullYear(); // 19를 2019로 변경
  mm = d.getMonth() + 1;
  mm = (mm < 10) ? '0' + mm : mm; //월 변경  +1 하는 이유는 자바스크립트에서 0이 1월이라
  dd = d.getDate();
  dd = (dd < 10) ? '0' + dd : dd; //10일 이전이면 숫자 자릿수 맞추기 위함

  return '' + yy + '-' + mm + '-' + dd;
}

// 발행일 수정 시 예정일, 확정일 자동 입력
var modifyDateRow = [];
function plusDate(el) {

  var tr = $(el).closest('tr');
  var trName = tr.attr('name');
  var nextFixed = tr.find('#fixedDate').val();
  var nextDue = tr.find('#dueDate').val();
  var plusFixed = dateAdd(el.value);
  var plusDue = dateAdd(plusFixed);

  if(trName != "newRow"){
    if(nextFixed=='' && nextDue==''){
      modifyDateRow.push(trName);
      tr.find('#fixedDate').val(plusFixed);
      tr.find('#dueDate').val(plusDue);
    } else if (modifyDateRow.indexOf(trName)>=0) {
      tr.find('#fixedDate').val(plusFixed);
      tr.find('#dueDate').val(plusDue);
    }
  } else {
    console.log(1);
    tr.find('#fixedDate').val(plusFixed);
    tr.find('#dueDate').val(plusDue);
  }
}

// 모달창 수정 인덱스 저장
// var modify_modal_idx = new Set();
var modify_idx_arr = [];

function modifyModalInput(el) {
  el.style.backgroundColor = "#F08080";

  var idx = Number($(el).closest('tr').attr('name'));
  // modify_modal_idx.add(idx);
  // modify_idx_arr = Array.from(modify_modal_idx);
  modify_idx_arr.push(idx);
}

// 은행 등록 (모달)
function insertBank() {
  var tr = $("#modal_insert_row");

  var insertType = tr.find("#insertType").val();
  if (tr.find("#insertBank").val()=='직접입력'){
    var insertBank = tr.find(".selboxDirect").val();
  } else {
    var insertBank = tr.find("#insertBank").val();
  }
  var insertBankType = tr.find("#insertBankType").val().replace(/\s/gi, "");
  var insertAccount = tr.find('#insertAccount').val().replace(/\s/gi, "");
  var insertBreakdown = tr.find('#insertBreakdown').val();
  var insertBalance = tr.find('#insertBalance').val().replace(/,/g, '');
  if (insertBalance=='') {
    insertBalance = 0;
  }

  if (insertType==''){
    alert('예금종류를 선택하세요.');
    stopPropagation();
  }
  if (insertType != '보증금') {
    if (insertType == '' && insertBank == '' && insertBankType == '' && insertBankType == ''){
      alert('등록할 은행정보를 입력해주세요.');
      stopPropagation();
    }
  } else {
    if (insertBreakdown == '') {
      alert('등록할 은행의 내역을 입력해주세요.');
      stopPropagation();
    }
  }

  if (insertType == "보통예금"){
    var tableType = "selectTable";
  } else if (insertType == "예적금"){
    var tableType = "saveTable";
  } else if (insertType == "보증금"){
    var tableType = "depositTable";
  } else if (insertType == "대출금"){
    var tableType = "loanTable";
  } else if (insertType == "투자금"){
    var tableType = "investTable";
  }

  var result = "";
  $.ajax({
    type: 'POST',
    url: '/index.php/sales/fundreporting/insertbankbook?company=' + getParam("company"),
    datatype: 'json',
    data: {
      insertType: insertType,
      insertBank: insertBank,
      insertBankType: insertBankType,
      insertAccount: insertAccount,
      insertBreakdown: insertBreakdown,
      insertBalance: insertBalance
    },
    success: function(data) {
      if (data == 'true'){
        alert('은행정보가 등록되었습니다.');
        sessionStorage.setItem('bank_modify', tableType);
        window.location.reload();
      }
    },
    error: function(jqXHR,textStatus){
      if(jqXHR.status==500){
        alert('은행정보 등록에 실패했습니다.');
      };
    }
  });
}

// 은행 삭제 (모달)
function delBank(el){
  var idx = $(el).closest('tr').attr('name');
  var delType = $(el).closest('table').attr('name');
  var userId = $('#userId').val();
  var result = '';

  if(confirm('해당 은행정보를 정말로 삭제하시겠습니까?')==true){
    var delajax = $.ajax({
      type: 'POST',
      url: '/index.php/sales/fundreporting/deletebankbook',
      // asyn:'false',
      datatype: 'json',
      data: {
        delIdx: idx
      },
      success: function(data) {
        if (data == 'true'){
          result = 'true';
        }
      },
      error: function(jqXHR,textStatus){
        if(jqXHR.status==500){
          result = 'false';
        };
      }
    });
  } else {
    return;
  }
  $.when(delajax).done(function() {
    $.ajax({
      type: 'POST',
      url: '/index.php/sales/fundreporting/deluser',
      // asyn:'false',
      datatype: 'json',
      data: {
        delIdx: idx,
        delId: userId
      },
      success: function(data) {
        if (data == 'true'){
          result = 'true';
        }
      },
      error: function(jqXHR,textStatus){
        if(jqXHR.status==500){
          result = 'false';
        };
      }
    });
  });
  if (result = 'true') {
    alert('은행정보가 삭제되었습니다.');
    sessionStorage.setItem('bank_modify', delType);
    window.location.reload();
  } else {
    alert('은행정보 삭제에 실패했습니다.');
  }
}

// 은행 수정 (모달)
function modifyBank() {
  var modifyLen = modify_idx_arr.length;
  var result = '';
  var bank_modify_type = '';
  if (modifyLen > 0){
    for (var i = 0; i < modifyLen; i++) {
      var tr = $('.modal-body tr[name='+modify_idx_arr[i]+']');
      var idx = tr.attr('name').replace(/\s/gi, "");
      var type = tr.find("#selectType").val();
      bank_modify_type = tr.closest('table').attr('name');
      var bank_select = tr.find('#selectBank').val();
      var bank_input = tr.find(".selboxDirect").val();
      if (bank_select == '직접입력' && bank_input != '') {
        var bank = bank_input;
      } else if (bank_select == '직접입력' && bank_input == '') {
        alert("은행정보를 입력하세요.");
        stopPropagation();
      } else {
        var bank = bank_select;
      }
      var bankType = tr.find("#selectBankType").val().replace(/\s/gi, "");
      var account = tr.find('#selectAccount').val().replace(/\s/gi, "");
      var breakdown = tr.find("#selectBreakdown").val();
      var balance = tr.find("#selectBalance").val().replace(/,/g, '');

      $.ajax({
        type: "POST",
        url: "/index.php/sales/fundreporting/updatebankbook?company=" + getParam("company"),
        dataType: "json",
        data: {
          updateIdx: idx,
          updateType: type,
          updateBank: bank,
          updateBankType: bankType,
          updateAccount: account,
          updateBreakdown: breakdown,
          updateBalance: balance
        },
        success: function(data) {
          if (data == 'true'){
            result = 'true';
          }
        },
        error: function(jqXHR,textStatus){
          if(jqXHR.status==500){
            result = 'false';
          };
        }
      });
    };
    if (result = 'true') {
      alert('은행정보가 수정되었습니다.');
      sessionStorage.setItem('bank_modify', bank_modify_type);
      window.location.reload();
    } else {
      alert('은행정보 삭제에 실패했습니다.');
    }
  } else{
    alert('은행정보 수정에 실패했습니다. 다시 한 번 확인해주세요.');
  }
}

// 삭제 버튼 눌렀을 때 동작 (거래내역)
function deleteRow() {
  if (delList.length == 0) {
    alert('삭제할 항목을 선택하세요.');
  } else {
    if (confirm('선택한 ' + delList.length + '개 항목을 삭제하시겠습니까?') == true) {
      for (var i = 0; i < delList.length; i++) {
        var delIdx = delList[i];

        $.ajax({
          type: 'POST',
          url: "/index.php/sales/fundreporting/delete?company=" + getParam("company"),
          datatype: 'json',
          data: {
            data: delIdx
          },
          success: function(data) {
            //// console.log(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.statusText = "Internal Server Error") {
              alert(delList[i] + '행 데이터 삭제 실패했습니다.');
            }
          }
        });
      }
      alert('선택한 ' + delList.length + '개 내용이 삭제되었습니다.');
      window.location.reload();
    } else {
      return;
    };
  };
}

// 거래 내역 수정 시 헹 저장 (거래내역)
// var modify_list_row = new Set();
var modify_list_arr = [];

// 수정 시 배열에 index 입력
function modifyInput(obj) {
  obj.style.backgroundColor = "#F08080";
  $(obj).siblings().find('span').attr("style","background-color:#F08080");

  var trName = Number($(obj).closest('tr').attr('name'));
  // modify_list_row.add(trName);
  // modify_list_arr = Array.from(modify_list_row);
  modify_list_arr.push(trName);
}

function modifyType(obj){
  var tr = $(obj).closest('tr');
  tr.find("#withdraw").show();
  tr.find("#deposit").show();
  var value = $(obj).val();
  if (value == "매출채권"){
    // alert(tr.find("#withdraw").val());
    tr.find("#withdraw").hide();
  } else if (value == "매입채무") {
    // alert(tr.find("#deposit").val());
    tr.find("#deposit").hide();
  }

}

// 저장 버튼 눌렀을 때 동작 (거래내역)
function saveList() {
  var err = [];
  var listLen = $('.row_accountlist').length;
  var newLen = $(".newRow").length;
  var totalLen = $('.accountlist tbody > tr').length;
  var saveConfirm = confirm('저장하시겠습니까?');

  if (saveConfirm) {
    // 수정 추가 모두 없을 때
    if (newLen == 0 && modify_list_arr.length == 0) {
      alert("수정 사항이 없습니다.");
      stopPropagation();
    }

    $(".accountlist tbody > tr").css('background-color', 'white');
    $(".accountlist tbody > tr").children('td').css('background-color', 'white');
    $(".accountlist tbody > tr").find('#type').css('background-color', 'white');

    $(".newRow").each(function(){
      var tr = $(this);
      var dateOfIssue = tr.find("#dateOfIssue").val();
      var fixedDate = tr.find("#fixedDate").val();
      var dueDate = tr.find("#dueDate").val();
      var type = tr.find("#type").val();
      var bankType = $.trim(tr.find("#bankType").val());
      var customer = tr.find("#customer").val();
      var endUser = tr.find("#endUser").val();
      var breakdown = tr.find("#breakdown").val();
      var requisition = tr.find("#requisition").val();
      var deposit = tr.find("#deposit").val();
      var withdraw = tr.find("#withdraw").val();

      if(dateOfIssue==""&&fixedDate==""&&dueDate==""&&type==""&&bankType==""&&customer==""&&endUser==""&&breakdown==""&&requisition==""&&deposit==""&&withdraw==""){
        tr.remove();
      }
    })

    // 입력 오류 검사
    var errNum = 0;
    $(".accountlist tbody > tr").each(function(){
      errNum++;
      var tr = $(this);
      var type = tr.find("#type").val();
      var breakdown = tr.find("#breakdown").val();
      var requisition = tr.find("#requisition").val().replace(/,/g, '');
      var deposit = tr.find("#deposit").val().replace(/,/g, '');
      var withdraw = tr.find("#withdraw").val().replace(/,/g, '');

      if (type == "매출채권" && deposit == '') {
        tr.find("#type").css('background-color', 'pink');
        tr.find("#deposit").closest('td').css('background-color', 'pink');
        err.push(errNum);
        if (requisition != '' && deposit == '' && withdraw == '') {
          err.pop();
          tr.find("#type").css('background-color', 'white');
          tr.find("#deposit").closest('td').css('background-color', 'white');
        }
      }

      if (type == "매입채무" && withdraw == '') {
        tr.find("#type").css('background-color', 'pink');
        tr.find("#withdraw").closest('td').css('background-color', 'pink');
        err.push(errNum);
        //// console.log(err);
        if (requisition != '' && deposit == '' && withdraw == '') {
          //// console.log(deposit);
          err.pop();
          tr.find("#type").css('background-color', 'white');
          tr.find("#withdraw").closest('td').css('background-color', 'white');
        }
      }

      if (breakdown != '기초' && requisition == '' && deposit == '' && withdraw == '') {
        tr.find("#requisition").closest('td').css('background-color', 'black');
        tr.find("#deposit").closest('td').css('background-color', 'black');
        tr.find("#withdraw").closest('td').css('background-color', 'black');
        err.push(errNum);
      } else {
        tr.css('background-color', 'white');
      }
    })



    var errRow = [];
    $.each(err, function(i, el) {
      if ($.inArray(el, errRow) === -1) errRow.push(el);
    });
    var errLen = errRow.length;

    if (errLen > 0) {
      alert(errLen + "행의 데이터 입력이 잘 못 되었습니다.");
      stopPropagation();
    }

    var result = "";
    modify_list_arr = unique(modify_list_arr);
    // 수정이 있을 경우
    if (modify_list_arr.length > 0) {
      for (var i = 0; i < modify_list_arr.length; i++){
        var tr = $(".accountlist tr[name='"+modify_list_arr[i]+"']");
        var idx = tr.find("#idx").val();
        var dateOfIssue = tr.find("#dateOfIssue").val();
        var fixedDate = tr.find("#fixedDate").val();
        var dueDate = tr.find("#dueDate").val();
        var type = tr.find("#type").val();
        var bankType = tr.find("#bankType").val();
        var customer = $.trim(tr.find("#customer").val());
        var endUser = $.trim(tr.find("#endUser").val());
        var breakdown = $.trim(tr.find("#breakdown").val());
        var requisition = tr.find("#requisition").val().replace(/,/g, '');
        var deposit = tr.find("#deposit").val().replace(/,/g, '');
        var withdraw = tr.find("#withdraw").val().replace(/,/g, '');

        $.ajax({
          type: "POST",
          // cache:false,
          url: "/index.php/sales/fundreporting/update?company=" + getParam("company"),
          dataType: "json",
          async: false,
          data: {
            idx: idx,
            dateOfIssue: dateOfIssue,
            fixedDate: fixedDate,
            dueDate: dueDate,
            type: type,
            bankType: bankType,
            customer: customer,
            endUser: endUser,
            breakdown: breakdown,
            requisition: requisition,
            deposit: deposit,
            withdraw: withdraw
          },
          success: function(data) {
            if (data == 'false') {
              //// console.log(data);
              result = 'false';
            }
          }
        });
      }
      $("#update").attr("disabled", true);
    }

    // 입력이 있을 경우
    if (newLen > 0) {
      $(".newRow").each(function(){
        var tr = $(this);
        var idx = tr.find("#idx").val();
        var dateOfIssue = tr.find("#dateOfIssue").val();
        var fixedDate = tr.find("#fixedDate").val();
        var dueDate = tr.find("#dueDate").val();
        var type = tr.find("#type").val();
        var bankType = $.trim(tr.find("#bankType").val());
        var customer = $.trim(tr.find("#customer").val());
        var endUser = $.trim(tr.find("#endUser").val());
        var breakdown = $.trim(tr.find("#breakdown").val());
        var requisition = tr.find("#requisition").val().replace(/,/g, '');
        var deposit = tr.find("#deposit").val().replace(/,/g, '');
        var withdraw = tr.find("#withdraw").val().replace(/,/g, '');
        var link_seq = tr.find('.link_seq').val();

        $.ajax({
          type: "POST",
          // cache:false,
          url: "/index.php/sales/fundreporting/insert?company=" + getParam("company"),
          dataType: "json",
          async: false,
          data: {
            idx: idx,
            dateOfIssue: dateOfIssue,
            fixedDate: fixedDate,
            dueDate: dueDate,
            type: type,
            bankType: bankType,
            customer: customer,
            endUser: endUser,
            breakdown: breakdown,
            requisition: requisition,
            deposit: deposit,
            withdraw: withdraw,
            link_seq: link_seq
          },
          success: function(data) {
            if (data == 'false') {
              //// console.log(data);
              result = 'false';
            }
          }
        });
      })
      $("#update").attr("disabled", true);
    }

    if (result = 'true') {
      alert('저장을 성공하였습니다.');
      var page_scroll = $(document).scrollTop();
      var table_scroll = $(".table-box").scrollTop();
      sessionStorage.setItem('page_scroll', page_scroll);
      sessionStorage.setItem('table_scroll', table_scroll);
      window.location.reload();
    } else {
      alert('저장을 실패하였습니다.');
      window.location.reload();
    }
  } else {
    alert('저장이 취소되었습니다.');
    return false;
  }
}

function search_modify_select(el) {
  if ($(el).val() == "dueDate") {
    $("#modify_before").datepicker();
    $("#modify_after").datepicker();
  } else {
    $("#modify_before").datepicker('destroy');
    $("#modify_after").datepicker('destroy');
  }
}

// 선택 바꾸기
function search_modify() {
  if (delList.length == 0) {
    alert('수정할 항목을 선택하세요.');
  } else {
    var modify_col = $("#modify_col").val();
    var modify_before = $("#modify_before").val();
    var modify_after = $("#modify_after").val();

    if (confirm('선택한 ' + delList.length + '개 항목을 수정하시겠습니까?') == true) {
      for (var i = 0; i < delList.length; i++) {
        var delIdx = delList[i];

        $.ajax({
          type: 'POST',
          url: "/index.php/sales/fundreporting/search_modify?company=" + getParam("company"),
          datatype: 'json',
          data: {
            idx: delIdx,
            modify_col:modify_col,
            modify_before:modify_before,
            modify_after:modify_after
          },
          success: function(data) {
            //// console.log(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.statusText = "Internal Server Error") {
              alert(delList[i] + '행 데이터 수정에 실패했습니다.');
            }
          }
        });
      }
      alert('선택한 ' + delList.length + '개 내용이 수정되었습니다.');
      window.location.reload();
    } else {
      return;
    };
  };
}

// // 일괄 수정
// function search_modify() {
//   var search_dateType = $("#selectDate").val();
//   var search_fromDate = $("#search_fromDate").val();
//   var search_toDate = $("#search_toDate").val();
//   var search1 = $("#search1").val();
//   var keyword1 = $("#keyword1").val();
//   var search2 = $("#search2").val();
//   var keyword2 = $("#keyword2").val();
//   var modify_col = $("#modify_col").val();
//   var modify_before = $("#modify_before").val();
//   var modify_after = $("#modify_after").val();
//
//   if (modify_before == ''){
//     alert("변경 전 내용을 작성하세요.");
//     $("#modify_before").focus();
//   }
//
//   if (modify_before == ''){
//     alert("변경 후 내용을 작성하세요.");
//     $("#modify_before").focus();
//   }
//
//   $.ajax({
//     type: 'POST',
//     url: '/index.php/fundreporting/search_modify?company=' + getParam("company"),
//     datatype: 'json',
//     data: {
//       search_dateType: search_dateType,
//       search_fromDate: search_fromDate,
//       search_toDate: search_toDate,
//       search1: search1,
//       keyword1: keyword1,
//       search2: search2,
//       keyword2:keyword2,
//       modify_col:modify_col,
//       modify_before:modify_before,
//       modify_after:modify_after
//     },
//     success: function(data) {
//       if (data == 1){
//         alert('일괄 수정되었습니다.');
//         window.location.reload();
//       } else {
//         alert('일괄 수정에 실패했습니다.');
//         window.location.reload();
//       }
//     }
//   });
// }

// 변수 체크 함수
function nullCheck(variable) {
  if(variable) {
    return variable;
  } else {
    return '';
  }
}
// var opt_vals = [];
var bankTypeOpt = '';
var values = $("#bankType").eq(0).find('option').map(function(){
  return $(this).val();
});

for (var i = 0; i < values.length; i++) {
  if (values[i] != ''){
    bankTypeOpt += '<option value="' + values[i] + '">' + values[i] + '</option>';
  }
}

// 추가, 한줄복사 버튼 클릭 시
function newRow(paste) {
  if (paste == 'paste'){
    var check_num = $('input[name=delRow]:checked').length;
    if (check_num == 0) {
      alert('복사할 행을 선택해 주세요.');
      return false;
    } else if (check_num > 1) {
      alert('복사할 행을 하나만 선택해 주세요.');
      return false;
    }

    var tr = $('input[name=delRow]:checked').closest('tr');
    if (tr.attr('class') == 'row_accountlist') {
      var link_seq = tr.find('#idx').val();
    } else {
      var link_seq = tr.find('.link_seq').val();
      if (link_seq == 'undefined') {
        var link_seq = '';
      }
    }
    var dateOfIssue = tr.find("#dateOfIssue").val();
    var fixedDate = tr.find("#fixedDate").val();
    var dueDate = tr.find("#dueDate").val();
    var type = tr.find("#type").val();
    var bankType = tr.find("#bankType").val();
    var customer = tr.find("#customer").val();
    var endUser = tr.find("#endUser").val();
    var breakdown = tr.find("#breakdown").val();
    var requisition = tr.find("#requisition").val();
    var deposit = tr.find("#deposit").val().replace(/,/g, '');
    var withdraw = tr.find("#withdraw").val().replace(/,/g, '');
    var yesBalance = tr.find("#balance").val().replace(/,/g, '');
    var balance = commaStr(Number(yesBalance) + Number(deposit) - Number(withdraw));
    if (balance == 0) {
      balance = '';
    }
    deposit = commaStr(deposit);
    withdraw = commaStr(withdraw);
  } else {
    var link_seq = '';
  }

  var contents = '';
  contents += '<tr class="newRow" name="newRow">';
  contents += '<input type="hidden" class="link_seq" value="' + link_seq + '">';
  contents += '<td class="cell0" scope="row"><input type="checkbox" name="delRow" id="rowCheck" onchange="delRowCheck(this);"/></td>';
  contents += '<td class="cell1" scope="row">';
  contents += '<input type="text" class="input mousetrap" style="width:100%; text-align:left;" id="dateOfIssue" name="dateOfIssue" value="' + nullCheck(dateOfIssue) + '" maxlength="10" onchange="plusDate(this);" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);"/></td>';
  contents += '<td class="cell2" scope="row">';
  contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="fixedDate" name="fixedDate" value="' + nullCheck(fixedDate) + '" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" /></td>';
  contents += '<td class="cell3" scope="row">';
  contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="dueDate" name="dueDate" value="' + nullCheck(dueDate) + '" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" /></td>';
  contents += '<td class="cell4" scope="row">';
  contents += '<select id="type" name="type" style="height:100%; width:100%; text-align:left; border:none;" onchange="modifyType(this);">';
  contents += '<option value="' + nullCheck(type) + '">' + nullCheck(type) + '</option>';
  contents += '<option value="">&nbsp;</option>';
  contents += '<option value="매입채무">매입채무</option>';
  contents += '<option value="매출채권">매출채권</option>';
  contents += '<option value="운영비용">운영비용</option>';
  contents += '</select></td>';
  contents += '<td class="cell5" scope="row">';
  contents += '<select id="bankType" name="bankType" style="height:100%; width:100%; text-align:left; border:none;" onmouseover="select2Mouseover(this);">';
  if (bankType!=''){
    contents += '<option value="">&nbsp;</option>';
  }
  contents += '<option value="' + nullCheck(bankType) + '" selected>' + nullCheck(bankType) + '</option>';
  contents += bankTypeOpt;
  contents += '</select></td>';
  contents += '<td class="cell6" scope="row">';
  contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="customer" name="customer"	value="' + nullCheck(customer) + '" title="' + nullCheck(customer) + '" /></td>';
  contents += '<td class="cell7" scope="row">';
  contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="endUser" name="endUser" value="' + nullCheck(endUser) + '" title="' + nullCheck(endUser) + '" /></td>';
  contents += '<td class="cell8" scope="row">';
  contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="breakdown" name="breakdown" value="' + nullCheck(breakdown) + '" title="' + nullCheck(breakdown) + '" /></td>';
  contents += '<td class="cell9" scope="row">';
  contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="requisition" name="requisition" value="' + nullCheck(requisition) + '" title="' + nullCheck(requisition) + '" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="';
  if(getParam('company') == 'DK') {
    contents += 'onlyNumHipen';
  } else {
    contents += 'onlyNumber';
  }
  contents += '(this);" /></td>';
  contents += '<td class="cell10 mousetrap" scope="row">';
  contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="deposit" name="deposit" class="deposit" value="' + nullCheck(deposit) + '" title="' + nullCheck(deposit) + '" onchange="calcBalance();" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);" /></td>';
  contents += '<td class="cell11 mousetrap" scope="row">';
  contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="withdraw" name="withdraw" class="withdraw" value="' + nullCheck(withdraw) + '" title="' + nullCheck(withdraw) + '" onchange="calcBalance();" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);"/></td>';
  contents += '<td class="cell12 mousetrap" scope="row">';
  contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="balance" name="balance" class="balance" value="' + nullCheck(balance) + '" title="' + nullCheck(balance) + '" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/></td>';
  contents += '<td class="cell13 mousetrap" scope="row">';
  contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="balance2" name="balance2" class="balance2" value="' + nullCheck(balance) + '" title="' + nullCheck(balance) + '" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/></td>';
  contents += '<td><input type="image" name="delRow" class="delRow" value="" src="/misc/img/dashboard/btn/icon_x.svg"/></td>';
  contents += '</tr>';

  $('#AddOption').append(contents); // 추가기능
  var newTr = $('.accountlist tr[name="newRow"]');
  newTr.find("select").css('border', 'solid 1px green');
  newTr.find("input").css('border', 'solid 1px green');
  $(".delRow").css('border', 'none');
  $('.table-box').scrollTop($('.table-box')[0].scrollHeight);

  $('.delRow').click(function() { // 삭제기능
    $(this).closest('tr').remove();
  });
}

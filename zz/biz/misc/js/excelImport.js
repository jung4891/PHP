function excelExport(event) {
  var input = event.target;
  var reader = new FileReader();
  var rABS = !!reader.readAsBinaryString;
  var len = 0;

  reader.onload = function() {
    var fileData = reader.result;

    if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
      var fileData = reader.result;
      if(!rABS) fileData = new Uint8Array(fileData);
      var wb = XLSX.read(fileData, {
        type: rABS ? 'binary' : 'array',
        cellDates: true,
        cellNF: false,
        cellText: false
      });
      } else {
        var fileData = reader.result;
        var wb = XLSX.read(fileData, {
          type: 'binary',
          cellDates: true,
          cellNF: false,
          cellText: false
        });
      }

  // Sun Apr 26 2015 23:59:08 GMT+0900 (대한민국 표준시)
  wb.SheetNames.forEach(function(sheetName) {
    var rowObj = XLSX.utils.sheet_to_json(wb.Sheets[sheetName], {
      raw: false,
      dateNF: 'YYYY-MM-DD'
    });
    len = len + rowObj.length; // 엑셀 임포트한 길이
    var tr = $(".accountlist tr:last-child");
    var contents = '';

    if ($(".accountlist tbody > tr").length == 0) {
      var lastBalance = 0;
    } else {
      var lastBalance = tr.find("#balance").val().replace(/,/g, '');
    }

    for (var i = 0; i < len; i++) {
      var deposit = rowObj[i].입금;
      var withdraw = rowObj[i].출금;

      if (typeof rowObj[i].출금 == "undefined") {
        rowObj[i].출금 = '';
        var withdraw = 0;
      }
      if (typeof rowObj[i].입금 == "undefined") {
        rowObj[i].입금 = '';
        var deposit = 0;
      }

      var lastBalance = Number(lastBalance) + Number(rowObj[i].입금) - Number(rowObj[i].출금);

      contents += '<tr class="newRow" name="newRow">';
      contents += '<td class="cell0" scope="row"><input type="checkbox" name="delRow" id="rowCheck" onchange="delRowCheck(this);"/></td>';
      contents += '<td class="cell1" scope="row">';
      contents += '<input type="text" class="input mousetrap" style="width:100%; text-align:left;" id="dateOfIssue" name="dateOfIssue" value="' + rowObj[i].발행일 + '" maxlength="10" onchange="plusDate(this);" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);"/></td>';
      contents += '<td class="cell2" scope="row">';
      contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="fixedDate" name="fixedDate" value="' + rowObj[i].예정일 + '" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" /></td>';
      contents += '<td class="cell3" scope="row">';
      contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="dueDate" name="dueDate" value="' + rowObj[i].확정일 + '" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" /></td>';
      contents += '<td class="cell4" scope="row">';
      contents += '<select id="type" name="type" style="height:100%; width:100%; text-align:left; border:none;">';
      contents += '<option value="' + rowObj[i].대구분 + '">' + rowObj[i].대구분 + '</option>';
      contents += '<option value=""></option>';
      contents += '<option value="매입채무">매입채무</option>';
      contents += '<option value="매출채권">매출채권</option>';
      contents += '<option value="운영비용">운영비용</option>';
      contents += '</select></td>';
      contents += '<td class="cell5" scope="row">';
      contents += '<select id="bankType" name="bankType" style="height:100%; width:100%; text-align:left; border:none;" onmouseover="select2Mouseover(this);">';
      contents += '<option value="' + rowObj[i].은행구분 + '" selected>' + rowObj[i].은행구분 + '</option>';
      contents += bankTypeOpt;
      contents += '</select></td>';
      contents += '<td class="cell6" scope="row">';
      contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="customer" name="customer"	value="' + rowObj[i].거래처 + '" title="' + rowObj[i].거래처 + '" /></td>';
      contents += '<td class="cell7" scope="row">';
      contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="endUser" name="endUser" value="' + rowObj[i].ENDUSER + '" title="' + rowObj[i].ENDUSER + '" /></td>';
      contents += '<td class="cell8" scope="row">';
      contents += '<input class="input mousetrap" style="width:100%; text-align:left;" type="text" id="breakdown" name="breakdown" value="' + rowObj[i].내역 + '" title="' + rowObj[i].내역 + '" /></td>';
      contents += '<td class="cell9" scope="row">';
      contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="requisition" name="requisition" value="' + commaStr(rowObj[i].청구금액) + '" title="' + commaStr(rowObj[i].청구금액) + '" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);" /></td>';
      contents += '<td class="cell10" scope="row">';
      contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="deposit" name="deposit" class="deposit" value="' + commaStr(rowObj[i].입금) + '" title="' + commaStr(rowObj[i].입금) + '" onchange="calcBalance();" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);" /></td>';
      contents += '<td class="cell11" scope="row">';
      contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="withdraw" name="withdraw" class="withdraw" value="' + commaStr(rowObj[i].출금) + '" title="' + commaStr(rowObj[i].출금) + '" onchange="calcBalance();" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);"/></td>';
      contents += '<td class="cell12" scope="row">';
      contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="balance" name="balance" class="balance" value="' + commaStr(lastBalance) + '" title="' + commaStr(lastBalance) + '" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/></td>';
      contents += '<td class="cell13" scope="row">';
      contents += '<input class="input mousetrap" style="width:70%; text-align:right;" type="text" id="balance2" name="balance2" class="balance2" value="' + commaStr(lastBalance) + '" title="' + commaStr(lastBalance) + '" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/></td>';
      contents += '<td><input type="image" name="delRow" class="delRow" value="" src="/misc/img/dashboard/btn/icon_x.svg"/></td>';
      contents += '</tr>';
    }

      var contents = contents.replace(/undefined/g, '');
      $('#AddOption').append(contents);
      var newTr = $('.accountlist tr[name="newRow"]');
      newTr.find("select").css('border', 'solid 1px green');
      newTr.find("input").css('border', 'solid 1px green');
      $(".delRow").css('border', 'none');
      $('.table-box').scrollTop($('.table-box')[0].scrollHeight);
    })

    $('.delRow').click(function() { // 삭제기능
      $(this).closest('tr').remove();
    });
  };

  var agent = navigator.userAgent.toLowerCase();

  if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
    reader.readAsArrayBuffer(input.files[0]);
  } else {
    reader.readAsBinaryString(input.files[0]);
  }
}

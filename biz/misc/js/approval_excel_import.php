<script type="text/javascript" src="/misc/js/xlsx.full.min.js"></script>
<script type="text/javascript">

function excelUpload() {
  var t_year = $('.tr1_td1').val();

  var corporation_card_num = '<?php echo $corporation_card_num['corporation_card_num']; ?>';

  if(confirm('지출년도가 ' + t_year + '으로 설정되어 있습니다.\n엑셀 업로드 내역이 ' + t_year + '로 출력됩니다.')) {
    $('#excelFile').trigger('click');
  } else {
    $('select[class=tr1_td1]').focus();
  }
}

function excelImport(event) {
  var input = event.target;
  var reader = new FileReader();
  var rABS = !!reader.readAsBinaryString;
  var len = 0;
  var t_year = $('.tr1_td1').val();
  t_year = t_year.replace(/[^0-9]/g, '');

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
    var re = /[면|동|리|길|로]$/;

    var excelData = [];

    var last_blank = true;

    var last_tr = $('.tr2_td1').last().closest('tr');

    var last_value = '';

    var corporation_card_num = '<?php echo $corporation_card_num['corporation_card_num']; ?>';

    last_tr.find('input').each(function(){
      if($.trim($(this).val()) != '') {
        last_blank = false;
      }
    })

    var card_error_cnt = 0;

    for(var i = 0; i < len-2; i++) {
      if($.trim(rowObj[i].일자) != '' && $.trim(corporation_card_num) == $.trim(rowObj[i].이용카드)){
        if(i != 0) {
          excelData.push(rowObj[i]);
        }
      } else if($.trim(rowObj[i].일자) != '' && $.trim(corporation_card_num) != $.trim(rowObj[i].이용카드)) {
        if(i != 0) {
          card_error_cnt++;
        }
      }
    }

    if(card_error_cnt > 0) {
      alert('카드번호가 맞지 않는 데이터가 ' + card_error_cnt + '건 있습니다.');
    }

    for(var j = 0; j < excelData.length; j++) {
      var t = $('.tr2_td1').last().closest('tr');

      if(last_blank) {
        Object.keys(excelData[j]).forEach(function(k){
          if(k == '일자') {
            var month = excelData[j][k].substring(0,2);
            var day = excelData[j][k].substring(2,4);

            t.find('.tr2_td1').val(t_year + '.' + month + '.' + day);
          } else if (k == '이용하신 가맹점') {
            t.find('.tr2_td6').val(excelData[j][k]);
          } else if (k == '이용금액') {
            t.find('.tr2_td7').val(excelData[j][k]);
            t.find('.tr2_td7').change();
          } else if (k.indexOf('가맹점 소재지')!=-1) {
            t.find('.tr2_td4').val(excelData[j][k]);
            var loc = excelData[j][k];
            loc = loc.split(' ');

            for(var l=0; l<loc.length; l++) {
              if(re.test(loc[l])) {
                t.find('.tr2_td4').val(loc[l]);
              }
            }
          }
        });
        last_blank = false;
      } else {
        var tr = $('.tr2_td1').last().closest('tr');
        var tr_name = tr.attr('name');
        var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
        var tr_last_html = tr_last.outerHTML;
        $(tr).after(tr_last_html);
        var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
        $(new_tr).find("img").show();
        for(i=0; i<$(new_tr).find($("input")).length; i++){
           // if($(new_tr).find($("input")).eq(i).val().indexOf("express") != -1){
              $(new_tr).find($("input")).eq(i).val(''); //표현식 들어있는 input 비워
           // }
        }

        Object.keys(excelData[j]).forEach(function(k){
          if(k == '일자') {
            var month = excelData[j][k].substring(0,2);
            var day = excelData[j][k].substring(2,4);

            $(new_tr).find('.tr2_td1').val(t_year + '.' + month + '.' + day);
          } else if (k == '이용하신 가맹점') {
            $(new_tr).find('.tr2_td6').val(excelData[j][k]);
          } else if (k == '이용금액') {
            $(new_tr).find('.tr2_td7').val(excelData[j][k]);
            $(new_tr).find('.tr2_td7').change();
          } else if (k.indexOf('가맹점 소재지')!=-1) {
            $(new_tr).find('.tr2_td4').val(excelData[j][k]);
            var loc = excelData[j][k];
            loc = loc.split(' ');

            for(var l=0; l<loc.length; l++) {
              if(re.test(loc[l])) {
                $(new_tr).find('.tr2_td4').val(loc[l]);
              }
            }
          }
        });
      }
    }
  })

  };

  var agent = navigator.userAgent.toLowerCase();

  if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
    reader.readAsArrayBuffer(input.files[0]);
  } else {
    reader.readAsBinaryString(input.files[0]);
  }
}

</script>

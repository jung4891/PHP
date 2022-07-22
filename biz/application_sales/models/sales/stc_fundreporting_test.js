var page_scroll = sessionStorage.getItem('page_scroll');
var table_scroll = sessionStorage.getItem('table_scroll');
var bank_modify = sessionStorage.getItem('bank_modify');

var beforCom = sessionStorage.getItem('page');
var login_time = sessionStorage.getItem('login_time');
var eq = 0;

function getParam(sname) {
  var params = location.search.substr(location.search.indexOf('?') + 1);
  var sval = '';
  params = params.split('&');
  for (var i = 0; i < params.length; i++) {
    temp = params[i].split('=');
    if ([temp[0]] == sname) {
      sval = temp[1];
    }
  }
  return sval;
}

$(window).load(function({
  if (page_scroll == null) {
    page_scroll = $(document).scrollTop() + $(window).height();
  }
  if (table_scroll == null) {
    var row_height = $(".row_accountlist").height();
    $(".accountlist tr").each(function(){
      if ( $(this).find("#bankType").val() != '' ) {
        table_scroll = $(this).attr('name') * row_height - 7 * row_height;
      }
    })
  }

  $(document).scrollTop(page_scroll);
  $('.table_box').scrollTop(table_scroll);

  if ( bank_modify != null ) {
    $('#bankModal').bPopup( { follow:[false,false] } );
    $('#'+bank_modify+'Btn').trigger('click');
  }

  sessionStorage.removeItem('bank_modify');
  sessionStorage.removeItem('page_scroll');
  sessionStorage.removeItem('table_scroll');

  var page = getParam("company");

  if (page != beforeCom) {
    if (beforeCom != null) {
      var con = '정상 로그아웃';
      var login_time = sessionStorage.getItem('login_time');

      $.ajax({
        type: 'POST',
        url: '/index.php/sales/fundreporting/logout?company=' + getParam("company"),
        datatype: 'json',
      })
    }
  }
}))

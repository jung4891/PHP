<script type="text/javascript">
  var config = {
    txHost: '',
    txPath: '',
    txService: 'sample',
    txProject: 'sample',
    initializedId: '',
    wrapper: 'tx_trex_container',
    form: 'tx_editor_form'+'',
    txIconPath: '/misc/daumeditor-7.4.9/images/icon/editor/',
    txDecoPath: '/misc/daumeditor-7.4.9/images/deco/contents',
    canvas: {
      style: {
        color: '#000000',
        fontFamily: '굴림',
        fontSize: '10pt',
        backgroundColor: '#fff',
        lineHeight: '1.5',
        padding: '8px'
      },
      showGuideArea: false
    },
    events: {
      preventUnload: false
    },
    sidebar: {
      attachbox: {
        show: true,
        confirmForDeleteAll: true
      }
    },
    size: {
    }
  };

  EditorJSLoader.ready(function(editor){
    var editor = new Editor(config);
  });
</script>

<script type="text/javascript">
  function saveContent() {
    Editor.save();
  }

  function validForm(editor) {
    var validator = new Trex.validator();
    var content = editor.getContent();
    if(!validator.exists(content)) {
      alert('내용을 입력하세요.');
      return false;
    }
    return true;
  }

  function setForm(editor) {
    var i, input;
    var form = editor.getForm();
    var content = editor.getContent();

    var textarea = document.createElement('textarea');
    textarea.name = 'content';
    textarea.value = content;
    form.createField(textarea);

    var images = editor.getAttachments('image');
    for(i = 0; i < images.length; i++) {
      if(images[i].existStage) {
        alert('attachement information - image[' + i +'] \r\n' + JSON.stringify(images[i].data));
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'attach_image';
        input.value = images[i].data.imageurl;
        form.createField(input);
      }
    }

    var files = editor.getAttachments('file');
    for (i = 0; i < files.length; i++) {
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'attach_file';
      input.value = files[i].data.attachurl;
      form.createField(input);
    }
    return true;
  }

  function loadContent() {
    var attachments = {};

    Editor.modify({
      "attachments": function() {
        var allattachments = [];
        for (var i in attachments) {
          allattachments = allattachments.concat(attachements[i]);
        }
        return allattachments;
      }(),
      'content': document.getElementById('content');
    })
  }

  $(document).ready(function() {
    loadContent();
  });

  function create_annual() {
    if($('input:checkbox[name="user_annual_seq"]:checked').length == 0){
      alert('----');
      return false;
    }

    $('input:checkbox[name="user_annual_seq"]').each(function() {
      if(this.checked == true) {
        var annual_seq = this.value;
        $.ajax({
          type: "POST",
          async: false,
          url: "<?php echo site_url(); ?>/admin/annual_admin/annual_management_user",
          dataType: "json",
          data: {
            seq: annual_seq
          },
          success: function(data) {
            if(Number(data.month_annual_cnt) + Number(data.annual_cnt) > 0) {
              alert('----');
              return true;
            }
            var type = data.annual_standard;
            var jd = data.join_company_date;
            var standart_year = data.annual_period;
            var join_company_date = new Date(jd);
            if(type == 'calcDt') {
              var selHour = format_date(join_company_date);
              var orgSelMinute = (standard_year - 1)+'-12-31';
              var selMinute = (standard_year-1)+'-12-31';
            }

            var startDate = selHour.replace(/-/g, "");
            var endDate = selMinute.replace(/-/g, "");
            var arrAnnual = calculate.annual(selHour, selMinute);
            if(arrAnnual[0] == 0) {
              var date1 = new Date(selHour);
              var date2 = new Date(selMinute);
              var elapsedMSec = date2.getTime() - date1.getTime();
              var elapsedDay = (elapsedMSec / 1000 / 60/ 60 / 24) + 1;

              var check_num = Math.floor(15*elapsedDay/365) + 0.5;
              var continous_service = (15*elapsedDay/365);

              if(check_num <= continuous_service) {
                continuous_service = Math.round(continuous_service);
              } else {
                continous_service = check_num;
              }

              if(selHour > orgSelMinute){
                arrAnnual[0] = arrAnnual[1];
                arrAnnual[1] = 0;
              } else {
                arrAnnual[0] = Math.floor((365-(elapsedDay))/30);
                arrAnnual[1] = continous_service;
              }

            } else {
              var getDate = new Date();
              getDate = util.getFormatDate(getDate);
              var selHour = format_date(join_company_date);
              var selMinute = format_date(new Date(new Date().getFullYear(),join_company_date.getMonth(),join_company_date.getDate()-1));
              var startDate = selHour.replace(/-/g, "");
              var endDate = selMinute.replace(/-/g, "");
              var arrAnnual = calculate.annual(selHour, selMinute);
              arrAnnual[0] = 0;
            }

          } else {
            var getDate = new Date();
            getDate = util.getFormatDate(getDate);
            var selHour = format_date(join_company_date);
            var selMinute = format_date(new Date(new Date().getFullYear(),join_company_date.getMonth(),join_company_date.getDate()-1));
            var startDate = selHour.replace(/-/g, "");
            var endDate = selMinute.replace(/-/g, "");
            var arrAnnual = calculate.annual(selHour, selMinute);
            arrAnnual[0] = 0;
          }

          $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo site_url(); ?>/admin/annual_admin/user_annual_update",
            dataType: "json",
            data: {
              type: 1,
              seq: annaul_seq,
              month_annual_cnt: arrAnnual[0],
              annual_cnt: arrAnnual[1]
            },
            success: function(data) {

            }
          })
        })
      }
    })
  }

  function round(obj, n, type) {
    if(n != 0) {
      if(type == "round") {
        var num = Number(obj.value);
        $(obj).val(num.toFixed(n));
      } else if (type == "down") {
        var decimal_point = obj.value.indexOf('.');
        var num = (obj.value).substring(0,(decimal_point+n+1));
        $(obj).val(num);
      } else if (type == "up") {
        var decimal_point = obj.value.indexOf('.');
        var num = (obj.value).substring(0,(decimal_point+n+1));
        var up_value = String(Number(num[(decimal_point+n)])+1);
        up_value = num.substr(0,(decimal_point+n)) +up_value + num.substr((decimal_point+n)+up_value.length);
        $(obj).val(up_value);
      }
    } else {
      if(type == 'round') {
        var num = Math.round(obj.value);
        $(obj).val(num);
      } else if (type == 'down') {
        var num = Math.floor(obj.value);
        $(obj).val(num);
      } else if (type == 'up') {
        var num = Math.ceil(obj.value);
        $(obj).val(num);
      }
    }
  }

  function addRow(obj) {
    var tr_name = $(obj).parent().parent().attr('name');
    var tr_last = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
    var tr_last_html = tr_last.outerHTML;
    $(tr_last).after(tr_last_html);
    var new_tr = $('tr[name='+tr_name+']')[$('tr[name='+tr_name+']').length-1];
    $(new_tr).find('img').show();
    for (i=0; i<$(new_tr).find($('input')).length; i++) {
      if($(new_tr).find($('input')).eq(i).val().indexOf('express') != -1) {
        $(new_tr).find($('input')).eq(i).val('');
      }
    }
  }

  function delRow(obj) {
    var tr = $(obj).closest('tr');
    var prev = tr.prev();
    tr.remove();
    for(var i = 0; i < prev.find('input').length; i++) {
      if(prev.find('input').eq(i).attr('onchange') != '' && prev.find('input').eq(i).attr('onchange') != undefined) {
        prev.find('input').eq(i).trigger('change');
      }
    }
  }

  function annual_count() {
    var start_date = new Date($('#annual_start_date').val());
    var end_date = new Date($('#annual_end_date').val());
    var count = 0;

    while(true) {
      var temp_date = start_date;
      if(temp_date.getTime() > end_date.getTime()) {
        break;
      } else {
        var tmp = temp_date.getDay();
        if(tmp == 0 || tmp == 6) {
        } else {
          count ++;
        }
        temp_date.setDate(start_date.getDate() + 1);
      }
    }
    if($('#annaul_type2').val() != '001') {
      count = count * 0.5;
    }
    $('#annual_cnt').val(count);
  }

  function saveGroupModal() {
    var txt = '';
    for(i=0; i<$('.select_group').length; i++){
      var val = $('.select_group').eq(i).text();
      if(i == 0){
        txt += val;
      } else {
        txt += ',' + val;
      }
      $('input[name='+$('#select_user_id').val()+']').val(txt);
      $('#group_tree_modal2').hide();
    }
  }

  function select_user_del(type) {
    if(type == 'all') {
      $('.select_user').remove();
    } else {
      if($('#click_user').attr('class') == 'select_user') {
        $('#click_user').remove();
      }
    }
  }

  function approver_del(type) {
    if(type != undefined) {
      $('.select_approver').remove();
    } else {
      if($('#click_user').attr('class') == 'select_approver') {
        $('#click_user').remove();
        finalReferrer();
      }
    }
  }

  function chkForm(t) {
    if(trim($('#approval_doc_name').val()) == '') {
      $('#approval_doc_name').focus();
      alert();
      return false;
    }
    var check = true;
    $('#formLayoutDiv').find('input, select, textarea').each(function() {
      var tt = jQuery(this);
    })
  }

  function multi_calculation(expression, changeInput, eq) {
    if(eq == 'all') {
      var class_name = expression.replace(/\[/gi, '').replace(/\]/gi, '');
      class_name = class_name.split(',');
      expression = '';
      for(i=0; i<class_name.length; i++) {
        if(isNaN(class_name[i]) == true && /[+=/)(*]/g.test(class_name[i]) == false) {
          class_name[i] = $('.'+class_name[i]);
          var sum = 0;
          for(j=0; j<class_name[i].length; j++) {
            sum += Number(class_name[i].eq(j).val().replace(/,/gi, ''));
          }
          class_name[i] = "(" + sum + ")";
        }
        expression += class_name[i];
      }
      var html_input = $('#html').find($('.'+changeInput)).eq(0);
      html_input.val(eval(expression));
      html_input.trigger('change');
    } else {
      var class_name = $(eq).attr('class').replace('input7','');
      var index = $('.'+class_name).index($(eq));
      expression = expression.split('eq(0)').join('eq('+index+')');
      var html_input = $('#html').find($('.'+changeInput)).eq(index);
      html_input.val(eval(expression));
      html_input.trigger('change');
    }
  }

  function multi_sum(multi_id) {
    var multi_input = multi_id + '_sum';
    var sum_value = 0;

    for(j=0; j<$('.'+multi_id).length; j++){
      sum_value += Number($('.'+multi_id).eq(j).val().replace(/,/gi, ''));
    }
    $('#'+multi_input).val(sum_value);
    $('#'+multi_input).change();
  }

  function referrerSelect(name,obj) {
    var selected = $('#'+name+'_select').val();
    var val = '';
    for(i=0; i<selected.length; i++) {
      if(i==0) {
        val += selected[i];
      } else {
        val += ','+selected[i];
      }
    }
    $('input[name='+name+']').val(val);
  }

  function saveUserModal(){
    var txt = '';
    for(i=0; i<$('.select_user').length; i++) {
      var val = $('.select_user').eq(i).text().split(' ');
      if(i==0) {
        txt += val[0]+' '+val[1];
      } else {
        txt += ',' + val[0] + ' ' + val[1];
      }
      $('input[name='+$('#select_user_id').val()+']').val(txt);
      $('#group_tree_modal').hide();
    }
    var select_id = $('#select_user_id').val() + '_select';
    var txtarr = txt.split(',');
    for(i=0; i<txtarr.length; i++) {
      $('#'+select_id+' > option[value="'+txtarr[i]+'"]').attr('selected', 'selected');
    }
    $('#'+select_id).select2().val(txtarr);
  }

  function viewMore(button) {
    var parentGroup = (button.id).replace('Btn', '');
    if($(button).attr('src')==='<?php echo $misc; ?>img/btn_add.jpg'){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $.ajax({

      })
    }
  }

  function excelExport(event) {
    var input = event.target;
    var reader = new FileReader();
    var rABS = !!reader.readAsBinaryString;
    var len = 0;

    reader.onload = function() {
      var fileData = reader.result;

      if ( ( navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1 ) || ( agent.indexOf('msie') != -1 ) ) {
        var fileData = reade.result;
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

      wb.SheetNames.forEach(function(sheetName) {
        var rowObj = XLSX
      })
    }

  }

  var fileIndex = 0;
  var totalFileSize = 0;
  var fileList = new Array();
  var fileSizeList = new Array();
  var uploadSize = 50;
  var maxUploadSize = 500;

  $(function() {
    fileDropDown();
  });

  function fileDropDown() {
    var dropZone = $('#dropZone');

    dropZone.on('dragenter', function(e) {
      e.stopPropagation();
      e.preventDefault();
      dropZone.css('background-color', '#E3F2FC');
    });
    dropZone.on('dragleave', function(e) {
      e.stopPropagation();
      e.preventDefault();
      dropZone.css('background-color', '#FFFFFF');
    });
    dropZone.on('dragover', function(e) {
      e.stopPropagation();
      e.preventDefault();
      dropZone.css('background-color', '#E3F2FC');
    });
    dropZone.on('drop', function(e) {
      e.preventDefault();
      dropZone.css('background-color', '#FFFFFF');

      var files = e.originalEvent.dataTransfer.files;
      if(files != null) {
        if(files.length < 1) {
          alert('폴더 업로드 불가');
          return;
        }
        selectFile(files);
      } else {
        alert('ERROR');
      }
    });
  }

  function selectFile(files) {
    if(files != null) {
      for(var i = 0; i < files.length; i++) {
        var fileName = files[i].name;
        var fileNameArr = fileName.split('\.');
        var ext = fileNameArr[fileNameArr.length - 1];
        var fileSize = files[i].size / 1024 / 1024;

        if($.inArray(ext, ['exe', 'bat', 'sh', 'java', 'jsp', 'html', 'js', 'css', 'xml']) >= 0) {
          alert('등록 불가 확장자');
          break;
        } else if (fileSize > uploadSize) {
          alert('용량 초과\n업로드 가능 용량 : ' + uploadSize + " MB");
          break;
        } else {
          totalFileSize += fileSize;
          fileList[fileIndex] = files[i];
          fileSizeList[fileIndex] = fileSize;
          addFileList(fileIndex, fileName, fileSize);
          fileIndex ++;
        }
      }
    } else {
      alert("ERROR");
    }
  }

  function addFileList(fIndex, fileName, fileSize) {
    var html = "";
  	html += "<tr id='fileTr_" + fIndex + "'>";
  	html += "    <td class='left' >";
  	html +=         fileName + " / " + fileSize + "MB "  + "<a href='#' onclick='deleteFile(" + fIndex + "); return false;' class='btn small bg_02'><img src='/misc/img/btn_del2.jpg' style='vertical-align:middle;'></a>";
  	html += "    </td>";
  	html += "</tr>";

    $('#fileTableTbody').append(html);
  }

  function deleteFile(fIndex) {
    totalFileSize -= fileSizeList[fIndex];
    delete fileList[fIndex];
    delete fileSizeList[fIndex];
    $('#fileTr_' + fIndex).remove();
  }

  function dbDeleteFile(fIndex) {
    $('#dbfileTr_' + fIndex).remove();
    file_realname[fIndex] = '';
    file_changename[fIndex] = '';
  }

  var chkForm = function() {
    var mform = document.tx_editor_form;

    if(mform.subject.value == '') {
      mform.subject.focus();
      alert('제목을 입력하세요.');
      return false;
    }

    $('#contents').val(Editor.getContent());

    var formData = new FormData(document.getElementById('tx_editor_form'));

    if($('#type').val()==0) {
      file_realname = file_realname.filter(Boolean);
      file_changename = file_changename.filter(Boolean);
      formData.append('file_realname', file_realname.join('*/*'));
      formData.appent('file_changename', file_changename.join('*/*'));
    }

    var uploadFileList = Object.keys(fileList);

    formData.append('file_length', uploadFileList.length);

    if(uploadFileList.length > 0) {
      if(totalFileSize > maxUploadSize) {
        alert('총 용량 초과\n총 업로드 가능 용량 : ' + maxUploadSize + ' MB');
        return;
      }

      for (var i = 0; i < uploadFileList.length; i++) {
        formData.append('files' + i, fileList[uploadFileList[i]]);
      }
    }

    var loc = $('#category_code option:selected').val();

    $.ajax({
      url: request_url,
      data: formData,
      type: 'POST',
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      dataType: 'json',
      cached: false,
      success: function(result) {
        if(result) {
          alert('저장되었습니다.');
          location.href = response_url;
        } else {
          alert('저장에 실패하였습니다. 관리자에게 문의주세요.');
        }
      }
    });
    return false;
  }

  function saveContent() {
    Editor.save();
  }

  function validForm(editor) {
    var validator = new Trex.Validator();
    var content = editor.getContent();
    if (!validator.exists(content)) {
      alert('내용을 입력하세요.');
      return false;
    }

    return true;
  }

  function setForm(editor) {
    var i, input;
    var form = editor.getForm();
    var content = editor.getContent();

    var textarea = document.createElement('textarea');
    textarea.name = 'content';
    textarea.value = content,
    form.createField(textarea);

    var images = editor.getAttachments('image');
    for (i = 0; i < images.length; i++) {
      if (images[i].existStage) {
        alert('attachment information - image[' + i + '] \r\n' + JSON.stringify(images[i].data));
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'attach_image';
        input.value = images[i].data.imageurl;
        form.createField(input);
      }
    }

    var files = editor.getAttachments('file');
    for (i=0; i<files.length; i++) {
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'attach_file';
      input.value = files[i].data.attachurl;
      form.createField(input);
    }
    return true;
  }

  function loadContent() {
    var attachments = {};
    attachments['image'] = [];
    attachments['image'].push({
      'attacher': 'image',
      'data': {
        'imageurl': 'http://cfile273.uf.daum.net/image',
        'filename': 'github.gif',
        'filesize': 59501,
        'originalurl': 'http://cfile273.uf.daum.net/original',
        'thumburl': 'http://cfile273.uf.daum.net/p150X100'
      }
    });
    attachments['file'] = [];
    attachments['file'].push({
      'attacher': 'file',
      'data': {
        'attachurl': 'http://cfile297.uf.daum.net/attach',
        'filememe': 'image/gif',
        'filename': 'editor_bi.gif',
        'filesize': 640
      }
    });

    Editor.modify({
      'attachments': function() {
        var allattachments = [];
        for (var i in attachements) {
          allattachments = allattachments.concat(attachements[i]);
        }
        return allattachments;
      }(),
      'content': document.getElementById('sample_contents_source')
    });
  }

</script>

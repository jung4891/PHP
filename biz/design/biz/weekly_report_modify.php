<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";

//정기점검2 count
if(!empty($current_cnt)){
    foreach($current_cnt as $cnt){
        if($cnt['work_name']=="정기점검2"){
        $cnt2=$cnt['cnt'];
        $cnt2_month=$cnt['month_cnt'];
    }
}

}
if(!empty($next_cnt)){
    foreach($next_cnt as $cnt){
        if($cnt['work_name']=="정기점검2"){
        $n_cnt2=$cnt['cnt'];
        }
    }
}
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
    textarea {
        width:95%;
    }

    .dash_subTitle{
      padding-top: 15px;
      font-size: 16px;
      color: #626262;
      font-weight: bold;
    }
    #totalTable{
      font-family:"Noto Sans KR", sans-serif !important;
    }

    .list_tbl td{
      border: solid #DFDFDF;
      border-width: thin;
      height: 40px;
    }

    .row-color7{
      font-size: 14px;
    }

</style>
<script language="javascript">
function chkForm(type) {
    if (type == 1) {
        if (confirm("정말 삭제하시겠습니까?") == true) {
            var mform = document.cform;
            mform.action = "<?php echo site_url();?>/biz/weekly_report/weekly_report_delete_action";
            mform.submit();
            return false;
        }
    } else {
        var mform = document.cform;

        //결과 입력 안하면 수정 안되게
        for(i=0; i<document.getElementsByName("result").length; i++){
            if(document.getElementsByName("result")[i].value == ""){
                alert("금주의 주간업무 결과를 입력해주세요.");
                document.getElementsByName("result")[i].focus();
                return;
            }
        }

        //금주 update
        if($("#current_update").val() != ''){
            var curObject = new Object();
            var current_doc_total = [];
            var current_update = $("#current_update").val().split(',');
            for (var i = 0; i < current_update.length; i++) {
                if ("<?php echo $view_val['group_name']; ?>" == '기술연구소' ){
                    var tmp_seq = $('#current_doc_' + current_update[i]).find('input[name="seq2"]').val();
                    var tmp_work_name = $('#current_doc_' + current_update[i]).find('select[name="work_name"]').val();
                    var tmp_income_time = $('#current_doc_' + current_update[i]).find('input[name="income_time"]').val();
                    var tmp_customer = $('#current_doc_' + current_update[i]).find('input[name="customer"]').val();
                    var tmp_produce = $('#current_doc_' + current_update[i]).find('textarea[name="produce"]').val();
                    var tmp_subject = $('#current_doc_' + current_update[i]).find('textarea[name="subject"]').val();
                    var tmp_result = $('#current_doc_' + current_update[i]).find('input[name="result"]').val();
                    var tmp_hide = $('#current_doc_' + current_update[i]).find('input[name="hide"]').val();
                    var tmp_completion_time = $('#current_doc_' + current_update[i]).find('input[name="completion_time"]').val();
                    var tmp_writer= $('#current_doc_' + current_update[i]).find('input[name="writer"]').val();
                    var tmp_type= $('#current_doc_' + current_update[i]).find('input[name="type"]').val();
                    current_doc_total[i] = tmp_seq + ";;;"+ tmp_work_name + ";;;"+ tmp_customer + ";;;" + tmp_income_time + ";;;" + tmp_subject + ";;;" + tmp_result + ";;;" + tmp_hide +";;;" + tmp_writer+";;;" +tmp_produce+";;;" +tmp_completion_time+";;;"+tmp_type;
                }else if(("<?php echo $view_val['group_name']; ?>" == '기술본부') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀') || ("<?php echo $view_val['group_name']; ?>" == '기술2팀') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀-2')){
                    var tmp_seq = $('#current_doc_' + current_update[i]).find('input[name="seq2"]').val();
                    var tmp_work_name = $('#current_doc_' + current_update[i]).find('select[name="work_name"]').val();
                    var tmp_produce = $('#current_doc_' + current_update[i]).find('textarea[name="produce"]').val();
                    var tmp_income_time = $('#current_doc_' + current_update[i]).find('input[name="income_time"]').val();
                    var tmp_subject = $('#current_doc_' + current_update[i]).find('textarea[name="subject"]').val();
                    var tmp_result = $('#current_doc_' + current_update[i]).find('textarea[name="result"]').val();
                    var tmp_hide = $('#current_doc_' + current_update[i]).find('input[name="hide"]').val();
                    current_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;"+ tmp_income_time + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_result+";;;"+tmp_hide;
                }else if(("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
                // }else if(("<?php echo $view_val['group_name']; ?>" == '영업본부') || ("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
                    var tmp_seq = $('#current_doc_' + current_update[i]).find('input[name="seq2"]').val();
                    var tmp_income_time = $('#current_doc_' + current_update[i]).find('input[name="income_time"]').val();
                    var tmp_customer = $('#current_doc_' + current_update[i]).find('input[name="customer"]').val();
                    var tmp_visit_company = $('#current_doc_' + current_update[i]).find('input[name="visit_company"]').val();
                    var tmp_subject = $('#current_doc_' + current_update[i]).find('textarea[name="subject"]').val();
                    var tmp_hide = $('#current_doc_' + current_update[i]).find('input[name="hide"]').val();
                    var tmp_writer= $('#current_doc_' + current_update[i]).find('input[name="writer"]').val();
                    if (("<?php echo $view_val['group_name']; ?>" == '경영지원실')) {
                      current_doc_total[i] = tmp_seq + ";;;"+ tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_subject + ";;;" + tmp_hide + ";;;" + tmp_writer;
                    } else {
                      current_doc_total[i] = tmp_seq + ";;;"+ tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_visit_company + ";;;" + tmp_subject + ";;;" + tmp_hide + ";;;" + tmp_writer;
                    }
                }
            }
            curObject.value = current_doc_total;
            current_doc_total = JSON.stringify(curObject);
        }


        //차주 update
        if($("#next_update").val() != ''){
            var nextObject = new Object();
            var next_doc_total = [];
            var next_update = $("#next_update").val().split(',');
            for (var i = 0; i < next_update.length; i++) {
                if ("<?php echo $view_val['group_name']; ?>" == '기술연구소' ){
                    var tmp_seq = $('#next_doc_' + next_update[i]).find('input[name="n_seq"]').val();
                    var tmp_work_name = $('#next_doc_' + next_update[i]).find('select[name="n_work_name"]').val();
                    var tmp_income_time = $('#next_doc_' + next_update[i]).find('input[name="n_income_time"]').val();
                    var tmp_customer = $('#next_doc_' + next_update[i]).find('input[name="n_customer"]').val();
                    var tmp_produce = $('#next_doc_' + next_update[i]).find('textarea[name="n_produce"]').val();
                    var tmp_subject = $('#next_doc_' + next_update[i]).find('textarea[name="n_subject"]').val();
                    var tmp_hide = $('#next_doc_' + next_update[i]).find('input[name="n_hide"]').val();
                    var tmp_completion_time = $('#next_doc_' + next_update[i]).find('input[name="n_completion_time"]').val();
                    var tmp_writer = $('#next_doc_' + next_update[i]).find('input[name="n_writer"]').val();
                    var tmp_type = $('#next_doc_' + next_update[i]).find('input[name="n_type"]').val();
                    next_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_hide + ";;;"+ tmp_completion_time +";;;" + tmp_writer+ ";;;" +tmp_type;
                }else if(("<?php echo $view_val['group_name']; ?>" == '기술본부') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀') || ("<?php echo $view_val['group_name']; ?>" == '기술2팀') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀-2')){
                    var tmp_seq = $('#next_doc_' + next_update[i]).find('input[name="n_seq"]').val();
                    var tmp_work_name = $('#next_doc_' + next_update[i]).find('select[name="n_work_name"]').val();
                    var tmp_income_time = $('#next_doc_' + next_update[i]).find('input[name="n_income_time"]').val();
                    var tmp_customer = $('#next_doc_' + next_update[i]).find('input[name="n_customer"]').val();
                    var tmp_subject = $('#next_doc_' + next_update[i]).find('textarea[name="n_subject"]').val();
                    var tmp_preparations = $('#next_doc_' + next_update[i]).find('textarea[name="n_preparations"]').val();
                    var tmp_hide = $('#next_doc_' + next_update[i]).find('input[name="n_hide"]').val();
                    var tmp_produce = $('#next_doc_' + next_update[i]).find('textarea[name="n_produce"]').val();
                    var tmp_writer = $('#next_doc_' + next_update[i]).find('input[name="n_writer"]').val();
                    next_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_preparations + ";;;"+ tmp_hide +";;;" + tmp_writer;
                }else if(("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
                // }else if(("<?php echo $view_val['group_name']; ?>" == '영업본부') || ("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
                    var tmp_seq = $('#next_doc_' + next_update[i]).find('input[name="n_seq"]').val();
                    var tmp_income_time = $('#next_doc_' + next_update[i]).find('input[name="n_income_time"]').val();
                    var tmp_customer = $('#next_doc_' + next_update[i]).find('input[name="n_customer"]').val();
                    var tmp_visit_company = $('#next_doc_' + next_update[i]).find('input[name="n_visit_company"]').val();
                    var tmp_subject = $('#next_doc_' + next_update[i]).find('textarea[name="n_subject"]').val();
                    var tmp_hide = $('#next_doc_' + next_update[i]).find('input[name="n_hide"]').val();
                    var tmp_writer = $('#next_doc_' + next_update[i]).find('input[name="n_writer"]').val();

                    if (("<?php echo $view_val['group_name']; ?>" == '경영지원실')) {
                      next_doc_total[i] = tmp_seq + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_subject + ";;;" + tmp_hide +";;;" + tmp_writer;
                    } else {
                      next_doc_total[i] = tmp_seq + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_visit_company + ";;;" + tmp_subject + ";;;" + tmp_hide +";;;" + tmp_writer;
                    }

                }

            }
            nextObject.value = next_doc_total;
            next_doc_total = JSON.stringify(nextObject);
        }

        //금주 insert
        var insertObject = new Object();
        var insert_current_doc_total = [];
        for (var i = 0; i < $("#insert_current_doc_cnt").val(); i++) {
          if ("<?php echo $view_val['group_name']; ?>" == '기술연구소' ){
            var tmp_seq = $('#insert_current_doc_' + i).find('input[name="seq2"]').val();
            var tmp_work_name = $('#insert_current_doc_' + i).find('select[name="work_name"]').val();
            var tmp_income_time = $('#insert_current_doc_' + i).find('input[name="income_time"]').val();
            var tmp_customer = $('#insert_current_doc_' + i).find('input[name="customer"]').val();
            var tmp_produce = $('#insert_current_doc_' + i).find('textarea[name="produce"]').val();
            var tmp_subject = $('#insert_current_doc_' + i).find('textarea[name="subject"]').val();
            var tmp_hide = $('#insert_current_doc_' + i).find('input[name="hide"]').val();
            var tmp_type = $('#insert_current_doc_' + i).find('input[name="type"]').val();
            var tmp_result = $('#insert_current_doc_' + i).find('input[name="result"]').val();
            var tmp_completion_time = $('#insert_current_doc_' + i).find('input[name="completion_time"]').val();
            var tmp_writer = $('#insert_current_doc_' + i).find('input[name="writer"]').val();
            insert_current_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_result + ";;;" + tmp_hide+ ";;;"+ tmp_writer+ ";;;"+ tmp_completion_time+ ";;;" +tmp_type;
          }else if(("<?php echo $view_val['group_name']; ?>" == '기술본부') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀') || ("<?php echo $view_val['group_name']; ?>" == '기술2팀') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀-2')){
            var tmp_seq = $('#insert_current_doc_' + i).find('input[name="seq2"]').val();
            var tmp_work_name = $('#insert_current_doc_' + i).find('select[name="work_name"]').val();
            var tmp_income_time = $('#insert_current_doc_' + i).find('input[name="income_time"]').val();
            var tmp_customer = $('#insert_current_doc_' + i).find('input[name="customer"]').val();
            var tmp_produce = $('#insert_current_doc_' + i).find('textarea[name="produce"]').val();
            var tmp_subject = $('#insert_current_doc_' + i).find('textarea[name="subject"]').val();
            var tmp_hide = $('#insert_current_doc_' + i).find('input[name="hide"]').val();
            var tmp_result = $('#insert_current_doc_' + i).find('textarea[name="result"]').val();
            var tmp_writer = $('#insert_current_doc_' + i).find('input[name="writer"]').val();
            insert_current_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_result + ";;;" + tmp_hide+ ";;;"+ tmp_writer;
          }else if(("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
          // }else if(("<?php echo $view_val['group_name']; ?>" == '영업본부') || ("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
            var tmp_seq = $('#insert_current_doc_' + i).find('input[name="seq2"]').val();
            var tmp_income_time = $('#insert_current_doc_' + i).find('input[name="income_time"]').val();
            var tmp_customer = $('#insert_current_doc_' + i).find('input[name="customer"]').val();
            var tmp_visit_company = $('#insert_current_doc_' + i).find('input[name="visit_company"]').val();
            var tmp_subject = $('#insert_current_doc_' + i).find('textarea[name="subject"]').val();
            var tmp_hide = $('#insert_current_doc_' + i).find('input[name="hide"]').val();
            var tmp_writer = $('#insert_current_doc_' + i).find('input[name="writer"]').val();
            if (("<?php echo $view_val['group_name']; ?>" == '경영지원실')) {
              insert_current_doc_total[i] = tmp_seq + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_subject + ";;;" + tmp_hide+ ";;;"+ tmp_writer;
            } else {
              insert_current_doc_total[i] = tmp_seq + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_visit_company + ";;;" + tmp_subject + ";;;" + tmp_hide+ ";;;"+ tmp_writer;
            }
          }
        }
        insertObject.value = insert_current_doc_total;
        insert_current_doc_total = JSON.stringify(insertObject);

        //차주 insert
        var insertNextObject = new Object();
        var insert_next_doc_total = [];
        for (var i = 0; i < $("#insert_next_doc_cnt").val(); i++) {
          if ("<?php echo $view_val['group_name']; ?>" == '기술연구소' ){
              var tmp_seq = $('#insert_next_doc_' + i).find('input[name="seq2"]').val();
              var tmp_work_name = $('#insert_next_doc_' + i).find('select[name="n_work_name"]').val();
              var tmp_income_time = $('#insert_next_doc_' + i).find('input[name="n_income_time"]').val();
              var tmp_customer = $('#insert_next_doc_' + i).find('input[name="n_customer"]').val();
              var tmp_produce = $('#insert_next_doc_' + i).find('textarea[name="n_produce"]').val();
              var tmp_subject = $('#insert_next_doc_' + i).find('textarea[name="n_subject"]').val();
              var tmp_hide = $('#insert_next_doc_' + i).find('input[name="n_hide"]').val();
              var tmp_completion_time = $('#insert_next_doc_' + i).find('input[name="n_completion_time"]').val();
              var tmp_type = $('#insert_next_doc_' + i).find('input[name="n_type"]').val();
              var tmp_writer = $('#insert_next_doc_' + i).find('input[name="n_writer"]').val();
              insert_next_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_hide + ";;;" + tmp_writer + ";;;" + tmp_completion_time+ ";;;" +tmp_type;
          }else if(("<?php echo $view_val['group_name']; ?>" == '기술본부') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀') || ("<?php echo $view_val['group_name']; ?>" == '기술2팀') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀-2')){
              var tmp_seq = $('#insert_next_doc_' + i).find('input[name="seq2"]').val();
              var tmp_work_name = $('#insert_next_doc_' + i).find('select[name="n_work_name"]').val();
              var tmp_income_time = $('#insert_next_doc_' + i).find('input[name="n_income_time"]').val();
              var tmp_customer = $('#insert_next_doc_' + i).find('input[name="n_customer"]').val();
              var tmp_produce = $('#insert_next_doc_' + i).find('textarea[name="n_produce"]').val();
              var tmp_subject = $('#insert_next_doc_' + i).find('textarea[name="n_subject"]').val();
              var tmp_hide = $('#insert_next_doc_' + i).find('input[name="n_hide"]').val();
              var tmp_preparations = $('#insert_next_doc_' + i).find('textarea[name="n_preparations"]').val();
              var tmp_writer = $('#insert_next_doc_' + i).find('input[name="n_writer"]').val();
              insert_next_doc_total[i] = tmp_seq + ";;;" + tmp_work_name + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_produce + ";;;" + tmp_subject + ";;;" + tmp_preparations + ";;;" + tmp_hide + ";;;" + tmp_writer;
          }else if(("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
          // }else if(("<?php echo $view_val['group_name']; ?>" == '영업본부') || ("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실')){
              var tmp_seq = $('#insert_next_doc_' + i).find('input[name="seq2"]').val();
              var tmp_income_time = $('#insert_next_doc_' + i).find('input[name="n_income_time"]').val();
              var tmp_customer = $('#insert_next_doc_' + i).find('input[name="n_customer"]').val();
              var tmp_visit_company = $('#insert_next_doc_' + i).find('input[name="n_visit_company"]').val();
              var tmp_subject = $('#insert_next_doc_' + i).find('textarea[name="n_subject"]').val();
              var tmp_hide = $('#insert_next_doc_' + i).find('input[name="n_hide"]').val();
              var tmp_writer = $('#insert_next_doc_' + i).find('input[name="n_writer"]').val();

              if (("<?php echo $view_val['group_name']; ?>" == '경영지원실')) {
                insert_next_doc_total[i] = tmp_seq + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_subject + ";;;" + tmp_hide + ";;;" + tmp_writer;
              } else {
                insert_next_doc_total[i] = tmp_seq + ";;;" + tmp_income_time + ";;;" + tmp_customer + ";;;" + tmp_visit_company + ";;;" + tmp_subject + ";;;" + tmp_hide + ";;;" + tmp_writer;
              }
          }
        }

        insertNextObject.value = insert_next_doc_total;
        insert_next_doc_total = JSON.stringify(insertNextObject);
        $('#current_doc_total').val(current_doc_total);
        $('#next_doc_total').val(next_doc_total);
        $('#insert_next_doc_total').val(insert_next_doc_total);
        $('#insert_current_doc_total').val(insert_current_doc_total);

        mform.action = "<?php echo site_url();?>/biz/weekly_report/weekly_report_modify_action";
        mform.submit();
        return false;
    }
}

function document_del(idx, type, seq) {
    if (type == 0) { //type = 0 차주 삭제
        if ($("#next_del_seq").val() == "") {
            $("#next_del_seq").val($("#next_del_seq").val() + seq);
        } else {
            $("#next_del_seq").val($("#next_del_seq").val() + ',' + seq);
        }
        $("#next_doc_" + idx).remove();
        $("#tr_next_doc_" + idx).remove();
    } else if (type == 2) { // 금주 삭제
        if ($("#del_seq").val() == "") {
            $("#del_seq").val($("#del_seq").val() + seq);
        } else {
            $("#del_seq").val($("#del_seq").val() + ',' + seq);
        }
        $("#current_doc_" + idx).remove();
        $("#tr_current_doc_" + idx).remove();
        // console.log($("#del_seq").val())
        // alert('here');
        // $.ajax({
        //     url : "/index.php/biz/weekly_report/change_sch_report_N_action",
        //     type : "POST",
        //     dataType : "json",
        //     data : {
        //         seq: seq
        //     },
        //     cache:false,
        //     async:false,
        //     success : function(data) {
        //         // successCallback(data);
        //         // alert('clear');
        //   }
        // });

    } else { //type = 1  추가하고 수정안누른거 삭제
        if(seq == "0"){
            $("#insert_current_doc_" + idx).remove();
            $("#tr_insert_current_doc_" + idx).remove();
            $("#insert_current_doc_cnt").val(Number(Number($("#insert_current_doc_cnt").val()) - Number(1)));

        }else{ //1=next
            $("#insert_next_doc_" + idx).remove();
            $("#tr_insert_next_doc_" + idx).remove();
            $("#insert_next_doc_cnt").val(Number(Number($("#insert_next_doc_cnt").val()) - Number(1)));
        }
    }
}

function document_add(type) {
    if ( "<?php echo $view_val['group_name']; ?>" == '기술연구소' ){
        if(type == 1){//금주
            var id = "insert_current_doc_" + $("#insert_current_doc_cnt").val();
            var idx = $("#insert_current_doc_cnt").val();

            $("#insert_current_doc_cnt").val(Number(Number($("#insert_current_doc_cnt").val()) + Number(1)));
            $('#current_insert_before').before("<tr id=" + id + "><input type='hidden' id='seq2' name='seq2'><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='checkbox' name='hide' value='N' onchange='hide_check(this);' /></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><select name='work_name' class='input7'><option value='신규개발'>신규개발</option><option value='버그수정'>버그수정</option><option value='기능개선'>기능개선</option></select></td><td colspan='1' height='20' align='center' bgcolor='f8f8f9' style='font-weight:bold;' class='t_border'><input type='date' id='income_time' name='income_time' class='input7'></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='customer' name='customer' class='input7' style='width:90%'/></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='type' name='type' class='input7' style='width:90%'/></td><td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='produce' name='produce' class='input7_tmp'></textarea></td> <td colspan='4' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='subject' name='subject' class='input7_tmp'></textarea></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='text' id='result' name='result' class='input7' style='width:90%'></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='completion_time' name='completion_time' class='input7'></td><td colspan='1' height='20' align='center' style='width:38px;font-weight:bold;'><input type='text' id='writer' name='writer' class='input7' style='width:90%'></td><td height='20' align='center' style='font-weight:bold;' class='t_border' ><img onClick='document_del(" + idx + "," + '1'+","+'0' + ");'  src='<?php echo $misc;?>img/btn_del.jpg' id='doc_del' name='doc_del' style='cursor:pointer;' /></td><input type='hidden' value='0'><tr id='tr_" + id + "'></tr>");

        }else{//차주
            var id = "insert_next_doc_" + $("#insert_next_doc_cnt").val();
            var idx = $("#insert_next_doc_cnt").val();

            $("#insert_next_doc_cnt").val(Number(Number($("#insert_next_doc_cnt").val()) + Number(1)));
            $('#doc_data_field').before("<tr id=" + id + "><input type='hidden' id='seq2' name='seq2'><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='checkbox' name='n_hide' value='N' onchange='hide_check(this);' /></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><select name='n_work_name' class='input7'><option value='신규개발'>신규개발</option><option value='버그수정'>버그수정</option><option value='기능개선'>기능개선</option></select></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='n_income_time' name='n_income_time' class='input7' ></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='n_customer' name='n_customer' class='input7' style='width:90%' /></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='n_type' name='n_type' class='input7' style='width:90%' /></td><td colspan='4' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_produce' name='n_produce' class='input7_tmp'></textarea></td><td colspan='4' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_subject' class='input7_tmp' name='n_subject'></textarea></td><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='n_completion_time' name='n_completion_time' class='input7' ></td><td height='20' align='center' style='width:38px;font-weight:bold;'><input type='text' id='n_writer' name='n_writer' class='input7' style='width:90%'></td><td height='20' align='center' style='font-weight:bold;' class='t_border' ><img onClick='document_del(" + idx + "," + '1'+","+'1' + ");'  src='<?php echo $misc;?>img/btn_del.jpg' id='doc_del' name='doc_del' style='cursor:pointer;' /></td><input type='hidden' value='0'><tr id='tr_" + id + "'></tr>");
        }
    }else if(("<?php echo $view_val['group_name']; ?>" == '기술본부') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀') || ("<?php echo $view_val['group_name']; ?>" == '기술2팀') || ("<?php echo $view_val['group_name']; ?>" == '기술1팀-2')){
        if(type == 1){//금주
            var id = "insert_current_doc_" + $("#insert_current_doc_cnt").val();
            var idx = $("#insert_current_doc_cnt").val();

            $("#insert_current_doc_cnt").val(Number(Number($("#insert_current_doc_cnt").val()) + Number(1)));
            $('#current_insert_before').before("<tr id=" + id + "><input type='hidden' id='seq2' name='seq2'><td height='20' align='center' style='font-weight:bold;' class='t_border'><input type='checkbox' name='hide' value='N' onchange='hide_check(this);' /></td></td><td height='20' align='center' style='font-weight:bold;' class='t_border'><select name='work_name' class='input7'><?php foreach($work_name as $w_name){?><option value='<?php echo $w_name['work_name'];?>'><?php echo $w_name['work_name'];?></option><?php } ?></select></td><td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='income_time' name='income_time' class='input7' ></td><td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><select id='customer_select' class='input7' onmouseover='selectbox_search(this);' onchange='dataUpdate("+'"cur"'+",0,this.value,"+idx+");'><option value=''>고객사선택</option><option value='direct'>직접입력</option><?php foreach($customer as $ct){ echo "<option value='{$ct['customer']}'>{$ct['customer']}</option>";} ?></select><input type='text' id='customer' name='customer' class='input7' style='display:none;'></td><td colspan='6' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='produce' name='produce' class='input7_tmp'></textarea></td><td colspan='4' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='subject' name='subject' class='input7_tmp'></textarea></td><td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='result' name='result' class='input7_tmp'></textarea></textarea></td><td height='20' align='center' style='width:38px;font-weight:bold;'><input type='text' id='writer' name='writer' style='width:90%'></td><td height='20' align='center' style='font-weight:bold;' class='t_border' ><img onClick='document_del(" + idx + "," + '1'+","+'0'+ ");' src='<?php echo $misc;?>img/btn_del.jpg' id='doc_del' name='doc_del' style='cursor:pointer;' /></td><input type='hidden' value='0'><tr id='tr_" + id + "'></tr>");

        }else{//차주
            var id = "insert_next_doc_" + $("#insert_next_doc_cnt").val();
            var idx = $("#insert_next_doc_cnt").val();

            $("#insert_next_doc_cnt").val(Number(Number($("#insert_next_doc_cnt").val()) + Number(1)));
            $('#doc_data_field').before("<tr id=" + id + "><input type='hidden' id='seq2' name='seq2'><td height='20' align='center' style='font-weight:bold;' class='t_border'><input type='checkbox' name='n_hide' value='N' onchange='hide_check(this);' /></td><td height='20' align='center' style='font-weight:bold;' class='t_border'><select name='n_work_name' class='input7'><?php foreach($work_name as $w_name){?><option value='<?php echo $w_name['work_name'];?>'><?php echo $w_name['work_name'];?></option><?php } ?></select></td><td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='n_income_time' name='n_income_time' class='input7' ></td><td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><select id='n_customer_select' class='input7' onmouseover='selectbox_search(this);' onchange='dataUpdate("+'"next"'+",0,this.value,"+idx+");'><option value=''>고객사선택</option><option value='direct'>직접입력</option><?php foreach($customer as $ct){ echo "<option value='{$ct['customer']}'>{$ct['customer']}</option>";} ?></select><input type='text' id='n_customer' name='n_customer' class='input7' style='display:none;'></td><td colspan='6' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_produce' name='n_produce' class='input7_tmp'></textarea></td><td colspan='4' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_subject' name='n_subject' class='input7_tmp'></textarea></td><td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_preparations' name='n_preparations' class='input7_tmp'></textarea></td><td height='20' align='center' style='width:38px;font-weight:bold;'><input type='text' id='n_writer' name='n_writer' style='width:90%'></td><td height='20' align='center' style='font-weight:bold;' class='t_border' ><img onClick='document_del(" + idx + "," + '1'+","+'1' + ");'  src='<?php echo $misc;?>img/btn_del.jpg' id='doc_del' name='doc_del' style='cursor:pointer;' /></td><input type='hidden' value='0'><tr id='tr_" + id + "'></tr>");
        }
    }else if(("<?php echo $view_val['group_name']; ?>" == '사업1부') || ("<?php echo $view_val['group_name']; ?>" == '사업2부') || ("<?php echo $view_val['group_name']; ?>" == '경영지원실') ){

      if(type == 1){//금주
          var id = "insert_current_doc_" + $("#insert_current_doc_cnt").val();
          var idx = $("#insert_current_doc_cnt").val();

          if (("<?php echo $view_val['group_name']; ?>" == '경영지원실')) {
            var insert_form = "<td colspan='4' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='customer' name='customer' class='input7' style='width:90%'/></td><td colspan='9' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='subject' name='subject' class='input7_tmp' height:'25px'; ></textarea></td>";
          } else {
            var insert_form = "<td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='customer' name='customer' class='input7' style='width:90%'/></td><td colspan='2' height='20' align='center'  style='font-weight:bold;' class='t_border'><input id='visit_company' name='visit_company' class='input7' style='width:90%'/></td><td colspan='9' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='subject' name='subject' class='input7_tmp' height:'25px'; ></textarea></td>";
          }

          $("#insert_current_doc_cnt").val(Number(Number($("#insert_current_doc_cnt").val()) + Number(1)));
          $('#current_insert_before').before("<tr id=" + id + "><input type='hidden' id='seq2' name='seq2'><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='checkbox' name='hide' value='N' onchange='hide_check(this);' /></td><td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='income_time' name='income_time' class='input7'></td>"+insert_form+"<td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='text' id='writer' name='writer' class='input7' style='width:90%'></td><td height='20' align='center' style='font-weight:bold;' class='t_border' ><img onClick='document_del(" + idx + "," + '1' + "," + '0' + ");'  src='<?php echo $misc;?>img/btn_del.jpg' id='doc_del' name='doc_del' style='cursor:pointer;' /></td><input type='hidden' value='0'><tr id='tr_" + id + "'></tr>");

      }else{//차주
          var id = "insert_next_doc_" + $("#insert_next_doc_cnt").val();
          var idx = $("#insert_next_doc_cnt").val();

          if (("<?php echo $view_val['group_name']; ?>" == '경영지원실')) {
            var insert_form = "<td colspan='4' height='20' align='center' bgcolor='f8f8f9' style='font-weight:bold;' class='t_border'><input id='n_customer' name='n_customer' class='input7' style='width:90%'/></td><td colspan='9' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_subject' name='n_subject' class='input7_tmp' style='height:80%;'></textarea></td>";
          } else {
            var insert_form = "<td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='n_customer' name='n_customer' class='input7' style='width:90%'/></td><td colspan='2' height='20' align='center' style='font-weight:bold;' class='t_border'><input id='n_visit_company' name='n_visit_company' class='input7' style='width:90%'/></td><td colspan='9' height='20' align='center' style='font-weight:bold;' class='t_border'><textarea id='n_subject' name='n_subject' class='input7_tmp' style='height:80%;'></textarea></td>";
          }

          $("#insert_next_doc_cnt").val(Number(Number($("#insert_next_doc_cnt").val()) + Number(1)));
          $('#doc_data_field').before("<tr id=" + id + "><input type='hidden' id='seq2' name='seq2'><td colspan='1' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='checkbox' name='n_hide' value='N' onchange='hide_check(this);' /></td><td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='date' id='n_income_time' name='n_income_time' class='input7'></td>"+insert_form+"<td colspan='3' height='20' align='center' style='font-weight:bold;' class='t_border'><input type='text' id='n_writer' name='n_writer' class='input7' style='width:90%'></td><td height='20' align='center' style='font-weight:bold;' class='t_border' ><img onClick='document_del(" + idx + "," + '1' + "," + '1' + ");'  src='<?php echo $misc;?>img/btn_del.jpg' id='doc_del' name='doc_del' style='cursor:pointer;' /></td><input type='hidden' value='0'><tr id='tr_" + id + "'></tr>");
      }
    }
    $("#sidebar_left").height($("#main_contents").height());
    $(".sidebar_sub_on").height($("#main_contents").height());
}

</script>

<body>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
    <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
        <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>
        <tr height="5%">
          <td class="dash_title">
            주간업무보고
          </td>
        </tr>
          <tr>
            <td class="dash_subTitle">
              <?php echo substr($view_val['s_date'],0,4)."년 ".$view_val['month']."월 ".$view_val['week']."주차 {$view_val['group_name']} 주간 업무 보고";?>
            </td>
          </tr>
          <tr>
              <td align="right">

                  <?php if($name == $view_val['writer'] || $tech_lv == 3) {?>
                    <button type="button" class="btn-common btn-color1" name="button" onClick="javascript:chkForm(0);return false;"/>수정</button>
                    <button type="button" class="btn-common btn-color1" name="button" onClick="javascript:chkForm(1);return false;"/>삭제</button>
                      <?php }?>
                  <button type="button" name="button"  class="btn-common btn-color2" onClick="javascript:history.go(-1);"/>목록</button>
              </td>
          </tr>
        <tr>
            <td align="center" valign="top">
                <table width="100%" height="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100%" align="center" valign="top">
                            <!-- 시작합니다. 여기서 부터  -->
                            <form name="cform" method="post">
                                <input type="hidden" name="seq" value="<?php echo $seq;?>">
                                <input type="hidden" name="group_name" value="<?php echo $view_val['group_name'];?>">
                                <input type="hidden" name="mode" value="modify">
                                <input type="hidden" name="year" value="<?php echo $view_val['year'];?>">
                                <input type="hidden" name="month" value="<?php echo $view_val['month'];?>">
                                <input type="hidden" name="week" value="<?php echo $view_val['week'];?>">
                                <input type="hidden" id="current_doc_cnt" value="<?php echo $current_total[0]['sum']?>">
                                <input type="hidden" id="next_doc_cnt" value="<?php echo $next_total[0]['sum']?>">
                                <input type="hidden" id="insert_current_doc_cnt" value=0>
                                <input type="hidden" id="insert_next_doc_cnt" value=0>
                                <input type="hidden" id="current_doc_total" name="current_doc_total">
                                <input type="hidden" id="next_doc_total" name="next_doc_total">
                                <input type="hidden" id="insert_next_doc_total" name="insert_next_doc_total">
                                <input type="hidden" id="insert_current_doc_total" name="insert_current_doc_total">
                                <input type="hidden" id="next_del_seq" name="next_del_seq" />
                                <input type="hidden" id="del_seq" name="del_seq" />

                                <!-- update하는 seq 가져오는거임 ! -->
                                <input type="hidden" id="current_update" name="current_update" />
                                <input type="hidden" id="next_update" name="next_update" />


                                <table width="100%" border="0" style="margin-top:20px;" class="list_tbl">
                                  <tr>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <colgroup>
                                                <?php
                                                $col_lenth = ($view_val['group_name'] == '기술연구소') ? 16 : 21;
                                                for($i=1; $i<=$col_lenth; $i++){
                                              ?>
                                                    <col width="<?php echo (100/$col_lenth); ?>%" />
                                                <?php } ?>
                                            </colgroup>
                                            <tr class="t_top row-color7">
                                                <td colspan="<?php echo $col_lenth ?>" height="15" align="center" style="font-weight:bold;"
                                                    class="t_border">
                                                    <?php echo $view_val['year']."년 ".$view_val['month']."월 ".$view_val['week']."주차 실적 보고 (".substr($view_val['s_date'],5,5)." ~ ".substr($view_val['e_date'],5,5).")";?>
                                                </td>
                                            </tr>
<?php if (strpos($view_val['group_name'],"기술") !== false && $view_val['group_name'] <> '기술연구소'){ ?>
                                              <tr class="t_top row-color1">
<?php foreach($current_cnt as $cnt){
  if( $cnt['work_name'] != "정기점검2"){
?>
                                                    <td colspan="2" width="11%" height="30" align="center"
                                                      style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['work_name'];?></td>
<?php }}?>
                                                    <td colspan="3" width="11%" height="30" align="center" style="font-weight:bold;" class="t_border">전체 지원 건수</td>
                                                </tr>

                                                <tr>
<?php for($i=0; $i<10; $i++){
  if($i != 9){
?>
                                                    <td height="30" width="<?php echo (100/21); ?>%" align="center" style="font-weight:bold;" class="t_border"><?php echo "금주";?></td>
                                                    <td height="30" width="<?php echo (100/21); ?>%" align="center" style="font-weight:bold;" class="t_border"><?php echo "금월";?></td>
<?php }else{?>
                                                    <td height="30" width="<?php echo (100/21); ?>%" align="center" style="font-weight:bold;" class="t_border"><?php echo "금주";?></td>
                                                    <td colspan=2 width="<?php echo (100/21); ?>%" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금월";?></td>

<?php }} ?>
                                                </tr>
                                                <tr>
<?php
$current_sum = 0;
$month_current_sum =0;
foreach($current_cnt as $cnt){
  if($cnt['month_cnt'] == null){
    $cnt['month_cnt'] =0;
  }
  if($cnt['cnt'] == null){
    $cnt['cnt'] =0;
  }

  if($cnt['work_name'] != "정기점검2"){
    if($cnt['work_name'] == "정기점검"){
?>
                                                    <td height="30" align="center" style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['cnt']+$cnt2;?>
                                                    </td>
                                                    <td height="30" align="center" style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['month_cnt']+$cnt2_month ;?>
                                                    </td>
<?php
    }else{
?>
                                                    <td height="30" align="center" style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['cnt'];?>
                                                    </td>
                                                    <td height="30" align="center" style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['month_cnt'] ;?>
                                                    </td>
<?php
    }
  }
    $month_current_sum += $cnt['month_cnt'];
    $current_sum+=$cnt['cnt'];
  }
?>
                                                    <td height="30" align="center" style="font-weight:bold;" class="t_border">
                                                        <?php echo $current_sum;?>
                                                    </td>
                                                    <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border">
                                                        <?php echo $month_current_sum;?>
                                                    </td>
                                                </tr>

                                                <tr class="t_top row-color1">
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">숨김</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">구분</td>
                                                    <td colspan="2" align="center" style="font-weight:bold;" class="t_border" >작업일</td>
                                                    <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">고객사</td>
                                                    <td colspan="6" height="20" align="center" style="font-weight:bold;" class="t_border">제품명/host/버전/서버/라이선스</td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">주요내용</td>
                                                    <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border" >결과</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">담당SE</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_add(1);" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                                                    </td>
                                                </tr>

<!-- 반복 구간 -->
<?php
	if(!empty($current_doc)){
		$i=0;
		foreach($current_doc as $key){
?>

                                                <tr id="current_doc_<?php echo $i;?>">
                                                    <input type="hidden" name="seq2" value="<?php echo $key['seq'];?>" />
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="checkbox" name="hide" value="<?php echo $key['hide']?>" onchange="hide_check(this);currentUpdate(<?php echo $i; ?>);" <?php if($key['hide'] == "Y"){echo "checked";} ?> />
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <select name="work_name" class="input7" onchange="currentUpdate(<?php echo $i; ?>)">
                                                            <?php foreach($work_name as $w_name){?>
                                                                <option value="<?php echo $w_name['work_name'];?>"
                                                                <?php if( $w_name['work_name'] == $key['work_name']){echo "selected" ;} ?>>
                                                                <?php echo $w_name['work_name'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <!-- <?php echo $key['work_name'];?> -->
                                                    </td>
                                                    <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border" >
                                                        <input type="date" name="income_time" class="input7" value="<?php echo substr($key['income_time'], 0, 10); ?>"  onchange="currentUpdate(<?php echo $i; ?>)">
                                                    </td>
                                                    <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border"><?php echo $key['customer'];?></td>
                                                    <td colspan="6" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <textarea name="produce" value="<?php echo $key['produce'];?>" class="input7_tmp" rows="<?php echo strlen($key['produce'])/20+1;?>" onchange="currentUpdate(<?php echo $i; ?>)" ><?php echo $key['produce'];?></textarea>
                                                    </td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <!-- <input type="text" id="subject" name="subject" value="<?php echo $key['subject'];?>" class="input7"> -->
                                                        <textarea name="subject" value="<?php echo $key['subject'];?>" class="input7_tmp" rows="<?php echo strlen($key['subject'])/20+1;?>" onchange="currentUpdate(<?php echo $i; ?>)" ><?php echo $key['subject'];?></textarea>
                                                    </td>
                                                    <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <textarea name="result" value="<?php echo $key['result'];?>" class="input7_tmp" rows="<?php echo strlen($key['result'])/20+1;?>" onchange="currentUpdate(<?php echo $i; ?>)"><?php echo $key['result'];?></textarea>
                                                        <!-- <input type="text" id="result" name="result" value="<?php echo $key['result'];?>" class="input7"> -->
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border"><?php echo $key['writer'];?></td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_del(<?php echo $i;?>,2,<?php echo $key['seq'];?>);" src="<?php echo $misc;?>img/btn_del.jpg" id="doc_del" name="doc_del" style="cursor:pointer;" />
                                                    </td>
                                                    <input type="hidden" value="1">
<?php
      $i++;
    }
  }
?>
<!-- 반복구간 끝 -->
                                                <tr id="current_insert_before">
                                                    <!-- <td colspan="21" height="2" bgcolor="#797c88"></td> -->
                                                </tr>
                                                <tr>
                                                    <td colspan="21" height="45" align="center" bgcolor="f8f8f9"
                                                        style="font-weight:bold;" class="t_border"></td>
                                                </tr>
                                                <!-- 차주 보고 -->
                                                <tr class="t_top row-color7">
                                                    <td colspan="21" height="15" align="center" style="font-weight:bold;" class="t_border">
                                                        <!-- <?php echo $view_val['year']."년 ".$view_val['month']."월 ".($view_val['week']+1)."주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?> -->
                                                        <?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date'])))."년 ".date("m",strtotime("+7 day",strtotime($view_val['s_date'])))."월 "?>
                                                        <span id="next_week"></span>
                                                        <?php echo "주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?>
                                                    </td>
                                                </tr>
                                                <tr class="t_top row-color1">
<?php
  if(!empty($next_cnt)){
  foreach($next_cnt as $cnt){
    if( $cnt['work_name'] != "정기점검2"){
?>
                                                    <td colspan="2" width="11%" height="30" align="center"
                                                        style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['work_name'];?></td>
<?php }}}?>
                                                    <td colspan="3" height="30" align="center"
                                                        style="font-weight:bold;" class="t_border">전체 지원 건수</td>
                                                </tr>
                                                <tr>
<?php
  $n_sum=0;
  if(!empty($next_cnt)){
  foreach($next_cnt as $cnt){
    if($cnt['cnt'] == null){
      $cnt['cnt'] = 0;
    }
    if( $cnt['work_name'] != "정기점검2"){
      if($cnt['work_name'] == "정기점검"){
?>
                                                    <td colspan="2" width="11%" height="30" align="center"
                                                        style="font-weight:bold;" class="t_border">
                                                        <?php echo ($cnt['cnt'])+($n_cnt2);?></td>
<?php
      }else{
?>
                                                    <td colspan="2" width="11%" height="30" align="center"
                                                        style="font-weight:bold;" class="t_border">
                                                        <?php echo $cnt['cnt'];?></td>
<?php
      }
    }
    $n_sum+=$cnt['cnt'];
  }}
?>
                                                    <td colspan="3" height="30" align="center"
                                                        style="font-weight:bold;" class="t_border"><?php echo $n_sum ?>
                                                    </td>
                                                </tr>

                                             <tr class="t_top row-color1">
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">숨김</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">구분</td>
                                                    <td colspan="2" align="center" style="font-weight:bold;" class="t_border" >작업일</td>
                                                    <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">고객사</td>
                                                    <td colspan="6" height="20" align="center" style="font-weight:bold;" class="t_border">제품명/host/버전/서버/라이선스</td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">주요내용</td>
                                                    <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">준비사항</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">담당SE</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_add(2);" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                                                    </td>
                                                </tr>
                                                <!-- 반복 구간 -->
<?php
	if(!empty($next_doc)){
	$i=0;
	foreach($next_doc as $key){
?>
                                                <tr id="next_doc_<?php echo $i;?>">
                                                    <input type="hidden" name="n_seq" class="input7" value="<?php echo $key['seq'];?>">
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="checkbox" name="n_hide" value="<?php echo $key['hide']?>" onchange="hide_check(this);nextUpdate(<?php echo $i; ?>);" <?php if($key['hide'] == "Y"){echo "checked";} ?> />
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <select name="n_work_name" class="input7" onchange="nextUpdate(<?php echo $i; ?>);" >
                                                            <?php foreach($work_name as $w_name){?>
                                                            <option value="<?php echo $w_name['work_name'];?>"
                                                                <?php if( $w_name['work_name'] == $key['work_name']){echo "selected" ;} ?>>
                                                                <?php echo $w_name['work_name'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="date" name="n_income_time" class="input7" onchange="nextUpdate(<?php echo $i; ?>);" value="<?php echo substr($key['income_time'], 0, 10); ?>">
                                                    </td>
                                                    <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <select class="input7" onchange="nextUpdate(<?php echo $i; ?>); dataUpdate('next','1',this.value,<?php echo $i;?>);" onmouseover ="selectbox_search(this);">
                                                        <option value=''<?php if($key['customer'] == ''){echo "selected";} ?>>고객사선택</option>
                                                        <option value="direct">직접입력</option>
                                                        <?php
                                                            $direct_check=false;
                                                            foreach($customer as $ct){
                                                                echo "<option value='{$ct['customer']}'";
                                                                if($ct['customer'] == $key['customer']){
                                                                    echo "selected";
                                                                    $direct_check=true;
                                                                }
                                                                echo ">{$ct['customer']}</option>";
                                                            }
                                                        ?>
                                                        <option value="direct" <?php if($direct_check == 0){echo 'selected';} ?>>직접입력</option>
                                                        </select>
                                                        <input type="text" name="n_customer" class="input7" onchange="nextUpdate(<?php echo $i; ?>);" value="<?php echo $key['customer'];?>" style="<?php if($direct_check == 1){echo 'display:none';} ?>">
                                                    </td>
                                                    <td colspan="6" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <textarea name="n_produce" class="input7_tmp" onchange="nextUpdate(<?php echo $i; ?>);" rows="<?php echo strlen($key['produce'])/20+1;?>" ><?php echo $key['produce'];?></textarea>
                                                    </td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <!-- <input type="text" id="n_subject" name="n_subject" class="input7" value="<?php echo $key['subject'];?>"> -->
                                                        <textarea name="n_subject" class="input7_tmp" onchange="nextUpdate(<?php echo $i; ?>);" rows="<?php echo strlen($key['subject'])/20+1;?>" ><?php echo $key['subject'];?></textarea>
                                                    </td>
                                                    <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <!-- <input type="text" id="n_preparations" name="n_preparations" class="input7" value="<?php echo $key['preparations'];?>"> -->
                                                        <textarea name="n_preparations" class="input7_tmp" onchange="nextUpdate(<?php echo $i; ?>);" rows="<?php echo strlen($key['preparations'])/20+1;?>" ><?php echo $key['preparations'];?></textarea>
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="n_writer" onchange="nextUpdate(<?php echo $i; ?>);" value="<?php echo $key['writer'];?>" style="width:90%;">
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_del(<?php echo $i;?>,0,<?php echo $key['seq'];?>);" src="<?php echo $misc;?>img/btn_del.jpg" id="doc_del" name="doc_del" style="cursor:pointer;" />
                                                    </td>
                                                    <input type="hidden" value="1">
                                                </tr>
  <?php
	$i++;
	}
	}?>

                                                <!-- 반복구간 끝 -->
<!-- 여기서부터 기술연구소 -->
<?php //}else{ ?>
<?php }else if(($view_val['group_name'] == '기술연구소' )){ ?>

                                                    <tr class="row-color1">
                                                        <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border">
                                                            신규개발
                                                        </td>
                                                        <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border">
                                                            버그수정
                                                        </td>
                                                        <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border">
                                                            기능개선
                                                        </td>
                                                        <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border">
                                                            전체 개발 건수
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금월";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금주";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금월";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금주";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금월";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금주";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금월";?></td>
                                                        <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo "금주";?></td>
                                                    </tr>

<?php
$month_total_cnt=0;
$week_total_cnt=0;
$improvement=array();
$new=array();
$bug=array();
if(!empty($current_cnt)){
foreach($current_cnt as $cnt){
    if($cnt['work_name']=='신규개발'){
        $new['cnt']=$cnt['cnt'];
        $new['month_cnt']=$cnt['month_cnt'];
        $week_total_cnt+= (int)$cnt['cnt'];
        $month_total_cnt+=(int)$cnt['month_cnt'];
    }else if($cnt['work_name']=='버그수정'){
        $bug['cnt']=$cnt['cnt'];
        $bug['month_cnt']=$cnt['month_cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
        $month_total_cnt+=(int)$cnt['month_cnt'];
    }else if($cnt['work_name']== '기능개선'){
        $improvement['cnt']=$cnt['cnt'];
        $improvement['month_cnt']=$cnt['month_cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
        $month_total_cnt+=(int)$cnt['month_cnt'];
    }
}
}
?>
                                                            <tr>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($new['month_cnt'])){echo 0;} else {echo $new['month_cnt'];} ?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($new['cnt'])){echo 0;} else {echo $new['cnt'];} ?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($bug['month_cnt'])){echo 0;} else {echo $bug['month_cnt'];} ?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($bug['cnt'])){echo 0;} else {echo $bug['cnt'];} ?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($improvement['month_cnt'])){echo 0;} else {echo $improvement['month_cnt'];} ?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($improvement['cnt'])){echo 0;} else {echo $improvement['cnt'];} ?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo $month_total_cnt;?></td>
                                                                <td colspan="2" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo $week_total_cnt;?></td>
                                                            </tr>
                                                        <!-- </table>
                                                    </td>
                                                </tr> -->

                                                <tr class="row-color1">
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">숨김</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">구분</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">요청일자</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">페이지</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">요청자</td>
                                                    <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">요청사항</td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border" >개발사항</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">결과</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">완료일자</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">담당자</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_add(1);" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                                                    </td>
                                                </tr>

<!-- 반복 구간 -->
<?php
	if(!empty($current_doc)){
		$i=0;
		foreach($current_doc as $key){
?>

                                                <tr id="current_doc_<?php echo $i;?>">
                                                    <input type="hidden" name="seq2" value="<?php echo $key['seq'];?>" />
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="checkbox" name="hide" value="<?php echo $key['hide']; ?>" onchange="hide_check(this);currentUpdate(<?php echo $i; ?>);" <?php if($key['hide'] == "Y"){echo "checked";} ?> />
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <!-- <input type="text" id="work_name" name="work_name" value="<?php echo $key['work_name'];?>" class="input7"> -->
                                                        <select name="work_name" class="input7" onchange="currentUpdate(<?php echo $i; ?>)">
                                                            <option value="신규개발" <?php if( "신규개발" == $key['work_name']){echo "selected" ;} ?>>
                                                                신규개발
                                                            </option>
                                                            <option value="버그수정" <?php if( "버그수정" == $key['work_name']){echo "selected" ;} ?>>
                                                                버그수정
                                                            </option>
                                                            <option value="기능개선" <?php if( "기능개선" == $key['work_name']){echo "selected" ;} ?>>
                                                                기능개선
                                                            </option>

                                                        </select>
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border" >
                                                        <input type="date" name="income_time" class="input7" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo substr($key['income_time'], 0, 10); ?>">
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="customer" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['customer'];?>" class="input7" style="width:90%">
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="type" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['type'];?>" class="input7" style="width:90%">
                                                    </td>
                                                    <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                      <textarea name="produce" style="width:90%" onchange="currentUpdate(<?php echo $i; ?>)" ><?php echo $key['produce'];?></textarea>
                                                    </td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <textarea name="subject" style="width:90%" onchange="currentUpdate(<?php echo $i; ?>)" ><?php echo $key['subject'];?></textarea>
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="result" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['result'];?>" class="input7" style="width:90%">
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border" >
                                                        <input type="date" name="completion_time" class="input7" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo substr($key['completion_time'], 0, 10); ?>">
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="writer" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['writer'];?>" class="input7" style="width:90%">
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_del(<?php echo $i;?>,2,<?php echo $key['seq'];?>);" src="<?php echo $misc;?>img/btn_del.jpg" id="doc_del" name="doc_del" style="cursor:pointer;" />
                                                    </td>
                                                    <input type="hidden" value="1">
<?php
      $i++;
    }
  }
?>
<!-- 반복구간 끝 -->
                                                <tr id="current_insert_before">
                                                </tr>
                                                <tr>
                                                    <td colspan="16" height="45" align="center"
                                                        style="font-weight:bold;" class="t_border"></td>
                                                </tr>
                                                <!-- 차주 보고 -->

                                                <tr class="row-color7">
                                                    <td colspan="<?php echo $col_lenth ?>" height="15" align="center"
                                                        style="font-weight:bold;" class="t_border">
                                                        <!-- <?php echo $view_val['year']."년 ".$view_val['month']."월 ".($view_val['week']+1)."주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?> -->
                                                        <?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date'])))."년 ".date("m",strtotime("+7 day",strtotime($view_val['s_date'])))."월 "?>
                            <span id="next_week"></span>
                            <?php echo "주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?>
                                                    </td>
                                                </tr>


                                                            <tr class="row-color1">
                                                                <td colspan="4" height="30" width="11%" align="center" style="font-weight:bold;" class="t_border">
                                                                    신규개발
                                                                </td>
                                                                <td colspan="4" height="30" width="11%" align="center" style="font-weight:bold;" class="t_border">
                                                                    버그수정
                                                                </td>
                                                                <td colspan="4" height="30" width="11%" align="center" style="font-weight:bold;" class="t_border">
                                                                    기능개선
                                                                </td>
                                                                <td colspan="4" height="30" width="11%" align="center" style="font-weight:bold;" class="t_border">
                                                                    전체 개발 건수
                                                                </td>
                                                            </tr>

<?php
$week_total_cnt=0;
$improvement=array();
$new=array();
$bug=array();
if(!empty($next_cnt)){
foreach($next_cnt as $cnt){
    if($cnt['work_name']=='신규개발'){
        $new['cnt']=$cnt['cnt'];
        $week_total_cnt+= (int)$cnt['cnt'];
    }else if($cnt['work_name']=='버그수정'){
        $bug['cnt']=$cnt['cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
    }else if($cnt['work_name']== '기능개선'){
        $improvement['cnt']=$cnt['cnt'];
        $week_total_cnt+=(int)$cnt['cnt'];
    }
}
}
?>
                                                            <tr>
                                                                <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($new['cnt'])){echo 0;} else {echo $new['cnt'];} ?></td>
                                                                <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($bug['cnt'])){echo 0;} else {echo $bug['cnt'];} ?></td>
                                                                <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border"><?php if(!isset($improvement['cnt'])){echo 0;} else {echo $improvement['cnt'];} ?></td>
                                                                <td colspan="4" height="30" align="center" style="font-weight:bold;" class="t_border"><?php echo $week_total_cnt;?></td>
                                                            </tr>
                                                        <!-- </table>
                                                    </td>
                                                </tr> -->

                                                <tr class="row-color1">
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">숨김</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">구분</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border" >요청일자</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">페이지</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">요청자</td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">요청사항</td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">개발예정사항</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">예정일자</td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">담당자</td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_add(2);" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                                                    </td>
                                                </tr>
                                                <!-- 반복 구간 -->
<?php
	if(!empty($next_doc)){
	$i=0;
	foreach($next_doc as $key){
?>

                                                <tr id="next_doc_<?php echo $i;?>">
                                                    <input type="hidden" name="n_seq" class="input7" value="<?php echo $key['seq'];?>">
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="checkbox" name="n_hide" value="<?php echo $key['hide']?>" onchange="hide_check(this);nextUpdate(<?php echo $i; ?>);" <?php if($key['hide'] == "Y"){echo "checked";} ?> />
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <select name="n_work_name" class="input7" onchange="nextUpdate(<?php echo $i; ?>)">
                                                            <option value="신규개발" <?php if( "신규개발" == $key['work_name']){echo "selected" ;} ?>>
                                                                신규개발
                                                            </option>
                                                            <option value="버그수정" <?php if( "버그수정" == $key['work_name']){echo "selected" ;} ?>>
                                                                버그수정
                                                            </option>
                                                            <option value="기능개선" <?php if( "기능개선" == $key['work_name']){echo "selected" ;} ?>>
                                                                기능개선
                                                            </option>

                                                        </select>
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="date" name="n_income_time" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo substr($key['income_time'], 0, 10); ?>">
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input name="n_customer" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['customer'];?>" style="width:90%;">
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="n_type" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['type'];?>" style="width:90%;">
                                                    </td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <textarea name="n_produce" style="width:90%" onchange="nextUpdate(<?php echo $i; ?>)"><?php echo $key['produce'];?></textarea>
                                                    </td>
                                                    <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <textarea id="n_subject" name="n_subject" style="width:90%" onchange="nextUpdate(<?php echo $i; ?>)"><?php echo $key['subject'];?></textarea>
                                                    </td>
                                                    <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="date" name="n_completion_time" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo substr($key['completion_time'], 0, 10); ?>">
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <input type="text" name="n_writer" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['writer'];?>" style="width:90%;">
                                                    </td>
                                                    <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                        <img onClick="document_del(<?php echo $i;?>,0,<?php echo $key['seq'];?>);" src="<?php echo $misc;?>img/btn_del.jpg" id="doc_del" name="doc_del" style="cursor:pointer;" />
                                                    </td>
                                                    <input type="hidden" value="1">
                                                </tr>
  <?php
	$i++;
	 }
	}
}if (($view_val['group_name'] == '영업본부') || ($view_val['group_name'] == '사업1부') || ($view_val['group_name'] == '사업2부') || ($view_val['group_name'] == '경영지원실')){
?>

                                              <tr class="row-color1">
                                                <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">숨김</td>
                                                <td colspan="3" height="20" width="<?php echo (100/17)*2; ?>%" align="center" style="font-weight:bold;" class="t_border">일자</td>

<?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                                                <td colspan="4" height="20" width="<?php echo (100/17)*3; ?>%" align="center" style="font-weight:bold;" class="t_border">업체명</td>
                                                <td colspan="9" height="20" width="<?php echo (100/17)*8; ?>%" align="center" style="font-weight:bold;" class="t_border" >내용</td>
<?php } else { ?>
                                                <td colspan="2" height="20" width="<?php echo (100/17)*3; ?>%" align="center" style="font-weight:bold;" class="t_border">고객사</td>
                                                <td colspan="2" height="20" width="<?php echo (100/17)*3; ?>%" align="center" style="font-weight:bold;" class="t_border">방문 업체</td>
                                                <td colspan="9" height="20" width="<?php echo (100/17)*8; ?>%" align="center" style="font-weight:bold;" class="t_border" >내용</td>
<?php } ?>
                                                <td colspan="3" height="20" width="<?php echo (100/17)*2; ?>%" align="center" style="font-weight:bold;" class="t_border">담당자</td>
                                                <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <img onClick="document_add(1);" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                                                </td>
                                              </tr>

<!-- 반복 구간 -->
<?php
if(!empty($current_doc)){
$i=0;
foreach($current_doc as $key){
?>

                                              <tr id="current_doc_<?php echo $i;?>">
                                                <input type="hidden" name="seq2" value="<?php echo $key['seq'];?>" />
                                                <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <input type="checkbox" name="hide" value="<?php echo $key['hide']; ?>" onchange="hide_check(this);currentUpdate(<?php echo $i; ?>);" <?php if($key['hide'] == "Y"){echo "checked";} ?> />
                                                </td>
                                                <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border" >
                                                  <input type="date" name="income_time" class="input7" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo substr($key['income_time'], 0, 10); ?>">
                                                </td>

<?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                                                <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <input type="text" name="customer" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['customer'];?>" class="input7" style="width:90%">
                                                </td>
                                                <td colspan="9" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <textarea name="subject" onchange="currentUpdate(<?php echo $i; ?>)" ><?php echo $key['subject'];?></textarea>
                                                </td>
<?php } else { ?>
                                                <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                <input type="text" name="customer" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['customer'];?>" class="input7" style="width:90%">
                                                </td>
                                                <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                <input type="text" name="visit_company" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['visit_company'];?>" class="input7" style="width:90%">
                                                </td>
                                                <td colspan="9" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                <textarea name="subject" onchange="currentUpdate(<?php echo $i; ?>)" ><?php echo $key['subject'];?></textarea>
                                                </td>
<?php } ?>
                                                <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <input type="text" name="writer" onchange="currentUpdate(<?php echo $i; ?>)" value="<?php echo $key['writer'];?>" class="input7" style="width:90%">
                                                </td>
                                                <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <img onClick="document_del(<?php echo $i;?>,2,<?php echo $key['seq'];?>);" src="<?php echo $misc;?>img/btn_del.jpg" id="doc_del" name="doc_del" style="cursor:pointer;" />
                                                </td>
                                                <input type="hidden" value="1">
<?php
  $i++;
  }
}
?>
                                              <!-- 반복구간 끝 -->
                                              <tr id="current_insert_before">
                                              <td colspan="21" height="2"></td>
                                              </tr>
                                              <tr>

                                              <!-- 차주 보고 -->
                                              <tr class="row-color7">
                                              <td colspan="21" height="15" align="center"
                                                  style="font-weight:bold;" class="t_border">
                                                  <?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date'])))."년 ".date("m",strtotime("+7 day",strtotime($view_val['s_date'])))."월 "?>
                                                  <span id="next_week"></span>
                                                  <?php echo "주차 계획 보고 (".date("m-d",strtotime("+7 day",strtotime($view_val['s_date'])))." ~ ".date("m-d",strtotime("+7 day",strtotime($view_val['e_date']))).")";?>
                                              </td>
                                              </tr>

                                              <tr>
                                                <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">숨김</td>
                                                <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border" >일자</td>

<?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                                                <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">업체명</td>
                                                <td colspan="9" height="20" align="center" style="font-weight:bold;" class="t_border">내용</td>
<?php } else { ?>
                                                <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">고객사</td>
                                                <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">방문 업체</td>
                                                <td colspan="9" height="20" align="center" style="font-weight:bold;" class="t_border">내용</td>
<?php } ?>

                                                <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">담당자</td>
                                                <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                    <img onClick="document_add(2);" src="<?php echo $misc;?>img/btn_add.jpg" id="doc_add" name="doc_add" style="cursor:pointer;" />
                                                </td>
                                              </tr>
                                              <!-- 반복 구간 -->
<?php
if(!empty($next_doc)){
$i=0;
foreach($next_doc as $key){
?>

                                              <tr id="next_doc_<?php echo $i;?>">
                                                <input type="hidden" name="n_seq" class="input7" value="<?php echo $key['seq'];?>">
                                                <td colspan="1" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                  <input type="checkbox" name="n_hide" value="<?php echo $key['hide']?>" onchange="hide_check(this);nextUpdate(<?php echo $i; ?>);" <?php if($key['hide'] == "Y"){echo "checked";} ?> />
                                                </td>
                                                <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                    <input type="date" name="n_income_time" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo substr($key['income_time'], 0, 10); ?>">
                                                </td>

<?php if(($view_val['group_name'] == '경영지원실' )){ ?>
                                                <td colspan="4" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                    <input name="n_customer" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['customer'];?>" style="width:90%;">
                                                </td>
                                                <td colspan="9" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                    <textarea id="n_subject" name="n_subject" onchange="nextUpdate(<?php echo $i; ?>)"><?php echo $key['subject'];?></textarea>
                                                </td>
<?php } else { ?>
                                                <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                <input name="n_customer" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['customer'];?>" style="width:90%;">
                                                </td>
                                                <td colspan="2" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                <input name="n_visit_company" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['visit_company'];?>" style="width:90%;">
                                                </td>
                                                <td colspan="9" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                <textarea id="n_subject" name="n_subject" onchange="nextUpdate(<?php echo $i; ?>)"><?php echo $key['subject'];?></textarea>
                                                </td>
<?php } ?>

                                                <td colspan="3" height="20" align="center" style="font-weight:bold;" class="t_border">
                                                    <input type="text" name="n_writer" class="input7" onchange="nextUpdate(<?php echo $i; ?>)" value="<?php echo $key['writer'];?>" style="width:90%;">
                                                </td>
                                                <td height="20" align="center" style="font-weight:bold;" class="t_border">
                                                    <img onClick="document_del(<?php echo $i;?>,0,<?php echo $key['seq'];?>);" src="<?php echo $misc;?>img/btn_del.jpg" id="doc_del" name="doc_del" style="cursor:pointer;" />
                                                </td>
                                                <input type="hidden" value="1">
                                              </tr>
<?php
$i++;
    }
  }
}
?>

                                                <tr id="doc_data_field">

                                                </tr>
                                                <tr class="t_top row-color7">
                                                    <td colspan="<?php echo $col_lenth ?>" height="15" align="center"
                                                        style="font-weight:bold;" class="t_border">보고 및 이슈사항</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo $col_lenth ?>" height="40" align="center" style="font-weight:bold;" class="t_border">
                                                      <textarea id="comment" name="comment" class="input7_tmp" value="<?php echo $view_val['comment'];?>"><?php echo $view_val['comment']?></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:20px 0px 15vh 0px;">

                            <?php if($name == $view_val['writer'] || $tech_lv == 3) {?>
                              <button type="button" class="btn-common btn-color1" name="button" onClick="javascript:chkForm(0);return false;"/>수정</button>
                              <button type="button" class="btn-common btn-color1" name="button" onClick="javascript:chkForm(1);return false;"/>삭제</button>
                                <?php }?>
                            <button type="button" name="button"  class="btn-common btn-color2" onClick="javascript:history.go(-1);"/>목록</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
    </table>
  </div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script>
    $("#next_week").text((Math.ceil((new Date(<?php echo date("Y",strtotime("+7 day",strtotime($view_val['s_date']))); ?>, <?php echo date("m",strtotime("+7 day",strtotime($view_val['s_date']))); ?>, <?php echo date("d",strtotime("+7 day",strtotime($view_val['s_date']))); ?>).getDate()+1)/7)).toString());

    function selectbox_search(obj){
        $(obj).select2();
    }

    textareaSize();

    function textareaSize(){
        var textarea = document.getElementsByTagName("textarea");
        for (var i = 0; i < textarea.length; i++) {
            if (textarea[i].value != '') {
                textarea[i].style.height = '1px';
                textarea[i].style.height = (textarea[i].scrollHeight) + 'px';
            }
        }

        for (var i = 0; i < textarea.length; i++) {
            textarea[i].style.height = (textarea[i].parentElement.offsetHeight)+ 'px';
        }
    }

    function currentUpdate(cur_idx){
        var curreunt_update = $("#current_update").val().split(',');
        var duplication = false;
        for(var i=0; i<curreunt_update.length; i++){
            if(curreunt_update[i].trim() == String(cur_idx)){
                duplication = true;
            }
        }

        if(duplication == false){ //중복아닐때 넣어주기
            if($("#current_update").val() == ""){
                $("#current_update").val($("#current_update").val()+cur_idx);
            }else{
                $("#current_update").val($("#current_update").val()+","+cur_idx);
            }
        }

    }

    function nextUpdate(next_idx){
        var next_update = $("#next_update").val().split(',');
        var duplication = false;
        for(var i=0; i<next_update.length; i++){
            if(next_update[i].trim() == String(next_idx)){
                duplication = true;
            }
        }

        if(duplication == false){ //중복아닐때 넣어주기
            if($("#next_update").val() == ""){
                $("#next_update").val($("#next_update").val()+next_idx);
            }else{
                $("#next_update").val($("#next_update").val()+","+next_idx);
            }
        }
    }

    function dataUpdate(type,mode,updateData,num){
        if(type == "next"){
            if(mode == 1){//수정
                if(updateData == "direct"){
                    $($('#next_doc_' +num).find('input[name="n_customer"]')).val("");
                    $($('#next_doc_' +num).find('input[name="n_customer"]')).show();
                }else{
                    $($('#next_doc_' +num).find('input[name="n_customer"]')).val(updateData);
                    $($('#next_doc_' +num).find('input[name="n_customer"]')).hide();
                }
            }else{ //insert
                if(updateData == "direct"){
                    alert("여기");
                    $($('#insert_next_doc_' +num).find('input[name="n_customer"]')).val("");
                    $($('#insert_next_doc_' +num).find('input[name="n_customer"]')).show();
                }else{
                    $($('#insert_next_doc_' +num).find('input[name="n_customer"]')).val(updateData);
                    $($('#insert_next_doc_' +num).find('input[name="n_customer"]')).hide();
                }

            }
        }else{
            if(updateData == "direct"){
                $($('#insert_current_doc_' +num).find('input[name="customer"]')).val("");
                $($('#insert_current_doc_' +num).find('input[name="customer"]')).show();
            }else{
                $($('#insert_current_doc_' +num).find('input[name="customer"]')).val(updateData);
                $($('#insert_current_doc_' +num).find('input[name="customer"]')).hide();
            }
        }
    }

    function hide_check(obj){
        var check_val = $(obj).prop("checked");
        if (check_val == true) {
            $(obj).val("Y");
        }else{
            $(obj).val("N");
        }
        console.log($(obj).val());
    }

    // $("textarea").on("keyup keydown", function(){
    //   console.log(this);
    // })

    $(".dash_tbl1-1").on("keyup keydown", "textarea", function(){
      $(this).height(1).height( $(this).prop('scrollHeight')+12 );
      $("#sidebar_left").height($("#main_contents").height());
      $(".sidebar_sub_on").height($("#main_contents").height());
    })

</script>
</body>
</html>

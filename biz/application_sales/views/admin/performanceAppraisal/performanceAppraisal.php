<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}

   .datepicker{
     z-index:10000;
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
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
   // echo $list_val_count."<br><br><br>";
   // var_dump($list_val);
?>

<div align="center">
   <div class="dash1-1">
      <form name="mform" action="<?php echo site_url();?>/admin/account/performanceAppraisal" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
        <input type="hidden" name="year" value="<?php echo $year; ?>">
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
         <tbody>
            <tr height="5%">
          <td class="dash_title">
            인사고과 (<?php echo $year; ?>년도)
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
                  <select class="select-common" id="yearSel">
            <?php for($i = 2021; $i < date('Y')+1; $i++) { ?>
                    <option value="<?php echo $i; ?>" <?php if($year == $i) {echo 'selected';} ?>><?php echo $i; ?>년도</option>
            <?php } ?>
                  </select>
                  <input type="button" class="btn-common btn-style2" value="검색" style="margin-left:10px;" onclick="GoSearch();">
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
               <!--내용-->
              <!--리스트-->
                <colgroup>
                  <col width="5%">
                  <col width="18%">
                  <col width="18%">
                  <col width="18%">
                  <col width="18%">
                  <col width="18%">
                  <col width="5%">
                </colgroup>
                <tr class="t_top row-color1">
                  <th></th>
                  <th height="40" align="center">이름</th>
                  <th align="center">부서</th>
                  <th align="center">직급</th>
                  <th align="center">입사일</th>
                  <th align="center">품의서</th>
                  <th></th>
                </tr>
          <?php
             foreach($view_val as $v) {
          ?>
                <tr id="<?php echo $v['seq'].'_'.$v['user_id']; ?>">
                  <td></td>
                  <td height="40" align="center"><?php echo $v['user_name']; ?></td>
                  <td align="center"><?php echo $v['user_group']; ?></td>
                  <td align="center"><?php echo $v['user_duty']; ?></td>
                  <td align="center"><?php echo $v['join_company_date']; ?></td>
                  <td align="center"><?php
                    if($v['companion_cnt'] == '') {
                      echo '<span style="cursor:default">0</span>';
                    } else {
                      echo '<span style="cursor:pointer;" onclick="view_approval_list(this);">'.$v['companion_cnt'].'</span>';
                    }
                  ?></td>
                  <td></td>
                  <td></td>
                </tr>
            <?php
             }
            ?>
                           </form>
                         </table>
                      </td>
                   </tr>
                </table>
             </td>
          </tr>
            <!--페이징-->

         </tbody>
      </table>
   </div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
<script type="text/javascript">
  function GoSearch() {
    document.mform.year.value = $('#yearSel').val();

    document.mform.submit();
  }

  function view_approval_list(el) {
    var tr_id = $(el).closest('tr').attr('id');
    var user_seq = tr_id.split('_')[0];
    var user_id = tr_id.split('_')[1];
    var year = $('input[name=year]').val();

    window.open('<?php echo site_url();?>/admin/account/return_approval_list?user_seq='+user_seq+'&user_id='+user_id+'&year='+year,'_blank',"width = 1200, height = 500, top = 100, left = 400, location = no,status=no,status=no,toolbar=no,scrollbars=no");
  }
</script>
</html>

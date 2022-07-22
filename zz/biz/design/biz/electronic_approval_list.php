<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .tabs {position: relative;margin: 35px auto;width: 600px;}
   .tabs_input {position: absolute;z-index: 1000;width: 135px;height: 35px;left: 0px;top: 0px;opacity: 0;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);}
   .tabs_input:not(:checked) {cursor: pointer;}
   .tabs_input:not(:checked) + label {color:#fff;}
   .tabs_input:not(:checked) + label {background: #f8f8f9;color:#777;}
   .tabs_input:hover + label {background: #abe9ff;color:#fff;}
   .tabs_input#tab-2{left: 135px;}
   .tabs_input#tab-3{left: 270px;}
   .tabs_input#tab-4{left: 405px;}
   .tabs_input#tab-5{left: 540px;}
   .tabs label {background:#41beeb;;color:#fff;font-size: 14px;line-height: 35px;height: 35px;position: relative;padding: 0 20px;float: left;display: block;width: 100px;letter-spacing: 0px;text-align: center;border-radius: 12px 12px 0 0;box-shadow: 2px 0 2px rgba(0,0,0,0.1), -2px 0 2px rgba(0,0,0,0.1);}
   .tabs label:after {content: '';background: #fff;position: absolute;bottom: -2px;left: 0;width: 100%;height: 2px;display: block;}
   .tabs label:first-of-type {z-index: 4;box-shadow: 1px 0 3px rgba(0,0,0,0.1);}
   .no_read {color:white;border-radius: 50%;background-color: red;margin-left: 5px;}

   <?php if($type != 'admin'){ ?>
   .read_n td {
     font-weight:bold;
   }
   <?php } ?>

	 .read_btn {
	   cursor: pointer;
	   margin-right: 11px;
	   border: 2px solid black;
	   background-color: white;
	   width: 90px;
	   height: 30px;
	   font-weight: 400;
	   border-radius: 5px;
	   background: #a9abac;
	   border-color: #a9abac;
	   color: rgb(255, 255, 255);
	   font-family: "Noto Sans KR", sans-serif;
	 }
   .main_title {
     display:inline-block;
     position: relative;
     height:40px;
   }
   .main_title a {
     height:40px;
     position: static;
   }
   .cnt {position: absolute;top:0;right:0; font-size: 14px;margin-left:2px;}
  body {
    line-height: normal;
  }
  .dash1-1 {
    margin-top: 48px !important;
  }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script>
</script>
<body>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php"; ?>
<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
   <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
   <input type="hidden" name="type" value="<?php echo $type; ?>">
   <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
</form>
<div align="center">
<div class="dash1-1">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
      <input type="hidden" id="seq" name="seq" value="">
      <tbody height="100%">
        <!-- 타이틀 이미지 tr -->
      <tr height="5%">
           <?php if($type != "admin"){
                   if($no_read_cnt_s[0]['cnt'] > 5){
                     $no_read_cnt_s[0]['cnt'] = '5over';
                   }
                   if($no_read_cnt_p[0]['cnt'] > 5){
                     $no_read_cnt_p[0]['cnt'] = '5over';
                   }
                   if($no_read_cnt_c[0]['cnt'] > 5){
                     $no_read_cnt_c[0]['cnt'] = '5over';
                   }
                   if($no_read_cnt_b[0]['cnt'] > 5){
                     $no_read_cnt_b[0]['cnt'] = '5over';
                   }
                   if($no_read_cnt_r[0]['cnt'] > 5){
                     $no_read_cnt_r[0]['cnt'] = '5over';
                   } ?>

                  <td class="dash_title">
                    <div class="main_title">
                      <a onclick ="moveList('standby')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "standby"){echo "#1C1C1C";}else{echo "#DEDEDE";}?><?php if($type != "standby"){echo ";font-weight:normal";}?>'>결재대기함</a>
                    <?php if($no_read_cnt_s[0]['cnt']!=0){ ?>
                      <div class="cnt">
                        <img src="<?php echo $misc ?>img/cnt_<?php echo $no_read_cnt_s[0]['cnt']; ?>.svg" width="20">
                      </div>
                    <?php } ?>
                    </div>
                    <div class="main_title">
                      <a onclick ="moveList('progress')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "progress"){echo "#1C1C1C";}else{echo "#DEDEDE";}?><?php if($type != "progress"){echo ";font-weight:normal";}?>'>결재진행함</a>
                      <?php if($no_read_cnt_p[0]['cnt']!=0){ ?>
                      <div class="cnt">
                        <img src="<?php echo $misc ?>img/cnt_<?php echo $no_read_cnt_p[0]['cnt']; ?>.svg" width="20">
                      </div>
                      <?php } ?>
                    </div>
                    <div class="main_title">
                      <a onclick ="moveList('completion')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "completion"){echo "#1C1C1C";}else{echo "#DEDEDE";}?><?php if($type != "completion"){echo ";font-weight:normal";}?>'>완료문서함</a>
                      <?php if($no_read_cnt_c[0]['cnt']!=0){ ?>
                      <div class="cnt">
                        <img src="<?php echo $misc ?>img/cnt_<?php echo $no_read_cnt_c[0]['cnt']; ?>.svg" width="20">
                      </div>
                      <?php } ?>
                    </div>
                    <div class="main_title">
                      <a onclick ="moveList('back')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "back"){echo "#1C1C1C";}else{echo "#DEDEDE";}?><?php if($type != "back"){echo ";font-weight:normal";}?>'>반려문서함</a>
                      <?php if($no_read_cnt_b[0]['cnt']!=0){ ?>
                      <div class="cnt">
                        <img src="<?php echo $misc ?>img/cnt_<?php echo $no_read_cnt_b[0]['cnt']; ?>.svg" width="20">
                      </div>
                      <?php } ?>
                    </div>
                    <div class="main_title">
                      <a onclick ="moveList('reference')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "reference"){echo "#1C1C1C";}else{echo "#DEDEDE";}?><?php if($type != "reference"){echo ";font-weight:normal";}?>'>참조/열람문서함</a>
                      <?php if($no_read_cnt_r[0]['cnt']!=0){ ?>
                      <div class="cnt">
                        <img src="<?php echo $misc ?>img/cnt_<?php echo $no_read_cnt_r[0]['cnt']; ?>.svg" width="20">
                      </div>
                      <?php } ?>
                    </div>
                  </td>
           <?php } else if ($type == "admin"){?>
                  <td class="dash_title">결재문서관리</td>
           <?php }?>
      </tr>
      <!-- 검색창 -->
      <tr id="search_tr">
         <td align="left" valign="top">
            <table width="100%" id="filter_table" style="margin-top:80px;">
              <tr>
                <td style="font-weight:bold;vertical-align:middle;">
                  <div style="float:left">
                    <span style="<?php if($_GET['type']!='admin'){echo 'display:none;';} ?>">
                      문서상태&nbsp;
                      <select id="filter1" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;">
                         <option value="" <?php if(isset($filter)){if($filter[0] == ""){echo "selected";}} ?>>문서상태선택</option>
                         <option value="001" <?php if(isset($filter)){if($filter[0] == "001"){echo "selected";}} ?>>진행중</option>
                         <option value="002" <?php if(isset($filter)){if($filter[0] == "002"){echo "selected";}} ?>>완료</option>
                         <option value="003" <?php if(isset($filter)){if($filter[0] == "003"){echo "selected";}} ?>>반려</option>
                         <option value="004" <?php if(isset($filter)){if($filter[0] == "004"){echo "selected";}} ?>>회수</option>
                         <option value="006" <?php if(isset($filter)){if($filter[0] == "006"){echo "selected";}} ?>>보류</option>
                      </select>
                    </span>
                    양식명&nbsp;
                    <input type="text" id="filter2" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[1];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;width:120px;" onchange="keyword_replace(this);" category="template_name"/>
                    기안자&nbsp;
                    <input type="text" id="filter3" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[2];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;width:120px;" />

                    <select class="select-common filtercolumn" id="filter4" style="margin-right:10px;color:black">
                      <option value="write_date" <?php if(isset($filter)){if($filter[3] == "write_date"){echo "selected";}} ?>>기안일</option>
                      <option value="completion_date" <?php if(isset($filter)){if($filter[3] == "completion_date"){echo "selected";}} ?>>완료일</option>
                    </select>
                    <input type="date" id="filter5" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[4];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;" />
                    ~
                    <input type="date" id="filter6" class="input-common input-style1 filtercolumn" value='<?php if(isset($filter)){echo $filter[5];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:120px;margin-right:10px;" />

                    <select class="select-common filtercolumn" id="filter7" style="margin-right:10px;color:black">
                      <option value="approval_doc_name" <?php if(isset($filter)){if($filter[6] == "approval_doc_name"){echo "selected";}} ?>>문서제목</option>
                      <option value="contents_html" <?php if(isset($filter)){if($filter[6] == "contents_html"){echo "selected";}} ?>>문서내용</option>
                      <option value="doc_num" <?php if(isset($filter)){if($filter[6] == "doc_num"){echo "selected";}} ?>>문서번호</option>
                    </select>
                    <input type="text" id="filter8" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[7];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="margin-right:10px;width:120px;" />
                  </div>
                  <div style="float:left;">
                    <input type="button" class="btn-common btn-style1" style="height:27px;cursor:hand;" value="검색" onclick="return GoSearch();">
                  </div>
                  <div style="float:right">

                    <button class="read_btn" style="float: right;display:inline;" type="button"name="button" onclick="all_read();">전체 읽음</button>
                  </div>
                </td>
              </tr>
            </table>
      </tr>
      <tr>
        <td>
           <!-- 페이징개수 -->
           <div style="width:fit-content;margin-top:10px;">
              <select class="select-common" id="listPerPage" style="height:25px;margin-right:10px;" onchange="change_lpp()">
                 <option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
                 <option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
                 <option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
                 <option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
                 <option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
                 <option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
              </select>
              <!-- <input type="button" class="basicBtn" name="button" style="background-color:#E2E2E2; color:black;height:25px" value="검색" onclick="change_lpp();"> -->
              <span>전체</span>
              <span style="color:red;margin-right:10px;"><?php echo $count; ?></span>
              <input type="button" style="background-color:white;border:1px black solid;border-radius:3px;cursor:pointer;" value="엑셀다운로드" onclick="excelDownload('excelTable');">
           </div>
        </td>
      </tr>

      <!-- <tr height="10%"> -->
        <!-- 검색 끝 -->

        <!-- 본문시작 -->
        <!-- <tr height="45%"> -->
          <?php if(!empty($delegation)){
            echo "<tr height='30%'>";
          }else{

            echo "<tr height='45%'>";
          }

          ?>


        <td valign="top" style="padding:1px 0px 15px 0px">
        	<table class="list_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
            <?php if($type == 'progress'){?>
              <colgroup>
                  <col width="5%">
                  <col width="6%">
                  <col width="9%">
                  <col width="9%">
                  <col width="22%">
                  <col width="6%">
                  <col width="6%">
                  <col width="9%">
                  <col width="9%">
                  <col width="5%">
                  <col width="5%">
                  <col width="5%">
                  <col width="2%">
              </colgroup>
            <?php }else if($type =='admin'){ ?>
              <colgroup>
                  <col width="5%">
                  <col width="6%">
                  <col width="9%">
                  <col width="9%">
                  <col width="20%">
                  <col width="4%">
                  <col width="6%">
                  <col width="9%">
                  <col width="9%">
                  <col width="6%">
                  <col width="5%">
                  <col width="5%">
                  <col width="5%">
                  <col width="2%">
              </colgroup>
            <?php }else{ ?>
              <colgroup>
                  <col width="5%">
                  <col width="6%">
                  <col width="9%">
                  <col width="9%">
                  <col width="4%">
                  <col width="20%">
                  <col width="6%">
                  <col width="6%">
                  <col width="9%">
                  <col width="9%">
                  <col width="5%">
                  <col width="5%">
                  <col width="5%">
                  <col width="2%">
              </colgroup>
            <?php } ?>
            <tr class="t_top row-color1">
              <th></th>
              <th align="center">서식함</th>
              <th align="center">양식명</th>
              <th align="center">문서번호</th>
              <?php if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){?>
              <th align="center">유형</th>
              <?php } ?>
              <th align="center">문서제목</th>
              <th align="center">기안자</th>
              <th align="center">기안부서</th>
              <th align="center">기안일</th>

              <?php if($type == "standby"){?>
                 <th align="center">배정일</th>
              <?php }else if($type == "progress"){?>
                 <th align="center">결재일</th>
              <?php }else if($type == "completion" || $type == "back" ||$type == "reference" || $type == "admin"){?>
                 <th align="center">완료일</th>
              <?php } ?>

              <?php if($type == "admin"){ ?>
                 <th align="center">보안설정</th>
              <?php } ?>
              <th align="center">문서상태</th>
              <th align="center">댓글</th>
              <th align="center">첨부파일</th>
              <th></th>
            </tr>
            <tr>
              <?php
              if(empty($view_val) != true){
                 $idx = $count-$start_row;
                 for($i = $start_row; $i<$start_row+$end_row; $i++){
                    if(!empty( $view_val[$i])){
                       $doc = $view_val[$i];
                       $read_yn = '';
                       $read_seq = substr($_GET['type'],0,1).'_'.$user_seq;
                       if(strpos($doc['read_seq'],$read_seq)===false) {
                         $read_yn = 'read_n';
                       } else {
                         $read_yn = 'read_y';
                       }
                       echo "<tr align='center' class='".$read_yn."' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$doc['seq']},".'"'.$doc['approval_doc_status'].'"'.")'>";
                       echo "<td height='40'></td>";
                       echo "<td>";
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
                       echo "<td>{$doc['template_name']}</td>";
                       echo "<td>{$doc['writer_group']}-{$doc['doc_num']}</td>";
                       if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){
                       echo "<td>{$doc['approval_type']}</td>";
                       }
                       if($doc['approval_doc_hold'] == "N"){
                          echo "<td>{$doc['approval_doc_name']}</td>";
                       }else{
                          echo "<td>{$doc['approval_doc_name']} (보류)</td>";
                       }

                       echo "<td>{$doc['writer_name']}</td>";
                       echo "<td>{$doc['writer_group']}</td>";
                       echo "<td>{$doc['write_date']}</td>";

                    if($type == "standby"){
                          echo "<td>{$doc['assignment_date']}</td>";
                    }else if($type == "progress"){
                          echo "<td>";
                          if($doc['assignment_date'] != ""){
                             echo $doc['assignment_date'];
                          }else{
                             echo $doc['write_date'];
                          }
                          echo "</td>";
                    }else if($type == "completion" || $type == "back" ||$type == "reference" || $type=="admin"){
                          echo "<td>{$doc['completion_date']}</td>";
                    }

                   if($type == "admin"){
                       echo "<td>";
                       if($doc['approval_doc_security'] == "Y"){
                          echo "<img src='{$misc}img/security.png' width=15' />";
                       }
                       echo "</td>";
                   }

                       echo "<td>";
                       if($doc['approval_doc_status'] == "001"){
                          echo '<p style="color: #B0B0B0;">'."진행중";
                       }else if($doc['approval_doc_status'] == "002"){
                          echo "완료";
                       }else if($doc['approval_doc_status'] == "003"){
                          echo '<p style="color: #DC0A0A;">'."반려";
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
                       echo "<td>{$doc['comment_cnt']}</td>";
                  if($doc['file_realname'] != '') {
                    echo '<td><img src="/misc/img/add.png" width="20" height="20"></td>';
                  } else {
                    echo "<td>-</td>";
                  }
                       echo "<td></td>";
                       echo "</tr>";
                       $idx --;
                    }
                 }
              }else{
                 echo "<tr><td align='center' colspan=14 height='40' class='basic_td'>검색 결과가 존재하지 않습니다.</td></tr>";
              }
              ?>

            </tr>
          </table>
        </td>
      </tr>
      <!-- 위임 있을 경우 -->
          <?php if(!empty($delegation)){ ?>
            <tr height="2%">
              <td align="left" valign="bottom">
                <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:150px;">
                <tr>
                  <!--타이틀-->
                  <?php if ($type != "admin"){?>
                     <td class="dash_title">위임</td>
                   </tr>
                  <?php }?>

                </table>
              </td>
              </tr>


          <tr height="30%">
          <td valign="top" style="padding:1px 0px 15px 0px">
          <table class="list_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;">
          <colgroup>
            <col width="10%">
            <col width="4%">
            <col width="6%">
            <col width="10%">
            <col width="4%">
            <col width="19%">
            <col width="6%">
            <col width="6%">
            <col width="10%">
            <col width="10%">
            <col width="5%">
            <col width="10%">
          </colgroup>
          <tr class="t_top row-color1" align="center">
            <th height="40"></th>
             <th>NO</th>
             <th>서식함</th>
             <th>문서번호</th>
             <?php if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){?>
             <th>유형</th>
             <?php } ?>
             <th>문서제목</th>
             <th>기안자</th>
             <th>기안부서</th>
             <th>기안일</th>

             <?php if($type == "standby"){?>
                <th>배정일</th>
             <?php }else if($type == "progress"){?>
                <th>결재일</th>
             <?php }else if($type == "completion" || $type == "back" ||$type == "reference"){?>
                <th>완료일</th>
             <?php } ?>

             <!-- <td class="basic_td">배정일</td> -->
             <th>문서상태</th>
             <th></th>
          </tr>
          <?php
          $idx = 1;
             foreach($delegation as $doc){
                echo "<tr align='center' onmouseover='this.style.backgroundColor=".'"'."#FAFAFA".'"'."' onmouseout='this.style.backgroundColor=".'"'.'#fff'.'"'."' style='cursor:pointer;' onclick='eletronic_approval_view({$doc['seq']})'>";
                echo "<td height='40'></td>";
                echo "<td>{$idx}</td>";
                echo "<td>";
                foreach($category as $format_categroy){
                   if($doc['template_category'] == $format_categroy['seq']){
                      echo $format_categroy['category_name'];
                   }
                }
                echo"</td>";
                echo "<td>문서번호아직없음</td>";
                if($type == "standby" || $type == "completion" || $type == "back" || $type == "reference"){
                echo "<td>{$doc['approval_type']}</td>";
                }
                if($doc['approval_doc_hold'] == "N"){
                   echo "<td>{$doc['approval_doc_name']}(위임)</td>";
                }else{
                   echo "<td>{$doc['approval_doc_name']} (보류)</td>";
                }

                echo "<td>{$doc['writer_name']}</td>";
                echo "<td>{$doc['writer_group']}</td>";
                echo "<td>{$doc['write_date']}</td>";

             if($type == "standby"){
                   echo "<td>{$doc['assignment_date']}</td>";
             }else if($type == "progress"){
                   echo "<td>";
                   if($doc['assignment_date'] != ""){
                      echo $doc['assignment_date'];
                   }else{
                      echo $doc['write_date'];
                   }
                   echo "</td>";
             }else if($type == "completion" || $type == "back" ||$type == "reference"){
                   echo "<td>{$doc['completion_date']}</td>";
             }

                echo "<td>";
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
                echo "<td></td>";
                echo "</tr>";
                $idx ++;
             }

      echo "</table>";
      echo "</td>";
      echo "</tr>";
    }
    ?>


        <!-- 페이징 처리 -->
<?php if(!empty($delegation)){
  echo "<tr height='30%'>";
}else{

  echo "<tr height='40%'>";
}

?>
<td align="left" valign="top">
<table width="100%" cellspacing="0" cellpadding="0">
  <!-- 페이징처리 -->
  <tr>
     <td align="center">
     <?php if ($count > 0) {?>
           <table width="400" border="0" cellspacing="0" cellpadding="0">
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
          </td>
        </tr>

    </tbody>
</table>
</div>
</div>
<div id="tablePlus" style="display:none;">

</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
   function eletronic_approval_view(seq,status){
      if("<?php echo $type ;?>" == "admin"){
         location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $type; ?>&type2="+status;
      }else{
         location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $type; ?>";
      }
   }

   function GoFirstPage (){
      document.cform.cur_page.value = 1;
      document.cform.submit();
   }

   function GoPrevPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
      document.cform.submit( );
   }

   function GoPage(nPage){
      document.cform.cur_page.value = nPage;
      document.cform.submit();
   }

   function GoNextPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
      document.cform.submit();
   }

   function GoLastPage (){
      var	total_page = <?php echo $total_page;?>;
      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

   function moveList(type){
      location.href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type="+type;
   }

   //거엄색!
   function GoSearch(){
      var searchkeyword = '';
      for ( i = 1; i <= $(".filtercolumn").length; i++) {
         if (i == 1) {
               searchkeyword += $("#filter" + i).val().trim();
         } else {
               var filter_val = $("#filter" + i).val().trim();
               if(i == 13 || i == 14){
                  filter_val = String(filter_val).replace(/,/g, "");
               }
               searchkeyword += ',' + filter_val;
         }
      }
      $("#searchkeyword").val(searchkeyword);

      if (searchkeyword.replace(/,/g, "") == "") {
         alert("검색어가 없습니다.");
         location.href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=<?php echo $type;?>";
         return false;
      }

      document.cform.action = "<?php echo site_url();?>/biz/approval/electronic_approval_list";
      document.cform.cur_page.value = "1";
      document.cform.submit();
    }

    function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.cform.lpp.value = lpp;
		document.cform.submit();
	}

  function all_read() {
    if (confirm('전체 읽음 처리 하시겠습니까?')) {
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/biz/approval/all_read",
        dataType: "json",
        async: false,
        data: {
          type: '<?php echo substr($_GET['type'],0,1); ?>'
        },
        success: function(data) {
          alert('완료되었습니다.');
          location.reload();
        }
      })
    }
  }

  function keyword_replace(el) {
    $.ajax({
      type:'POST',
      cache: false,
      url: "<?php echo site_url(); ?>/biz/approval/keyword_replace",
      dataType: "json",
      async: false,
      data: {
        keyword: $(el).val(),
        category: $(el).attr('category'),
        page: '<?php echo $this->uri->segment(3); ?>'
      },
      success: function(data) {
        if(data) {
          if($(el).attr('category') == 'template_name') {
            var category = '양식명';
          }
          var txt = category + ' 추천 검색어가 있습니다.\n검색어 : ' + $(el).val() + '\n추천 검색어 : ' + data.replace_keyword
                    + '\n추천 검색어로 변경하시겠습니까?';
          if (confirm(txt)) {
            $(el).val(data.replace_keyword);
          }
        }
      }
    })
  }

  function excelDownload(id) {
    var excel_download_table = '';
    var type = '<?php echo $type; ?>';
    var search_keyword = '<?php echo $search_keyword; ?>';
    var category = <?php echo json_encode($category); ?>;
    console.log(category);

    $.ajax({
      type: "POST",
      cache: false,
      url: '<?php echo site_url(); ?>/biz/approval/electronic_approval_list_excel',
      dataType: 'json',
      async: false,
      data: {
        type: type,
        search_keyword: search_keyword
      },
      success: function(data) {
        if(data) {
          excel_download_table += '<table id="excelTable" width="100%" border="0" cellpadding="0" style="display:none;"><colgroup>';
          if(type == 'progress') {
            excel_download_table += '<col width="6%"><col width="9%"><col width="9%"><col width="29%"><col width="6%"><col width="6%"><col width="9%"><col width="9%"><col width="5%">';
          } else if (type == 'admin') {
            excel_download_table += '<col width="6%"><col width="9%"><col width="9%"><col width="31%"><col width="4%"><col width="6%"><col width="9%"><col width="9%"><col width="6%">';
          } else {
            excel_download_table += '<col width="6%"><col width="9%"><col width="9%"><col width="4%"><col width="22%"><col width="6%"><col width="6%"><col width="9%"><col width="9%"><col width="5%">';
          }
          excel_download_table += '</colgroup><tr class="t_top row-color1"><th align="center">서식함</th><th align="center">양식명</th><th align="center">문서번호</th>';
          if(type == "standby" || type == 'completion' || type == 'back' || type == 'reference') {
            excel_download_table += '<th align="center">유형</th>';
          }
          excel_download_table += '<th align="center">문서제목</th><th align="center">기안자</th><th align="center">기안부서</th><th align="center">기안일</th>';
          if(type == 'standby') {
            excel_download_table += '<th align="center">배정일</th>';
          } else if (type == 'progress') {
            excel_download_table += '<th align="center">결재일</th>';
          } else if (type == 'completion' || type == 'back' || type == 'reference' || type == 'admin') {
            excel_download_table += '<th align="center">완료일</th>';
          }
          excel_download_table += '<th align="center">문서상태</th>';
          for (var i = 0; i < data.length; i++) {
            if(data[i].template_category == '' || data[i].template_category == null) {
              var template_category = '연차';
            } else {
              for(var j = 0; j < category.length; j++) {
                if(data[i].template_category == category[j].seq) {
                  var template_category = category[j].category_name;
                }
              }
            }
            excel_download_table += '<tr><td height="40">' + template_category + '</td><td>' + data[i].template_name + '</td><td>' + data[i].writer_group + '-' + data[i].doc_num + '</td>';
            if(type == 'standby' || type == 'completion' || type == 'back' || type == 'reference') {
              excel_download_table += '<td>' + data[i].approval_type + '</td>';
            }
            if (data[i].approval_doc_hold == 'Y') {
              var hold = '(보류)';
            } else {
              var hold = '';
            }
            excel_download_table += '<td>' + data[i].approval_doc_name + hold + '</td><td>' + data[i].writer_name + '</td><td>' + data[i].writer_group + '</td><td>' + data[i].write_date + '</td>';
            if(type == 'standby') {
              excel_download_table += '<td>' + data[i].assignment_date + '</td>';
            } else if (type == 'progress') {
              excel_download_table += '<td>';
              if(data[i].assignment_date != null) {
                excel_download_table += data[i].assignment_date;
              } else {
                excel_download_table += data[i].write_date;
              }
              excel_download_table += '</td>';
            } else if (type == 'completion' || type == 'back' || type == 'reference' || type == 'admin') {
              if(data[i].completion_date == null) {
                var completion_date = '';
              } else {
                var completion_date = data[i].completion_date;
              }
              excel_download_table += '<td>' + completion_date + '</td>';
            }
            if(data[i].approval_doc_status == '001') {
              var status = '진행중';
            } else if (data[i].approval_doc_status == '002') {
              var status = '완료';
            } else if (data[i].approval_doc_status == '003') {
              var status = '반려';
            } else if (data[i].approval_doc_status == '004') {
              var status = '회수';
            } else if (data[i].approval_doc_status == '005') {
              var status = '임시저장';
            } else if (data[i].approval_doc_status == '006') {
              var status = '보류';
            } else {
              var status = '';
            }
            excel_download_table += '<td>' + status + '</td></tr>';
          }
        } else {
          alert('조회결과가 없습니다.');
          return false;
        }
      }
    });

    $("#tablePlus").append(excel_download_table);

    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";
    var exportTable = $('#' + id).clone();
    exportTable.find('input').each(function (index, elem) {
      $(elem).remove();
    });
    tab_text = tab_text + exportTable.html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if(type == 'admin') {
      title = '결재문서관리';
    } else if (type == 'standby') {
      title = '결재대기함';
    } else if (type == 'progress') {
      title = '결재진행함';
    } else if (type == 'completion') {
      title = '완료문서함';
    } else if (type == 'back') {
      title = '반려문서함';
    } else if (type == 'reference') {
      title = '참조열람문서함';
    }
    var today = getToday();
    var fileName = title + '_' + today + '.xls';
    //Explorer 환경에서 다운로드
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
      if (window.navigator.msSaveBlob) {
        var blob = new Blob([tab_text], {
          type: "application/csv;charset=utf-8;"
        });
        navigator.msSaveBlob(blob, fileName);
      }
    } else {
      var blob2 = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
      });
      var filename = fileName;
      var elem = window.document.createElement('a');
      elem.href = window.URL.createObjectURL(blob2);
      elem.download = filename;
      document.body.appendChild(elem);
      elem.click();
      document.body.removeChild(elem);
    }
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

</script>
</body>
</html>

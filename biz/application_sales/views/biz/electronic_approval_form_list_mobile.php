<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
	$mode = $_GET['mode'];
  $filter_text = $filter;
  $filter = explode(",",$filter);
  if($mode == "user"){
     //즐겨찾기 때문에 배열 순서 앞으로 땡겨
     if(empty($view_val) != true){
       for($i =0; $i<count($view_val); $i++){
          $form = $view_val[$i];
           if(strpos($form['bookmark'],','.$id)!== false){
              array_splice($view_val, $i, 1);
              array_unshift($view_val, $form);
           }
       }
     }
  }
?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-bottom:20px;
	}
	.approval_list_tbl {
		padding-top: 20px;
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}
	#paging_tbl {
		margin-top:10px;
		width:100%;
	}
	#paging_tbl a {
		font-size: 18px;
	}

	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>

	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
	<body>
		<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
			 <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
			 <input type="hidden" name="mode" value="<?php echo $mode; ?>">
			 <input type="hidden" name="filter" value="<?php echo str_replace('"', '&uml;',$filter_text); ?>">
		</form>
		<input type="hidden" id="seq" name="seq" value="">
	<div class="menu_div">
		<?php if($mode == "admin"){ ?>
			<a class="menu_list" onclick ="moveList('standby')" style='color:<?php if($mode == "admin"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>양식관리</a>
	 <?php	}else{ ?>
		<a class="menu_list" onclick ="moveList('standby')" style='color:<?php if($mode == "user"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>기안문작성</a>
	<?php } ?>
	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
				<?php
				  if(empty($view_val) != true){
				    $idx = $count-$start_row;
				    for($i = $start_row; $i<$start_row+$end_row; $i++){
				       if(!empty( $view_val[$i])){
				          $form = $view_val[$i];
				?>
				    <tr onclick="eletronic_approval_view('<?php echo $form['seq']; ?>',event)">
				      <td align="left" style='color:#A1A1A1'><?php echo $form['template_type']; ?></td>
				<?php
				         foreach($category as $format_categroy){
				           if($form['template_category'] == $format_categroy['seq']){
				?>
								 	<td align="right" style='color:#A1A1A1'><?php echo $format_categroy['category_name']; ?></td>
				<?php
				           }
				         }
				?>

							</tr>
						<tr onclick="eletronic_approval_view('<?php echo $form['seq']; ?>',event)">
							<td align="left" style='color:#1C1C1C;font-weight:bold;'><?php echo  $form['template_name']; ?></td>
						</tr>
						<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
			<?php
				}
			}
		}else{
			echo "<tr><td align='center' colspan='2' height='40'>검색 결과가 존재하지 않습니다.</td></tr>";
		}
		?>
			</tbody>
		</table>
		<!-- 페이징 -->
		<table id="paging_tbl" cellspacing="0" cellpadding="0">
		  <!-- 페이징처리 -->
		  <tr>
		     <td align="center">
		     <?php if ($count > 0) {?>
		           <table border="0" cellspacing="0" cellpadding="0">
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
	</div>
	<div align="center">
		<button type="button" name="button" style="width:80%;height:50px;border:0;outline:0;background:#0575E6;color:white;border-radius:10px;" onclick="annual_input_view()">연차신청서 작성</button>
	</div>


	<!-- 일정수정 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
			<table>
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr class="admin_tr">
					<td align="center" height="40">서식명</td>
					<td>
						<select class="select-common select-style1 filter" onchange="categoryFilter();">
							 <option value="">전체</option>
							 <?php
							 foreach( $category as $ct){
									echo "<option value='{$ct['seq']}'";
									if(isset($_GET['filter'])){
										 if($ct['seq'] == $filter[0]){
												echo "selected";
										 }
									}
									echo ">{$ct['category_name']}</option>";
							 }
							 ?>
						</select>
					</td>
				</tr>
				<tr class="admin_tr">
					<td  align="center" height="40">양식명</td>
					<td>
						<input class="input-common filter" value="<?php if(isset($_GET['filter']) && count($filter) > 1){echo $filter[1];}?>" onKeypress="javascript:if(event.keyCode==13){categoryFilter();}"/ style="margin-right:10px;">
					</td>
				</tr>
				<tr>
					<td colspan="2" align ="center">
						<input type="button" class="btn-common btn-color1" style="width:45%; margin-right:5px;" value="취소" onclick="$('#search_div').bPopup().close();">
						<input type="button" class="btn-common btn-color2" style="width:45%" value="검색" onclick="categoryFilter();">
					</td>
				</tr>
			</table>
    </div>
  </div>
	<!-- 일정수정 모달 끝 -->

	<div align="center" style="padding:10px 0px 60px 0px;">
		<span style="color:red;">*</span>결재문서 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>

<script>
function eletronic_approval_view(seq,e){
	 if(!$(e.target).hasClass("bookmark")){
			<?php if($mode == "admin"){ ?>
			location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_form?seq="+seq+"&mode=modify";
			<?php }else{ ?>
			location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_input?seq="+seq;
			<?php }?>
	 }
}

function approval_form_input(){
	 location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_form?mode=input";
}

function categoryFilter(){
	 var filter ='';
	 for(var i=0; i < $(".filter").length; i++){
		 if(i==0){
			 filter = $(".filter").eq(i).val().trim();
		 }else{
			 filter += ","+ $(".filter").eq(i).val().trim();
		 }
	 }
	 location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_form_list?mode=<?php echo $mode; ?>&filter="+filter;
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
	console.log(nPage);
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

//연차신청서 쓰러가깅
function annual_input_view(){
	 location.href='<?php echo site_url();?>/biz/approval/electronic_approval_doc_input?seq=annual';
}



function change_lpp(){
	var lpp = $("#listPerPage").val();
	document.cform.lpp.value = lpp;
	document.cform.submit();
}


function open_search() {
	$('#search_div').bPopup();
}

</script>
</body>
</html>

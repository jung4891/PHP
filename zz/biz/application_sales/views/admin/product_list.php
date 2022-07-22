<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

	if(searchkeyword == ""){
		alert( "검색어를 입력해 주세요." );
		return false;
	}

	document.mform.action = "<?php echo site_url();?>/admin/company/product_list";
	document.mform.cur_page.value = "";
//	document.mform.search_keyword.value = searchkeyword;
	document.mform.submit();
}
//$(document).ready(function() {
//   $('li > ul').show();
//});
</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
  <div class="dash1-1">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="width:95%">
			<form name="mform" action="<?php echo site_url();?>/admin/company/product_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
			<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
			<input type="hidden" name="seq" value="">
			<input type="hidden" name="mode" value="">
			<tbody height="100%">
			<!-- 타이틀 부분 시작 -->
				<tr height="5%">
				  <td class="dash_title">
						제품명
					</td>
				</tr>
				<tr>
					<td height="70"></td>
				</tr>
				<!-- 타이틀 부분 끝 -->
				<!-- 검색 부분 시작 -->
        <tr height="10%">
          <td align="left" valign="bottom">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
              <!-- 검색창 -->
	                <select name="search2" id="search2" class="select-common" style="margin-right:10px; width:140px;">
		                <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>제품명</option>
		                <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>제조사</option>
					          <option value="003" <?php if($search2 == "003"){ echo "selected";}?>>품목</option>
	              	</select>
                  <span>
										<input type="text" style="margin-right:10px; width:240px;" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
									</span>
                  <span>
										<input class="btn-common btn-style2" type="button" onclick="return GoSearch();" value="검색" >
                  </span>
								</td>
								<td align="right">
									<?php
									if($admin_lv > 0) {
										?>
										<input class="btn-common btn-color2" type="button" onclick="$('#product_input').bPopup();" value="추가" >
										<?php
									}
									?>
								</td>
							</tr>
		      	</table>
		  		</td>

				</tr>
				<!-- 콘텐트시작 -->
				<tr height="45%">
					<td valign="top" style="padding:15px 0px;">
						<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<table width="100%" class="month_tbl list" border="0" cellspacing="0" cellpadding="0">
										<colgroup>
											<col width="10%"/>
	                    <col width="8%"/>
	                    <col width="15%"/>
											<col width="15%"/>
											<col width="15%"/>
											<col width="27%"/>
											<col width="10%"/>
                		</colgroup>
	                  <tr class="t_top row-color1">
											<th></th>
											<!-- <th height="40" align="center">No.</th> -->
	                    <th height="40" align="center">번호</th>
	                    <th align="center">제품명</th>
	                    <th align="center">제조사</th>
	                    <th align="center">품목</th>
	                    <th align="center">하드웨어스펙</th>
											<th></th>
	                  </tr>
<?php
	if ($count > 0) {
		$i = $count - $no_page_list * ( $cur_page - 1 );
		$icounter = 0;

		foreach ( $list_val as $item ) {
?>
	                 	<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
										  <td></td>
	                    <td height="40" align="center"><?php echo $i;?></td>
	                    <td  align="center"><?php echo $item['product_name'];?></td>
	                    <td  align="center"><?php echo $item['product_company'];?></td>
	                    <td  align="center"><?php echo $item['product_item'];?></td>
	                    <td  align="center"><?php echo $this->common->trim_text($item['hardware_spec'], 100);?></td>
											<td></td>
	                  </tr>
<?php
			$i--;
			$icounter++;
		}
	} else {
?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                  		<td width="100%" height="40" align="center" colspan="5">등록된 게시물이 없습니다.</td>
	                  </tr>
<?php
	}
?>
              		</table>
								</td>
	            </tr>
	              <!--//리스트-->
<script language="javascript">
function GoFirstPage (){
	document.mform.cur_page.value = 1;
	document.mform.submit();
}

function GoPrevPage (){
	var	cur_start_page = <?php echo $cur_page;?>;

	document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
	document.mform.submit( );
}

function GoPage(nPage){
	document.mform.cur_page.value = nPage;
	document.mform.submit();
}

function GoNextPage (){
	var	cur_start_page = <?php echo $cur_page;?>;

	document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
	document.mform.submit();
}

function GoLastPage (){
	var	total_page = <?php echo $total_page;?>;
//	alert(total_page);

	document.mform.cur_page.value = total_page;
	document.mform.submit();
}

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/admin/company/product_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
						</table>
					</td>
				</tr>
<!-- 컨텐트 테이블 끝 -->
			  <tr height="40%">
        	<td align="left" valign="top">
						<table width="100%" cellspacing="0" cellpadding="0">
				    	<tr>
				      	<td width="19%">
				        	<tr height="20%">
				          	<td align="center" valign="top">
<?php
	if ($count > 0) {
?>
											<table width="400" border="0" cellspacing="0" cellpadding="0">
                  		<tr>
<?php
		if ($cur_page > 10){
?>
		                    <td width="19">
													<a href="JavaScript:GoFirstPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/>
													</a>
												</td>
		                    <td width="2"></td>
		                    <td width="19">
													<a href="JavaScript:GoPrevPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" height="20"/>
													</a>
												</td>
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
				$strSection = "&nbsp;<span class=\"section\">&nbsp;&nbsp;</span>&nbsp;";
			}

			if  ( $i == $cur_page ) {
				echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
			} else {
				echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
			}
		}
?>
												</td>
<?php
		if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
?>
												<td width="19">
													<a href="JavaScript:GoNextPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/>
													</a>
												</td>
		                    <td width="2"></td>
		                    <td width="19">
													<a href="JavaScript:GoLastPage()">
														<img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height="20"/>
													</a>
												</td>
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
<?php
	}
?>
										</td>
            			</tr>
              <!--//페이징-->
            		</td>
			        </tr>

			      </table>
		      </td>
		    </tr>
			</form>
		</table>
	</div>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->


<!-- 제품 추가 모달 시작 -->
<div id="product_input" style="display:none; position: absolute; background-color: white; width: 650px; height: 470px; border-radius: 5px;">
  <form name="cform" id="cform" action="<?php echo site_url();?>/admin/company/product_input_action" method="post" onSubmit="javascript:chkForm();return false;" enctype="multipart/form-data">
    <table style="margin:10px 30px; border-collapse: separate; border-spacing: 0 30px;">
			<colgroup>
				<col width="15%" />
				<col width="30%" />
				<col width="25%" />
				<col width="30%" />
			</colgroup>
			<tr>
				<td colspan="4" class="modal_title" align="left" style="padding-bottom:10px; font-size:20px; font-weight:bold;">
					제품명
				</td>
      </tr>
      <tr>
        <td align="left" valign="center" style="font-weight:bold;">
          제품명
        </td>
				<td align="left">
					<input type="text" id="product_name" name="product_name" value="" class="input-common" style="width:180px;">
				</td>
        <td align="left" valign="center" style="font-weight:bold; padding-left:20px;">
          하드웨어/소프트웨어
        </td>
				<td align="left">
					<select name="product_type" id="product_type" class="select-common" onChange="changekm();" style="width:185px;">
						<option value="" selected >하드웨어/소프트웨어</option>
						<option value="hardware">하드웨어</option>
						<option value="software">소프트웨어</option>
						<option value="appliance">어플라이언스</option>
					</select>
				</td>
      </tr>
      <tr>
        <td align="left" valign="center" style="font-weight:bold;">
          제조사
        </td>
				<td align="left">
					<input type="text" name="product_company" id="product_company" class="input-common" style="width:180px;">
				</td>
        <td align="left" valign="center" style="font-weight:bold; padding-left:20px;">
          품목
        </td>
				<td align="left">
					<input type="text" name="product_item" id="product_item" class="input-common" style="width:180px;">
				</td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-weight:bold;">
          하드웨어스펙
        </td>
				<td colspan="3" align="left">
					<textarea name="hardware_spec" id="hardware_spec" class="input-common" style="width:100%; height:150px; resize:none;"></textarea>
					<!-- <textarea name="hardware_spec" id="hardware_spec" class="input-common" style="width:95%; height:240px; resize:none; padding:5px 10px;"></textarea> -->
				</td>
      </tr>
			<tr>
				<td colspan="4" align="right">
					<!--지원내용 추가 버튼-->
					<input type="button" class="btn-common btn-color1" style="width:70px; margin-right:10px;" value="취소" onclick="$('#product_input').bPopup().close()">
					<input type="button" class="btn-common btn-color2" style="width:70px;" value="등록" onclick="javascript:chkForm();return false;">
				</td>
			</tr>
    </table>
  </form>
</div>
<!-- 제품 추가 모달 끝  -->
<script language="javascript">
function chkForm () {
	var mform = document.cform;

	if (mform.product_name.value == "") {
		mform.product_name.focus();
		alert("제품명을 입력해 주세요.");
		return false;
  }
  if (mform.product_name.value.indexOf(',') != -1){
    alert("제품명에 , 를 입력하실 수 없습니다.");
    $("#product_name").focus();
    return false;
  }
  if (mform.product_item.value.indexOf(',') != -1){
    alert("품목에 , 를 입력하실 수 없습니다.");
    $("#product_item").focus();
    return false;
  }
	if (mform.product_company.value == "") {
		mform.product_company.focus();
		alert("제조사를 입력해 주세요.");
		return false;
	}
	if (mform.product_item.value == "") {
		mform.product_item.focus();
		alert("품목을 입력해 주세요.");
		return false;
	}
	if (mform.hardware_spec.value == "") {
		mform.hardware_spec.focus();
		alert("하드웨어 스팩을 입력해 주세요.");
		return false;
	}
  if (mform.product_type.value == "") {
		mform.hardware_spec.focus();
		alert("하드웨어/소프트웨어를 구분해 주세요.");
		return false;
	}

	mform.submit();
	return false;
}

</script>



</body>
</html>

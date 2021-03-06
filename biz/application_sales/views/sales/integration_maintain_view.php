<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
.basic_td{
	border:1px solid;
	border-color:#d7d7d7;
	padding:0px 10px 0px 10px;
}
.basic_table{
	border-collapse:collapse;
	border:1px solid;
	border-color:#d7d7d7;
}
</style>
<body>
    <table width="100%" height="100%" cellspacing="0" cellpadding="0" style="padding:30px 30px 30px 30px" >
        <tr>
            <td width="100%" align="center" valign="top">
            <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">통합 유지보수 뷰 </td>
              </tr>
              <!--타이틀-->
              <tr>
                <td height=30></td>
              </tr>
              <tr>
                <td>
					<table class="basic_table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="9" height="2" bgcolor="#797c88"></td>
						</tr>
						<tr>
							<td width="30%" height=40 align="center" bgcolor="f8f8f9" class="basic_td t_top">프로젝트명</td>
							<td class="basic_td">
								<?php echo $view_val['project_name']; ?>
							</td>
						</tr>
					</table>
           		 </td>
       		  </tr>
			  <tr>
			  	<td height="40"></td>
			  </tr>
			  <tr>
			  	<td height="40" style="font-weight:bold;font-size:15px;">제품정보</td>
			  </tr>
				<tr>
					<td>
						<table style="width:100%;border-collapse:collapse">
						<tr>
							<td><input type="checkbox" id="allCheck" /></td>
						</tr>
						<?php
						foreach ($view_val2 as $item) {?>
								<!--시작라인-->
								<tr>
									<td colspan="9" height="1" bgcolor="#797c88"></td>
								</tr>
								<tr>
									<td rowspan=2 bgcolor="f8f8f9"><input type="checkbox" name="product_row" value="<?php echo $item['seq']; ?>" style="float:left;" /></td>
									<td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
									<td width="20%" align="left" class="t_border" style="padding-left:10px;"><?php echo $item['product_company']; ?></td>
									<td width="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
									<td width="20%" align="left" class="t_border" style="padding-left:10px;">
										<?php echo $item['product_type']; ?>
									</td>
									<td width="15%" height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">품목(용도)</td>
									<td width="15%" align="left" class="t_border" style="padding-left:10px;">
										<?php echo $item['product_item']; ?>
									</td>
								</tr>

								<tr>
									
									<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
									<td align="left" class="t_border" style="padding-left:10px;">
										<input type="hidden" name ="product_seq" id="product_seq" value="<?php echo $item['seq']; ?>" />
										<?php echo $item['product_name'] ;?>
									</td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
									<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item['product_licence']; ?></td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
									<td align="left" class="t_border" style="padding-left:10px;"><?php echo $item['product_serial']; ?></td>
								</tr>
							<?php
						}
						?>
						<tr>
							<td colspan="9" height="1" bgcolor="#797c88"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			 <tr>
				<td>
					<input type="button" class="basicBtn" value="유지보수 제품 등록" style="cursor:pointer;" onclick="integration_maintain_add();"/>
					<span style="float:right;">
						<img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" style="cursor:pointer;" onclick="location.href='<?php echo site_url();?>/sales/maintain/integration_maintain_list'"/>
						<img src="<?php echo $misc;?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer;" onclick="modify();"/>
						<img src="<?php echo $misc;?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer;" onclick="integrationDelete();"/>
					</span>
				</td>
			 </tr>
     </table>
	 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script> 
// 수정하러가기
function modify(){
	location.href="<?php echo site_url();?>/sales/maintain/integration_maintain_input?seq=<?php echo $_GET['seq']; ?>";
}

//전체선택 체크박스 클릭 
$(function () {
	$("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우 
		if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다 
			$("input[name=product_row]").prop("checked", true); // 전체선택 체크박스가 해제된 경우 
		} else { //해당화면에 모든 checkbox들의 체크를해제시킨다. 
			$("input[name=product_row]").prop("checked", false);
		}
	})
})


// 통합유지보수시킬 제품들 등록
function integration_maintain_add(){
	var maintain_seq = $(opener.document).find("#seq").val();
	var product_seq = "";
	if($('input:checkbox[name="product_row"]:checked').length > 0){
		$('input:checkbox[name="product_row"]').each(function () {
			if (this.checked == true) {
				if(product_seq == ""){
					product_seq += this.value;
				}else{
					product_seq += ','+this.value;
				}
			}
		});
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/sales/maintain/integration_maintain_add",
			dataType: "json",
			async: false,
			data: {
				maintain_seq: maintain_seq,
				product_seq: product_seq
			},
			success: function(data) {
				if(data){
					alert("성공");
					opener.location.reload();
					self.close();
				}else{
					alert("실패");
				}
			}
		})
	}else{
		alert("선택된 제품이 없습니다.");
		return false;
	}
}

//통합유지보수 삭제
function integrationDelete(){
	var seq = "<?php echo $_GET['seq']; ?>";
	if(confirm("해당 통합유지보수를 삭제하시겠습니까?")){
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/sales/maintain/integrationDelete",
			dataType: "json",
			async: false,
			data: {
				seq: seq,
			},
			success: function(data) {
				if(data){
					alert("삭제되었습니다.");
					location.href = "<?php echo site_url();?>/sales/maintain/integration_maintain_list";
				}else{
					alert("삭제 실패");
				}
			}
		})
	}else{
		return false;
	}

}
	
</script>
</body>
</html>

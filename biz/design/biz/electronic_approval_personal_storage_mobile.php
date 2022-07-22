<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="/misc/css/view_page_common.css">
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
	 padding-top:20px;
	 padding-bottom:20px;
	}
	.content_list_tbl {
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.content_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}

	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
    box-sizing : border-box !important;
	}
  .basic_table{
		width:100%;
		 border-collapse:collapse;
		 border:1px solid;
		 border-color:#DEDEDE;
		 table-layout: auto !important;
		 border-left:none;
		 border-right:none;
	}

	.basic_table td{
		height:35px;
		 padding:0px 10px 0px 10px;
		 border:1px solid;
		 border-color:#DEDEDE;
	}
	.border_n {
		border:none;
	}
	.border_n td {
		border:none;
	}
	.basic_table tr > td:first-child {
		border-left:none;
	}
	.basic_table tr > td:last-child {
		border-right:none;
	}
	.select_box {
		background-color: rgb(5, 117, 230, 0.6);

	}
	.box_name {
		padding-left: 10px;
	}
	</style>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
  <div class="menu_div">
		<a class="menu_list" onclick ="moveList('electronic_approval_delegation_management')">위임관리</a>
		<a class="menu_list" style='color:#0575E6'>개인보관함관리</a>
	</div>

  <div style="width:90%;margin: 0 auto;margin-top:10px;">
    <table id="storage_table" class="basic_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:16px;">
      <colgroup>
        <col width="30%">
        <col width="40%">
        <col width="10%">
        <col width="20%">
      </colgroup>
      <tr bgcolor="#F4F4F4">
        <td colspan="3" style="font-weight:bold;">CATEGORY</td>
        <td colspan="1" align="center">
          <img src="<?php echo $misc; ?>img/mobile/btn_plus_big.svg" height="100%" onclick="storageBtn('new');">
        </td>
      </tr>
  <?php
  if(!empty($view_val)) {
    foreach($view_val as $val) {
      if($val['parent_id'] == 0 && $val['cnt'] == 0) { ?>
      <tr>
        <td colspan="3" seq='<?php echo $val['seq'] ?>' onclick="box_select(this, '<?php echo $val['seq']; ?>')">
					<?php echo $val['storage_name']; ?>
				</td>
        <td colspan="1"></td>
      </tr>
<?php } else if ($val['parent_id'] == 0 && $val['cnt'] > 0) { ?>
      <tr id="box_<?php echo $val['seq'] ?>" class="box_<?php echo $val['seq'] ?>">
        <td colspan="3" class="box_name" seq='<?php echo $val['seq'] ?>' onclick="box_select(this, '<?php echo $val['seq']; ?>')">
					<?php echo $val['storage_name']; ?>
				</td>
        <td colspan="1" align="center">
					<img class="Btn" src="<?php echo $misc; ?>img/mobile/allow_down.svg" onclick="viewMore('<?php echo $val['seq']; ?>','box_<?php echo $val['seq']; ?>', this)">
				</td>
      </tr>
			<!-- <tbody></tbody> -->
<?php }
    }
  }
   ?>
	 	<tr height="40" class="input_tr" style="display:none;">
	 	<tr class="input_tr" style="display:none;">
			<td>보관함명</td>
	 		<td colspan="3">
				<input type="hidden" id="save_type" name="save_type" value="" />
				<input type="hidden" id="storage_seq" name="storage_seq" value="" />
				<input type="hidden" id="parent_id"  name="parent_id" value="" />
				<input type="text" id="storage_name" name="storage_name" class="input-common" value="" style="width:100%;border:none;" placeholder="보관함명 입력">
			</td>
	 	</tr>
    </table>
		<div class="btn_div" style="margin-top:10px;text-align:center;display:none;">
			<input type="button" class="btn-common btn-color1" value="추가" onclick="storageBtn(1);" style="width:32%">
			<input type="button" class="btn-common btn-color1" value="수정" onclick="storageBtn(2);" style="width:32%">
			<input type="button" class="btn-common btn-color2" value="삭제" onclick="storageBtn(3);" style="width:32%">
		</div>
		<div class="save_div" style="margin-top:10px;text-align:center;display:none;">
			<input type="button" class="btn-common btn-color2" value="저장" onclick="storageSave();" style="width:100%;">
		</div>
  </div>
	<div style="padding-bottom:60px;width:90%;margin:0 auto;">
		<p style="margin-top:40px;">
			<span style="color:#1C1C1C">개인보관함 생성 방법 : </span>
			<span style="color:#A1A1A1">상위 개인보관함을 선택하고 추가 버튼을 누른 뒤 보관함명을 입력하고 저장 버튼을 선택합니다. <br>(최상위 보관함을 만들 경우 우측 상단의 + 버튼을 선택합니다.)</span>
		</p>
		<p style="">
			<span style="color:#1C1C1C">개인보관함 수정 방법 : </span>
			<span style="color:#A1A1A1">수정할 개인보관함을 선택하고 수정 버튼을 누른 뒤 수정할 보관함명을 입력하고 저장 버튼을 선택합니다.</span>
		</p>
		<p style="">
			<span style="color:#1C1C1C">개인보관함 삭제 방법 : </span>
			<span style="color:#A1A1A1">삭제할 개인보관함을 선택하고 삭제 버튼을 선택합니다.</span>
		</p>
	</div>

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>

</body>

<script type="text/javascript">
	//보관함 전체열어!!!!!!!!
	$(".Btn").trigger("click");

	function moveList(type){
		 location.href="<?php echo site_url();?>/biz/approval/"+type;
	}

	function box_select(el, seq) {
		$('.input_tr').hide();
		$('.btn_div').hide();
		$('.save_div').hide();
		if($(el).hasClass('select_box')) {
			$(el).removeClass('select_box');
		} else {
			$(".select_box").each(function() {
				$(this).removeClass('select_box');
			})
			$(el).addClass('select_box');
			$('#storage_seq').val($(el).attr('seq'));
			$('#storage_name').val($.trim($(el).html()));
			$('.btn_div').show();
		}
	}

	//보관함 추가/수정/삭제버튼클릭
	function storageBtn(type){
		$(".btn_div").hide();
		if(type != 3) {
			$('.save_div').show();
		}
		var seq = $('.select_box').attr('seq');
		var storage_name = $.trim($('.select_box').text());
		console.log(seq);
		console.log(storage_name);

		 if(type == 1){ //추가버튼 클뤽
				$("#save_type").val(type);
				$("#parent_id").val(seq);
				$("#storage_name").val('');
				$(".input_tr").show();
		 }else if(type == 2){ //수정버튼 클뤽
			 if ($('.select_box').length == 0) {
				 alert('수정할 보관함을 선택해주세요.');
				 return false;
			 }
				$("#save_type").val(type);
				$("#storage_seq").val(seq);
				$("#storage_name").val(storage_name);
				$(".input_tr").show();
		 } else if(type =='new'){
			 $(".select_box").each(function() {
 				$(this).removeClass('select_box');
 			})
			 $("#save_type").val(1);
			 $("#parent_id").val(0);
			 $("#storage_name").val('');
			 $(".input_tr").show();
		 } else {
			 $('#save_type').val(3);
			 $('#storage_seq').val(seq);
			 storageSave();
		 }

	}

	//보관함 추가/수정/삭제
	function storageSave(){
		 var t = $("#save_type").val();
		 if( t == 1 ) { // 추가
				$.ajax({
					 type: "POST",
					 cache: false,
					 url: "<?php echo site_url(); ?>/biz/approval/storageSave",
					 dataType: "json",
					 async :false,
					 data: {
							type : t,
							storage_name: $("#storage_name").val(),
							parent_id: $("#parent_id").val()
					 },
					 success: function (result) {
							if(result){
								 alert("저장되었습니다.");
								 location.reload();
							}else{
								 alert("저장 실패");
							}

					 }
				});
		 }else if(t == 2){ // 수정
				$.ajax({
					 type: "POST",
					 cache: false,
					 url: "<?php echo site_url(); ?>/biz/approval/storageSave",
					 dataType: "json",
					 async :false,
					 data: {
							type : t,
							storage_name: $("#storage_name").val(),
							seq: $("#storage_seq").val()
					 },
					 success: function (result) {
							if(result){
								 alert("수정 완료");
								 location.reload();
							}else{
								 alert("수정 실패");
							}
					 }
				});
		 }else if(t == 3){ // 삭제
				// alert($("#storage_seq").val());
				if (confirm("하위 보관함까지 모두 삭제됩니다. 삭제하시겠습니니까?")) {
					 $.ajax({
							type: "POST",
							cache: false,
							url: "<?php echo site_url(); ?>/biz/approval/storageSave",
							dataType: "json",
							async: false,
							data: {
								 type: t,
								 seq: $("#storage_seq").val()
							},
							success: function (result) {
								 if (result) {
										alert("삭제 완료");
										location.reload();
								 } else {
										alert("삭제 실패");
								 }
							}
					 });
				}
		 }
	}

	//개인보관함 열기 +버튼 눌러서 하위 목록 보기
	function viewMore(seq,id,obj){
		 var src = "<?php echo $misc; ?>img/mobile/allow_down.svg";
		 $(obj).attr('src', src);
		 // console.log($(obj).attr('onclick'))
		 $(obj).attr('onclick',"viewHide('"+id+"',this)");
		 var padding = $('#'+id).find('.box_name').css('padding-left');
		 padding = padding.replace(/[^0-9]/g, '');
		 padding = 10 + Number(padding);
		 var tree = '';
		 if (padding > 0) {
			 tree = '└ ';
		 }
		 var tr_class = $('#'+id).attr('class');
		 $.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url(); ?>/biz/approval/storageView",
				dataType: "json",
				async :false,
				data: {
					 seq:seq
				},
				success: function (result) {
					 var html = "";
					 for(i=0; i<result.length; i++){
							if(result[i].cnt > 0){
								html += "<tr id='box_"+result[i].seq+"' class='"+tr_class+" box_"+result[i].seq+"'><td colspan='3' class='box_name' seq='"+result[i].seq+"' onclick='box_select(this, "+'"'+result[i].seq+'"'+")' style='padding-left:"+padding+"px'>"+tree +result[i].storage_name + "</td>";
								html += "<td colspan='1' align='center'><img class='Btn' src='<?php echo $misc; ?>img/mobile/allow_up.svg' onclick='viewMore("+result[i].seq+","+'"box_'+result[i].seq+'"'+",this)'></td></tr>";
							}else{
								html += "<tr id='box_"+result[i].seq+"' class='"+tr_class+" box_"+result[i].seq+"'><td colspan='3' seq='"+result[i].seq+"' onclick='box_select(this, "+'"'+result[i].seq+'"'+")' style='padding-left:"+padding+"px'>"+tree + result[i].storage_name + "</td>";
								html += "<td colspan='1'></td></tr>";
							}
					 }
					 $("#"+id).after(html);
					 $('#storage_table img').each(function() {
						 if($(this).attr('src') == '<?php echo $misc; ?>img/mobile/allow_up.svg') {
							 // console.log($(this).closest('tr').find('.box_name').text());
							 console.log($(this).attr('onclick'));
							 $(this).trigger("click");
						 }
					 })

				}
		 });
	}

	//개인보관함 숨기기
	function viewHide(id,obj){
		 var src = "<?php echo $misc; ?>img/mobile/allow_up.svg";
		 $(obj).attr('src', src);
		 $(obj).attr('onclick',"viewShow('"+id+"',this)");
		 $("." + id).hide();
		 $(obj).closest('tr').show();
	}

	//개인보관함 다시열어!
	function viewShow(id,obj){
		 var src = "<?php echo $misc; ?>img/mobile/allow_down.svg";
		 $(obj).attr('src', src);
		 $(obj).attr('onclick',"viewHide('"+id+"',this)");
		 $("." + id).show();
		 $(obj).closest('tr').show();
	}
</script>

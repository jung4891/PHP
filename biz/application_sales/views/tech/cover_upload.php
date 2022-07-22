<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/customer_top.php";
?>
<form enctype='multipart/form-data' action='<?php echo site_url();?>/tech_board/cover_upload_ok' method='post'>
	<input type='file' name='myfile'>
	<button>표지 업로드</button>
</form>

<div style="margin-top:50px;">< 등록된 표지 목록 ></div>
<div style="margin-top:10px;">
	<?php foreach($cover as $co){
	?>
		<div>
			<?php echo $co['cover_name']; ?>
			<input type='button' value='삭제' onclick="coverDelete('<?php echo $co['cover_name'];?>','<?php echo $co['seq'];?>');" style="margin-left:10px;">
			<input type='button' value='위치고정' onclick='imageCoordinate("<?php echo $co['seq']; ;?>");' style="margin-left:10px;">
		</div>
		<img src='<?php echo $misc; ?>/img/cover/<?php echo $co['cover_name']; ?>' width='200px' height='300px'/>
	<?php } ?>
</div>

<script>
	function coverDelete(cover,seq){
		var con = confirm("정말 삭제하시겠습니까?");
		if(con == true){
			window.open('/index.php/tech_board/cover_delete?filename=' + cover +'&seq=' + seq ,'_blank');
		}else{
			return false;
		}
	}

	//이미지 좌표 찍으러가깅
	function imageCoordinate(seq) {
		window.open('/index.php/tech_board/cover_coordinate?seq=' + seq, '_blank', 'scrollbars=yes,width=850,height=600');
	}

</script>

<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/customer_top.php";
?>
<form enctype='multipart/form-data' action='<?php echo site_url();?>/tech_board/logo_upload_ok' method='post'>
	<input type='file' name='myfile'>
	<button>로고 업로드</button>
</form>

<div style="margin-top:50px;">< 등록된 로고 목록 ></div>
<div style="margin-top:10px;">
	<?php foreach($cover as $co){
		$fileEncording = iconv("UTF-8","EUC-KR",$co);
	?>
		<div>
			<?php echo $co;?>
			<input type='button' value='삭제' onclick='logoDelete("<?php echo $co ;?>");' style="margin-left:10px;">
		</div>
		<img src='<?php echo $misc; ?>/img/logo/<?php echo $co; ?>' width='200px' height='100px'/>
	<?php } ?>
</div>

<script>
	function logoDelete(cover){
		var con = confirm("정말 삭제하시겠습니까?");
		if(con == true){
			window.open('/index.php/tech_board/logo_delete?filename=' + cover ,'_blank');
		}else{
			return false;
		}
	}
</script>

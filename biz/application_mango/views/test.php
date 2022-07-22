<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css_mango/view_page_common_mango.css">
<link rel="stylesheet" href="/misc/css_mango/dunkin_menu_mango.css">
<style media="screen">
#dunkin_menu .main {
	font-weight: bold;
}
li {
	list-style: none;
}
.gnb_depth2 {
	width: 20%;
	float: left;
}
#dunkin_menu {
	padding-bottom: 50px;
}
.hashtag, .btn_buy {
	display:none !important;
}
.list_dom {
	border-radius:0 0 5px 5px; border:1px solid #d1b6a3; border-top:0; background:#fcfaf1;
}
</style>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/mango_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<tbody height="100%">
<div style="width:1200px;margin: 0 auto;">
	<?php
	$get_top = $_GET['top'];
	if(isset($_GET['sub'])) {
		$get_sub = $_GET['sub'];
	}
	if(isset($_GET['Page'])) {
		$get_page = $_GET['Page'];
	}

	$url = "https://www.dunkindonuts.co.kr/";

	if(!isset($get_sub)) {
		$url = "https://www.dunkindonuts.co.kr/menu/main.php?top=".$get_top;
	} else if (!isset($get_page)) {
		$url = "https://www.dunkindonuts.co.kr/menu/list.php?top=".$get_top.'&sub='.$get_sub;
	} else {
		$url = "https://www.dunkindonuts.co.kr/menu/list.php?top=".$get_top.'&sub='.$get_sub.'&Page='.$get_page;
	}

	$html = file_get_html($url);

	echo "<div id='dunkin_menu'>";
	foreach($html->find('.content_2') as $depth2) {
		foreach($depth2->find('.content_inner') as $ci) {
			foreach($ci->find('.gnb_depth1', 3)->find('.gnb_depth2') as $gd1) {
				echo $gd1;
			}
		}
	}
	echo "</div>";

	echo "<div id='menu_container' style='width: 1200px;margin: 0 auto'>";
	foreach($html->find('#content') as $mc) {
		echo $mc;
	}
	echo "</div>";

	?>

</tbody>
</table>
</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/mango_bottom.php"; ?>
</body>
<script type="text/javascript">
	$('#menu_container').find('img').each(function() {
		var src = $(this).attr('src');
		// console.log(src);
		$(this).attr('src', '	https://www.dunkindonuts.co.kr/' + src);
	})

	$('#dunkin_menu').find('a').each(function() {
		var href = $(this).attr('href');

		var get = href.split('?')[1];

		$(this).attr('href', '<?php echo site_url(); ?>/test/test22?'+get);
	})

	$('#menu_container').find('a').each(function() {
		var html = $(this).html();
		var this_class= $(this).attr('class');
		if(!$(this).hasClass('btn_buy') && $(this).closest('nav').attr('class') != 'pagination') {
			$(this).replaceWith('<div class="'+this_class+'">'+html+'</div>');
		}
	})

	$('.pagination').find('a').each(function() {
		var href = $(this).attr('href');

		var get = href.split('?')[1];

		$(this).attr('href', '<?php echo site_url(); ?>/test/test22?' + get);
	})
</script>
</html>

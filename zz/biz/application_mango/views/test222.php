<style media="screen">
	.hashtag, .btn_buy {
		display:none;
	}
</style>
<?php
$get_top = $_GET['top'];
if(isset($_GET['sub'])) {
	$get_sub = $_GET['sub'];
}

$url = "https://www.dunkindonuts.co.kr/";

if(!isset($_get_sub)) {
	$url = "https://www.dunkindonuts.co.kr/menu/main.php?top=".$get_top;
} else {
	$url = "https://www.dunkindonuts.co.kr/menu/main.php?top=".$get_top.'&sub='.$get_sub;
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

echo "<div id='menu_container'>";
foreach($html->find('#content') as $mc) {
	echo $mc;
}
echo "</div>";

?>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	$('img').each(function() {
		var src = $(this).attr('src');
		$(this).attr('src', '	https://www.dunkindonuts.co.kr/' + src);
	})

	$('#dunkin_menu').find('a').each(function() {
		console.log($(this).attr('href'));
		var href = $(this).attr('href');

		var get = href.split('?')[1];

		$(this).attr('href', '<?php echo site_url(); ?>/test/test22?'+get);
	})
</script>

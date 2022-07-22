<script>
	window.addEventListener('DOMContentLoaded', function(){
		$("#sidebar_left").height($("#main_contents").height());

		// var path = $(location).attr('pathname');
		// if(path=='/'){
		// 	location.href ='<?php echo site_url();?>/biz/';
		// 	}
		//
	  // var path = path.split('/');
	  // var manu = path[2];
	  // switch (manu) {
		// 	case 'biz':
		// 	// change_sidebar(menu, 'load');
		// 		$("#biz_head").click();
		// 		break;
		//
		// 	case 'sales':
		// 		$("#sales_head").click();
		// 		break;
		//
		// 	case 'tech':
		// 		$("#tech_head").click();
		// 		break;
		//
	  //   case 'admin':
		// 		$("#admin_head").click();
		// 		break;
		//
		// }
		<?php

		if(strpos($_SERVER['REQUEST_URI'],'biz/approval/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'approval')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'sales/forcasting/order_completed') !== false || strpos($_SERVER['REQUEST_URI'],'/sales/forcasting/forcasting_list?mode=mistake') !== false){

			echo "sessionStorage.setItem('sidemanu', 'order_completed')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'sales/maintain/maintain_list') !== false || strpos($_SERVER['REQUEST_URI'],'sales/maintain/maintain_unissued') !== false) {

			echo "sessionStorage.setItem('sidemanu', 'maintain')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'sales/fundreporting/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'fund_reporting')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'tech/board/manual_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/faq_') !== false){

			echo "sessionStorage.setItem('sidemanu', 'notice')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'tech/board/edudata_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/dailyWorkLog_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/study_document_') !== false){

			echo "sessionStorage.setItem('sidemanu', 'education')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'tech/maintain/') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/network_map_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/tech_board/tech_doc_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/tech_board/request_tech_support_') !== false ){

			echo "sessionStorage.setItem('sidemanu', 'customer')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'admin/equipment/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'equipment')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'admin/account/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'user')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'sales/funds/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'funds_list')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'admin/attendance_admin/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'attendance_admin')";
		}

		else if(strpos($_SERVER['REQUEST_URI'],'biz/attendance/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'attendance_user')";
		}
		else if(strpos($_SERVER['REQUEST_URI'],'admin/annual_admin/') !== false){

			echo "sessionStorage.setItem('sidemanu', 'annual_admin')";
		}

		else{
			echo "sessionStorage.setItem('sidemanu', 'none')";
		}

		?>



		var side_onoff = sessionStorage.getItem('subside');
		if(side_onoff == 'on'){

			// console.log(side_onoff);
<?php

if(strpos($_SERVER['REQUEST_URI'],'biz/approval/') !== false){
	echo "subside_open('approval');";
}

if(strpos($_SERVER['REQUEST_URI'],'sales/forcasting/order_completed') !== false || strpos($_SERVER['REQUEST_URI'],'/sales/forcasting/forcasting_list?mode=mistake') !== false){
	echo "subside_open('order_completed')";
}

if(strpos($_SERVER['REQUEST_URI'],'sales/maintain/maintain_list?type=001') !== false || strpos($_SERVER['REQUEST_URI'],'sales/maintain/maintain_list?type=002') !== false || strpos($_SERVER['REQUEST_URI'],'sales/maintain/maintain_unissued')) {
	echo "subside_open('maintain')";
}

if(strpos($_SERVER['REQUEST_URI'],'sales/fundreporting/') !== false){
	echo "subside_open('fund_reporting')";
}

if(strpos($_SERVER['REQUEST_URI'],'sales/purchase_sales/') !== false){
	echo "subside_open('purchase_sales')";
}

if(strpos($_SERVER['REQUEST_URI'],'tech/board/manual_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/faq_') !== false){
	echo "subside_open('notice')";
}

if(strpos($_SERVER['REQUEST_URI'],'tech/board/edudata_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/dailyWorkLog_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/study_document_') !== false){
	echo "subside_open('education')";
}

if(strpos($_SERVER['REQUEST_URI'],'tech/maintain/') !== false || strpos($_SERVER['REQUEST_URI'],'tech/board/network_map_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/tech_board/tech_doc_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/tech_board/request_tech_support_') !== false || strpos($_SERVER['REQUEST_URI'],'tech/tech_board/tech_issue')){

	echo "subside_open('customer')";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/equipment/') !== false){

	echo "subside_open('equipment')";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/account/') !== false){
	echo "subside_open('user')";
}

if(strpos($_SERVER['REQUEST_URI'],'sales/funds/') !== false){
	echo "subside_open('funds_list')";
}

if(strpos($_SERVER['REQUEST_URI'],'admin/attendance_admin/') !== false){
	echo "subside_open('attendance_admin')";
}

if(strpos($_SERVER['REQUEST_URI'],'biz/attendance/') !== false){
	echo "subside_open('attendance_user')";
}
if(strpos($_SERVER['REQUEST_URI'],'admin/annual_admin/') !== false){
	echo "subside_open('annual_admin')";
}

?>
}else{
	var side_manulist = sessionStorage.getItem('sidemanu');
	if(side_manulist!='none'){


		$("#sidebar_open_div").css({
			display:'inline-block'
		});
		// $("#sub_open_btn").removeAttr("onclick");

		// $("#main_contents").removeClass("main_content_extend");
		// $("#main_contents").addClass("main_content_cut");
		$("#main_contents").css({
			// min-width:'95%',
			width:'94%',
			position:'absolute',
			left:'105px'
		})
		// var path = $(location).attr('pathname');
		// var path = path.split('/');
		// var manu = path[3];
		$("#sub_open_btn").attr("onclick", "subside_open('"+side_manulist+"');");
		// $('#sub_open_btn').attr('id', manu);
	}

}
	});


var subside_open = function(menu){

	$(".sidenav3").hide();
	$("#sidebar_sub").show();
	$("#sidebar_sub").css({
		display:"inline-block"
	});
	$("#sidebar_open_div").hide();

	$("#main_contents").css({
		width:'80%',
		position:'',
		left:'',
	});
	$("#sidebar_sub").removeClass("sidebar_sub_off");
	$("#sidebar_sub").addClass("sidebar_sub_on");
	$("#main_contents").removeClass("main_content_extend");
	$("#main_contents").addClass("main_content_cut");
	switch (menu) {
		case 'approval':
			$("#approval_sidenav").show();
			break;

		case 'order_completed':
			$("#order_completed_sidenav").show();
			break;

		case 'maintain':
			$("#maintain_sidenav").show();
			break;

		case 'fund_reporting':
			$("#fundreporting_sidenav").show();
			break;

		case 'purchase_sales':
			$("#purchase_sales_sidenav").show();
			break;

		case 'notice':
			$("#manual_sidenav").show();
			break;

		case 'education':
			$("#education_sidenav").show();
			break;

		case 'customer':
			$("#customer_sidenav").show();
			break;

		case 'equipment':
			$("#equipment_sidenav").show();
			break;

		case 'user':
			$("#user_sidenav").show();
			break;

		case 'funds_list':
			$("#funds_list_sidenav").show();
			break;

		case 'attendance_admin':
			$("#attendance_admin_sidenav").show();
			break;
		case 'attendance_user':
			$("#attendance_user_sidenav").show();
			break;
		case 'annual_admin':
			$("#annual_admin_sidenav").show();
			break;
	}


	sessionStorage.setItem("subside", "on");
	$("#sidebar_left").height($("#main_contents").height());
 $(".sidebar_sub_on").height($("#main_contents").height());
}

// var subside_close = function(){
// 	$("#sidebar_sub").removeClass("sidebar_sub_on");
// 	$("#sidebar_sub").addClass("sidebar_sub_off");
// 	$("#main_contents").removeClass("main_content_cut");
// 	// $("#sidebar_open_div").show();
// 	$("#main_contents").addClass("main_content_extend");
//
//
// 	sessionStorage.setItem("subside", "off");
// }

var subside_close = function(){
	$("#sidebar_sub").hide();

	$("#sidebar_open_div").css({display:'inline-block'});

	$("#main_contents").css({
		width:'94%',
		position:'absolute',
		left:'105px'
	})

	sessionStorage.setItem("subside", "off");
}

var sub_open_btn =function(){
	$("#sidebar_sub").show();
	$("#sidebar_sub").css({
		display:"inline-block"
	});
	$("#sidebar_open_div").hide();

	$("#main_contents").css({
		width:'80%',
		position:'',
		left:''

	});
	sessionStorage.setItem("subside", "on");
}

console.log('<?php echo gethostbyname($_SERVER["HTTP_HOST"]); ?>')

</script>
</div>
</div>

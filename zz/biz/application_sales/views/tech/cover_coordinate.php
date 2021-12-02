<?php
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
?>
<html>
<head>
	<style>
		html,body{
			height:297mm;
			width:210mm;
		}

		.footer-space {
		   height: 35px;
		   width: 101%;
		}

		.header-space {
		   height: 25px;
		   width: 101%;
		}

		.footer {
		   position: fixed;
		   bottom: 0;
		   right: 0;
		   margin-right: 10px;
		}

		.header {
		   position: fixed;
		   top: 0;
		   right: 0;
		}

		.footer,
		.footer-space,
		.header,
		.header-space {
		   background-color: white;
		   border-color: white;
		}
		#both { resize: both; }


	   @media print {
		   table tr:not(.borderNone){outline:#000 solid thin\9;} td:not(.borderNone){outline:#000 solid thin\9;} #cover{-webkit-print-color-adjust: exact;}
	   }

	   @page {
		   margin: 2mm
	   }

	   .endline{page-break-before:always}
    </style>
    
	<title><?php echo $this->config->item('site_title');?></title>
	<link href="/misc/css/print_doc.css" type="text/css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="/misc/js/m_script.js"></script>
	<script type="text/javascript" src="/misc/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/misc/js/jquery.min.js"></script>
	<script type="text/javascript" src="/misc/js/common.js"></script>
	<script type="text/javascript" src="/misc/js/jquery.validate.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table id="cover" class="borderNone" border=0.5 cellpadding=0 cellspacing=0 height=1100 style='border-collapse:collapse;table-layout:fixed;width:100%;background-image:url("<?php echo $misc?>img/cover/<?php echo $cover[0]['cover_name']; ?>");background-size:100% 100%;'>
	<tr class="borderNone">
		<td colspan=2 class="borderNone">
			<input type="button" id="save" value='저장' onclick="save();">
		</td>
		<td class="borderNone"></td>
		<form name="cform" action="<?php echo site_url(); ?>/tech_board/cover_coordinate_update" method="post">
			<td>
				<input type="hidden" id="seq" name ="seq" value ="<?php echo $_GET['seq']; ?>" />
				<input type="hidden" id="durian_sign" name ="durian_sign" value ="" />
				<input type="hidden" id="customer_sign" name ="customer_sign" value ="" />
				<input type="hidden" id="subject" name ="subject" value ="" />
				<input type="hidden" id="income_time" name ="income_time" value ="" />
				<input type="hidden" id="customer_company" name ="customer_company" value ="" />
				<input type="hidden" id="writer" name ="writer" value ="" />
				<input type="hidden" id="durian_engineer" name ="durian_engineer" value ="" />
				<input type="hidden" id="customer_manager" name ="customer_manager" value ="" />
			</td>
		</form>
	</tr>
	<div id="durian_sign_div" style="width:200px;height:100px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<img id="d_sign_loc" src="<?php echo $misc; ?>img/<?php echo $name; ?>.png" style="position:absolute;width:100%" />
		</deckgo-drr>
	</div>

	<div id="customer_sign_div" style="width:200px;height:100px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<img id="c_sign_loc" src="<?php echo $misc; ?>img/customer_sign.png" style="position:absolute;width:100%" />
		</deckgo-drr>
	</div>

	<div id="subject_div" style="width:450px;height:50px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<input type="text" id="subject_loc" value="제목" />
		</deckgo-drr>
	</div>

	<div id="income_time_div" style="width:300px;height:40px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<input type="text" id="income_time_loc" value="점검날짜" />
		</deckgo-drr>
	</div>

	<div id="customer_company_div" style="width:300px;height:40px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<input type="text" id="customer_company_loc" value="고객사명" />
		</deckgo-drr>
	</div>

	<div id="writer_div" style="width:300px;height:40px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<input type="text" id="writer_loc" value="작성자" />
		</deckgo-drr>
	</div>

	<div id="durian_engineer_div" style="width:100px;height:40px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<input type="text" id="durian_enginner_loc" value="엔지니어이름" />
		</deckgo-drr>
	</div>

	<div id="customer_manager_div" style="width:100px;height:40px;position:absolute;">
		<deckgo-drr style="--width: 100%; --height: 100%; --top: 25%; --left: 10%;position:absolute;">
			<input type="text" id="customer_manager_loc" value="담당자이름" />
		</deckgo-drr>
	</div>

</table>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="module" src="https://unpkg.com/@deckdeckgo/drag-resize-rotate@latest/dist/deckdeckgo-drag-resize-rotate/deckdeckgo-drag-resize-rotate.esm.js"></script>
<script nomodule="" src="https://unpkg.com/@deckdeckgo/drag-resize-rotate@latest/dist/deckdeckgo-drag-resize-rotate/deckdeckgo-drag-resize-rotate.js"></script>
<script>
	$( "#durian_sign_div" ).draggable();
	$( "#customer_sign_div" ).draggable();
	$( "#subject_div" ).draggable();
	$( "#income_time_div" ).draggable();
	$( "#customer_company_div" ).draggable();
	$( "#writer_div" ).draggable();
	$( "#durian_engineer_div" ).draggable();
	$( "#customer_manager_div" ).draggable();

	function save(){
		$("#durian_sign").val($("#d_sign_loc").offset().top + "px," + $("#d_sign_loc").offset().left+"px,"+$("#d_sign_loc").height()+"px,"+$("#d_sign_loc").width()+"px");
		$("#customer_sign").val($("#c_sign_loc").offset().top + "px," + $("#c_sign_loc").offset().left+"px,"+$("#c_sign_loc").height()+"px,"+$("#c_sign_loc").width()+"px") 
		$("#subject").val($("#subject_loc").offset().top + "px," + $("#subject_loc").offset().left+"px,"+$("#subject_loc").height()+"px,"+$("#subject_loc").width()+"px") 
		$("#income_time").val($("#income_time_loc").offset().top + "px," + $("#income_time_loc").offset().left+"px,"+$("#income_time_loc").height()+"px,"+$("#income_time_loc").width()+"px") 
		$("#customer_company").val($("#customer_company_loc").offset().top + "px," + $("#customer_company_loc").offset().left+"px,"+$("#customer_company_loc").height()+"px,"+$("#customer_company_loc").width()+"px") 
		$("#writer").val($("#writer_loc").offset().top + "px," + $("#writer_loc").offset().left+"px,"+$("#writer_loc").height()+"px,"+$("#writer_loc").width()+"px") 
		$("#durian_engineer").val($("#durian_enginner_loc").offset().top + "px," + $("#durian_enginner_loc").offset().left+"px,"+$("#durian_enginner_loc").height()+"px,"+$("#durian_enginner_loc").width()+"px") 
		$("#customer_manager").val($("#customer_manager_loc").offset().top + "px," + $("#customer_manager_loc").offset().left+"px,"+$("#customer_manager_loc").height()+"px,"+$("#customer_manager_loc").width()+"px") 

		document.cform.submit();
	}

	<?php if($cover[0]['durian_sign'] != ""){
		$durian_sign = explode(",","{$cover[0]['durian_sign']}");
		$customer_sign = explode(",","{$cover[0]['customer_sign']}");
		$subject = explode(",","{$cover[0]['subject']}");
		$income_time = explode(",","{$cover[0]['income_time']}");
		$customer_company = explode(",","{$cover[0]['customer_company']}");
		$writer = explode(",","{$cover[0]['writer']}");
		$durian_engineer = explode(",","{$cover[0]['durian_engineer']}");
		$customer_manager = explode(",","{$cover[0]['customer_manager']}");

  	?>
	$("#durian_sign_div").css({
		position: 'absolute',
		top: '<?php echo $durian_sign[0]; ?>',
		left: '<?php echo $durian_sign[1]; ?>'
	});
	$("#durian_sign_div").height('<?php echo $durian_sign[2]; ?>');
	$("#durian_sign_div").width('<?php echo $durian_sign[3]; ?>');

	$("#customer_sign_div").css({
		position: 'absolute',
		top: '<?php echo $customer_sign[0]; ?>',
		left: '<?php echo $customer_sign[1]; ?>'
	});
	$("#customer_sign_div").height('<?php echo $customer_sign[2]; ?>');
	$("#customer_sign_div").width('<?php echo $customer_sign[3]; ?>');

	$("#subject_div").css({
		position: 'absolute',
		top: '<?php echo $subject[0]; ?>',
		left: '<?php echo $subject[1]; ?>'
	});
	$("#subject_div").height('<?php echo $subject[2]; ?>');
	$("#subject_div").width('<?php echo $subject[3]; ?>');

	$("#income_time_div").css({
		position: 'absolute',
		top: '<?php echo $income_time[0]; ?>',
		left: '<?php echo $income_time[1]; ?>'
	});
	$("#income_time_div").height('<?php echo $income_time[2]; ?>');
	$("#income_time_div").width('<?php echo $income_time[3]; ?>');

	$("#customer_company_div").css({
		position: 'absolute',
		top: '<?php echo $customer_company[0]; ?>',
		left: '<?php echo $customer_company[1]; ?>'
	});
	$("#customer_company_div").height('<?php echo $customer_company[2]; ?>');
	$("#customer_company_div").width('<?php echo $customer_company[3]; ?>');

	$("#writer_div").css({
		position: 'absolute',
		top: '<?php echo $writer[0]; ?>',
		left: '<?php echo $writer[1]; ?>'
	});
	$("#writer_div").height('<?php echo $writer[2]; ?>');
	$("#writer_div").width('<?php echo $writer[3]; ?>');

	$("#durian_engineer_div").css({
		position: 'absolute',
		top: '<?php echo $durian_engineer[0]; ?>',
		left: '<?php echo $durian_engineer[1]; ?>'
	});
	$("#durian_engineer_div").height('<?php echo $durian_engineer[2]; ?>');
	$("#durian_engineer_div").width('<?php echo $durian_engineer[3]; ?>');

	$("#customer_manager_div").css({
		position: 'absolute',
		top: '<?php echo $customer_manager[0]; ?>',
		left: '<?php echo $customer_manager[1]; ?>'
	});
	$("#customer_manager_div").height('<?php echo $customer_manager[2]; ?>');
	$("#customer_manager_div").width('<?php echo $customer_manager[3]; ?>');

  <?php } ?>
</script>
   
</html>

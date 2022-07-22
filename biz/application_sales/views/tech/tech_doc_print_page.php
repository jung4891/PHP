<?php
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";

$customerid = $this->phpsession->get( 'customerid', 'stc' );

if($customerid <> null){
	if ($_SESSION['timeout'] + 10*60 < time()) {
		session_unset();
		session_destroy();
		echo " <script> alert('세션 만료 되었습니다. 인증번호 재발급 후 이용해주세요.'); history.go(-1); </script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->config->item('site_title');?></title>
<link href="/misc/css/print_doc.css" type="text/css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="/misc/js/m_script.js"></script>
<script type="text/javascript" src="/misc/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery-1.8.3.min"></script>
<script type="text/javascript" src="/misc/js/common.js"></script>
<script type="text/javascript" src="/misc/js/jquery.validate.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<script language="javascript">
  <?php
	// exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -L 19mm -B 10mm  --footer-html http://tech.durianit.co.kr/index.php/tech_board/tech_doc_pdf_logo?seq={$seq} http://tech.durianit.co.kr/index.php/tech_board/tech_doc_pdf?seq={$seq} /var/www/html/stc/misc/upload/tech/tech/techprint.pdf");
    exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -L 19mm -B 10mm  --footer-html ".site_url()."/tech/tech_board/tech_doc_pdf_logo?seq={$seq} ".site_url()."/tech/tech_board/tech_doc_pdf?seq={$seq} /var/www/html/stc/misc/upload/tech/tech/techprint.pdf");

	$file = "/var/www/html/stc/misc/upload/tech/tech/techprint.pdf";
	$pdf = file_get_contents($file);

	header('Content-Type: application/pdf');
	header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
	header('Pragma: public');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Content-Length: '.strlen($pdf));
	header('Content-Disposition: inline; filename="'.$view_val['customer'].$view_val['subject'].'_'.substr($view_val['income_time'], 0, 10).'.pdf";');
	ob_clean();
	flush();
	echo $pdf;

	unlink("/var/www/html/stc/misc/upload/tech/tech/techprint.pdf"); //파일삭제
  ?>
</script>
</body>
</html>

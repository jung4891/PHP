<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -L 19mm -B 10mm ".site_url()."/biz/approval/electronic_approval_doc_preview?seq={$seq} /var/www/html/stc/misc/upload/sales/electronic_approval/approval_print.pdf");

$file = "/var/www/html/stc/misc/upload/sales/electronic_approval/approval_print.pdf";
$pdf = file_get_contents($file);

header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
header('Content-Disposition: inline; filename="'.$view_val['approval_doc_name'].'.pdf";');
ob_clean();
flush();
echo $pdf;

unlink("/var/www/html/stc/misc/upload/sales/electronic_approval/approval_print.pdf"); //파일삭제
?>
<body>
<script>
</script>
</body>
</html>

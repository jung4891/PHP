<?php
// exec("C:/wkhtmltopdf/bin/wkhtmltopdf -T 30mm -R 25mm -B 30mm -L 25mm --footer-center [page] --encoding UTF-8 ".site_url()."/biz/approval/salary_contract_pdf?seq=".$approval_doc_seq." c:/xampp/htdocs/biz/misc/upload/biz/official_doc/signdoc.pdf");
exec("/usr/local/bin/wkhtmltopdf -T 30mm -R 25mm -B 30mm -L 25mm --footer-center [page] --encoding UTF-8 ".site_url()."/biz/approval/salary_contract_pdf?seq=".$approval_doc_seq." /var/www/html/stc/misc/upload/biz/official_doc/signdoc.pdf");

// $file = "c:/xampp/htdocs/biz/misc/upload/biz/official_doc/signdoc.pdf";
$file = "/var/www/html/stc/misc/upload/biz/official_doc/signdoc.pdf";
$pdf = file_get_contents($file);

header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
header('Content-Disposition: inline; filename="연봉계약서.pdf";');
ob_clean();
flush();
echo $pdf;
 ?>

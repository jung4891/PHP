<?php
// exec("C:/wkhtmltopdf/bin/wkhtmltopdf -T 30mm -R 25mm -B 10mm -L 25mm --encoding UTF-8 ".site_url()."/biz/approval/employment_doc_pdf?seq=".$approval_doc_seq." c:/xampp/htdocs/biz/misc/upload/biz/employment_doc/employment_doc.pdf");
exec("/usr/local/bin/wkhtmltopdf -T 30mm -R 25mm -B 10mm -L 25mm --encoding UTF-8 ".site_url()."/biz/approval/employment_doc_pdf?seq=".$approval_doc_seq." /var/www/html/stc/misc/upload/biz/employment_doc/employment_doc.pdf");

// $file = "c:/xampp/htdocs/biz/misc/upload/biz/employment_doc/employment_doc.pdf";
$file = "/var/www/html/stc/misc/upload/biz/employment_doc/employment_doc.pdf";
$pdf = file_get_contents($file);

header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
header('Content-Disposition: inline; filename="재직증명서.pdf";');
ob_clean();
flush();
echo $pdf;
 ?>

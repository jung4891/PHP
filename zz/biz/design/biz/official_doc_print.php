<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

if($mode == 'preview') {
  $get = "user_id={$user_id}";
} else if ($mode == 'print') {
  $get = "seq={$seq}";
}

// exec("C:/wkhtmltopdf/bin/wkhtmltopdf --encoding UTF-8 -B 55mm -T 10mm --header-html ".site_url()."/biz/official_doc/official_doc_header?{$get} --footer-html ".site_url()."/biz/official_doc/official_doc_footer?{$get} ".site_url()."/biz/official_doc/official_doc_preview?{$get} c:/xampp/htdocs/biz/misc/upload/biz/official_doc/official_doc_preview.pdf");
exec("/usr/local/bin/wkhtmltopdf --encoding UTF-8 -B 55mm -T 10mm --header-html ".site_url()."/biz/official_doc/official_doc_header?{$get} --footer-html ".site_url()."/biz/official_doc/official_doc_footer?{$get} ".site_url()."/biz/official_doc/official_doc_preview?{$get} /var/www/html/stc/misc/upload/biz/official_doc/official_doc_preview.pdf");

// $file = "c:/xampp/htdocs/biz/misc/upload/biz/official_doc/official_doc_preview.pdf";
$file = "/var/www/html/stc/misc/upload/biz/official_doc/official_doc_preview.pdf";
$pdf = file_get_contents($file);

header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
header('Content-Disposition: inline; filename="'.$view_val['subject'].'.pdf";');
ob_clean();
flush();
echo $pdf;

// unlink("c:/xampp/htdocs/biz/misc/upload/biz/official_doc/official_doc_preview.pdf"); //파일삭제
unlink("/var/www/html/stc/misc/upload/biz/official_doc/official_doc_preview.pdf"); //파일삭제
?>
<body>
<script>
</script>
</body>
</html>

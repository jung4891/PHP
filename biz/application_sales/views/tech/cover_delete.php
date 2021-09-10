<?php 
unlink($this->input->server('DOCUMENT_ROOT')."/misc/img/cover/".$_GET['filename']);
echo("<script>opener.location.reload();self.close()</script>");
?>
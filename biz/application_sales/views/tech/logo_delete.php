<?php 
unlink($this->input->server('DOCUMENT_ROOT')."/misc/img/logo/".$_GET['filename']);
echo("<script>opener.location.reload();self.close()</script>");
?>
<?php
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
$misc = base_url().'misc/';
$img = $misc.'img/';
$id = $this->phpsession->get( 'id', 'stc' );
$customerid = $this->phpsession->get( 'customerid', 'stc' );
$name = $this->phpsession->get( 'name', 'stc' );
$lv = $this->phpsession->get( 'lv', 'stc' );
$email = $this->phpsession->get( 'email', 'stc' ); //김수성 수정-161228//이메일발송용
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="footer" style="width:100%;"><img src='<?php echo $misc ?>img/logo/<?php echo $view_val['logo']; ?>' height="35" style ="float:right;"></div>   
</body>
</html>
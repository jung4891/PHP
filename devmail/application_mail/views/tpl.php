<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="/misc/css/style.css" type="text/css" charset="utf-8"/>
 <link rel="stylesheet" href="/misc/css/admin.css" type="text/css" charset="utf-8"/>


 <div id="main_contents" align="center">
   <form name="mform" action="" method="post">
  <div class="main_div">
    <table>

    </table>
  </div>
  </form>
</div>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>

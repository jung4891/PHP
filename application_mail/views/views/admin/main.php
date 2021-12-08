<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/admin_side.php";
 ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css"/>
 <script src="https://d3js.org/d3.v3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>

 <div id="main_contents" align="center">
   <div class="main_div">
     <div class="chart">
     </div>

   </div>
 </div>


<script type="text/javascript">
var chart = c3.generate({
    bindto: '.chart',
    data: {
        columns: [
          <?php
           foreach ($domain_info as $dl) {
             $quota = round($dl->quota);
            echo "['{$dl->domain}', {$quota}],";
          }
          ?>
        ],
        // keys:{
        //   value: ['domain', 'quota'],
        // },
        type : 'donut'
    },
    donut: {
        title: "Total"
    }
});
</script>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>

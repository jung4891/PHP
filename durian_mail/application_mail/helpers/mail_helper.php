<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 if ( ! function_exists('var_pre')) {
   function var_pre($param) {
     echo '<tr><td colspan="2"><pre>';
     var_dump($param);
     echo '</pre></td></tr>';
   }
 }

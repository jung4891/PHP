<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 if ( ! function_exists('kdate')) {
   function kdate($stamp) {
     return date('o년 n월 j일, G시 i분 s초', $stamp);
     // date('Y-m-d H:i:s');
   }
 }
 ?>

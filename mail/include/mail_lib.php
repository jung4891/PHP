
 <?php
   function decode($val) {
     if(substr($val,0,2) == "=?") {   // 인코딩 되었는지 여부
       $val_lower = strtolower($val);
       if(strpos($val_lower, "utf-8") || strpos($val_lower, "ks_c_5601-1987")) {  // 제목은 이 두가지 형태로 출력됨
         return imap_utf8($val);
       }
       return imap_base64($val);
     }
     else {
       return $val;
     }
   }
 ?>

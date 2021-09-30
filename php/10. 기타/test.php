<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    $searchkeyword = "t";
    $search1 = "009";
    $search2 = "001";

    if($searchkeyword != "") {
      if($search1 == "000" && $search2 == "001") {
             $searchstring = " where subject like ? ";
      } else if($search1 == "000" && $search2 == "002") {
             $searchstring = " where user_name like ? ";
      } else {
        for ($i = 1; $i < 12; $i++){
          for ($j = 1; $j < 3; $j++) {
            if($search1 == "00{$i}" && $search2 == "00{$j}") {
              if($j == 1) {
                if($i < 10) {
                  $searchstring = " where category_code = '00{$i}' and subject like ? ";
                }else {
                  $searchstring = " where category_code = '0{$i}' and subject like ? ";
                }
              } else { 
                if($i < 10) {
                  $searchstring = " where category_code = '00{$i}' and user_name like ? ";
                }else {
                  $searchstring = " where category_code = '0{$i}' and user_name like ? ";
                }
              }
            }
          }
        }
      }
    } else {
       $searchstring = "";
         for ($i = 1; $i < 12; $i++){
           for ($j = 1; $j < 3; $j++) {
             if($search1 == "00{$i}") {
               if($i < 10) {
                 $searchstring = " where category_code = '00{$i}' ";
               }else {
                 $searchstring = " where category_code = '0{$i}' ";
               }
             }
           }
         }
      }
      echo $searchstring;

     ?>
  </body>
</html>

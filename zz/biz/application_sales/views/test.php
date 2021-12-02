<?php
if ($sales_cnt == 0){
    for($j=0; $j<$row_cnt; $j++){
      echo "<tr>";
      echo "<td class='dept'>{$dms['dept']}</td>";
      if(isset($purchase_row[$j])){
        echo $purchase_row[$j];
      }else{
        echo "<td colspan=7></td>";
      }
      echo "<td class='customer_companyname' style='background-color:#e8e8e8;'>{$dms['customer_companyname']}</td>";
      if(isset($sales_row[$j])){
        echo $sales_row[$j];
      }else{
        if(strpos($dms['exception_saledate'],$toYear."-".$month) === false){
          echo "<td colspan=7 style='background-color:#FCD5B4'>";
          echo date('Y-m',strtotime($dms['exception_saledate']));
          echo " 매출</td>";
        }else{
          echo "<td colspan=7>";
          echo "</td>";
        }
      }
      echo "</tr>";
    }
  } else {
    for($j=0; $j<$row_cnt; $j++){
      echo "<tr>";
      echo "<td class='dept'>{$dms['dept']}</td>";
      if(isset($purchase_row[$j])){
        echo $purchase_row[$j];
      }else{
        echo "<td colspan=7></td>";
      }
      echo "<td class='customer_companyname' style='background-color:#e8e8e8;'>{$dms['customer_companyname']}</td>";

      if(isset($sales_row[$j])){
        echo $sales_row[$j];
      }else{
          echo "<td colspan=7></td>";
      }
      echo "</tr>";
    }
  }
 ?>

<?php
	$dnfile = "/var/www/html/stc/ZOOKAppAgentSetup.exe"; //실제 파일명 또는 경로 
	$dnfilen = "ZOOKAppAgentSetup.exe";				//다운받을 파일명 또는 경로 

	if (is_file($dnfile)) { 

		Header("Cache-Control: cache, must-revalidate, post-check=0, pre-check=0"); 
			Header("Content-type: application/x-msdownload"); 
		Header("Content-Length: ".(string)(filesize($dnfile))); 
		Header("Content-Disposition: attachment; filename=".$dnfilen.""); 
		Header("Content-Description: PHP5 Generated Data"); 
		Header("Content-Transfer-incoding: euc_kr");  
		Header("Content-Transfer-Encoding: binary");  
		Header("Pragma: no-cache"); 
		Header("Expires: 0"); 
		Header("Content-Description: File Transfer"); 

		if (is_file($dnfile)) { 
		  $fp = fopen($dnfile, "rb"); 

		if (!fpassthru($fp))  
			fclose($fp); 

		} 
	}else { 
	  echo "<script>alert('해당 파일이나 경로가 존재하지 않습니다.');history.back();</script>"; 
	}
?>
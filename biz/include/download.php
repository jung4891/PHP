<? 
header("Content-Type: text/html; charset=UTF-8");
//------------------------------------------------------ 
// download.php로 저장 
//------------------------------------------------------ 
$_ServerFileName=$_GET['svf']; // 서버에 저장된 파일 이름 
$_RealSaveFileName=$_GET['rf']; // 실제 사용자가 저장한 파일이름 & 사용자가 저장할 파일 이름 

if($_GET['directory_add'] != "")
{
	$add_directory = $_GET['directory_add']."\\";
}
else
{
	$add_directory = "";
}

$_DataDir = "C:\AutoSet6\public_html\dbs\misc\upload\\".$add_directory; 
$_FilePath =  $_DataDir.$_ServerFileName; 


$dn = "0"; // 1 이면 다운 0 이면 브라우져가 인식하면 화면에 출력 
$dn_yn = ($dn) ? "attachment" : "inline"; 

//echo $_FilePath;
//exit;

if (is_file($_FilePath)) 
{ 
	if(eregi("(MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) 
	{ 
	Header("Content-type: application/octet-stream"); 
	Header("Content-Length: ".filesize("$_FilePath"));  // 이부분을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다. 
Header("Content-Disposition:".$dn_yn."; filename=".iconv("utf-8","cp949",$_RealSaveFileName));  
	Header("Content-Transfer-Encoding: binary");  
	Header("Pragma: no-cache");  
	Header("Expires: 0");  
	} 
	else 
	{ 
	Header("Content-type: file/unknown");    
	Header("Content-Length: ".filesize("$_FilePath")); 
	Header("Content-Disposition:".$dn_yn."; filename=".iconv("utf-8","cp949",$_RealSaveFileName)); 
	Header("Content-Description: PHP3 Generated Data"); 
	Header("Pragma: no-cache"); 
	Header("Expires: 0"); 
	} 
	$fp = fopen($_FilePath, "r"); 
	if (!fpassthru($fp))// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이... 
	{ fclose($fp); } 
} 
else 
{ 
  echo "해당 파일이나 경로가 존재하지 않습니다."; 
  exit; 
} 
?> 
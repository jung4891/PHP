<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/

// Define a destination
$targetFolder = '/misc/upload/bigfile'; // Relative to the root

$verifyToken = md5("unique_salt".$_POST['timestamp']);

if(!empty($_FILES) && $_POST['token'] == $verifyToken) {

    $upName = $_POST['timestamp']."_".$_FILES['Filedata']['name'];    // 파일명 앞에 UNIX 시간을 붙여 중복되지 않게 구분한다.
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    $targetFile = rtrim($targetPath, "/")."/".$upName;

    // 업로드 할 수 있는 파일의 확장자를 지정한다.
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    move_uploaded_file($tempFile, $targetFile);

    // if(in_array($fileParts['extension'], $fileTypes)) {
    // } else {
    //     echo "업로드 할 수 없는 형식의 파일입니다.";
    // }
}

?>

<?php
if(!isset($_SESSION['USERID'])){
    Header("Location:./index.php");
    exit;
}
?>
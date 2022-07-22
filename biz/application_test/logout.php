<?php
    session_start();
    unset($_SESSION['USERID']);
    unset($_SESSION['USERPW']);
    unset($_SESSION['USERLEVEL']);
    unset($_SESSION['USERNAME']);
    echo '<script>alert("로그아웃 되었습니다");</script>';
    echo "<br><a href='./index.php'>메인 페이지로 이동</a>";
?>
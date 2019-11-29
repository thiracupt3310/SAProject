<?php
    session_start();
    $_SESSION['isSetEarn'] = 1;
    header("location:../view/seller.php");
?>
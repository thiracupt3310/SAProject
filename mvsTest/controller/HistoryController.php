<?php
    session_start();
    $_SESSION['Bid'] = $_GET['Bid'];
    $_SESSION['isHistory'] = 1;
    header("location:../view/manager.php");
?>
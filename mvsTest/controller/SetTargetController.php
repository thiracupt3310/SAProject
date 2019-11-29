<?php
    session_start();
    $_SESSION['isSetTarget'] = 1;
    $_SESSION['Bid'] = $_GET['Bid'];
    // echo $_SESSION['Bid'];
    // header("location:../controller/calculateController.php");
    $_SESSION['isAdmin'] = 1;
    require 'calculateController.php';

    // echo $_SESSION['sum']['SUM(sumTotal)'];
    header("location:../view/manager.php");
?>
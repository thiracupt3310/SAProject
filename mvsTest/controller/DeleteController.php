<?php
    session_start();
    require '../models/Model.php';
    $data = new Models();
    $data->deleteSale($_SESSION['Bid'], $_GET['date']);
    $_SESSION['isDelete'] = 1;
    header("location:../view/seller.php");
?>
<?php    
    $hostname ="localhost";
    $user = "root";
    $pass = "";
    $dbname = "visor";
    $connect = mysqli_connect($hostname, $user, $pass, $dbname) or die("ผิดพลาด");
    mysqli_set_charset($connect, "utf8");
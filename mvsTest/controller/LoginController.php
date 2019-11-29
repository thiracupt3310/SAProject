<?php
    session_start();
    require '../models/model.php';
    $user = $_GET['user'];
    $pass = $_GET['pass'];
    $data = new Models();
    $data->loadLogin('login', $user, $pass);
    $record = mysqli_fetch_array($data->getResult());
    if ($user != null && $pass != null){
        if ($record['user'] == $user && $record['pass'] == $pass){
            // echo "login success";
            $_SESSION['user'] = $user;
            if ($record['position'] == 'h'){                
                header("location:../view/manager.php");
            }
            elseif ($record['position'] == 's'){
                header("location:../view/seller.php");
            }
        }else {
            $_SESSION['message'] = 'User ID หรือ Password ผิด กรุณากรอกใหม่';
            header("location:../view/login.php");
        }
    }else{
        $_SESSION['message'] = 'กรุณากรอกข้อมูลให้ครบ';
        header("location:../view/login.php");
    }   
?>
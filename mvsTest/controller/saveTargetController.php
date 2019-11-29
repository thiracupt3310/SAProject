<?php
    session_start();
    function isDate($value){
        if (!$value) {
            return false;
        }
        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    if ($_GET['date'] == null || $_GET['target'] == null){
        $_SESSION['error'] = 1;
        $_SESSION['message'] = 'กรุณากรอกข้อมูลให้ครบ';
        if ($_SESSION['isAdmin'] == 1){
            header("location:../view/manager.php");
        } else{
            header("location:../view/seller.php");
        }
    }else{
        if (isDate($_GET['date'])){
            $_SESSION['error'] = 0;
            $date = new DateTime($_GET['date']);
            $result = $date->format('Y-m-d');
            $target = $_GET['target'];
            if (is_numeric ($target)){ 
                if (intval($target) < 0){
                    $_SESSION['message'] = 'ตจำนวนเงินติดลบ กรุณากรอกใหม่';
                    $_SESSION['error'] = 1;
                } else {      
                    $_SESSION['error'] = 0;
                }
            }else {
                if ($target == null){
                    $_SESSION['message'] = 'กรุณากรอกจำนวนเงิน';
                } else{
                    $_SESSION['message'] = 'จำนวนเงินไม่ถูกต้อง กรุณากรอกใหม่';
                }
                $_SESSION['error'] = 1;
            }
        }else {
            $_SESSION['error'] = 1;
            if ($_GET['date'] == null){
                $_SESSION['message'] = 'Please enter the date.';
            } else{
                $_SESSION['message'] = 'Your date is incorrect. Please enter the date again';
            }
        }        
        $Bid = $_SESSION['Bid']; 
        require '../models/Model.php';   
        $data = new Models();
        if ($_SESSION['isAdmin'] == 1){
            $data->updateTable($Bid, $result, $target, 'targets');
            header("location:../view/manager.php");
        } else{
            $data->updateTable($Bid, $result, $target, 'sales');
            header("location:../view/seller.php");
        }
        if ($data->getResult()){
            $_SESSION['isSuccess'] = 1;
        }    
    }

?>
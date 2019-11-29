<?php
    if (!isset($_SESSION['isInclude'])){
        require '../models/model.php';
    }
    $data = new Models();
    $data->loadSum($_SESSION['Bid'], $_SESSION['isAdmin']);
    $_SESSION['sum'] = mysqli_fetch_array($data->getResult());
    if (!$_SESSION['isAdmin']){
        $_SESSION['sum'] = $_SESSION['sum']['sumTotal'];
    }else{
        $data->loadBranch($_SESSION['Bid']);
        $record = mysqli_fetch_array($data->getResult());
        $divide = 3;
        if ($record['size'] == 's'){
            $divide *= 1.5;
        }elseif ($record['size'] == 'm'){
            $divide *= 1;
        }elseif ($record['size'] == 'l'){
            $divide *= 0.5;
        }    
        $_SESSION['sum'] = round($_SESSION['sum']['SUM(sumTotal)'] / $divide);
        $_SESSION['sum'] = $_SESSION['sum'] - ($_SESSION['sum'] % 1000 );
    }
    unset($_SESSION['isInclude']);
?>
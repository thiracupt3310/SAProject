<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="manager.css" />
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet"> 
    <script src="https://kit.fontawesome.com/b13ddaf0a8.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">  
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
    <!-- ดูประวัติ -->
    <div>
        <div id="history">
            <div class='container' style="height: 75%; width: 75%;">
                <header>ประวัติการเงิน</header>
                <ul class="list-group" style="text-align:center;">
                    <li class='list-group-item' style='background-color: #dbdbdb'>
                        <div class='row'>
                            <div class='col'>วัน/เดือน/ปี</div>
                            <div class='col' style="border-left: solid; border-color:#aeb6bf;">จำนวนเงิน</div>
                        </div>
                    </li>
                    <?php
                        require '../models/Model.php';
                        session_start();
                        $data = new Models();
                        if (isset($_SESSION['Bid'])){
                            $data->loadSales($_SESSION['Bid']);
                            while($record =  mysqli_fetch_assoc($data->getResult())){
                                echo "<li class='list-group-item' style='background-color: #eeeeee'>
                                    <div class='row'>
                                        <div class='col'>" . date("m-d-Y", strtotime($record['date'])) . "</div>
                                        <div class='col' style='border-left: solid; border-color:#aeb6bf;'>". $record['total'] . "</div>
                                    </div>
                                </li>";
                            }
                        }                        
                    ?>
                </ul>
                <div style="display: flex; justify-content: center;"><button type="button" class="btn btn-danger" onclick="closeClick()">ปิด</button></div>
            </div>
        </div>
        <!-- ตั้งยอด -->
        <div id="setTarget">
            <div class='container' style="height: 75%; width: 50%;">
                <header>ตั้งยอดขาย</header>
                <div class="container" style="height: 75%; background-color: white;">
                    <div class="row" style="text-align:center; height: 100%; align-items: center;">
                        <div class="col-sm-5">
                            <h3>เป้าหมายแนะนำ</h3>
                            <h4 id="recommendTarget">00000</h4>
                        </div>
                        <div class="col-sm">
                            <form action="../controller/saveTargetController.php">
                                <input name='date' class="datepicker" width="75%" placeholder='วันที่ทำการบันทึก'/>
                                <input name='target' type="text" class="form-control" placeholder="จำนวนเงิน" style="width: 75%; margin-top: 10px">
                                <?php
                                    echo '<div class="inputWithIcon" style="color: red;">';
                                    if (isset($_SESSION['message'] ))
                                    {
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']);
                                    }
                                    echo '</div>'
                                ?>
                                <input type="submit" class="btn btn-success" style="margin-top: 10px" value="ยันยัน"> 
                                <span><button style="margin-top: 10px" type="button" class="btn btn-danger" onclick="closeClick()">ยกเลิก</button></span>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>      
        </div>
    </div>


    <!-- header -->
    <div class="container">
        <header class="row">
            <div class="col-sm-2">
                <img style="width: 125px; height: 125px; " src="../picture/userImage.png" alt="Image">
            </div>
            <div class="col-sm" >
                <?php                    
                    // echo $_SESSION['user'];
                    $data->loadInfo('info', $_SESSION['user']);
                    $record = mysqli_fetch_array($data->getResult());
                    echo $record['firstname'] . "  " . $record['lastname'] . "<br>";
                    echo 'ตำแหน่ง: หัวหน้า';
                ?>
            </div>
            <div class="col-sm-2">
                <form method="GET" action="../controller/LogoutController.php">
                    <input class="btn btn-danger" value="LOGOUT" type="submit">
                </form>
            </div>
        </header>        
    </div>

    <!-- สาขา -->
    <div class="container">
        <header  style="background-color: deepskyblue; padding: 20px; margin-top: 20px;"> สาขาที่ดูแล </header>
        <ul class="list-group">    
        <?php
            // require '../models/Model.php';
            $data->loadInfo('branch', $_SESSION['user']);  
            // echo $data->getRecord()['name'];
            while($record = mysqli_fetch_assoc($data->getResult())){
                echo "<li class='list-group-item' style='background-color: #dbdbdb'>
                            <div class='row'>
                                <div class='col-sm-2'><img style='width: 100px; height: 100px' src='../picture/userImage.png' alt='Image'></div>
                                <div class='col-sm'>" . 
                                    "ชื่อสาขา: " . $record['name'] . "<br>
                                    ที่อยู่: " . $record['address'] . "<br>
                                </div>
                                <div class='col-sm-2'>
                                    <div class='list-group'>
                                    <form action='../controller/HistoryController.php'>
                                        <input type='hidden' name='Bid' value=" . $record['Bid'] . ">
                                        <input type='submit' class='list-group-item list-group-item-action' value='ดูประวัติ'>
                                    </form>
                                    <form action='../controller/SetTargetController.php'>
                                        <input type='hidden' name='Bid' value=" . $record['Bid'] . ">
                                        <input type='hidden' name='isSet' value='1'>
                                        <input type='hidden' name='total1' value=''>
                                        <input type='hidden' name='total2' value='1'>
                                        <input type='hidden' name='total3' value='1'>
                                        <input type='submit' class='list-group-item list-group-item-action' value='ตั้งยอดขาย'>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </li>";
            }
            if (isset($_SESSION['isSuccess'])){
                echo "<script type='text/javascript'>alert('บันทึกสำเร็จ');</script>";
                unset($_SESSION['isSuccess']);
            }
        ?>
        </ul>
    </div>
    <script> 
        function closeClick(){
            document.getElementById("history").style.display = "none";
            document.getElementById("setTarget").style.display = "none";
        }
        var status1 = "<?php echo $_SESSION['isHistory']?>";
        var status2 = "<?php echo $_SESSION['isSetTarget']?>";
        var isDate = "<?php echo $_SESSION['error']?>";
        if (status1 == 1){
            document.getElementById("history").style.display = "flex";
            document.getElementById("setTarget").style.display = "none";
            status1 = "<?php echo $_SESSION['isHistory'] = 0?>";
        }               
        if (status2 == 1 || isDate == 1){
            document.getElementById("history").style.display = "none";
            document.getElementById("setTarget").style.display = "flex";
            status2 = "<?php echo $_SESSION['isSetTarget'] = 0?>";
            document.getElementById("recommendTarget").innerHTML = "<?php echo $_SESSION['sum']?>";
            isDate = "<?php echo $_SESSION['error'] = 0?>";
        }
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });
    </script>
</body>
</html>
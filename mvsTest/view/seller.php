<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="seller.css" />
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
    <!-- ประวัติ -->
    <div id="history">
        <div class='container' style="height: 75%; width: 75%;">
            <header>ประวัติการเงิน</header>
            <li class='list-group-item' style='background-color: #dbdbdb; text-align: center;'>
                <div class='row'>
                    <div class='col'>วัน/เดือน/ปี</div>
                    <div class='col' style="border-left: solid; border-color:#aeb6bf;">จำนวนเงิน</div>
                    <div class='col-1'></div>
                </div>
            </li>
            <ul class="list-group" style="text-align:center; overflow: auto; height: 75%;'" >
                <?php
                    require '../models/Model.php';
                    session_start();  
                    $data = new Models();
                    if (isset($_SESSION['Bid'])){
                        $data->loadSales($_SESSION['Bid']);
                        while($record =  mysqli_fetch_assoc($data->getResult())){
                            echo "<li class='list-group-item'>
                                <div class='row'>
                                    <div class='col'>" . date("m-d-Y", strtotime($record['date'])) . "</div>
                                    <div class='col' style='border-left: solid; border-color:#aeb6bf;'>". $record['total'] . 
                                    "</div>
                                    <div class='col-1'><form action='../controller/DeleteController.php'>
                                        <input name='date' type='hidden' value=" . $record['date'] . ">
                                        <input type='submit' class='btn btn-danger' value='ลบ'>
                                    </form></div>
                                </div>
                            </li>";
                        }
                    }                                          
                ?>
            </ul>
            <div style="display: flex; justify-content: center;"><button type="button" class="btn btn-danger" onclick="closeClick()">ปิด</button></div>
        </div>
    </div>

    <!-- setEarn -->
    <div id="setEarn">
        <div class='container' style="height: 50%; width: 30%;">
            <header>อัพเดทยอดขาย</header>
            <div class="container" style="height: 75%; background-color: white; display: flex; justify-content: center ">
                <div class="row" style="text-align:center; height: 100%; align-items: center;">
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
    <!-- header -->
    <div class="container">
            <header class="row">
                <div class="col-sm-2">
                    <img style="width: 125px; height: 125px; " src="../picture/userImage.png" alt="Image">
                </div>
                <div class="col-sm" >
                    <?php                  
                        // echo $_SESSION['user'];
                    $_SESSION['isInclude'] = 1;
                    $_SESSION['isAdmin'] = 0;
                    $data = new Models();
                    $data->loadInfo('info', $_SESSION['user']);
                    $record = mysqli_fetch_array($data->getResult());
                    $_SESSION['Bid'] = $record['Bid'];
                    echo $record['firstname'] . "  " . $record['lastname'] . "<br>";
                    ?>
                </div>
                <div class="col-sm-2">
                    <form method="GET" action="../controller/LogoutController.php">
                        <input class="btn btn-danger" value="LOGOUT" type="submit">
                    </form>
                </div>
            </header>        
        </div>
     <!-- action -->
    <div class="container" style="height: 100%">
        <header  style="background-color: deepskyblue; padding: 20px; margin-top: 20px;"> สาขา: 
            <?php
                $data->loadInfo('branch', $_SESSION['Bid']);
                $record = mysqli_fetch_array($data->getResult());
                echo $record['name'];
                $data->loadTarget($_SESSION['Bid']);
                $_SESSION['record'] = mysqli_fetch_array($data->getResult());
            ?>
        </header>
        <div class="container" style="width: 100%; background-color: white; height: 50%">
            <div class="row" style="text-align:center; height: 50%; align-items: center;">
                <div class="col-sm" style="border: 1px solid black; padding: 10px; margin: 10px">
                    <h3>เป้าหมายทั้งหมดในเดือนนี้</h3>
                    <h4><?php echo $_SESSION['record']['target']?><h4>
                </div>
                <div class="col-sm" style="border: 1px solid black; padding: 10px; margin: 10px">
                    <h3>ประจำเดือน</h3>
                    <h4><?php echo $_SESSION['record']['MONTH(date)'] . "/" . $_SESSION['record']['YEAR(date)']?></h4>
                </div>
                <div class="col-sm" style="border: 1px solid black; padding: 10px; margin: 10px">
                    <h3>ยอดที่ทำได้</h3>
                    <h4>
                        <?php 
                            require '../controller/calculateController.php';
                            echo $_SESSION['sum'];
                        ?>    
                    <h4>
                </div>
            </div>
            <div style="display: flex; justify-content: center; height: 50%; align-items: center;">
            <form action='../controller/EarnController.php'>
                <input type="submit" class="btn btn-secondary" style="margin-right: 5px" value="บันทึกยอด">
            </form>
            <form action='../controller/EditController.php'>
                <input type="submit" class="btn btn-secondary" value="แก้ไข">
            </form>
                
            </div>
        </div>   
        <?php
            if (isset($_SESSION['isDelete'])){
                echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
                unset($_SESSION['isDelete']);
            }
            if (isset($_SESSION['isSuccess'])){
                echo "<script type='text/javascript'>alert('บันทึกสำเร็จ');</script>";
                unset($_SESSION['isSuccess']);
            }
        ?>     
    </div>

    <script> 
        function closeClick(){
            document.getElementById("setEarn").style.display = "none";
            document.getElementById("history").style.display = "none";
        }
        var status = "<?php echo $_SESSION['isSetEarn']?>";
        var isError = "<?php echo $_SESSION['error']?>";
        if (status == 1  || isError == 1){
            document.getElementById("setEarn").style.display = "flex";
            document.getElementById("history").style.display = "none";
            status1 = "<?php echo $_SESSION['isSetEarn'] = 0?>";
            isError = "<?php echo $_SESSION['error'] = 0?>";

        }
        if(status == 2){
            document.getElementById("setEarn").style.display = "none";
            document.getElementById("history").style.display = "flex";
            status1 = "<?php echo $_SESSION['isSetEarn'] = 0?>";
        }
              
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });
    </script>
</body>
</html>
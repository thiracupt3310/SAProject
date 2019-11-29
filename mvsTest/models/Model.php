<?php
    class Models{
        private $result;        
        public function loadLogin($type, $u, $p){
            require 'connectDB.php';
            $this->result = mysqli_query($connect, "select * from employee where user = '$u' and pass = '$p'") or die("something wrong");
        }
        public function loadInfo($type, $u){
            require 'connectDB.php';
            if ($type == 'info') {
                $this->result = mysqli_query($connect, "select * from employee where user = '$u'");
            } elseif ($type == 'branch'){
                if ($u == 'admin'){
                    $this->result = mysqli_query($connect, "select * from branch");
                } else{
                    $this->result = mysqli_query($connect, "select * from branch where Bid = '$u'");
                }
            }
        }
        public function loadBranch($Bid){
            require 'connectDB.php';
            $this->result = mysqli_query($connect, "select * from branch where Bid = '$Bid'");
        }
        public function loadSales($Bid){
            require 'connectDB.php';
            $this->result = mysqli_query($connect, "select * from sales where Bid = '$Bid'");
        }
        public function deleteSale($Bid, $d){
            require 'connectDB.php';
            $this->result = mysqli_query($connect, "DELETE FROM sales WHERE Bid = '$Bid' and date = '$d'");
        }
        public function loadSum($Bid, $type){
            require 'connectDB.php';
            $sql1 = "SELECT SUM(sumTotal) from ";
            $sql2 = "SELECT YEAR(date), MONTH(date), SUM(total) as sumTotal , Bid FROM Sales WHERE Bid = '$Bid' GROUP BY YEAR(date), MONTH(date), Bid ORDER BY YEAR(date), MONTH(date) DESC LIMIT 3";
            if ($type == 1){
                $this->result = mysqli_query($connect, $sql1 ."(" . $sql2 . ") as t");
            }elseif ($type == 0){
                $this->result = mysqli_query($connect, $sql2);
            }
        }
        public function updateTable($Bid, $d, $target, $table){
            require 'connectDB.php';
            if ($table == 'targets'){
                $val = 'target';
            }elseif ($table == 'sales'){
                $val = 'total';
            }            
            $insertInto = "INSERT INTO ". $table . "(Bid, date, " . $val . ") VALUES ('$Bid', '$d', '$target')";
            $this->result = mysqli_query($connect, $insertInto);
        }
        public function loadTarget($Bid){
            require 'connectDB.php';
            $this->result = mysqli_query($connect, "select target, YEAR(date), MONTH(date) from branch, targets where branch.Bid = '$Bid' and targets.Bid = '$Bid'");
        }
        public function getResult(){            
            return $this->result;
        }
    }
?>
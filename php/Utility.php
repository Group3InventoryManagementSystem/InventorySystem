<?php
    require_once "DBase.php";
    @session_start();
    class Utility extends DBConnect{
        
        function log_in(){
            try{
                $id = $_POST['id'];
                $pass = $_POST['password'];
                
                $result = $this->query("SELECT * FROM","users","WHERE ID = ?",[$id]);
               if($result->rowCount() > 0){
                   $row = $result->fetch();
                   if(password_verify($pass, $row['pass'])){
                        @session_start();
                        $_SESSION['fname'] = $row['f_name'];
                        $_SESSION['rank'] = $row['rank'];
                        $this->goToPage($row['rank']);
                    }else{
                        header("Location:../LogIn.php?err=Wrong Password");
                    }
               }else{
                    header("Location:../LogIn.php?err=No such user");
               } 
                
                
            }catch(Exception $e){
                header("Location:../LogIn.php");
            }
           
        }
        
        function registerUser(){
            $id = $_POST['id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $pass = $_POST['pass'];
            
            $res = $this->query("SELECT * FROM","users","WHERE ID = ?",[$id]);
            
            if($res->rowCount()>0){
                header("Location:../Register.php?err=User ID already exists");
            }else{
                $res = $this->query("INSERT INTO ","users","(ID, f_name, lname, pass, status) VALUES(?,?,?,?,?)",[$id, $fname, $lname, password_hash($pass, PASSWORD_DEFAULT), "PENDING"]);
                header("Location:../LogIn.php?suc=Successfuly registered. Waiting for manager's approval");
            }
        }
        
        function goToPage($rank){
            if($rank === "SECRETARY"){
                header("Location:../WorkRequestPage.php");
            }else if($rank === "STOREMAN"){
                header("Location:../MaterialsRequested.php");
            }else if($rank === "FOREMAN"){
                header("Location:../ForemanWorkRequest.php");
            }else if($rank == "MANAGER" || $rank == "MAINTENANCE SUPERVISOR" || $rank == "MAINTENANCE OFFICER"){
               header("Location:../AdminWorkRequests.php");
            }else{
                header("Location:../LogIn.php?err=Awaiting Manager's Approval");
            }
        }
        
        function log_out(){
            session_destroy();
            header("Location:../index.php");
        }
        
        function report(){
            if(isset($_GET['suc'])){
                echo "<div class='success' id='r_success'>* ".$_GET['suc']."</div>";
            }
            if(isset($_GET['err'])){
                echo "<div class='error' id='r_error'>* ".$_GET['err']."</div>";
            }
        }
    
        function checkLogin(){
            if(isset($_SESSION['rank'])){
                return true;
            }
            return false;
        }
        
        function check($rank){
            if(isset($_SESSION['rank']) && $_SESSION['rank']==$rank){
                
            }else{
                $this->log_out();
            }
        }
    }

    $utility = new Utility();

    if(isset($_POST['register'])){
        $utility->registerUser();
    }

    if(isset($_POST['login'])){
        $utility->log_in();
    }

    if(isset($_POST['logout'])){
        $utility->log_out();
    }

?>
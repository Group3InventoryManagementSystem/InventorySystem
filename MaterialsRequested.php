<?php
    @session_start();
    $get = null;
    if(isset($_SESSION['rank'])){
        
        if($_SESSION['rank'] == "STOREMAN"){
            require_once "php/StoreKeeper.php";
            $get = new Storeman();
        }else if($_SESSION['rank'] == "MANAGER"){
            require_once "php/Admin.php";
            $get = new Admin();
        }else{
            header("Location:LogIn.php");
        }
    }else{
        header("Location:LogIn.php");
    }

?>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
    <header>
        <h1>Egerton Estates Department</h1>
        <nav class="navbar">
        <?php require_once "includes/headerLinks.php";?>
    </nav>
    </header>
<body>
    <div  style="border-left: 20px;">
    <?php $get->getMaterialsRequested();?>
</div>
</body>
</html>

<?php
    require_once "php/Admin.php";
    if(!$admin->checkLogin()){
        header("LogIn.php");
    }else{
        if($_SESSION['rank'] != "MANAGER" || $_SESSION['rank'] != "MAINTENANCE SUPERVISOR" || $_SESSION['rank'] != "MAINTENANCE OFFICER"){
            header("LogIn.php");
        }
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
   
    <div style="margin-left: 20px;">
    <?php $admin->getRequests(); ?>

</div>
</body>
</html>
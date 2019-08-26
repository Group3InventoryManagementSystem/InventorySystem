<?php
    require_once "php/Admin.php";
    if(!$admin->checkLogIn()){
        header("Location:LogIn.php");
    }else{
        if($_SESSION['rank'] != "MANAGER"){
            header("Location:LogIn.php");
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
    <body class='report'>
        <div class='filter'>
        <form action="Report.php" method="post">
        <label>From :</label><input type="date" name='from' required>
        <label>To :</label><input type="date" name='to' required>
        <input type="submit" value='Fetch'>
        </form>
        </div>
        <?php $admin->getReport();?>
    </body>
</html>
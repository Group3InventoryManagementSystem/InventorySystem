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
    <script>
    
        function set(){
            var rank = document.getElementById('rank');
            var rankVis = document.getElementById('rankVis');
            rank.value = rankVis.value;
        }
    </script>
    <body>
        <div style="margin-left: 20px;">
        <?php $admin->getRegisterPending();?>
    </div>
    </body>

</html>
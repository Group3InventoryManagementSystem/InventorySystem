<?php

    require_once "php/Utility.php";
    $utility->check("FOREMAN");
    require_once "php/Foreman.php";

    $foreman = new Foreman();

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
<body class='foreman'>

  <div>
    <form action="ForemanWorkRequest.php" method='get' style="margin-left: 20px;" id='filter'><select name='filter' >
        <option>All</option>
        <option>Unassigned</option>
        <option>Assigned</option>
        </select>
        <input type="submit" value='Filter' class='button'>
    </form>
    </div>
<div style="margin-left: 20px">
    <?php
        $foreman->getWork();
    ?>
</div>
</body>

</html>
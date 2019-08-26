<?php
    require_once "php/Utility.php";
    $utility->check("STOREMAN");
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
    <div class="box">
    <form method='post' action="php/StoreKeeper.php">
        <h1>Add Material</h1>
        <label>Name of Material</label><br>
        <input type='text' name='name' maxlength="40" required="required"><br>
        <label>Total Number of Units</label><br>
        <input type='number' name='units' min="1" maxlength="10" required="required"><br>
        <label>Price Per Unit</label><br>
        <input type='number' name='price' min="1" maxlength="10" required="required"><br>
        <label>Refference Number</label><br>
        <input type='text' name='ref' placeholder="Receipt Number etc" maxlength="20" required="required"><br>
        <input type='submit' value='Add' name='add'><br>
    </form>
          <?php require_once"php/Utility.php";
        $utility->report();
    ?>
  
    </div>
</body>
        <script type="text/javascript" src="js/hide.js"></script>

</html>
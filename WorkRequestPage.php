<?php
    require_once "php/Utility.php";
    $utility->check("SECRETARY");
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
    <body class='secretary'>
        <div class="box">
    
        <form action="php/Secretary.php" method='post'>
            <h1>Request Work</h1>
            <label>Requested By</label><br>
            <input type='text' name='requestedBy' maxlength="50"  required="required"><br>
            <label>Section of the University </label><br>
            <select name='section'>
            <option>Staff Offices</option>
            <option>Residential Houses</option>
            <option>Learning Facilities</option>
            <option>Other</option>
            </select><br>
            <label>Building Name</label><br>
            <input type='text' name='buildingName' maxlength="40" required="required"><br>
            <label>Room/Office Name</label><br>
            <input type="text" name='roomName' maxlength="40" min="1" required="required"><br>
            <label>Repair Classification</label><br>
            <select name='repairClass'>
            <option>Electrical</option>
            <option>Masonry</option>
            <option>Metal Work</option>
            <option>Plumbing</option>
            <option>Wood Work</option>
            <option>Locks</option>
            <option>Other</option>
            </select><br>
            <label>Description of Problem</label><br>
            <textarea name='description' required="required"></textarea><br>
            <input type="submit" name='saveRequest' value='Submit Request'>
            <?php require_once"php/Utility.php";
                $utility->report();
            ?>
        </form>
        </div>
    </body>
    <script type="text/javascript" src="js/hide.js"></script>
    <div style="margin-left: 20px;">
    
    </div>
</html>
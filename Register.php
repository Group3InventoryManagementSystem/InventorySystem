<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
    
    <header>
        <h1>Egerton Estates Department</h1>
        <nav class="navbar">
        <ul>
            <li><a href='Index.php'>Home</a></li>
            <li ><a href='LogIn.php'>Log In</a></li>
            <li class="current"><a href='Register.php'>Register</a></li>
        </ul>
    </nav>
    </header>
<body>
    <div class="box">

    <form method="post" action="php/Utility.php">
        <h1>Register</h1>
        <label>ID Number</label><br>
        <input type='text' name='id' maxlength="11" required="required"><br>
        <label>First Name</label><br>
        <input type='text' name='fname' maxlength="20" required="required"><br>
        <label>Last Name</label><br>
        <input type='text' name='lname' maxlength="20" required="required"><br>
        <label>Password</label><br>
        <input type='password' name='pass' maxlength="20" required="required"><br>
        <label>Confirm Password</label><br>
        <input type='password' maxlength="20" required="required" ><br>
        <input type="submit" name='register' value='Register'>
        <?php require_once"php/Utility.php";
            $utility->report();
        ?>
    </form>
</div>
</body>
        <script type="text/javascript" src="js/hide.js"></script>

</html>
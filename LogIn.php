<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
 <header>
     <h1>Egerton Estates Department</h1>
    <nav class="navbar">
        <ul>
             <li><a href='Index.php'>Home</a></li>
            <li class="current"><a href='LogIn.php'>Log In</a></li>
            <li><a href='Register.php'>Register</a></li>
        </ul>
    </nav>
    </header>
<body class='login'>
    <div class="box">
    <form action='php/Utility.php' method='post'>
        <h1>Log In</h1>
        <label>ID Number</label><br>
        <input type='text' name='id' maxlength="11" required="required"><br>
        <label>Password</label><br>
        <input type='password' name='password' maxlength="20" required="required"><br>
        <input type='submit' name='login' value='Log In'>
        <?php require_once"php/Utility.php";
            $utility->report();
        ?>
    </form>
     </div>
</body>
    <script type="text/javascript" src="js/hide.js"></script>
    
</html>
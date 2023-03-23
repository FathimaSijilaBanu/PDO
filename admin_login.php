<?php

session_start();
if (isset($_SESSION['loggedIn'])) {
    header("location: index.html");
    clearstatcache();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css" class="rel">

</head>
<body>
    <form method="POST" action="login.php" class="loginform">
    <h1>ADMIN LOGIN</h1>
        <label for="username">Username</label>
        <input type="text" id="name" name="username"><br><br>
        <label for="password">Password</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
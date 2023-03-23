<?php

/**
 * File name: index.php
 *
 * PHP script that store data in localstorage using session.
 *
 * PHP version 8.2
 *
 * @category PHP
 * @package  PDOTASK
 * @author   sijila <sijila.b@codilar.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://example.com/my_file
 */

session_start();
if (isset($_SESSION['loggedIn'])) {
    header("location: registration.html");
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
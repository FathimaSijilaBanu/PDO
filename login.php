<?php

/**
 * File name: login.php
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

require_once realpath(__DIR__ . "/vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$user = $_ENV['ADMIN_USERNAME'];
$password = $_ENV['ADMIN_PASSWORD'];
$currentUser = $_POST["username"];
$currentPassword = $_POST["password"];

if ($user == $currentUser && $password == $currentPassword) {
    $_SESSION['loggedIn'] = true;
    header("Location: registration.html");
} else {
    header("Location: index.php");
    echo "<script>alert(Invalid Login data')</script>";
}

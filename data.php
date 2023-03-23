<?php

/**
 * File name: data.php
 *
 * PHP script that store data in localstorage using session.
 *
 * PHP version 8.2
 *
 * @category PHP
 * @package  PDO
 * @author   sijila <sijila.b@codilar.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://example.com/my_file
 */

require_once realpath(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeload();

$host = $_ENV['HOST'];
$user = $_ENV['USER'];
$password = $_ENV['PASSWORD'];
$database = $_ENV['DATABASE'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$name = $_POST["name"];
$email = $_POST["email"];
$dob = $_POST["dob"];
$phone = $_POST["phone"];
$designation = $_POST["designation"];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM employtb WHERE email = ?");
$stmt->execute([$email]);
$emailCount = $stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT COUNT(*) FROM employtb WHERE phone = ?");
$stmt->execute([$phone]);
$phoneCount = $stmt->fetchColumn();

if ($emailCount > 0) {
    echo "<script>alert('Email already exists. Please enter a different email.')</script>";
    exit();
} else if ($phoneCount > 0) {
    echo "<script>alert('Phone number already exists. Please enter a different phone number.')</script>";
} else {
    try {
        $stmt = $pdo->prepare("INSERT INTO employtb (name, email, dob, phone, designation) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $dob);
        $stmt->bindParam(4, $phone);
        $stmt->bindParam(5, $designation);
        $stmt->execute();
        header('Location: view_employees.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
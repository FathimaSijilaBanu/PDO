<?php

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

$id = $_POST['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM employtb WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: view_employees.php");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

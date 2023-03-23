<?php

/**
 * File name: edit_employee.php
 *
 * PHP script that updates employee data in the database.
 *
 * PHP version 8.2
 *
 * @category PHP
 * @package  PDOTASK
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $designation = $_POST["designation"];
    $stmt = $pdo->prepare("SELECT * FROM employtb WHERE id != :id AND (email = :email OR phone = :phone)");
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo "<script>alert('Phone number or email already exists in the database. Please provide a unique phone number and email.')</script>";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE employtb SET name = :name, email = :email, dob = :dob, phone = :phone, designation = :designation WHERE id = :id");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":dob", $dob);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":designation", $designation);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            header("Location: view_employees.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    $id = $_GET["id"];
    try {
        $stmt = $pdo->prepare("SELECT * FROM employtb WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo "No record found for ID: $id";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="styles.css" class="rel">
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $result['name']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $result['email']; ?>"><br><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo $result['dob']; ?>"><br><br>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $result['phone']; ?>"><br><br>
        <label for="designation">Designation:</label>
        <input type="text" id="designation" name="designation" value="<?php echo $result['designation']; ?>"><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>

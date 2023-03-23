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

if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM employtb WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM employtb");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Employees</title>
    <style>
        table {
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: darkred;
            color:white;
        }

        th {
            background-color: darkred;
            color: white;
        }
        h2 {
    text-align: center;
    color:black;
    margin-top: 50px;
  }
  span{
    display:flex;
  }
  button{
    background-color: black;
    color: #fff;
    padding: 10px 20px;
    border-radius: 3px;
    cursor: pointer;
  }

        </style>
</head>
<body>
    <h2>Employee Information</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Phone</th>
            <th>Designation</th>
            <th>Action</th>
        </tr>
        <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['designation']; ?></td>
            <td>
                <span>
                    <form method="get" action="edit_employee.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <!-- <form method="post" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form> -->
                    <!-- code for the table -->
                    <form method="post" action="delete_employee.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
        </form>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html> 
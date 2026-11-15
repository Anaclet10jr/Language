<?php
// Simple student registration using MySQLi (not PDO).
$host = "localhost";
$username = "root";
$password = "";
$database = "student_portfolio";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed: " . htmlspecialchars($conn->connect_error));
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($name !== "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            $message = "Student registered successfully.";
        } else {
            $message = "Could not register student.";
        }
        $stmt->close();
    } else {
        $message = "Enter a name and a valid email address.";
    }
}

$result = $conn->query("SELECT id, name, email FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 760px; margin: 35px auto; padding: 0 15px; }
        input { display: block; width: 100%; max-width: 380px; padding: 10px; margin: 8px 0; }
        button { padding: 10px 16px; }
        table { border-collapse: collapse; width: 100%; margin-top: 22px; }
        th, td { border: 1px solid #ccc; padding: 9px; text-align: left; }
    </style>
</head>
<body>
    <h1>Student Registration</h1>
    <?php if ($message !== ""): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Name <input type="text" name="name" required></label>
        <label>Email <input type="email" name="email" required></label>
        <button type="submit">Register student</button>
    </form>

    <h2>Registered students</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th></tr>
        <?php while ($student = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars((string)$student["id"]) ?></td>
                <td><?= htmlspecialchars($student["name"]) ?></td>
                <td><?= htmlspecialchars($student["email"]) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>

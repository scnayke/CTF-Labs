<?php

session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "4545";
$db = "vulnapp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Debug: Check if session is active
if (isset($_SESSION["user"])) {
    echo "<p>Session Active: " . $_SESSION["user"] . "</p>";
    header("Location: dashboard.php");
    exit();
}

// Debug: Check if session cookie exists
if (isset($_COOKIE["sessionid"])) {
    echo "<p>Cookie Found: " . $_COOKIE["sessionid"] . "</p>";
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Debug: Check if username/password are received
    if (empty($username) || empty($password)) {
        $error = "Username and password required!";
    } else {
        // Use prepared statements to prevent SQL Injection
        $stmt = $conn->prepare("SELECT username FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            session_regenerate_id(true); // Refresh session for security

            // Generate a custom sessionid with username
            $new_sessionid = $username . "_" . bin2hex(random_bytes(5)); // Example: admin_3f7a9d
            
            $_SESSION["user"] = $username;
            setcookie("sessionid", $new_sessionid, time() + 3600, "/");  // Store custom sessionid in cookie

            // Store session ID in database
            $update_session = $conn->prepare("UPDATE users SET session_id = ? WHERE username = ?");
            $update_session->bind_param("ss", $new_sessionid, $username);
            $update_session->execute();
            $update_session->close();

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VulnApp - Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { width: 300px; padding: 20px; background: white; margin: 100px auto; border-radius: 8px; box-shadow: 2px 2px 10px gray; }
        input { width: 90%; padding: 10px; margin: 5px; border: 1px solid gray; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: blue; color: white; border: none; border-radius: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>


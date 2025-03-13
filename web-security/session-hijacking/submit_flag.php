<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "4545";
$db = "vulnapp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Ensure user is logged in and is NOT a guest
if (!isset($_SESSION["user"]) || $_SESSION["user"] === "Guest") {
    die("<p style='color:red;'>❌ You must be logged in with a valid account to submit a flag.</p><a href='dashboard.php'>Go Back</a>");
}

$username = $_SESSION["user"];

// Check if the user has already submitted a flag
$check_user_stmt = $conn->prepare("SELECT COUNT(*) FROM flags WHERE username = ?");
$check_user_stmt->bind_param("s", $username);
$check_user_stmt->execute();
$check_user_stmt->bind_result($user_flag_count);
$check_user_stmt->fetch();
$check_user_stmt->close();

if ($user_flag_count > 0) {
    die("<p style='color:red;'>❌ You have already submitted a flag! Hijack another session to submit again.</p><a href='dashboard.php'>Go Back</a>");
}

// Flag submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["flag"])) {
    $submitted_flag = trim($_POST["flag"]);

    // **Fix 1: Prevent XSS**
    $submitted_flag = htmlspecialchars($submitted_flag, ENT_QUOTES, 'UTF-8');

    // **Fix 2: Validate flag format**
    if (!preg_match('/^FLAG\{[a-zA-Z0-9_]+\}$/', $submitted_flag)) {
        die("<p style='color:red;'>❌ Invalid flag format! Flags must be in the format FLAG{something}.</p><a href='dashboard.php'>Go Back</a>");
    }

    // **Fix 3: Check if the flag exists in `flags_pool` and is not already used**
    $check_flag_stmt = $conn->prepare("SELECT is_used FROM flags_pool WHERE flag_value = ?");
    $check_flag_stmt->bind_param("s", $submitted_flag);
    $check_flag_stmt->execute();
    $check_flag_stmt->bind_result($is_used);
    if (!$check_flag_stmt->fetch()) {
        die("<p style='color:red;'>❌ Invalid flag! This flag does not exist.</p><a href='dashboard.php'>Go Back</a>");
    }
    $check_flag_stmt->close();

    if ($is_used) {
        die("<p style='color:red;'>❌ This flag has already been used! Hijack another session for a new flag.</p><a href='dashboard.php'>Go Back</a>");
    }

    // **Fix 4: Store the submitted flag in the `flags` table**
    $stmt = $conn->prepare("INSERT INTO flags (username, submitted_flag) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $submitted_flag);
    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Flag submitted successfully!</p>";

        // **Fix 5: Mark the flag as used in `flags_pool`**
        $mark_used_stmt = $conn->prepare("UPDATE flags_pool SET is_used = TRUE WHERE flag_value = ?");
        $mark_used_stmt->bind_param("s", $submitted_flag);
        $mark_used_stmt->execute();
        $mark_used_stmt->close();
    } else {
        echo "<p style='color:red;'>❌ Error submitting flag.</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Flag</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { width: 400px; padding: 20px; background: white; margin: 50px auto; border-radius: 8px; box-shadow: 2px 2px 10px gray; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit Your Flag</h2>
        <form method="POST">
            <input type="text" name="flag" placeholder="Enter the flag (e.g., FLAG{example})" required><br>
            <button type="submit">Submit</button>
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>


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

// Ensure only admin can access
if (!isset($_SESSION["user"]) || $_SESSION["user"] !== "admin") {
    die("Access Denied!");
}

// Step 1: Get the current admin flag (FROM USERS TABLE, NOT FLAGS TABLE)
$flag_check_stmt = $conn->prepare("SELECT assigned_flag FROM users WHERE username = 'admin'");
$flag_check_stmt->execute();
$flag_check_stmt->bind_result($current_admin_flag);
$flag_check_stmt->fetch();
$flag_check_stmt->close();

// If no flag is assigned, get a new one from `flags_pool`
if ($admin_flag === NULL) {
    // Select a random unused flag from `flags_pool`
    $flag_query = $conn->prepare("SELECT flag_value FROM flags_pool WHERE is_used = FALSE ORDER BY RAND() LIMIT 1");
    $flag_query->execute();
    $flag_query->bind_result($new_flag);
    
    if ($flag_query->fetch()) {
        $flag_query->close();

        // Assign the new flag to admin
        $update_admin_flag = $conn->prepare("UPDATE users SET assigned_flag = ? WHERE username = 'admin'");
        $update_admin_flag->bind_param("s", $new_flag);
        $update_admin_flag->execute();
        $update_admin_flag->close();

        $admin_flag = $new_flag;
    } else {
        $admin_flag = "No more flags available.";
    }
}

// Step 2: Check if this flag has already been submitted (USED)
$used_flag_stmt = $conn->prepare("SELECT COUNT(*) FROM flags WHERE submitted_flag = ?");
$used_flag_stmt->bind_param("s", $current_admin_flag);
$used_flag_stmt->execute();
$used_flag_stmt->bind_result($flag_used_count);
$used_flag_stmt->fetch();
$used_flag_stmt->close();

// Step 3: If the flag has been used, assign a new one
if ($flag_used_count > 0) {
    // Get a new unused flag from flags_pool
    $flag_stmt = $conn->prepare("SELECT flag_value FROM flags_pool WHERE is_used = FALSE ORDER BY RAND() LIMIT 1");
    $flag_stmt->execute();
    $flag_stmt->bind_result($new_flag);
    $flag_stmt->fetch();
    $flag_stmt->close();

    if (!empty($new_flag)) {
        // Mark the new flag as used
        $mark_used_stmt = $conn->prepare("UPDATE flags_pool SET is_used = TRUE WHERE flag_value = ?");
        $mark_used_stmt->bind_param("s", $new_flag);
        $mark_used_stmt->execute();
        $mark_used_stmt->close();

        // Assign new flag to admin
        $update_admin_flag = $conn->prepare("UPDATE users SET assigned_flag = ? WHERE username = 'admin'");
        $update_admin_flag->bind_param("s", $new_flag);
        $update_admin_flag->execute();
        $update_admin_flag->close();

        $current_admin_flag = $new_flag;
    } else {
        $current_admin_flag = "NO_FLAG_AVAILABLE";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { width: 600px; padding: 20px; background: white; margin: 50px auto; border-radius: 8px; box-shadow: 2px 2px 10px gray; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background: #333; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <p>Welcome, Admin!</p>

        <!-- Show the current flag for the admin (for attackers to steal) -->
        <p class="flag">Current Admin Flag: <strong><?php echo htmlspecialchars($current_admin_flag); ?></strong></p>

        <h2>Leaderboard - Flag Submissions</h2>
        <table>
            <tr><th>Rank</th><th>Username</th><th>Flags Submitted</th><th>Last Submission Time</th></tr>
            <?php
            // Fetch leaderboard based on the number of flags submitted
            $result = $conn->query("
                SELECT username, COUNT(submitted_flag) AS flag_count, MAX(submission_time) AS last_submission
                FROM flags
                GROUP BY username
                ORDER BY flag_count DESC, last_submission ASC
            ");

            $rank = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rank++ . "</td>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . $row["flag_count"] . "</td>";
                echo "<td>" . $row["last_submission"] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <br>
        <a href="dashboard.php">Back to Dashboard</a> | 
        <a href="comment.php">Go to Comments</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>


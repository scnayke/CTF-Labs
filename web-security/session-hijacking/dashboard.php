<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "4545";
$db = "vulnapp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Get current user
$username = $_SESSION["user"];

// Retrieve the latest submitted flag for the user
$flag_stmt = $conn->prepare("SELECT submitted_flag FROM flags WHERE username = ? ORDER BY submission_time DESC LIMIT 1");
$flag_stmt->bind_param("s", $username);
$flag_stmt->execute();
$flag_stmt->bind_result($submitted_flag);
$flag_stmt->fetch();
$flag_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { width: 400px; padding: 20px; background: white; margin: 50px auto; border-radius: 8px; box-shadow: 2px 2px 10px gray; }
        .flag { color: green; font-weight: bold; }
        .logout { color: red; }
        ol { text-align: left; margin-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>

        <!-- Guided Steps for Lab -->
        <h3>Steps to Complete the Lab:</h3>
        <ol>
            <li>Go to the <strong>Comments Section</strong> and attempt an XSS attack.</li>
            <li>Steal the admin's session and access the <strong>Admin Panel</strong>.</li>
            <li>Find the current flag displayed for the admin.</li>
            <li>Re-login to your own account.</li>
            <li>Submit the flag in the <strong>Submit Flag</strong> section.</li>
            <li>Check your rank on the <strong>Leaderboard</strong>!</li>
        </ol>

        <!-- Display the flag the user last submitted -->
        <?php if (!empty($submitted_flag)) { ?>
            <p class="flag">Your Last Submitted Flag: <strong><?php echo htmlspecialchars($submitted_flag); ?></strong></p>
            <p>(You must hijack another session for a new flag!)</p>
        <?php } else { ?>
            <p class="flag" style="color: red;">You haven't submitted a flag yet. Hijack an admin session to find one!</p>
        <?php } ?>

        <!-- Submit Flag Button -->
        <a href='/vulnapp/submit_flag.php'>Submit a Flag</a><br><br>

        <!-- View Leaderboard -->
        <a href="/vulnapp/leaderboard.php">View Leaderboard</a><br><br>

        <!-- Other Navigation -->
        <a href="/vulnapp/comment.php">Go to Comments</a><br><br>
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <?php 
    // If the user is "admin", redirect them to the comments page
    if ($username === "admin") {
        echo "<script>setTimeout(function() { window.location.href = 'comment.php'; }, 60000);</script>";
    }
    ?>
</body>
</html>

<?php
$conn->close();
?>


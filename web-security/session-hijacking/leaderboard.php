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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
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
        <h1>Leaderboard</h1>
        <table>
            <tr><th>Rank</th><th>Username</th><th>Flags Submitted</th><th>Last Submission Time</th></tr>
            <?php
            // Fetch leaderboard based on number of flags submitted
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
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>


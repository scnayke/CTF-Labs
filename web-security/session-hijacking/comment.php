<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Fix: Ensure session is always set
if (!isset($_SESSION["user"])) {
    $_SESSION["user"] = "Guest"; // Default value to prevent errors
}

$host = "localhost";
$user = "root"; // Change if using a different MySQL user
$pass = "4545"; // Use your MySQL password
$db = "vulnapp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Function to sanitize dangerous XSS while allowing session hijacking
function sanitizeXSS($input) {
    $blacklist = ['window.location', 'document.location', 'innerHTML', 'while(', 'setTimeout', 'setInterval', 'alert(', 'console.log', 'body.remove'];
    
    foreach ($blacklist as $dangerousCode) {
        if (stripos($input, $dangerousCode) !== false) {
            return "[XSS BLOCKED]";
        }
    }

    return $input; // Still allows `document.cookie` for session hijacking
}

// Handle comment deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_comment"])) {
    if (!isset($_SESSION["user"])) {
        die("You must be logged in to delete comments.");
    }

    $comment_id = $_POST["delete_id"];
    $username = $_SESSION["user"] ?? "Guest"; // Fix: Default to "Guest"

    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $comment_id, $username);
    
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Comment deleted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error deleting comment.</p>";
    }
}

// Handle new comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["comment"])) {
    if (!isset($_SESSION["user"])) {
        die("You must be logged in to post comments.");
    }

    $comment = $_POST["comment"];
    $username = $_SESSION["user"] ?? "Guest"; // Fix: Default to "Guest"

    $stmt = $conn->prepare("INSERT INTO comments (text, username) VALUES (?, ?)");
    $stmt->bind_param("ss", $comment, $username);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Comment added successfully!</p>";
    } else {
        die("<p style='color:red;'>Error adding comment: " . $stmt->error . "</p>");
    }
    $stmt->close();
}

// Fetch comments
$result = $conn->query("SELECT * FROM comments");
if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { width: 400px; padding: 20px; background: white; margin: 50px auto; border-radius: 8px; box-shadow: 2px 2px 10px gray; }
        input, button { width: 90%; padding: 10px; margin: 5px; border: 1px solid gray; border-radius: 5px; }
        .comment { border: 1px solid #ccc; background: #e9e9e9; padding: 10px; margin: 5px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Leave a Comment</h2>
        <form method="POST">
            <input type="text" name="comment" placeholder="Your comment here" required><br>
            <button type="submit">Post</button>
        </form>
        <h3>Comments</h3>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="comment">
                <strong><?php echo htmlspecialchars($row["username"]); ?>:</strong> 
                <?php 
                    // If the admin bot is visiting, show only safe text
                    if (isset($_GET["adminsafe"])) {
                        echo htmlspecialchars($row["text"]);
                    } else {
                        echo sanitizeXSS($row["text"]); // Allow controlled XSS
                    }
                ?>
                <!-- Show the delete button only for the user who posted the comment -->
                <?php if ($row["username"] == ($_SESSION["user"] ?? "Guest")) { ?>
                    <form method="POST" action="comment.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_comment" style="color: red;">Delete</button>
                    </form>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>


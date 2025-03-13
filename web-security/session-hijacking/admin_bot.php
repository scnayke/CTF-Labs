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

// Admin credentials
$admin_username = "admin";
$admin_password = "admin123!"; // Replace with actual admin password

// Retrieve admin's session ID from the database
$stmt = $conn->prepare("SELECT session_id FROM users WHERE username=?");
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$stmt->bind_result($admin_session_id);
$stmt->fetch();
$stmt->close();

// If the admin has no session ID, generate one
if (!$admin_session_id) {
    $admin_session_id = "admin_" . bin2hex(random_bytes(5)); // Example: admin_3f7a9d

    // Store session ID in database
    $update_session = $conn->prepare("UPDATE users SET session_id = ? WHERE username = ?");
    $update_session->bind_param("ss", $admin_session_id, $admin_username);
    $update_session->execute();
    $update_session->close();
}

// Set session and cookies to match admin's session
$_SESSION["user"] = "admin";
setcookie("sessionid", $admin_session_id, time() + 3600, "/");  

// Admin bot continuously visits the comments page with cookies
while (true) {
    echo "Admin bot visiting comments page with session ID: $admin_session_id\n";
    
    // Use cURL instead of file_get_contents to send cookies
    $ch = curl_init("http://172.16.230.24/vulnapp/comment.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIE, "sessionid=$admin_session_id"); // Send the admin's session ID
    curl_exec($ch);
    curl_close($ch);

    // Wait before next visit
    sleep(5);
}

?>


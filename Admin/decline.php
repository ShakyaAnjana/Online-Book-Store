<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Database connection and session validation

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Delete the user's data from the database
        $delete_sql = "DELETE FROM user_info WHERE user_id = '$user_id'";

        if ($conn->query($delete_sql)) {
            // Deletion successful, redirect to user.php
            header("Location: user.php");
            exit;
        } else {
            // Deletion failed, display an error message
            echo "Error deleting user data: " . $conn->error;
        }
    } else {
        // User ID not provided, display an error message
        echo "Invalid request";
    }
}
?>


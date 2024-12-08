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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Update the user's status to "approved"
        $sql = "UPDATE user_info SET status = 'approved' WHERE user_id = '$user_id'";

        if ($conn->query($sql)) {
            // Approval successful, show a success message or redirect to admin.php
            header("Location: admin.php");
        } else {
            // Approval failed, display an error message
            echo "Error: " . $conn->error;
        }
    } else {
        // User ID not provided, display an error message
        echo "Invalid request";
    }
}

$conn->close();
?>

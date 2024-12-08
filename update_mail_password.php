<?php
include "./include/db_connection.php";

// Start the session
session_start();

// Password update
if (isset($_POST['update'])) {
    // Check if the 'email' key is set in the session
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $oldPassword = $_POST['op'];
        $newPassword = $_POST['np'];
        $confirmPassword = $_POST['cp'];

        // Sanitize and validate user input
        $email = mysqli_real_escape_string($conn, $email);
        $oldPassword = mysqli_real_escape_string($conn, $oldPassword);
        $newPassword = mysqli_real_escape_string($conn, $newPassword);
        $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

        // Retrieve the current password from the database
        $sql = "SELECT password FROM user_info WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $currentPassword = $row["password"];

            if ($currentPassword !== $oldPassword) {
                echo "Old password is incorrect.";
            } else {
                // Update the password in the database
                $updateSql = "UPDATE user_info SET password = '$newPassword' WHERE email = '$email'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            }
        }
    } else {
        echo "Session email not set.";
    }
}


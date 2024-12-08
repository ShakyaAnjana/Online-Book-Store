<?php
include "db_connection.php";
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check both user_info and admin_info tables for the provided email and password
    $userQuery = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password'";
    $adminQuery = "SELECT * FROM admin_info WHERE email = '$email' AND password = '$password'";

    $userResult = $conn->query($userQuery);
    $adminResult = $conn->query($adminQuery);

    if ($userResult->num_rows == 1) {
        $row = $userResult->fetch_assoc();
        $status = $row['status'];
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $row['user_id']; // Set the user ID in the session

        if ($status == 'approved') {
            // User is approved, allow login
            // Redirect to the user's dashboard or home page
            header("Location:../home.php");
            exit();
        } else {
            // User is not approved yet, display an error message or redirect to a waiting page
            echo "Your account is pending admin approval.";
            exit();
        }
    } elseif ($adminResult->num_rows > 0) {
        // Admin login logic
        $row = $adminResult->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['admin_id'] = $row['admin_id'];
        header("Location: ../Admin/admin.php");
        exit();
    } else {
        // Invalid login credentials
        echo "Invalid email or password.";
        exit();
    }
}
?>
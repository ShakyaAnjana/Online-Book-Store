<?php
session_start();
include "db_connection.php";

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Get the user's ID from the user_info table
    $getUserIDSql = "SELECT user_id FROM user_info WHERE email = '$email'";
    $userResult = mysqli_query($conn, $getUserIDSql);
    
    if ($userResult && mysqli_num_rows($userResult) > 0) {
        $userRow = mysqli_fetch_assoc($userResult);
        $userID = $userRow['user_id'];

        // Delete user-related data from other tables
        // Delete from book_info table
        $deleteBookSql = "DELETE FROM book_info WHERE owner_email = '$email'";
        if (!mysqli_query($conn, $deleteBookSql)) {
            // Handle error during deletion
            echo "Error deleting user's books: " . mysqli_error($conn);
        }

        // Delete from cart table
        $deleteCartSql = "DELETE FROM cart WHERE user_id = '$userID'";
        if (!mysqli_query($conn, $deleteCartSql)) {
            // Handle error during deletion
            echo "Error deleting user's cart: " . mysqli_error($conn);
        }

        // Delete user profile picture if exists
        $sql = "SELECT user_pic FROM user_info WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userPic = $row['user_pic'];
            if (!empty($userPic)) {
                $userPicPath = "include/user_pictures/" . $userPic;
                if (file_exists($userPicPath)) {
                    unlink($userPicPath);
                }
            }
        }

        // Delete the user account
        $deleteUserSql = "DELETE FROM user_info WHERE email = '$email'";
        if (mysqli_query($conn, $deleteUserSql)) {
            // Account deleted successfully
            session_destroy();
            header("Location: ../index.php"); // Redirect to index.php or any other appropriate page
            exit();
        } else {
            // Handle error during deletion
            echo "Error deleting account: " . mysqli_error($conn);
        }
    } else {
        // Handle error, user not found
        echo "Error finding user: " . mysqli_error($conn);
    }
} else {
    // User not logged in, redirect to login page or show an error message
    header("Location: ../index.php"); // Redirect to login page or any other appropriate page
    exit();
}
?>

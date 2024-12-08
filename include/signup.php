<?php
include "db_connection.php";

$error_message = "";

if (isset($_POST['sign_up'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $status = "Pending"; // Default status is set to "Pending"

    // Check if the provided email already exists in user_info table
    $userExistsQuery = "SELECT * FROM user_info WHERE email = '$email'";
    $userExistsResult = $conn->query($userExistsQuery);

    // Check if the provided email already exists in admin_info table
    $adminExistsQuery = "SELECT * FROM admin_info WHERE email = '$email'";
    $adminExistsResult = $conn->query($adminExistsQuery);

    if ($userExistsResult->num_rows > 0 || $adminExistsResult->num_rows > 0) {
        // Email already exists in user_info or admin_info table
        $error_message = "Email already exists.";
    } else {
        // Email doesn't exist, proceed with user registration
        $sql = "INSERT INTO user_info (fname, lname, phone, address, email, password, dob, status) 
                VALUES ('$fname', '$lname', '$phone', '$address', '$email', '$password', '$dob', '$status')";
    
        if ($conn->query($sql)) {
            header("Location:../index.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$response = array('error_message' => $error_message);
echo json_encode($response);
?>

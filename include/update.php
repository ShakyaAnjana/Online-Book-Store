<?php

if (isset($_POST['update'])) {
    session_start();
    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        $data = $_SESSION['email'];
    } else {
        $data = "";
    }
    
    include "db_connection.php";
    
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    // Update user info
    $sql = "UPDATE user_info SET fname='$fname', mname='$mname', lname='$lname', phone='$phone', dob='$dob', gender='$gender', address='$address'  WHERE email = '$data'";
    if ($conn->query($sql)) {
        
        // User info updated successfully
        
        // Check if a new user picture is uploaded
        if ($_FILES['user_pic']['name'] !== '') {
            $targetDirectory = "user_pictures/";
            $fileName = $_FILES['user_pic']['name'];
            $targetFilePath = $targetDirectory . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
            // Allow only specific file formats
            $allowedTypes = array('jpg', 'jpeg', 'png','JPG','JPEG','PNG');
            if (in_array($fileType, $allowedTypes)) {
                // Move the uploaded file to the desired directory
                if (move_uploaded_file($_FILES['user_pic']['tmp_name'], $targetFilePath)) {
                    // Update the user picture path in the database
                    $sql = "UPDATE user_info SET user_pic = '$fileName', userPic_path = '$targetFilePath' WHERE email = '$data'";
                    if ($conn->query($sql)) {
                        header("Location: ../profile.php");
                        exit();
                    } else {
                        echo "Failed to update user picture.";
                    }
                } else {
                    echo "Failed to upload the user picture.";
                }
            } else {
                echo "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        } else {
            header("Location: ../profile.php");
            exit();
        }
    } else {
        echo "Error updating user info.";
    }
}

?>

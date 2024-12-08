<?php
include "db_connection.php";
session_start();

$conn = new mysqli("localhost", "root", "", "obs");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['update'])) {
    $book_id = $_POST['book_id'];
    $book_isbn = $_POST['book_isbn'];
    $book_name = $_POST['book_name'];
    $book_author = $_POST['book_author'];
    $book_price = $_POST['book_price'];
    $book_publication = $_POST['book_publication'];
    $book_categories = $_POST['book_categories'];
    $book_subcategories = $_POST['book_subcategories'];
    $book_subsubcategories = $_POST['book_subsubcategories'];
    $book_condition = $_POST['book_condition'];
    $book_quantity = $_POST['book_quantity'];

    // Check if the new ISBN conflicts with existing entries owned by the logged-in user
    $checkDuplicateIsbnQuery = "SELECT book_id FROM book_info WHERE book_isbn = ? AND owner_email = ? AND book_id != ?";
    
    $stmt = $conn->prepare($checkDuplicateIsbnQuery);
    $stmt->bind_param("ssi", $book_isbn, $_SESSION['email'], $book_id);
    $stmt->execute();
    $duplicateIsbnResult = $stmt->get_result();
    
    if ($duplicateIsbnResult === false) {
        echo "Error: " . $conn->error;
        exit();
    }

    if ($duplicateIsbnResult->num_rows > 0) {
        // ISBN number already exists for another book owned by the same user, handle the error
        echo "Error: The ISBN number is already in use.";
        exit();
    }
    // Check if a file was uploaded
    if (isset($_FILES['book_pic']) && $_FILES['book_pic']['error'] === UPLOAD_ERR_OK) {
        // Define the path where the uploaded file will be saved
        $target_dir = "../uploads/"; // Change this to your desired directory
        $book_pic_tmp = $_FILES['book_pic']['tmp_name'];
        $book_pic_name = $_FILES['book_pic']['name'];
        $target_file = $target_dir . basename($book_pic_name);

        if (move_uploaded_file($book_pic_tmp, $target_file)) {
            // File upload successful
            $bookpic_path = $target_file;
        } else {
            // File upload failed
            echo "Error uploading file.";
            exit();
        }
    } else {
        // No file uploaded, use the existing value from the database
        $sql = "SELECT book_pic, bookpic_path FROM book_info WHERE book_id = '$book_id'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $book_pic = $row['book_pic'];
            $bookpic_path = $row['bookpic_path'];
        } else {
            echo "Error retrieving book details from the database.";
            exit();
        }
    }

    // Escape special characters in the input values
    $book_name = $conn->real_escape_string($book_name);
    $book_author = $conn->real_escape_string($book_author);

    // Update the book details in the database
    $sql = "UPDATE book_info SET
            book_isbn = '$book_isbn',
            book_name = '$book_name',
            book_author = '$book_author',
            book_price = '$book_price',
            book_publication = '$book_publication',
            book_condition = '$book_condition',
            book_quantity = '$book_quantity',
            book_categories = '$book_categories',
            book_subcategories = '$book_subcategories',
            book_subsubcategories = '$book_subsubcategories',
            book_pic = '$book_pic',
            bookpic_path = '$bookpic_path'
            WHERE book_id = '$book_id'";

    if ($conn->query($sql) === TRUE) {
        // Update successful
        header("Location: ../my_book.php?book_id=$book_id");
        exit();
    } else {
        // Update failed
        echo "Error updating book: " . $conn->error;
    }
} else {
    // Invalid form submission
    echo "Invalid request.";
}

$conn->close();
?>

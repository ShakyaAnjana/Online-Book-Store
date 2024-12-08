<?php
session_start();
include "db_connection.php";

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    $email = "";
}

if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    // Book ID is provided, proceed with deletion
    $book_id = $_GET['book_id'];
    // Retrieve the book details from the database
    $sql = "SELECT * FROM book_info WHERE book_id = '$book_id' AND owner_email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Book found, delete it
        $row = $result->fetch_assoc();
        $book_pic = $row['book_pic'];
        $bookpic_path = $row['bookpic_path'];

        // Delete the book entry from the database
        $delete_sql = "DELETE FROM book_info WHERE book_id = '$book_id' AND owner_email = '$email'";
        if ($conn->query($delete_sql)) {
            // Deletion successful, delete the book cover image file
            unlink("../uploads/" . $bookpic_path);

            header("Location: ../sellhere.php");
            // You can redirect to a success page if desired
            // header("Location: success.php");
        } else {
            echo "Error deleting book: " . $conn->error;
        }
    } else {
        // Book not found or not owned by the user
        echo "Book not found or you don't have permission to delete it.";
    }
} else {
    // Book ID missing or empty
    echo "Invalid request. Book ID is missing or empty.";
}

$conn->close();
?>

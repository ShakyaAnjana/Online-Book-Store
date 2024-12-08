<?php

include "./db_connection.php";

session_start();

if (isset($_POST['add'])) {
    $book_id = $_POST['book_id'];
    $book_isbn = mysqli_real_escape_string($conn, $_POST["book_isbn"]);
    $book_name = mysqli_real_escape_string($conn, $_POST["book_name"]);
    $book_author = mysqli_real_escape_string($conn, $_POST["book_author"]);
    $book_price = mysqli_real_escape_string($conn, $_POST["book_price"]);
    $book_publication = mysqli_real_escape_string($conn, $_POST["book_publication"]);

    // Check if the array keys exist
    $book_condition = isset($_POST["book_condition"]) ? mysqli_real_escape_string($conn, $_POST["book_condition"]) : "";
    $book_quantity = isset($_POST["book_quantity"]) ? mysqli_real_escape_string($conn, $_POST["book_quantity"]) : "";

    // Check if the array keys exist
    $book_categories_id = isset($_POST["book_categories"]) ? mysqli_real_escape_string($conn, $_POST["book_categories"]) : null;
    $book_subcategories_id = isset($_POST["book_subcategories"]) ? mysqli_real_escape_string($conn, $_POST["book_subcategories"]) : null;
    $book_subsubcategories_id = isset($_POST["book_subsubcategories"]) ? mysqli_real_escape_string($conn, $_POST["book_subsubcategories"]) : null;

    // File upload handling
    $book_pic = mysqli_real_escape_string($conn, $_FILES["book_pic"]["name"]);
    $bookpic_path = "../uploads/" . $book_pic; // Adjust the upload directory path as needed

    // Check if the file was uploaded successfully
    if (move_uploaded_file($_FILES["book_pic"]["tmp_name"], $bookpic_path)) {
        // Retrieve the email from the session
        $email = $_SESSION['email'];

        // Check if the user already has a book with the same ISBN
        $duplicateCheckQuery = "SELECT book_id FROM book_info WHERE book_isbn = '$book_isbn' AND owner_email = '$email'";
        $duplicateCheckResult = mysqli_query($conn, $duplicateCheckQuery);

        if ($duplicateCheckResult && mysqli_num_rows($duplicateCheckResult) > 0) {
            // User already has a book with the same ISBN, show an error message or take appropriate action
            echo "You have already added a book with the same ISBN.";
        } else {
            // Construct the SQL statement
            $sql = "INSERT INTO book_info (book_id, book_isbn, book_name, book_author, book_price, book_publication, book_condition, book_quantity, book_categories, book_subcategories, book_subsubcategories, book_pic, bookpic_path, owner_email)
                    VALUES ('$book_id', '$book_isbn', '$book_name', '$book_author', '$book_price', '$book_publication', '$book_condition', '$book_quantity', '$book_categories_id', '$book_subcategories_id', '$book_subsubcategories_id', '$book_pic', '$bookpic_path', '$email')";

            // Execute the SQL statement
            if ($conn->query($sql) === true) {
                header("Location:../sellhere.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    }
}
?>

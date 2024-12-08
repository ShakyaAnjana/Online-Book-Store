<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "./include/db_connection.php"; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id']) && isset($_POST['quantity'])) {
    $bookId = $_POST['book_id'];
    $quantity = $_POST['quantity'];

    // Check if the user_id is set in the session
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['cart_error'] = "User ID is not set in the session.";
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=1");
        exit();
    }

    $userId = $_SESSION['user_id'];

    // Check if the item already exists in the cart
    $selectSql = "SELECT * FROM cart WHERE user_id = ? AND book_id = ?";
    $selectStmt = mysqli_prepare($conn, $selectSql);
    mysqli_stmt_bind_param($selectStmt, "ii", $userId, $bookId);
    mysqli_stmt_execute($selectStmt);

    $result = mysqli_stmt_get_result($selectStmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update quantity if item exists
        $row = mysqli_fetch_assoc($result);
        $newQuantity = $row['quantity'] + $quantity;

        // Check if adding the desired quantity exceeds the quantity limit
        $bookInfoSql = "SELECT * FROM book_info WHERE book_id = ?";
        $bookInfoStmt = mysqli_prepare($conn, $bookInfoSql);
        mysqli_stmt_bind_param($bookInfoStmt, "i", $bookId);
        mysqli_stmt_execute($bookInfoStmt);
        $bookInfoResult = mysqli_stmt_get_result($bookInfoStmt);
        $bookInfo = mysqli_fetch_assoc($bookInfoResult);

        if ($newQuantity > $bookInfo['book_quantity']) {
            $_SESSION['cart_error'] = "Adding this quantity would exceed the product's quantity.";
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=1");
            exit();
        }

        // Update the quantity of the existing item in the cart
        $updateSql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "ii", $newQuantity, $row['id']);
        mysqli_stmt_execute($updateStmt);
    } else {
        // Insert new item into the cart
        $insertSql = "INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "iii", $userId, $bookId, $quantity);
        mysqli_stmt_execute($insertStmt);
    }

    // Redirect to cart page
    header("Location: cart.php");
    exit();
}
?>

<?php
include "./include/db_connection.php";
session_start();

$bookId = isset($_GET['book_id']) ? $_GET['book_id'] : null;
$book = null;
$bookNotFound = false; // Initialize book not found flag

if ($bookId) {
    $sql = "SELECT * FROM book_info WHERE book_id = '$bookId'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $book = mysqli_fetch_assoc($res);
    }
}

if (!$book) {
    // Book not found, set the flag
    $bookNotFound = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $quantity = $_POST['quantity'];
        $userId = $_SESSION['user_id'];

        $sql = "INSERT INTO cart (user_id, book_id, quantity) VALUES ($userId, $bookId, $quantity)";
        mysqli_query($conn, $sql);

        // Redirect to cart or show a success message
        header("Location: cart.php");
        exit();
    }
}

// Check for cart error message
$cartError = isset($_SESSION['cart_error']) ? $_SESSION['cart_error'] : null;
unset($_SESSION['cart_error']); // Clear the error message
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="./CSS/book_detail.css">
</head>
<style>
    .button-container {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .add-to-cart-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .add-to-cart-btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .cart-icon {
    width: 18px; 
    height: 18px; 
    margin-right: 5px; 
    vertical-align: middle; 
}

    .quantity-input {
        width: 50px;
        padding: 6px;
        margin-left: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
        outline: none;
        text-align: center;
    }

    .container1 {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f9f9f9;
        border-radius: 5px;
        padding: 20px;
        z-index: 9999;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .container1 h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .container1 h3 {
        font-size: 18px;
        color: #555;
        margin-bottom: 5px;
    }

    .container1 .owner-info h1,
    .container1 .owner-info h2 {
        margin: 5px 0;
    }

    .container1 .owner-info h1 {
        font-size: 20px;
        color: #333;
    }

    .container1 .owner-info h2 {
        font-size: 16px;
        color: #555;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
    }

    body.popup-active {
        overflow: hidden;
    }

    .popup-active .overlay,
    .popup-active .container1 {
        display: block;
    }
    .error-message{
        color: red;
    }
</style>

<body>
    <div class="container">
        <?php if ($book) { ?>
            <div class="book-details">
                <div class="pic">
                    <img src="uploads/<?= $book['bookpic_path'] ?>" alt="Book Cover">
                </div>
                <div class="des">
                    <h1><?= $book['book_name'] ?></h1>
                    <p>Book ISBN : <?= $book['book_isbn'] ?></p>
                    <p>Author : <?= $book['book_author'] ?></p>
                    <p>Price : Rs.<?= $book['book_price'] ?></p>
                    <p>Publication : <?= $book['book_publication'] ?></p>
                    <p>Quantity : <?= $book['book_quantity'] ?></p>
                    <p>Condition : <?= $book['book_condition'] ?></p>
                    <button id="buy-now-btn">Buy Now</button>
                    <div class="button-container">
                        <form action="addToCart.php" method="POST">
                            <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                            <input type="number" name="quantity" class="quantity-input" value="1" min="1" max="<?= $book['book_quantity'] ?>">
                            <button type="submit" class="add-to-cart-btn">
                                <img src="./Photos/add-to-cart.png" alt="Cart Icon" class="cart-icon">
                                Add to Cart
                            </button>
                            <!-- Display cart error message -->
                            <?php if ($cartError) { ?>
                                <div class="error-message">
                                    <?= $cartError ?>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <p>Book not found.</p>
        <?php } ?>
    </div>

    <div class="container1">
        <h1>Thank you for your Time!</h1>
        <h3>To buy this book, please contact the owner directly.</h3>
        <h3>Details are given below:</h3>
        <hr>
        <div class="owner-info">
            <?php
            $sql = "SELECT * FROM book_info WHERE book_id = '$bookId'";
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $owner_email = $row['owner_email'];
                }
            }

            $nam = "SELECT * FROM user_info WHERE email = '$owner_email'";
            if ($res = mysqli_query($conn, $nam)) {
                if (mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $fname = $row['fname'];
                    $mname = $row['mname'];
                    $lname = $row['lname'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $address = $row['address'];
                    echo "<h1>Name: $fname $mname $lname</h1>";
                    echo "<h2>Email: $email</h2>";
                    echo "<h2>Phone No.: $phone</h2>";
                    echo "<h2>Address: $address</h2>";
                }
            }
            ?>
        </div>
    </div>

    <div class="overlay"></div>
    

    <script>
        // JavaScript code to show the container1 div when the Buy Now button is clicked
        var buyNowButton = document.getElementById("buy-now-btn");
        var container1Div = document.querySelector(".container1");
        var overlayDiv = document.querySelector(".overlay");
        var bodyElement = document.querySelector("body");

        buyNowButton.addEventListener("click", function() {
            container1Div.style.display = "block";
            overlayDiv.style.display = "block";
            bodyElement.classList.add("popup-active");
        });

        overlayDiv.addEventListener("click", function() {
            container1Div.style.display = "none";
            overlayDiv.style.display = "none";
            bodyElement.classList.remove("popup-active");
        });
    </script>
</body>

</html>
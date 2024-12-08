<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "./include/db_connection.php"; // Include your database connection

// Fetch cart items for the current user
$userId = $_SESSION['user_id'];

$sql = "SELECT c.*, b.book_name, b.book_price, b.book_author, u.fname, u.mname, u.lname, u.address AS owner_address, u.phone AS owner_phone
        FROM cart c
        JOIN book_info b ON c.book_id = b.book_id
        JOIN user_info u ON b.owner_email = u.email
        WHERE c.user_id = $userId";

$result = mysqli_query($conn, $sql);

$cartItems = []; // Initialize the cart items array

while ($item = mysqli_fetch_assoc($result)) {
    $cartItems[] = $item; // Add each item to the cart items array
}

if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];
    $userId = $_SESSION['user_id'];

    // Delete the item from the cart
    $deleteSql = "DELETE FROM cart WHERE id = $itemId AND user_id = $userId";
    mysqli_query($conn, $deleteSql);

    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .whole {
            display: block;
            height: 100vh;
            width: 100%;
            position: fixed;
            overflow-y: scroll;
        }

        .whole::-webkit-scrollbar {
            display: none;
        }

        .nab {
            display: flex;
            flex-wrap: wrap;
            display: inline-block;
            margin-top: 0%;
            position: fixed;
            width: 100%;
            height: 15vh;
        }

        .main {
            margin-top: 20vh;
            height: 100vh;
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        .main::-webkit-scrollbar {
            display: none;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .cart-container {
            width: 80%;
            margin: 20px auto;
            /* margin-top: 20vh; */
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .cart-title {
            font-size: 24px;
            color: #333;
        }

        .empty-cart-msg {
            text-align: center;
            color: #777;
        }

        .remove-btn,
        .buy-btn {
            background-color: #c40000;
            color: #fff;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .remove-btn:hover,
        .buy-btn:hover {
            background-color: #c40000;
        }

        /* Styling for buy button */
        .buy-btn {
            background-color: #007bff;
            margin-left: 10px;
        }

        .buy-btn:hover {
            background-color: #0056b3;
        }

        /* Adjustments for delete icon */
        .remove-btn img {
            width: 20px;
            height: auto;
            filter: brightness(0);
            filter: invert(0);
        }

        /* Styling for the button group container */
        .btn-group {
            display: flex;
            align-items: center;
            align-self: center;
        }

        /* Styling for the button forms */
        .btn-form {
            margin: 0;
            padding: 0;
            display: inline;
        }

        .remove-btn:hover,
        .remove-btn:focus {
            background-color: #e60000;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="whole">
        <div class="nab">
            <?php include "navbar.php"; ?>
        </div>
        <div class="main">
            <div class="cart-container">
                <h1 class="cart-title">Your Cart</h1>
                <?php if (count($cartItems) > 0) { ?>
                    <table>
                        <tr>
                            <th>Book</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($cartItems as $item) { ?>
                            <tr>
                                <td><?= $item['book_name'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>Rs. <?= $item['book_price'] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <form method="post" action="cart.php" class="btn-form">
                                            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                            <button type="submit" class="remove-btn"><img src="./Photos/delete.png" alt="" srcset=""></button>
                                        </form>
                                        <button type="button" class="buy-btn" onclick="showOwnerDetails('<?= $item['fname'] ?>', '<?= $item['mname'] ?>', '<?= $item['lname'] ?>', '<?= $item['owner_address'] ?>', '<?= $item['owner_phone'] ?>')">Buy Now</button>

                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p class="empty-cart-msg">Your cart is empty. Start shopping now!</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="popup" id="ownerPopup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Book Owner Details</h2>
            <p><strong>Name:</strong> <span id="ownerName"></span></p>
            <p><strong>Address:</strong> <span id="ownerAddress"></span></p>
            <p><strong>Phone Number:</strong> <span id="ownerPhone"></span></p>
        </div>
    </div>
    <script>
        function showOwnerDetails(firstName, middleName, lastName, address, phone) {
    const fullName = [firstName, middleName, lastName].filter(namePart => namePart.trim() !== '').join(' ');
    document.getElementById("ownerName").textContent = fullName;
    document.getElementById("ownerAddress").textContent = address;
    document.getElementById("ownerPhone").textContent = phone;
    document.getElementById("ownerPopup").style.display = "block";
}

        function closePopup() {
            document.getElementById("ownerPopup").style.display = "none";
        }
    </script>
    
</body>

</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM user_info WHERE status = 'pending'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        /* Styles for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: fit-content;
            background-color: rgba(178, 34, 34, 0.1);
        }

        h1 {
            background: linear-gradient(to right, #a8c0ff, #3f51b5);
            color: #fff;
            padding: 20px;
            margin: 0;
            text-align: center;
        }

        .page-introduction {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
        }

        .page-introduction p {
            text-align: center;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        form {
            display: inline-block;
            margin: 0;
        }

        input[type="submit"] {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #d32f2f;
        }

        /* Styles for the navbar */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #B22222;
            width: 100%;
            height: 10vh;
        }

        .logo {
            margin-left: 20px;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .navbar a {
            text-decoration: none;
            margin: 20px;
            color: #fff;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background-color: #45a049;
        }

        button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.3);
            transition: left 0.3s ease;
            z-index: -1;
        }

        button:hover::before {
            left: 100%;
        }

        .approval-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .approval-table th,
        .approval-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .approval-table th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .approval-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }
    </script>
    <meta http-equiv="refresh" content="10">
</head>

<body>
    <header>
        <div class="logo">
            <!-- Add your logo here -->
            <img src="../Photos/logo.png" alt="Logo">
        </div>
        <nav class="navbar">
            <a href="admin.php">Home</a>
            <a href="user.php">Manage Users</a>
            <a href="product.php">Manage Products</a>
            <a href="View_Categories.php">Manage Categories</a>
        </nav>
    </header>

    <h1>User Approval Requests</h1>
    <div class="page-introduction">
        <p>This table displays the pending user approval requests.</p>
    </div>
    <hr>

    <table>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>LastName</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['lname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>";
                echo "<form method='POST' action='approve.php'>";
                echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
                echo "<input type='submit' name='approve_user' value='Approve'>";
                echo "</form>";
                echo "<form method='POST' action='decline.php'>";
                echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
                echo "<input type='submit' name='decline_user' value='Decline'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No pending approval requests.</td></tr>";
        }
        ?>
    </table>

    <br><br>
    <hr><br> <br>

    <h1>User Details</h1>
    <div class="page-introduction">
        <p>This table displays the details of all users.</p>
    </div>
    <hr>

    <table class="approval-table">
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
            <th>Password</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>User Picture</th>
            <th>User Picture Path</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM user_info";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['fname'] . "</td>";
            echo "<td>" . $row['mname'] . "</td>";
            echo "<td>" . $row['lname'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['dob'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['user_pic'] . "</td>";
            echo "<td>" . $row['userpic_path'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>";
            echo "<form method='POST' action='' onsubmit='return confirmDelete()'>";
            echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
            echo "<input type='submit' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];

            // Begin a transaction
            $conn->begin_transaction();

            try {
                // Delete related cart records
                $deleteCartQuery = "DELETE FROM cart WHERE user_id = '$user_id'";
                $conn->query($deleteCartQuery);

                // Delete books added by the user from book_info table
                $deleteBooksQuery = "DELETE FROM book_info WHERE owner_email IN (SELECT email FROM user_info WHERE user_id = '$user_id')";
                $conn->query($deleteBooksQuery);

                // Delete user data from the user_info table
                $deleteUserQuery = "DELETE FROM user_info WHERE user_id = '$user_id'";
                if ($conn->query($deleteUserQuery) === TRUE) {
                    // Commit the transaction
                    $conn->commit();
                    header("Location: user.php"); // Redirect to user.php
                } else {
                    throw new Exception("Error deleting user: " . $conn->error);
                }
            } catch (Exception $e) {
                // Rollback the transaction in case of error
                $conn->rollback();
                echo "An error occurred: " . $e->getMessage();
            }
        } else {
            echo "Invalid request.";
        }
    }

    ?>

</body>

</html>
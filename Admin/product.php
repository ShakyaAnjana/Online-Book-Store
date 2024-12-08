<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Details</title>
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

        .delete-form {
            display: inline-block;
        }

        .delete-button {
            background-color: #ff6262;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #ff4040;
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
    </style>
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
    <h1>Books Details</h1>
    <div class="page-introduction">

    </div>
    <hr>
    <table>
        <tr>
            <th>Book ID</th>
            <th>Book ISBN</th>
            <th>Book Name</th>
            <th>Author</th>
            <th>Price</th>
            <th>Publisher</th>
            <th>Categories</th>
            <th>Sub Categories</th>
            <th>Sub sub Categories</th>
            <th>Book Pic</th>
            <th>Book pic path</th>
            <th>Owner Email</th>
            <th>Action</th>
        </tr>
        <?php
        $conn = new mysqli("localhost", "root", "", "obs");
        if ($conn->connect_error) {
            die("Connection Error");
        }
        $sql = "SELECT * FROM book_info";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . $row['book_isbn'] . "</td>";
            echo "<td>" . $row['book_name'] . "</td>";
            echo "<td>" . $row['book_author'] . "</td>";
            echo "<td>" . $row['book_price'] . "</td>";
            echo "<td>" . $row['book_publication'] . "</td>";

              // Fetch and display category name
    $category_id = $row['book_categories'];
    $category_sql = "SELECT category_name FROM categories WHERE category_id = $category_id";
    $category_result = $conn->query($category_sql);
    $category_row = $category_result->fetch_assoc();
    echo "<td>" . $category_row['category_name'] . "</td>";

    // Fetch and display subcategory name
    $subcategory_id = $row['book_subcategories'];
    $subcategory_sql = "SELECT subcategory_name FROM subcategories WHERE subcategory_id = $subcategory_id";
    $subcategory_result = $conn->query($subcategory_sql);
    $subcategory_row = $subcategory_result->fetch_assoc();
    echo "<td>" . $subcategory_row['subcategory_name'] . "</td>";

    // Fetch and display subsubcategory name
    $subsubcategory_id = $row['book_subsubcategories'];
if ($subsubcategory_id !== null && $subsubcategory_id !== "") {
    $subsubcategory_sql = "SELECT subsubcategory_name FROM subsubcategories WHERE subsubcategory_id = $subsubcategory_id";
    $subsubcategory_result = $conn->query($subsubcategory_sql);
    $subsubcategory_row = $subsubcategory_result->fetch_assoc();
    echo "<td>" . $subsubcategory_row['subsubcategory_name'] . "</td>";
} else {
    echo "<td></td>"; // Display an empty cell if subsubcategory is not set
}

            echo "<td>" . $row['book_pic'] . "</td>";
            echo "<td>" . $row['bookpic_path'] . "</td>";
            echo "<td>" . $row['owner_email'] . "</td>";
            echo "<td>";
            echo "<form class='delete-form' method='POST' action='' onsubmit='return confirm(\"Are you sure you want to delete this book?\")'>";
            echo "<input type='hidden' name='book_id' value='" . $row['book_id'] . "'>";
            echo "<input class='delete-button' type='submit' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new mysqli("localhost", "root", "", "obs");
        if ($conn->connect_error) {
            die("Connection Error");
        }

        $book_id = $_POST['book_id'];

        // Perform the deletion query here
        $delete_sql = "DELETE FROM book_info WHERE book_id = $book_id";
        if ($conn->query($delete_sql) === TRUE) {
            echo "Book deleted successfully";
        } else {
            echo "Error deleting book: " . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>

</html>
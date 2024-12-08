<?php
include "../include/db_connection.php"; // Include your database connection file

// Handle deletion logic
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Determine the table and column names for deletion based on the type
    switch ($type) {
        case 'category':
            $table = 'categories';
            $column = 'category_id';
            break;
        case 'subcategory':
            $table = 'subcategories';
            $column = 'subcategory_name'; // Assuming subcategories are identified by name
            break;
        case 'subsubcategory':
            $table = 'subsubcategories';
            $column = 'subsubcategory_id';
            break;
        default:
            echo "Invalid type specified.";
            exit;
    }

    // Perform the deletion based on the provided ID and type
    $sql = "DELETE FROM $table WHERE $column = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Deletion successful
        header("Location: {$_SERVER['PHP_SELF']}"); // Redirect back to the same page
        exit;
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>



<?php
// Retrieve categories with their subcategories
$sql = "SELECT c.category_id, c.category_name, s.subcategory_id, s.subcategory_name
        FROM categories c
        LEFT JOIN subcategories s ON c.category_id = s.category_id";
$result = mysqli_query($conn, $sql);

// Organize the data into an array
$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categoryID = $row['category_id'];
    $subcategoryID = $row['subcategory_id'];
    $subcategoryName = $row['subcategory_name'];

    if (!isset($categories[$categoryID])) {
        $categories[$categoryID] = array(
            'category_name' => $row['category_name'],
            'subcategories' => array()
        );
    }

    if ($subcategoryID !== null) {
        $categories[$categoryID]['subcategories'][] = $subcategoryName;
    }
}

?>
<?php
// Include your database connection code here

// Retrieve sub-subcategories data from the database
$sql = "SELECT ss.subsubcategory_id, ss.subsubcategory_name, s.subcategory_id, s.category_id, c.category_name, sc.subcategory_name AS subcategory_name
        FROM subsubcategories ss
        INNER JOIN subcategories s ON ss.subcategory_id = s.subcategory_id
        INNER JOIN categories c ON s.category_id = c.category_id
        INNER JOIN subcategories sc ON ss.subcategory_id = sc.subcategory_id"; // Added this JOIN
$subsubcategories_result = mysqli_query($conn, $sql);

$subsubcategories_data = array();
while ($row = mysqli_fetch_assoc($subsubcategories_result)) {
    $categoryName = $row['category_name'];
    $subcategoryName = $row['subcategory_name'];
    $subsubcategoryID = $row['subsubcategory_id'];
    $subsubcategoryName = $row['subsubcategory_name'];

    if (!isset($subsubcategories_data[$categoryName][$subcategoryName])) {
        $subsubcategories_data[$categoryName][$subcategoryName] = array();
    }

    if ($subsubcategoryID !== null) {
        $subsubcategories_data[$categoryName][$subcategoryName][] = array(
            'subsubcategory_id' => $subsubcategoryID,
            'subsubcategory_name' => $subsubcategoryName
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(178, 34, 34, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* min-height: 100vh; */
        }

        h1 {
            background: linear-gradient(to right, #a8c0ff, #3f51b5);
            color: #fff;
            padding: 20px;
            margin: 0;
            text-align: center;
            width: 100%;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Delete button styles */
        .delete-button {
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            transition: background-color 0.3s ease;
            background-color: #f44336;
            color: #fff;
            margin-right: 5px;
        }

        .delete-button:hover {
            background-color: #d32f2f;
        }

        /* Navbar styles */
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

        /* Button styles */
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
            float: right;
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

        /* Add styles for page introduction */
        .page-introduction {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .page-introduction p {
            color: #666;
        }

        /* Add styles for the add button */
        .add-button {
            margin-top: 20px;
            /* Adjust the top margin as needed */
            margin-left: 20px;
            /* Align the button to the left side */
        }

        .add-button button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }


        .add-button button:hover {
            background-color: #45a049;
        }

        /* Center the text in the table cells */
        th,
        td {
            text-align: center;
        }

        /* Add hover effect to table rows */
        tr:hover {
            background-color: #f5f5f5;
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

    <h1>Manage Category</h1>
    <div class="page-introduction">
        <p>This system allows you to view and manage categories, subcategories, and sub-subcategories.</p>
    </div>
    <hr>

    <h2>Categories<button onclick="window.location.href = 'categories_Form.php';">Add</button></h2>

    <table>
        <tr>
            <th>Category Name</th>
        </tr>
        <?php
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        foreach ($result as $category) {
            $categoryId = $category['category_id'];
            $categoryName = $category['category_name'];

            echo "<tr>";
            echo "<td>";
            echo "<span class='display-data'>$categoryName</span>";
            echo "<form class='edit-form' style='display: none;' action='cat_update.php' method='POST'>";
            echo "<input type='hidden' name='action' value='edit'>";
            echo "<input type='hidden' name='categoryId' value='$categoryId'>";
            echo "<input type='text' name='newName' value='$categoryName'>";
            echo "<button type='submit'class=''>Save</button>";
            echo "</form>";
            echo "<button class='delete-button' onclick=\"confirmDelete('$categoryId', 'category')\">Delete</button>";
            echo "<button class='edit-button' onclick=\"toggleEditMode(this)\">Edit</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>






    <h2>Subcategories<button onclick="window.location.href = 'subcategories_Form.php';">Add</button></h2>

    <table>
        <tr>
            <?php
            foreach ($categories as $category) {
                if (!empty($category['subcategories'])) {
                    echo "<th>{$category['category_name']}</th>";
                }
            }
            ?>
        </tr>
        <?php
        $maxSubcategories = 0;
        $displayedCategories = array(); // Keep track of categories with subcategories

        foreach ($categories as $category) {
            $numSubcategories = count($category['subcategories']);
            if ($numSubcategories > $maxSubcategories) {
                $maxSubcategories = $numSubcategories;
            }

            if (!empty($category['subcategories'])) {
                $displayedCategories[] = $category;
            }
        }

        for ($i = 0; $i < $maxSubcategories; $i++) {
            echo "<tr>";

            foreach ($displayedCategories as $category) {
                $subcategoryName = $category['subcategories'][$i] ?? '';
                $subcategoryId = "{$category['category_name']}_{$subcategoryName}";

                echo "<td id='subcategoryName_{$subcategoryId}'>{$subcategoryName}";

                echo "<button class='delete-button' onclick=\"confirmDelete('{$subcategoryName}', 'subcategory')\">Delete</button>";
                echo "</td>";
            }

            echo "</tr>";
        }
        ?>
    </table>




    <h2>Subsubcategories<button onclick="window.location.href = 'subsubcategories_Form.php';">Add</button></h2>
    <table>
        <tr>
            <?php
            // Display header row with subsubcategory names as individual headings
            foreach ($subsubcategories_data as $categoryName => $subcategoryData) {
                foreach ($subcategoryData as $subcategoryName => $subsubcategories) {
                    echo "<th>{$subcategoryName}</th>";
                }
            }
            ?>
        </tr>
        <?php
        // Loop through each category's subcategories and display subsubcategories
        foreach ($subsubcategories_data as $categoryName => $subcategoryData) {
            $maxSubsubcategories = max(array_map(function ($subsubcategories) {
                return count($subsubcategories);
            }, $subcategoryData));

            for ($i = 0; $i < $maxSubsubcategories; $i++) {
                echo "<tr>";

                foreach ($subcategoryData as $subcategoryName => $subsubcategories) {
                    echo "<td>";
                    if (isset($subsubcategories[$i])) {
                        echo "<span id='subsubcategoryName_{$subsubcategories[$i]['subsubcategory_id']}'>{$subsubcategories[$i]['subsubcategory_name']}</span>";
                        echo "<button class='delete-button' onclick=\"confirmDelete('{$subsubcategories[$i]['subsubcategory_id']}', 'subsubcategory')\">Delete</button>";
                    } else {
                        echo "&nbsp;";
                    }
                    echo "</td>";
                }

                echo "</tr>";
            }
        }
        ?>
    </table>









    <script>
        function toggleEditMode(button, subcategoryId = null) {
            if (subcategoryId === null) {
                // For the main categories
                var row = button.parentNode.parentNode;
            } else {
                // For the subcategories
                var row = document.getElementById('subcategoryName_' + subcategoryId);
            }

            var displayData = row.querySelector('.display-data');
            var editForm = row.querySelector('.edit-form');

            if (displayData.style.display === 'none') {
                displayData.style.display = 'inline';
                editForm.style.display = 'none';
            } else {
                displayData.style.display = 'none';
                editForm.style.display = 'inline';
            }
        }




        function updateCategory(categoryId) {
            const newNameInput = document.getElementById(`categoryName_${categoryId}`);
            const newName = newNameInput.value;

            fetch('cat_update.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'updateCategory',
                        categoryId: categoryId,
                        categoryName: newName
                    })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Log the response from the server
                    // You can update the UI to show success or handle errors
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function confirmDelete(id, type) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = `<?php echo $_SERVER['PHP_SELF']; ?>?id=${id}&type=${type}`;
            }
        }
    </script>
</body>

</html>
<?php
// Assuming you have a database connection established
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'obs';

// Create a new database connection
$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve the selected category from the AJAX request
$selectedCategory = $_GET['category'];

// Prepare the subcategory select options
$subcategoriesOptions = "<option value=''>Select a subcategory</option>";

// Retrieve the subcategories based on the selected category
if (!empty($selectedCategory)) {
    $categoryQuery = "SELECT category_id FROM categories WHERE category_name = '$selectedCategory'";
    $categoryResult = mysqli_query($connection, $categoryQuery);

    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryId = $categoryRow['category_id'];

        $subcategoryQuery = "SELECT subcategory_name FROM subcategories WHERE category_id = $categoryId";
        $subcategoryResult = mysqli_query($connection, $subcategoryQuery);

        while ($row = mysqli_fetch_assoc($subcategoryResult)) {
            $subcategory = $row['subcategory_name'];
            $subcategoriesOptions .= "<option value='$subcategory'>$subcategory</option>";
        }
    }
}

// Return the subcategory options
echo $subcategoriesOptions;

// Close the database connection
mysqli_close($connection);
?>

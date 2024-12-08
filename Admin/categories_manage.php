<?php
// Assuming you have a database connection established
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'obs';

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create a new database connection
$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Add Category Form
if (isset($_POST['submitCategory'])) {
    $categoryName = mysqli_real_escape_string($connection, $_POST['categoryName']);
    $upperCategoryName = strtoupper($categoryName);

    // Check if the category already exists
    $checkCategoryQuery = "SELECT COUNT(*) as count FROM categories WHERE upper(category_name) = '$upperCategoryName'";
    $checkCategoryResult = mysqli_query($connection, $checkCategoryQuery);
    $checkCategoryRow = mysqli_fetch_assoc($checkCategoryResult);
    $categoryCount = $checkCategoryRow['count'];

    if ($categoryCount === '0') {
        // Insert the category into the database
        $insertCategoryQuery = "INSERT INTO categories (category_name) VALUES ('$upperCategoryName')";
        if (mysqli_query($connection, $insertCategoryQuery)) {
            header("Location:View_Categories.php");
        } else {
            echo "Error adding category: " . mysqli_error($connection);
        }
    } else {
        echo "Category already exists.";
    }
}

// Add Subcategory Form
if (isset($_POST['submitSubcategory'])) {
    $selectedCategory = $_POST['selectedCategory'];
    $subcategoryName = mysqli_real_escape_string($connection, $_POST['subcategoryName']);
    $upperSubcategoryName = strtoupper($subcategoryName);

    // Retrieve the category ID
    $categoryQuery = "SELECT category_id FROM categories WHERE upper(category_name) = UPPER('$selectedCategory')";
    $categoryResult = mysqli_query($connection, $categoryQuery);

    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryId = $categoryRow['category_id'];

        // Check if the subcategory already exists
        $checkSubcategoryQuery = "SELECT COUNT(*) as count FROM subcategories WHERE category_id = $categoryId AND UPPER(subcategory_name) = '$upperSubcategoryName'";
        $checkSubcategoryResult = mysqli_query($connection, $checkSubcategoryQuery);
        $checkSubcategoryRow = mysqli_fetch_assoc($checkSubcategoryResult);
        $subcategoryCount = $checkSubcategoryRow['count'];

        if ($subcategoryCount === '0') {
            // Insert the subcategory into the database
            $insertSubcategoryQuery = "INSERT INTO subcategories (category_id, subcategory_name) VALUES ($categoryId, '$upperSubcategoryName')";
            if (mysqli_query($connection, $insertSubcategoryQuery)) {
                header("Location:View_Categories.php");
            } else {
                echo "Error adding subcategory: " . mysqli_error($connection);
            }
        } else {
            echo "Subcategory already exists.";
        }
    } else {
        echo "Invalid category selected";
    }
}

// Add Sub-subcategory Form
if (isset($_POST['submitSubSubcategory'])) {
    $selectedCategory = $_POST['selectedCategory'];
    $selectedSubcategory = $_POST['selectedSubcategory'];
    $subsubcategoryName = mysqli_real_escape_string($connection, $_POST['subsubcategoryName']);
    $upperSubsubcategoryName = strtoupper($subsubcategoryName);

    // Retrieve the category ID
    $categoryQuery = "SELECT category_id FROM categories WHERE UPPER(category_name) = UPPER('$selectedCategory')";
    $categoryResult = mysqli_query($connection, $categoryQuery);

    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryId = $categoryRow['category_id'];

        // Retrieve the subcategory ID
        $subcategoryQuery = "SELECT subcategory_id FROM subcategories WHERE category_id = $categoryId AND UPPER(subcategory_name) = UPPER('$selectedSubcategory')";
        $subcategoryResult = mysqli_query($connection, $subcategoryQuery);

        if ($subcategoryResult && mysqli_num_rows($subcategoryResult) > 0) {
            $subcategoryRow = mysqli_fetch_assoc($subcategoryResult);
            $subcategoryId = $subcategoryRow['subcategory_id'];

            // Check if the sub-subcategory already exists
            $checkSubSubcategoryQuery = "SELECT COUNT(*) as count FROM subsubcategories WHERE subcategory_id = $subcategoryId AND UPPER(subsubcategory_name) = '$upperSubsubcategoryName'";
            $checkSubSubcategoryResult = mysqli_query($connection, $checkSubSubcategoryQuery);
            $checkSubSubcategoryRow = mysqli_fetch_assoc($checkSubSubcategoryResult);
            $subsubcategoryCount = $checkSubSubcategoryRow['count'];

            if ($subsubcategoryCount === '0') {
                // Insert the sub-subcategory into the database
                $insertSubSubcategoryQuery = "INSERT INTO subsubcategories (subcategory_id, subsubcategory_name) VALUES ($subcategoryId, '$upperSubsubcategoryName')";
                if (mysqli_query($connection, $insertSubSubcategoryQuery)) {
                    header("Location:View_Categories.php");
                } else {
                    echo "Error adding sub-subcategory: " . mysqli_error($connection);
                }
            } else {
                echo "Sub-subcategory already exists.";
            }
        } else {
            echo "Invalid subcategory selected";
        }
    } else {
        echo "Invalid category selected";
    }
}

// Close the database connection
mysqli_close($connection);
?>

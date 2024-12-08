<?php
include "../include/db_connection.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["categoryId"]) && isset($_POST["newName"])) {
        $categoryId = $_POST["categoryId"];
        $newName = $_POST["newName"];

        $sql = "UPDATE categories SET category_name = ? WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newName, $categoryId);
        if ($stmt->execute()) {
            echo "Category data saved successfully!";
        } else {
            echo "Error updating category data: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['subcategoryId']) && isset($_POST['subcategoryName'])) {
        $subcategoryId = $_POST['subcategoryId'];
        $newSubcategoryName = $_POST['subcategoryName'];

        $sql = "UPDATE subcategories SET subcategory_name = ? WHERE subcategory_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newSubcategoryName, $subcategoryId);
        if ($stmt->execute()) {
            echo "Subcategory data saved successfully!";
        } else {
            echo "Error updating subcategory data: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['subsubcategoryId']) && isset($_POST['subsubcategoryName'])) {
        $subsubcategoryId = $_POST['subsubcategoryId'];
        $newSubsubcategoryName = $_POST['subsubcategoryName'];

        $sql = "UPDATE subsubcategories SET subsubcategory_name = ? WHERE subsubcategory_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newSubsubcategoryName, $subsubcategoryId);
        if ($stmt->execute()) {
            echo "Subsubcategory data saved successfully!";
        } else {
            echo "Error updating subsubcategory data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid request.";
    }
}
?>

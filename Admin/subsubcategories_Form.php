<!DOCTYPE html>
<html>

<head>
    <title>Category Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .form-group button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        /* Adjustments for vertical layout */
        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <hr>

        <h2>Add Sub-subcategory</h2>
        <!-- Sub-subcategory form -->
        <form method="POST" action="categories_manage.php">
            <div class="form-group">
                <label for="categorySelect2">Select Category:</label>
                <select id="categorySelect2" name="selectedCategory">
                    <option value="">Select a category</option>
                    <?php
                    // Assuming you have a database connection established
                    $dbHost = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName = 'obs';

                    // Create a new database connection
                    $connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

                    // Retrieve categories from the database
                    $selectCategoriesQuery = "SELECT category_name FROM categories";
                    $categoriesResult = mysqli_query($connection, $selectCategoriesQuery);

                    // Generate options for the select element
                    while ($row = mysqli_fetch_assoc($categoriesResult)) {
                        $category = $row['category_name'];
                        echo "<option value='$category'>$category</option>";
                    }

                    // Close the database connection
                    mysqli_close($connection);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="subcategorySelect">Select Subcategory:</label>
                <select id="subcategorySelect" name="selectedSubcategory">
                    <option value="">Select a subcategory</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subsubcategoryName">Sub-subcategory:</label>
                <input type="text" id="subsubcategoryName" name="subsubcategoryName" placeholder="Enter sub-subcategory name">
                <button type="submit" name="submitSubSubcategory">Add Sub-subcategory</button>
            </div>
        </form>
    </div>

    <script>
        // Function to handle the category selection
        function handleCategorySelection() {
            // Get the selected category value
            var selectedCategory = document.getElementById("categorySelect2").value;

            // Make a Fetch request to retrieve the subcategories
            fetch("get_subcategories.php?category=" + selectedCategory)
                .then(function(response) {
                    return response.text();
                })
                .then(function(data) {
                    // Update the subcategory select element with the received data
                    var subcategorySelect = document.getElementById("subcategorySelect");
                    subcategorySelect.innerHTML = data;
                })
                .catch(function(error) {
                    console.log("Error:", error);
                });
        }

        // Attach the category selection event listener
        document.getElementById("categorySelect2").addEventListener("change", handleCategorySelection);
    </script>

</body>

</html>
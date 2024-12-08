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
            margin-top: 10%;
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
            text-align: center;
            justify-self: center;
        }

        .form-group label {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Category</h2>
        <!-- Category form -->
        <form method="POST" action="categories_manage.php">
            <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" placeholder="Enter category name">
                <br><button type="submit" name="submitCategory">Add Category</button>
            </div>
        </form>

        <hr>


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
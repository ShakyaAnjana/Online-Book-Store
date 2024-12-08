<?php
include "./include/db_connection.php";

// Check if user is logged in and retrieve their email
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $data = $_SESSION['email'];
} else {
    $data = '';
}

// Fetch categories from the database
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($conn, $categories_query);
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

// Fetch subcategories from the database
$subcategories_query = "SELECT * FROM subcategories";
$subcategories_result = mysqli_query($conn, $subcategories_query);
$subcategories = mysqli_fetch_all($subcategories_result, MYSQLI_ASSOC);

// Fetch subsubcategories from the database
$subsubcategories_query = "SELECT * FROM subsubcategories";
$subsubcategories_result = mysqli_query($conn, $subsubcategories_query);
$subsubcategories = mysqli_fetch_all($subsubcategories_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/catagories.css">
</head>

<body>
    <script>
        function toggleSubcategories(category) {
            var subcategoryList = category.nextElementSibling;

            if (subcategoryList && subcategoryList.tagName === 'UL') {
                subcategoryList.style.display = subcategoryList.style.display === 'none' ? 'block' : 'none';
            }

            var categoryId = category.getAttribute('data-category-id'); // Get category ID
            var categoryName = category.textContent.trim();
            window.location.href = window.location.pathname + '?category=' + encodeURIComponent(categoryId);
        }

        function filterBooksByCategory(categoryId) {
            window.location.href = window.location.pathname + '?category=' + encodeURIComponent(categoryId);
        }
    </script>

    <div class="whole">
        <div class="nab">
            <?php include "navbar.php" ?>
        </div>
        <div class="main">
            <div class="cat_list">
                <h2>Categories</h2>
                <ul>
                    <?php foreach ($categories as $category) : ?>
                        <li>
                            <a href="#" onclick="toggleSubcategories(this)" data-category-id="<?= $category['category_id'] ?>">
                                <?= $category['category_name'] ?>
                            </a>
                            <ul>
                                <?php foreach ($subcategories as $subcategory) : ?>
                                    <?php if ($subcategory['category_id'] == $category['category_id']) : ?>
                                        <li>
                                            <a href="#" onclick="filterBooksByCategory('<?= $subcategory['subcategory_id'] ?>')">
                                                <?= $subcategory['subcategory_name'] ?>
                                            </a>
                                            <ul>
                                                <?php foreach ($subsubcategories as $subsubcategory) : ?>
                                                    <?php if ($subsubcategory['subcategory_id'] == $subcategory['subcategory_id']) : ?>
                                                        <li><a href="#" onclick="filterBooksByCategory('<?= $subsubcategory['subsubcategory_id'] ?>')">
                                                                <?= $subsubcategory['subsubcategory_name'] ?>
                                                            </a></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="content">
                <div class="dis">
                    <?php
                    $category = isset($_GET['category']) ? $_GET['category'] : '';
                    $userEmail = $_SESSION['email'];

                    $sql = "SELECT * FROM book_info";

                    // Check if a category is selected
                    if (!empty($category)) {
                        $sql .= " WHERE (book_categories = '$category' OR book_subcategories = '$category' OR book_subsubcategories = '$category') AND owner_email <> '$userEmail'";
                    } else {
                        $sql .= " WHERE owner_email <> '$userEmail'";
                    }

                    $res = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($res) > 0) {
                        while ($book = mysqli_fetch_assoc($res)) {
                    ?>
                            <a href="book_detail.php?book_id=<?= $book['book_id'] ?>">
                                <h4>
                                    <div class="alb" style="cursor: pointer;">
                                        <img src="uploads/<?= $book['bookpic_path'] ?>">
                                        <span class="outline"><?= $book['book_name'] ?></span><br><br>
                                        <span class="outline"><?= $book['book_author'] ?></span><br><br>
                                        <span class="outline">PRICE: Rs. <?= $book['book_price'] ?></span>
                                    </div>
                                </h4>
                            </a>
                    <?php
                        }
                    } else {
                        echo "<p>No books found.</p>";
                    }
                    ?>
                </div>
            </div>

        </div>
        <hr>
        <div class="footer">
            <!-- Footer content here -->
        </div>
    </div>
</body>

</html>
<?php
include "./include/db_connection.php";

if (isset($_SESSION['book_id']) && !empty($_SESSION['book_id'])) {
    $book_id = $_SESSION['book_id'];
} else {
    $book_id = "";
}
// Check if a book ID is provided in the URL
if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Retrieve the book details from the database
    $sql = "SELECT * FROM book_info WHERE book_id = '$book_id'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        // Fetch the book details
        $book = mysqli_fetch_assoc($res);
        $book_isbn_value = $book['book_isbn'];
        $book_name_value = $book['book_name']; // Assign the value to a variable
        $book_author_value = $book['book_author'];
        $book_price_value = $book['book_price'];
        $book_publication_value = $book['book_publication'];
        $book_categories_value = $book['book_categories'];
        $book_subcategories_value = $book['book_subcategories'];
        $book_subsubcategories_value = $book['book_subsubcategories'];
        $book_pic_value = $book['book_pic'];
        $bookpic_path_value = $book['bookpic_path'];
    } else {
        // Book not found 
        $book = false;
    }
} else {
    // No book ID provided
    $book = false;
}
?>
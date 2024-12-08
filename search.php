<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./CSS/search.css">
</head>

<body>
  <div class="main">
    <div class="nab"><?php include "navbar.php"; ?></div>
    <div class="content">
      <div class="dis">
        <?php
        // Retrieve the search term from the query parameter
        $searchTerm = $_GET['searchTerm'];

        include "./include/db_connection.php";

        // Construct the SQL query
        $sql = "SELECT * FROM book_info WHERE book_name LIKE '%" . $searchTerm . "%' ";

        // Execute the query
        $res = $conn->query($sql);

        // Check if any results were found
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
          echo "No results found.";
        }

        // Close the database connection
        $conn->close();
        ?>
      </div>
    </div>
  </div>
</body>

</html>
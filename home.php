<?php include './include/db_connection.php' ?>
<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Document</title>
  <link rel="stylesheet" href="CSS\home.css">
</head>

<body>
  <div class="whole">
    <div class="nab">
      <?php include "navbar.php" ?>
    </div>
    <div class='main'>
      <div class='describe'>
        <!-- <h1>Pick Your Book. <br> Find a right choice here.</h1> -->
      </div>

      <h2 class="book_section">New Arrivals</h2>
      <div class="book-list">
        <?php
        include "./include/db_connection.php";
        $userEmail = $_SESSION['email'];

        $sql = "SELECT * FROM book_info WHERE owner_email <> '$userEmail' ORDER BY book_id DESC";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
          $count = 0; // Variable to keep track of the displayed books
          while ($book = mysqli_fetch_assoc($res)) {
            $count++;
            if ($count <= 6) { // Display only the first 6 books
        ?>
              <a href="book_detail.php?book_id=<?= $book['book_id'] ?>">
                <h4>
                  <div class="book-item" style="cursor: pointer;">
                    <img src="uploads/<?= $book['bookpic_path'] ?>">
                    <span class="outline"><?= $book['book_name'] ?></span><br><br>
                    <span class="outline"><?= $book['book_author'] ?></span><br><br>
                    <span class="outline">PRICE: Rs. <?= $book['book_price'] ?></span>
                  </div>
                </h4>
              </a>
        <?php
            }
          }
        }
        ?>
      </div>

      <h2 class="book_section">All Books</h2>
<div class="book-list">
  <?php
  include "./include/db_connection.php";
  $userEmail = $_SESSION['email'];

  $sql = "SELECT * FROM book_info WHERE owner_email <> '$userEmail'";
  $res = mysqli_query($conn, $sql);

  if (mysqli_num_rows($res) > 0) {
    $count = 0; // Variable to keep track of the displayed books
    while ($book = mysqli_fetch_assoc($res)) {
      $count++;
      if ($count <= 6) { // Display only the first 6 books
  ?>
        <a href="book_detail.php?book_id=<?= $book['book_id'] ?>">
          <h4>
            <div class="book-item" style="cursor: pointer;">
              <img src="uploads/<?= $book['bookpic_path'] ?>">
              <span class="outline"><?= $book['book_name'] ?></span><br><br>
              <span class="outline"><?= $book['book_author'] ?></span><br><br>
              <span class="outline">PRICE: Rs. <?= $book['book_price'] ?></span>
            </div>
          </h4>
        </a>
  <?php
      }
    }
  }
  ?>
</div>
      <button id="see-more-btn">--See More--</button>
      <hr>
      <div class="footer">
        <!-- Footer content here -->
      </div>
    </div>

  </div>

  <script>
    document.getElementById("see-more-btn").addEventListener("click", function() {
      window.location.href = "catagories.php";
    });
  </script>

</body>

</html>
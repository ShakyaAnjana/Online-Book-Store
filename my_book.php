<?php
include "./include/db_connection.php";
session_start();
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
    $book_name_value = $book['book_name'];
    $book_author_value = $book['book_author'];
    $book_price_value = $book['book_price'];
    $book_publication_value = $book['book_publication'];
    $book_condition_value = $book['book_condition'];
    $book_quantity_value = $book['book_quantity'];
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

// Retrieve categories from the database
$categoryQuery = "SELECT * FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

// Retrieve subcategories for each category
$subcategories = array();
foreach ($categories as $category) {
  $categoryId = $category['category_id'];
  $subcategoryQuery = "SELECT * FROM subcategories WHERE category_id = '$categoryId'";
  $subcategoryResult = mysqli_query($conn, $subcategoryQuery);
  $subcategories[$categoryId] = mysqli_fetch_all($subcategoryResult, MYSQLI_ASSOC);
}

// Retrieve sub-subcategories for each subcategory
$subsubcategories = array();
foreach ($subcategories as $categoryId => $categorySubcategories) {
  foreach ($categorySubcategories as $subcategory) {
    $subcategoryId = $subcategory['subcategory_id'];
    $subsubcategoryQuery = "SELECT * FROM subsubcategories WHERE subcategory_id = '$subcategoryId'";
    $subsubcategoryResult = mysqli_query($conn, $subsubcategoryQuery);
    $subsubcategories[$subcategoryId] = mysqli_fetch_all($subsubcategoryResult, MYSQLI_ASSOC);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Details</title>
  <link rel="stylesheet" href="./CSS/my_book.css">
  <style>
    .error {
      border-color: red;
    }

    .error-bubble {
      display: none;
      position: absolute;
      background-color: red;
      color: #fff;
      padding: 5px;
      border-radius: 4px;
      font-size: 12px;
      white-space: nowrap;
    }
  </style>
</head>

<body>
  <div class="overlay"></div>
  <div class="main" id="main">
    <div class="sellbutton">
      <div class="sell_btn">
        <button type="button" id="makeVisible">Update Book</button>
        <form action="./include/delete_book.php" method="GET" style="display:inline;">
          <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
          <input type="submit" name="delete" value="Delete Book" onclick="return confirmDelete();">
        </form>
      </div>
    </div>
    <div class="container">
      <?php if ($book) { ?>
        <div class="book-details">
          <div class="pic">
            <img src="uploads/<?= $book['bookpic_path'] ?>" alt="Book Cover">
          </div>
          <div class="des">
            <h1><?= $book['book_name'] ?></h1>
            <p>Author: <?= $book['book_author'] ?></p>
            <p>Price: Rs. <?= $book['book_price'] ?></p>
            <p>Publication: <?= $book['book_publication'] ?></p>
            <p>ISBN: <?= $book['book_isbn'] ?></p>
          </div>
        </div>
      <?php } else { ?>
        <p>Book not found.</p>
      <?php } ?>
    </div>
  </div>
  <div class="update_book hidden1" id="updateHere">
    <span id="cross" style="cursor: pointer;">X</span><br>

    <form action="./include/update_book.php" method="post" id="bookForm" enctype="multipart/form-data">
      <input type="hidden" name="book_id" value="<?= $book_id ?>">
      <label for="book_isbn">BOOK ISBN:</label><br>
      <input type="text" name="book_isbn" class="book_isbn" value="<?= $book_isbn_value ?>" placeholder="Book ISBN">
      <div class="error-bubble" id="isbnErrorBubble"></div><br><br>
      <label for="book_name">BOOK NAME:</label><br>
      <input type="text" name="book_name" class="book_name" value="<?= $book_name_value ?>" placeholder="Book Name">
      <div class="error-bubble" id="book_nameErrorBubble"></div><br><br>
      <label for="book_author">BOOK AUTHOR:</label><br>
      <input type="text" name="book_author" class="book_author" value="<?= $book_author_value ?>" placeholder="Book Author">
      <div class="error-bubble" id="book_authorErrorBubble"></div><br><br>
      <label for="book_price">BOOK PRICE:</label><br>
      <input type="text" name="book_price" class="book_price" value="<?= $book_price_value ?>" placeholder="Book Price">
      <div class="error-bubble" id="book_priceErrorBubble"></div><br><br>
      <label for="book_publication">BOOK PUBLICATION:</label><br>
      <input type="text" name="book_publication" class="book_publication" value="<?= $book_publication_value ?>" placeholder="Book Publication">
      <div class="error-bubble" id="book_publicationErrorBubble"></div><br><br>
      <div class="flex-container">
        <div class="flex-item">
          <label for="book_condition">Book Condition:</label>
          <select id="book_condition" name="book_condition">
            <option value="" disabled selected></option>
            <option value="used" <?= ($book_condition_value === 'used') ? 'selected' : '' ?>>Used</option>
            <option value="brand_new" <?= ($book_condition_value === 'brand_new') ? 'selected' : '' ?>>Brand New</option>
          </select>
          <div class="error-bubble" id="book_conditionErrorBubble"></div>
        </div>
        <div class="flex-item">
          <label for="book_quantity">Book Quantity:</label>
          <input type="number" name="book_quantity" class="book_quantity" placeholder="Book Quantity" value="1">
          <div class="error-bubble" id="book_quantityErrorBubble"></div>
        </div>
      </div> <br>

      <label for="book_categories">BOOK CATEGORIES:</label><br>
<select id="book_categories" name="book_categories" onchange="updateSubcategories()">
    <?php
    foreach ($categories as $category) {
        $selected = ($category['category_id'] == $book_categories_value) ? 'selected' : '';
        echo '<option value="' . $category['category_id'] . '" ' . $selected . '>' . $category['category_name'] . '</option>';
    }
    ?>
</select>
<select id="book_subcategories" name="book_subcategories" onchange="updateSubsubcategories()">
    <?php
    foreach ($subcategories[$book_categories_value] as $subcategory) {
        $selected = ($subcategory['subcategory_id'] == $book_subcategories_value) ? 'selected' : '';
        echo '<option value="' . $subcategory['subcategory_id'] . '" ' . $selected . '>' . $subcategory['subcategory_name'] . '</option>';
    }
    ?>
</select>
<select id="book_subsubcategories" name="book_subsubcategories">
    <?php
    foreach ($subsubcategories[$book_subcategories_value] as $subsubcategory) {
        $selected = ($subsubcategory['subsubcategory_id'] == $book_subsubcategories_value) ? 'selected' : '';
        echo '<option value="' . $subsubcategory['subsubcategory_id'] . '" ' . $selected . '>' . $subsubcategory['subsubcategory_name'] . '</option>';
    }
    ?>
</select>

      <div class="error-bubble" id="book_categoriesErrorBubble"></div><br><br>
      <label for="book_picture">BOOK PICTURE:</label><br>
      <input type="file" name="book_pic" placeholder="Book Picture">
      <div class="error-bubble" id="book_pictureErrorBubble"></div><br><br>
      <input type="submit" value="Update" name="update" class="update">
    </form>


  </div>



  <script>
    document.getElementById('makeVisible').addEventListener('click', function() {
      document.getElementById('updateHere').classList.remove('hidden1');
      document.getElementById('main').classList.add('hidden1');
      document.querySelector('.overlay').classList.add('show-overlay');
    });

    document.getElementById('cross').addEventListener('click', function() {
      document.getElementById('updateHere').classList.add('hidden1');
      document.getElementById('main').classList.remove('hidden1');
      document.querySelector('.overlay').classList.remove('show-overlay');
    });



    function updateSubcategories() {
      const categorySelect = document.getElementById('book_categories');
      const subcategorySelect = document.getElementById('book_subcategories');
      const subsubcategorySelect = document.getElementById('book_subsubcategories');

      // Clear previous options
      subcategorySelect.innerHTML = '<option value="">Sub categories</option>';
      subsubcategorySelect.innerHTML = '<option value="">Sub-sub categories</option>';

      // Retrieve selected category value
      const categoryId = categorySelect.value;

      if (categoryId !== '') {
        // Retrieve subcategories for the selected category
        const subcategories = <?php echo json_encode($subcategories) ?>;
        const categorySubcategories = subcategories[categoryId];

        // Create subcategory options
        for (let i = 0; i < categorySubcategories.length; i++) {
          const subcategoryOption = document.createElement('option');
          subcategoryOption.value = categorySubcategories[i].subcategory_id;
          subcategoryOption.innerText = categorySubcategories[i].subcategory_name;
          subcategorySelect.appendChild(subcategoryOption);
        }
      }
    }

    function updateSubsubcategories() {
      const subcategorySelect = document.getElementById('book_subcategories');
      const subsubcategorySelect = document.getElementById('book_subsubcategories');

      // Clear previous options
      subsubcategorySelect.innerHTML = '<option value="">Sub-sub categories</option>';

      // Retrieve selected subcategory value
      const subcategoryId = subcategorySelect.value;

      if (subcategoryId !== '') {
        // Retrieve sub-subcategories for the selected subcategory
        const subsubcategories = <?php echo json_encode($subsubcategories) ?>;
        const subcategorySubsubcategories = subsubcategories[subcategoryId];

        // Create sub-subcategory options
        for (let i = 0; i < subcategorySubsubcategories.length; i++) {
          const subsubcategoryOption = document.createElement('option');
          subsubcategoryOption.value = subcategorySubsubcategories[i].subsubcategory_id;
          subsubcategoryOption.innerText = subcategorySubsubcategories[i].subsubcategory_name;
          subsubcategorySelect.appendChild(subsubcategoryOption);
        }
      }
    }

    document.getElementById('book_subcategories').addEventListener('change', updateSubsubcategories);

    function confirmDelete() {
      return confirm("Are you sure you want to delete this book?");
    }
  </script>

  <script>
    const bookForm = document.querySelector('#bookForm');
    const isbnInput = document.querySelector('.book_isbn');
    const nameInput = document.querySelector('.book_name');
    const authorInput = document.querySelector('.book_author');
    const priceInput = document.querySelector('.book_price');
    const bookPublicationInput = document.querySelector('.book_publication');
    const conditionSelect = document.getElementById('book_condition');
    const bookQuantityInput = document.querySelector('.book_quantity');
    const bookPictureInput = document.querySelector('input[name="book_pic"]');

    const isbnErrorBubble = document.getElementById('isbnErrorBubble');
    const nameErrorBubble = document.getElementById('book_nameErrorBubble');
    const authorErrorBubble = document.getElementById('book_authorErrorBubble');
    const priceErrorBubble = document.getElementById('book_priceErrorBubble');
    const bookPublicationErrorBubble = document.getElementById('book_publicationErrorBubble');
    const conditionErrorBubble = document.getElementById('book_conditionErrorBubble');
    const bookQuantityErrorBubble = document.getElementById('book_quantityErrorBubble');
    const bookPictureErrorBubble = document.getElementById('book_pictureErrorBubble');


    bookForm.addEventListener('submit', function(event) {
      let hasError = false;

      if (!validateISBN()) {
        event.preventDefault();
        showBubbleError(isbnInput, isbnErrorBubble, 'ISBN is required and must be 9 digits');
        hasError = true;
      } else {
        hideBubbleError(isbnInput, isbnErrorBubble);
      }

      if (!validateBookName()) {
        event.preventDefault();
        showBubbleError(nameInput, nameErrorBubble, 'valid Book name is required.');
        hasError = true;
      } else {
        hideBubbleError(nameInput, nameErrorBubble);
      }

      if (!validateBookAuthor()) {
        event.preventDefault();
        showBubbleError(authorInput, authorErrorBubble, 'Valid Author name is required.');
        hasError = true;
      } else {
        hideBubbleError(authorInput, authorErrorBubble);
      }

      if (!validateBookPrice()) {
        event.preventDefault();
        showBubbleError(priceInput, priceErrorBubble, 'Valid price is required under 5000');
        hasError = true;
      } else {
        hideBubbleError(priceInput, priceErrorBubble);
      }

      if (!validateBookPublication()) {
        event.preventDefault();
        showBubbleError(bookPublicationInput, bookPublicationErrorBubble, 'Publication name must contain at least 8 characters and consist of letters.');
        hasError = true;
      } else {
        hideBubbleError(bookPublicationInput, bookPublicationErrorBubble);
      }

      if (!validateBookCondition()) {
        event.preventDefault();
        showBubbleError(conditionSelect, conditionErrorBubble, 'Please select a book condition.');
        hasError = true;
      } else {
        hideBubbleError(conditionSelect, conditionErrorBubble);
      }


      if (!validateBookQuantity()) {
        event.preventDefault();
        showBubbleError(bookQuantityInput, bookQuantityErrorBubble, 'Quantity must be at least 1.');
        hasError = true;
      } else {
        hideBubbleError(bookQuantityInput, bookQuantityErrorBubble);
      }

      if (hasError) {
        event.preventDefault();
      }
    });

    function validateISBN() {
      const isbn = isbnInput.value.trim();
      return /^\d{9}$/.test(isbn);
    }

    function validateBookPublication() {
  const bookPublication = bookPublicationInput.value.trim();
  // Check if the publication name contains at least 8 characters, letters, spaces, and special characters
  return /^(?=.*[A-Za-z\s\-',.]).{8,}$/i.test(bookPublication);
}

function validateBookPrice() {
  const bookPrice = parseFloat(priceInput.value.trim());
  return !isNaN(bookPrice) && bookPrice >= 0 && bookPrice <= 5000;
}


    function validateBookPublication() {
  const bookPublication = bookPublicationInput.value.trim();
  // Check if the publication name contains at least 8 characters, letters, spaces, and special characters
  return /^(?=.*[A-Za-z\s\-',.]).{8,}$/i.test(bookPublication);
}

    function validateBookCondition() {
      return conditionSelect.value !== '';
    }


    function validateBookQuantity() {
      const quantity = parseInt(bookQuantityInput.value, 10);
      if (isNaN(quantity) || quantity <= 0) {
        showBubbleError(bookQuantityInput, bookQuantityErrorBubble, 'Quantity must be a positive number.');
        return false;
      } else {
        hideBubbleError(bookQuantityInput, bookQuantityErrorBubble);
        return true;
      }
    }

    function showBubbleError(inputElement, errorBubbleElement, errorMessage) {
      inputElement.classList.add('error');
      errorBubbleElement.textContent = errorMessage;

      // Position the error bubble below the input field
      errorBubbleElement.style.display = 'block';
      errorBubbleElement.style.position = 'absolute';
      errorBubbleElement.style.top = inputElement.offsetTop + inputElement.offsetHeight + 'px';
      errorBubbleElement.style.left = inputElement.offsetLeft + 'px';
    }

    function hideBubbleError(inputElement, errorBubbleElement) {
      inputElement.classList.remove('error');
      errorBubbleElement.style.display = 'none';
    }
  </script>

</body>

</html>
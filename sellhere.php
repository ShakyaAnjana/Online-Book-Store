<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./CSS/sellhere.css">
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
  <?php
  include "navbar.php";

  // Database connection
  $conn = mysqli_connect("localhost", "root", "", "obs");

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $data = $_SESSION['email'];
  } else {
    $data = '';
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

  <div class="main" id="main">
    <div class="sellbutton">
      <div class="sell_btn">
        <button id="makeVisible">Sell Book</button>
      </div>
    </div>
    <div class="display">
      <div class="dis">
        <!-- Display user's uploaded books -->
        <?php
        // Retrieve the email of the specific user
        $userEmail = $_SESSION['email'];

        // Retrieve the book information uploaded by the user
        $sql = "SELECT bi.book_id, bi.book_name, bi.book_author, bi.book_price, bi.bookpic_path 
        FROM book_info bi
        JOIN user_info ui ON bi.owner_email = ui.email
        WHERE ui.email = '$userEmail'
        ORDER BY bi.owner_email DESC";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
          while ($book = mysqli_fetch_assoc($res)) {
        ?>
            <a href="my_book.php?book_id=<?= $book['book_id'] ?>">
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
        }
        ?>
      </div>
    </div>
  </div>
  <div class="sell_book hidden1" id="sellHere">
    <span id="cross" style="cursor: pointer;">X</span><br>
    <form action="./include/bookform.php" method="post" id="bookForm" enctype="multipart/form-data">
      <input type="hidden" name="book_id" value="">
      <label for="book_isbn">BOOK ISBN:</label><br>
      <input type="text" name="book_isbn" class="book_isbn" placeholder="Book ISBN">
      <div class="error-bubble" id="isbnErrorBubble"></div><br><br>
      <label for="book_name">BOOK NAME:</label><br>
      <input type="text" name="book_name" class="book_name" placeholder="Book Name">
      <div class="error-bubble" id="book_nameErrorBubble"></div><br><br>
      <label for="book_author">BOOK AUTHOR:</label><br>
      <input type="text" name="book_author" class="book_author" placeholder="Book Author">
      <div class="error-bubble" id="book_authorErrorBubble"></div><br><br>
      <label for="book_price">BOOK PRICE:</label><br>
      <input type="text" name="book_price" class="book_price" placeholder="Book Price">
      <div class="error-bubble" id="book_priceErrorBubble"></div><br><br>
      <label for="book_publication">BOOK PUBLICATION:</label><br>
      <input type="text" name="book_publication" class="book_publication" placeholder="Book Publication">
      <div class="error-bubble" id="book_publicationErrorBubble"></div><br><br>
      <div class="flex-container">
        <div class="flex-item">
          <label for="book_condition">Book Condition:</label>
          <select id="book_condition" name="book_condition">
            <option value="" disabled selected></option>
            <option value="used">Used</option>
            <option value="brand_new">Brand New</option>
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
        <option value="">Category</option>
        <?php
        foreach ($categories as $category) {
          echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
        }
        ?>
      </select>
      <select id="book_subcategories" name="book_subcategories">
        <option value="">Sub categories</option>
      </select>
      <select id="book_subsubcategories" name="book_subsubcategories">
        <option value="">Sub-sub categories</option>
      </select>
      <div class="error-bubble" id="book_categoriesErrorBubble"></div><br><br>
      <label for="book_picture">BOOK PICTURE:</label><br>
      <input type="file" name="book_pic" placeholder="Book Picture">
      <div class="error-bubble" id="book_pictureErrorBubble"></div><br><br>
      <input type="submit" value="add" name="add" class="add">
    </form>
  </div>
  <script>
    const makeVisible = document.getElementById('makeVisible');
    const sellHere = document.getElementById('sellHere');
    const cross = document.getElementById('cross');
    const overlay = document.createElement('div');

    makeVisible.addEventListener('click', function() {
      sellHere.classList.remove('hidden1');
      document.body.appendChild(overlay);
      overlay.classList.add('overlay');
    });

    cross.addEventListener('click', function() {
      sellHere.classList.add('hidden1');
      overlay.remove();
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
        showBubbleError(isbnInput, isbnErrorBubble, 'ISBN is required & must be 9 digits');
        hasError = true;
      } else {
        hideBubbleError(isbnInput, isbnErrorBubble);
      }

      if (!validateBookName()) {
        event.preventDefault();
        showBubbleError(nameInput, nameErrorBubble, 'Valid Book name is required.');
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
        showBubbleError(priceInput, priceErrorBubble, 'Valid price is required. under 5000');
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


      if (!validateBookPicture()) {
        event.preventDefault();
        hasError = true;
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

    function validateBookName() {
  const bookName = nameInput.value.trim();
  // Check if the book name contains letters, spaces, and special characters
  return /^[A-Za-z\s\-',.]+$/i.test(bookName);
}

function validateBookAuthor() {
  const bookAuthor = authorInput.value.trim();
  // Check if the author name contains letters, spaces, and special characters
  return /^[A-Za-z\s\-',.]+$/i.test(bookAuthor);
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

    function validateBookPicture() {
      const selectedFile = bookPictureInput.files[0];

      if (selectedFile === undefined) {
        showBubbleError(bookPictureInput, bookPictureErrorBubble, 'You must upload a book picture.');
        return false;
      } else {
        const allowedExtensions = ['.jpg', '.jpeg', '.png'];
        const fileExtension = selectedFile.name.split('.').pop().toLowerCase();

        if (allowedExtensions.includes('.' + fileExtension)) {
          hideBubbleError(bookPictureInput, bookPictureErrorBubble);
          return true;
        } else {
          showBubbleError(bookPictureInput, bookPictureErrorBubble, 'Invalid file format. Please upload a .jpg, .jpeg, or .png file.');
          return false;
        }
      }
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
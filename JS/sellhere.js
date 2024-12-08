
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
        const subcategories =  echo ($subcategories) 
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
        const subsubcategories =  echo ($subsubcategories) 
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








    // Validation

    const bookForm = document.querySelector('#bookForm');
const isbnInput = document.querySelector('.book_isbn');
const nameInput = document.querySelector('.book_name');
const authorInput = document.querySelector('.book_author');
const priceInput = document.querySelector('.book_price');
const conditionSelect = document.getElementById('book_condition');
const bookQuantityInput = document.querySelector('.book_quantity');
const bookPictureInput = document.querySelector('input[name="book_pic"]');

const isbnErrorBubble = document.getElementById('isbnErrorBubble');
const nameErrorBubble = document.getElementById('book_nameErrorBubble');
const authorErrorBubble = document.getElementById('book_authorErrorBubble');
const priceErrorBubble = document.getElementById('book_priceErrorBubble');
const conditionErrorBubble = document.getElementById('book_conditionErrorBubble');
const bookQuantityErrorBubble = document.getElementById('book_quantityErrorBubble');
const bookPictureErrorBubble = document.getElementById('book_pictureErrorBubble');

bookForm.addEventListener('submit', function (event) {
  let hasError = false;

  if (!validateISBN()) {
    event.preventDefault();
    showBubbleError(isbnInput, isbnErrorBubble, 'ISBN is required.');
    hasError = true;
  } else {
    hideBubbleError(isbnInput, isbnErrorBubble);
  }

  if (!validateBookName()) {
    event.preventDefault();
    showBubbleError(nameInput, nameErrorBubble, 'Book name is required.');
    hasError = true;
  } else {
    hideBubbleError(nameInput, nameErrorBubble);
  }

  if (!validateBookAuthor()) {
    event.preventDefault();
    showBubbleError(authorInput, authorErrorBubble, 'Author name is required.');
    hasError = true;
  } else {
    hideBubbleError(authorInput, authorErrorBubble);
  }

  if (!validateBookPrice()) {
    event.preventDefault();
    showBubbleError(priceInput, priceErrorBubble, 'Valid price is required.');
    hasError = true;
  } else {
    hideBubbleError(priceInput, priceErrorBubble);
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
  return isbn.length > 0;
}

function validateBookName() {
  const bookName = nameInput.value.trim();
  return bookName.length > 0;
}

function validateBookAuthor() {
  const bookAuthor = authorInput.value.trim();
  return bookAuthor.length > 0;
}

function validateBookPrice() {
  const bookPrice = priceInput.value.trim();
  return bookPrice.length > 0 && !isNaN(bookPrice);
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


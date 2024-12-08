document.addEventListener("DOMContentLoaded", function() {
  const bookListWrap = document.querySelector(".book-list-wrap");
  const backBtn = document.getElementById("backBtn");
  const nextBtn = document.getElementById("nextBtn");
  const bookItems = Array.from(document.querySelectorAll(".book-item"));

  let currentPosition = 0; // Variable to track the current position of the book list

  backBtn.addEventListener("click", function() {
    if (currentPosition > 0) {
      currentPosition--;
      bookListWrap.scrollLeft -= bookListWrap.offsetWidth; // Use scrollLeft property to scroll left
    }
  });

  nextBtn.addEventListener("click", function() {
    const maxPosition = Math.ceil(bookItems.length / 5) - 1;
    if (currentPosition < maxPosition) {
      currentPosition++;
      bookListWrap.scrollLeft += bookListWrap.offsetWidth; // Use scrollLeft property to scroll right
    }
  });
});

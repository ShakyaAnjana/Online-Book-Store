window.addEventListener('DOMContentLoaded', () => {
    const makeVisible = document.getElementById('makeVisible');
    const editpage = document.getElementById('editpage');
    const displaypage = document.getElementById('displaypage');
    const cross = document.getElementById('cross');
  
    makeVisible.addEventListener('click', function () {
      editpage.classList.remove('hidden');
      displaypage.classList.add('hidden');
    });
  
    cross.addEventListener('click', function () {
      editpage.classList.add('hidden');
      displaypage.classList.remove('hidden');
    });
  
    // Attach a click event listener to the delete button
    document.getElementById("deleteAccountBtn").addEventListener("click", function () {
      // Confirm if the user wants to delete the account
      if (confirm("Are you sure you want to delete your account? This action is irreversible.")) {
        // Send the fetch request to delete the account
        fetch("delete_account.php")
          .then(response => {
            if (response.ok) {
              // Request was successful, handle the response
              return response.text();
            } else {
              // Request encountered an error
              throw new Error("An error occurred while deleting the account.");
            }
          })
          .then(responseText => {
            alert(responseText);
            // Optionally, redirect to a different page after successful account deletion
            window.location.href = "deleted.html";
          })
          .catch(error => {
            alert(error.message);
          });
      }
    });
  });
  
 
const makeVisible = document.getElementById('makeVisible');
const signupPage = document.getElementById('signupPage');
const loginPage = document.getElementById('loginPage');
const cross = document.getElementById('cross');
makeVisible.addEventListener('click', function () {
    signupPage.classList.remove('hidden');
    loginPage.classList.add('hidden');
});
cross.addEventListener('click', function () {
    signupPage.classList.add('hidden');
    loginPage.classList.remove('hidden');
});

const signupForm = document.querySelector('#signupForm');
const fnameInput = document.querySelector('input[name="fname"]');
const lnameInput = document.querySelector('input[name="lname"]');
const phoneInput = document.querySelector('input[name="phone"]');
const addressInput = document.querySelector('input[name="address"]');
const emailInput = document.querySelector('input[name="email"]');
const passwordInput = document.querySelector('input[name="password"]');
const dobInput = document.querySelector('input[name="dob"]');

const fnameErrorBubble = document.getElementById('fnameErrorBubble');
const lnameErrorBubble = document.getElementById('lnameErrorBubble');
const phoneErrorBubble = document.getElementById('phoneErrorBubble');
const addressErrorBubble = document.getElementById('addressErrorBubble');
const emailErrorBubble = document.getElementById('emailErrorBubble');
const passwordErrorBubble = document.getElementById('passwordErrorBubble');
const dobErrorBubble = document.getElementById('dobErrorBubble');

signupForm.addEventListener('submit', function (event) {
    let hasError = false;

    if (!validateName()) {
        event.preventDefault();
        showBubbleError(fnameInput, fnameErrorBubble, 'First name must be more than 3 characters.');
        hasError = true;
    } else {
        hideBubbleError(fnameInput, fnameErrorBubble);
    }

    if (!validateLastName()) {
        event.preventDefault();
        showBubbleError(lnameInput, lnameErrorBubble, 'Last name is required.');
        hasError = true;
    } else {
        hideBubbleError(lnameInput, lnameErrorBubble);
    }

    if (!validatePhoneNumber()) {
        event.preventDefault();
        showBubbleError(phoneInput, phoneErrorBubble, 'Phone number must be 10 digits.');
        hasError = true;
    } else {
        hideBubbleError(phoneInput, phoneErrorBubble);
    }
    
    if (!validateAddress()) {
        event.preventDefault();
        showBubbleError(addressInput, addressErrorBubble, 'Address is required.');
        hasError = true;
    } else {
        hideBubbleError(addressInput, addressErrorBubble);
    }

    if (!validateEmail()) {
        event.preventDefault();
        showBubbleError(emailInput, emailErrorBubble, 'Please enter a valid email address.');
        hasError = true;
    } else {
        hideBubbleError(emailInput, emailErrorBubble);
    }

    if (!validatePassword()) {
        event.preventDefault();
        showBubbleError(passwordInput, passwordErrorBubble, 'Password must contain at least one special character, one numeric value, and one uppercase letter.');
        hasError = true;
    } else {
        hideBubbleError(passwordInput, passwordErrorBubble);
    }

    if (!validateBirthdate()) {
        event.preventDefault();
        // Adjust the error message as needed
        showBubbleError(dobInput, dobErrorBubble, 'You must be at least 10 years old.');
        hasError = true;
    } else {
        hideBubbleError(dobInput, dobErrorBubble);
    }

    if (hasError) {
        event.preventDefault();
    }
});

function validateName() {
    const firstName = fnameInput.value.trim();
    const containsDigits = /\d/.test(firstName); // Check if it contains digits
    return firstName.length >= 3 && !containsDigits;
}

function validateLastName() {
    const lastName = lnameInput.value.trim();
    const containsDigits = /\d/.test(lastName); // Check if it contains digits
    return lastName.length > 0 && !containsDigits;
}

function validatePhoneNumber() {
    const phone = phoneInput.value.trim();
    return /^\d{10}$/.test(phone);
}

function validateAddress() {
    const address = addressInput.value.trim();
    return address.length > 0;
}

function validateEmail() {
    const email = emailInput.value.trim();
    // A simple email validation regex
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validatePassword() {
    const password = passwordInput.value;
    // Password must contain at least one special character, one numeric value, and one uppercase letter
    const regex = /^(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?])(?=.*\d)(?=.*[A-Z]).*$/;
    return regex.test(password);
}

function validateBirthdate() {
    const dob = dobInput.value;
    const birthdate = new Date(dob);
    const currentDate = new Date();
    const minimumAge = 10; 
    const maximumAge = 100; // Maximum age is set to 100 years
    
    const age = currentDate.getFullYear() - birthdate.getFullYear();
    
    return age >= minimumAge && age <= maximumAge;
}

function showBubbleError(inputElement, errorBubbleElement, errorMessage) {
    inputElement.classList.add('error');
    errorBubbleElement.textContent = errorMessage;
    
    const inputRect = inputElement.getBoundingClientRect();
    const inputTop = inputRect.top + window.scrollY;
    const inputLeft = inputRect.left + window.scrollX;
    
    errorBubbleElement.style.display = 'block';
    errorBubbleElement.style.top = inputTop + inputElement.offsetHeight + 'px';
    errorBubbleElement.style.left = inputLeft + 'px';
}

function hideBubbleError(inputElement, errorBubbleElement) {
    inputElement.classList.remove('error');
    errorBubbleElement.style.display = 'none';
}

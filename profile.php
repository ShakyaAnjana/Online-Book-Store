<?php
SESSION_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $data = $_SESSION['email'];
} else {
    $data = '';
}
include "./include/db_connection.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="./CSS/profile.css">
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
    <div class="main" id="displaypage">
        <div class="left">
            <div class="back">
                <a href="home.php">
                    <span id="Back" style="cursor: pointer;">BACK</span>
                </a>
            </div>
            <hr>
            <div class="title" style="color: black;"><span id="Back" style="cursor: pointer;"> <a href="#editp" style=" text-decoration: none; color: white; "> Edit Profile </a></span></div>
            <hr>
            <div class="title" style="color: black;"><span id=" Back" style="cursor: pointer;"> <a href="#update" style=" text-decoration: none; color: white; "> Setting & Privacy</a></span></div>
            <hr>
            <div class="title" style="color: black;"><span id=" Back" style="cursor: pointer;">Help & Support</span></div>
            <hr>
        </div>

        <div class="right">
            <div class="name" id="editp">
                <div class="circle1"><img src="<?php
                                                $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        $row = mysqli_fetch_assoc($result);
                                                        if (isset($row['user_pic'])) {
                                                            $user_pic = $row['user_pic'];
                                                            $user_pic_path = "include/user_pictures/" . $user_pic; // Adjust the file path here
                                                            if (!empty($user_pic) && file_exists($user_pic_path)) {
                                                                echo $user_pic_path;
                                                            } else {
                                                                echo "./include/user_pictures/pi.png";
                                                            }
                                                        } else {
                                                            echo "./include/user_pictures/pi.png";
                                                        }
                                                    }
                                                }
                                                ?>" alt=""></div>
                <br>
                <?php
                $conn = new mysqli("localhost", "root", "", "obs");
                if ($conn->connect_error) {
                    die("Connection Error");
                }
                $conn = new mysqli("localhost", "root", "", "obs");
                if ($conn->connect_error) {
                    die("Connection Error");
                }
                $sql = "SELECT * FROM user_info WHERE email = '$data'";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $fname = $row['fname'];
                        $mname = $row['mname'];
                        $lname = $row['lname'];
                        echo '<h1>' . $fname . ' ' . $mname . ' ' . $lname . '</h1>';
                    }
                }
                ?>
            </div>
            <div class="phone">
                <h2> Phone Number : <?php
                                    $conn = new mysqli("localhost", "root", "", "obs");
                                    if ($conn->connect_error) {
                                        die("Connection Error");
                                    }
                                    $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                    if ($result = mysqli_query($conn, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $phone = $row['phone'];
                                            echo "$phone";
                                        }
                                    }
                                    ?>
                </h2>
            </div>
            <div class="dob">
                <h2> Date of Birth : <?php
                                        $conn = new mysqli("localhost", "root", "", "obs");
                                        if ($conn->connect_error) {
                                            die("Connection Error");
                                        }
                                        $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                        if ($result = mysqli_query($conn, $sql)) {
                                            if (mysqli_num_rows($result) > 0) {
                                                $row = mysqli_fetch_assoc($result);
                                                $dob = $row['dob'];
                                                echo "$dob";
                                            }
                                        }
                                        ?>
                </h2>
            </div>
            <div class="email">
                <h2> Email : <?php
                                $conn = new mysqli("localhost", "root", "", "obs");
                                if ($conn->connect_error) {
                                    die("Connection Error");
                                }
                                $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $email = $row['email'];
                                        echo "$email";
                                    }
                                }
                                ?>
                </h2>
            </div>
            <div class="gender">
                <h2> Gender : <?php
                                $conn = new mysqli("localhost", "root", "", "obs");
                                if ($conn->connect_error) {
                                    die("Connection Error");
                                }
                                $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $gender = $row['gender'];
                                        echo "$gender";
                                    }
                                }
                                ?>
                </h2>
            </div>
            <div class="gender">
                <h2> Address : <?php
                                $conn = new mysqli("localhost", "root", "", "obs");
                                if ($conn->connect_error) {
                                    die("Connection Error");
                                }
                                $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $address = $row['address'];
                                        echo "$address";
                                    }
                                }
                                ?>
                </h2>
            </div>
            <span id="makeVisible" style="cursor: pointer;">Edit</span> <br>
            <hr><br><br>
            <div class="pri" id="update">
                <form id="passwordChangeForm" action="update_mail_password.php" method="post">
                    <div class="c_password">
                        <h2> Change Password : <br><br>
                            <input type="password" name="op" id="oldPassword" value="" placeholder="Old Password">

                            <input type="password" name="np" id="newPassword" value="" placeholder="New Password">
                            <div class="error-bubble" id="newPasswordErrorBubble"></div>
                            <input type="password" name="cp" id="confirmPassword" value="" placeholder="Confirm Password">
                            <div class="error-bubble" id="confirmPasswordErrorBubble"></div>
                        </h2>
                    </div> <br>
                    <div class="edit_b" style="cursor: pointer">
                        <input type="submit" value="Update" name="update"> <br>
                    </div> <br><br>
                </form>
                <!-- <form id="emailChangeForm" action="update_mail_password.php" method="post">
    <div class="c_email">
        <h2> Change Email : <br><br>
            <input type="email" required name="old_email" id="oldEmail" value="" placeholder="Old Email">
            <input type="email" required name="new_email" id="newEmail" value="" placeholder="New Email">
            <input type="email" required name="confirm_email" id="confirmEmail" value="" placeholder="Confirm Email">
            <div class="error-bubble" id="confirmEmailErrorBubble"></div>
        </h2>
    </div> <br>
    <div class="edit_b" style="cursor: pointer">
        <input type="submit" value="Update" name="update_email"> <br>
    </div>
</form> -->

            </div>
            <hr><br><br>
            <div class="deleteAccount">
                <h1> Delete My Account : <a href="./include/delete_account.php">Delete</a> </h1>
            </div>
        </div>
    </div>
    <div class="container hidden" id="editpage">
        <div class="edit_f">

            <form action="./include/update.php" id="updateForm" method="post" enctype="multipart/form-data">
                <span id="cross" style="cursor: pointer;">X</span> <br>
                <div class="u_pic">
                    <img src="<?php
                                if (isset($row['user_pic'])) {
                                    $user_pic = $row['user_pic'];
                                    $user_pic_path = "include/user_pictures/" . $user_pic; // Adjust the file path here
                                    if (!empty($user_pic) && file_exists($user_pic_path)) {
                                        echo $user_pic_path;
                                    } else {
                                        echo "./include/user_pictures/pi.png";
                                    }
                                } else {
                                    echo "./include/user_pictures/pi.png";
                                }
                                ?>" alt="">
                </div>
                <input type="file" name="user_pic" class="pic_in"> <br><br>

                <div class="form-group">
                    <label for="fname,mname,lname"> Name:</label><br>
                    <input type="text" name="fname" id="fname" value="<?php echo $row['fname']; ?>" placeholder="First Name">
                    <div class="error-bubble" id="fnameErrorBubble"></div>

                    <input type="text" name="mname" id="mname" value="<?php echo $row['mname']; ?>" placeholder="Middle Name">

                    <input type="text" name="lname" id="lname" value="<?php echo $row['lname']; ?>" placeholder="Last Name">
                    <div class="error-bubble" id="lnameErrorBubble"></div>
                </div> <br>
                <div class="form-group">
                    <label for="phone">Phone:</label><br>
                    <input type="text" name="phone" id="phone" value="<?php echo $row['phone']; ?>" placeholder="Phone Number">
                    <div class="error-bubble" id="phoneErrorBubble"></div>
                </div><br>
                <div class="form-group">
                    <label for="dob">Birthday:</label><br>
                    <input type="date" name="dob" id="dob" value="<?php echo $row['dob']; ?>">
                    <div class="error-bubble" id="dobErrorBubble"></div>
                </div><br>
                <div class="form-group">
                    <label>Gender:</label><br>
                    <input type="radio" name="gender" id="gender" value="Male" <?php if ($row['gender'] == 'Male') echo 'checked'; ?>> Male
                    <input type="radio" name="gender" value="Female" <?php if ($row['gender'] == 'Female') echo 'checked'; ?>> Female
                    <input type="radio" name="gender" value="Other" <?php if ($row['gender'] == 'Other') echo 'checked'; ?>> Other

                </div><br>
                <div class="form-group">
                    <label for="address">Address:</label><br>
                    <input type="text" name="address" id="address" value="<?php echo $row['address']; ?>" placeholder="Address">
                    <div class="error-bubble" id="addressErrorBubble"></div>
                </div><br>
                <div class="edit_b" style="cursor: pointer">
                    <input type="submit" value="Update" name="update"> <br>
                </div>
            </form>
        </div>
    </div>

    <script src="./JS/profile.js"></script>
    <script>
        const signupForm = document.querySelector('#updateForm');
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

        signupForm.addEventListener('submit', function(event) {
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
            return firstName.length > 3;
        }

        function validateLastName() {
            const lastName = lnameInput.value.trim();
            return lastName.length > 0;
        }

        function validatePhoneNumber() {
            const phone = phoneInput.value.trim();
            return /^\d{10}$/.test(phone);
        }

        function validateAddress() {
            const address = addressInput.value.trim();
            return address.length > 0;
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
    </script>
    <script>
        const passwordChangeForm = document.querySelector('#passwordChangeForm');
        const newPasswordInput = document.querySelector('#newPassword');
        const confirmPasswordInput = document.querySelector('#confirmPassword');

        passwordChangeForm.addEventListener('submit', function(event) {
            let hasError = false;

            if (newPasswordInput.value !== confirmPasswordInput.value) {
                event.preventDefault();
                showErrorBubble(confirmPasswordInput, 'Confirm Password must match New Password.');
                hasError = true;
            } else {
                hideErrorBubble(confirmPasswordInput);
            }

            if (!validatePassword(newPasswordInput.value)) {
                event.preventDefault();
                showErrorBubble(newPasswordInput, 'Password must contain at least one special character, one numeric value, and one uppercase letter.');
                hasError = true;
            } else {
                hideErrorBubble(newPasswordInput);
            }

            if (hasError) {
                event.preventDefault();
            }
        });

        function validatePassword(password) {
            // Password must contain at least one special character, one numeric value, and one uppercase letter
            const regex = /^(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?])(?=.*\d)(?=.*[A-Z]).*$/;
            return regex.test(password);
        }

        function showErrorBubble(inputElement, errorMessage) {
            const errorBubble = inputElement.nextElementSibling;
            inputElement.classList.add('error');
            errorBubble.textContent = errorMessage;
            errorBubble.style.display = 'block';
        }

        function hideErrorBubble(inputElement) {
            const errorBubble = inputElement.nextElementSibling;
            inputElement.classList.remove('error');
            errorBubble.style.display = 'none';
        }
    </script>
    <script>
        const emailChangeForm = document.querySelector('#emailChangeForm');
        const newEmailInput = document.querySelector('#newEmail');
        const confirmEmailInput = document.querySelector('#confirmEmail');

        emailChangeForm.addEventListener('submit', function(event) {
            let hasError = false;

            if (newEmailInput.value !== confirmEmailInput.value) {
                event.preventDefault();
                showErrorBubble(confirmEmailInput, 'Confirm Email must match New Email.');
                hasError = true;
            } else {
                hideErrorBubble(confirmEmailInput);
            }

            if (!validateEmail(newEmailInput.value)) {
                event.preventDefault();
                showErrorBubble(newEmailInput, 'Invalid email format.');
                hasError = true;
            } else {
                hideErrorBubble(newEmailInput);
            }

            if (hasError) {
                event.preventDefault();
            }
        });

        function validateEmail(email) {
            // Use a regular expression for basic email format validation
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        function showErrorBubble(inputElement, errorMessage) {
            const errorBubble = inputElement.nextElementSibling;
            inputElement.classList.add('error');
            errorBubble.textContent = errorMessage;
            errorBubble.style.display = 'block';
        }

        function hideErrorBubble(inputElement) {
            const errorBubble = inputElement.nextElementSibling;
            inputElement.classList.remove('error');
            errorBubble.style.display = 'none';
        }
    </script>

</body>

</html>
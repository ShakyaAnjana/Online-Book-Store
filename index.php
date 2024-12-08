
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/index.css">
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
    <div class="whole">
        <div class="container hidden" id="signupPage">
            <div class="signup_f">
                <form action="./include/signup.php" method="post" id="signupForm">
                    <div>
                        <Div class="Lhead">
                            Sign up
                            <span id="cross" style="cursor: pointer;">X</span>
                        </Div> <br>
                        <div class="Lhead1">It's quick and easy</div>
                        <hr>
                        <br>
                        <div>Name: <br>
                            <input type="text" name="fname" id="fname" placeholder="First Name">
                            <div class="error-bubble" id="fnameErrorBubble"></div>
                            <input type="text" name="lname" id="lname" placeholder="Last Name">
                            <div class="error-bubble" id="lnameErrorBubble"></div>
                        </div> <br>
                        <div>
                            Phone No. <br>
                            <input type="text" name="phone" id="phone" placeholder="Phone Number">
                            <div class="error-bubble" id="phoneErrorBubble"></div>
                        </div> <br>
                        <div> Address: <br>
                            <input type="text" name="address" id="address" placeholder="Your Address">
                            <div class="error-bubble" id="addressErrorBubble"></div>
                        </div> <br>
                        <div> Email: <br>
                            <input type="email" name="email" id="email" placeholder="Your Email">
                            <div class="error-bubble" id="emailErrorBubble"></div>
                        </div> <br>
                        <div>Password: <br>
                            <input type="password" name="password" id="password" placeholder="Password">
                            <div class="error-bubble" id="passwordErrorBubble"></div>
                        </div> <br>
                        <div>Birthday: <br>
                            <input type="date" name="dob">
                            <div class="error-bubble" id="dobErrorBubble"></div>
                        </div><br><br>
                        <div class="signup_b" style="cursor: pointer">
                        <input type="submit" value="Sign Up" name="sign_up"> <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="Fl">
            <img src="./Photos/Fl.png" alt="">
        </div>
        <div class="l_s" id="loginPage">
            <div class="login">
                <div class="topic"> Log In </div>
                <hr>
                <form action="./include/login.php" method="post">
                    <br>
                    <img src="./Photos/mail.png" alt="">
                    <div class="log"><input type="email" name="email" id="Email" placeholder="Something@gmail.com">
                    </div> <br> <br>
                    <img src="./Photos/lock.png" alt="">
                    <div class="log"><input type="password" name="password" id="password" placeholder="Password"></div>
                    <br> <br> <br>
                    <div class="f_but"><input type="Submit" value="LOG IN" name="login"></div>
                </form>
                <hr>
            </div>

            <div class="S_but">
                <button id="makeVisible"> SIGN UP</button>
            </div>
        </div>


    </div>
    <script src="./JS/index.js"></script>
</body>

</html>
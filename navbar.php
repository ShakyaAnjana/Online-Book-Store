<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $data = $_SESSION['email'];
} else {
    $data = '';
}
include "./include/db_connection.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/navbar.css">
  
</head>

<body>
    <header>
        <div class="header">
            <div class="menusetting">
                <img src="./Photos/a.jpg" class="menu-icon" style="cursor: pointer" onclick="togglesmenu()">
                <div class="smenu-w " id="Wmenu">
                    <div class="smenu">
                        <a href="Home.php" class="menu-link">
                            <p>Home</p>
                            <span>></span>
                        </a>
                        <a href="catagories.php" class="menu-link">
                            <p>Catagories</p>
                            <span>></span>
                        </a>
                        <a href="sellhere.php" class="menu-link">
                            <p>Library</p>
                            <span>></span>
                        </a>
                        <div class="frm">
                            <form action="">
                                <input type="search" size="20" placeholder="Search...">
                                <button type="submit" class="icon1"><img src="./Photos/search.png"></button>
                        </div>
                        </form>
                        <br>
                        <hr>
                        <br>
                    </div>
                </div>
            </div>


            <div class="left">
                <img src="./Photos/logo.png" class="logo hidden">
            </div>
            <div class="left1"><img src="./Photos/Fl.png" class="fl "></div>
            <div class="mid">
                <nav class="navbar">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="catagories.php">Catagories</a></li>
                        <li><a href="sellhere.php">Sell Here</a></li>
                    </ul>
                </nav>
            </div>
            <div class="cart-icon">
                <a href="cart.php">
                    <img src="./Photos/add-to-cart.png">
                </a>
            </div>

            <div class="right">
                <form action="search.php">
                    <input type="search" size="20" name="searchTerm" placeholder="Search...">
                    <button type="submit" class="icon"><img src="./Photos/search.png" alt="" width="20px"></button>
                </form>
            </div>
            <div class="profileSetting">
                <div class="circle1"> <img src="<?php
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
                                                ?>" class="user-pic" style="cursor: pointer" onclick="toggleMenu()"></div>
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                            <div class="circle">
                                <img src="<?php
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
                                            ?>">
                            </div>

                            <h4><?php

                                $sql = "SELECT * FROM user_info WHERE email = '$data'";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $fname = $row['fname'];
                                        $mname = $row['mname'];
                                        $lname = $row['lname'];
                                        echo "$fname $mname $lname";
                                    }
                                }

                                ?></h4>
                        </div>
                        <hr>
                        <a href="profile.php" class="sub-menu-link">
                            <img src="./Photos/profile.png">
                            <p>Edit Profile</p>
                            <span>></span>
                        </a>
                        <a href="profile.php#update" class="sub-menu-link">
                            <img src="./Photos/setting.png">
                            <p>Setting & Privacy</p>
                            <span>></span>
                        </a>
                        <a href="profile.php" class="sub-menu-link">
                            <img src="./Photos/help.png">
                            <p>Help & Support</p>
                            <span>></span>
                        </a>
                        <a href="./include/logout.php" class="sub-menu-link">
                            <img src="./Photos/logout.png">
                            <p>Log-Out</p>
                            <span>></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
        let Wmenu = document.getElementById("Wmenu");

        function togglesmenu() {
            Wmenu.classList.toggle("open-m")
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <style>
        /* Styles for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            /* padding: 20px; */
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Updated justify-content property */
            align-items: center;
            min-height: 100vh; /* Updated height property */
            background-color: rgba(178, 34, 34, 0.1);

        }
        
        header {
            display: flex;
            justify-content: sp ace-between;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
            height: 10vh;
            background-color: #B22222; /* Set the background color of the navbar */
        }
        
        .logo {
            margin-left: 20px;
        }
        
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }
        
        .navbar a {
            text-decoration: none;
            margin: 20px;
            color: #fff; /* Set the color of the navbar links to white */
        }
        
        .logout {
            margin-right: 20px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        
        p {
            text-align: center;
            color: #777;
            margin-bottom: 20px;
        }
        
        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.3);
            transition: left 0.3s ease;
            z-index: -1;
        }
        
        button:hover::before {
            left: 100%;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <!-- Add your logo here -->
            <img src="../Photos/logo.png" alt="Logo">
        </div>
        <nav class="navbar">
            <a href="user.php">Manage Users</a>
            <a href="product.php">Manage Products</a>
            <a href="View_Categories.php">Manage Categories</a>
        </nav>
        <a href="logout.php" class="logout"><button>Logout</button></a>
    </header>
    <h1>Admin Control Panel</h1>
    <p>This page is exclusively for administrators to manage and update the website content. With the admin control panel, you have the power to:</p>
    <ul>
        <li>Add, edit, and remove user accounts</li>
        <li>Manage product listings and inventory</li>
        <li>Create and organize categories for easy navigation</li>
        <li>Access detailed analytics and reports</li>
        <li>Customize the website's design and settings</li>
    </ul>
    <p>Make use of the options below to effectively maintain and enhance your website:</p>
    <a href="user.php"><button>Manage Users</button></a>  <br>
    <a href="product.php"><button>Manage Products</button></a> <br>
    <a href="View_Categories.php"><button>Manage Categories</button></a> <br>
</body>
</html>

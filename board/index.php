<!-- index.php (Bulletin Board UI) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Bulletin Board</title>
</head>
<body>
    <h1>Welcome to the Bulletin Board</h1>

    <!-- Registration Form -->
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <hr>

    <!-- Login Form -->
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <hr>

    <!-- Display Posts -->
    <h2>Posts</h2>
    <?php include 'view_post.php'; ?>

    <!-- Add more HTML code for other functionalities such as creating posts, comments, editing posts, comments, and more. -->

</body>
</html>
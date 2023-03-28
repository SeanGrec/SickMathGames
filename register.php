<?php
require_once("./environment.php");
$username = "";
$password = "";
$username_error = "";
$password_error = "";

// Process form data during POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_error = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_error = "The username can only contain letters, numbers, and the underscore character.";
    }
    $username = trim($_POST["username"]);

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_error = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting in database
    if (empty($username_error) && empty($password_error)) {

        // Connecting to the database
        $connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);
        if (mysqli_connect_errno()) {
            die("There is an error connecting to the database.");
        }

        // Check if username exists first
        $query = "SELECT id, username, password from users where username = '$username'";
        $result = mysqli_query($connection, $query);
        if ($result->num_rows == 1) { // Username exists
            $username_error = "Username taken.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT into users(username, password) VALUES ('$username','$hashed_password')";
            $result = mysqli_query($connection, $query);


            $query = "SELECT id, username, password FROM users WHERE username = '$username'";
            $result = mysqli_query($connection, $query);
            $row = $result->fetch_row();
            $user_id = $row[0];

            $query = "INSERT into highscores(flappy_score, add_score, react_score, user_id) VALUES (0,0,1000, $user_id)";
            $result2 = mysqli_query($connection, $query);
            if (!$result || !$result2) {
                die("There is an error inserting into the database<br>" . $query);
            } else {
                // Redirect to login page (Successfully added data to database)
                header("location: login.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./styles/general.css">
    <link rel="stylesheet" href="./styles/site-header.css">
    <link rel="stylesheet" href="./styles/main-nav-container.css">
</head>

<body>
    <header class="site-header">
        <a class="site-logo" href="home.php">
            <div class="account_name">Signed in as: <?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? $_SESSION["username"] : 'Guest'; ?></div>
            <div class="site-name">
                <img src="images/math-icon.png">
                <p>SickMathGames.com</p>
            </div>
        </a>
    </header>
    <nav class="main-nav-container">
        <a href="javascript:history.back()" class="back-button"><img src="images/back-icon.png" width="60px"></a>
        <h1 class="main-nav-title">Register</h1>
        <span id="register-info">Complete the form to create your account.</span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <label>Username</label>
                <input type="text" name="username" <?php echo (!empty($username_error)) ? 'is-invalid' : ''; ?> value="<?php echo $username; ?>">
                <span><?php echo $username_error; ?></span>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?> value="<?php echo $password; ?>">
                <span><?php echo $password_error; ?></span>
            </div>
            <div>
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
        </form>
    </nav>
</body>

</html>
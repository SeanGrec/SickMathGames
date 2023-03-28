<?php
require_once("./environment.php");

// Start session
session_start();

// If user is logged in already, redirect to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: account.php");
    exit;
}

$username = "";
$password = "";
$username_error = "";
$password_error = "";
$login_errorU = "";
$login_errorP = "";

// Process form data during POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_error = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_error) && empty($password_error)) {
        $connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);  // Creates connection
        if (mysqli_connect_errno()) { // Checks connection
            die("There is an error connecting to the database.");
        }

        $query = "SELECT id, username, password FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if ($result->num_rows == 1) { // If username exists, then proceed to authentication
            $row = $result->fetch_row();
            $id = $row[0];
            $username = $row[1];
            $hashed_password = $row[2];

            if (password_verify($password, $hashed_password)) {
                // Password is verified, start session and set session vars
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                // Redirect user to welcome page
                header("location: account.php");
            } else {
                // Password is not valid, display a generic error message
                $login_errorP = "Invalid password.";
            }
        } else {
            $login_errorU = "Invalid username.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
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
        <h2 class="main-nav-title">Login</h2>
        <span id="login-info">Please fill in your credentials to login.</span>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback">
                    <?php echo $username_error;
                    if (!empty($login_errorU)) {
                        echo '<div class="alert alert-danger">' . $login_errorU . '</div>';
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback">
                    <?php echo $password_error;
                    if (!empty($login_errorP)) {
                        echo '<div class="alert alert-danger">' . $login_errorP . '</div>';
                    }
                    ?>
                </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <span id="no-account">Don't have an account? <a class="sign-up-link" href="register.php">Sign up now</a>.</span>
        </form>

    </nav>
</body>

</html>
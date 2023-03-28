<?php
require_once("./environment.php");

// Start session
session_start();
$flappy_score = "";
$add_score = "";
$react_score = "";

// If user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  $connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);  // Creates connection
  if (mysqli_connect_errno()) { // Checks connection
    die("There is an error connecting to the database.");
  }

  $query = "SELECT users.id, highscores.flappy_score, highscores.add_score, highscores.react_score 
    FROM users INNER JOIN highscores ON users.id = highscores.user_id WHERE users.username = '{$_SESSION["username"]}'";
  $result = mysqli_query($connection, $query);

  $row = $result->fetch_row();
  $flappy_score = $row[1];
  $add_score = $row[2];
  $react_score = $row[3];

  $_SESSION["flappy_score"] = $flappy_score;
  $_SESSION["add_score"] = $add_score;
  $_SESSION["react_score"] = $react_score;
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>SickMathGames</title>
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
    <a href="home.php" class="back-button"><img src="images/back-icon.png" width="60px"></a>
    <label class="main-nav-title">Account</label>
    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
      echo '<p class="account_details">Logged In ✓<br><br>Highscores<br>
        Flappy Bird: ' . $_SESSION["flappy_score"] . '<br> 
        Add Em Up!: ' . $_SESSION["add_score"] . '<br>
        React: ' . $_SESSION["react_score"] . 'ms</p>';
      echo '<br><a href="logout.php" class="main-nav-subtitle">Logout</a>';
    } else {
      echo '<a href="register.php" class="main-nav-subtitle">Register</a>';
      echo '<a href="login.php" class="main-nav-subtitle">Login</a>';
    }
    ?>
  </nav>
</body>

</html>
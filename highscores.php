<?php
require_once("./environment.php");

// Start session
session_start();

$connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);  // Creates connection
if (mysqli_connect_errno()) { // Checks connection
  die("There is an error connecting to the database.");
}

$query = "SELECT users.username, highscores.flappy_score FROM users INNER JOIN highscores ON 
users.id = highscores.user_id ORDER BY highscores.flappy_score DESC LIMIT 3;";
$result = mysqli_query($connection, $query);
$flappy_rows = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT users.username, highscores.add_score FROM users INNER JOIN highscores ON 
users.id = highscores.user_id ORDER BY highscores.add_score DESC LIMIT 3;";
$result = mysqli_query($connection, $query);
$add_rows = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT users.username, highscores.react_score FROM users INNER JOIN highscores ON 
users.id = highscores.user_id ORDER BY highscores.react_score ASC LIMIT 3;";
$result = mysqli_query($connection, $query);
$react_rows = $result->fetch_all(MYSQLI_ASSOC);

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
    <a href="javascript:history.back()" class="back-button"><img src="images/back-icon.png" width="60px"></a>
    <label class="main-nav-title">Highscores</label>
    <label class="main-nav-subtitle">Flappybird </label>
    <span>
      <?php foreach ($flappy_rows as $row) {
        echo $row["username"] . ': ' . $row["flappy_score"] . ' ';
      }
      ?>
    </span>
    <label class="main-nav-subtitle">Add Em Up! </label><span>
      <?php foreach ($add_rows as $row) {
        echo $row["username"] . ': ' . $row["add_score"] . ' ';
      }
      ?>
    </span>
    <label class="main-nav-subtitle">React </label><span>
      <?php foreach ($react_rows as $row) {
        echo $row["username"] . ': ' . $row["react_score"] . 'ms ';
      }
      ?>
    </span>
  </nav>
</body>

</html>
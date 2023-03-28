<?php
// Start session
session_start();
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
    <a href="games.php" class="main-nav-subtitle">Games</a>
    <a href="highscores.php" class="main-nav-subtitle">Highscores</a>
    <a href="howToPlay.php" class="main-nav-subtitle">How to play</a>
    <a href="options.php" class="main-nav-subtitle">Options</a>
    <a href="account.php" class="main-nav-subtitle">Account</a>
  </nav>
</body>

</html>
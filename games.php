<?php
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
    <a href="javascript:history.back()" class="back-button"><img src="images/back-icon.png" width="60px"></div>
      <a href="flappyBird.php" class="main-nav-subtitle">Flappybird</a>
      <a href="addEmUp.php" class="main-nav-subtitle">Add Em Up!</a>
      <a href="react.php" class="main-nav-subtitle">React</a>
  </nav>
</body>

</html>
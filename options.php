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
    <a href="javascript:history.back()" class="back-button"><img src="images/back-icon.png" width="60px"></a>
    <label class="main-nav-title">Options</label>
    <?php
    echo '<label class="main-nav-subtitle-nonreactive">Flappybird Mute?</label>';
    if (isset($_COOKIE["cookieName1"])) {
      echo '<input type="checkbox" id="checkbox1" name="mute" checked>';
    } else {
      echo '<input type="checkbox" id="checkbox1" name="mute">';
    }

    echo '<label class="main-nav-subtitle-nonreactive">Add Em Up! Mute?</label>';
    if (isset($_COOKIE["cookieName2"])) {
      echo '<input type="checkbox" id="checkbox2" name="mute" checked>';
    } else {
      echo '<input type="checkbox" id="checkbox2" name="mute">';
    }

    echo '<label class="main-nav-subtitle-nonreactive">React Mute?</label>';
    if (isset($_COOKIE["cookieName3"])) {
      echo '<input type="checkbox" id="checkbox3" name="mute" checked>';
    } else {
      echo '<input type="checkbox" id="checkbox3" name="mute">';
    }
    ?>
  </nav>
  <script src="./javascript/options.js"></script>
</body>

</html>
<?php
require_once("./environment.php");

// Start session
session_start();
$add_score = "";
$connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);  // Creates connection
if (mysqli_connect_errno()) { // Checks connection
  die("There is an error connecting to the database.");
}

// If user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  $query = "SELECT users.id, highscores.add_score FROM users INNER JOIN highscores ON 
    users.id=highscores.id WHERE users.username = '{$_SESSION["username"]}'";
  $result = mysqli_query($connection, $query);

  $row = $result->fetch_row();
  $add_score = $row[1];

  $_SESSION["add_score"] = $add_score;
}

$query = "SELECT users.username, highscores.add_score FROM users INNER JOIN highscores ON 
users.id = highscores.user_id ORDER BY highscores.add_score DESC LIMIT 5;";
$result = mysqli_query($connection, $query);
$add_rows = $result->fetch_all(MYSQLI_ASSOC);
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
  <link rel="stylesheet" href="./styles/sidebar-nav.css">
  <link rel="stylesheet" href="./styles/game-viewer.css">
  <link rel="stylesheet" href="./styles/add-gfx.css">
  <link rel="stylesheet" href="./styles/game-top-5.css">
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
  <div class="sidebar-nav">
    <div class="profile-btn"><a href="account.php"> <img src="./images/pfp-icon.png"></a></div>
    <div><a href="home.php"> <img src="./images/home-icon.png"></a></div>
    <div><a href="games.php"> <img src="./images/games-icon.jpg"></a></div>
    <div><a href="highscores.php"> <img src="./images/scores-icon.png"></a></div>
    <div><a href="howToPlay.php"> <img src="./images/question-icon.png"></a></div>
    <div><a href="options.php"> <img src="./images/options-icon.png"></a></div>
  </div>
  <div class="game-viewer">
    <div class="game-container">
      <div id="cur-score">Score: 0</div>
      <div id="game">
        <p id="question">Click any button</p>
        <button onclick="guess1()" type="button" id="option1" name="option1">option 1</button>
        <button onclick="guess2()" type="button" id="option2" name="option2">option 2</button>
        <button onclick="guess3()" type="button" id="option3" name="option3">option 3</button>
        <button onclick="guess4()" type="button" id="option4" name="option4">option 4</button>
      </div>
      <div id="player-highscore">Highscore: <?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? $_SESSION["add_score"] : '?'; ?></div>
    </div>
    <div class="games">
      <div class="flappyBird">
        <img class="game-thumbnail" src="./images/flappy-thumbnail.jpg">
        <div class="game-title"><a href="flappyBird.php"> Flappy Bird</a></div>
      </div>
      <div class="addEmUp">
        <img class="game-thumbnail" src="./images/add-thumbnail.jpg" style="width: 186px;height:auto">
        <div class="game-title"><a href="addEmUp.php"> Add Em Up!</a></div>
      </div>
      <div class="react">
        <img class="game-thumbnail" src="./images/react.jpg" style="width: 186px;height:186px">
        <div class="game-title"><a href="react.php"> React</a></div>
      </div>
    </div>
  </div>
  <div class="game-top-5">
    <div class="top-5-title">Highscores</div>
    <div class="top-5-scores">
      <?php 
        for ($i = 0; $i < count($add_rows); $i++) {
          echo('<div class="placement-icon"><img src="./images/' . strval($i+1) . '-icon.png"></div><div class="placement-info"><p class="player">' . $add_rows[$i]["username"] . '</p>' . '<p class="score">' . $add_rows[$i]["add_score"] . '</p></div>');
        }
      ?>
    </div>
  </div>
</body>
<script src="./javascript/addEmUp.js"></script>

</html>
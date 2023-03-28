<?php
require_once("./environment.php");

// Start session
session_start();
$flappy_score = "";

$connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);  // Creates connection
if (mysqli_connect_errno()) { // Checks connection
  die("There is an error connecting to the database.");
}

// If user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  $query = "SELECT users.id, highscores.flappy_score FROM users INNER JOIN highscores ON 
    users.id=highscores.id WHERE users.username = '{$_SESSION["username"]}'";
  $result = mysqli_query($connection, $query);

  $row = $result->fetch_row();
  $flappy_score = $row[1];

  $_SESSION["flappy_score"] = $flappy_score;
}

$query = "SELECT users.username, highscores.flappy_score FROM users INNER JOIN highscores ON 
users.id = highscores.user_id ORDER BY highscores.flappy_score DESC LIMIT 5;";
$result = mysqli_query($connection, $query);
$flappy_rows = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
}
?>
<!doctype html>
<html lang="en" onclick="jump()">

<head>
  <title>SickMathGames</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./styles/general.css">
  <link rel="stylesheet" href="./styles/site-header.css">
  <link rel="stylesheet" href="./styles/sidebar-nav.css">
  <link rel="stylesheet" href="./styles/game-viewer.css">
  <link rel="stylesheet" href="./styles/bird-gfx.css">
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
  <nav class="sidebar-nav">
    <div class="profile-btn"><a href="account.php"> <img src="./images/pfp-icon.png"></a></div>
    <div><a href="home.php"> <img src="./images/home-icon.png"></a></div>
    <div><a href="games.php"> <img src="./images/games-icon.jpg"></a></div>
    <div><a href="highscores.php"> <img src="./images/scores-icon.png"></a></div>
    <div><a href="howToPlay.php"> <img src="./images/question-icon.png"></a></div>
    <div><a href="options.php"> <img src="./images/options-icon.png"></a></div>
  </nav>
  <div class="game-viewer">
    <div class="game-container">
      <div id="cur-score"></div>
      <div id="game">
        <img src="images/flappy-logo.png" id="flappy-logo"></img>
        <img src="images/pipes.png" id="pipes1" class="pipes"></img>
        <img src="images/pipes.png" id="pipes2" class="pipes"></img>
        <img src="images/pipes.png" id="pipes3" class="pipes"></img>
        <img src="images/pipes.png" id="pipes4" class="pipes"></img>
        <img src="images/bird-character.png" id="character"></img>
      </div>
      <div id="player-highscore">Highscore: <?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? $_SESSION["flappy_score"] : '?'; ?></div>
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
        for ($i = 0; $i < count($flappy_rows); $i++) {
          echo('<div class="placement-icon"><img src="./images/' . strval($i+1) . '-icon.png"></div><div class="placement-info"><p class="player">' . $flappy_rows[$i]["username"] . '</p>' . '<p class="score">' . $flappy_rows[$i]["flappy_score"] . '</p></div>');
        }
      ?>
    </div>
  </div>
</body>
<script src="./javascript/flappyScript.js"></script>

</html>

<?php  // for setting new highscore NOT WORKING 
/*
      if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $doc = new DomDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTMLFile("flappyBird.php");
        libxml_clear_errors();
        $score = $doc->getElementById("cur-score");
        if ($score->textContent > $_SESSION["flappy_score"]) {
          $query = "UPDATE highscores SET flappy_score = $score->textContent WHERE id = '1'"; // {$_SESSION["id"]} fix hardcoded 1
        }
      }
      */
?>
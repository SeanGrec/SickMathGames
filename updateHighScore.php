<?php 
require_once("./environment.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // var_dump($_SERVER["QUERY_STRING"]);
    $_POST = json_decode(file_get_contents("php://input"), true);
    // Check if score key is sent in post request, and if user is logged in
    if (isset($_POST["score"]) && isset($_POST["game"]) && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        // Get user's high score
        $connection = mysqli_connect($_ENV["hostname"], $_ENV["db_user"], $_ENV["db_pass"], $_ENV["db_name"]);  // Creates connection
        $query = "SELECT users.id, highscores.flappy_score, highscores.add_score, highscores.react_score FROM users INNER JOIN highscores ON 
            users.id=highscores.user_id WHERE users.username = '{$_SESSION["username"]}'";
        $result = mysqli_query($connection, $query);
        $row = $result->fetch_row();        
        $user_id = $row[0];
        $flappy_score = $row[1];
        $add_score = $row[2];
        $react_score = $row[3];

        // Compare if new score is higher than high score for each game
        // UPDATE highscore if the new score is higher
        if ($_POST["game"] == "flappy" && $_POST["score"] > $flappy_score) {
            $query = "UPDATE highscores 
                        SET flappy_score = {$_POST["score"]}
                        WHERE highscores.user_id = '{$_SESSION["id"]}'";
            $result = mysqli_query($connection, $query);
        } else if ($_POST["game"] == "add" && $_POST["score"] > $add_score) {
            $query = "UPDATE highscores
                        SET add_score = {$_POST["score"]}
                        WHERE highscores.user_id = '{$_SESSION["id"]}'";
            $result = mysqli_query($connection, $query);
        } else if ($_POST["game"] == "react" && $_POST["score"] < $react_score) {
            $query = "UPDATE highscores 
                        SET react_score = {$_POST["score"]}
                        WHERE highscores.user_id = '{$_SESSION["id"]}'";
            $result = mysqli_query($connection, $query);
        }
    }
}

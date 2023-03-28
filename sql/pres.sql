-- cd C:\Users\shawn\Desktop\CP476\Apache\Apache24\htdocs
-- mysql -u root -p
-- USE cp476
-- @BLOCK
SELECT *
FROM users;
-- @BLOCK
SELECT *
FROM highscores;
-- @BLOCK -- top 5 flappy bird scores    flappyBird.php
SELECT users.username,
    highscores.flappy_score
FROM users
    INNER JOIN highscores ON users.id = highscores.user_id
ORDER BY highscores.flappy_score DESC
LIMIT 5;
-- @BLOCK -- top 3 add em up scores    highscores.php
SELECT users.username,
    highscores.add_score
FROM users
    INNER JOIN highscores ON users.id = highscores.user_id
ORDER BY highscores.add_score DESC
LIMIT 3;
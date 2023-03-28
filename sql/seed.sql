-- @BLOCK
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- @BLOCK
CREATE TABLE highscores (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    flappy_score INT(255) NOT NULL,
    add_score INT(255) NOT NULL,
    react_score INT(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
-- @BLOCK
DROP TABLE users;
-- @BLOCK
DROP TABLE highscores;
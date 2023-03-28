var button = document.getElementById("start");
var scoreDisplay = document.getElementById("cur-score");
var highDisplay = document.getElementById("player-highscore");
var themeSong = new Audio("../audio/super_meat_boy_theme.mp3");
var reactTime = 0;

themeSong.volume = 0.2;
if(getCookie("cookieName3") != null){ //option mute is checked
    themeSong.volume = 0;
}
themeSong.play();
setInterval(function(){ 
    themeSong.play(); 
}, 1000);

window.addEventListener('load', (event) => {
    button.style.backgroundColor = "grey";
});

button.addEventListener("click", () => {
    if(button.style.backgroundColor == "grey"){
        button.innerHTML = "...";
        button.style.backgroundColor = "red";
        var rand = Math.floor((Math.random() + 0.2) * 1000);
        setTimeout(function () {
            button.innerHTML = "CLICK!";
            button.style.backgroundColor = "green";
        }, rand);
    }
    if(button.style.backgroundColor == "green"){
        button.innerHTML = "Start";
        button.style.backgroundColor = "grey";
        scoreDisplay.innerHTML = "Score: " + reactTime + "ms";
        updateHighscore(reactTime, "react");
        if(highDisplay.innerHTML.substring(11) != '?' && parseInt(highDisplay.innerHTML.substring(11)) > reactTime){
            highDisplay.innerHTML = "Highscore: " + reactTime + "ms";
        }
    }
});
setInterval(function(){ //runs every 10ms
    if(button.style.backgroundColor == "green"){
        reactTime += 10;
    }
    if(button.style.backgroundColor == "red"){
        reactTime = 0;
        scoreDisplay.innerHTML = "Score: " + reactTime + "ms";
    }
},10);


function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }else{
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }

    return decodeURI(dc.substring(begin + prefix.length, end));
}

function updateHighscore(current_score, game){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/updateHighScore.php", true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({
        "score": current_score,
        "game": game
    }));
}
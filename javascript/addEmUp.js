var option1 = document.getElementById("option1");
var option2 = document.getElementById("option2");
var option3 = document.getElementById("option3");
var option4 = document.getElementById("option4");
var question = document.getElementById("question");
var scoreDisplay = document.getElementById("cur-score");
var highDisplay = document.getElementById("player-highscore");
var themeSong = new Audio("../audio/MKWii_theme.mp3");
var plusMinus = ["+","-"];
var curAnswer = 0;
var score = 0;

themeSong.volume = 0.2;
if(getCookie("cookieName2") != null){ //option mute is checked
    themeSong.volume = 0;
}
themeSong.play();
setInterval(function(){ 
    themeSong.play(); 
}, 38000);


setInterval(function(){ //runs every 10ms
    scoreDisplay.innerHTML = "Score: " + score; // current score
},10);

function guess1(){
    if(option1.innerHTML == curAnswer){ score++; }else{ 
        updateHighscore(score, "add");
        if(highDisplay.innerHTML.substring(11) != '?' && parseInt(highDisplay.innerHTML.substring(11)) < score){
            highDisplay.innerHTML = "Highscore: " + score;
        }
        score = 0; 
    } //add highscore tracking to else
    newQ();
    newAnswers();
}
function guess2(){
    if(option2.innerHTML == curAnswer){ score++; }else{ 
        updateHighscore(score, "add");
        if(highDisplay.innerHTML.substring(11) != '?' && parseInt(highDisplay.innerHTML.substring(11)) < score){
            highDisplay.innerHTML = "Highscore: " + score;
        }
        score = 0; 
    }
    newQ();
    newAnswers();
}
function guess3(){
    if(option3.innerHTML == curAnswer){ score++; }else{ 
        updateHighscore(score, "add");
        if(highDisplay.innerHTML.substring(11) != '?' && parseInt(highDisplay.innerHTML.substring(11)) < score){
            highDisplay.innerHTML = "Highscore: " + score;
        }
        score = 0; 
    }
    newQ();
    newAnswers();
}
function guess4(){
    if(option4.innerHTML == curAnswer){ score++; }else{ 
        updateHighscore(score, "add");
        if(highDisplay.innerHTML.substring(11) != '?' && parseInt(highDisplay.innerHTML.substring(11)) < score){
            highDisplay.innerHTML = "Highscore: " + score;
        }
        score = 0; 
    }
    newQ();
    newAnswers();
}

function newQ(){
    var num1 = Math.floor(Math.random()*10);
    var num2 = Math.floor(Math.random()*10);
    var oneOrZero = (Math.random()>0.5)? 1 : 0;

    if(oneOrZero == 0){
        curAnswer = num1 + num2;
    }else{
        curAnswer = num1 - num2;
    }
    question.innerHTML = num1 + " " + plusMinus[oneOrZero] + " " + num2 + " = ?";
}

function newAnswers(){
    var num1 = Math.floor(Math.random()*10);
    var num2 = Math.floor(Math.random()*10);
    var oneOrZero = (Math.random()>0.5)? 1 : 0;
    if(oneOrZero == 0){
        option1.innerHTML = num1 + num2;
    }else{
        option1.innerHTML = num1 - num2;
    }

    num1 = Math.floor(Math.random()*10);
    num2 = Math.floor(Math.random()*10);
    oneOrZero = (Math.random()>0.5)? 1 : 0;
    if(oneOrZero == 0){
        option2.innerHTML = num1 + num2;
    }else{
        option2.innerHTML = num1 - num2;
    }

    num1 = Math.floor(Math.random()*10);
    num2 = Math.floor(Math.random()*10);
    oneOrZero = (Math.random()>0.5)? 1 : 0;
    if(oneOrZero == 0){
        option3.innerHTML = num1 + num2;
    }else{
        option3.innerHTML = num1 - num2;
    }

    num1 = Math.floor(Math.random()*10);
    num2 = Math.floor(Math.random()*10);
    oneOrZero = (Math.random()>0.5)? 1 : 0;
    if(oneOrZero == 0){
        option4.innerHTML = num1 + num2;
    }else{
        option4.innerHTML = num1 - num2;
    }
    var randButton = Math.floor(Math.random() * 4);
    if(randButton == 0){
        option1.innerHTML = curAnswer
    }else if(randButton == 1){
        option2.innerHTML = curAnswer
    }else if(randButton == 2){
        option3.innerHTML = curAnswer
    }else{
        option4.innerHTML = curAnswer
    }
}

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
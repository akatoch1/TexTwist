var placeholders;
var lettersEntered = [];
var entries;
var count = 0;
let temp;
var score = 0;



function keyupHandler(event) {
  if (count == 1) {
  var letter = event.which || event.keyCode;
  var letters = document.querySelectorAll(".letter");
  for (var i = 0; i < placeholders.length; i++) {
    if ((placeholders[i] == String.fromCharCode(letter)) && (lettersEntered.length < 7)) {
      lettersEntered.push(String.fromCharCode(letter));
      placeholders.splice(i, 1);
      break;
    }
  }
  for (var i = 0; i < lettersEntered.length; i++) {
    letters[i].innerText = lettersEntered[i];
  }
}
  
}

document.addEventListener(
    "keyup",
    keyupHandler
)

function newLetters() {
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      if (this.status == 200) {
        var newRack = JSON.parse(this.response);
        placeholders = newRack["rack"].split('');
        var entries = document.querySelectorAll(".rack");
        for (var i = 0; i < placeholders.length; i++) {
          entries[i].innerText = placeholders[i];
        }
        temp = newRack["rack"].split('');
        count = 1;
        var letters = document.querySelectorAll(".letter");
        for (var i = 0; i < letters.length; i++) {
          letters[i].innerText = "_";
        }
        lettersEntered.length = 0;
      }
    };
    xhttp.open("GET", "backend.php");
    xhttp.send();
    
}

function twist() {
  for (var i = 0; i < placeholders.length; i++) {
    var randomIndex = Math.floor(Math.random() * i);
    [placeholders[i], placeholders[randomIndex]] = [placeholders[randomIndex], placeholders[i]];
  }
  var entries = document.querySelectorAll(".rack");
  for (var i = 0; i < placeholders.length; i++) {
    entries[i].innerText = placeholders[i];
  }
}



function clearGuess() {
  var letters = document.querySelectorAll(".letter");
  for (var i = 0; i < letters.length; i++) {
    letters[i].innerText = "_";
  
  }
  lettersEntered.length = 0;
  for (var i = 0; i < temp.length; i++) {
    placeholders[i] = temp[i];
  }
  
}

function enter() {
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "backend.php");
  var send = lettersEntered.join('');
    xhttp.onload = function() {
      if (this.status == 200) {
        console.log(JSON.parse(this.response));
        var valid = JSON.parse(this.response);
        if (valid["answer"]) {
          score += 10;
        }
        score = document.querySelector("#score");
      }
    };
    xhttp.send(send);
}

/*function newLetters1() {
  entries = document.querySelectorAll(".rack");
  for (var i = 0; i < placeholders.length; i++) {
    entries[i].innerText = placeholders[i];
  }
  count = 1;
}*/


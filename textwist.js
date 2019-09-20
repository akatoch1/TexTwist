var placeholders;
var lettersEntered = [];
var entries;
var count = 0;
var temp;


function keyupHandler(event) {
  if (count == 1) {
  var letter = event.which || event.keyCode;
  var letters = document.querySelectorAll(".letter");
  for (var i = 0; i < placeholders.length; i++) {
    if ((placeholders[i] == String.fromCharCode(letter)) && (lettersEntered.length < 7)) {
      lettersEntered.push(letter);
      placeholders.splice(i, 1);
    }
  }
  for (var i = 0; i < lettersEntered.length; i++) {
    letters[i].innerText = String.fromCharCode(lettersEntered[i]);
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
        temp = placeholders;
        entries = document.querySelectorAll(".rack");
        for (var i = 0; i < placeholders.length; i++) {
          entries[i].innerText = placeholders[i];
        }
        count = 1;
      }
    };
    xhttp.open("GET", "backend.php");
    xhttp.send();
    
}

function clearGuess() {
  var letters = document.querySelectorAll(".letter");
  for (var i = 0; i < letters.length; i++) {
    letters[i].innerText = "_";
  
  }
  lettersEntered.length = 0;
  placeholders = temp;
}

/*function newLetters1() {
  entries = document.querySelectorAll(".rack");
  for (var i = 0; i < placeholders.length; i++) {
    entries[i].innerText = placeholders[i];
  }
  count = 1;
}*/


// initialize speech recognition variables
var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList
var SpeechRecognitionEvent =
  SpeechRecognitionEvent || webkitSpeechRecognitionEvent
var directions = ['izquierda', 'derecha', 'parar', 'recto', 'atras']
var grammar =
  '#JSGF V1.0; grammar directions; public <direction> = ' +
  directions.join(' | ') +
  ' ;'

var recognition = new SpeechRecognition()
var speechRecognitionList = new SpeechGrammarList()
speechRecognitionList.addFromString(grammar, 1)
recognition.grammars = speechRecognitionList
recognition.continuous = false
recognition.lang = 'es-US'
recognition.interimResults = false
recognition.maxAlternatives = 1
let obtainedWord = ''

// send arduino order json to server : {order : String comand}
function enviarOrden (comand) {
  let data = {
    order: comand
  }
  fetch(
    'http://localhost/GamesForKids/ProyectoFinal/Model/carGame/carController.php',
    {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      }
    }
  )
    .then(res => res.text())
    .then(function (resp) {
      document.getElementById('msj').innerHTML = resp
    })
    .catch(err => console.error(err))
}
// send prolog  query json to server : {prolog : String query}
// function sendPrologQuery (comand ) {
//   let data = {
//     prolog: comand
//   }
//   fetch(
//     'http://localhost/GamesForKids/ProyectoFinal/Model/carGame/carController.php',
//     {
//       method: 'POST',
//       body: JSON.stringify(data),
//       headers: {
//         'Content-Type': 'application/json;charset=utf-8'
//       }
//     }
//   )
//     .then(res => res.text())
//     .then(function (resp) {
//       if (resp.includes("[")) {
//         let directions = resp.slice(1,-1).split(",");
//         return directions
//       }
//       document.getElementById('msj').innerHTML = resp
//     })
//     .catch(err => console.error(err))
// }

// send prolog  query json to server : {prolog : String query}
async function sendPrologQuery (comand) {
  let data = {
    prolog: comand
  }
  const response = await fetch(
    'http://localhost/GamesForKids/ProyectoFinal/Model/carGame/carController.php',
    {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      }
    }
  )
  const res = await response.text()
  return res
}
async function sendCarSession(gameSession) {
  console.log(gameSession.numberCommands);
  let data = {
    directions: gameSession.directions.toString(),
    com: gameSession.numberCommands,
    numErrors: gameSession.numberError,
  }
  const response = await fetch(
    'http://localhost/GamesForKids/ProyectoFinal/Model/carGame/carController.php',
    {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      }
    }
  )
  const res = await response.text()
  return res
}

function recognizeWord () {
  try {
    recognition.start()
    // console.log('Ready to receive a direction command.')
    btnListen.value= " 🎤 ";
    console.log(btnListen);

  } catch (error) {
    let errorP = document.getElementById("errorListen")
    errorP.innerText = "Escuchando ..."
    setTimeout(() => {
      if (!errorP.classList.contains('hidden')) {
        setTimeout(() => {
          errorP.classList.add('hidden'), 1000
        })
      } else {
        errorP.classList.remove('hidden')
      }
    }, 10)
  }
}
// on recognize speech word  move carTile and arduinoCar
recognition.onresult = function (event) {
  obtainedWord = event.results[0][0].transcript.toUpperCase()
  console.log(obtainedWord)
  btnListen.value= "Escuchar";
  if ('DERECHA DERECHO'.includes(obtainedWord) && ('DERECHA DERECHO').includes(labyrinthGame.currentDirection) ) {
    if (useArduino) {
      enviarOrden('R');
    }
    // move car tile
    moveCar("DERECHA");
    labyrinthGame.increaseIndexDir();
  }
  else if ('IZQUIERDA IZQUIERDO'.includes(obtainedWord) && ('IZQUIERDA IZQUIERDO').includes(labyrinthGame.currentDirection) ) {
    if (useArduino) {
      enviarOrden('L');
    }
    // move car tile
    moveCar("IZQUIERDA");
    labyrinthGame.increaseIndexDir();
  }
  else if ('ADELANTE'.includes(obtainedWord) && ('ADELANTE').includes(labyrinthGame.currentDirection) ) {
    if (useArduino) {
      enviarOrden('F');
    }
    // move car tile
    moveCar("ADELANTE");
    labyrinthGame.increaseIndexDir();
  }else{
    enviarOrden('E');
    labyrinthGame.increaseError();
    grid.cellByCord(tileWithCar.x , tileWithCar.y).shakeCell();
  }
  showScore();
  if (selectedFinalCell.x == tileWithCar.x && selectedFinalCell.y == tileWithCar.y  ) {
    // enviarOrden('G');
    dropConfetti();
    showSaveGame();
  }

}

function showScore(){
  document.getElementById("pScore").innerText = labyrinthGame.indexDir;   
}

recognition.onspeechend = function () {
  document.getElementById("btnListen").innerText = " ... ";
  recognition.stop()
}

recognition.onnomatch = function (event) {
  console.log('No se reconoce palabra')
}

recognition.onerror = function (event) {
  console.log('Error : ' + event.error)
}
var createPathsBtn = true
var createDirBtn = true
function modifyCell (functionIndex) {
  // select cell clicked
  let val = functionIndex.value
  let cell = grid.cellById(id_selected)
  switch (val) {
    case 0: // set initial cell
      showInstrucction(functionIndex)
      playSpeech("Seleccione casilla final");
      cell.inicial = true
      functionIndex.value++
      return functionIndex
    case 1: // set final cell
    cell.final ? cell.final = false : cell.final = true;
      playSpeech("Seleccione casillas de ruta ");
    
      if (cell.inicial) {
        alert('la celda seleccionada es inicial')
      } else {
        showInstrucction(functionIndex)
        functionIndex.value++
        return functionIndex
      }
      break
    case 2: // set path cells
    console.log(cell)
    cell.ruta? cell.ruta = false : cell.ruta = true;
      return createBtnPaths(createPathsBtn, functionIndex) + 1
      break

    case 3:
      //set car directionr
      playSpeech("Seleccione sentido del carrito") ;
      createBtnDirection()

      return

    default:
      break
  }
}
function createBtnPaths (create, functionIndex) {
  if (create) {
    let finishPahtBtn = document.createElement('button')
    finishPahtBtn.innerText = 'Finalizar selección'
    document.getElementById('ins-det').appendChild(finishPahtBtn)
    finishPahtBtn.onclick = function () {
      showInstrucction(functionIndex)
      document.getElementById('btnSavePath').classList.remove('hidden')
      functionIndex.value++
      modifyCell(functionIndex)
      document.getElementById('ins-det').removeChild(finishPahtBtn)
      // set carTile into initial cell
      tileWithCar = grid.getInitialCell().carTile = new CarTile(
        boardGame,
        carSource
      )
    }
    createPathsBtn = false
  }
  return functionIndex
}

// create buttons for rotate car img, and set initial orientation (n,s,e,o)
function createBtnDirection () {
  if (createDirBtn) {
    let optionsContainer = document.createElement('div')
    let optDiv = document.createElement('div')
    let rotateLeftBtn = document.createElement('button')
    let rotateRightBtn = document.createElement('button')
    optDiv.classList.add("optDiv");
    rotateLeftBtn.innerText = '⭯'
    rotateLeftBtn.classList.add('btn', 'btn-outline-primary', 'btn-lg')
    rotateLeftBtn.id = "lftBtn";
    rotateRightBtn.id = "rigBtn";
    rotateRightBtn.classList.add('btn', 'btn-outline-primary', 'btn-lg')
    optionsContainer.classList.add('btnContainer')
    optionsContainer.id = 'dirDiv'
    rotateRightBtn.innerText = '⭮'
    optDiv.appendChild(rotateLeftBtn)
    optDiv.appendChild(rotateRightBtn)
    optionsContainer.appendChild(optDiv);
    document.getElementById('ins-det').appendChild(optionsContainer)
    rotateLeftBtn.addEventListener('click', rotateLeft)
    rotateRightBtn.addEventListener('click', rotateRight)
  }
  createDirBtn = false
}

function rotateLeft () {
  tileWithCar.rotateL()
}

function rotateRight () {
  tileWithCar.rotateR()
}

function moveCar (comand) {
  if (comand == 'ADELANTE') tileWithCar.goForward()
  else if (comand == 'DERECHA') tileWithCar.rotateR()
  else if (comand == 'IZQUIERDA') tileWithCar.rotateL()
  else if (comand == 'ATRAS') tileWithCar.goBackward()
}

function showInstrucction (index) {
  document.querySelectorAll('.inst').forEach(function (element) {
    if (element.id == `p-ins-${index.value}`) {
      element.classList.add('hidden')
    }
  })
  document.querySelectorAll('.inst')[index.value + 1].classList.remove('hidden')
}

function hideInstrucctions () {
  document.querySelectorAll('.inst').forEach(function (element) {
    element.classList.add('hidden')
  })
  document.getElementById('btnSavePath').classList.add('hidden')
  //show only the first instruction
  document.querySelectorAll('.inst')[0].classList.remove('hidden')
}

function hideLastInst (title) {
  document.getElementById('dirDiv').classList.add('hidden')
  document.getElementById('p-ins-3').classList.add('hidden')
  document.getElementById('ins-title').innerText = title
}

function showSaveGame(){
  let btnSave = document.getElementById("btnSaveGame");
  btnSave.classList.toggle("hidden");
  btnSave.addEventListener('click' , saveGame);
  document.getElementById("formSave").appendChild(btnSave);
}

function saveGame() {
  console.log("juego guardado ");
  let btnSave = document.getElementById("btnSaveGame");
  btnSave.classList.toggle("hidden");
  // send data to post controller json and save to sql
   const promise  = sendCarSession(labyrinthGame);
  promise.then((data) =>{
    window.location = '../../View/Student/dashboard.php';
  });

}

function playSpeech(text){
  var utterance = new SpeechSynthesisUtterance(text);
  utterance.lang = 'es-ES';
  var voices = window.speechSynthesis.getVoices();
  utterance.voice = voices.filter(function(voice) { return voice.name == 'Zira'; })[0];
  speechSynthesis.speak(utterance);
}


// third party confetty 

const start = () => {
            setTimeout(function() {
                confetti.start()
            }, 1000); 
        };
        const stop = () => {
            setTimeout(function() {
                confetti.stop()
            }, 4000); 
        };
function dropConfetti(){
    start();
    stop();
}
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro por voz</title>
    <link rel="stylesheet" type="text/css" href="../Student/Css/styles2.css">
    <link rel="stylesheet" href="CarGameStyle.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- Icons Bootstrap-->  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>


    <?php
    include '../CarGame/carGridView.php';
    $numRow = 3;
    $numCol = 3;
    $instrucArray  = array("Seleccione casilla de inicio ", "Seleccione casilla final ", "Seleccione casilla(s) de ruta   ", "Seleccione sentido de el carrito");
    ?>

<div class="containerTitle">
		<header>
            <p></p>
			<h2>ORIENTACIÓN</h2>
		</header>
	</div>
	
	<!-- divisor de circulos azul -->
	<div class="divisor dark-blue">
		<div class="divisor">
			<svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep3" viewBox="0 0 1600 100" style="display: block;">
				<path class="" style="opacity: 1;fill: #273a4c;" d="M-40,71.627C20.307,71.627,20.058,32,80,32s60.003,40,120,40s59.948-40,120-40s60.313,40,120,40s60.258-40,120-40s60.202,40,120,40s60.147-40,120-40s60.513,40,120,40s60.036-40,120-40c59.964,0,60.402,40,120,40s59.925-40,120-40s60.291,40,120,40s60.235-40,120-40s60.18,40,120,40s59.82,0,59.82,0l0.18,26H-60V72L-40,71.627z"></path>
				<path class="" style="opacity: 1;fill: #2a3f54;" d="M-40,83.627C20.307,83.627,20.058,44,80,44s60.003,40,120,40s59.948-40,120-40s60.313,40,120,40s60.258-40,120-40s60.202,40,120,40s60.147-40,120-40s60.513,40,120,40s60.036-40,120-40c59.964,0,60.402,40,120,40s59.925-40,120-40s60.291,40,120,40s60.235-40,120-40s60.18,40,120,40s59.82,0,59.82,0l0.18,14H-60V84L-40,83.627z"></path>
				<path class="" style="fill: rgb(34, 49, 63);" d="M-40,95.627C20.307,95.627,20.058,56,80,56s60.003,40,120,40s59.948-40,120-40s60.313,40,120,40s60.258-40,120-40s60.202,40,120,40s60.147-40,120-40s60.513,40,120,40s60.036-40,120-40c59.964,0,60.402,40,120,40s59.925-40,120-40s60.291,40,120,40s60.235-40,120-40s60.18,40,120,40s59.82,0,59.82,0l0.18,138H-60V96L-40,95.627z"></path>
			</svg>
			
		</div>
	</div>
    <!-- header placed here -->

    <!-- game cells  -->
    <?php
    echo '<div id="p-container">';
    echo '<div id="game-board"></div>';
    printInstructions("Instrucciones", $instrucArray);
    echo "</div>";

    ?>
    <!-- modal dialog -->
    <!-- <section class="modal hidden">
        <div class="flex">
            <button class="btn-close">⨉</button>
        </div>
        <div>
            <h3 id="titleDialog">Stay in touch</h3>
            <p id="msj">
            </p>
        </div>

        <button class="btn" id="btnClose">Cerrar</button>
    </section> -->

    <div class="overlay hidden"></div>


    <form action="" method="POST">
        <div class="row" id="formSave">
            <div class="col-4"></div>
            <div class="col-5">
                <input type="button" value="Generar ruta" class="btn-Green" id="btnSavePath">
                <input type="button" value="Guardar ruta" class="btn-Green hidden" id="btnSaveGame">
            </div>
            <p id="msj"></p>
        </div>
    </form>

    <script type="text/javascript" src="../CarGame/carFunctions.js"></script>
    <script type="text/javascript" src="../CarGame/Grid.js"></script>
    <script type="text/javascript" src="../CarGame/confetti.js"></script>
    <script type="text/javascript">
        hideInstrucctions();
        // create and control item cells
        const closeModalBtn = document.querySelector(".btn-close");
        const boardGame = document.getElementById("game-board");
        const btnSavePath = document.getElementById("btnSavePath");
        const grid = new Grid(boardGame, 3, 3);
        const carSource = "../CarGame/CarritoSanduchero.png"
        var tileWithCar;
        var intervalDirections = 2500;
        var carPromisePath = Promise.resolve();
        var carDirections = {
            dir: []
        };
        var labyrinthGame;
        var useArduino = true;
        var selectedFinalCell;
        //array to control the modify order of cells
        var functionIndex = {
            value: 0
        };
       playSpeech("Seleccione casilla de incio");
        // handle grid click input 

        boardGame.addEventListener('click', function() {
            modifyCell(functionIndex);
        });

        btnSavePath.addEventListener('click', function() {
            // carDirections.dir =   sendPrologQuery(grid.getPrologQuery());
            // console.log(carDirections.dir)
            console.log(grid.getPrologQuery());
            const promise = sendPrologQuery(grid.getPrologQuery());
            promise.then((data) => {
                validatePath(data)
            });
        });

        function validatePath(data) {
            if (data.includes("[")) {
                hideLastInst("Simulando ruta");
                carDirections.dir = String(data).toUpperCase().slice(1, -1).split(",");
                document.getElementById("btnSavePath").classList.toggle("hidden")
                selectedFinalCell = grid.getFinalCell();
                //mostrar modal de ruta valida y cuenta regresiva

                // mandar ruta al arduino y al carro
                const promise = routeDemostration();
                // save game session 
                labyrinthGame = new LabyrinthGame(carDirections.dir);
            } else {
                console.log("no vale ruta")
                openModal("Ruta no válida", "La ruta no puede trazada")
            }
        }
        

        // Listen voice comands event
        let btnListen = document.getElementById('btnListen');
        btnListen.addEventListener('click', function() {
            console.log(recognizeWord());
        });

        // async function routeDemostration() {
        //     let proces = await carDirections.dir.forEach(function(comand,index) {
        //         setTimeout(function() {
        //             console.log(comand);
        //             moveCar(comand);
        //         }, index * 2500);
        //     });
        //     return;
        // }
        var limit= true;
        async function routeDemostration() {
            carDirections.dir.forEach(function(comand) {
                carPromisePath = carPromisePath.then(function() {
                    //mandar aqui al arduino
                    // if(arduino) sendArduino(comand);
                    moveCar(comand);
                    
                    if ( comand == "ATRAS") limit = false
                    if (limit) playSpeech(comand)
                    return new Promise(function(resolve) {
                        setTimeout(resolve, intervalDirections);
                    });
                });
            });
            carPromisePath.then(function() {
                showVoiceInstructions("Comandos de voz")
            })
        }

        function showVoiceInstructions(title) {
            document.getElementById("ins-title").innerText = title;
            document.getElementById("btnListen").classList.toggle("hidden");
            document.getElementById("scoreDiv").classList.toggle("hidden")
        }



        function openModal(title, message) {
            const modal = document.querySelector(".modal");
            const overlay = document.querySelector(".overlay");
            document.getElementById("titleDialog").innerText = title;
            document.getElementById("msj").innerText = message;
            modal.classList.remove("hidden");
            overlay.classList.remove("hidden");
        }

        const closeModal = function() {
            const modal = document.querySelector(".modal");
            const overlay = document.querySelector(".overlay");
            modal.classList.add("hidden");
            overlay.classList.add("hidden");
        }

        closeModalBtn, addEventListener("click", closeModal);


        // 
    </script>


</body>

</html>
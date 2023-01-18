<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro por voz</title>
    <link rel="stylesheet" href="CarGameStyle.css">
</head>

<body>
    <?php
    include '../../Template/header.php';
    include '../CarGame/carGridView.php';
    $numRow = 3;
    $numCol = 3;
    $instrucArray  = array("Seleccione casilla de inicio ", "Seleccione casilla final ", "Seleccione casilla(s) de ruta   ", "Seleccione sentido de el carrito");
    ?>
    <!-- header placed here -->

    <!-- game cells  -->
    <?php
    echo '<div id="p-container">';
    echo '<div id="game-board"></div>';
    printInstructions("Instrucciones", $instrucArray);
    echo "</div>";

    ?>
    <!-- modal dialog -->
    <section class="modal hidden">
        <div class="flex">
            <button class="btn-close">⨉</button>
        </div>
        <div>
            <h3 id="titleDialog">Stay in touch</h3>
            <p id="msj">
            </p>
        </div>

        <button class="btn" id="btnClose">Cerrar</button>
    </section>

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
        var useArduino = false;
        var selectedFinalCell;
        //array to control the modify order of cells
        var functionIndex = {
            value: 0
        };
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
        // cell.isInicial(tru`e);

        // prolog functions


        // send audio to arduino

        // botonOn.addEventListener('click', function() {
        //     enviarOrden("ON");
        // });
        // botonOFF.addEventListener('click', function() {
        //     enviarOrden("OFF");
        // });

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

        async function routeDemostration() {
            carDirections.dir.forEach(function(comand) {
                carPromisePath = carPromisePath.then(function() {
                    //mandar aqui al arduino
                    // if(arduino) sendArduino(comand);
                    moveCar(comand);
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
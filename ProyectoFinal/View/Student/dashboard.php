<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>Juego figuras</title>
        <link rel="stylesheet" type="text/css" href="Css/styles1.css"/>
    </head>

<body>
    <div class="container">
		<header>
			<h2>Seleccione el juego</h2>
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


    <section>
            <div class="principal-buttons">

                <div class="type-button" id='btn-figures'>
                    <img src="Imgs/figuras.png" ></img>
                    <a href="startFiguresGame.php"><h3>Figuras</h3></a>
                </div>
            
                <div class="type-button" id='btn-orientation'>
                    <img src="Imgs/figuras.png" ></img>
                    <a><h3>Orientación</h3></a>
                </div>

            </div>

    </section>


</body>
</html>
        
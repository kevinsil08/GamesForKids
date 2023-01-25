<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="../../resources/styles9.css">
</head>
<body>
	<?php
		include ("../../Model/Database/Connection.php");
		include ("../../Model/Database/Funciones.php");
	?>
	<?php
    if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'falta'){
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Debe llenar todos los campos.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    }
    ?>
	<div class="contenedor">
		<h1>Crear sesion</h1>
		<form action="../../Model/Teacher/registerTeacherProcess.php" method="post" >
			<h2 id="error"></h2>
			<div class="username">
				<label>Ingrese el Nombre del profesor : </label>
				<input type="text" name="nombre" autofocus required>
			</div>
			<div class="userLastname">
				<label>Ingrese el Apellido del profesor : </label>
				<input type="text" name="apellido" autofocus required>
			</div>
			<div class="email">
				<label>Ingrese el Correo del profesor : </label>
				<input type="email" name="email" autofocus required>
			</div>
			<div class="password">
				<label>Ingrese la Contraseña del profesor : </label>
				<input type="password" name="pass" autofocus required>
			</div>
			<input type="submit" value="Registrarse">
		</form>
	</div>
</body>
</html>
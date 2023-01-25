<?php
session_start();
if(!empty($_SESSION)){
	session_unset();
	session_destroy();
	session_abort();
}
?>
<!DOCTYPE html>
<html lang="es-US">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pagina de Inicio</title>
	<link rel="stylesheet" type="text/css" href="resources/styles5.css">
</head>
<body>
	<div class="contenedor">
		<h1>Seleccione su ocupaci&oacute;n</h1>
		<div class="administrador">
			<a href="View/Admin/loginAdmin.php"><input type="button" value="👩‍💻 Administrador 👨‍💻"></a>
		</div>
		<div class="profe">
			<a href="View/Teacher/loginTeacher.php"><input type="button" value="👩‍🏫 Profesor 👨‍🏫"></a>
		</div>
		<div class="std">
			<a href="View/Student/loginStudent.php"><input type="button" value="👩‍🎓 Estudiante 👨‍🎓"></a>
		</div>

	</div>
</body>
</html>
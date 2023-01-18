<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administrador</title>
	<link rel="stylesheet" type="text/css" href="../../resources/styles7.css">
	<!-- Bootstrap CSS v5.2.1 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>

<?php
if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'){
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> El correo y/o contraseña son incorrectos
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>

	<div class="formulario">
		<h2>Inicio de sesion</h2>
		<form action="../../Model/Teacher/loginTeacherController.php" method="post" >
			<h1 id="error"></h1>
			<div class="username">
				<label>Correo electronico : </label>
				<input type="text" name="user" required autofocus>
			</div>
			<div class="password">
				<label>Contraseña : </label>
				<input type="password" name="pass" required autofocus>
			</div>
			<input type="submit" value="Iniciar sesion">
		</form>
		<div class="registrar">
				Registrate<a href="registerTeacher.php"> aqui.</a>
		</div>
		<form action="../../index.php" method="post">
			<input type="submit" style="background-color: rgba(255, 0, 0, 0.826); margin-bottom: 15px;" value="Regresar">
		</form>
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    	integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  	</script>
	
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Estudiante</title>
	<link rel="stylesheet" type="text/css" href="../../resources/styles8.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>

<?php
if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'){
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> El nombre y/o código del estudiante son incorrectos
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>

	<div class="formulario">
		<h2>Inicio de sesion</h2>
		<form action="../../Model/Login/loginStudentController.php" method="post" >
			<h1 id="error"></h1>
			<div class="username">
				<label>C&eacute;dula : </label>
				<input type="text" name="txtPassport" required>
			</div>
			<div class="password">
				<label>Contraseña : </label>
				<input type="password" name="txtPassword" required>
			</div>
			<input type="submit" value="Iniciar sesion">
		</form>
		<form action="../../index.php" method="post">
			<input type="submit" style="background-color: rgba(255, 0, 0, 0.826); margin-top: 40px; margin-bottom: 10px;" value="Regresar">
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    	integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  	</script>
</body>
</html>
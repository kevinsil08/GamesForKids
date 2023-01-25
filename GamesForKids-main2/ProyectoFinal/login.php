<?php 
if(!empty($_SESSION)){
    session_destroy();
}

include 'Template/header.php'
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <?php
                if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Las credenciales ingresadas no son las correctas.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                }
                ?>
            <div class="card">
                <div class="card-header">
                    Ingresar
                </div>

                <form action="Model/Login/loginProcess.php" class="p-3" method="POST">
                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Correo: </label>
                        <input type="email" class="form-control" name="txtEmail" autofocus required="true">
                    </div>
                    <div class="mb-3">
                        <label for="txtPassword" class="form-label">Contraseña: </label>
                        <input type="password" class="form-control" name="txtPassword" autofocus required="true">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Tipo de Usuario:</label>
                        
                        <input type="radio" checked="checked" name="user" value="Teacher"> <label class="form-label">Profesor</label>
                        <input type="radio" name="user" value="Student"> <label class="form-label">Estudiante</label>
                    </div>

                    <div class="mb-3">
                        <a href="View/Teacher/registerTeacher.php">Reg&iacute;strate como Profesor...</a>
                    </div>

                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<br><br>
<br><br>

<?php 
include 'Template/footer.php'
?>

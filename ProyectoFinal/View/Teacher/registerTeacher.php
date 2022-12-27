<?php 
include '../../Template/header.php'
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

                <?php
                if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'contra'){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Alerta!</strong> La contraseña de confirmaci&oacute;n no concuerda con la contraseña ingresada.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                }
                ?>
            <div class="card">
                <div class="card-header">
                    Registrar Profesor
                </div>
                <form action="../../Model/Teacher/registerTeacherProcess.php" class="p-4" method="POST">
                    <div class="mb-3">
                        <label for="txtName" class="form-label">Nombre: </label>
                        <input type="text" class="form-control" name="txtName" autofocus required="true">
                    </div>
                    <div class="mb-3">
                        <label for="txtLastName" class="form-label">Apellido: </label>
                        <input type="text" class="form-control" name="txtLastName" autofocus required="true">
                    </div>
                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Correo: </label>
                        <input type="email" class="form-control" name="txtEmail" autofocus required="true">
                    </div>
                    <div class="mb-3">
                        <label for="txtPassword" class="form-label">Contraseña: </label>
                        <input type="password" class="form-control" name="txtPassword" autofocus required="true">
                    </div>
                    <div class="mb-3">
                        <label for="txtConfirmPassword" class="form-label">Contraseña de confirmaci&oacute;n: </label>
                        <input type="password" class="form-control" name="txtConfirmPassword" autofocus required="true">
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
include '../../Template/footer.php'
?>
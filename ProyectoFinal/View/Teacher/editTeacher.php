<?php 
    session_start();
    include '../../Template/header.php';
    include '../../Model/Database/Connection.php';
    include '../../Model/Teacher/functionsDatabase.php';
    include '../../index.php';

    if(empty($_SESSION['tch_id'])){
        session_destroy();
        header("Location: ../../login.php");
    }else{
        $id_teacher=$_SESSION["tch_id"];
        global $conn;
        $teacher = selectTeacher($conn, $id_teacher);
    }
?>

<div class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-expand-lg bg-primary bg-opacity-75 pr-5">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="../../View/Teacher/dashboardTeacher.php">P&aacute;gina Principal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="../../View/Teacher/studentsTeacher.php">Perfiles Estudiantes</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white" href="#">Calificaciones Estudiantes</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-lg-0 d-flex" style="margin-right: 10%;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Opciones
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="editTeacher.php">Configurar Perfil</a></li>
                            <li><a class="dropdown-item" href="../../login.php">Salir</a></li>
                        </ul>
                    </li>
            </ul>
            </div>
        </div>
    </nav>
      
  </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Editar datos:
                </div>
                <form action="../../Model/Teacher/editProcess.php" class="p-4" method="POST">
                    <div class="mb-3">
                        <label for="txtNombre" class="form-label">Nombre: </label>
                        <input type="text" class="form-control" name="txtNombre" autofocus required="true" value="<?php echo $teacher['tch_name'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtApellido" class="form-label">Apellido: </label>
                        <input type="text" class="form-control" name="txtApellido" autofocus required="true" value="<?php echo $teacher['tch_last_name'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Email: </label>
                        <input type="email" class="form-control" name="txtEmail" autofocus required="true" value="<?php echo $teacher['tch_email'];?>">
                    </div>
                    <div class="d-grid">
                        <input type="hidden" name="id_teacher" value="<?php echo $id_teacher;?>">
                        <input type="submit" class="btn btn-primary" value="Editar">
                    </div>
                </form>
            </div>

            <!-- <div class="card mt-5">
                <div class="card-header">
                    Editar Contraseña:
                </div>
                <form action="../../Model/Teacher/editProcess.php" class="p-4" method="POST">
                    <div class="mb-3">
                        <label for="txtPassword" class="form-label">Ingrese su Contraseña Actual: </label>
                        <input type="text" class="form-control" name="txtPassword" autofocus required="true" value="">
                    </div>
                    <div class="mb-3">
                        <label for="txtNewPassword" class="form-label">Nueva Contraseña: </label>
                        <input type="text" class="form-control" name="txtNewPassword" autofocus required="true" value="">
                    </div>
                    <div class="mb-3">
                        <label for="txtNewPassword2" class="form-label">Email: </label>
                        <input type="text" class="form-control" name="txtNewPassword2" autofocus required="true" value="">
                    </div>
                    <div class="d-grid">
                        <input type="hidden" name="id_teacher" value="<?php echo $id_teacher;?>">
                        <input type="submit" class="btn btn-primary" value="Editar">
                    </div>
                </form>
            </div> -->

            <br><br><br>
            <br><br><br>
        </div>
    </div>
</div>



<?php 
include '../../Template/footer.php'
?>
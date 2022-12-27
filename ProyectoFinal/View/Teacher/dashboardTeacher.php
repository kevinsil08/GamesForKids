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
  $teacher = selectTeacher($conn, $id_teacher);
  $_SESSION["tch_id"] = $id_teacher;
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

<?php
if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'registrado'){
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Registrado!</strong> Se ha registrado correctamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>

<?php
if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado'){
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Actualizado!</strong> Se actualizaron los datos.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>

<?php
if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'){
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Vuelve a intentarlo.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>




<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
          <div class="card-header">
          Bienvenido, <?php echo $teacher['tch_name'];?>  <?php echo $teacher['tch_last_name'];?>
          </div>

          <div class="card-body">
            <h5 class="card-title">Calificaciones de los estudiantes registrados</h5>
            <a href="#" class="btn btn-primary">Acceder <i class="bi bi-archive"></i></a>
          </div>

          <div class="card-body">
            <h5 class="card-title">Ajustes del Perfil</h5>
            <a href="editTeacher.php" class="btn btn-warning">Ajustes <i class="bi bi-gear"></i></a>
          </div>
      </div>
          
        </div>
  </div>
</div>




<?php 
include '../../Template/footer.php'
?>
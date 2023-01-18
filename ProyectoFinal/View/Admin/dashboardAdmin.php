<?php 
session_start();
include '../../Template/header.php';
include '../../Template/navAdmin.php';
include '../../Model/Database/Connection.php';
include '../../Model/Admin/functionsDatabase.php';
include '../../SecurityToken.php';

if(empty($_SESSION['admin_id'])){
  session_destroy();
  header("Location: ../../index.php");
}else{
  $id_admin=$_SESSION["admin_id"];
  $admin = selectAdmin($conn, $id_admin);
}
?>

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
          Bienvenido, <?php echo $admin['adm_name'];?>  <?php echo $admin['adm_last_name'];?>
          </div>

          <div class="card-body">
            <h5 class="card-title">Asignar Juegos a los Estudiantes</h5>
            <a href="assignGamesToStudent.php" class="btn btn-primary">Asignar <i class="bi bi-archive"></i></a>
          </div>

          <div class="card-body">
            <h5 class="card-title">Ajustes del Perfil</h5>
            <a href="editadmin.php" class="btn btn-warning">Ajustes <i class="bi bi-gear"></i></a>
          </div>
      </div>
          
        </div>
  </div>
</div>

<?php 
include '../../Template/footer.php'
?>
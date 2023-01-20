<?php 
session_start();
include '../../Template/header.php';
include '../../Template/navTeacher.php';
include '../../Model/Database/Connection.php';
include '../../Model/Teacher/functionsDatabase.php';
include '../../Model/Game/functionsDatabase.php';
include '../../SecurityToken.php';
  global $conn;
if(empty($_SESSION['tch_id'])){
  session_destroy();
  header("Location: ../../index.php");
}else{
  $id_teacher=$_SESSION["tch_id"];
  $teacher = selectTeacher($conn, $id_teacher);
  $_SESSION["tch_id"] = $id_teacher;
}

  global $conn;
  
  $result_match_id = selectLastMatch($conn,$id_teacher);

  if($result_match_id != null ){
    $_SESSION["passwd_generated"] = $result_match_id["mtg_password"]; 
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
if(isset($_GET['juego']) && $_GET['juego'] == 'generado'|| (isset($result_match_id['mtg_password']) && $result_match_id['mtg_password'] != null)){
  $passwd_generated =$_SESSION["passwd_generated"]; 
?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Generado correctamente!</strong> El c&oacute;digo de ingreso es <strong><?php echo $passwd_generated; ?></strong>
      <form action="../../Model/Game/finishGame.php" method="POST">
        <input type="hidden" name="passwd" value="<?php echo $passwd_generated; ?>">
        <button type="submit" class="btn btn-success mt-2">Finalizar Juego</button>
      </form>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php
}
?>

<?php
if(isset($_GET['juego']) && $_GET['juego'] == 'finalizado'){
?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Finalizado correctamente!</strong> El juego ha sido finalizado correctamente</strong>
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
            <h5 class="card-title">Asignar Juegos a los Estudiantes</h5>
            <a href="assignGamesToStudent.php" class="btn btn-primary">Asignar <i class="bi bi-archive"></i></a>
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
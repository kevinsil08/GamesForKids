<?php 
    session_start();
    include '../../Template/header.php';
    include '../../Template/navTeacher.php';
    include '../../Model/Database/Connection.php';
    include '../../Model/Teacher/functionsDatabase.php';
    include '../../SecurityToken.php';

    if(empty($_SESSION['tch_id'])){
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
    }else{
        $id_teacher=$_SESSION["tch_id"];
        global $conn;
        $teacher = selectTeacher($conn, $id_teacher);
    }
?>

<div class="container mt-5 mb-5">
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
                    <div class="mb-3">
                        <label for="txtpasswd" class="form-label">Contraseña: </label>
                        <input type="text" class="form-control" name="txtpasswd" autofocus required="true" value="<?php echo $teacher['tch_password'];?>">
                    </div>
                    <div class="d-grid">
                        <input type="hidden" name="id_teacher" value="<?php echo $id_teacher;?>">
                        <input type="submit" class="btn btn-primary" value="Editar">
                    </div>
                </form>
            </div>

            <br><br><br>
        </div>
    </div>
</div>



<?php 
include '../../Template/footer.php'
?>
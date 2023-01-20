<?php 
    session_start();
    include '../../Template/header.php';
    include '../../Template/navAdmin.php';
    include '../../Model/Database/Connection.php';
    include '../../Model/Admin/functionsDatabase.php';
    include '../../SecurityToken.php';


    if(empty($_SESSION['admin_id'])){
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
    }else{
        $id_admin=$_SESSION["admin_id"];
        global $conn;
        $admin = selectAdmin($conn, $id_admin);
    }
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Editar datos:
                </div>
                <form action="../../Model/Admin/editController.php" class="p-4" method="POST">
                    <div class="mb-3">
                        <label for="txtNombre" class="form-label">Nombre: </label>
                        <input type="text" class="form-control" name="txtNombre" autofocus required="true" value="<?php echo $admin['adm_name'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtApellido" class="form-label">Apellido: </label>
                        <input type="text" class="form-control" name="txtApellido" autofocus required="true" value="<?php echo $admin['adm_last_name'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Email: </label>
                        <input type="email" class="form-control" name="txtEmail" autofocus required="true" value="<?php echo $admin['adm_email'];?>">
                    </div>
                    <div class="mb-3">
                        <label for="txtpasswd" class="form-label">Contraseña: </label>
                        <input type="text" class="form-control" name="txtpasswd" autofocus required="true" value="<?php echo $admin['adm_password'];?>">
                    </div>
                    <div class="d-grid">
                        <input type="hidden" name="id" value="<?php echo $id_admin;?>">
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
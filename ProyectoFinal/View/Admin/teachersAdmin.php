<?php 
session_start();
include '../../Template/header.php';
include '../../Template/navAdmin.php';
include '../../Model/Database/Connection.php';
include '../../Model/Admin/functionsDatabase.php';
include '../../Model/Teacher/functionsDatabase.php';
include '../../SecurityToken.php';

if(empty($_SESSION['admin_id'])){
    session_destroy();
    header("Location: ../../index.php");
}else{
    $id_admin=$_SESSION["admin_id"];
}


?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php
                if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Rellena todos los campos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                }
                ?>

                <?php
                if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'falta'){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Vuelve a intentarlo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                }
                ?>

                <?php
                if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'registrado'){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Registrado!</strong> Se agregaron los datos.
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
                if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Eliminado!</strong> Se elimin&oacute; el estudiante seleccionado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        Listado de Profesores
                    </div>
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col" colspan="2">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    global $conn;
                                    
                                    $lista = listAllTeachers($conn);

                                    if(isset($lista)){

                                                           
                                        foreach($lista as $fila){
                                            $encrypt_id_tch = secureToke::tokenencrypt($fila['tch_id']);

                                                                        
                                ?>
                                    <tr>
                                        <td><?php echo $fila['tch_name']; ?></td>
                                        <td><?php echo $fila['tch_last_name']; ?></td>
                                        <td><button type="button" class="btn btn-warning"><a class="text-white" href="../../View/Admin/teachersAdmin.php?mensaje=actualizar&aldzU1BpUm9xWXprRVhaTEdpU3JTQT09=<?php echo $encrypt_id_tch;?>">Editar<i class="bi bi-pencil"></i></a> </button></td>
                                        <td><button type="button" class="btn btn-danger"><a class="text-white" onclick='return eliminar();' href="../../Model/Admin/deleteAdmin.php?aldzU1BpUm9xWXprRVhaTEdpU3JTQT09=<?php echo $encrypt_id_tch; ?>">Eliminar <i class="bi bi-trash"></i></a></button></td>
                                        <!-- <td><a class="text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar <i class="bi bi-trash"></i></a></td> -->
                                    </tr>
                                
                                <?php
                                        }
                                    }                                
                                                                
                                ?>

                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>

            <?php 
            $path_form=null;
            $name = ""; 
            $last_name = ""; 
            $passwd_student = "";
            $email_student = null;
            $date_birth_student = "";
            $sex_student = "";
            $codigo = null;
            $class = "col-md-4 invisible";
            if(!isset($_GET['aldzU1BpUm9xWXprRVhaTEdpU3JTQT09']) || $_GET['mensaje'] != 'actualizar'){
                $path_form="../../Model/Student/registerStudent.php";
                
            }else{
                $path_form="../../Model/Teacher/editProcess.php";
                $encrypt_id_teacher = $_GET['aldzU1BpUm9xWXprRVhaTEdpU3JTQT09'];
                $codigo = secureToke::tokendecrypt($encrypt_id_teacher);
                $class = "col-md-4";

                global $conn;
                $teacher = selectTeacher($conn,$codigo);

                $name = $teacher['tch_name'];
                $last_name = $teacher['tch_last_name'];
                $email_teacher = $teacher['tch_email'];
                $passwd_teacher = $teacher['tch_password'];
                $id_teacher = $teacher['tch_id'];
            }
            ?>

            <div class="<?php echo $class; ?>">
                <div class="card">
                    <div class="card-header">
                    Actualizar Profesor
                    </div>

                    <form action=<?php echo $path_form; ?> class="p-4" method="POST">
                        <div class="mb-3">
                            <label for="txtNombre" class="form-label">Nombre: </label>
                            <input type="text" class="form-control" name="txtNombre" autofocus required="true" value="<?php echo $name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="txtApellido" class="form-label">Apellido: </label>
                            <input type="text" class="form-control" name="txtApellido" autofocus required="true" value="<?php echo $last_name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="txtEmail" class="form-label">Correo: </label>
                            <input type="email" class="form-control" name="txtEmail" value="<?php echo $email_teacher; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="txtPasswd" class="form-label">Contraseña: </label>
                            <input type="text" class="form-control" name="txtpasswd" autofocus required="true" value="<?php echo $passwd_teacher; ?>">
                        </div>

                        <div class="d-grid">
                        <input type="hidden" name="type_edit" value="admin">
                            <input type="hidden" name="id_teacher" value="<?php echo $id_teacher;?>">
                            <input type="hidden" name="codigo" value="<?php echo $codigo;?>">
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                        </div>
                        
                    </form>
                    <div class="d-grid p-4">
                    <button class="btn btn-danger" value="Cancelar"><a class="nav-link text-white" href="../../View/Teacher/studentsTeacher.php">Cancelar</a></button>        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    

    <br><br>
    <br><br>
    <br><br>
    <br><br>

    <script src="main.js"></script>  

    
<?php 
include '../../Template/footer.php'
?>

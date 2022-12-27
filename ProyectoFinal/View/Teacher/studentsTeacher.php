<?php 
session_start();
include '../../Template/header.php';
include '../../Model/Database/Connection.php';
include '../../Model/Student/functionsDatabase.php';
include '../../Model/Teacher/functionsDatabase.php';
include '../../index.php';

if(empty($_SESSION['tch_id'])){
    session_destroy();
    header("Location: ../../login.php");
}else{
    $id_teacher=$_SESSION["tch_id"];
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
            <div class="col-md-7">

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
                        Listado de Estudiantes
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
                                    
                                    $lista = listStudents($conn, $id_teacher);

                                    if(isset($lista)){

                                                           
                                        foreach($lista as $fila){
                                            $encrypt_id_std = secureToke::tokenencrypt($fila['std_id']);

                                                                        
                                ?>
                                    <tr>
                                        <td><?php echo $fila['std_name']; ?></td>
                                        <td><?php echo $fila['std_last_name']; ?></td>
                                        <td><button type="button" class="btn btn-warning"><a class="text-white" href="../../View/Teacher/studentsTeacher.php?mensaje=actualizar&aldzU1BpUm9xWXprRVhaTEdpU3JTQT09=<?php echo $encrypt_id_std;?>">Editar<i class="bi bi-pencil"></i></a> </button></td>
                                        <td><button type="button" class="btn btn-danger"><a class="text-white" onclick='return eliminar();' href="../../Model/Student/deleteStudent.php?aldzU1BpUm9xWXprRVhaTEdpU3JTQT09=<?php echo $encrypt_id_std; ?>">Eliminar <i class="bi bi-trash"></i></a></button></td>
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
            $text_button="Registrar Estudiante";
            $name = ""; 
            $last_name = ""; 
            $codigo = 0;
            if(!isset($_GET['aldzU1BpUm9xWXprRVhaTEdpU3JTQT09']) || $_GET['mensaje'] != 'actualizar'){
                $path_form="../../Model/Student/registerStudent.php";
                
            }else{
                $path_form="../../Model/Student/editProcess.php";
                $text_button="Actualizar Estudiante";
                $encrypt_id_student = $_GET['aldzU1BpUm9xWXprRVhaTEdpU3JTQT09'];
                $codigo = secureToke::tokendecrypt($encrypt_id_student);

                global $conn;
                $student = selectStudent($conn,$codigo);

                $name = $student['std_name'];
                $last_name = $student['std_last_name'];
            }
            ?>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                    <?php echo $text_button; ?>
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
                        <div class="d-grid">
                            <input type="hidden" name="id_teacher" value="<?php echo $id_teacher;?>">
                            <input type="hidden" name="codigo" value="<?php echo $codigo;?>">
                            <input type="submit" class="btn btn-primary" value="<?php echo $text_button; ?>">
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

    <script>
        function eliminar(){
            if(confirm("¿Desea eliminar el estudiante seleccionado?")){
                return true;
            }else{
                return false;
            }
        }
    </script>

    
<?php 
include '../../Template/footer.php'
?>

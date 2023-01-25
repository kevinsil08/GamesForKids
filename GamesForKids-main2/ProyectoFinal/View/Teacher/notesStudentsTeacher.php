<?php 
    session_start();
    include '../../Template/header.php';
    include '../../Template/navTeacher.php';
    include '../../Model/Database/Connection.php';
    include '../../Model/Game/functionsDatabase.php';
    include '../../Model/Teacher/functionsDatabase.php';
    

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
          Filtrar calificaciones por fechas
          </div>
          <?php
                date_default_timezone_set('America/Guayaquil');
                $today = date('Y-m-d');
            ?>

         <form action="../../Model/Teacher/notesStudentsController.php" class="p-4" method="POST">
            <div class="mb-3">
                <label for="txtSince" class="form-label">Desde: </label>
                <input type="date" class="form-control" name="txtSince" max="<?php echo $today ?>" autofocus required="true" value="">
            </div>
            <div class="mb-3">
                <label for="txtTo" class="form-label">Hasta: </label>
                <input type="date" class="form-control" name="txtTo" max="<?php echo $today ?>" autofocus required="true" value="<?php echo $today ?>">
            </div>

            <div class="d-grid">
                <input type="hidden" name="id_teacher" value="<?php echo $id_teacher;?>">
                <input type="submit" class="btn btn-primary" value="Generar">
            </div>
          
        </form>
      </div>
          
        </div>
  </div>


    <?php
        if(isset($_GET['tabla']) && $_GET['tabla'] == 'mostrar'){
    ?>

            

<div class="card mt-5 mb-5">
    <div class="card-header">
        Listado de Notas
    </div>
    <div class="p-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Nombre del Juego</th>
                        <th scope="col"># de Preguntas</th>
                        <th scope="col"># de Preguntas contestadas incorrectamente</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Creado por</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    global $conn;

                    if(!isset($_GET['primera']) || !isset($_GET['segunda'])){
                        header("Location: dashboardTeacher.php?mensaje=error");
                        exit();
                    }

                    $date_before = $_GET['primera'];
                    $date_after = $_GET['segunda'];

                    $lista = get_califications_students_with_dates($conn, $id_teacher,$date_before,$date_after);

                    

                    if(isset($lista)){
                        foreach($lista as $fila){
                                                        
                ?>
                    <tr>
                        <td><?php echo $fila['std_name']; ?></td>
                        <td><?php echo $fila['std_last_name']; ?></td>
                        <td><?php echo $fila['tpg_name']; ?></td>
                        <td><?php echo $fila['match_quantity_answers']; ?></td>
                        <td><?php echo $fila['match_correct_answer_student']; ?></td>
                        <td><?php echo $fila['mtg_created']; ?></td>
                        <?php
                        
                        $GENERATED_BY = null;
                            if($fila['mtg_typ_match'] == "T"){
                                $GENERATED_BY = "Profesor";
                            }else{
                                $GENERATED_BY = "Estudiante";
                            }
                        ?>

                        <td><?php echo $GENERATED_BY; ?></td>
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

<br><br>
        
    <?php
        }
    ?>


</div>

<?php 
include '../../Template/footer.php'
?>
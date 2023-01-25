<?php 
session_start();
include '../../Template/header.php';
include '../../Template/navTeacher.php';
include '../../Model/Database/Connection.php';
include '../../Model/Teacher/functionsDatabase.php';
include '../../Model/Game/functionsDatabase.php';
include '../../SecurityToken.php';

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
if((isset($_GET['juego']) && $_GET['juego'] == 'generado') || (isset($result_match_id['mtg_password']) && $result_match_id['mtg_password'] != null)){
  $passwd_generated =$_SESSION["passwd_generated"]; 
?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      El c&oacute;digo de ingreso es <strong><?php echo $passwd_generated; ?></strong>
      <p>Para asignar otro juego debe terminar el juego en curso.</p>
      
      <form action="../../Model/Game/finishGame.php" method="POST">
        <input type="hidden" name="passwd" value="<?php echo $passwd_generated; ?>">
        <button type="submit" class="btn btn-success mt-2">Finalizar Juego</button>
      </form>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php
}else{
?>




<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php 
                global $conn;    
                $type_games = listTypeGames($conn);
                $count_type = 0;
                
                if(isset($type_games)){ 
                    foreach($type_games as $type_game){
                      if($count_type == 1){
                        break;
                      }
                        $detail_only_game = listDetailGames($conn,$type_game['tpg_id']);//llama a la base de datos para que haga la consulta de los tipo de juegos
            ?>
            <div class="card mb-5">
                <form action="../../Model/Game/assignGameProcess.php" class="p-4" method="POST" id="types_answers<?php echo $count_type;?>">
                <input type="hidden" name="type_game<?php echo $count_type;?>" value="<?php echo $type_game['tpg_id'];?>">
                <div class="card-header">
                <?php   echo $type_game['tpg_name']; 
                        $count_questions = 1;
                ?>
                </div>

                <?php for($x = 0;$x<count($detail_only_game);$x++){//se cuenta la cantidad de elementos con el 'tpg_id' ?>

                <div class="card-body">
                    <h5 class="card-title">Pregunta <?php echo $count_questions;//$count_questions es un contador de preguntas ?></h5>
                    <select name="type_answer<?php echo $count_questions;?>" class="form-select" aria-label="Default select example" form="types_answers<?php echo $count_type;?>"> <!-- $count_type es para identificar a cada formulario con realice el POST   -->

                        <?php 
                            global $conn;    
                            $detail_games = listDetailGames($conn,$type_game['tpg_id']);//llama a la base de datos para que haga la consulta de los tipo de juegos
                            if(isset($detail_games)){
                                foreach($detail_games as $detail_game){
                        ?>
                        <option value="<?php echo $detail_game['dtg_id'];?>"><?php echo $detail_game['dtg_detail'];//genera una opcion con cada detalle de cada juego?></option>
                                    <?php }?>
                    </select>
                </div>
                    <?php }?>
                
                    <?php $count_questions++;}//se suma la cantidad de preguntas ?>
                    <input type="submit" class="btn btn-primary btn-lg" value="Asignar">
                </form> 
                
            </div>

            <?php $count_type++;} }//se suma la cantidad para el form ?>



        </div>
  </div>
</div>

<br><br>




<?php 
}
include '../../Template/footer.php'
?>
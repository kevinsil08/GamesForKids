<?php
$id_teacher=0;
?>
<div class="container-fluid">
  <div class="row">
      <nav class="navbar navbar-expand navbar-dark bg-primary bg-opacity-75">

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link text-white" href="../../View/Teacher/dashboardTeacher.php?codigo=<?php echo $id_teacher;?>">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="../../View/Teacher/studentsTeacher.php?codigo=<?php echo $id_teacher;?>">Perfiles Estudiantes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Calificaciones Estudiantes</a>
          </li>
        </ul>
      </div>

      </nav>
  </div>
</div>

<?php

// VERIFICAMOS SI HAY UNA SESION INICIADA
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
  // SI NO HAY SESION INICIADA LO REDIRIGIMOS A LOGIN
  header("Location: userLS.php");
  exit();
} else {
  echo "<script>Swal.fire('Any fool can use a computer')</script>";
}

// INCLUIMOS LA CONEXION A LA BASE DE DATOS,ADEMAS DE LAS FUNCIONES QUE EJECUTAN CAMBIOS EN LA APP
require '../functions/actions.php';
require '../functions/db.php';

if (isset($_POST['LOGOUT'])) {
  session_destroy();
  header("Location: userLS.php");
  exit();
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>App TO-DO</title>
  <link rel="stylesheet" type="text/css" href="../app/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<header>
  <a class="logo">
    <img class="logo" src="../app/img/Logo_horizontal-removebg-preview.png">
  </a>

  <nav>

    <ul class="menu">
      <li>
        <h1 class="userNameSty">Hola de nuevo: <?php echo $_SESSION['username']; ?></h1>
        <ul class="submenu">
          <li>
            <form action="" method="POST">

              <input type="hidden" name="LOGOUT" value="true">
              <button type="submit">CERRAR SESION</button>

            </form>
          </li>
        </ul>
      </li>

    </ul>
  </nav>
</header>

<body>
  <div class="container">
    <!-- FORMULARIO QUE EJECUTA LA FUNCION PARA CREAR UNA NUEVA TAREA CON ESTATUS PENDIENTE POR DEFECTO, LA TAREA SE RELACIONA CON EL ID DEL USUARIO -->
    <form class="indexForm" action="" method="POST">
      <h1>Bienvenido, <?php echo $_SESSION['username']; ?></h1>

      <div class="indexFormPP">
      <div>
        <p>Tarea</p>
        <input type="text" name="task" placeholder="Escribe aqui tu tarea" required>
      </div>
      <div>
        <p>Fecha de vencimiento</p>
        <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" />
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      </div>
      </div>


      <center><button type="submit">Agregar tarea</button></center>

      <h2>Tus tareas:</h2>
    </form>

    <?php
    // SI EXISTE EL ATRIBUTO TAREA Y EL USER_ID CREAREMOS UNA NUEVA TAREA CON ESTATUS PENDIENTE PARA EL USUARIO
    if (isset($_POST['task']) && isset($_POST['user_id']) && isset($_POST['fecha'])) {
      createTask($_POST['task'], $_POST['fecha'], $_POST['user_id']);
    }

    // ACTUALIZAMOS EL ESTATUS DE LA TAREA POR MEDIO DEL TASK_ID
    if (isset($_POST['task_id']) && isset($_POST['state'])) {
      updateTask($_POST['task_id'], $_POST['state']);
    }

    // BORRAMOS TODAS LAS TAREAS DEL USUARIO QUE TIENE EL USER_ID
    if (isset($_POST['CLEAR_ALL']) && isset($_POST['user_id'])) {
      deleteTasks($_POST['user_id']);
    }
    ?>





    <ul class="status_colors">
      <li><span class="let1">TERMINADA</li>
      <li><span class="let2">PENDIENTE</li>
    </ul>

    <ul>
      <?php

      // TRAEMOS TODAS LAS TAREAS DEL USUARIO CORRESPONDIENTE AL USER_ID
      $sql = "SELECT * FROM todos WHERE user_id = '" . $_SESSION['user_id'] . "' ";
      $result = $conn->query($sql);
      // RECORREMOS EL ARREGLO CON REGISTROS DE LA BASE DE DATOS
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $task_id = $row['id'];
          $task = $row['task'];
          $fecha = $row['fecha'];
          $completed = $row['state'];
      ?>
          <!-- SE IMPRIMIRAN ITEMS DE LISTA CON LAS TAREAS DINAMICAMENTE DEPENDE DE LA CANTIDAD DE REGISTROS EN LA BASE DE DATOS -->
          <li>
            <!-- CREAMOS UN FORMULARIO PARA EJECUTAR ACCIONES DE ACTUALIZACION SOBRE LA TAREA -->
            <form id="test" action="" method="POST" class="<?= $completed == "COMPLETED" ? 'completed' : '' ?> ">

              <!-- IMPRIMIMOS EL NOMBRE DE LA TAREA -->
              <h3 class='task'> <?php echo $task ?> </h3><br>
              <span class='task'>Fecha de vencimiento: <?php echo $fecha ?> </span><br>
              <!-- SELECCIONAMOS EL ESTATUS DE LA TAREA -->
              <select name="state" id="" default="">
                <option value="PENDING" <?= $completed == "PENDING" ? 'selected' : '' ?>>PENDIENTE</option>
                <option value="COMPLETED" <?= $completed == "COMPLETED" ? 'selected' : '' ?>>COMPLETADA</option>
              </select>
              <!-- MANDAMOS EL TASK_ID AL FORMULARIO PARA IDENTIFICAR A CUAL TAREA VAMOS ALTERAR -->
              <input type="hidden" name="task_id" value="<?= $task_id ?>">


              <button type="submit">Actualizar</button>
            </form>
          </li>

      <?php
        }
      } else {
        // SI NO HAY TAREAS MOSTRAMOS EL SIGUIENTE MENSAJE
        echo "<li>No hay tareas.</li>";
      }
      ?>
    </ul>
    <!-- CREAMOS UN FORMULARIO PARA EJECUTAR LA ACCION DE BORRAR TODAS LAS TAREAS DEL USUARIO -->
    <form action="" method="POST">

      <input type="hidden" name="CLEAR_ALL" value="true">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <center><button type="submit">BORRAR TODOS</button></center>

    </form>
  </div>


</body>

</html>
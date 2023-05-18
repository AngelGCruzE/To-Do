

<?php

// VERIFICAMOS SI HAY UNA SESION INICIADA
session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
  // SI NO HAY SESION INICIADA LO REDIRIGIMOS A LOGIN
  header("Location: login.php");
  exit();
}

// INCLUIMOS LA CONEXION A LA BASE DE DATOS,ADEMAS DE LAS FUNCIONES QUE EJECUTAN CAMBIOS EN LA APP
require 'db.php';
require 'actions.php';


?>


<!DOCTYPE html>
<html>

<head>
  <title>App TO-DO</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="container">
    <!-- IMPRIMIMOS NOMBRE DEL USUARIO EN LA SESION -->
    <h1>Bienvenido, <?php echo $_SESSION['username']; ?></h1>

    <!-- FORMULARIO QUE EJECUTA LA FUNCION PARA CREAR UNA NUEVA TAREA CON ESTATUS PENDIENTE POR DEFECTO, LA TAREA SE RELACIONA CON EL ID DEL USUARIO -->
    <form action="" method="POST">
      <input type="text" name="task" placeholder="Nueva tarea" required>
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <button type="submit">Agregar tarea</button>
    </form>

    <?php
    // SI EXISTE EL ATRIBUTO TAREA Y EL USER_ID CREAREMOS UNA NUEVA TAREA CON ESTATUS PENDIENTE PARA EL USUARIO
    if (isset($_POST['task']) && isset($_POST['user_id'])) {
      createTask($_POST['task'], $_POST['user_id']);
    }

    // ACTUALIZAMOS EL ESTATUS DE LA TAREA POR MEDIO DEL TASK_ID
    if (isset($_POST['task_id']) && isset($_POST['state'])) {
      updateTask($_POST['task_id'], $_POST['state']);
    }

    // BORRAMOS TODAS LAS TAREAS DEL USUARIO QUE TIENE EL USER_ID
    if (isset($_POST['CLEAR_ALL']) && isset($_POST['user_id'])) {
      deleteTasks($_POST['user_id']);
    }

    // CERRAMOS LA SESION DEL USUARIO, BORRAMOS LA SESION Y LO REDIRIGIMOS A LOGIN.PHP
    if (isset($_POST['LOGOUT'])) {
      session_destroy();
      header("Location: login.php");
      exit();
    }
    ?>



    <h2>Tus tareas:</h2>

    <ul class="status_colors">
      <li><span>TERMINADA: <span style="color:#2ecc71;">*</span> </span></li>
      <li><span>PENDIENTE: <span style="color:#eb4d4b;">*</span> </span></li>
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
          $completed = $row['state'];
      ?>
        <!-- SE IMPRIMIRAN ITEMS DE LISTA CON LAS TAREAS DINAMICAMENTE DEPENDE DE LA CANTIDAD DE REGISTROS EN LA BASE DE DATOS -->
          <li>
            <!-- CREAMOS UN FORMULARIO PARA EJECUTAR ACCIONES DE ACTUALIZACION SOBRE LA TAREA -->
            <form action="" method="POST" class="<?= $completed == "COMPLETED" ? 'completed' : '' ?> ">

              <!-- IMPRIMIMOS EL NOMBRE DE LA TAREA -->
              <span class='task'> <?php echo $task ?> </span>
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
      <button type="submit">BORRAR TODOS</button>

    </form>
      <!-- FORMULARIO PARA SOLICITAR QUE SE EJECUTE LA FUNCION DE CERRAR SESION -->
    <form action="" method="POST">

      <input type="hidden" name="LOGOUT" value="true">
      <button type="submit">CERRAR SESION</button>

    </form>
    

  </div>

  
</body>

</html>
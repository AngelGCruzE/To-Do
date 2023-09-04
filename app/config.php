<?php

// VERIFICAMOS SI HAY UNA SESION INICIADA
session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
  // SI NO HAY SESION INICIADA LO REDIRIGIMOS A LOGIN
  header("Location: userLyS.php");
  exit();
}

// INCLUIMOS LA CONEXION A LA BASE DE DATOS,ADEMAS DE LAS FUNCIONES QUE EJECUTAN CAMBIOS EN LA APP
require '../functions/actions.php';
require '../functions/db.php';


?>


<!DOCTYPE html>
<html>

<head>
  <title>App TO-DO</title>
  <link rel="stylesheet" type="text/css" href="../app/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>
<header>
  <img class="logo" src="../app/img/Logo_horizontal-removebg-preview.png">
  <!-- IMPRIMIMOS NOMBRE DEL USUARIO EN LA SESION -->
  <div class="opBar">
  <h1 class="userNameSty"><?php echo $_SESSION['username']; ?></h1>
  <a class="bckbtn" href="../app/index.php"><img class="bkbtn" src="../app/img/flecha-izquierda.png"></a>
  </div>
</header>

<body>



</body>

</html>
<?php

require 'db.php';


//metodo para añadir tarea
function createTask($task, $user_id){
  global $conn;

  $sql = "INSERT INTO todos (user_id, task, state) VALUES ('$user_id', '$task', 'PENDING')";
  $state = $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS

  if($state){
    // echo "<script>alert('Tarea Agregada');</script>";
  }
}

//actualizar estatus de la tarea TENIENDO EL ID DE LA TAREA Y EL ESTATUS DE LA TAREA ACTUALIZADO
function updateTask($task_id,$state){
  global $conn;

  $sql = "UPDATE todos SET state = '$state' WHERE id = $task_id";
  $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS

}

// ELIMINAR TODAS LAS TAREAS POR MEDIO DEL ID DEL USUARIO
function deleteTasks($user_id){
  global $conn;

  $sql = "DELETE FROM `tasks`.`todos` WHERE user_id = $user_id";
  $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS
  
}

// INICIAMOS SESION POR MEDIO DEL USUARIO Y CONTRASEÑA 
function login($user, $password){
  global $conn;

  $sql = "SELECT * FROM `tasks`.`users` WHERE username = '$user' AND pass = '$password'";
  $result = $conn->query($sql);
    
  // SI EL NUMERO DE REGISTROS ES CERO ENTONCES NO HAY PERSONAS CON EL USUARIO Y CONTRASEÑA
  if ($result->num_rows == 0) {
    return false;
  } else {
    // CASO CONTRARIO QUIERE DECIR QUE SI HAY ALGUIEN CON ESOS DATOS, OBTENEMOS EL NOMBRE DE USUARIO Y SU ID.
    $row = $result->fetch_assoc();
    $username = $row['username']; // Obtener el valor de la columna "username"
    $id = $row['id'];
    // GUARDAMOS LA SESION DEL USUARIO
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $id;

    // LO REDIRIGIMOS A LA APLICACION
    header("Location: index.php");

    return true;
  }
}

// METODO PARA REGISTRARME EN LA APLICACION
function signup($user, $password){
  global $conn;

  $sql = "SELECT * FROM `tasks`.`users` WHERE username = '$user'";
  $result = $conn->query($sql);
    
  // SI YA EXISTE UNA PERSONA CON EL MISMO USUARIO ENTONCES EL USUARIO ES INAVLIDO Y TIENE QUE PONER OTRO
  if ($result->num_rows == 1) {
    return false;
  } else if ($result->num_rows == 0){
    // SI NO HAY NINGUMO EL NOMBRE DE USUARIO ESTA DISPONIBLE Y ASIGNAMOS LAS CREDENCIALES
    $sql = "INSERT INTO users (username, pass) VALUES ('$user', '$password')";
    $state = $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS
    // LO REDIRIGIMOS A INICIO DE SESION
    if($state){
      header("Location: login.php");
    }

    return true;
  }else{
    return false;
  }
}




?>

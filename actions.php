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

//actualizar estatus de la tarea
function updateTask($task_id,$state){
  global $conn;

  $sql = "UPDATE todos SET state = '$state' WHERE id = $task_id";
  $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS

}


function deleteTasks($user_id){
  global $conn;

  $sql = "DELETE FROM `tasks`.`todos` WHERE user_id = $user_id";
  $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS
  
}

function login($user, $password){
  global $conn;

  $sql = "SELECT * FROM `tasks`.`users` WHERE username = '$user' AND pass = '$password'";
  $result = $conn->query($sql);
    
  if ($result->num_rows == 0) {
    return false;
  } else {
    $row = $result->fetch_assoc();
    $username = $row['username']; // Obtener el valor de la columna "username"
    $id = $row['id'];

    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $id;

    header("Location: index.php");

    return true;
  }
}


function signup($user, $password){
  global $conn;

  $sql = "SELECT * FROM `tasks`.`users` WHERE username = '$user'";
  $result = $conn->query($sql);
    
  if ($result->num_rows == 1) {
    return false;
  } else if ($result->num_rows == 0){

    $sql = "INSERT INTO users (username, pass) VALUES ('$user', '$password')";
    $state = $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS
    if($state){
      header("Location: login.php");
    }

    return true;
  }else{
    return false;
  }
}




?>

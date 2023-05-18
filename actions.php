<?php
require 'db.php';


//metodo para añadir tarea
function createTask($task){
  global $conn;

  $sql = "INSERT INTO todos (user_id, task, state) VALUES (1, '$task', 'PENDING')";
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


function deleteTasks(){
  global $conn;

  $sql = "TRUNCATE TABLE `tasks`.`todos`";
  $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS
  
}




?>

<?php
require 'db.php';

// session_start();
// if (!isset($_SESSION['username'])) {
//   header("Location: login.php");
//   exit();
// }

// require 'db.php';


function addTasks($task){
  // $user_id = $_SESSION['user_id'];
  global $conn;

  $sql = "INSERT INTO todos (user_id, task, state) VALUES (1, '$task', 'PENDING')";
  $state = $conn->query($sql);

  if($state){
    // echo "<script>alert('Tarea Agregada');</script>";
  }



}

function updateTask($task_id,$state){
  global $conn;
  

  $sql = "UPDATE todos SET state = '$state' WHERE id = $task_id";
  $conn->query($sql);

}




?>

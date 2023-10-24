<?php

require '../functions/db.php';

function createTask($task, $fecha, $user_id){
  global $conn;
  if (empty(trim($task)) || empty(trim($fecha)) || empty(trim($user_id))) {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Error",
        text: "Por favor, completa todos los campos antes de registrar la tarea.",
    });
    </script>';
    return;
  }
  $sql = "INSERT INTO todos (user_id, task, state, fecha) VALUES (?, ?, 'PENDING', ?)";
  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param("iss", $user_id, $task, $fecha);
    $result = $stmt->execute();

    if ($result) {
      echo '<script>
      Swal.fire({
          icon: "success",
          title: "Genial !!!",
          text: "Tu tarea fue registrada exitosamente",
      });
      </script>';
    } else {
      echo '<script>
      Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo registrar la tarea. Por favor, inténtalo de nuevo.",
      });
      </script>';
    }
  } else {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error en la consulta SQL. Por favor, inténtalo de nuevo.",
    });
    </script>';
  }
}

function updateTask($task_id,$state){
  global $conn;
  $sql = "UPDATE todos SET state = '$state' WHERE id = $task_id";
  $conn->query($sql);
}

function deleteTasks($user_id){
  global $conn;

  $sql = "DELETE FROM `id21412201_tododb`.`todos` WHERE user_id = $user_id";
  $conn->query($sql);
  
}
function login($email, $password){
  global $conn;
  $sql = "SELECT id, email, username, pass FROM `id21412201_tododb`.`users` WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stored_password = $row['pass']; 
    if (password_verify($password, $stored_password)) {
session_start();
  $_SESSION['email'] = $row['email'];
  $_SESSION['username'] = $row['username'];
  $_SESSION['user_id'] = $row['id'];
  header("Location: index.php");
  return true;
} else {
  echo "<script>alert('Correo o contraseña incorrectos');</script>";
}
  }else{
    echo "<script>alert('Correo o contraseña incorrectos');</script>";
  }
  return false;
}
function signup($user, $email, $password){
  global $conn;
  $query_check_user = "SELECT * FROM `id21412201_tododb`.`users` WHERE email = ?";
  $stmt_check_user = $conn->prepare($query_check_user);
  $stmt_check_user->bind_param("s", $email);
  $stmt_check_user->execute();
  $result_check_user = $stmt_check_user->get_result();
  if ($result_check_user->num_rows > 0) {
    echo "<script>alert('Este correo ya fue registrado con otro usuario');</script>";
    return false;
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query_insert_user = "INSERT INTO users (username, email ,pass) VALUES (?, ?, ?)";
    $stmt_insert_user = $conn->prepare($query_insert_user);
    $stmt_insert_user->bind_param("sss", $user, $email, $hashed_password);
    $stmt_insert_user->execute();
    if ($stmt_insert_user->affected_rows === 1) {
      echo "<script>alert('Usuario registrado con exito');</script>";
      return true;
    } else {
      return false;
    }
  }
}



?>
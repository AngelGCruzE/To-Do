<?php

require '../functions/db.php';


//metodo para añadir tarea
function createTask($task, $user_id){
  global $conn;

  $sql = "INSERT INTO todos (user_id, task, state) VALUES ('$user_id', '$task', 'PENDING')";
  $state = $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS

  if($state){
     echo "<script>alert('Tarea Agregada');</script>"; // quite el comentario para que salga la alerta
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

// INICIAMOS SESION POR MEDIO DEL USUARIO Y CONTRASEÑA (segura contra sqli)
function login($user, $password){
  global $conn;

  // se prepara la consulta para evitar inyeccion
  $sql = "SELECT id, username, pass FROM `tasks`.`users` WHERE username = ?";
  $stmt = $conn->prepare($sql);

  // Vincula los parámetros y establece sus valores
  $stmt->bind_param("s", $user);

  // Ejecuta la consulta
  $stmt->execute();

  // Obtiene el resultado
  $result = $stmt->get_result();

  // verifica el usuario
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // llama la contraseña
    $stored_password = $row['pass']; 

    // verifica la contrasela
    if (password_verify($password, $stored_password)) {
      // inicia secion
      session_start();
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_id'] = $row['id'];

      // accede a la app 
      header("Location: index.php");
      return true;
    }else{
      echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Usuario o contraseña incorrectos!",
            });
          </script>';
    }
  }else{
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Usuario o contraseña incorrectos!",
            });
          </script>';
  }
  return false;
}

// METODO PARA REGISTRARME EN LA APLICACION
function signup($user, $password){
  global $conn;

  // valida el usuario con consulta preparada
  $query_check_user = "SELECT * FROM `tasks`.`users` WHERE username = ?";
  $stmt_check_user = $conn->prepare($query_check_user);
  $stmt_check_user->bind_param("s", $user);
  $stmt_check_user->execute();
  $result_check_user = $stmt_check_user->get_result();

  // Comprueba si ya existe un usuario con el mismo nombre
  if ($result_check_user->num_rows > 0) {
    echo "<script>alert('usuario existe');</script>";
    return false;
  } else {
    // Genera un hash 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // crea el usuario con la consulta prep
    $query_insert_user = "INSERT INTO users (username, pass) VALUES (?, ?)";
    $stmt_insert_user = $conn->prepare($query_insert_user);
    $stmt_insert_user->bind_param("ss", $user, $hashed_password);
    $stmt_insert_user->execute();

    // Comprueba si la inserción tuvo éxito
    if ($stmt_insert_user->affected_rows === 1) {
      // redirige al login si se registro bien
      header("Location: userLS.php");
      echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Usuario o contraseña incorrectos!",
            });
          </script>';/*ESTA CHINGADERA NO FUNCIONA*/
      return true;
    } else {
      return false;
    }
  }
}



?>

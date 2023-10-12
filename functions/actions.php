<?php

require '../functions/db.php';


//metodo para añadir tarea
function createTask($task, $fecha , $user_id){
  global $conn;

  $sql = "INSERT INTO todos (user_id, task, state, fecha) VALUES ('$user_id', '$task', 'PENDING', '$fecha' )";
  $state = $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS

  if($state){
    echo '<script>
    Swal.fire({
        icon: "",
        title: "Genial !!!",
        text: "Tu tarea fue registrada exitosamente",
    });
  </script>'; // quite el comentario para que salga la alerta
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

  $sql = "DELETE FROM `ToDoDatabase`.`todos` WHERE user_id = $user_id";
  $conn->query($sql); //EJECUTAR CONSULTA ALA BASE DE DATOS
  
}

// INICIAMOS SESION POR MEDIO DEL USUARIO Y CONTRASEÑA (segura contra sqli)
function login($email, $password){
  global $conn;

  // se prepara la consulta para evitar inyeccion
  $sql = "SELECT id, email, username, pass FROM `ToDoDatabase`.`users` WHERE email = ?";
  $stmt = $conn->prepare($sql);

  // Vincula los parámetros y establece sus valores
  $stmt->bind_param("s", $email);

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
      $_SESSION['email'] = $row['email'];
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
function signup($user, $email, $password){
  global $conn;

  // valida el usuario con consulta preparada
  $query_check_user = "SELECT * FROM `ToDoDatabase`.`users` WHERE email = ?";
  $stmt_check_user = $conn->prepare($query_check_user);
  $stmt_check_user->bind_param("s", $email);
  $stmt_check_user->execute();
  $result_check_user = $stmt_check_user->get_result();

  // Comprueba si ya existe un usuario con el mismo nombre
  if ($result_check_user->num_rows > 0) {
    echo "<script>alert('Correo Resgistrado');</script>";
    return false;
  } else {
    // Genera un hash 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // crea el usuario con la consulta prep
    $query_insert_user = "INSERT INTO users (username, email ,pass) VALUES (?, ?, ?)";
    $stmt_insert_user = $conn->prepare($query_insert_user);
    $stmt_insert_user->bind_param("sss", $user, $email, $hashed_password);
    $stmt_insert_user->execute();

    // Comprueba si la inserción tuvo éxito
    if ($stmt_insert_user->affected_rows === 1) {
      // redirige al login si se registro bien
      echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Usuario o contraseña incorrectos!",
            });
          </script>';/*ESTA CHINGADERA NO FUNCIONA*/
      header("Location: userLS.php");
      
      return true;
    } else {
      return false;
    }
  }
}



?>

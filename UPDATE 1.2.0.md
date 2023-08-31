# UPDATE 1.2.0

## Seguridad en el inicio de secion y al registrar cuentas 
#### Horas empleadas (1:15 de 2)
Como fue especificado en X archivo el sistema TO-DO tenia vulnerabilidades en el acceso a la aplicacion (singup/login) por lo que se tomaron medidas al respecto, las cuales fueron añadir 
sentencias sentencias preparadas en la consulta a la base de datos (para prevenir SQLi) , ademas de añadir la funciones de php "password_hash" y "password_verify" respectivamente, esto ya que anterior mente las contraseñas de los usuarios se guardaban directamente en la DB , ahora con esto la contraseña no es conocida masque por el usuario y el sistema solo funciona con hashes, a continuacion se mostraran los cambios realizados


---
Empezando por el login (funcion establecida en "actions.php") antes de la modificacion 

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
Ahora la funcion login con las mejoras incorporadas

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
        echo "<script>alert('contraseña mal');</script>";
        }
    }else{
        echo "<script>alert('usuario');</script>";
    }
    return false;
    }
---
Estas mejoras , como anteriormente lo mencionamos tambien fueron aplicadas a la seccion del registro de cuentas (funcion singup en "actions.php") y a continuacion mostraremos los cambios.

---
Funcion antes de las mejoras
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
---
Funcion login con mejoras incorporadas.

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
        echo "<script>alert('contraseña mal');</script>";
        }
    }else{
        echo "<script>alert('usuario');</script>";
    }
    return false;
    }
<?php
require 'db.php';
require 'actions.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>Inicia Sesión en TO-DO</title>
    
    <!-- ESTILOS PARA FORMULARIO -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px
        }

        input {
            padding: 5px;
            width: 70%;
            border: none;
            border-bottom: 1px solid #000;
        }

        button {
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bienvenido</h1>

        <!-- FORMULARIO PARA ENVIAR DATOS Y REGISTRARSE -->
        <form action="" method="POST">



            <input type="text" name="user" placeholder="USUARIO">
            <input type="password" name="password" placeholder="CONTRASEÑA">


            <button type="submit">Iniciar Sesión</button>
        </form>
        <!-- HIPERVINCULO PARA IR A REGISTRARME -->
        <a href="signup.php">Registarme</a>
        
        

        <?php
        // VERIFICAMOS SI LOS CAMPOS ESTAN ESTABLECIDOS PARA EJECUTAR LAS CONSULTAS EN LA BASE DE DATOS
        if (isset($_POST['user']) && isset($_POST['password'])) {
            //SI ESTAN ESTABLECIDOS VERIFICAMOS EN LA BASE DE DATOS
            login($_POST['user'], $_POST['password']);
        }

        ?>

</body>

</html>
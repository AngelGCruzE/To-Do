<?php
require 'db.php';
require 'actions.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>TO-DO App</title>

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


        <form action="" method="POST">



            <input type="text" name="user" placeholder="USUARIO">
            <input type="password" name="password" placeholder="CONTRASEÑA">


            <button type="submit">Iniciar Sesión</button>
        </form>
        <a href="signup.php">Registarme</a>
        
        

        <?php

        if (isset($_POST['user']) && isset($_POST['password'])) {
            login($_POST['user'], $_POST['password']);
        }

        ?>

</body>

</html>
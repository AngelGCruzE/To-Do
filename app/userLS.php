<?php
require '../functions/actions.php';
require '../functions/db.php';
                    if (isset($_POST['email']) && isset($_POST['password'])) {
                        login($_POST['email'], $_POST['password']);
                    }
                    if (isset($_POST['user']) && isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2'])) {
                        if ($_POST['password_1'] == $_POST['password_2']) {
                            signup($_POST['user'],$_POST['email'], $_POST['password_1']);
                        }else{
                            echo "<script>alert('Las contraseñas no son iguales');</script>";
                        }
                    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TO-DO</title>
    <link rel="stylesheet" type="text/css" href="../app/stylesLS.css">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
    <body>
        <div class="bodylg">
            <div class="main">
                <input type="checkbox" id="chk" aria-hidden="true">

                <div class="login">
                    <div class="logols"><img src="../app/img/logo_s.png"></div>
                    <form action="" method="POST">
                        <label class="labellg1" for="chk" aria-hidden="true">Login</label>
                        <input class="inputlg" type="email" name="email" placeholder="Correo" required="">
                        <input class="inputlg" type="password" name="password" placeholder="Contraseña" required="">
                        <button type="submit" class="buttonlg">Login</button>
                    </form>
                </div>
                <div class="signup">
                    <form action="" method="POST">
                        <label class="labellg" for="chk" aria-hidden="true">Sign up</label>
                        <input class="inputlg" type="text" name="user" placeholder="Usuario" required="">
                        <input class="inputlg" type="email" name="email" placeholder="Correo" required="">
                        <input class="inputlg" type="password" name="password_1" placeholder="Contraseña" required="">
                        <input class="inputlg" type="password" name="password_2" placeholder="Confirme Contraseña" required="">
                        <button type="submit" class="buttonlg">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        ?>
</body>
</html>
<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: login.php");
exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/master.css">
        <link rel="stylesheet" href="css/aos.css">
        <link rel="stylesheet" href="iconfont/material-icons.css">
        <link href="css/datepicker.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/aos.js"></script>
        <script type="text/javascript" src="js/anime.min.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.arctext.js"></script>
        <script type="text/javascript" src="js/Chart.bundle.min.js"></script>
        <script type="text/javascript" src="js/Myjs.js"></script>
        <title>Perfil</title>
    </head>
    <body>
        <header class="encabezado">
            <div id="slideit">
                <div id="dimmer">
                    <div class="container-header" >
                        <hr id="top">
                        <h2 class="titulos" id="titu1">UREE en Edificios Públicos</h2>
                        <div id="svg">
                            <i class="material-icons">brightness_7</i>
                            <i class="material-icons" id="sol-mid">brightness_7</i>
                            <i class="material-icons">brightness_7</i>
                        </div>
                        <h3 class="titulos">Administración de Perfil</h3><br>
                        <h3 class="titulos">Hola <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h3><br>
                        <p>En éste sitio puede administrar los dispositivos que tiene registrados<br>
                        y modificar los datos de su cuenta.</p><br><hr>
                        <p class="botones_index">
                            <a href="resetear_pass.php" id="botoni_1">Modificar la Contraseña</a>
                            <a href="dispositivos.php" id="botoni_2">Administrar Dispositivos</a>
                            <a href="inicio.php" id="botoni_3">Volver a la página principal</a>
                        </p>
                    </div>
                </div>
            </div>
        </header>
    </body>
</html>
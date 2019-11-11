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
        <title>Inicio</title>
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
                        <h3 class="titulos">Bienvenido <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h3><br>
                        <p>UREE es un proyecto que tiene como objetivo el uso de la energía <br>
                            de forma consciente y la reducción del consumo con el motivo de <br>
                        reducir el gasto enegético y proteger el medio ambiente.</p><br><hr>
                        <p class="botones_index">
                            <a href="logout.php" id="botoni_1">Logout</a>
                            <a href="perfil.php" id="botoni_2">Administrar Perfil</a>
                            <a href="sensores.php" id="botoni_3">Monitoreo de datos</a>
                        </p>
                    </div>
                </div>
            </div>
        </header>
    </body>
</html>
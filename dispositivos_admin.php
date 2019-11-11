<?php
// Initialize the session
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["username"]!=='admin'){
header("location: login.php");
exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dispositivos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <style type="text/css">
        .wrapper{
        width: 650px;
        margin: 0 auto;
        }
        .page-header h2{
        margin-top: 0;
        }
        table tr td:last-child a{
        margin-right: 15px;
        }
        </style>
        <script type="text/javascript">
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
    </head>
    <body><br><br><br>
                        <a href="inicio.php" class="btn btn-success" style="margin-left: 650px">Regresar a la página principal</a><br><br><br>
                        <a href="set_potencia.php" class="btn btn-success" style="margin-left: 650px">Asignar potencia maxima</a>
           

    </body>
</html> 
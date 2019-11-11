<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: login.php");
exit;
}
if($_SESSION["username"]=='admin'){
    header("location:dispositivos_admin.php");
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
    <body>
        <div class="wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Detalle de los Dispositivos</h2>
                            <a href="crear.php" class="btn btn-success pull-right">Agregar un nuevo dispositivo</a>
                        </div>
                        <?php
                        require_once "config.php";
                        $aux=$_SESSION["username"];
                        // Attempt select query execution
                        $sql = "SELECT nombre, dispositivo, id_equipo FROM Equipos WHERE nombre='$aux';";
                        if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Nombre</th>";
                                    echo "<th>Equipo</th>";
                                    echo "<th>Id</th>";
                                    echo "<th>Eliminar</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                    echo "<td>" . $row['nombre'] . "</td>";
                                    echo "<td>" . $row['dispositivo'] . "</td>";
                                    echo "<td>" . $row['id_equipo'] . "</td>";
                                    echo "<td>";
                                       echo "<a href='delete.php?id=". $row['id_equipo'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "</td>";
                                echo "</tr>";
                                }
                            echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                        } else{
                        echo "<p class='lead'><em>No se encontraron registros.</em></p>";
                        }
                        } else{
                        echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
                        }
                        
                        // Close connection
                        mysqli_close($link);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <a href="inicio.php" class="btn btn-success pull-right">Regresar a la página principal</a>
                </div>
                
            </div>
        </div>
    </body>
</html>
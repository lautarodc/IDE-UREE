<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CorrienteESP</title>
        <style media="screen">
        @font-face {
        font-family: Source Sans Pro;
        src: url(../Fonts/SourceSansPro-Regular.ttf);
        }
        * {font-family: font-family: 'Source Sans Pro', sans-serif;
        color: black;text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.2rem;
        font-size: 0.8rem;
        line-height: 2;}
        hr {height: 1px; background-color: rgba(0,0,0,0.9); border:none;width: 60%;}
        </style>
    </head>
    <body>
        <?php
        if(!empty($_GET["oficina"]) && !empty($_GET["temperatura"]) && !empty($_GET["humedad"])){
        
        $oficina=$_GET["oficina"];
        $temperatura=$_GET["temperatura"];
        $humedad=$_GET["humedad"];
        
        require_once "../config.php";
        
        $sqlcrearambiente="CREATE TABLE IF NOT EXISTS Ambiente(id int NOT NULL AUTO_INCREMENT,oficina varchar(255) NOT NULL , temperatura varchar(255) NOT NULL,humedad varchar(255) NOT NULL, DataDate DateTime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
        
        if (mysqli_query($link, $sqlcrearambiente)) {
        } else {
        echo "Error: <br>" . mysqli_error($link);
        }
        $sqlcargarambiente="INSERT INTO Ambiente (oficina, temperatura, humedad) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sqlcargarambiente)){
        mysqli_stmt_bind_param($stmt, "sss", $param_oficina, $param_temperatura, $param_humedad);
        // Set parameters
        $param_oficina = $oficina;
        $param_temperatura =$temperatura;
        $param_humedad=$humedad;
        if(mysqli_stmt_execute($stmt)){
        } else{
        echo "Ha ocurrido un error por favor intente nuevamente.";
        }
        }
        mysqli_stmt_close($stmt);
        

        
        mysqli_close($link);
        
        }else{
        echo "Error con los datos enviados";
        }
        
        ?>
    </body>
</html>
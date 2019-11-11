<?php
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: login.php");
exit;
}
// Include config file
require_once "config.php";
$sql_crear="CREATE TABLE IF NOT EXISTS PotAdmin(index_reg int NOT NULL AUTO_INCREMENT, potencia_max varchar(255),PRIMARY KEY (index_reg));";
if(mysqli_query($link, $sql_crear)){
}
else{
    echo "ocurrio un error con la tabla";
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_potencia = trim($_POST["potencia"]);
    if(empty($input_potencia)){
        $potencia_err = "Por favor ingrese la potencia.";
    }else{
        $potencia = $input_potencia;
    }
        if(empty($potencia_errn)){
        // Prepare an insert statement
        $sql = "INSERT INTO PotAdmin (potencia_max) VALUES (?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_pot);
            
            // Set parameters
            $param_pot = $potencia;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: dispositivos.php");
                exit();
            } else{
                echo "Ha ocurrido un error. Intentar nuevamente más tarde";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);



}
?>
 
<!DOCTYPE html>
<html lang>
<head>
    <meta charset="UTF-8">
    <title>Potencia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Asignar potencia limite</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <input type="text" name="potencia" class="form-control">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="dispositivos.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
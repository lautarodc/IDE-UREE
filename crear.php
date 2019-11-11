<?php
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: login.php");
exit;
}
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$equipo = $id_equipo ="";
$equipo_err = $id_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_equipo = trim($_POST["equipo_reg"]);
    if(empty($input_equipo)){
        $equipo_err = "Por favor ingrese el nombre del equipo.";
    }else{
        $equipo = $input_equipo;
    }
    
    // Validate address
    $input_id = trim($_POST["id_reg"]);
    if(empty($input_id)){
        $id_err = "Por favor ingrese un id válido.";     
    } else{
        $id_equipo = $input_id;
    }

    // Check input errors before inserting in database
    if(empty($equipo_err) && empty($id_err)){
        $aux=$_SESSION["username"];
        // Prepare an insert statement
        $sql = "INSERT INTO Equipos (nombre, dispositivo, id_equipo) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_equipo, $param_id);
            
            // Set parameters
            $param_name = $aux;
            $param_equipo = $equipo;
            $param_id = $id_equipo;
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
    <title>Crear Equipo</title>
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
                        <h2>Agregar Equipo</h2>
                    </div>
                    <p>Por favor completar el formulario para agregar un nuevo equipo a su cuenta.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nombre del equipo</label>
                            <input type="text" name="equipo_reg" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Id del equipo</label>
                            <input type="text" name="id_reg" class="form-control">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dispositivos.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
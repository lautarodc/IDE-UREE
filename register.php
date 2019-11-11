<?php
// Include config file
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'corriente');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sql_crear="CREATE TABLE IF NOT EXISTS Usuarios(index_reg int NOT NULL AUTO_INCREMENT,nombre varchar(50) NOT NULL,contrasena varchar(255) NOT NULL,oficina varchar(255),imagen varchar(255),PRIMARY KEY (index_reg));";
$sql_crear2="CREATE TABLE IF NOT EXISTS Equipos(index_reg int NOT NULL AUTO_INCREMENT,nombre varchar(50) NOT NULL, dispositivo varchar(255),id_equipo varchar(255), PRIMARY KEY (index_reg));";
if(mysqli_query($link, $sql_crear)){
}else{
    echo "ocurrio un error con la tabla";
}
if(mysqli_query($link, $sql_crear2)){
}else{
    echo "ocurrio un error con la tabla";
}

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

// Validate username
if(empty(trim($_POST["username"]))){
$username_err = "Por favor ingrese un usuario.";
} else{
// Prepare a select statement
$sql = "SELECT index_reg FROM Usuarios WHERE nombre = ?";
if($stmt = mysqli_prepare($link, $sql)){
// Bind variables to the prepared statement as parameters
mysqli_stmt_bind_param($stmt, "s", $param_username);
// Set parameters
$param_username = trim($_POST["username"]);
// Attempt to execute the prepared statement
if(mysqli_stmt_execute($stmt)){
/* store result */
mysqli_stmt_store_result($stmt);
if(mysqli_stmt_num_rows($stmt) > 0){
$username_err = "El nombre de usuario ya se ha utilizado.";
} else{
$username = trim($_POST["username"]);
}
} else{
echo "Ha ocurrido un error con el Formulario. Intente nuevamente más tarde.";
}
}
// Close statement
mysqli_stmt_close($stmt);
}
// Validate password
if(empty(trim($_POST["password"]))){
$password_err = "Por favor ingrese una contrasena.";
} elseif(strlen(trim($_POST["password"])) < 8){
$password_err = "La contrasena debe tener al menos 8 caracteres.";
} else{
$password = trim($_POST["password"]);
}
// Validate confirm password
if(empty(trim($_POST["confirm_password"]))){
$confirm_password_err = "Por favor confirme la contrasena.";
} else{
$confirm_password = trim($_POST["confirm_password"]);
if(empty($password_err) && ($password != $confirm_password)){
$confirm_password_err = "Las contrasenas no coinciden.";
}
}
$oficina_entrada=trim($_POST["oficina"]);
$imagen_subida=$_FILES["image"]["name"];
$nombre_imagen="imagenes/".$imagen_subida;
move_uploaded_file($_FILES["image"]["tmp_name"],$nombre_imagen);



// Check input errors before inserting in database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
// Prepare an insert statement
$sql = "INSERT INTO Usuarios (nombre, contrasena, oficina, imagen) VALUES (?, ?, ?, ?)";
if($stmt = mysqli_prepare($link, $sql)){
// Bind variables to the prepared statement as parameters
mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_oficina, $param_imagen);
// Set parameters
$param_username = $username;
$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
$param_oficina=$oficina_entrada;
$param_imagen=$nombre_imagen;
// Attempt to execute the prepared statement
if(mysqli_stmt_execute($stmt)){
// Redirect to login page
header("location: login.php");
} else{
echo "Ha ocurrido un error por favor intente nuevamente.";
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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registro de Usuarios</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Registro de Usuarios</h2>
            <p>Por favor complete el formulario para crear un Usuario</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype='multipart/form-data'>
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Nombre</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Ingrese el número de oficina</label>
                    <input type="text" name="oficina" class="form-control">
                </div>
                <div class="form-group">
                    <label>Ingrese la foto con la que se identificará</label>
                    <input type="file" name="image">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                    <input type="reset" class="btn btn-default" value="Resetear">
                </div>
                <p>Ya tiene una cuenta? <a href="login.php">Acceda desde aquí</a>.</p>
            </form>
        </div>
    </body>
</html>
    <?php
    date_default_timezone_set('America/Argentina/Mendoza');
    echo date('j');

    if(!empty($_GET["id_equipo"]) && !empty($_GET["energia"]) && !empty($_GET["potencia"])){
    $energia=$_GET["energia"];
    $equipo=$_GET["id_equipo"];
    $potencia=$_GET["potencia"];
    require_once "../config.php";
    $sqlcrearenergia="CREATE TABLE IF NOT EXISTS Energia(id int NOT NULL AUTO_INCREMENT,id_equipo varchar(255) NOT NULL , energia varchar(255) NOT NULL,energia_inst varchar(255),potencia varchar(255) NOT NULL, DataDate DateTime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
    if (mysqli_query($link, $sqlcrearenergia)) {
    } else {
    echo "Error: <br>" . mysqli_error($link);
    }
    $dia_actual=date('d');
    $sqlvaloranterior="SELECT energia FROM Energia WHERE id_equipo='$equipo' AND day(DataDate)='$dia_actual' ORDER BY id desc LIMIT 1;";
    if ($result=mysqli_query($link, $sqlvaloranterior)) {
    } else {
    echo "Error: <br>" . mysqli_error($link);
    }
    $sqlcargarenergia="INSERT INTO Energia (id_equipo, energia,energia_inst, potencia) VALUES (?,?,?,?)";
    if($stmt = mysqli_prepare($link, $sqlcargarenergia)){
    mysqli_stmt_bind_param($stmt, "ssss", $param_idequipo, $param_energia, $param_energia_inst, $param_potencia);

    if (mysqli_num_rows($result)>0) {
        $energia_ant=mysqli_fetch_assoc($result);
        $energia_ant=$energia_ant['energia'];
    }else{
        $energia_ant=0;
    }
    $energia_inst_actual=0;
    if ($energia<$energia_ant) {
        $energia_inst_actual=$energia;
        $param_idequipo = $equipo;
        $param_energia =$energia+$energia_ant;
        $param_energia_inst=$energia_inst_actual;
        $param_potencia=$potencia;
    }else{
        $energia_inst_actual=$energia-$energia_ant;
        $param_idequipo = $equipo;
        $param_energia =$energia;
        $param_energia_inst=$energia_inst_actual;
        $param_potencia=$potencia;        
    }
    // Set parameters
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

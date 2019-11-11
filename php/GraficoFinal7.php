<?php
// Setting header to json
header('Content-Type: application/json');
// Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');

date_default_timezone_set('America/Argentina/Mendoza');
$nombre = $_REQUEST["nombre"];
$dia=date('d');
$mes=date('m');
$anho=date('Y');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}


$query ="SELECT SUM(energia_inst) AS 'Energia', dispositivo FROM equipos INNER JOIN energia ON (energia.id_equipo=equipos.id_equipo) AND (energia.DataDate>'$anho-$mes-1 00:00:00') AND (energia.DataDate<NOW()) INNER JOIN usuarios ON (usuarios.nombre=equipos.nombre) AND (usuarios.nombre='$nombre') GROUP BY dispositivo;";



// Query to get data from the table
$result = $mysqli->query($query);
$data = array();
// Loop through the returned data
$suma=0;


while($row=$result->fetch_array()){
	$data[]=$row;
	$suma=$suma+$row['Energia'];
}

$i=0;
while($row=$result->fetch_array()){
	$data[$i]['Energia']=($data[$i]['Energia']/$suma)*100;
	$i=$i+1;
}


// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>

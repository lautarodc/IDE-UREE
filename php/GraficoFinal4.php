<?php
// Setting header to json
header('Content-Type: application/json');
// Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');

$nombre = $_REQUEST["nombre"];
date_default_timezone_set('America/Argentina/Mendoza');
$anho=date('Y');


$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
$query_mes="SET lc_time_names = 'es_AR';";
$res=$mysqli->query($query_mes);

$query ="SELECT SUM(energia_inst) AS 'Energia', MONTHNAME(DataDate)  AS 'fecha'
FROM equipos INNER JOIN energia ON (energia.id_equipo=equipos.id_equipo) INNER JOIN usuarios ON (usuarios.nombre=equipos.nombre) AND (usuarios.nombre='$nombre') GROUP BY MONTH(DataDate);";

// Query to get data from the table
// Execute query
$result = $mysqli->query($query);
$data = array();
// Loop through the returned data
while($row=$result->fetch_assoc()){
	$data[]=$row;
}
// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>

<?php
// Setting header to json
header('Content-Type: application/json');
// Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'corriente');

$ini = $_REQUEST["ini"];
$fini = $_REQUEST["fini"];
$nombre = $_REQUEST["nombre"];

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

if(empty($_REQUEST["ini"]) || empty($_REQUEST["fini"])){
	$query = "SELECT SUM(energia_inst) AS 'Energia',DataDate AS 'fecha'
FROM equipos INNER JOIN energia ON (energia.id_equipo=equipos.id_equipo) INNER JOIN usuarios ON (usuarios.nombre=equipos.nombre) and (usuarios.nombre='$nombre')
GROUP BY UNIX_TIMESTAMP(fecha) DIV 300";
}else {
	$query ="SELECT SUM(energia_inst) AS 'Energia',DataDate AS 'fecha'
FROM equipos INNER JOIN energia ON (energia.id_equipo=equipos.id_equipo) INNER JOIN usuarios ON (usuarios.nombre=equipos.nombre) and (usuarios.nombre='$nombre')
GROUP BY UNIX_TIMESTAMP(fecha) DIV 300
HAVING fecha BETWEEN '$ini 00:00:00' AND '$fini 23:59:59'";
}
// Query to get data from the table
// Execute query
$result = $mysqli->query($query);
// Loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>

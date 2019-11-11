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
$dia=date('d');
$mes=date('m');
$anho=date('Y');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
$query ="SELECT SUM(energia_inst) AS 'Energia',DataDate AS 'fecha'
FROM equipos INNER JOIN energia ON (energia.id_equipo=equipos.id_equipo) INNER JOIN usuarios ON (usuarios.nombre=equipos.nombre) and (usuarios.nombre='$nombre')
GROUP BY UNIX_TIMESTAMP(fecha) DIV 30
HAVING fecha BETWEEN '$anho-$mes-$dia 00:00:00' AND NOW()";

// Query to get data from the table
// Execute query
$result = $mysqli->query($query);
$data = array();
// Loop through the returned data
while($row=$result->fetch_assoc()){
	$data[]=$row;
}
for($i=0;$i<count($data);$i++) { 
	if ($i!=0) {
		$data[$i]['Energia']=$data[$i]['Energia']+$data[$i-1]['Energia'];
	}
}

// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>

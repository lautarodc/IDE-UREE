<?php
// Setting header to json
header('Content-Type: application/json');
// Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');
$anho=date('Y');
$mes=date('m');
$dia=date('d');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

$query_max="SELECT potencia_max AS 'Potencia_max' FROM PotAdmin ORDER BY index_reg DESC LIMIT 1;";
$res2=$mysqli->query($query_max);
while ($row=$res2->fetch_assoc()) {
	$Potencia_max=$row['Potencia_max'];
}

$query = "SELECT SUM(potencia) AS 'Potencia',DataDate AS 'fecha'
FROM energia WHERE DataDate BETWEEN '$anho-$mes-1 00:00:00' AND NOW() GROUP BY UNIX_TIMESTAMP(fecha) DIV 900";

// Query to get data from the table
// Execute query
$result = $mysqli->query($query);
$data = array();
// Loop through the returned data
$i=0;
while($row=$result->fetch_assoc()){
	$data[$i]['Potencia']=$row['Potencia'];
	$data[$i]['Potencia_max']=$Potencia_max;
	$data[$i]['fecha']=$row['fecha'];
	$i=$i+1;
}



// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>

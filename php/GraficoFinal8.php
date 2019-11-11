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

function linear_regression( $x, $y ) {
 
    $n     = count($x);     
    $x_sum = array_sum($x); 
    $y_sum = array_sum($y);
 
    $xx_sum = 0;
    $xy_sum = 0;
 
    for($i = 0; $i < $n; $i++) {
        $xy_sum += ( $x[$i]*$y[$i] );
        $xx_sum += ( $x[$i]*$x[$i] );
    }
 
    // Slope
    $slope = ( ( $n * $xy_sum ) - ( $x_sum * $y_sum ) ) / ( ( $n * $xx_sum ) - ( $x_sum * $x_sum ) );
 
    // calculate intercept
    $intercept = ( $y_sum - ( $slope * $x_sum ) ) / $n;
 
    return array( 
        'slope'     => $slope,
        'intercept' => $intercept,
    );
}

$query ="SELECT SUM(energia_inst) AS 'Energia',DataDate AS 'fecha'
FROM equipos INNER JOIN energia ON (energia.id_equipo=equipos.id_equipo) INNER JOIN usuarios ON (usuarios.nombre=equipos.nombre) and (usuarios.nombre='$nombre')
GROUP BY UNIX_TIMESTAMP(fecha) DIV 300
HAVING fecha BETWEEN '$anho-$mes-1 00:00:00' AND NOW();";



// Query to get data from the table
$result = $mysqli->query($query);
$data = array();
$tiempo_unix=array();
$tiempo_str=array();
$energia_act=array();
$energia_proy=array();
// Loop through the returned data
$i=0;
while($row=$result->fetch_array()){
	$tiempo_unix[$i]=strtotime($row['fecha']);
	$tiempo_str[$i]=$row['fecha'];
	$data[$i]['fecha']=$row['fecha'];
	if ($i==0) {
		$energia_act[$i]=$row['Energia'];
		$data[$i]['Energia_actual']=$row['Energia'];
		$data[$i]['proyeccion']=$row['Energia'];		
	} else {
		$energia_act[$i]=$row['Energia']+$energia_act[$i-1];
		$data[$i]['Energia_actual']=$row['Energia']+$energia_act[$i-1];
		$data[$i]['proyeccion']=$row['Energia']+$energia_act[$i-1];				
	}
	$i++;
}
$trend_array=linear_regression($tiempo_unix,$energia_act);
$mes=$mes+1;
$aux=new DateTime();
$aux->setDate($anho,$mes,1);
$aux->setTime(0,0,0);
$aux2=$aux->format('Y-m-d H:i:s');
$fin_mes=strtotime($aux2);
$diff=($fin_mes-$tiempo_unix[$i-1])/1500;
$data['slope']=$trend_array['slope'];
$data['intercept']=$trend_array['intercept'];
$data['diff']=$diff;
$data['fecha_fin']=$fin_mes;
$data['fecha_ini']=$tiempo_unix[$i-1];
$data['fecha_unix_ini']=$tiempo_str[$i-1];
$data['fecha_unix_fini']=date("Y-m-d H:i:s",$fin_mes);


for($j=$i;$j<($diff+$i);$j++){
	$tiempo_unix[$j]=$tiempo_unix[$j-1]+1500;
	$energia_act[$j] = ( $trend_array['slope'] * $tiempo_unix[$j] ) + $trend_array['intercept'];
    $energia_act[$j] = ( $energia_act[$j] <= 0 )? 0 : $energia_act[$j];
    $tiempo_str[$j]= date("Y-m-d H:i:s", $tiempo_unix[$j]);
    $data[$j]['fecha']=$tiempo_str[$j];
    $data[$j]['proyeccion']=$energia_act[$j];
}



// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>

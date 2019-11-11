<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');
$decimales = 1;
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
//OBTENCION DEL CONSUMO TOTAL DE LAS INSTALACIONES.
$query1 = "select SUM(energia_inst) FROM energia;";
$res = $mysqli->query($query1);
$contotal = $res->fetch_assoc();
$contotal = round($contotal['SUM(energia_inst)'], $decimales);
//OBTENCION DE LA CANTITADAD TOTAL DE OFICINAS, $MAXIMO SERA ESE NUMERO.
//$sql="select max(oficina) from usuarios;";
$sql="SELECT DISTINCT(oficina) AS 'Oficinas' FROM usuarios WHERE oficina IS NOT NULL;";
$res = $mysqli->query($sql);
$oficinas = array();
while($row=$res->fetch_assoc()){
	$ofi=$row['Oficinas'];
	if(empty($ofi)){
	}else{
			$query2 = "SELECT id_equipo AS 'Equipo' FROM usuarios INNER JOIN equipos ON (equipos.nombre=usuarios.nombre) AND (usuarios.oficina='$ofi') GROUP BY id_equipo, oficina;";
	$res2 = $mysqli->query($query2);
	$suma_energia=0;
	$oficinas_num[]=$ofi;
	while ($row_2 = $res2->fetch_assoc()) {
		$equipo=$row_2['Equipo'];
		$sql_equipo="SELECT SUM(energia_inst) AS 'Consumo' FROM energia WHERE id_equipo='$equipo';";
		$result=$mysqli->query($sql_equipo);
		$aux=$result->fetch_assoc();
		$aux=$aux['Consumo'];
		$suma_energia=$suma_energia+$aux;
	}
	$oficinas[] = round($suma_energia, $decimales);
	}
}
$porcentaje = array();
$data=[];
$i=0;
foreach ($oficinas as $row) {
	$data[$i]['Oficina']=$oficinas_num[$i];
	$asd = ($row/$contotal)*100;
	$porcentaje[] = round($asd, $decimales);
	$data[$i]['Porcentajes']=round($asd, $decimales);
	$i++;
}
//$data = $porcentaje;
$mysqli->close();
print json_encode($data);
?>
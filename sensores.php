<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: login.php");
exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--Todas las imagenes de fondo fueron libremente descargadas de https://www.pexels.com/ y https://unsplash.com/, Los iconos pertenecen a al Instituto de Energía y a EMESA.-->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="iconfont/material-icons.css">
    <link href="css/datepicker.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/aos.js"></script>
    <script type="text/javascript" src="js/anime.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.arctext.js"></script>
    <script type="text/javascript" src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/GraficoFinal.js"></script>
    <script type="text/javascript" src="js/Myjs.js"></script>
   <title>UREE</title>
  </head>
  <body>
    <header class="encabezado">
      <div id="slideit">
        <div id="dimmer">
          <div class="container-header" >
              <hr id="top">
              <h2 class="titulos" id="titu1">UREE en Edificios Públicos</h2>
              <div id="svg">
                <i class="material-icons">brightness_7</i>
                <i class="material-icons" id="sol-mid">brightness_7</i>
                <i class="material-icons">brightness_7</i>
              </div>
              <h3 class="titulos"> Auditoría y Cambio de Hábitos</h3><br>
              <p>UREE es un proyecto que tiene como objetivo el uso de la energía <br>
                 de forma consciente y la reducción del consumo con el motivo de <br>
                 reducir el gasto enegético y proteger el medio ambiente.</p><br><hr>
              <p class="botones">
                <a href="#intro" id="boton1">General</a>
                <a href="#work1" id="boton2">Consumo instantaneo</a>
                <a href="#work2" id="boton3">Consumo por dia</a>
                <a href="#work3" id="boton4">Consumo por semana</a>
                <a href="#work4" id="boton5">Consumo por mes</a>
                <a href="#work5" id="boton6">Consumo acumulado</a>
                <a href="#about" id="boton7">Humedad y Temperatura</a>
                <a href="#slideit" id="boton8" onclick="mail()">Contacto</a>
              </p>
           </div>
         </div>
      </div>
     </div>
    </header>


    <div class="grid-lista-canvas" id="intro">
      <div class="canvas">
        <h2 style="text-align : center;">DISTRIBICIÓN DE CONSUMOS<br><br></h2>
      </div>

      <div class="texto" >
        <div class="chiquito" >


          <?php
                define('DB_HOST', 'localhost');
                define('DB_USERNAME', 'maria');
                define('DB_PASSWORD', 'maria');
                define('DB_NAME', 'Corriente');
                $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                if(!$mysqli){
                  die("Connection failed: " . $mysqli->error);
                }

                $sqlmax="select count(nombre) from Usuarios;";
                $sqlcrear="select nombre, imagen from Usuarios order by nombre asc;";
                $res = $mysqli->query($sqlmax);
                $maximo = $res->fetch_assoc();
                $maximo = $maximo['count(nombre)'];
                $result = $mysqli->query($sqlcrear);

                $yourArray = array();

                $index = 0;
                while($row = $result->fetch_assoc()){
                     $yourArray[$index] = $row;
                     $index++;
                }
                $decimales=4;
                echo "<table>";
                $t1_1=mktime(0,0,0,date("m"),date("d"),date("Y"));
                $t1_2=mktime(0,0,0,date("m"),1,date("Y"));
                $t2_1=mktime(0,0,0,date("m")-1,date("d"),date("Y"));
                $t2_2=mktime(0,0,0,date("m")-1,1,date("Y"));
                for($i=0;$i<$maximo;$i++){
                  $variable=$yourArray[$i]['nombre'];
                  $sqldispositivo="SELECT id_equipo FROM equipos WHERE nombre='$variable';";
                  $res_equipo=$mysqli->query($sqldispositivo);
                  $num=mysqli_num_rows($res_equipo);                                    
                  if($num!==0){
                  echo "<tr>";
                  $variable=$yourArray[$i]['nombre'];
                  echo "<td>";
                  $imagen=$yourArray[$i]['imagen'];
                  //Modificacion propuesta de imagenes
                  echo "<img class='avatar' src='$imagen'>";
                  //
                  // Avatares aleatorios en base a numero generado aleatoriamente
                  // echo "<img class='avatar' src='avatares/avatar-$numero.png'>";
                  echo "</td>";
                  echo "<td>";
                  $variable = str_replace("_"," ","$variable");
                  echo $variable;
                  echo "</td>";
                  echo "<td>";
                  $array_equipo=array();
                  $index=0;
                  while ($row=$res_equipo->fetch_assoc()) {
                    $array_equipo[$index]=$row;
                    $index++;
                  }
                  $energia_actual=0;
                  $energia_anterior=0;
                  for ($j=0; $j <$index ; $j++) { 
                    $idequipo=$array_equipo[$j]['id_equipo'];
                    $sqlenergia_actual="SELECT SUM(energia_inst) AS 'Consumo' FROM Energia WHERE id_equipo='$idequipo' AND DataDate BETWEEN FROM_UNIXTIME($t1_2) AND FROM_UNIXTIME($t1_1);";
                    $sqlenergia_anterior="SELECT SUM(energia_inst) AS 'Consumo' FROM Energia WHERE id_equipo='$idequipo' AND DataDate BETWEEN FROM_UNIXTIME($t2_2) AND FROM_UNIXTIME($t2_1);";
                    $result1=$mysqli->query($sqlenergia_actual);
                    $consumo_actual=$result1->fetch_assoc();
                    $consumo_actual=$consumo_actual['Consumo'];
                    $result2=$mysqli->query($sqlenergia_anterior);
                    $consumo_anterior=$result2->fetch_assoc();
                    $consumo_anterior=$consumo_anterior['Consumo'];
                    $energia_actual=$energia_actual+$consumo_actual;
                    $energia_anterior=$energia_anterior+$consumo_anterior;
                  }
                  if ($energia_anterior==0) {
                    echo "------";
                    echo "</td>";
                  }else{
                  $porcentaje=(($energia_anterior-$energia_actual)/$energia_anterior)*100;
                  echo round($porcentaje,2);
                  echo "%";
                  echo "</td>";

                  if ($porcentaje<0){
                    echo "<td>";
                    echo "<img class='flecha' src='avatares/flecharoja.svg'>";
                    echo "</td>";
                  }
                  if ($porcentaje>0){
                    echo "<td>";
                    echo "<img class='flecha' src='avatares/flechaverde.svg'>";
                    echo "</td>";
                  }
                  if ($porcentaje==0){

                    echo "<td>";
                    echo "<img class='flecha' src='avatares/flechanegra.svg'>";
                    echo "</td>";
                  }
                  }
                  echo "</tr>";
                }
                }
                echo "</table>";

                $mysqli->close();
          ?>
        </div>

        <div class="flex-container">
        <a href="perfil.php" class="subir" class="flex-item">Perfil</a>
        <a href="./Gerais/gerais.php" class="subir" class="flex-item">Datos Generales</a>
        </div>


      </div>
      <div class="canvas" style="margin-top:80px">
        <canvas id="polar_1"></canvas>
      </div>
    </div>

 <!--Grafico de CONSUMO INSTANTANEO DE ENERGÍA-----------------------------------------------------------> 

<div class="grid-canvas-texto" id="work1">
   <div class="canvas">
      <h2 style="text-align : center;">CONSUMO INSTANTANEO DE ENERGÍA<br><br></h2>
    </div>

      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo de energía instantaneo.<br><br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre,
           posteriormente indique el intervalo de fechas que desee visulizar, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango1" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer1()">
             <a href="#work1" onclick="expand1()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli1 type="text" placeholder="p.e: 'Santiago Rivier'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda1();"></p>
            <p>fecha inicio: <input id=ini1 class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
            <p>fecha final: <input id=fini1 class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
            <button type="button" name="button" onclick="holanda1()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart1"></canvas>
      </div>
    </div>

    <!--Grafico de energia por dia en Kwh----------------------------------------------------------->

    <div class="grid-canvas-texto" id="work2">
       <div class="canvas">
      <h2 style="text-align : center;">CONSUMO DEL DÍA<br><br></h2>
</div>
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo de energia en Kwh por dia.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango2" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer2()">
             <a href="#work2" onclick="expand2()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli2 type="text" placeholder="p.e: 'Juan Ignacio Fernández'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda2();"></p>
            <button type="button" name="button" onclick="holanda2()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart2"></canvas>
      </div>
    </div>

    <!--Grafico de energia por semana en Kwh---------------------------------------------------------->

<div class="grid-canvas-texto" id="work3">
   <div class="canvas">
      <h2 style="text-align : center;">CONSUMO DE LA SEMANA<br><br></h2>
</div>
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo de energia en Kwh por semana.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango3" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer3()">
             <a href="#work3" onclick="expand3()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli3 type="text" placeholder="p.e: 'Lautaro Delgado'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda3();"></p>
            <button type="button" name="button" onclick="holanda3()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart3"></canvas>
      </div>
    </div>

    <!--Grafico de energia por mes en Kwh----------------------------------------------------------->

<div class="grid-canvas-texto" id="work4">
   <div class="canvas">
      <h2 style="text-align : center;">CONSUMO POR MES<br><br></h2>
      </div>
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo de energia en Kwh por mes.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango4" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer4()">
             <a href="#work4" onclick="expand4()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli4 type="text" placeholder="p.e: 'Santiago Rivier'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda4();"></p>
            <button type="button" name="button" onclick="holanda4()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart4"></canvas>
      </div>
    </div>

    <!--Grafico de energia acumulado hasta el momento en Kwh------------------------------------------>

<div class="grid-canvas-texto" id="work5">
   <div class="canvas">
      <h2 style="text-align : center;">CONSUMO ACUMULADO<br><br></h2>
   </div>
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo acumulado de energia, entre fecha y fecha.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre,
           posteriormente indique el intervalo de fechas que desee visulizar, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango5" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer5()">
             <a href="#work5" onclick="expand5()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli5 type="text" placeholder="p.e: 'Juan Ignacio Fernández'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda5();"></p>
            <p>fecha inicio: <input id=ini5 class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
            <p>fecha final: <input id=fini5 class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
            <button type="button" name="button" onclick="holanda5()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart5"></canvas>
      </div>
    </div>

  <!--Grafico de cons   umo acumulado del mes con proyeccion ----------------------------------->
<div class="grid-canvas-texto" id="work8">
   <div class="canvas">
      <h2 style="text-align : center;">CONSUMO MENSUAL ACUMULADO<br><br></h2>
   </div>
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo acumulado de energia del mes actual y una proyección hacia fin de mes.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre,
           posteriormente haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango8" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer8()">
             <a href="#work8" onclick="expand8()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli8 type="text" placeholder="p.e: 'Lautaro Delgado'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda8();"></p>
            <button type="button" name="button" onclick="holanda8()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart8"></canvas>
      </div>
    </div>
    <!--Grafico de distribucion de consumos --------------------------------------------------->

<div class="grid-canvas-texto" id="work7">
 <div class="canvas">
      <h2 style="text-align : center;">DISTRIBUCIÓN DE CONSUMOS ENTRE EQUIPOS<br><br></h2>
 </div>

      <div class="texto">
        
        <p style="text-align : left;">En esta sección puede visualizar la distribución de consumos entre electrodomésticos de un mismo usuario.<br><br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre,
           luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango7" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer7()">
             <a href="#work7" onclick="expand7()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>Usuario: <input id=oli7 type="text" placeholder="p.e: 'Santiago Rivier'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda7();"></p>
            <button type="button" name="button" onclick="holanda7()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart7"></canvas>
      </div>
    </div>

    <!--Grafico de humedad y temperatura-------------------------------------------------------------->

    <div class="grid-texto-canvas" id="about">
         <div class="canvas">
      <h2 style="text-align : center;">HUMEDAD Y TEMPERATURA<br><br></h2>
   </div>

      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de humedad y temperatura en su oficina.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y seleccione el número de oficina,
           posteriormente indique el intervalo de fechas que desee visulizar, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas" style="margin-top:80px">
        <div id="rango6" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer6()">
             <a href="#about" onclick="expand6()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
            <p>oficina: <input id=oli6 type="text" placeholder="p.e: '1'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda6();"></p>
            <p>fecha inicio: <input id=ini6 class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
            <p>fecha final: <input id=fini6 class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
            <button type="button" name="button" onclick="holanda6()">Procesar</button>
          </form>
        </div>
        <canvas id="myChart6" class="graficos-linea"></canvas>
      </div>
    </div>

  </body>
</html>

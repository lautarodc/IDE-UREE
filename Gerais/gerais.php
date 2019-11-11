<!doctype html>
<html lang="en" prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IDE: UREE </title>
    <meta name="description" content="UREE en EMESA. Una rápida referencia.">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,700,700i%7CMaitree:200,300,400,600,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="../static/css/base.css">
    <link rel="stylesheet" type="text/css" media="all" href="../static/css/colors.css">
    <link rel="stylesheet" type="text/css" media="all" href="../static/css/svg-icons.css">
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="../css/aos.css">
    <link rel="stylesheet" href="../iconfont/material-icons.css">
    <link href="../css/datepicker.css" rel="stylesheet" type="text/css"/>
    <!-- <script type="text/javascript" src="../js/jquery.min.js"></script> -->
    <script type="text/javascript" src="../js/jquery.js"></script>
    <!-- <script type="text/javascript" src="../js/Chart.bundle.min.js"></script> -->
    <script type="text/javascript" src="../js/Chart.bundle.js"></script>
    <link rel="shortcut icon" sizes="16x16" href="../static/images/favicons/favicon.png">
    <link rel="shortcut icon" sizes="32x32" href="../static/images/favicons/favicon-32.png">
    <link rel="apple-touch-icon icon" sizes="76x76" href="../static/images/favicons/favicon-76.png">
    <link rel="apple-touch-icon icon" sizes="120x120" href="../static/images/favicons/favicon-120.png">
    <link rel="apple-touch-icon icon" sizes="152x152" href="../static/images/favicons/favicon-152.png">
    <link rel="apple-touch-icon icon" sizes="180x180" href="../static/images/favicons/favicon-180.png">
    <link rel="apple-touch-icon icon" sizes="192x192" href="../static/images/favicons/favicon-192.png">
    <link rel="stylesheet" href="./master.css">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#333333">
  </head>
  <body>
    <main role="main">
      <article id="webslides">
        <!-- Quick Guide
        - Each parent <section> in the <article id="webslides"> element is an individual slide.
          - Vertical sliding = <article id="webslides" class="vertical">
            - <div class="wrap"> = container 90% / <div class="wrap size-50"> = 45%;
              -->
              <section class="bg-black aligncenter">
                <span class="background light" style="background-image:url('../imagenes/Fondo3.jpg')"></span>
                <div class="wrap">
                  <h1>UREE</h1>
                  <h4>Energizando a las personas</h4><br>
                  <p class="text-shadow">UREE es un proyecto que tiene como objetivo el uso de la energía <br>
                    de forma consciente y la reducción del consumo con el motivo de <br>
                  reducir el gasto enegético y proteger el medio ambiente.</p><br>
                  <a href="../sensores.php" class="subir">Inicio</a>
                </div>
                <!-- .end .wrap -->
              </section>
              <section class="aligncenter">
                <!--.wrap = container (width: 90%) with fadein animation -->
                <header>
                  <!--.wrap or <nav> = container 1200px -->
                  <div class="wrap">
                    <h2>Ranking de Usuarios</h2>
                    <p class="text-intro">Consumo dentro de la empresa.</p>
                  </div>
                </header>
                <div class="wrap">
                  <div class="grid">
                    <div class="column">
                      <script type="text/javascript">
                      </script>
                      <div class="grid-lista-canvas">
                        <div>
                          <div>
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
                                echo "<td>";
                                  $imagen=$yourArray[$i]['imagen'];
                                  //Modificacion propuesta de imagenes
                                  echo "<img class='avatar' src='../$imagen'>";
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
                                echo $porcentaje;
                                echo "%";
                              echo "</td>";
                              if ($porcentaje<0){
                              echo "<td>";
                                echo "<img class='flecha' src='.../avatares/flecharoja.svg'>";
                              echo "</td>";
                              }
                              if ($porcentaje>0){
                              echo "<td>";
                                echo "<img class='flecha' src='.../avatares/flechaverde.svg'>";
                              echo "</td>";
                              }
                              if ($porcentaje==0){
                              echo "<td>";
                                echo "<img class='flecha' src='.../avatares/flechanegra.svg'>";
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
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end .column -->
              </div>
              <!-- end .wrap -->
            </section>
            <section class="aligncenter">
              <!--.wrap = container (width: 90%) with fadein animation -->
              <header>
                <!--.wrap or <nav> = container 1200px -->
                <div class="wrap">
                  <h2>Ranking de Oficinas</h2>
                  <p class="text-intro">Porcentajes dentro de la empresa.</p>
                </div>
              </header>
              <div class="wrap">
                <div class="grid">
                  <div class="column">
                    <script type="text/javascript">
                    // Solicitud ajax para obtener consumod acumulados mensualmente.
                    $.ajax({
                    // Grafico polar para consumo por oficina
                    url : "../php/polar.php",
                    type : "GET",
                    success : function(data){
                    var porcentajes = [];
                    var oficinas = [];
                    var colores = [];
                    for(var i in data) {
                    porcentajes.push(data[i]['Porcentajes']);
                    oficinas.push(data[i]['Oficina']);
                    }
                    var lista = [
                    "rgba(54, 162, 235, 0.5)",
                    "rgba(255, 205, 86, 0.5)",
                    "rgba(75, 192, 192, 0.5)",
                    "rgba(255, 99, 132, 0.5)",
                    "rgba(153, 102, 255, 0.5)",
                    "rgba(201, 203, 207, 0.5)"
                    ];
                    var j = 0;
                    for (var i = 0; i < porcentajes.length; i++) {
                    colores[i] = lista[j++];
                    if (j==lista.length) {
                    j=0;
                    }
                    }
                    var config = {
                    data: {
                    datasets: [{
                    data: [
                    porcentajes[0]
                    ],
                    backgroundColor: [
                    colores[0]
                    ],
                    }],
                    labels: [
                    oficinas[0]
                    ]
                    },
                    type: 'pie',
                    options: {
                    responsive: true,
                    legend: {
                    position: 'right',
                    },
                    title: {
                    display: true,
                    text: 'Distribución de Consumos %'
                    },
                    animation: {
                    animateRotate: true,
                    animateScale: true
                    }
                    }
                    };
                    var ctx = $("#polar");
                    window.myPolarArea = new Chart(ctx, config);
                    j=1;
                    for (var i = 1; i < porcentajes.length; i++) {
                    if (config.data.datasets.length > 0) {
                    config.data.labels.push(oficinas[i]);
                    config.data.datasets.forEach(function(dataset) {
                    dataset.backgroundColor.push(lista[j++]);
                    dataset.data.push(porcentajes[i]);
                    if (j==lista.length) {
                    j=0;
                    }
                    });
                    }
                    }
                    window.myPolarArea.update();
                    },error : function(data) {}
                    });
                    </script>
                    <div class="grid-lista-canvas-polar">
                      <div class="canvas">
                        <canvas id="polar"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end .column -->
              </div>
              <!-- end .wrap -->
            </section>
            <section class="aligncenter">
              <!--.wrap = container (width: 90%) with fadein animation -->
              <header>
                <!--.wrap or <nav> = container 1200px -->
                <div class="wrap">
                  <h2>Consumo</h2>
                  <p class="text-intro">Potencia maxima dentro de la empresa.</p>
                </div>
              </header>
              <div class="wrap">
                <div class="grid">
                  <div class="column">
                    <script type="text/javascript">
                    $.ajax({
                    url : "../php/potencia.php",
                    type : "GET",
                    success : function(data) {
                    console.log(data);
                    //Adquisicion de datos.
                    var Potencia = [];
                    var Potencia_max = [];
                    var DataDate = [];
                    for(var i in data) {
                    Potencia.push(data[i].Potencia);
                    Potencia_max.push(data[i].Potencia_max);
                    DataDate.push(data[i].fecha);
                    }
                    var maximo_pot=Math.max.apply(null,Potencia);
                    var minimo_pot=Math.min.apply(null,Potencia);
                    var step_pot=(maximo_pot-minimo_pot)/5;
                    // Grafico de potencia
                    var chartdata = {
                    labels: DataDate,
                    datasets: [
                    {
                    label: "Potencia",
                    yAxisID:"Potencia",
                    fill: false,
                    backgroundColor: "rgba(255,99,132,1)",
                    borderColor: "rgba(255,99,132,1)",
                    pointHoverBackgroundColor: "rgba(255,99,132,1)",
                    cubicInterpolationMode: 'monotone',
                    pointRadius: 0.2,
                    pointHoverBorderColor: "rgba(255,99,132,1)",
                    data: Potencia
                    },
                    {
                    label: "Potencia Máxima",
                    yAxisID:"Potencia",
                    fill: false,
                    backgroundColor: "rgba(54, 162, 235, 1)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    pointRadius: 0.2,
                    cubicInterpolationMode: 'monotone',
                    pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
                    pointHoverBorderColor: "rgba(54, 162, 235, 1)",
                    data: Potencia_max
                    }
                    ]
                    };
                    var ctx = $("#potencia-lineal");
                    var LineGraph = new Chart(ctx, {
                    type: 'line',
                    data: chartdata,
                    options: {
                    scales: {
                    xAxes: [{
                    display: true,
                    scaleLabel: {
                    display: true
                    },
                    ticks: {
                    maxRotation: 0,
                    minRotation: 0,
                    fontColor: "#9a9ca5",
                    fontStyle: "bold",
                    autoSkip: true,
                    maxTicksLimit: 5
                    }
                    }],
                    yAxes: [{
                    position:"left",
                    type: "linear",
                    id:"Potencia",
                    ticks: {
                    fontColor: "rgba(59, 89, 152, 0.75)",
                    fontStyle: "bold",
                    stepSize:step_pot,
                    callback: function(label, index, labels) {
                    return label.toFixed(2)+'Kw';
                    }
                    }
                    },{
                    position:"left",
                    type: "linear",
                    id:"Potencia",
                    ticks: {
                    fontColor: "rgba(29, 202, 255, 0.75)",
                    fontStyle: "bold",
                    stepSize:step_pot,
                    callback: function(label, index, labels) {
                    return label.toFixed(2)+'Kw';
                    }
                    }
                    }]
                    }
                    }
                    });
                    },
                    error : function(data) {} });
                    </script>
                    <div class="grid-lista-canvas-potencia">
                      <div class="canvas">
                        <canvas id="potencia-lineal"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end .column -->
              </div>
              <!-- end .wrap -->
            </section>
          </article>
        </main>
        <!--main-->
        <!-- Required -->
        <script src="../static/js/webslides.js"></script>
        <script>
        window.ws = new WebSlides({ autoslide: 25000 });
        </script>
        <!-- OPTIONAL - svg-icons.js (fontastic.me - Font Awesome as svg icons) -->
        <script defer src="../static/js/svg-icons.js"></script>
      </body>
    </html>
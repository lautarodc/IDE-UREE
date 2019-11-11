$( function() {
	// Generacion del calendario
	$( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd",
	showAnim: "drop",
	showOtherMonths: true,
	selectOtherMonths: true,
	monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre","Octubre", "Noviembre", "Diciembre" ],
	dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
	prevText: "&lt;",
	nextText: "&gt;"
	});
});


function holanda6(){
	contraer6();
	// Creacion de formulario.
	var str = document.getElementById("oli6").value;
	var ini = document.getElementById("ini6").value;
	var fini = document.getElementById("fini6").value;
$.ajax({
	url : "php/GraficoFinal.php?q=" +str+"&ini=" +ini+"&fini=" +fini,
	type : "GET",

	success : function(data) {
		console.log(data);
		//Adquisicion de datos.
		var Temperatura = [];
		var Humedad = [];
		var DataDate = [];
		for(var i in data) {
			Temperatura.push(Math.round(data[i].Temp*100)/100);
			Humedad.push(Math.round(data[i].Hum*100)/100);
			DataDate.push(data[i].fecha);
		}
		var maximo_temp=Math.max.apply(null,Temperatura);
		var minimo_temp=Math.min.apply(null,Temperatura);
		var step_temp=(maximo_temp-minimo_temp)/5;
		var maximo_hum=Math.max.apply(null,Humedad);
		var minimo_hum=Math.min.apply(null,Humedad);
		var step_hum=(maximo_hum-minimo_hum)/5;	
		// Grafico de temperaturas por oficina
		var chartdata = {
			labels: DataDate,
			datasets: [
				{
					label: "Temperatura",
					yAxisID:"Temperatura",
					fill: false,
					backgroundColor: "rgba(255,99,132,1)",
					borderColor: "rgba(255,99,132,1)",
					pointHoverBackgroundColor: "rgba(255,99,132,1)",
					cubicInterpolationMode: 'monotone',
					pointRadius: 0.2,
					pointHoverBorderColor: "rgba(255,99,132,1)",
					data: Temperatura
				},
				{
					label: "Humedad",
					yAxisID:"Humedad",
					fill: false,
					backgroundColor: "rgba(54, 162, 235, 1)",
					borderColor: "rgba(54, 162, 235, 1)",
					pointRadius: 0.2,
					cubicInterpolationMode: 'monotone',
					pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
					pointHoverBorderColor: "rgba(54, 162, 235, 1)",
					data: Humedad
				}
			]
		};

		var ctx = $("#myChart6");
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
									id:"Temperatura",
									ticks: {
											fontColor: "rgba(59, 89, 152, 0.75)",
											fontStyle: "bold",
											stepSize:step_temp,
											callback: function(label, index, labels) {

												return label.toFixed(2)+'°C';
											}
									}
								},{
										position:"right",
										type: "linear",
										id:"Humedad",
										ticks: {
												fontColor: "rgba(29, 202, 255, 0.75)",
												fontStyle: "bold",
												stepSize:step_hum,
												callback: function(label, index, labels) {
																	return label.toFixed(2)+'%';

												}
										}
							}]
					}
				}
		});
	},
	error : function(data) {} }); }
		// Graficos de energia por individuo
		function holanda5(){
			contraer5();
			var str = document.getElementById("oli5").value;
			str = str.replace(" ","_");
			console.log(str);
			var ini = document.getElementById("ini5").value;
			var fini = document.getElementById("fini5").value;
		$.ajax({
			url : "php/GraficoFinal5.php?nombre=" + str + "&ini=" + ini + "&fini=" + fini,
			type : "GET",
			success : function(data){

				var energia = [];
				var DataDate = [];
				for(var i in data) {
					energia.push(data[i].Energia);
					DataDate.push(data[i].fecha);
				}
				var maximo=Math.max.apply(null,energia);
				var minimo=0;
				var step=(maximo-minimo)/5;

				var ctx2 = $("#myChart5");

				var myLineChart = new Chart(ctx2, {
				    type: 'line',
				    data: {
                labels: DataDate,
                datasets: [{
                    label: "Energía",
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderColor: "rgba(54, 162, 235, 0)",
										pointRadius: 0.1,
                    data: energia,
                    fill: 'origin',
                }]
            },
				    options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Consumo Energético'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
												showXLabels: 5,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Tiempo'
                        },
												ticks: {
														maxRotation: 0,
														minRotation: 0,
														fontColor: "#9a9ca5",
														fontStyle: "bold",
														maxTicksLimit: 5
												}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Energía'
                        },
												ticks: {
													fontColor: "#9a9ca5",
													fontStyle: "bold",
													suggestedMin: 0,
													stepSize:step,															
														callback: function(label, index, labels) {
																			return label.toFixed(2)+' kWh';
														}
												}
                    }]
                }
            }
				});
			},error : function(data) {}
		});
	}

		
		function holanda1(){
			contraer1();
			var str = document.getElementById("oli1").value;
			str = str.replace(" ","_");
			console.log(str);
			var ini = document.getElementById("ini1").value;
			var fini = document.getElementById("fini1").value;
		$.ajax({
			url : "php/GraficoFinal1.php?nombre=" + str + "&ini=" + ini + "&fini=" + fini,
			type : "GET",
			success : function(data){

				var energia = [];
				var DataDate = [];
				for(var i in data) {
					energia.push(data[i].Energia);
					DataDate.push(data[i].fecha);
				}
				var maximo=Math.max.apply(null,energia);
				var minimo=0;
				var step=(maximo-minimo)/5;


				var ctx2 = $("#myChart1");

				var myLineChart = new Chart(ctx2, {
				    type: 'line',
				    data: {
                labels: DataDate,
                datasets: [{
                    label: "Energía",
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderColor: "rgba(54, 162, 235, 0)",
					pointRadius: 0.1,
                    data: energia,
                    fill: 'origin',
					pointHoverBackgroundColor: "rgba(255,99,132,1)",
					cubicInterpolationMode: 'monotone',

                }]
            },
				    options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Consumo Energético'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
												showXLabels: 5,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Tiempo'
                        },
												ticks: {
														maxRotation: 0,
														minRotation: 0,
														fontColor: "#9a9ca5",
														fontStyle: "bold",
														maxTicksLimit: 5
												}
                    }],
                    yAxes: [{
                        display: true,
                  		position:"left",
						type: "linear",
                        scaleLabel: {
                            display: true,
                            labelString: 'Energía'
                        },
												ticks: {
													fontColor: "#9a9ca5",
													fontStyle: "bold",
													suggestedMin: 0,
													stepSize:step,															
														callback: function(label, index, labels) {
																			return label.toFixed(2)+' kWh';
														}
												}
                    }]
                }
            }
				});
			},error : function(data) {}
		});
	}


		function holanda2(){
			contraer2();
			var str = document.getElementById("oli2").value;
			str = str.replace(" ","_");
			console.log(str);
		$.ajax({
			url : "php/GraficoFinal2.php?nombre=" + str,
			type : "GET",
			success : function(data){

				var energia = [];
				var DataDate = [];
				for(var i in data) {
					energia.push(data[i].Energia);
					DataDate.push(data[i].fecha);
				}
				var maximo=Math.max.apply(null,energia);
				var minimo=0;
				var step=(maximo-minimo)/5;

				var ctx2 = $("#myChart2");

				var myLineChart = new Chart(ctx2, {
				    type: 'line',
				    data: {
                labels: DataDate,
                datasets: [{
                    label: "Energía",
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderColor: "rgba(54, 162, 235, 0)",
										pointRadius: 0.1,
                    data: energia,
                    fill: 'origin',
                }]
            },
				    options: {
                responsive: false,
                title:{
                    display:true,
                    text:'Consumo Energético'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
						showXLabels: 5,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Tiempo'
                        },
												ticks: {
														maxRotation: 0,
														minRotation: 0,
														fontColor: "#9a9ca5",
														fontStyle: "bold",
														maxTicksLimit: 20
												}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Energía'
                        },
												ticks: {
													fontColor: "#9a9ca5",
													fontStyle: "bold",
													suggestedMin: 0,
													stepSize:step,													
														callback: function(label, index, labels) {
																			return label.toFixed(2)+' kWh';
														}
												}
                    }]
                }
            }
				});
			},error : function(data) {
				console.log(data);
			}
		});
	}

			function holanda3(){
			contraer3();
			var str = document.getElementById("oli3").value;
			str = str.replace(" ","_");
			console.log(str);
		$.ajax({
			url : "php/GraficoFinal3.php?nombre=" + str,
			type : "GET",
			success : function(data){

				var energia = [];
				var DataDate = [];
				for(var i in data) {
					energia.push(data[i].Energia);
					DataDate.push(data[i].fecha);
				}
				var maximo=Math.max.apply(null,energia);
				var minimo=0;
				var step=(maximo-minimo)/5;

				var ctx2 = $("#myChart3");

				var myLineChart = new Chart(ctx2, {
				    type: 'line',
				    data: {
                labels: DataDate,
                datasets: [{
                    label: "Energía",
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderColor: "rgba(54, 162, 235, 0)",
										pointRadius: 0.1,
                    data: energia,
                    fill: 'origin',
                }]
            },
				    options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Consumo Energético'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
												showXLabels: 5,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Tiempo'
                        },
												ticks: {
														maxRotation: 0,
														minRotation: 0,
														fontColor: "#9a9ca5",
														fontStyle: "bold",
														maxTicksLimit: 5
												}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Energía'
                        },
												ticks: {
													fontColor: "#9a9ca5",
													fontStyle: "bold",
													suggestedMin: 0,
													stepSize:step,													
														callback: function(label, index, labels) {
																			return label.toFixed(2)+' kWh';
														}
												}
                    }]
                }
            }
				});
			},error : function(data) {
				console.log(data);
			}
		});
	}

		function holanda4(){
			contraer4();
			var str = document.getElementById("oli4").value;
			str = str.replace(" ","_");
			console.log(str);
		$.ajax({
			url : "php/GraficoFinal4.php?nombre=" + str,
			type : "GET",
			success : function(data){
				console.log(data);
				var energia = [];
				var DataDate = [];
				for(var i in data) {
					energia.push(data[i].Energia);
					DataDate.push(data[i].fecha);
				}
				var maximo=Math.max.apply(null,energia);
				var minimo=0;
				var step=(maximo-minimo)/5;

				var ctx2 = $("#myChart4");

				var myLineChart = new Chart(ctx2, {
				    type: 'bar',
				    data: {
                labels: DataDate,
                datasets: [{
                    label: "Energía",
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderColor: "rgba(54, 162, 235, 0)",
                    data: energia,
                }]
            },
				    options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Consumo Energético'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
												showXLabels: 5,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Mes'
                        },
												ticks: {
														maxRotation: 0,
														minRotation: 0,
														fontColor: "#9a9ca5",
														fontStyle: "bold",
														maxTicksLimit: 5
												}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Energía'
                        },
												ticks: {
													fontColor: "#9a9ca5",
													suggestedMin: 0,
													fontStyle: "bold",
													stepSize:step,
														callback: function(label, index, labels) {
																			return label.toFixed(2)+' kWh';
														}
												}
                    }]
                }
            }
				});
			},error : function(data) {
				console.log(data);
			}
		});
	}

				$.ajax({

  // Grafico polar para consumo por oficina
  url : "php/polar.php",
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
            "rgba(255, 0, 0, 0.5)",
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
    var ctx = document.getElementById("polar_1");
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
  },error : function(data) {

  	console.log(data);
  }
});

			function holanda7(){
			contraer7();
			var str = document.getElementById("oli7").value;
			str = str.replace(" ","_");
			console.log(str);

  $.ajax({

  // Grafico polar para dispositivos
  url : "php/GraficoFinal7.php?nombre=" + str,
  type : "GET",
  success : function(data){
    var porcentajes = [];
    var aparatos = [];
    var colores = [];
    for(var i in data) {
      porcentajes.push(data[i]['Energia']);
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
      aparatos[i] = data[i]['dispositivo'];
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
                aparatos[0]
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
    var ctx = $("#myChart7");
    window.myPolarArea = new Chart(ctx, config);

    j=1;
    for (var i = 1; i < porcentajes.length; i++) {
          if (config.data.datasets.length > 0) {
              config.data.labels.push(aparatos[i]);
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
  },error : function(data) {
  	console.log(data);
   }

});

 }

 function holanda8(){
	contraer8();
	// Creacion de formulario.
	var str = document.getElementById("oli8").value;
$.ajax({
	url : "php/GraficoFinal8.php?nombre=" +str,
	type : "GET",

	success : function(data) {
		console.log(data);
		//Adquisicion de datos.
		var Energia_act = [];
		var Energia_proy = [];
		var DataDate = [];
		for(var i in data) {
			Energia_act.push(data[i]['Energia_actual']);
			Energia_proy.push(data[i]['proyeccion']);
			DataDate.push(data[i]['fecha']);
		}	
		// Grafico de temperaturas por oficina
		var chartdata = {
			labels: DataDate,
			datasets: [
				{
					label: "Energía Actual",
					yAxisID:"Energia",
					fill: false,
					backgroundColor: "rgba(255,99,132,1)",
					borderColor: "rgba(255,99,132,1)",
					pointHoverBackgroundColor: "rgba(255,99,132,1)",
					cubicInterpolationMode: 'monotone',
					pointRadius: 0.2,
					pointHoverBorderColor: "rgba(255,99,132,1)",
					data: Energia_act
				},
				{
					label: "Proyección de Energía",
					yAxisID:"Energia",
					fill: false,
					backgroundColor: "rgba(54, 162, 235, 1)",
					borderColor: "rgba(54, 162, 235, 1)",
					pointRadius: 0.2,
					cubicInterpolationMode: 'monotone',
					pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
					pointHoverBorderColor: "rgba(54, 162, 235, 1)",
					data: Energia_proy
				}
			]
		};

		var ctx = $("#myChart8");
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
											maxRotation: 60,
											minRotation: 30,
											fontColor: "#9a9ca5",
											fontStyle: "bold",
											autoSkip: true,
											maxTicksLimit: 30
									}
							}],
							yAxes: [{
									position:"left",
									type: "linear",
									id:"Energia",
									ticks: {
											fontColor: "rgba(59, 89, 152, 0.75)",
											fontStyle: "bold",
											callback: function(label, index, labels) {

												return label.toFixed(2)+'kWh';
											}
									}
								},{
										position:"left",
										type: "linear",
										id:"Energia",
										ticks: {
												fontColor: "rgba(29, 202, 255, 0.75)",
												fontStyle: "bold",
												callback: function(label, index, labels) {
																	return label.toFixed(2)+'kWh';

												}
										}
							}]
					}
				}
		});
	},
	error : function(data) {
					console.log(data);
	} }); }

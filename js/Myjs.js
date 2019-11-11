function mail(){
  window.prompt("Dudas, consultas o sugerencias escribinos a:", "eficienciaenergeticauncuyo@gmail.com");
};
$(function() {
  AOS.init();
  $("#titu1").arctext({radius: 400});
  var i =0;
  var images = ['imagenes/Fondo1.jpg','imagenes/Fondo2.jpg','imagenes/Fondo3.jpg','imagenes/Fondo4.jpg','imagenes/Fondo5.jpg','imagenes/Fondo6.jpg','imagenes/Fondo7.jpg','imagenes/Fondo8.jpg','imagenes/Fondo9.jpg','imagenes/Fondo10.jpg','imagenes/Fondo11.jpg'];
  var image = $('#slideit');
                //Initial Background image setup
  image.css('background-image', 'url(imagenes/Fondo4.jpg)');
                //Change image at regular intervals
  setInterval(function(){
   image.fadeOut(250, function () {
   image.css('background-image', 'url(' + images [i++] +')');
   image.fadeIn(750);
   });
   if(i == images.length)
    i = 0;
  }, 15000);

  //smooth scroolling to anchors

  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      // Store hash
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }
  });

  //graficosssssss
 for (var i = 0; i < 8; i++) {
   if (i==0) {
     var ctx = document.getElementById("myChart1");
   }else if(i==1) {
     var ctx = document.getElementById("myChart2");
   }else if(i==2) {
     var ctx = document.getElementById("myChart3");
   }else if(i==3) {
     var ctx = document.getElementById("myChart4");
   }else if(i==4) {
     var ctx = document.getElementById("myChart5");
   }else if(i==5) {
     var ctx = document.getElementById("myChart6");
   }else if(i==6){
     var ctx = document.getElementById("myChart7");
   }
   else{
     var ctx = document.getElementById("myChart8");
   }
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["Esperando a recibir datos"],
          datasets: [{
              label: "¿Que desea ver?",
              data: [0],
              backgroundColor: [
                  'rgba(255,99,132,1)'
              ],
              borderColor: [
                  'rgba(255,99,132,1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });
};


  function range(start, stop, step){
  var a=[start], b=start;
  while(b<stop){b+=step;a.push(b)}
  return a;
};
});
function expand1() {
  document.getElementById("rango1").classList.add('expandido');
  document.getElementById("rango1").classList.remove('circular');
};
function contraer1() {
  document.getElementById("rango1").classList.remove('expandido');
  document.getElementById("rango1").classList.add('circular');
}
function expand2() {
  document.getElementById("rango2").classList.add('expandido');
  document.getElementById("rango2").classList.remove('circular');
};
function contraer2() {
  document.getElementById("rango2").classList.remove('expandido');
  document.getElementById("rango2").classList.add('circular');
}
function expand3() {
  document.getElementById("rango3").classList.add('expandido');
  document.getElementById("rango3").classList.remove('circular');
};
function contraer3() {
  document.getElementById("rango3").classList.remove('expandido');
  document.getElementById("rango3").classList.add('circular');
}
function expand4() {
  document.getElementById("rango4").classList.add('expandido');
  document.getElementById("rango4").classList.remove('circular');
};
function contraer4() {
  document.getElementById("rango4").classList.remove('expandido');
  document.getElementById("rango4").classList.add('circular');
}
function expand5() {
  document.getElementById("rango5").classList.add('expandido');
  document.getElementById("rango5").classList.remove('circular');
};
function contraer5() {
  document.getElementById("rango5").classList.remove('expandido');
  document.getElementById("rango5").classList.add('circular');
}
function expand6() {
  document.getElementById("rango6").classList.add('expandido');
  document.getElementById("rango6").classList.remove('circular');
};
function contraer6() {
  document.getElementById("rango6").classList.remove('expandido');
  document.getElementById("rango6").classList.add('circular');
}
function expand7() {
  document.getElementById("rango7").classList.add('expandido');
  document.getElementById("rango7").classList.remove('circular');
};
function contraer7() {
  document.getElementById("rango7").classList.remove('expandido');
  document.getElementById("rango7").classList.add('circular');
}
function expand8() {
  document.getElementById("rango8").classList.add('expandido');
  document.getElementById("rango8").classList.remove('circular');
};
function contraer8() {
  document.getElementById("rango8").classList.remove('expandido');
  document.getElementById("rango8").classList.add('circular');
}
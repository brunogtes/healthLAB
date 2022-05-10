demo = {
  initPickColor: function () {
    $('.pick-class-label').click(function () {
      var new_class = $(this).attr('new-class');
      var old_class = $('#display-buttons').attr('data-class');
      var display_div = $('#display-buttons');
      if (display_div.length) {
        var display_buttons = display_div.find('.btn');
        display_buttons.removeClass(old_class);
        display_buttons.addClass(new_class);
        display_div.attr('data-class', new_class);
      }
    });
  },

  initDashboardPageCharts: function () {

    //Usuarios
    var ctxD = document.getElementById("doughnutChart").getContext('2d');
    var usuariosAtivos = $('#usuariosAtivos').val();
    var usuariosInativos = $('#usuariosInativos').val();

    var myLineChart = new Chart(ctxD, {
      type: 'doughnut',
      data: {
        labels: ["Ativos", "Inativos"],
        datasets: [{
          data: [usuariosAtivos, usuariosInativos],
          backgroundColor: ["#46BFBD", "#949FB1"],
          hoverBackgroundColor: ["#46BFBD", "#949FB1"]
        }]
      },
      options: {
        responsive: true
      }
    });

    //Exames
    var ctxD = document.getElementById("doughnutChartExames").getContext('2d');
    var ExamesAtivos = $('#ExamesAtivos').val();
    var ExamesInativos = $('#ExamesInativos').val();


    var myLineChart = new Chart(ctxD, {
      type: 'doughnut',
      data: {
        labels: ["Ativos", "Inativos"],
        datasets: [{
          data: [ExamesAtivos, ExamesInativos],
          backgroundColor: ["#00BFFF", "#949FB1"],
          hoverBackgroundColor: ["#00BFFF", "#949FB1"]
        }]
      },
      options: {
        responsive: true
      }
    });

    //Convênios
    var ctxD = document.getElementById("doughnutChartConvenios").getContext('2d');
    var ConveniosAtivo = $('#ConveniosAtivo').val();
    var ConveniosInativos = $('#ConveniosInativos').val();


    var myLineChart = new Chart(ctxD, {
      type: 'doughnut',
      data: {
        labels: ["Ativos", "Inativos"],
        datasets: [{
          data: [ConveniosAtivo, ConveniosInativos],
          backgroundColor: ["#084B8A", "#949FB1"],
          hoverBackgroundColor: ["#084B8A", "#949FB1"]
        }]
      },
      options: {
        responsive: true
      }
    });

    //Quantidade de Exames - Mensal
    var ctxB = document.getElementById("barChart").getContext('2d');

    var qtdMes1 = $('#qtdMes1').val();
    var qtdMes2 = $('#qtdMes2').val();
    var qtdMes3 = $('#qtdMes3').val();
    var qtdMes4 = $('#qtdMes4').val();
    var qtdMes5 = $('#qtdMes5').val();
    var qtdMes6 = $('#qtdMes6').val();
    var qtdMes7 = $('#qtdMes7').val();
    var qtdMes8 = $('#qtdMes8').val();
    var qtdMes9 = $('#qtdMes9').val();
    var qtdMes10 = $('#qtdMes10').val();
    var qtdMes11 = $('#qtdMes11').val();
    var qtdMes12 = $('#qtdMes12').val();

    gradientFill = ctxB.createLinearGradient(0, 170, 0, 50);
    gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
    gradientFill.addColorStop(1, hexToRGB('#2CA8FF', 0.6));

    var myBarChart = new Chart(ctxB, {
      type: 'bar',
      data: {
        labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        datasets: [{
          label: "Exames",
          backgroundColor: gradientFill,
          borderColor: "#2CA8FF",
          pointBorderColor: "#FFF",
          pointBackgroundColor: "#2CA8FF",
          pointBorderWidth: 2,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 1,
          pointRadius: 4,
          fill: true,
          borderWidth: 1,
          data: [qtdMes1, qtdMes2, qtdMes3, qtdMes4, qtdMes5, qtdMes6, qtdMes7, qtdMes8, qtdMes9, qtdMes10, qtdMes11, qtdMes12]
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        tooltips: {
          bodySpacing: 4,
          mode: "nearest",
          intersect: 0,
          position: "nearest",
          xPadding: 10,
          yPadding: 10,
          caretPadding: 10
        },
        responsive: 1,
        scales: {
          yAxes: [{
            gridLines: 0,
            gridLines: {
              zeroLineColor: "transparent",
              drawBorder: false
            }
          }],
          xAxes: [{
            display: 0,
            gridLines: 0,
            ticks: {
              display: false
            },
            gridLines: {
              zeroLineColor: "transparent",
              drawTicks: false,
              display: false,
              drawBorder: false
            }
          }]
        },
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 15,
            bottom: 15
          }
        }
      }
    });


    //Status de Exames
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var aguardandoColeta = $('#aguardandoColeta').val();
    var aguardandoResultado = $('#aguardandoResultado').val();
    var exameFinalizado = $('#exameFinalizado').val();
    var exameCancelado = $('#exameCancelado').val();

    var myPieChart = new Chart(ctxP, {
      type: 'pie',
      data: {
        labels: ["Cancelados", "Finalizados", "Aguardando Resultado", "Aguardando Coleta"],
        datasets: [{
          data: [exameCancelado, exameFinalizado, aguardandoResultado, aguardandoColeta],
          backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1"],
          hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
        }]
      },
      options: {
        responsive: true
      }
    });

    //Quantidade de Coletas - Mensal

    var qtdColetaMes1 = $('#qtdColetaMes1').val();
    var qtdColetaMes2 = $('#qtdColetaMes2').val();
    var qtdColetaMes3 = $('#qtdColetaMes3').val();
    var qtdColetaMes4 = $('#qtdColetaMes4').val();
    var qtdColetaMes5 = $('#qtdColetaMes5').val();
    var qtdColetaMes6 = $('#qtdColetaMes6').val();
    var qtdColetaMes7 = $('#qtdColetaMes7').val();
    var qtdColetaMes8 = $('#qtdColetaMes8').val();
    var qtdColetaMes9 = $('#qtdColetaMes9').val();
    var qtdColetaMes10 = $('#qtdColetaMes10').val();
    var qtdColetaMes11 = $('#qtdColetaMes11').val();
    var qtdColetaMes12 = $('#qtdColetaMes12').val();


    new Chart(document.getElementById("horizontalBar"), {
      "type": "horizontalBar",
      "data": {
        "labels": ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        "datasets": [{
          "label": "healthLAB",
          "data": [qtdColetaMes1, qtdColetaMes2, qtdColetaMes3, qtdColetaMes4, qtdColetaMes5, qtdColetaMes6, qtdColetaMes7, qtdColetaMes8, qtdColetaMes9, qtdColetaMes10, qtdColetaMes11, qtdColetaMes12],
          "fill": false,
          "backgroundColor": ["rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)","rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)","rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)","rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)","rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)",
            
            
          ],
          "borderColor": ["rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(75, 192, 192)", "rgb(54, 162, 235)","rgb(75, 192, 192)", "rgb(54, 162, 235)","rgb(75, 192, 192)", "rgb(54, 162, 235)","rgb(75, 192, 192)", "rgb(54, 162, 235)","rgb(75, 192, 192)", "rgb(54, 162, 235)", 
          ],
          "borderWidth": 1
        }]
      },
      "options": {
        "scales": {
          "xAxes": [{
            "ticks": {
              "beginAtZero": true
            }
          }]
        }
      }
    });



  }
}
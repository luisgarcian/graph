
$(function () {
   
  $.ajax({
    url: "ventasnetas.php",
    type: "GET",
    async: true,
    contentType: "text/json; charset=utf-8",
    dataFormat : "jason",       
    success: function(datos) { 
      CreaChart(datos) 
    },
    error: function(jqXmlHttpRequest, textStatus, errorThrown) { 
    }
  });

  function CreaChart(datos) {
    
    const dataSource = {
      chart: {
        caption: "VENTAS NETAS",
        subcaption: "POR SUCURSAL",
        xAxisName: "SUCURSALES",
        yAxisName: "PESOS",
        pYAxisName: "Ventas Netas (Pesos)",
        sYAxisName: "Unidades Venta",
        yAxisMinValue: "1000",
        yAxisMaxValue: "4000000",
        xAxisNameFont: "Arial",
        xAxisNameFontSize: "12",
        xAxisNameFontColor: "#993600",
        xAxisNameFontBold: "1",
        yAxisValueBgColor: "#ff0000",
        yAxisValueBgAlpha: "40",
        theme: "zune"
      },
      data:datos
    };

    var salesRevChart = new FusionCharts({
      type: "Line",
      renderAt: "chart-container",
      width: "600",
      height: "400",
      dataFormat: "json",
      dataSource
    }).render();

  };
    
});

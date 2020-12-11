
$(function () {
   
  $.ajax({
    url: "http://localhost/graph/data3.php",
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
        caption: "Top Ventas",
        xaxisname: "Vendedores",
        yaxisname: "Pesos",
        theme: "management"
      },
      data:datos
    };

    var salesRevChart = new FusionCharts({
      type: "Bar3d",
      renderAt: "chart-container",
      width: "800",
      height: "800",
      dataFormat: "json",
      dataSource
    }).render();

  };
    
});

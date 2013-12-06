var chart; // globally available

Highcharts.visualize = function(table, options) {
   // the categories
   options.xAxis.categories = [];
   $('tbody th', table).each( function(i) {
      options.xAxis.categories.push(this.innerHTML);
   });
   
   // the data series
   options.series = [];
   $('tr', table).each( function(i) {
      var tr = this;
      $('th, td', tr).each( function(j) {
         if (j > 0) { // skip first column
            if (i == 0) { // get the name and init the series
               options.series[j - 1] = { 
                  name: this.innerHTML,
                  data: []
               };
            } else { // add values
               options.series[j - 1].data.push(parseFloat(this.innerHTML));
            }
         }
      });
   });
   
   var chart = new Highcharts.Chart(options);
}

$(document).ready(function(){    
    var table = document.getElementById('datatable'),
       options = {
         chart: {
            renderTo: 'chart',
            defaultSeriesType: 'column',
            height: 300,
            width: 780,
            spacing: 0,
            margin: 0,
            marginBottom: 25,
            backgroundColor: ''
         },
         title: { text: '' },
         xAxis: {
             labels: { enabled: false },
             lineWidth: 3,
             lineColor: '#838383'
         },
         yAxis: {
            title: { text: '' },
            opposite: true,
            labels: {
                align: 'right',
                x: -6,
                y: 15,
                formatter: function(){
                    return this.value;
                },
                style: {
                    fontFamily: '"Helvetica Neue", Arial, Helvetica, sans-serif',
                    fontSize: '10px',
                    fontWeight: '300',
                    color: '#777'
                }
            }
         },
         tooltip: {
            formatter: function() {
               return '<strong>'+ this.x +':</strong> ' + this.y;
            }
         }
      };
   
                     
   Highcharts.visualize(table, options);
   
   $('g.highcharts-grid path:last-child').remove();
});
var chartOverall;

$(document).ready(function(){
	$('.widget').each(widget);
	
	var data = [77, 90, 51, 43, 44, 80, 1, 100, 29, 34, 10, 68, 73, 51, 54, 26, 19, 65, 73, 83, 69, 66, 39, 68, 73, 70, 20, 98, 1, 19];
	var dataMax = 0;
	
	for(i=0; i<data.length; i++){
    	if(data[i] > dataMax) dataMax = data[i];
    }
	
    chartOverall = new Highcharts.Chart({
        chart: {
            renderTo: 'overall-chart',
            type: 'area',
            spacingTop: 0,
            spacingRight: 1,
            spacingBottom: 10,
            spacingLeft: 0,
            width: 890
        },
        
        title: { text: '' },
        credits: { enabled: false }, 
        legend: { enabled: false },
        
        plotOptions: {
        	area: {
        		fillOpacity: .2,
        		lineWidth: 2,
        		
        		states: {
        			hover: { lineWidth: 2 }
        		}
        	},
        	
        	series: {
        		marker: {
        			lineWidth: 1.5,
        			radius: 4,
        			
        			states: {
        				hover: {
        					lineWidth: 2,
        					radius: 5
        				}
        			}
        		}
        	}
        },
        
        tooltip: {
        	backgroundColor: 'rgba(0,0,0,.8)',
        	borderWidth: 1,
        	borderColor: 'black',
        	borderRadius: 4,
        	xDateFormat: '%b %e',
        	xDateFormat: '%b %e',
        	pointFormat: '<b>{point.y} Actions</b>',
        	shadow: false,
        	style: {
        		color: 'white',
        		lineHeight: 1.4
        	}
        },
        
        yAxis: {
        	title: { text: '' },
        	labels: { enabled: false },
        	gridLineColor: '#e1e1e1',
        	lineWidth: 1,
        	lineColor: '#e1e1e1',
        	tickInterval: (dataMax * .5) + 25,
        	max: dataMax + 50
        },
        
        xAxis: {
        	type: 'datetime',
        	dateTimeLabelFormats: {
        		day: '%b %e'
        	},
        	minPadding: 0,
            maxPadding: 0,
            showFirstLabel: true,
            tickWidth: 0,
            lineWidth: 1,
            lineColor: '#e1e1e1',
            labels: {
            	style: {
            		fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif', 
            		fontSize: '10px',
            		color: '#414141'
            	}
            },
            plotLines: [{
                color: '#e1e1e1',
                width: 1,
                value: Date.UTC(2012, 1, 26)
            }]
        },
        
        series: [{
        	data: data,
        	pointStart: Date.UTC(2012, 0, 28),
        	pointInterval: 24 * 3600 * 1000,
        	color: '#00b2cd',
        	shadow: false
        }]
    });
    
    
    
});




function widget(){
	var widget, chart, data, listData, slOptions, max;
	
	widget = $(this);
	chart = $('.inlinebar', widget);
	data = {};
	data.default = chart.attr('data').split(',');
	data.breakout = [];
	max = 0;
	
	$('.controls .col:has(.subset)', widget).each(function(){
		var num = $(this).index();
		var dataSet = $('a', this).attr('data');
		data.breakout[num] = dataSet.split(',');
		
		var add = data.breakout[num];
		$('span.num', this).text(add[add.length - 1]);
	});
	
	for(var k in data.default){
		if (data.default[k] > max) max = data.default[k];
	}
	
	max = Math.ceil(max / 10) * 10;
	
	slOptions = {
		type: 'bar',
		height: '30px',
		width: '100%',
		barColor: '#cacaca',
		zeroColor: 'white',
		barWidth: 7,
		barSpacing: 1,
		chartRangeMin: 0,
		chartRangeMax: max
	}
	
	updateChart(data.default.join());
	
	$('.controls a.subset', widget).click(function(e){
		e.preventDefault();
		
		$(this).add('.controls .active', widget).toggleClass('active');
		updateData();
	});
	
	function updateData(){
		if($('.controls .active', widget).size() > 0){
			var num = $('.controls .active', widget).closest('.col').index();
			updateChart(data.breakout[num].join());
			
		} else { updateChart(data.default.join()); }
	}
	
	function updateChart(data){
		chart.html(data);
		chart.sparkline('html', slOptions);
	}
}



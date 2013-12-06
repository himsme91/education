Highcharts.theme = {
    colors: [
        '#74e0ba',
        '#e0e67b',
        '#ba4e1f',
        '#735600',
        '#36212f',
        '#377ca0',
        '#74e0ba',
        '#e0e67b',
        '#ba4e1f',
        '#735600',
        '#36212f',
        '#377ca0',
        '#74e0ba',
        '#e0e67b',
        '#ba4e1f',
        '#735600',
        '#36212f',
        '#377ca0',
        '#74e0ba',
        '#e0e67b',
        '#ba4e1f',
        '#735600',
        '#36212f',
        '#377ca0',
        '#74e0ba',
        '#e0e67b',
        '#ba4e1f',
        '#735600',
        '#36212f'
    ],
    
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        style: {
            fontFamily: '"Helvetica Neue", Arial, Helvetica, sans-serif',
            fontSize: '10px',
            fontWeight: '300',
            color: '#333'
        }
    },
    
    title: {
        style: {
            fontFamily: '"Helvetica Neue", Arial, Helvetica, sans-serif',
            fontSize: '16px',
            fontWeight: '300',
            color: '#333'
        }
    },
    
    tooltip: {
        style: {
            fontFamily: '"Helvetica Neue", Arial, Helvetica, sans-serif',
            fontSize: '10px',
            fontWeight: '300',
            color: '#333'
        },
        snap: 50
    },
    
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            borderWidth: 0.75,
            showCheckbox: false,
            dataLabels: {
                enabled: true,
                color: '#4e4e4e',
                connectorColor: '#cbcbcb',
                style: {
                    fontFamily: '"Helvetica Neue", Arial, Helvetica, sans-serif',
                    fontSize: '9px',
                    fontWeight: '300',
                    color: '#333'
                }
            },
            slicedOffset: 0,
            size: '240'
        },
        column: {
            borderWidth: 0,
            cursor: 'default',
            minPointLength: 5,
            pointWidth: 20,
            colorByPoint: true,
            pointPadding: 0
        }
    },
    
    credits: {
        enabled: false
    },
    
    xAxis: {
        lineWidth: 1,
        lineColor: '#f1f1f1',
        tickmarkPlacement: 'on',
        tickLength: 0,
        startOnTick: false,
        endOnTick: false
    },
    
    yAxis: {
        gridLineColor: 'rgba(0,0,0,.1)',
        lineWidth: 0,
        showFirstLabel: false,
        lineColor: '#f1f1f1'
    },
    
    legend: {
        enabled: false
    }
};

var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
Highcharts.theme = {
    chart: {
        backgroundColor: null,
        spacingRight: 0,
        spacingLeft: 0,
        spacingBottom: 10,
        spacingTop: 0
    },
    credits: { enabled: false },
    legend: { enabled: false },
    colors: [
        '#199cc9',
        '#8cc544'
    ],
    xAxis: {
        gridLineWidth: 1,
        gridLineColor: 'rgba(0,0,0,.05)',
        lineColor: '#3b3b3b',
        tickLength: 0,
        labels: {
            style: {
                fontSize: '9px',
                fontFamily: '"Helvetica Neue", Arial, sans-serif',
                fontWeight: '600',
                color: '#FFF',
                textShadow: '0 -1px #000',
                lineHeight: '14px'
            }
        }
    },
    yAxis: {
        gridLineColor: "rgba(0,0,0,.05)",
        tickPixelInterval: 27,
        labels: { enabled: false }
    },
    plotOptions: {
        areaspline: {
            color: '#717171',
            fillOpacity: .2,
            shadow: false,
            lineWidth: 3,
            marker: {
                fillColor: '#FFFFFF',
                lineWidth: 3,
                lineColor: null
            },
            states: {
                hover: {
                    lineWidth: 3,
                    marker: {
                        raduis: 2
                    }
                }
            }
        },
        column: {
            shadow: false,
            pointWidth: 12,
            pointPadding: -1,
            borderWidth: 1,
            borderColor: 'rgba(0,0,0,.2)'
        }
    },
    tooltip: {
        backgroundColor: null,
        shadow: false,
        borderWidth: 0
    }
};

var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
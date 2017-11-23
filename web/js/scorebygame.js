function graphScoreByGame(data) {
    Highcharts.chart('scorebygame', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Score par partie'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: null
            }
        },
        tooltip: {
            pointFormat: '{point.y:.2f} pts'
        },

        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },
        series: data
    });
}
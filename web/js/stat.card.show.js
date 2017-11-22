$(document).ready(function(){
    $.ajax({
        url: '/card/get/stat/'+$('#id_carte').val(),
        method: 'POST',
        dataType: 'json',
        success : function(data){
            var data_stat = [];
            for(var item in data){
                if(data.hasOwnProperty(item)){
                    var key = [];
                    var date = new Date(data[item]['playedAt'].date);
                    key.push(date.getTime());
                    key.push(data[item]['result']);
                    data_stat.push(key);
                }
            }
            Highcharts.chart('containerHighcharts', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Score'
                },
                subtitle: {
                    text: 'Score par partie'
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
                        text: 'Points'
                    },
                    min: 0
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y:.2f} pts'
                },

                plotOptions: {
                    spline: {
                        marker: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    data: data_stat
                }]
            });
        }
    });
});
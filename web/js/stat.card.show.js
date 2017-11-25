$(document).ready(function(){
    Highcharts.setOptions({
        chart: {
            style: {
                fontFamily: 'Roboto',
                backgroundColor: '#FCFFC5'
            }
        }
    });
    $.ajax({
        url: '/card/get/scorebygame/'+$('#id_carte').val(),
        method: 'POST',
        dataType: 'json',
        success : function(obj){
            var data_scorebygame = [];
            for(var item in obj){
                if(obj.hasOwnProperty(item)){
                    var key = {};
                    var data = [];
                    for(var item_ in obj[item]){
                        if(obj[item].hasOwnProperty(item_)){
                            var date = new Date(obj[item][item_]['playedAt'].date);
                            data.push([date.getTime(), obj[item][item_]['result']]);
                        }
                    }
                    key = {
                        'name' : item,
                        'data' : data
                    };
                    data_scorebygame.push(key);
                }
            }
            graphScoreByGame(data_scorebygame);
        }
    });
    $.ajax({
        url: '/card/get/typepartie/'+$('#id_carte').val(),
        method: 'POST',
        dataType: 'json',
        success : function(obj){
            var data_typepartie = [];
            for(var item in obj){
                if(obj.hasOwnProperty(item)) {
                    var key = {
                        'name' : item,
                        'y' : parseFloat(obj[item])
                    };
                    data_typepartie.push(key)
                }
            }
            graphTypePartie(data_typepartie);
        }
    });

    Highcharts.chart('winlose', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Victoires / Défaites'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['Team', 'FFA', 'Dracula']
        },
        yAxis: {
            title: {
                text: null
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
        series: [{
            color: '#4caf50',
            name: 'Victoires',
            data: [5, 3, 4]
        }, {
            color: '#f44336',
            name: 'Défaites',
            data: [2, 2, 3]
        }]
    });
});
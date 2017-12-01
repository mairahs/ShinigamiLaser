$(document).ready(function(){
    $('.modal').modal();
    $('.modal-trigger').click(function(){
        var data_game_id = $(this).attr('data-game-id');
        $('.ui-linkjoin').each(function () {
            var data_card_id = $(this).attr('data-card-id');
            $(this).attr('href', 'game/join/dash/'+data_game_id+'/'+data_card_id)
        })
    });
});
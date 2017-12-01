$(document).ready(function(){
    $('.modal').modal();
    $('ul.tabs').tabs();
    $('.modal-trigger').click(function(){
        var data_game_id = $(this).attr('data-game-id');
        $('.ui-linkjoin').each(function () {
            var data_card_id = $(this).attr('data-card-id');
            $(this).attr('href', 'join/game/'+data_game_id+'/'+data_card_id)
        })
    });

    $('#add_player_card').click(function(){
        var data_game_id = $(this).attr('data-game-id');
        addPlayerCard(data_game_id);
        return false;
    });
});
function addPlayerCard(data_game_id) {
    var input_card_number = $('#appbundle_card_number')
    $.ajax({
        url: '/game/add/player/card/'+data_game_id+'/'+input_card_number.val(),
        method: 'POST',
        dataType: 'json',
        success : function(obj){
            if(obj.status == "OK"){
                window.location.href = obj.retour;
            }else{
                var msg_error = "<ul><li class='error'>"+obj.retour+"</li></ul>";
                input_card_number.parents('.input-field').find('ul').remove();
                input_card_number.parents('.input-field').append(msg_error);
                input_card_number.parents('.row').addClass('has-error')
            }
        }
    });
}
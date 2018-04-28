$(function() {
    $('.game-listener').on('click', function() {
        update_game(this.id);
    });
});

function update_game(click) {
    $.ajax({
        type: 'POST',
        url: 'game_load.php',
        data: {
            clicked_item: click
        },
        dataType: 'HTML',
        success: function(data) {
            $('#game-table').html(data);
            $('.game-listener').click(function() {
                update_game(this.id);
            });
        }
    });
}
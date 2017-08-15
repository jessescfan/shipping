(function() {
    var $collection_holder;
    var $add_participant_btn = $('.add-participant');
    var $new_participant_list = $('.participants-list');
    var $user_list = $('#user-list');
    var form_index = $new_participant_list.find('input').length;
    var user = {};
    var group = [];

    $user_list.find('tr').each(function(key, value){
        user['id'] = $(value).data('id');
        user['name'] = $(value).data('name');
        group.push(user);
    });

    $(document).ready(function() {
        $collection_holder = $('#bet_participants');
        var prototype = $collection_holder.data('prototype');
        $add_participant_btn.on('click', function(e) {
            e.preventDefault();
            var $user_list_item = $(this).closest('.user-list-item');
            $user_list_item.hide();
            var participant_id = $user_list_item.data('id');
            var new_form = prototype.replace(/__name__/g, form_index);
            var $new_form = $(new_form).find('[name*=user_id]').val(participant_id);
            var form_name = $user_list_item.data('name');
            var new_row = '<tr class="cur-participant"><td>'+ $new_form[0].outerHTML
                + form_name + '</td><td><button type="button" class="btn btn-sm  btn-warning">' +
                '<i class="glyphicon glyphicon-remove"></i> Remove</button></td></tr>';
            $new_participant_list.append(new_row);
            form_index ++;
            $('.cur-participant button').click(function(){
                var $cur_participant = $(this).closest('.cur-participant');
                var user_id = $cur_participant.find('[name*=user_id]').val();
                $cur_participant.remove();
                $user_list.find("[data-id='" + user_id + "']").closest('.user-list-item').show();
            })
        });
    });

    $('.cur-participant button').click(function(){
        var $cur_participant = $(this).closest('.cur-participant');
        var user_id = $cur_participant.find('input').val();
        $cur_participant.remove();
        $user_list.find("[data-id='" + user_id + "']").closest('.user-list-item').show();
    })
})();
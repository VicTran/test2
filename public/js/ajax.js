$(document).ready(function () {
    var url= "/user";
    console.log('tung');
    $('.delete-task').click(function () {
        var user_id = $(this).val();
        console.log(user_id);

        $.ajax({

            type: "POST",
            url: '/test',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data: {
                user_id : user_id
            },
            success: function (data) {
                if(data) {
                    console.log(data);
                    $("#user" + user_id).remove();
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
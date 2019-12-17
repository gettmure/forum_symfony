$(document).ready(function () {
    $('#send-message-form').submit(function() {
        let username = $('#username').val();
        let category = $('#category').val();
        let messageText = $('#message').val();
        $.ajax({
            type: 'GET',
            url: "new/send",
            data:  {
                name: username,
                category_name: category,
                text: messageText,
            },
            success: function (response) {
                if (typeof response.status != "undefined" && response.status != "undefined")
                {
                    if (response.status == "OK")
                    {
                        if (typeof response.user_id != "undefined" && response.user_id != "undefined" &&
                            typeof response.category_id != "undefined" && response.category_id != "undefined")
                        {
                            alert('Message has been successfuly added!');
                            location.href = '/';
                        }
                    }
                }
            },
            error: function () {
                alert('ERROR');
            }
        });
        return false;
    });
});
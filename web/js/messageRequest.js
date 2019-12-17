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
                    // At this point we know that the status is defined,
                    // so we need to check for its value ("OK" in my case)
                    if (response.status == "OK")
                    {
                        // At this point we know that the server response
                        // is what we were expecting,
                        // so retrive the response and use if

                        if (typeof response.user_id != "undefined" && response.user_id != "undefined" &&
                            typeof response.category_id != "undefined" && response.category_id != "undefined")
                        {
                            alert('OK');
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